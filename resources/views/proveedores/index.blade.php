@extends('layouts.app')

@section('titulo', 'Proveedores')

@section('contenido')
    <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between mb-4">
            <form method="GET" class="flex gap-2">
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar" class="border-gray-300 rounded-md text-sm">
                <button class="text-sm bg-gray-200 px-3 py-1 rounded">Buscar</button>
            </form>
            <a href="{{ route('proveedores.create') }}" class="bg-gray-800 text-white px-3 py-1 rounded text-sm">Nuevo proveedor</a>
        </div>

        <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th class="py-2">Nombre</th>
                    <th>Contacto</th>
                    <th>Telefono</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($proveedores as $proveedor)
                    <tr class="border-b">
                        <td class="py-2">{{ $proveedor->nombre }}</td>
                        <td>{{ $proveedor->contacto }}</td>
                        <td>{{ $proveedor->telefono }}</td>
                        <td class="text-right space-x-2">
                            <a href="{{ route('proveedores.edit', $proveedor) }}" class="text-blue-600">Editar</a>
                            <form action="{{ route('proveedores.destroy', $proveedor) }}" method="POST" class="inline" onsubmit="return confirm('Eliminar este proveedor?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>

        <div class="mt-4">{{ $proveedores->links() }}</div>
    </div>
@endsection
