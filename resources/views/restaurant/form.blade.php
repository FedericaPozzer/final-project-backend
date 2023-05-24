@extends('layouts.app')

@section('content')
 
{{-- * if che controlla che il ristoratore possa vedere solo le sue cose --}}
{{-- @if(isset($restaurant) && $restaurant->owner->id == auth()->user()->id)
 --}}


{{-- * UPDATE / EDIT title --}}
@if ($restaurant->id)
    <h2 class="mt-3 mb-3">Modifica il ristorante</h2>
   @else
    <h2 class="mt-3 mb-3">Crea il tuo ristorante</h2>
@endif

@include('layouts.partials.errors')

{{-- Validazione Client Side --}}


{{-- * se il ristorante esiste già form edit / se il ristorante non esiste già form create --}}
@if ($restaurant->id)
{{ Aire::open()
    ->route('restaurants.update', $restaurant)
    ->rules([
        'name' => 'required|max:20',
        'address' => 'required|min:3',
        'vat' => 'required|digits:11',
        'phone_number' => 'required|digits:10'
    
    ])
    ->messages([
        'required' => 'Il campo è richiesto.',
        'min' => 'Numero insufficiente di caratteri.',
        'max' => 'Hai inserito troppi caratteri.',
        'digits' => 'Inserisci il numero esatto di caratteri.'
      ])
    }}
@else
{{ Aire::open()
    ->route('restaurants.store', $restaurant)
    ->rules([
        'name' => 'required|max:20',
        'address' => 'required|min:3',
        'vat' => 'required|digits:11',
        'phone_number' => 'required|digits:10'
    
    ])
    ->messages([
        'required' => 'Il campo è richiesto.',
        'min' => 'Numero insufficiente di caratteri.',
        'max' => 'Hai inserito troppi caratteri.',
        'digits' => 'Inserisci il numero esatto di caratteri.'
      ])
    }}
        
    @endif
    @csrf
    {{-- * nome ristorante --}}
    <div class="col-12 my-2">
        {{ Aire::input('name', 'Nome') 
        ->value( old("name") ?? $restaurant->name)
        ->helpText('Nome del ristorante. Max 20 caratteri.')
    }} {{-- Creates a text input --}}
        {{--         <input type="text" name="name" id="name" placeholder="Da Mario" class="form-control @error("name") is-invalid @enderror" value="{{ old("name") ?? $restaurant->name }}">
        --}}        
        @error("name")
        <div class="invalid-feedback"> {{ $message }} </div>
        @enderror
    </div>
    
    {{-- * indirizzo --}}
    <div class="col-12 my-2">
        {{ Aire::input('address', 'Indirizzo')
        ->id('address')
        ->value( old("address") ?? $restaurant->address)
        ->helpText('Indirizzo del ristorante.')
        }}
        @error("address")
            <div class="invalid-feedback"> {{ $message }} </div>
        @enderror
    </div>
    
    <div class="row">
        {{-- * partita iva --}}
        <div class="col-6 col-md-4 my-2">
            {{ Aire::input('vat', 'Partita IVA')
            ->value( old("vat") ?? $restaurant->vat)

                ->helpText('11 caratteri.')
                 }} {{-- Creates a text input --}}
            {{--             <input type="number" name="vat" id="vat" placeholder="es. 86334519757" class="form-control @error("vat") is-invalid @enderror" value="{{ old("vat") ?? $restaurant->vat }}">
            --}}            @error("vat")
            <div class="invalid-feedback"> {{ $message }} </div>
            @enderror
        </div>
        
        {{-- * numero di telefono --}}
        <div class="col-6 col-md-4 my-2">
            {{ Aire::input('phone_number', 'Numero di Tel.') 
                        ->value( old("phone_number") ?? $restaurant->phone_number)

                        ->helpText('10 caratteri.')
}} {{-- Creates a text input --}}
            {{--             <input type="tel" name="phone_number" id="phone_number" pattern="+?[0-9]{10}" placeholder="0123456789" class="form-control @error("phone_number") is-invalid @enderror" value="{{ old("phone_number") ?? $restaurant->phone_number }}">
            --}}            @error("phone_number")
            <div class="invalid-feedback"> {{ $message }} </div>
            @enderror
        </div>
        
    </div>
    
    
    {{-- * immagine --}} 
<div clss="">
    <div class="col-12 my-2">
        <label class="form-label" for="image">Immagine</label>
    </div>
    {{-- @error("image")
    <div class="invalid-feedback"> {{ $message }} </div>
    @enderror --}}
    
    @php
        $default_images = ['restaurant_images/1.jpg', 'restaurant_images/3.jpg', 'restaurant_images/4.jpg', 'restaurant_images/5.jpg']
    @endphp

    <div class="row row-cols-5 d-flex flex-wrap">
    
        <div class="col d-flex flex-wrap align-items-center justify-content-center imageBox upload-bg
            @if ($restaurant->image != null)
                choosen
            @endif
            "onclick="uploadImage()" id="image_0">
    
            <div class="d-flex flex-column text-center align-items-center uploadImage">
                <i class="bi bi-cloud-upload fs-4 fs-md-2 fs-lg-1"></i>
                <span class="">
                    Carica un'immagine
                </span>
            </div>
    
            <img id="preview" 
            @if ($restaurant->image != null)
            src = '{{$restaurant->image}}'
            @else
            src = '#' style = 'display:none;'
            @endif 
            alt="" class=""/>
        </div>

        @foreach ($default_images as $key=>$default_image)
        <div class="col imageBox d-flex justify-content-center" 
        onclick="chooseImage( {{$key + 1}}, '{{$default_image}}')" id="image_{{$key + 1}}">
            <img class="rounded" src="{{ asset($default_image) }}" alt="description of myimage">
        </div>
        @endforeach

    </div>


    <input type="file" class="d-none" name="image" @error('image') is-invalid @enderror     id="selectImage" autocomplete="false">
    <input type="text" name="defaultImage" id="selectDefaultImage" autocomplete="false"     class="d-none" value="{{ old("image") ??  $restaurant->image }}">

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

{{-- * tipi di ristorante - checkboxes --}}
<div class="col-12 col-md-8 mt-4">
    <label class="form-label  @error('types') is-invalid @enderror" for="image">Tipo</label>
    @error("types")
    <div class="invalid-feedback"> {{ $message }} </div>
    @enderror
    <div class="row row-cols-4 ms-1">
        @foreach ($types as $type)
        <div class="form-check col me-4">
            <input class="form-check-input"  type="checkbox" value="{{$type->id}}" id="types[]" name="types[]" 
            @if ($restaurant->containsType($type->id))
            checked    
            @endif>
            <label class="form-check-label" for="types[]">
                {{$type->name}}
            </label>
        </div>
        @endforeach
    </div>
</div>
<div class="col-4 d-flex mt-5 mt-md-null justify-content-end align-items-end">
    @if ($restaurant->id)
    {{ Aire::submit('Modifica il tuo ristorante') }}
    @else
    {{ Aire::submit('Crea il tuo ristorante') }}
    @endif
</div>

{{-- * EDIT / CREATE submit --}}
{{Aire::close()}}



{{-- @else
    <h2 class="my-5">Non sei autorizzato a visualizzare ciò che cerchi!</h2>
    @endif --}}
    
    @endsection
    
    
    
    
    
        