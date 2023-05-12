@extends('layouts.app')
@section('content')
@if (auth()->user())
@if (auth()->user()->restaurant)
    <a type="button" class="btn btn-success border fw-bold" href="{{route('restaurants.edit', auth()->user()->restaurant)}}">Modifica il tuo ristorante</a>
@else
    <a type="button" class="btn btn-success border fw-bold" href="{{route('restaurants.create')}}">Registra il tuo ristorante</a>
@endif  
@else  
registrati
@endif

@endsection