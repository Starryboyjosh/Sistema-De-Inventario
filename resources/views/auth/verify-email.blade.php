<x-layouts.guest>
    <div class="mb-4 text-sm text-gray-600">
        Gracias por registrarte! Antes de continuar, confirma tu correo dando clic en el enlace que te enviamos.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 text-sm text-green-600">Se envio un nuevo enlace de verificacion a tu correo.</div>
    @endif

    <div class="flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm">Reenviar correo</button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-500 underline">Cerrar sesion</button>
        </form>
    </div>
</x-layouts.guest>
