@extends('layouts.app')
@section('content')

@if (auth()->user())
@if (auth()->user()->restaurant)
    <h1>{{auth()->user()->restaurant->name}}</h1>
    <a type="button" class="btn btn-success border fw-bold" href="{{route('restaurants.edit', auth()->user()->restaurant)}}">Modifica il tuo ristorante</a>
    <a href="{{route('dishes.create')}}">Crea Piatto</a>

    <div class="col-12">
        <table class="table table-striped">
            <thead>
                <tr>
                  <th scope="col">Nome Piatto</th>
                  <th scope="col">Descrizione</th>
                  <th scope="col">Prezzo</th>
                  <th scope="col">Disponibilità</th>
                  <th scope="col">Azioni</th>
                </tr>
              </thead>
              <tbody>
                @foreach (auth()->user()->restaurant->dishes as $dish)    
                <tr>
                  <th scope="row">{{$dish->name}}</th>
                  <td>{{$dish->description}}</td>
                  <td>{{$dish->price}}</td>
                  <td>{{$dish->available}}</td>
                    <td>
                        <a href="{{route('dishes.show', $dish)}}">Dettaglio</a>
                        <a href="{{route('dishes.edit', $dish)}}">Modifica</a>
                    </td>
                </tr>
                @endforeach
              </tbody>
            
        </table>
    </div>
@else
    <a type="button" class="btn btn-success border fw-bold" href="{{route('restaurants.create')}}">Registra il tuo ristorante</a>
@endif  
@else  
registrati
@endif

@endsection