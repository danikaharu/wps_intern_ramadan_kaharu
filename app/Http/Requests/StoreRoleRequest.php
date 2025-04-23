<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
            'name' => 'required|min:2|max:30|unique:roles,name',
            'permissions' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Role wajib diisi',
            'name.min' => 'Role minimal 2 huruf',
            'name.max' => 'Role maksimal 30 huruf',
            'name.unique' => 'Role sudah terdaftar',
            'permissions.required' => 'List akses wajib dipilih',
        ];
    }
}
