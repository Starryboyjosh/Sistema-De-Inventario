@extends('layouts.app')

@section('titulo', 'Editar proveedor')

@section('contenido')
    <div class="bg-white p-6 rounded shadow max-w-xl">
        <form method="POST" action="{{ route('proveedores.update', $proveedor) }}" class="space-y-4">
            @csrf
            @method('PUT')
            @include('proveedores._form')
            <button class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm">Actualizar</button>
        </form>
    </div>
@endsection
