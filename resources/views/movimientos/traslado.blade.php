@extends('layouts.app')

@section('titulo', 'Registrar traslado')

@section('contenido')
    <div class="bg-white p-6 rounded shadow max-w-xl">
        <form method="POST" action="{{ route('movimientos.traslado.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm text-gray-700">Item</label>
                <select name="item_id" id="item_id" class="mt-1 block w-full border-gray-300 rounded-md">
                    @foreach ($items as $item)
                        <option value="{{ $item->id }}">{{ $item->nombre }} ({{ $item->sku }})</option>
                    @endforeach
                </select>
                <x-input-error for="item_id" />
            </div>

            <div>
                <label class="block text-sm text-gray-700">Area origen</label>
                <select name="area_origen_id" id="area_origen_id" class="mt-1 block w-full border-gray-300 rounded-md">
                    @foreach ($areas as $area)
                        <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">Stock disponible: <span id="stock_disponible">-</span></p>
                <x-input-error for="area_origen_id" />
            </div>

            <div>
                <label class="block text-sm text-gray-700">Area destino</label>
                <select name="area_destino_id" class="mt-1 block w-full border-gray-300 rounded-md">
                    @foreach ($areas as $area)
                        <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                    @endforeach
                </select>
                <x-input-error for="area_destino_id" />
            </div>

            <div>
                <label class="block text-sm text-gray-700">Cantidad</label>
                <input type="number" name="cantidad" min="1" class="mt-1 block w-full border-gray-300 rounded-md">
                <x-input-error for="cantidad" />
            </div>

            <div>
                <label class="block text-sm text-gray-700">Motivo</label>
                <input type="text" name="motivo" class="mt-1 block w-full border-gray-300 rounded-md">
            </div>

            <button class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm">Registrar traslado</button>
        </form>
    </div>

    <script>
        function actualizarStock() {
            var itemId = document.getElementById('item_id').value;
            var areaId = document.getElementById('area_origen_id').value;

            fetch('/movimientos/stock-por-area/' + areaId)
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    document.getElementById('stock_disponible').textContent = data[itemId] ?? 0;
                });
        }

        document.getElementById('item_id').addEventListener('change', actualizarStock);
        document.getElementById('area_origen_id').addEventListener('change', actualizarStock);
        actualizarStock();
    </script>
@endsection
