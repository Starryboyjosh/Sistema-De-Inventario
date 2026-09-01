@extends('layouts.app')

@section('titulo', 'Reporte de movimientos')

@section('contenido')
    <div class="bg-white p-4 rounded shadow">
        <form method="GET" class="flex gap-2 mb-4">
            <select name="tipo" class="border-gray-300 rounded-md text-sm">
                <option value="">Todos los tipos</option>
                <option value="entrada" @selected(request('tipo') == 'entrada')>Entrada</option>
                <option value="salida" @selected(request('tipo') == 'salida')>Salida</option>
                <option value="traslado" @selected(request('tipo') == 'traslado')>Traslado</option>
                <option value="ajuste" @selected(request('tipo') == 'ajuste')>Ajuste</option>
            </select>
            <input type="date" name="desde" value="{{ request('desde') }}" class="border-gray-300 rounded-md text-sm">
            <input type="date" name="hasta" value="{{ request('hasta') }}" class="border-gray-300 rounded-md text-sm">
            <button class="text-sm bg-gray-200 px-3 py-1 rounded">Filtrar</button>
        </form>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th class="py-2">Fecha</th>
                    <th>Tipo</th>
                    <th>Item</th>
                    <th>Cantidad</th>
                    <th>Usuario</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($movimientos as $mov)
                    <tr class="border-b">
                        <td class="py-2">{{ $mov->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ ucfirst($mov->tipo) }}</td>
                        <td>{{ $mov->item->nombre ?? '-' }}</td>
                        <td>{{ $mov->cantidad }}</td>
                        <td>{{ $mov->usuario->name ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">{{ $movimientos->links() }}</div>
    </div>
@endsection
