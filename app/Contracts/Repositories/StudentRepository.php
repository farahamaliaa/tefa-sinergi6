<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\StudentInterface;
use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Http\Request;

class StudentRepository extends BaseRepository implements StudentInterface
{
    public function __construct(Student $student)
    {
        $this->model = $student;
    }

    public function get(): mixed
    {
        return $this->model->query()->get();
    }

    public function whereUserId(mixed $id): mixed
    {
        return $this->model->query()->where('user_id', $id)->first();
    }

    public function store(array $data): mixed
    {
        return $this->model->query()->create($data);
    }

    public function show(mixed $id): mixed
    {
        return $this->model->query()->findOrFail($id);
    }

    public function update(mixed $id, array $data): mixed
    {
        return $this->model->query()->findOrFail($id)->update($data);
    }

    public function delete(mixed $id): mixed
    {
        return $this->model->query()->findOrFail($id)->delete();
    }

    public function paginate() : mixed
    {
        return $this->model->query()->latest()->paginate(10);
    }

    public function count(): mixed
    {
        return $this->model->query()->count();
    }

    public function orderByPoint(): mixed
    {
        return $this->model->query()->where('point', '!=', 0)->orderBy('point', 'desc')->take(5)->get();
    }

    public function search(Request $request): mixed
    {
        return $this->model->query()
            ->when($request->name, function ($query) use ($request) {
                $query->whereHas('user', function($q) use ($request) {
                    $q->where('name', 'LIKE', '%' .  $request->name . '%');
                });
            })
            ->when($request->gender, function ($query) use ($request) {
                $query->where('gender', $request->gender);
            })
            ->whereDoesntHave('memberships', function ($mq) {
                $mq->where('memberable_type', Classroom::class)
                ->whereHasMorph('memberable', [Classroom::class], function ($cq) {
                    $cq->whereHas('levelClass', fn($lq) =>
                        $lq->where('name', 'Alumni')
                    );
                });
            })
            ->when($request->class, function ($q) use ($request) {
                $q->whereHas('memberships', function ($mq) use ($request) {
                    $mq->where('memberable_type', Classroom::class)
                    ->whereHasMorph('memberable', [Classroom::class], function ($cq) use ($request) {
                        $cq->where('name', 'LIKE', '%'.$request->class.'%');
                    });
                });
            })
            ->latest()
            ->paginate(10);
    }


    public function doesntHaveClassroom(Request $request): mixed
    {
        return $this->model->query()
        ->with('user')
        ->whereDoesntHave('memberships', function ($mq) {
            $mq->where('memberable_type', Classroom::class);
        })
        ->when($request->name, function ($query) use ($request) {
            $query->whereHas('user', function($q) use ($request){
                $q->where('name', 'LIKE', '%' .  $request->name . '%');
            });
        })
        ->get();
    }

    public function countStudentAlumni(): mixed
    {
        return $this->model->query()
            ->whereHas('memberships', function ($mq) {
                $mq->where('memberable_type', Classroom::class)
                ->whereHasMorph('memberable', [Classroom::class], function ($sq) {
                    $sq->whereHas('levelClass', fn($lq) => $lq->where('name', 'Alumni'));
                });
            })
            ->count();
    }

    public function getByPoint(Request $request): mixed
    {
        return $this->model->query()
            ->when($request->search_student, function($query) use ($request){
                $query->when($request->search_student, function($q) use($request){
                    $q->whereRelation('user', 'name', 'LIKE', '%' . $request->search_student . '%');
                });
            })
            ->where('point' , '>', 0)
            ->when($request->point_student, function($q) use($request) {
                if ($request->point_student == 'highest') {
                    $q->orderBy('point', 'desc');
                } elseif ($request->point_student == 'lowest') {
                    $q->orderBy('point', 'asc');
                }
            })
            ->paginate(10);
    }

    public function whereClassroomStudent(mixed $id): mixed
    {
        return $this->model->query()
            ->whereHas('memberships', function ($q) use ($id) {
                $q->where('memberable_type', Classroom::class)
                ->where('memberable_id', $id);
            })
            ->first();
    }

    public function highestPoint(mixed $query): mixed
    {
        return $this->model->query()
            ->where('point', '>', $query)
            ->count();
    }

    public function getByApi(Request $request): mixed
    {
        return $this->model->query()
            ->when($request->search, function($query) use ($request){
                $query->when($request->search, function($q) use($request){
                    $q->whereRelation('user', 'name', 'LIKE', '%' . $request->search . '%');
                });
            })
            ->where('point', '!=', 0)
            ->orderBy('point', 'desc')
            ->get();
    }
}
