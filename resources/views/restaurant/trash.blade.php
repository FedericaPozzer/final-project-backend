@extends('layouts.app')

@section('content')
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
                    @foreach ($dishes as $dish)    
                    <tr>
                        <th scope="row">{{$dish->name}}</th>
                        <td>{{$dish->description}}</td>
                        <td>{{$dish->price}}</td>
                        <td>{{$dish->available}}</td>
                        <td>
                            <a class="" href="{{ route('dishes.restore', $dish->id) }}">
                                Restore
                            </a>
                            <a class="" href="{{ route('dishes.delete', $dish->id) }}">
                                Delete
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>



@endsection