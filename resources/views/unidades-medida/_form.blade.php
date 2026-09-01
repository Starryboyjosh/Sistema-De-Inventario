@php $unidad = $unidad ?? null; @endphp

<div>
    <label class="block text-sm text-gray-700">Nombre</label>
    <input type="text" name="nombre" value="{{ old('nombre', $unidad->nombre ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md">
    <x-input-error for="nombre" />
</div>

<div>
    <label class="block text-sm text-gray-700">Abreviatura</label>
    <input type="text" name="abreviatura" value="{{ old('abreviatura', $unidad->abreviatura ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md">
    <x-input-error for="abreviatura" />
</div>
