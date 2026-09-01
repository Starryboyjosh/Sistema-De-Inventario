@extends('layouts.app')

@section('titulo', 'Reporte de inventario')

@section('contenido')
    <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between mb-4">
            <h3 class="font-semibold text-sm">Listado de inventario</h3>
            <div class="flex gap-2">
                <a href="{{ route('reportes.inventario.excel') }}" class="bg-green-700 text-white px-3 py-1 rounded text-sm">Exportar Excel</a>
                <a href="{{ route('reportes.inventario.pdf') }}" class="bg-red-700 text-white px-3 py-1 rounded text-sm">Exportar PDF</a>
            </div>
        </div>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th class="py-2">SKU</th>
                    <th>Nombre</th>
                    <th>Categoria</th>
                    <th>Unidad</th>
                    <th>Stock total</th>
                    <th>Stock minimo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr class="border-b">
                        <td class="py-2">{{ $item->sku }}</td>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->categoria->nombre ?? '-' }}</td>
                        <td>{{ $item->unidadMedida->nombre ?? '-' }}</td>
                        <td>{{ $item->stockTotal() }}</td>
                        <td>{{ $item->stock_minimo }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
