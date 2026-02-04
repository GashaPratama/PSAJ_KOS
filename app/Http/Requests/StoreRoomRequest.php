<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'nomor_kamar' => 'required|string|unique:rooms,nomor_kamar',
            'tipe_kamar' => 'required|string',
            'harga_per_bulan' => 'required|numeric|min:0',
            'fasilitas' => 'nullable|array',
            'status_kamar' => 'nullable|in:available,occupied,maintenance',
        ];
    }
}
