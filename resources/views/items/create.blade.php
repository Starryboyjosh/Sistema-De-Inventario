@extends('layouts.app')

@section('titulo', 'Nuevo item')

@section('contenido')
    <div class="bg-white p-6 rounded shadow max-w-xl">
        <form method="POST" action="{{ route('items.store') }}" class="space-y-4" enctype="multipart/form-data">
            @csrf
            @include('items._form')
            <button class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm">Guardar</button>
        </form>
    </div>
@endsection
