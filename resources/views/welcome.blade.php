@extends('layouts.app')

@section('content')

    <div class="container my-5">


        <section class="welcome my-5">

            <div class="row">
                <div class="col-12 col-md-5 mb-5 m-auto">
                    <img src="logo.png" alt="logo" style="width: 100%">
                </div>

                <div class="col-12">

                    <h3 class="my-3"> Benvenuto/a nell'area Partner! </h3>
                
                    <p>Accedi per visualizzare e gestire il tuo ristorante, oppure, se non sei ancora iscritto, iscriviti per registrare il tuo ristorante e iniziare a far decollare la tua attività!</p>
                    <p>Vendi di più, aumenta le tue entrate e gestisci la tua attività online insieme a noi. Il tuo percorso di digitalizzazione inizia qui.</p>
                    <button class="btn btn-primary btn-secondary-custom">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </button>

                    <button class="btn btn-secondary btn-grey-custom">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </button>
                </div>
            </div>

        </section>





    </div>

@endsection