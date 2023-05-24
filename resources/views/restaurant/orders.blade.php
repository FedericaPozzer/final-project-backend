@extends('layouts.app')

@section('content')

@if (auth()->user()->restaurant->orders->first())

<br>
<div class="mt-2">
    <h2>Ordini in preparazione</h2>
</div>
<div class="row row-cols-1 row-cols-lg-2">
    
@foreach (auth()->user()->restaurant->orders as $order)
@if ($order->shipped != 1)
<div class="col">
        
    <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title">ORDINE #{{$order->id}}</h5>
          <h6 class="card-subtitle my-2 text-muted">Dati cliente:</h6>
          <div class="card-text">
              <table>
                  <tbody>
                      <tr>
                          <th>Nome:</th>
                          <td>{{$order->guest_name}}</td>
                      </tr>
                      <tr>
                          <th>Indirizzo:</th>
                          <td>{{$order->guest_address}}</td>
                      </tr>
                      <tr>
                          <th>Email:</th>
                          <td>{{$order->guest_mail}}</td>
                      </tr>
                  </tbody>
              </table>

          </div>
          <h6 class="card-subtitle my-2 text-muted">Riepilogo Ordine</h6>
          <div class="card-text">
              <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Articolo</th>
                      <th scope="col">Quantità</th>
                      <th scope="col">Prezzo</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($order->dishes as $dish)
                    <tr>
                      <th scope="row">
                          {{$dish->name}}
                      </th>
                      <td>
                          {{$dish->pivot->quantity}}
                      </td>
                      <td>
                          @php
                          $price = 0;
                          for($i = 0; $i < $dish->pivot->quantity; $i++) {
                              $price += $dish->price;
                          }
                          @endphp
                          {{$price}}
                          ({{$dish->price}})
                      </td>
                      </tr>
                  @endforeach
                  <tr>
                      <td></td>
                      <td></td>
                      <th scope="row">
                          {{$order->totalPrice()}} &euro;
                      </th>
                  </tr>
          
                  </tbody>
                </table>
          </div>
        </div>
    </div>
    <br>
    <br>
    
</div>
      @endif
    @endforeach
</div>

    <h2>Ordini finiti</h2>
    <div class="row row-cols-1 row-cols-lg-2">
        
    @foreach (auth()->user()->restaurant->orders as $order)
    @if ($order->shipped != 0)
    <div class="col">
            
        <div class="card h-100">
            <div class="card-body">
              <h5 class="card-title">ORDINE #{{$order->id}}</h5>
              <h6 class="card-subtitle my-2 text-muted">Dati cliente:</h6>
              <div class="card-text">
                  <table>
                      <tbody>
                          <tr>
                              <th>Nome:</th>
                              <td>{{$order->guest_name}}</td>
                          </tr>
                          <tr>
                              <th>Indirizzo:</th>
                              <td>{{$order->guest_address}}</td>
                          </tr>
                          <tr>
                              <th>Email:</th>
                              <td>{{$order->guest_mail}}</td>
                          </tr>
                      </tbody>
                  </table>
    
              </div>
              <h6 class="card-subtitle my-2 text-muted">Riepilogo Ordine</h6>
              <div class="card-text">
                  <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Articolo</th>
                          <th scope="col">Quantità</th>
                          <th scope="col">Prezzo</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($order->dishes as $dish)
                        <tr>
                          <th scope="row">
                              {{$dish->name}}
                          </th>
                          <td>
                              {{$dish->pivot->quantity}}
                          </td>
                          <td>
                              @php
                              $price = 0;
                              for($i = 0; $i < $dish->pivot->quantity; $i++) {
                                  $price += $dish->price;
                              }
                              @endphp
                              {{$price}}
                              ({{$dish->price}})
                          </td>
                          </tr>
                      @endforeach
                      <tr>
                          <td></td>
                          <td></td>
                          <th scope="row">
                              {{$order->totalPrice()}} &euro;
                          </th>
                      </tr>
              
                      </tbody>
                    </table>
              </div>
            </div>
        </div>
        <br>
        <br>
        
    </div>
          @endif
        @endforeach
    
@else
      Non ci sono ordini.
@endif

      
  

@endsection