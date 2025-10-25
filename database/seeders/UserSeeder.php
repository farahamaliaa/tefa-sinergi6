<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Role::all() as $role) {
            $user = User::query()
                ->create([
                    'name' => $role['name'],
                    'slug' => Str::slug($role['name']),
                    'email' => str_replace(' ', '', $role['name']) . "@gmail.com",
                    'email_verified_at' => now(),
                    'password' => bcrypt('password'),
                    'role' => $role['name'],
                ]);

            $user->assignRole($role);
            if ($role['name'] == 'staff') {
              $permission = Permission::firstOrCreate([
                'name' => 'view_violation',
                'guard_name' => 'web',
              ]);
                $user->givePermissionTo('view_violation');
            }

        }
    }
}
