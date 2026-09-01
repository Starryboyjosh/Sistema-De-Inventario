@extends('layouts.app')

@section('titulo', 'Dashboard')

@section('contenido')
    <p>Bienvenido, {{ Auth::user()->name }}.</p>
@endsection
