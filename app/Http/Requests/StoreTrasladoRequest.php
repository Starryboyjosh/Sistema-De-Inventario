<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrasladoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'item_id' => 'required|exists:items,id',
            'area_origen_id' => 'required|exists:areas,id|different:area_destino_id',
            'area_destino_id' => 'required|exists:areas,id',
            'cantidad' => 'required|integer|min:1',
            'motivo' => 'nullable|string|max:255',
        ];
    }
}
