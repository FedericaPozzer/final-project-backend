Creazione e modifica ristiorante
@extends('layouts.app')
@section('content')
    
@if (isset($restaurant))
    <h2>modifica il ristorante</h2>

   @else

    <h2>crea il tuo ristorante</h2>
      
  @endif
  @if (isset($restaurant))
  <form action="{{route('restaurants.update', $restaurant)}}" method="POST" class="row"></form>
  @method('PUT')
  
  @else
  <form action="{{route('restaurants.store')}}" method="POST" class="row"></form>
  
  @endif
  @csrf
  <div class="col-8 my-4">
    <label class="form-label" for="name">Nome Ristorante</label>
    <input type="text" name="name" id="name" class="form-control">
  </div>
    
  <div class="col-8 my-4">
    <label class="form-label" for="address">Indirizzo</label>
    <input type="text" name="address" id="address" class="form-control">
  </div>

  <div class="col-8 my-4">
    <label class="form-label" for="vat">P. IVA</label>
    <input type="text" name="vat" id="vat" class="form-control">
  </div>

  <div class="col-8 my-4">
    <label class="form-label" for="phone_number">Numero di Tel.</label>
    <input type="text" name="phone_number" id="phone_number" class="form-control">
  </div>

  @if (isset($restaurant))
      <button type="submit" class="btn btn-primary">Modifica il tuo ristorante</button>
      @else
      <button type="submit" class="btn btn-primary">Crea il tuo ristorante</button>

  @endif
  @endsection
  
      
 
  
    
        