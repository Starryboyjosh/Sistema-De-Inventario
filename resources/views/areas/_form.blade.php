@php $area = $area ?? null; @endphp

<div>
    <label class="block text-sm text-gray-700">Sucursal</label>
    <select name="sucursal_id" class="mt-1 block w-full border-gray-300 rounded-md">
        @foreach ($sucursales as $sucursal)
            <option value="{{ $sucursal->id }}" @selected(old('sucursal_id', $area->sucursal_id ?? '') == $sucursal->id)>{{ $sucursal->nombre }}</option>
        @endforeach
    </select>
</div>

<div>
    <label class="block text-sm text-gray-700">Nombre</label>
    <input type="text" name="nombre" value="{{ old('nombre', $area->nombre ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md">
    <x-input-error for="nombre" />
</div>

<div>
    <label class="block text-sm text-gray-700">Descripcion</label>
    <input type="text" name="descripcion" value="{{ old('descripcion', $area->descripcion ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md">
</div>

<div>
    <label class="block text-sm text-gray-700">Encargado</label>
    <select name="encargado_id" class="mt-1 block w-full border-gray-300 rounded-md">
        <option value="">Sin asignar</option>
        @foreach ($usuarios as $usuario)
            <option value="{{ $usuario->id }}" @selected(old('encargado_id', $area->encargado_id ?? '') == $usuario->id)>{{ $usuario->name }}</option>
        @endforeach
    </select>
</div>

<div>
    <label class="block text-sm text-gray-700">Estado</label>
    <select name="estado" class="mt-1 block w-full border-gray-300 rounded-md">
        <option value="activo" @selected(old('estado', $area->estado ?? 'activo') == 'activo')>Activo</option>
        <option value="inactivo" @selected(old('estado', $area->estado ?? '') == 'inactivo')>Inactivo</option>
    </select>
</div>
