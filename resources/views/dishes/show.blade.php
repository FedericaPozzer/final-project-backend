show del ristorante
@extends('layouts.app')
@section('content')
    {{$dish->name}}
    {{$dish->price}}
    {{$dish->description}}
@endsection