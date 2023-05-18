@extends('layouts.app')

@section('content')

{{-- @php 
$restaurant = auth()->user()->restaurant;
@endphp --}}

{{-- * if che controlla che il ristoratore possa vedere solo le sue cose --}}
{{-- @if(auth()->user()->owner->id == auth()->user()->id) --}}



{{-- * UPDATE / EDIT title --}}
@if ($dish->id)
    <h2 class="mt-5 mb-3">Modifica il piatto</h2>
@else
    <h2 class="mt-5 mb-3">Crea il tuo piatto</h2>
@endif

@include('layouts.partials.errors')

{{-- * se il piatto esiste già form edit / se il piatto non esiste già form create --}}
@if ($dish->id)
    <form action="{{route('dishes.update', $dish)}}" method="POST" enctype="multipart/form-data" class="row">
    @method('PUT')
@else
    <form action="{{route('dishes.store')}}" method="POST" enctype="multipart/form-data" class="row">
@endif
    @csrf

    {{-- * nome piatto --}}
    <div class="col-8 my-4">
        <label class="form-label" for="name">Nome Piatto</label>
        <input type="text" name="name" id="name" placeholder="Pizza" class="form-control @error("name") is-invalid @enderror" value="{{ old("name") ?? $dish->name }}">
        @error("name")
            <div class="invalid-feedback"> {{ $message }} </div>
        @enderror
    </div>
    
    {{-- * descrizione --}}
    <div class="col-8 my-4">
        <label class="form-label" for="description">Descrizione</label>
        <textarea type="text" name="description" id="description" placeholder="Ingredienti: ..." class="form-control @error("description") is-invalid @enderror" rows="5">{{ old("description") ?? $dish->description }} </textarea>
        @error("description")
            <div class="invalid-feedback"> {{ $message }} </div>
        @enderror
    </div>
  
    {{-- * prezzo --}}
    <div class="col-8 my-4">
        <label class="form-label" for="price">Prezzo</label>
        <input type=number step=0.01 name="price" id="price" placeholder="quanto costa?" class="form-control @error("price") is-invalid @enderror" value="{{ old("price") ?? $dish->price }}">
        @error("price")
            <div class="invalid-feedback"> {{ $message }} </div>
        @enderror
    </div>
  
    {{-- * immagine --}} 
        {{-- TODO: image! --}}
        <div class="col-12 my-2">
            <label class="form-label" for="image" >Immagine</label>
        </div>
        {{-- @error("image")
            <div class="invalid-feedback"> {{ $message }} </div>
        @enderror --}}
    
        @php
            $default_images = ['restaurant_images/1.jpg', 'restaurant_images/3.jpg', 'restaurant_images/4.jpg', 'restaurant_images/5.jpg']
        @endphp

        <div class="row gap-2">

            <div class="col d-flex align-items-center justify-content-center ratio ratio-4x3 imageBox
                @if ($dish->image != null)
                    choosen
                @endif
                "onclick="uploadImage()" id="image_0">
            
                <div class="d-flex h-max w-max justify-content-center align-items-center uploadImage">
                    <i class="bi bi-cloud-upload"></i>
                </div>
            
                <img id="preview" 
                @if ($dish->image != null)
                src = '{{$dish->image}}'
                @else
                src = '#' style = 'display:none;'
                @endif 
                alt="your image" class="img-fluid object-fit-cover"/>
            </div>
        
            @foreach ($default_images as $key=>$default_image)
            <div class="col ratio ratio-4x3 imageBox" onclick="chooseImage( {{$key + 1}}, '{{$default_image}}')" id="image_{{$key + 1}}">
                <img class="" src="{{ asset($default_image) }}" alt="description of myimage">
            </div>
            @endforeach

        </div>


        <input type="file" class="d-none" name="image" @error('image') is-invalid @enderror id="selectImage" autocomplete="false">
        <input type="text" name="defaultImage" id="selectDefaultImage" autocomplete="false" class="d-none" value="{{ old("image") ?? $dish->image }}">
    
        <script>
            let selectedImage = 0;
            let selectedBox = document.getElementById('image_' + selectedImage)
            
            function chooseImage(key, img_path){
                let input = document.getElementById('selectDefaultImage');
                console.log(key)
                selectedImage = key
                selectedBox.classList.remove('choosen')
                selectedBox = document.getElementById('image_' + selectedImage)
                selectedBox.classList.add('choosen')
            
                input.value = img_path
            
                document.getElementById('selectImage').value = null
            }

            function uploadImage(){           
                document.getElementById('selectDefaultImage').value = null
                selectedBox.classList.remove('choosen')
                selectedBox = document.getElementById('image_0')
                selectedBox.classList.add('choosen')

                let input = document.getElementById('selectImage');

                input.click()
            }
        </script>

    @error('image')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror

    <script>
        selectImage.onchange = evt => {
            preview = document.getElementById('preview');
            preview.style.display = 'block';
            const [file] = selectImage.files
            if (file) {
                preview.src = URL.createObjectURL(file)
            }
        }
    </script>

    {{-- * disponibilità --}}
    <div class="col-8 my-4">
        <label class="form-label" for="available">Disponibilità</label>
        <input type="checkbox" id="available" name="available" @checked(old("available", $dish->available)) value="0">
    </div>

    {{-- * input invisibile per inviare l'id del ristorante insieme alle info inserite --}}
    <input class="d-none" type="text" value="{{auth()->user()->restaurant->id}}" name="restaurant_id" id="restaurant_id">

    <div class="col-12 mt-3">
        {{-- * EDIT / CREATE submit --}}
        @if ($dish->id)
            <button type="submit" class="btn btn-primary">Modifica il tuo piatto</button>
        @else
            <button type="submit" class="btn btn-primary">Crea il tuo piatto</button>
        @endif
    </div>

</form>



{{-- @else
<h2 class="my-5">Non sei autorizzato a visualizzare ciò che cerchi!</h2>
@endif --}}

@endsection
  