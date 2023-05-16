@extends('layouts.app')

@section('content')


{{-- * IF 1 - se sei registrato --}}
@if (auth()->user())

    {{-- * IF 2 - se hai già un ristorante --}}
    @if (auth()->user()->restaurant)

        <img src="{{auth()->user()->restaurant->image}}" alt="">

        <div class="row">
            <div class="col-8 mt-5">
                {{-- * nome ristorante --}}
                <h1 class="fw-bold">{{auth()->user()->restaurant->name}}</h1>
                @foreach (auth()->user()->restaurant->types as $type)
                    <div class="text-secondary">{{$type->name}}</div>
                @endforeach
            </div>

            <div class="col-4 mt-5 d-flex align-items-center justify-content-end">
                {{-- * Modifica il tuo ristorante --}}
                <a type="button" class="btn btn-success border" href="{{route('restaurants.edit', auth()->user()->restaurant)}}"title="Modifica"><i class="bi bi-pencil"></i></a>
                
                {{-- * Elimina il tuo ristorante --}}
                <button type="button" class="btn btn-danger ms-2" data-bs-toggle="modal" data-bs-target="#delete-modal" rel="tooltip" title="Elimina">
                    <i class="bi bi-trash"></i>            
                </button>
                {{-- * delete modal --}}
                @include('layouts.partials.deleteRestaurant')   
            </div>
        </div>
        
        <hr>

        <div class="row">
            <div class="col-3">
                <h2 class="my-3">Menu:</h2>
            </div>

            <div class="col-9 d-flex justify-content-end align-items-center">
                {{-- * Crea un piatto --}}
                <a href="{{route('dishes.create')}}" class="btn btn-success border" rel="tooltip" title="Crea">Crea Piatto</a>
                {{-- * Cestino Piatti --}}
                <a type="button" class="btn btn-primary border ms-2" href="{{route('restaurants.trash', auth()->user()->restaurant->id)}}" rel="tooltip" title="Cestino">Cestino piatti</a>
            </div>
        </div>
        
        
        {{-- * Tabella menù --}}
        <div class="dashboard-menu-height">
            <table class="table table-striped">

                <thead class="fs-4 thead">
                    <tr>
                        <th scope="col">Nome Piatto</th>
                        <th scope="col" class="d-none d-lg-table-cell">Descrizione</th>
                        <th scope="col">Prezzo</th>
                        <th scope="col" class="d-none d-md-table-cell">Disponibilità</th>
                        <th scope="col">Azioni</th>
                    </tr>
                </thead>

                <tbody class="tbody">
                    @foreach (auth()->user()->restaurant->dishesSortedByName(auth()->user()->restaurant->id) as $dish)    
                    <tr>
                        {{-- * nome piatto --}}
                        <th scope="row" class="d-none d-md-table-cell">{{$dish->name}}</th>
                            {{-- fino a MD, se il piatto è disponibile il nome è blu, se non è disponibile il nome è nero --}}
                        @if(($dish->available) == 1)
                        <th scope="row" class="text-primary d-md-none">{{$dish->name}}</th>
                        @else
    	                <th scope="row" class="d-md-none">{{$dish->name}}</th>
                        @endif

                        {{-- * descrizione (abstract) --}}
                        <td class="d-none d-lg-table-cell">
                            {{$dish->getAbstract()}}
                        </td>

                        {{-- * prezzo --}}
                        <td>&euro; {{$dish->price}}</td>

                        {{-- * disponibilità --}}
                        <td class="d-none d-md-table-cell">{{$dish->available}}</td>

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