<x-layouts.guest>
    <div class="mb-4 text-sm text-gray-600">
        Olvidaste tu contrasena? Escribe tu correo y te enviaremos un enlace para restablecerla.
    </div>

    @if (session('status'))
        <div class="mb-4 text-sm text-green-600">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm text-gray-700">Correo</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-1 block w-full border-gray-300 rounded-md">
            <x-input-error for="email" />
        </div>

        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm">Enviar enlace</button>
    </form>
</x-layouts.guest>
