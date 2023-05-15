Creazione e modifica ristorante
@extends('layouts.app')

@section('content')

{{-- @if (auth()->user()->restaurant != null)
    ho un ristorante
@else
    non ho un ristorante sono povero
@endif --}}

{{-- * UPDATE / EDIT title --}}
@if ($dish->id)
    <h2>modifica il piatto</h2>
@else
    <h2>crea il tuo piatto</h2>
@endif

@include('layouts.partials.errors')

{{-- * se il piatto esiste già form edit / se il piatto non esiste già form create --}}
@if ($dish->id)
    <form action="{{route('dishes.update', $dish)}}" method="POST" class="row">
    @method('PUT')
@else
    <form action="{{route('dishes.store')}}" method="POST" class="row">
@endif
    @csrf

    {{-- * nome piatto --}}
    <div class="col-8 my-4">
        <label class="form-label" for="name">Nome Piatto</label>
        <input type="text" name="name" id="name" class="form-control @error("name") is-invalid @enderror" value="{{ old("name") ?? $dish->name }}">
        @error("name")
            <div class="invalid-feedback"> {{ $message }} </div>
        @enderror
    </div>
    
    {{-- * descrizione --}}
    <div class="col-8 my-4">
        <label class="form-label" for="description">Descrizione</label>
        <input type="text" name="description" id="description" class="form-control @error("description") is-invalid @enderror" value="{{ old("description") ?? $dish->description }}">
        @error("description")
            <div class="invalid-feedback"> {{ $message }} </div>
        @enderror
    </div>
  
    {{-- * prezzo --}}
    <div class="col-8 my-4">
        <label class="form-label" for="price">Prezzo</label>
        <input type="float" name="price" id="price" class="form-control @error("price") is-invalid @enderror" value="{{ old("price") ?? $dish->price }}">
        @error("price")
            <div class="invalid-feedback"> {{ $message }} </div>
        @enderror
    </div>
  
    {{-- * immagine --}} 
        {{-- TODO: image! --}}
    <div class="col-8 my-4">
        <label class="form-label" for="phone_number">Immagine</label>
        <input type="text" name="image" id="image" class="form-control @error("image") is-invalid @enderror" value="{{ old("image") ?? $dish->image }}">
        @error("image")
            <div class="invalid-feedback"> {{ $message }} </div>
        @enderror
    </div>

    {{-- * disponibilità --}}
    <div class="col-8 my-4">
        <label class="form-label" for="available">Disponibilità</label>
        <input type="checkbox" id="available" name="available" @checked(old("available", $dish->available)) value="0">
    </div>

    {{-- * input invisibile per inviare l'id del ristorante insieme alle info inserite --}}
    <input class="d-none" type="text" value="{{auth()->user()->restaurant->id}}" name="restaurant_id" id="restaurant_id">

    {{-- * EDIT / CREATE submit --}}
    @if ($dish->id)
        <button type="submit" class="btn btn-primary">Modifica il tuo piatto</button>
    @else
        <button type="submit" class="btn btn-primary">Crea il tuo piatto</button>
    @endif

</form>

@endsection
  