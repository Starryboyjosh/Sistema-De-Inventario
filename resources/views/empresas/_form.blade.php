@php $empresa = $empresa ?? null; @endphp

<div>
    <label class="block text-sm text-gray-700">Nombre</label>
    <input type="text" name="nombre" value="{{ old('nombre', $empresa->nombre ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md">
    <x-input-error for="nombre" />
</div>

<div>
    <label class="block text-sm text-gray-700">Identificacion fiscal (RTN)</label>
    <input type="text" name="identificacion_fiscal" value="{{ old('identificacion_fiscal', $empresa->identificacion_fiscal ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md">
    <x-input-error for="identificacion_fiscal" />
</div>

<div>
    <label class="block text-sm text-gray-700">Direccion</label>
    <input type="text" name="direccion" value="{{ old('direccion', $empresa->direccion ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md">
</div>

<div>
    <label class="block text-sm text-gray-700">Telefono</label>
    <input type="text" name="telefono" value="{{ old('telefono', $empresa->telefono ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md">
</div>

<div>
    <label class="block text-sm text-gray-700">Correo</label>
    <input type="email" name="correo" value="{{ old('correo', $empresa->correo ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md">
</div>

<div>
    <label class="block text-sm text-gray-700">Estado</label>
    <select name="estado" class="mt-1 block w-full border-gray-300 rounded-md">
        <option value="activo" @selected(old('estado', $empresa->estado ?? 'activo') == 'activo')>Activo</option>
        <option value="inactivo" @selected(old('estado', $empresa->estado ?? '') == 'inactivo')>Inactivo</option>
    </select>
</div>
