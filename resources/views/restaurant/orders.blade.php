@extends('layouts.app')

@section('content')

@if (auth()->user()->restaurant->orders->first())

<br>
<h2>Ordini da fare</h2> <br><br>
    @foreach (auth()->user()->restaurant->orders as $order)
    @if ($order->shipped == 0)
        

    <div class="d-flex justify-content-between align-items-center">
        <h2>
            Ordine ID {{$order->id}} <br>
        </h2>
        <a href="{{route('order.shipped', $order->id)}}">Finito!</a>
    </div>
    <br>
    Dati cliente:
    <br>
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
                {{$order->totalPrice()}}
            </th>
        </tr>

        </tbody>
      </table>
      @endif
    @endforeach

    <br>
    <h2>Ordini finiti</h2> <br><br>
    @foreach (auth()->user()->restaurant->orders as $order)
    @if ($order->shipped != 0)
        

    <div class="d-flex justify-content-between align-items-center">
        <h2>
            Ordine ID {{$order->id}} <br>
        </h2>
    </div>
    <br>
    Dati cliente:
    <br>
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
                {{$order->totalPrice()}}
            </th>
        </tr>

        </tbody>
      </table>
      @endif
    @endforeach

@else
      Non ci sono ordini.
@endif

      
  

@endsection