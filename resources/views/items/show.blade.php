@extends('layouts.app')

@section('titulo', 'Detalle del item')

@section('contenido')
    <div class="bg-white p-6 rounded shadow max-w-2xl space-y-4">
        <div>
            <h3 class="text-lg font-semibold">{{ $item->nombre }}</h3>
            <p class="text-sm text-gray-500">SKU: {{ $item->sku }}</p>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div><span class="text-gray-500">Categoria:</span> {{ $item->categoria->nombre ?? '-' }}</div>
            <div><span class="text-gray-500">Unidad:</span> {{ $item->unidadMedida->nombre ?? '-' }}</div>
            <div><span class="text-gray-500">Proveedor:</span> {{ $item->proveedor->nombre ?? '-' }}</div>
            <div><span class="text-gray-500">Stock minimo:</span> {{ $item->stock_minimo }}</div>
            <div><span class="text-gray-500">Stock total:</span> {{ $item->stockTotal() }}</div>
            <div><span class="text-gray-500">Estado:</span> {{ $item->estado }}</div>
        </div>

        <div>
            <h4 class="font-semibold text-sm mb-2">Stock por area</h4>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="py-2">Sucursal</th>
                        <th>Area</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($item->inventario as $inv)
                        <tr class="border-b">
                            <td class="py-2">{{ $inv->area->sucursal->nombre ?? '-' }}</td>
                            <td>{{ $inv->area->nombre ?? '-' }}</td>
                            <td>{{ $inv->cantidad }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-2 text-gray-500">Sin stock registrado en areas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <a href="{{ route('items.index') }}" class="text-sm text-blue-600">Volver</a>
    </div>
@endsection
