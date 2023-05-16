@extends('layouts.app')

@section('content')

{{-- @if (auth()->user()->restaurant != null)
    ho un ristorante
@else
    non ho un ristorante sono povero
@endif --}}
    
{{-- * UPDATE / EDIT title --}}
@if ($restaurant->id)
    <h2 class="mt-5 mb-3">Modifica il ristorante</h2>
   @else
    <h2 class="mt-5 mb-3">Crea il tuo ristorante</h2>
@endif

@include('layouts.partials.errors')

{{-- * se il ristorante esiste già form edit / se il ristorante non esiste già form create --}}
@if ($restaurant->id)
    <form action="{{route('restaurants.update', $restaurant)}}" method="POST" class="row">
    @method('PUT')
@else
    <form action="{{route('restaurants.store')}}" method="POST" class="row">
@endif
    @csrf
    
    {{-- * nome ristorante --}}
    <div class="col-12 my-3">
        <label class="form-label" for="name">Nome Ristorante</label>
        <input type="text" name="name" id="name" class="form-control @error("name") is-invalid @enderror" value="{{ old("name") ?? $restaurant->name }}">
        @error("name")
            <div class="invalid-feedback"> {{ $message }} </div>
        @enderror
    </div>


    {{-- * indirizzo --}}
    <div class="col-12 my-3">
        <label class="form-label" for="address">Indirizzo</label>
        <input type="text" name="address" id="address" class="form-control @error("address") is-invalid @enderror" value="{{ old("address") ?? $restaurant->address }}">
        @error("address")
            <div class="invalid-feedback"> {{ $message }} </div>
        @enderror
    </div>

    <div class="row">
            {{-- * partita iva --}}
        <div class="col-4 my-3">
            <label class="form-label" for="vat">P. IVA</label>
            <input type="text" name="vat" id="vat" class="form-control @error("vat") is-invalid @enderror" value="{{ old("vat") ?? $restaurant->vat }}">
            @error("vat")
                <div class="invalid-feedback"> {{ $message }} </div>
            @enderror
        </div>
    
        {{-- * numero di telefono --}}
        <div class="col-4 my-3">
            <label class="form-label" for="phone_number">Numero di Tel.</label>
            <input type="text" name="phone_number" id="phone_number" class="form-control @error("phone_number") is-invalid @enderror" value="{{ old("phone_number") ?? $restaurant->phone_number }}">
            @error("phone_number")
                <div class="invalid-feedback"> {{ $message }} </div>
            @enderror
        </div>

    </div>
    

     {{-- * immagine --}} 
        {{-- TODO: image! --}}
    <div class="col-12 my-3">
        <label class="form-label" for="image">Immagine</label>
        <input type="text" name="image" id="image" class="form-control @error("image") is-invalid @enderror" value="{{ old("image") ?? $restaurant->image }}">
        @error("image")
            <div class="invalid-feedback"> {{ $message }} </div>
        @enderror
    </div>

    <div class="col-12 my-3">
        <label class="form-label" for="image">Tipo</label>
        @foreach ($types as $type)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{$type->id}}" id="check-{{$type->id}}" name="check-{{$type->id}}" 
                @if ($restaurant->containsType($type->id))
                    checked    
                @endif>
                <label class="form-check-label" for="check-{{$type->id}}">
                    {{$type->name}}
                </label>
              </div>
        @endforeach
    </div>

    <div class="col-12 mt-3">
        {{-- * EDIT / CREATE submit --}}
        @if ($restaurant->id)
            <button type="submit" class="btn btn-primary">Modifica il tuo ristorante</button>
        @else
            <button type="submit" class="btn btn-primary">Crea il tuo ristorante</button>
        @endif
    </div>

</form>

@endsection
  
      
 
  
    
        