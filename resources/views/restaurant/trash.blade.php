@extends('layouts.app')

@section('content')
 <div class="">

    <div class="row">
        <div class="col-3">
            <h2 class="mt-5 mb-3 d-flex text-success">Cestino <i class="bi bi-trash"></i></h2>
        </div>
    </div>

    <table class="table table-striped">

        <thead>
            <tr>
                <th scope="col">Nome Piatto</th>
                <th scope="col" class="d-none d-lg-table-cell">Descrizione</th>
                <th scope="col">Prezzo</th>
                <th scope="col" class="d-none d-lg-table-cell">Disponibilità</th>
                <th scope="col">Azioni</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($dishes as $dish)    
            <tr>
                <th scope="row">{{$dish->name}}</th>
                <td class="d-none d-md-table-cell">{{$dish->description}}</td>
                <td> &euro; {{$dish->price}}</td>
                <td class="d-none d-md-table-cell">{{$dish->available}}</td>
                <td>
                    <a class="text-success me-2" href="{{ route('dishes.restore', $dish->id) }}">
                        Ripristina
                    </a>
                    <a class="text-success" href="{{ route('dishes.delete', $dish->id) }}">
                        Elimina
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>



@endsection