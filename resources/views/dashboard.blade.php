@extends('layouts.app')

@section('content')

{{-- * IF 1 - se sei registrato --}}
@if (auth()->user())

    {{-- * IF 2 - se hai già un ristorante --}}
    @if (auth()->user()->restaurant)

        <div class="row">
            <div class="col-5 mt-5">
                {{-- * nome ristorante --}}
                <h1>{{auth()->user()->restaurant->name}}</h1>
                @foreach (auth()->user()->restaurant->types as $type)
                    <div class="text-secondary">{{$type->name}}</div>
                @endforeach
            </div>

            <div class="col-7 mt-5">
                {{-- * Modifica il tuo ristorante --}}
                <a type="button" class="btn btn-success border fw-bold" href="{{route('restaurants.edit', auth()->user()->restaurant)}}">Modifica il tuo ristorante</a>
                
                {{-- * Elimina il tuo ristorante --}}
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-modal">
                    Elimina ristorante  
                </button>
                @include('layouts.partials.deleteRestaurant')   
            </div>
        </div>
        

        

        <h2 class="mt-5">Menu:</h2>    
        <br>

        {{-- * Crea un piatto --}}
        <a href="{{route('dishes.create')}}">Crea Piatto</a>
        {{-- Cestino Piatti --}}
        <a type="button" class="btn btn-success border fw-bold" href="{{route('restaurants.trash', auth()->user()->restaurant->id)}}">Cestino piatti</a>
        
        {{-- * Tabella menù --}}
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
                    @foreach (auth()->user()->restaurant->dishesSortedByName(auth()->user()->restaurant->id) as $dish)    
                    <tr>
                        <th scope="row">{{$dish->name}}</th>
                        <td>{{$dish->description}}</td>
                        <td>{{$dish->price}}</td>
                        <td>{{$dish->available}}</td>
                        <td>
                            <a href="{{route('dishes.show', $dish)}}">Dettaglio</a>
                            <a href="{{route('dishes.edit', $dish)}}">Modifica</a>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $dish->id }}">
                                Elimina              
                              </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        @include('layouts.partials.deleteDishes')

    {{-- * ELSE 2 - se non hai già un ristorante --}}
    @else
        <a type="button" class="btn btn-success border fw-bold" href="{{route('restaurants.create')}}">Registra il tuo ristorante</a>
    @endif  

{{-- * ELSE 1 - se non sei registrato --}}
@else  
    Registrati
@endif

@endsection