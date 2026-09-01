@extends('layouts.app')

@section('titulo', 'Items')

@section('contenido')
    <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between mb-4">
            <form method="GET" class="flex gap-2">
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar" class="border-gray-300 rounded-md text-sm">
                <select name="categoria_id" class="border-gray-300 rounded-md text-sm">
                    <option value="">Todas las categorias</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" @selected(request('categoria_id') == $categoria->id)>{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
                <button class="text-sm bg-gray-200 px-3 py-1 rounded">Buscar</button>
            </form>
            <a href="{{ route('items.create') }}" class="bg-gray-800 text-white px-3 py-1 rounded text-sm">Nuevo item</a>
        </div>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th class="py-2">SKU</th>
                    <th>Nombre</th>
                    <th>Categoria</th>
                    <th>Stock total</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr class="border-b">
                        <td class="py-2">{{ $item->sku }}</td>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->categoria->nombre ?? '-' }}</td>
                        <td>
                            @php $stock = $item->stockTotal(); @endphp
                            <span class="{{ $stock <= $item->stock_minimo ? 'text-red-600 font-semibold' : '' }}">{{ $stock }}</span>
                        </td>
                        <td>{{ $item->estado }}</td>
                        <td class="text-right space-x-2">
                            <a href="{{ route('items.show', $item) }}" class="text-gray-600">Ver</a>
                            <a href="{{ route('items.edit', $item) }}" class="text-blue-600">Editar</a>
                            <form action="{{ route('items.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Eliminar este item?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">{{ $items->links() }}</div>
    </div>
@endsection
