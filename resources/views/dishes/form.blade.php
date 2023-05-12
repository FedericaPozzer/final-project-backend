Creazione e modifica ristorante
@extends('layouts.app')
@section('content')

{{-- @if (auth()->user()->restaurant != null)
    ho un ristorante
@else
    non ho un ristorante sono povero
@endif --}}
    
@if ($dish->id)
    <h2>modifica il piatto</h2>

   @else

    <h2>crea il tuo piatto</h2>
      
@endif
  @if ($dish->id)
  <form action="{{route('dishes.update', $dish)}}" method="POST" class="row">
    @method('PUT')
    
  @else
  <form action="{{route('dishes.store')}}" method="POST" class="row">
  
  @endif
  @csrf
  <div class="col-8 my-4">
    <label class="form-label" for="name">Nome Piatto</label>
    <input type="text" name="name" id="name" class="form-control">
  </div>
    
  <div class="col-8 my-4">
    <label class="form-label" for="description">Descrizione</label>
    <input type="text" name="description" id="description" class="form-control">
  </div>
  
  <div class="col-8 my-4">
    <label class="form-label" for="price">Prezzo</label>
    <input type="float" name="price" id="price" class="form-control">
  </div>
  
  <div class="col-8 my-4">
    <label class="form-label" for="phone_number">Immagine</label>
    <input type="text" name="image" id="image" class="form-control">
  </div>
  <div class="col-8 my-4">
    <label class="form-label" for="available">Disponibilità</label>
    <input type="checkbox" id="available" name="available" value="0">
  </div>


  <input class="d-none" type="text" value="{{auth()->user()->restaurant->id}}" name="restaurant_id" id="restaurant_id">

@if ($dish->id)
      <button type="submit" class="btn btn-primary">Modifica il tuo piatto</button>
      @else
      <button type="submit" class="btn btn-primary">Crea il tuo piatto</button>
      
      @endif
  </form>
  @endsection
  