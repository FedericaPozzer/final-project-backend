Creazione e modifica ristorante
@extends('layouts.app')

@section('content')

{{-- @if (auth()->user()->restaurant != null)
    ho un ristorante
@else
    non ho un ristorante sono povero
@endif --}}
    
{{-- * UPDATE / EDIT title --}}
@if ($restaurant->id)
    <h2>modifica il ristorante</h2>
   @else
    <h2>crea il tuo ristorante</h2>
@endif

{{-- * se il ristorante esiste già form edit / se il ristorante non esiste già form create --}}
@if ($restaurant->id)
    <form action="{{route('restaurants.update', $restaurant)}}" method="POST" class="row">
    @method('PUT')
@else
    <form action="{{route('restaurants.store')}}" method="POST" class="row">
@endif
    @csrf
    
    {{-- * nome ristorante --}}
    <div class="col-8 my-4">
        <label class="form-label" for="name">Nome Ristorante</label>
        <input type="text" name="name" id="name" class="form-control">
    </div>
    
    {{-- * indirizzo --}}
    <div class="col-8 my-4">
        <label class="form-label" for="address">Indirizzo</label>
        <input type="text" name="address" id="address" class="form-control">
    </div>
    
    {{-- * partita iva --}}
    <div class="col-8 my-4">
        <label class="form-label" for="vat">P. IVA</label>
        <input type="text" name="vat" id="vat" class="form-control">
    </div>
    
    {{-- * numero di telefono --}}
    <div class="col-8 my-4">
        <label class="form-label" for="phone_number">Numero di Tel.</label>
        <input type="text" name="phone_number" id="phone_number" class="form-control">
    </div>

    {{-- * EDIT / CREATE submit --}}
    @if ($restaurant->id)
        <button type="submit" class="btn btn-primary">Modifica il tuo ristorante</button>
    @else
        <button type="submit" class="btn btn-primary">Crea il tuo ristorante</button>
    @endif

</form>

@endsection
  
      
 
  
    
        