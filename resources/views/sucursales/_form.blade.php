@php $sucursal = $sucursal ?? null; @endphp

@if (auth()->user()->hasRole('super_admin'))
    <div>
        <label class="block text-sm text-gray-700">Empresa</label>
        <select name="empresa_id" class="mt-1 block w-full border-gray-300 rounded-md" @disabled($sucursal)>
            @foreach ($empresas as $empresa)
                <option value="{{ $empresa->id }}" @selected(old('empresa_id', $sucursal->empresa_id ?? '') == $empresa->id)>{{ $empresa->nombre }}</option>
            @endforeach
        </select>
    </div>
@endif

<div>
    <label class="block text-sm text-gray-700">Nombre</label>
    <input type="text" name="nombre" value="{{ old('nombre', $sucursal->nombre ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md">
    <x-input-error for="nombre" />
</div>

<div>
    <label class="block text-sm text-gray-700">Direccion</label>
    <input type="text" name="direccion" value="{{ old('direccion', $sucursal->direccion ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md">
</div>

<div>
    <label class="block text-sm text-gray-700">Telefono</label>
    <input type="text" name="telefono" value="{{ old('telefono', $sucursal->telefono ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md">
</div>

<div>
    <label class="block text-sm text-gray-700">Estado</label>
    <select name="estado" class="mt-1 block w-full border-gray-300 rounded-md">
        <option value="activo" @selected(old('estado', $sucursal->estado ?? 'activo') == 'activo')>Activo</option>
        <option value="inactivo" @selected(old('estado', $sucursal->estado ?? '') == 'inactivo')>Inactivo</option>
    </select>
</div>
