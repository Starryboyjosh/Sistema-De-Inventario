<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $itemId = $this->route('item')?->id;

        return [
            'categoria_id' => 'required|exists:categorias,id',
            'unidad_medida_id' => 'required|exists:unidades_medida,id',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'nombre' => 'required|string|max:255',
            'sku' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('items', 'sku')->where('empresa_id', auth()->user()->empresa_id)->ignore($itemId),
            ],
            'descripcion' => 'nullable|string|max:500',
            'imagen' => 'nullable|image|max:2048',
            'costo_unitario' => 'nullable|numeric|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'estado' => 'required|in:activo,inactivo',
        ];
    }
}
