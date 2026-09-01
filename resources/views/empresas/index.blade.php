@extends('layouts.app')

@section('titulo', 'Empresas')

@section('contenido')
    <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between mb-4">
            <form method="GET" class="flex gap-2">
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre" class="border-gray-300 rounded-md text-sm">
                <button class="text-sm bg-gray-200 px-3 py-1 rounded">Buscar</button>
            </form>

            @can('create', App\Models\Empresa::class)
                <a href="{{ route('empresas.create') }}" class="bg-gray-800 text-white px-3 py-1 rounded text-sm">Nueva empresa</a>
            @endcan
        </div>

        <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th class="py-2">Nombre</th>
                    <th>Identificacion fiscal</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($empresas as $empresa)
                    <tr class="border-b">
                        <td class="py-2">{{ $empresa->nombre }}</td>
                        <td>{{ $empresa->identificacion_fiscal }}</td>
                        <td>{{ $empresa->estado }}</td>
                        <td class="text-right space-x-2">
                            @can('update', $empresa)
                                <a href="{{ route('empresas.edit', $empresa) }}" class="text-blue-600">Editar</a>
                            @endcan
                            @can('delete', $empresa)
                                <form action="{{ route('empresas.destroy', $empresa) }}" method="POST" class="inline" onsubmit="return confirm('Eliminar esta empresa?')">
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
        </div>

        <div class="mt-4">{{ $empresas->links() }}</div>
    </div>
@endsection
