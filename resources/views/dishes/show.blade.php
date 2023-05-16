
@extends('layouts.app')

@section('content')

    <div class="row mt-5">
        <div class="col-8 offset-2">
            <div class="card p-4">
                <div class="row basic-card-row">
                    <h1 class="card-title my-4">I dettagli del tuo piatto "{{$dish->name}}"</h1>
                    <div class="col-sm-12 col-md-6">
                        <img src="https://www.burgerking.it/site/assets/files/8495654/bacon_king_3_0-1.png" class="card-img-top img-card-dish" alt="dish_image">
                    </div>
                    <div class="col-sm-10 col-md-6 d-flex flex-column justify-content-between">
                        <h3 class="my-4">Prezzo: &euro; {{$dish->price}}</h3>
                        <h4 class="my-4">{{$dish->available == 1 ? 'Disponibile' : 'Non disponibile'}}</h4>
                        <p class="fw-bold my-4">
                            {{$dish->description}}
                        </p>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary align-self-end">Torna al tuo menu</a>
                    </div>
                </div>
            </div>
        </div>
                    
                

                        
    
        
        
        
        
        



    </div>

@endsection
    