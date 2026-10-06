<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KegiatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'target_peserta' => 'nullable|string|max:255',
            'foto' => 'nullable|string|max:255',
            'status' => 'nullable|in:aktif,nonaktif',
        ];
    }
}