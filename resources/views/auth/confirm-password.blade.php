<x-layouts.guest>
    <div class="mb-4 text-sm text-gray-600">
        Esta es un area segura. Confirma tu contrasena antes de continuar.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm text-gray-700">Contrasena</label>
            <input type="password" name="password" required autofocus class="mt-1 block w-full border-gray-300 rounded-md">
            <x-input-error for="password" />
        </div>

        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm">Confirmar</button>
    </form>
</x-layouts.guest>
