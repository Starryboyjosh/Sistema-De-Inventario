@extends('layouts.app')

@section('titulo', 'Mi perfil')

@section('contenido')
    <div class="bg-white p-6 rounded shadow max-w-xl space-y-8">
        @if (session('status') == 'profile-updated')
            <div class="text-sm text-green-600">Perfil actualizado.</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('patch')

            <div>
                <label class="block text-sm text-gray-700">Nombre</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                <x-input-error for="name" />
            </div>

            <div>
                <label class="block text-sm text-gray-700">Correo</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                <x-input-error for="email" />
            </div>

            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm">Guardar</button>
        </form>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            @method('put')

            <h3 class="font-medium text-gray-800">Cambiar contrasena</h3>

            <div>
                <label class="block text-sm text-gray-700">Contrasena actual</label>
                <input type="password" name="current_password" class="mt-1 block w-full border-gray-300 rounded-md">
                <x-input-error for="current_password" />
            </div>

            <div>
                <label class="block text-sm text-gray-700">Nueva contrasena</label>
                <input type="password" name="password" class="mt-1 block w-full border-gray-300 rounded-md">
                <x-input-error for="password" />
            </div>

            <div>
                <label class="block text-sm text-gray-700">Confirmar contrasena</label>
                <input type="password" name="password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md">
            </div>

            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm">Actualizar contrasena</button>
        </form>
    </div>
@endsection
