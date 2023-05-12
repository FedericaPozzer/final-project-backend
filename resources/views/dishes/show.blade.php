show del ristorante
@extends('layouts.app')

@section('content')

    <h3>Dettaglio piatto - show</h3>  

    {{$dish->name}}
    {{$dish->price}}
    {{$dish->description}}
    
@endsection