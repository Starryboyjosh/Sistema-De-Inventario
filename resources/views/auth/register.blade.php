<x-layouts.guest>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm text-gray-700">Nombre</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus class="mt-1 block w-full border-gray-300 rounded-md">
            <x-input-error for="name" />
        </div>

        <div>
            <label class="block text-sm text-gray-700">Correo</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 block w-full border-gray-300 rounded-md">
            <x-input-error for="email" />
        </div>

        <div>
            <label class="block text-sm text-gray-700">Contrasena</label>
            <input type="password" name="password" required class="mt-1 block w-full border-gray-300 rounded-md">
            <x-input-error for="password" />
        </div>

        <div>
            <label class="block text-sm text-gray-700">Confirmar contrasena</label>
            <input type="password" name="password_confirmation" required class="mt-1 block w-full border-gray-300 rounded-md">
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('login') }}" class="text-sm text-gray-500 underline">Ya tienes cuenta?</a>
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm">Registrarse</button>
        </div>
    </form>
</x-layouts.guest>
