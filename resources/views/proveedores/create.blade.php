@extends('layouts.app')

@section('titulo', 'Nuevo proveedor')

@section('contenido')
    <div class="bg-white p-6 rounded shadow max-w-xl">
        <form method="POST" action="{{ route('proveedores.store') }}" class="space-y-4">
            @csrf
            @include('proveedores._form')
            <button class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm">Guardar</button>
        </form>
    </div>
@endsection
