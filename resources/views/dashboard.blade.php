@extends('layouts.app')

@section('content')


{{-- * IF 1 - se sei registrato --}}
@if (auth()->user())

    {{-- * IF 2 - se hai già un ristorante --}}
    @if (auth()->user()->restaurant)

        <div class="row">

            {{-- Restaurant info --}}
            <div class="col-12 col-md-4 mt-5 pt-3 bg-prova">
                {{-- * immagine --}}
                <div class="restaurant-img-cage">
                    <img src="{{auth()->user()->restaurant->image}}" alt="img">
                </div>
                {{-- * nome ristorante --}}
                <h1 class="fw-bold mt-3">{{auth()->user()->restaurant->name}}</h1>
                {{-- * owner --}}
                <h3>di {{auth()->user()->restaurant->owner->name}}</h3>
                {{-- * tipo ristorante --}}
                @foreach (auth()->user()->restaurant->types as $type)
                    <div class="text-secondary mb-4">{{$type->name}}</div>
                @endforeach
                {{-- * indirizzo --}}
                <p class="mt-2">{{auth()->user()->restaurant->address}}</p>
                {{-- * p.iva --}}
                <p>Partita Iva {{auth()->user()->restaurant->vat}}</p>
                {{-- * telefono --}}
                <p>Tel. {{auth()->user()->restaurant->phone_number}}</p>
            
                {{-- BUTTONS --}}
                <div class="mt-5">
                    {{-- * Modifica il tuo ristorante --}}
                    <a type="button" class="btn btn-success border my-md-3 me-2" href="{{route('restaurants.edit', auth()->user()->restaurant)}}"title="Modifica">Modifica ristorante</i></a>
                
                    {{-- * Elimina il tuo ristorante --}}
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-modal" rel="tooltip" title="Elimina">
                        Elimina ristorante            
                    </button>
                    {{-- * delete modal --}}
                    @include('layouts.partials.deleteRestaurant')   
                </div>
            </div>

            <hr class="d-md-none mt-5">

            {{-- Menù section --}}
            <div class="col-12 col-md-8">
                <div class="row">

                    <div class="col-12 d-flex justify-content-between">
                        {{-- * Titolo --}}
                        <h2 class="my-3 my-md-5">Menu:</h2>
    
                        {{-- * Buttons --}}
                        <div class="d-flex align-items-center">
                            {{-- * Crea un piatto --}}
                            <a href="{{route('dishes.create')}}" class="btn btn-success border" rel="tooltip" title="Crea">Crea Piatto</a>
                            {{-- * Cestino Piatti --}}
                            <a type="button" class="btn btn-primary border ms-2" href="{{route('restaurants.trash', auth()->user()->restaurant->id)}}" rel="tooltip" title="Cestino">Cestino piatti</a>
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
                                    <td class="d-none d-xl-table-cell">{{$dish->available}}</td>

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

    {{-- * ELSE 2 - se non hai già un ristorante --}}
    @else
        <div class="container my-5">

            <h1>Diventa nostro Partner!</h1>
            <p>Registrati e diventa un partner. Vendi di più, aumenta le tue entrate e gestisci la tua attività online insieme a noi. Il tuo percorso di digitalizzazione inizia qui.</p>
            <p>Prepara i documenti della tua attività e clicca il pulsante qui sotto:</p>
            <a type="button" class="btn btn-success border fw-bold" href="{{route('restaurants.create')}}">Registra il tuo ristorante</a>

        </div>
    @endif  

    {{-- * ELSE 1 - se non sei registrato --}}
    @else  
        <h2 class="my-5">Registrati al sito per usufruire dei servizi!</h2>
    @endif

@endsection