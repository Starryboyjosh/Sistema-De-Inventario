<x-layouts.guest>
    @if (session('status'))
        <div class="mb-4 text-sm text-green-600">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm text-gray-700">Correo</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-1 block w-full border-gray-300 rounded-md">
            <x-input-error for="email" />
        </div>

        <div>
            <label class="block text-sm text-gray-700">Contrasena</label>
            <input type="password" name="password" required class="mt-1 block w-full border-gray-300 rounded-md">
            <x-input-error for="password" />
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember" class="ml-2 text-sm text-gray-600">Recordarme</label>
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('password.request') }}" class="text-sm text-gray-500 underline">Olvidaste tu contrasena?</a>
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm">Iniciar sesion</button>
        </div>

        <p class="text-sm text-gray-600">No tienes cuenta? <a href="{{ route('register') }}" class="underline">Registrate</a></p>
    </form>
</x-layouts.guest>
