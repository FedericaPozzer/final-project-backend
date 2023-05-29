@extends('layouts.app')

@section('content')
 <div class="">

    <div class="row">
        <div class="col-3">
            <h2 class="mt-5 mb-3 d-flex text-success">Cestino <i class="bi bi-trash"></i></h2>
        </div>
    </div>

    <div class="dashboard-menu-height">
    <table class="table table-striped">

        <thead class="fs-4 thead">
            <tr>
                <th scope="col">Nome Piatto</th>
                <th scope="col" class="d-none d-md-table-cell">Descrizione</th>
                <th scope="col">Prezzo</th>
                {{-- <th scope="col" class="d-none d-lg-table-cell">Disponibilità</th> --}}
                <th scope="col">Azioni</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($dishes as $dish)    
            <tr>
                <th scope="row">{{$dish->name}}</th>
                <td class="d-none d-md-table-cell">{{$dish->description}}</td>
                <td> &euro; {{$dish->price}}</td>
                {{-- <td class="d-none d-md-table-cell">{{$dish->available == 1 ? 'Disponibile' : 'Non disponibile'}}</td> --}}
                <td>
                    <button class="bi bi-trash text-danger trash-stile-delete border-0 bg-transparent fs-4 {{route('restaurants.trash')}}?sort=" data-bs-toggle="modal" data-bs-target="#delete-modal-{{$dish->id}}"></button>

                    <button class="bi bi-arrow-up-left-square trash-stile-restore text-success border-0 bg-transparent fs-4 {{route('restaurants.trash')}}?sort=" data-bs-toggle="modal" data-bs-target="#restore-modal-{{$dish->id}}"></button>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
    </div>
</div>

@foreach ($dishes as $dish)
    
{{-- modale cancellazione --}}

<div class="modal fade" id="delete-modal-{{$dish->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
              <h1 class="modal-title fs-4  fw-bold" id="exampleModalLabel">Attenzione</h1>
              
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body fs-2 fw-bold">
                Sei sicuro di voler cancellare definitivamente il piatto {{$dish->name}}?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info text-light border fw-bold" data-bs-dismiss="modal">Chiudi</button>
                <form class="" action="{{ route('dishes.force-delete', $dish )}}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger border fw-bold">Elimina</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- modale ripristino --}}
  <div class="modal fade" id="restore-modal-{{$dish->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-4  fw-bold" id="exampleModalLabel">Attenzione</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body fs-2 fw-bold">
          Vuoi ripristinare il piatto {{$dish->name}}?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info text-light border fw-bold" data-bs-dismiss="modal">Chiudi</button>
          <form class="" action="{{ route('dishes.restore',$dish)}}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-success border fw-bold">Ripristina</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  @endforeach
@endsection
  
  
  
