@extends('layouts.app')

@section('titulo', 'Areas')

@section('contenido')
    <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between mb-4">
            <form method="GET" class="flex gap-2">
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre" class="border-gray-300 rounded-md text-sm">
                <button class="text-sm bg-gray-200 px-3 py-1 rounded">Buscar</button>
            </form>

            @can('create', App\Models\Area::class)
                <a href="{{ route('areas.create') }}" class="bg-gray-800 text-white px-3 py-1 rounded text-sm">Nueva area</a>
            @endcan
        </div>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th class="py-2">Nombre</th>
                    <th>Sucursal</th>
                    <th>Encargado</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($areas as $area)
                    <tr class="border-b">
                        <td class="py-2">{{ $area->nombre }}</td>
                        <td>{{ $area->sucursal->nombre }}</td>
                        <td>{{ $area->encargado->name ?? 'Sin asignar' }}</td>
                        <td>{{ $area->estado }}</td>
                        <td class="text-right space-x-2">
                            @can('update', $area)
                                <a href="{{ route('areas.edit', $area) }}" class="text-blue-600">Editar</a>
                            @endcan
                            @can('delete', $area)
                                <form action="{{ route('areas.destroy', $area) }}" method="POST" class="inline" onsubmit="return confirm('Eliminar esta area?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600">Eliminar</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">{{ $areas->links() }}</div>
    </div>
@endsection
