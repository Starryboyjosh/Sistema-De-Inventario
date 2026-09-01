@php $proveedor = $proveedor ?? null; @endphp

<div>
    <label class="block text-sm text-gray-700">Nombre</label>
    <input type="text" name="nombre" value="{{ old('nombre', $proveedor->nombre ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md">
    <x-input-error for="nombre" />
</div>

<div>
    <label class="block text-sm text-gray-700">Contacto</label>
    <input type="text" name="contacto" value="{{ old('contacto', $proveedor->contacto ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md">
</div>

<div>
    <label class="block text-sm text-gray-700">Telefono</label>
    <input type="text" name="telefono" value="{{ old('telefono', $proveedor->telefono ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md">
</div>

<div>
    <label class="block text-sm text-gray-700">Correo</label>
    <input type="email" name="correo" value="{{ old('correo', $proveedor->correo ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md">
</div>
