@extends('layouts.app')

@section('content')

    <div class="container my-5">


        <section class="welcome my-5">

            <div class="row">
                <div class="col-5">
                    <img src="logo.png" alt="ciao" style="width: 500px">
                </div>

                <div class="col-7">

                    <h3 class="my-3"> Benvenuto/a in Deliveboo! </h3>
                
                    <p>Stai programmando codice da ore e ore e ti sei scordato di cucinarti il pasto? Tranquillo! Ci pensiamo noi di Deliveboo, il servizio di consegna a domicilio pensata apposta per i Booleaners, così potrai spendere altre centinaia di ore a debuggare il tuo codice che di sicuro avrà un errore di sintassi!</p>

                </div>
            </div>

        </section>


        <section class="my-5">

            <h4>Le nostre proposte:</h4>
    
            <ul>
                <li>Italiano</li>
                <li>Cinese</li>
                <li>Messicano</li>
                <li>Giapponese</li>
                <li>Indiano</li>
            </ul>

        </section>

        <section class="my-5">

            <h4>I piatti più richiesti</h4>
    
            <ul>
                <li>Pizza Margherita</li>
                <li>Panino Vegano</li>
                <li>Tiramisu</li>
                <li>Hot Dog</li>
                <li>Hamburger</li>
            </ul>

        </section>




    </div>

@endsection