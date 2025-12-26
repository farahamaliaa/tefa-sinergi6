<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExtracurricularRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:extracurriculars,name',
            'user_id' => 'required|exists:users,id',
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama harus diisi.',
            'name.unique' => 'Ekstrakurikuler sudah ditambahkan.',
            'user_id.required' => 'Pengajar harus diisi.',
            'user_id.exists' => 'Pengajar tidak valid.',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        session()->flash('showCreateModal', true);
        throw new \Illuminate\Validation\ValidationException($validator, redirect()->back()->withInput()->withErrors($validator, 'create'));
    }
}
