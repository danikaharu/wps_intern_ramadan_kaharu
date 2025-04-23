<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreActivityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'user_id' => Auth::user()->id,
            'status' => 0
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['exists:users,id'],
            'activity' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'photo' => ['required', 'mimes:jpg,jpeg,png', 'max:5000'],
            'status' => ['in:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.exists' => 'Pegawai tidak terdaftar',
            'activity.required' => 'Nama Kegiatan wajib diisi',
            'activity.max' => 'Nama Kegiatan maksimal 255 kata',
            'date.required' => 'Tanggal Kegiatan wajib diisi',
            'date.date' => 'Tanggal Kegiatan tidak sesuai format',
            'photo.required' => 'Foto Kegiatan wajib upload',
            'photo.mimes' => 'Foto Kegiatan tidak sesuai format',
            'photo.max' => 'Foto Kegiatan maksimal 5 MB',
        ];
    }
}
