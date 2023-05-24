@extends('layouts.app')

@section('content')
@if ($dish->id)
    <h2 class="mt-5 mb-3">Modifica il piatto</h2>
@else
    <h2 class="mt-5 mb-3">Crea il tuo piatto</h2>
@endif

{{-- @php 
$restaurant = auth()->user()->restaurant;
@endphp --}}

{{-- * if che controlla che il ristoratore possa vedere solo le sue cose --}}
{{-- @if(auth()->user()->owner->id == auth()->user()->id) --}}



{{-- * UPDATE / EDIT title --}}

@include('layouts.partials.errors')

{{-- * se il piatto esiste già form edit / se il piatto non esiste già form create --}}
@if ($dish->id)
{{ Aire::open()
    ->route('dishes.update', $dish)
    ->rules([
        'name' => 'required|max:20',
        'description' => 'required',
        'price' => 'required|min:0.5|max:100',    
    ])
    ->messages([
        'required' => 'Il campo è richiesto.',
        'min' => 'Numero insufficiente di caratteri.',
        'max' => 'Hai inserito troppi caratteri.',
      ])
    }}
@else
{{ Aire::open()
    ->route('dishes.store', $dish)
    ->rules([
        'name' => 'required|max:20',
        'description' => 'required',
        'price' => 'required|min:0.5|max:100',    
    ])
    ->messages([
        'required' => 'Il campo è richiesto.',
        'min' => 'Numero insufficiente di caratteri.',
        'max' => 'Hai inserito troppi caratteri.',
      ])
    }}
    @endif

    {{-- * nome piatto --}}
    <div class="col-12 col-md-8 my-4">
        {{ Aire::input('name', 'Nome')
        ->id('name')
        ->value( old("name") ?? $dish->name)
        ->helpText('Nome del piatto.')
        }}
        @error("name")
            <div class="invalid-feedback"> {{ $message }} </div>
        @enderror
        
    </div>
    
    {{-- * descrizione --}}
    <div class="col-12 col-md-8 my-4">
        {{ Aire::input('description', 'Descrizione')
        ->id('description')
        ->value( old("description") ?? $dish->description)
        ->helpText('Descrizione del piatto.')
    }}
        @error("description")
            <div class="invalid-feedback"> {{ $message }} </div>
        @enderror
        
    </div>
  
    {{-- * prezzo --}}
    <div class="col-12 col-md-8 my-4">
        
        {{Aire::number('price', 'Prezzo')
        ->step(0.01)
        ->value( old("price") ?? $dish->price)}}

        @error("price")
            <div class="invalid-feedback"> {{ $message }} </div>
        @enderror
    </div>
  
    {{-- * immagine --}} 
    <div class="">
        <div class="col-12 my-2">
            <label class="form-label" for="image" >Immagine</label>
        </div>
        {{-- @error("image")
            <div class="invalid-feedback"> {{ $message }} </div>
        @enderror --}}
    
        @php 
            $default_images = ['dish_images/1.png', 'dish_images/2.png', 'dish_images/3.png', 'dish_images/4.png', 'dish_images/5.png', 'dish_images/6.png', 'dish_images/7.png', 'dish_images/8.png', 'dish_images/9.png', 'dish_images/10.png', 'dish_images/11.png', 'dish_images/12.png', 'dish_images/13.png']
        @endphp

        <div class="row row-cols-5 d-flex flex-wrap">

            <div class="col d-flex flex-wrap align-items-center justify-content-center imageBox upload-bg
                @if ($dish->image != null)
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
                @if ($dish->image != null)
                src='{{$dish->image}}'
                @else
                src='#' style = 'display:none;'
                @endif 
                alt="" class=""/>
            </div>
        
            @foreach ($default_images as $key=>$default_image)
            <div class="col imageBox d-flex justify-content-center" onclick="chooseImage( {{$key + 1}}, '{{$default_image}}')" id="image_{{$key + 1}}">
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
    
    </div>


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
        <input type="checkbox" id="available" name="available" value="1"  @checked(old('published',$dish->available))>
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

{{ Aire::close() }}



{{-- @else
<h2 class="my-5">Non sei autorizzato a visualizzare ciò che cerchi!</h2>
@endif --}}

@endsection
  