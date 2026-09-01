<x-layouts.guest>
    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label class="block text-sm text-gray-700">Correo</label>
            <input type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus class="mt-1 block w-full border-gray-300 rounded-md">
            <x-input-error for="email" />
        </div>

        <div>
            <label class="block text-sm text-gray-700">Nueva contrasena</label>
            <input type="password" name="password" required class="mt-1 block w-full border-gray-300 rounded-md">
            <x-input-error for="password" />
        </div>

        <div>
            <label class="block text-sm text-gray-700">Confirmar contrasena</label>
            <input type="password" name="password_confirmation" required class="mt-1 block w-full border-gray-300 rounded-md">
        </div>

        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm">Restablecer contrasena</button>
    </form>
</x-layouts.guest>
