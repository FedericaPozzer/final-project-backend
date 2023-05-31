@extends('layouts.app')

@section('content')

{{-- * IF 1 - se sei registrato --}}
@if (auth()->user())

{{-- * IF 2 - se hai già un ristorante --}}
@if (auth()->user()->restaurant)

<div class="row">
    
    {{-- Restaurant info --}}
    <div class="col-12 col-md-4 bg-prova">
        {{-- * immagine --}}
        <div class="restaurant-img-cage">
            <img src="{{'http://127.0.0.1:8000/' . auth()->user()->restaurant->image}}" alt="img">
            {{-- BUTTONS --}}
            <div class="buttons">
                {{-- * Modifica il tuo ristorante --}}
                <a type="button" class="btn btn-success" href="{{route('restaurants.edit', auth()->user()->restaurant)}}"title="Modifica">
                    <i class="bi bi-pencil-square"></i>
                </i></a>
            
                {{-- * Elimina il tuo ristorante --}}
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-modal-restaurant" rel="tooltip" title="Elimina">
                    <i class="bi bi-trash"></i>            
                </button>
                {{-- * delete modal --}}
                @include('layouts.partials.deleteRestaurant')   
            </div>
        </div>
        {{-- * nome ristorante --}}
        <h1>
            {{auth()->user()->restaurant->name}}
                </h1>
                {{-- * owner --}}
                {{-- * tipo ristorante --}}
                <div class="d-flex flex-wrap">
                    @foreach (auth()->user()->restaurant->types as $type)
                        <div class="category me-2 badge">{{$type->name}}</div>
                    @endforeach
                </div>
                {{-- * indirizzo --}}
                <div class="items d-flex flex-wrap gap-3">
                    <div class="item">
                        <i class="bi bi-signpost-split"></i>
                        <p>{{auth()->user()->restaurant->address}}</p>
                    </div>
                    {{-- * p.iva --}}
                    <div class="item">
                        <i class="bi bi-info-circle"></i>
                        <p>{{auth()->user()->restaurant->vat}}</p>
                    </div>
                    {{-- * telefono --}}
                    <div class="item">
                        <i class="bi bi-phone"></i>
                        <p>{{auth()->user()->restaurant->phone_number}}</p>
                    </div>
                </div>

            
            </div>

            <hr class="d-md-none mt-5">

            {{-- Menù section --}}
            <div class="col-12 col-md-8">
                <div class="row">

                    <div class="col-12 d-flex justify-content-between">
                        {{-- * Titolo --}}
                        <h2 class="my-2">Il mio menu:</h2>
    
                        {{-- * Buttons --}}
                        <div class="d-flex align-items-center">
                            {{-- * Crea un piatto --}}
                            <a href="{{route('dishes.create')}}" class="btn btn-success border" rel="tooltip" title="Crea"><i class="bi bi-plus-square"></i> Aggiungi Piatto</a>
                            {{-- * Cestino Piatti --}}
                            <a type="button" class="btn btn-primary border ms-2" href="{{route('restaurants.trash', auth()->user()->restaurant->id)}}" rel="tooltip" title="Cestino"> <i class="bi bi-recycle"></i>
                                Cestino piatti</a>
                        </div>
                    </div>
                    
                    
                    {{-- * Tabella Menù --}}
                    <div class="col-12 dashboard-menu-height">
                        <table class="table table-striped">

                            <thead class="fs-4 thead">
                                <tr>
                                    <th scope="col">Nome Piatto</th>
                                    <th scope="col" class="d-none d-xl-table-cell">Descrizione</th>
                                    <th scope="col">Prezzo</th>
                                    <th scope="col" class="d-none d-xxl-table-cell">Disponibilità</th>
                                    <th scope="col">Azioni</th>
                                </tr>
                            </thead>

                            <tbody class="tbody">
                                @foreach (auth()->user()->restaurant->dishesSortedByName(auth()->user()->restaurant->id) as $dish)    
                                <tr>
                                    {{-- * nome piatto --}}
                                    <th scope="row" class="d-none d-xxl-table-cell">{{$dish->name}}</th>
                                        {{-- fino a XXL, se il piatto è disponibile il nome è blu, se non è disponibile il nome è nero --}}
                                    @if(($dish->available) == 1)
                                    <th scope="row" class="text-primary d-xxl-none">{{$dish->name}}</th>
                                    @else
    	                            <th scope="row" class="d-xxl-none">{{$dish->name}}</th>
                                    @endif

                                    {{-- * descrizione (abstract) --}}
                                    <td class="d-none d-xxl-table-cell">
                                        {{$dish->getAbstract()}}
                                    </td>

                                    {{-- * prezzo --}}
                                    <td>&euro; {{$dish->price}}</td>

                                    {{-- * disponibilità --}}
                                    {{-- <td class="d-none d-xl-table-cell">{{$dish->available}}</td> --}}
                                    
                                        <td class="d-none d-xl-table-cell">{{$dish->available == 1 ? 'Disponibile' : 'Non disponibile'}}</td>
                                    

                                    {{-- * azioni - vedi, modifica, elimina --}}
                                    <td class="d-flex justify-content-between align-items-center">
                                        <a href="{{route('dishes.show', $dish)}}" rel="tooltip" title="Visualizza"><i class="bi bi-eye"></i></a>
                                        
                                        <a href="{{route('dishes.edit', $dish)}}" rel="tooltip" title="Modifica"><i class="bi bi-pencil"></i></a>

                                        <button type="button" class="text-danger border-0 bg-transparent" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $dish->id }}" rel="tooltip" title="Elimina">
                                            <i class="bi bi-trash"></i>            
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>

                        {{-- {{ $dishes->links() }} --}}
                    </div>
                    
                </div>
            </div>

        </div>

        {{-- * la modal per eliminare i piatti --}}
        @include('layouts.partials.deleteDishes')
        @include('layouts.partials.deleteRestaurant')
    {{-- * ELSE 2 - se non hai già un ristorante --}}
    @else
        <div class="container my-5">

            <h1>Registra il tuo ristorante!</h1>
            
            <p>Prepara i documenti della tua attività e clicca il pulsante qui sotto:</p>
            <a type="button" class="btn btn-success border fw-bold" href="{{route('restaurants.create')}}">Registra il tuo ristorante</a>

        </div>
    @endif  

    {{-- * ELSE 1 - se non sei registrato --}}
    @else  
        <h2 class="my-5">Registrati al sito per usufruire dei servizi!</h2>
    @endif

    
@endsection