@php $item = $item ?? null; @endphp

<div>
    <label class="block text-sm text-gray-700">Nombre</label>
    <input type="text" name="nombre" value="{{ old('nombre', $item->nombre ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md">
    <x-input-error for="nombre" />
</div>

<div>
    <label class="block text-sm text-gray-700">SKU (dejar en blanco para autogenerar)</label>
    <input type="text" name="sku" value="{{ old('sku', $item->sku ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md">
    <x-input-error for="sku" />
</div>

<div>
    <label class="block text-sm text-gray-700">Categoria</label>
    <select name="categoria_id" class="mt-1 block w-full border-gray-300 rounded-md">
        <option value="">Seleccione</option>
        @foreach ($categorias as $categoria)
            <option value="{{ $categoria->id }}" @selected(old('categoria_id', $item->categoria_id ?? '') == $categoria->id)>{{ $categoria->nombre }}</option>
        @endforeach
    </select>
    <x-input-error for="categoria_id" />
</div>

<div>
    <label class="block text-sm text-gray-700">Unidad de medida</label>
    <select name="unidad_medida_id" class="mt-1 block w-full border-gray-300 rounded-md">
        <option value="">Seleccione</option>
        @foreach ($unidades as $unidad)
            <option value="{{ $unidad->id }}" @selected(old('unidad_medida_id', $item->unidad_medida_id ?? '') == $unidad->id)>{{ $unidad->nombre }}</option>
        @endforeach
    </select>
    <x-input-error for="unidad_medida_id" />
</div>

<div>
    <label class="block text-sm text-gray-700">Proveedor</label>
    <select name="proveedor_id" class="mt-1 block w-full border-gray-300 rounded-md">
        <option value="">Sin proveedor</option>
        @foreach ($proveedores as $proveedor)
            <option value="{{ $proveedor->id }}" @selected(old('proveedor_id', $item->proveedor_id ?? '') == $proveedor->id)>{{ $proveedor->nombre }}</option>
        @endforeach
    </select>
</div>

<div>
    <label class="block text-sm text-gray-700">Descripcion</label>
    <textarea name="descripcion" class="mt-1 block w-full border-gray-300 rounded-md">{{ old('descripcion', $item->descripcion ?? '') }}</textarea>
</div>

<div>
    <label class="block text-sm text-gray-700">Imagen</label>
    <input type="file" name="imagen" class="mt-1 block w-full text-sm">
    <x-input-error for="imagen" />
</div>

<div>
    <label class="block text-sm text-gray-700">Costo unitario</label>
    <input type="number" step="0.01" name="costo_unitario" value="{{ old('costo_unitario', $item->costo_unitario ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md">
</div>

<div>
    <label class="block text-sm text-gray-700">Stock minimo</label>
    <input type="number" name="stock_minimo" value="{{ old('stock_minimo', $item->stock_minimo ?? 0) }}" class="mt-1 block w-full border-gray-300 rounded-md">
    <x-input-error for="stock_minimo" />
</div>

<div>
    <label class="block text-sm text-gray-700">Estado</label>
    <select name="estado" class="mt-1 block w-full border-gray-300 rounded-md">
        <option value="activo" @selected(old('estado', $item->estado ?? 'activo') == 'activo')>Activo</option>
        <option value="inactivo" @selected(old('estado', $item->estado ?? '') == 'inactivo')>Inactivo</option>
    </select>
</div>
