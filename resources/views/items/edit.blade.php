@extends('layouts.app')

@section('titulo', 'Editar item')

@section('contenido')
    <div class="bg-white p-6 rounded shadow max-w-xl">
        <form method="POST" action="{{ route('items.update', $item) }}" class="space-y-4" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('items._form')
            <button class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm">Actualizar</button>
        </form>
    </div>
@endsection
