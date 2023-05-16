
@extends('layouts.app')

@section('content')

@if (session('message'))
<div class="alert alert-info">
    {{ session('message') }}
</div>
@endif
    <div class="row">
        <div class="col-10">
            <div class="card">
                <h3>Dettaglio piatto - show</h3>  
                <p>
                    {{$dish->name}}
                </p>
                <p>
                    {{$dish->price}}
                </p>
                <p>
                    {{$dish->description}}
                </p>
            </div>
        </div>




    </div>

@endsection
    