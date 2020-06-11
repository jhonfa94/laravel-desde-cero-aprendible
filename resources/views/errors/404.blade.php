@extends('layout')

@section('title','Página no econtrada 404') 

@section('content')
    <h1> 404 Página no encontrada </h1>
    <p>
        <a href="{{route('home')}}">Volver</a>
    </p>
@endsection