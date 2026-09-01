@extends('layouts.app')

@section('titulo', 'Sucursales')

@section('contenido')
    <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between mb-4">
            <form method="GET" class="flex gap-2">
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre" class="border-gray-300 rounded-md text-sm">
                <button class="text-sm bg-gray-200 px-3 py-1 rounded">Buscar</button>
            </form>

            @can('create', App\Models\Sucursal::class)
                <a href="{{ route('sucursales.create') }}" class="bg-gray-800 text-white px-3 py-1 rounded text-sm">Nueva sucursal</a>
            @endcan
        </div>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th class="py-2">Nombre</th>
                    <th>Empresa</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sucursales as $sucursal)
                    <tr class="border-b">
                        <td class="py-2">{{ $sucursal->nombre }}</td>
                        <td>{{ $sucursal->empresa->nombre }}</td>
                        <td>{{ $sucursal->estado }}</td>
                        <td class="text-right space-x-2">
                            @can('update', $sucursal)
                                <a href="{{ route('sucursales.edit', $sucursal) }}" class="text-blue-600">Editar</a>
                            @endcan
                            @can('delete', $sucursal)
                                <form action="{{ route('sucursales.destroy', $sucursal) }}" method="POST" class="inline" onsubmit="return confirm('Eliminar esta sucursal?')">
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

        <div class="mt-4">{{ $sucursales->links() }}</div>
    </div>
@endsection
