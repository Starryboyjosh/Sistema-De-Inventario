@extends('layouts.app')

@section('titulo', 'Dashboard')

@section('contenido')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded shadow">
            <p class="text-sm text-gray-500">Total de items</p>
            <p class="text-2xl font-semibold">{{ $totalItems }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <p class="text-sm text-gray-500">Total de unidades en inventario</p>
            <p class="text-2xl font-semibold">{{ $totalUnidades }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <p class="text-sm text-gray-500">Items con alerta de stock bajo</p>
            <p class="text-2xl font-semibold text-red-600">{{ $alertas->count() }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-semibold text-sm mb-2">Alertas de stock minimo</h3>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="py-2">Item</th>
                        <th>Stock</th>
                        <th>Minimo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($alertas as $item)
                        <tr class="border-b">
                            <td class="py-2">{{ $item->nombre }}</td>
                            <td class="{{ $item->stockTotal() == 0 ? 'text-red-600' : 'text-yellow-600' }} font-semibold">{{ $item->stockTotal() }}</td>
                            <td>{{ $item->stock_minimo }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="py-2 text-gray-500">Sin alertas por el momento.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-semibold text-sm mb-2">Unidades por sucursal</h3>
            <canvas id="graficoSucursales"></canvas>
        </div>
    </div>

    <div class="bg-white p-4 rounded shadow mt-4">
        <h3 class="font-semibold text-sm mb-2">Ultimos movimientos</h3>
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
                @forelse ($movimientos as $mov)
                    <tr class="border-b">
                        <td class="py-2">{{ $mov->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ ucfirst($mov->tipo) }}</td>
                        <td>{{ $mov->item->nombre ?? '-' }}</td>
                        <td>{{ $mov->cantidad }}</td>
                        <td>{{ $mov->usuario->name ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-2 text-gray-500">Sin movimientos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('graficoSucursales');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($porSucursal->pluck('nombre')) !!},
                datasets: [{
                    label: 'Unidades',
                    data: {!! json_encode($porSucursal->pluck('total')) !!},
                    backgroundColor: '#374151',
                }],
            },
        });
    </script>
@endsection
