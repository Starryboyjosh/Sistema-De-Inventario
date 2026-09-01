<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-6">
                <a href="{{ route('dashboard') }}" class="font-bold text-gray-800">Inventario Mipymes</a>

                @can('empresas.ver')
                    <a href="{{ route('empresas.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Empresas</a>
                @endcan
                @can('sucursales.ver')
                    <a href="{{ route('sucursales.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Sucursales</a>
                @endcan
                @can('areas.ver')
                    <a href="{{ route('areas.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Areas</a>
                @endcan
                @can('categorias.ver')
                    <a href="{{ route('categorias.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Categorias</a>
                @endcan
                @can('unidades_medida.ver')
                    <a href="{{ route('unidades-medida.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Unidades</a>
                @endcan
                @can('proveedores.ver')
                    <a href="{{ route('proveedores.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Proveedores</a>
                @endcan
                @can('items.ver')
                    <a href="{{ route('items.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Items</a>
                @endcan
                @can('movimientos.ver')
                    <a href="{{ route('movimientos.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Movimientos</a>
                @endcan
                @can('reportes.ver')
                    <a href="{{ route('reportes.inventario') }}" class="text-sm text-gray-600 hover:text-gray-900">Reportes</a>
                @endcan
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('profile.edit') }}" class="text-sm text-gray-600 hover:text-gray-900">{{ Auth::user()->name }}</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">Cerrar sesion</button>
                </form>
            </div>
        </div>
    </div>
</nav>
