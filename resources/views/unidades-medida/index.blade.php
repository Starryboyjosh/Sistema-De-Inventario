@extends('layouts.app')

@section('titulo', 'Unidades de medida')

@section('contenido')
    <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-end mb-4">
            <a href="{{ route('unidades-medida.create') }}" class="bg-gray-800 text-white px-3 py-1 rounded text-sm">Nueva unidad</a>
        </div>

        <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th class="py-2">Nombre</th>
                    <th>Abreviatura</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($unidades as $unidad)
                    <tr class="border-b">
                        <td class="py-2">{{ $unidad->nombre }}</td>
                        <td>{{ $unidad->abreviatura }}</td>
                        <td class="text-right space-x-2">
                            <a href="{{ route('unidades-medida.edit', $unidad) }}" class="text-blue-600">Editar</a>
                            <form action="{{ route('unidades-medida.destroy', $unidad) }}" method="POST" class="inline" onsubmit="return confirm('Eliminar esta unidad?')">
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

        <div class="mt-4">{{ $unidades->links() }}</div>
    </div>
@endsection
