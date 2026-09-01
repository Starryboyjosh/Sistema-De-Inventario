@extends('layouts.app')

@section('titulo', 'Historial de movimientos')

@section('contenido')
    <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between mb-4 flex-wrap gap-2">
            <form method="GET" class="flex gap-2">
                <select name="tipo" class="border-gray-300 rounded-md text-sm">
                    <option value="">Todos los tipos</option>
                    <option value="entrada" @selected(request('tipo') == 'entrada')>Entrada</option>
                    <option value="salida" @selected(request('tipo') == 'salida')>Salida</option>
                    <option value="traslado" @selected(request('tipo') == 'traslado')>Traslado</option>
                    <option value="ajuste" @selected(request('tipo') == 'ajuste')>Ajuste</option>
                </select>
                <select name="item_id" class="border-gray-300 rounded-md text-sm">
                    <option value="">Todos los items</option>
                    @foreach ($items as $item)
                        <option value="{{ $item->id }}" @selected(request('item_id') == $item->id)>{{ $item->nombre }}</option>
                    @endforeach
                </select>
                <button class="text-sm bg-gray-200 px-3 py-1 rounded">Filtrar</button>
            </form>

            <div class="flex gap-2">
                <a href="{{ route('movimientos.entrada') }}" class="bg-gray-800 text-white px-3 py-1 rounded text-sm">Entrada</a>
                <a href="{{ route('movimientos.salida') }}" class="bg-gray-800 text-white px-3 py-1 rounded text-sm">Salida</a>
                <a href="{{ route('movimientos.traslado') }}" class="bg-gray-800 text-white px-3 py-1 rounded text-sm">Traslado</a>
                <a href="{{ route('movimientos.ajuste') }}" class="bg-gray-800 text-white px-3 py-1 rounded text-sm">Ajuste</a>
            </div>
        </div>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th class="py-2">Fecha</th>
                    <th>Tipo</th>
                    <th>Item</th>
                    <th>Cantidad</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Usuario</th>
                    <th>Motivo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($movimientos as $mov)
                    <tr class="border-b">
                        <td class="py-2">{{ $mov->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ ucfirst($mov->tipo) }}</td>
                        <td>{{ $mov->item->nombre ?? '-' }}</td>
                        <td>{{ $mov->cantidad }}</td>
                        <td>{{ $mov->areaOrigen->nombre ?? '-' }}</td>
                        <td>{{ $mov->areaDestino->nombre ?? '-' }}</td>
                        <td>{{ $mov->usuario->name ?? '-' }}</td>
                        <td>{{ $mov->motivo }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">{{ $movimientos->links() }}</div>
    </div>
@endsection
