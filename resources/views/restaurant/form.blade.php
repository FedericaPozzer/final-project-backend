@extends('layouts.app')

@section('content')

@include('layouts.partials.errors')



    <div class="row d-flex justify-content-center">
        <div class="col-12 col-md-11">
            @if ($restaurant->id)
            
            {{-- FORM MODIFICA --}}
            {{ Aire::open()
                ->enctype('multipart/form-data')
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
        
            {{-- FORM CREAZIONE --}}
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
        
                {{-- riga immagine preview - form --}}
                <div class="row mt-3">
                    
                    {{-- preview immagine --}}
                    <div class="col-12 col-lg-4 my-2">
                        <div class="preview">
                            <div class="choose_image">
                                <img src="/restaurant.svg" alt="" srcset="">
                            </div>
                            <img id="preview" 
                            @if ($restaurant->image != null)
                            src = '{{'/' . $restaurant->image}}'
                            @else
                            src = '#'
                            @endif 
                            alt="" class="img-fluid"/>
                        </div>
                    </div>
        
                    {{-- nome - indirizzo - vat - tel --}}
                    <div class="col-12 col-lg-8 my-2">
        
                        <div class="col-12">
                            <h2 class="title">
                                @if ($restaurant->id)
                                    Modifica il tuo ristorante
                                @else
                                    Parlaci del tuo ristorante
                                @endif
                            </h2>
                        </div>
        
                        @if ($restaurant->id)
                            <div class="subtitle my-2">
                                E' periodo di cambiamenti? Modifica qui i dati del tuo ristorante, così che i tuoi clienti possano sapere che il tuo business si sta evolvendo!
                            </div>
                            
                        @else
                            <div class="subtitle my-2">
                                Pronto per entrare nella community di Ristoratori di DeliveBoo? Inserisci un po' di dati sul tuo ristorante, li useremo per consigliarti ai nostri clienti! 
                            </div>
                        @endif
        
                        {{-- Nome --}}
                        <div class="col-12 my-2">
                            {{ Aire::input('name', 'Nome') 
                                ->value( old("name") ?? $restaurant->name)
                                ->helpText('Nome del ristorante. Max 20 caratteri.')
                            }}  
                    
                            @error("name")
                            <div class="invalid-feedback"> {{ $message }} </div>
                            @enderror
                        </div>
                        
                        {{-- Indirizzo --}}
                        <div class="col-12 my-2">
                            {{ Aire::input('address', 'Indirizzo')
                                ->value( old("address") ?? $restaurant->address)
                                ->helpText('Indirizzo del ristorante.')
                            }}
                            @error("address")
                                <div class="invalid-feedback"> {{ $message }} </div>
                            @enderror
                        </div>
                        
                        {{-- riga partita iva e numero di telefono --}}
                        <div class="col-12">
                            <div class="row">
                                {{-- partita iva --}}
                                <div class="col-6 my-2">
                                    {{ Aire::input('vat', 'Partita IVA')
                                        ->value( old("vat") ?? $restaurant->vat)
                                        ->helpText('11 caratteri.')
                                    }} 
                                    
                                    @error("vat")
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>
                                
                                {{-- numero di telefono --}}
                                <div class="col-6 my-2">
                                    {{ Aire::input('phone_number', 'Numero di Tel.') 
                                        ->value( old("phone_number") ?? $restaurant->phone_number)
                                        ->helpText('10 caratteri.')
                                    }} 
                        
                                    @error("phone_number")
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
            
            <div class="row mt-3">
                <div class="col-12">
                    <h2 class="title" @error('image') is-invalid @enderror">
                        Scegli un'immagine per il tuo ristorante
                    </h2>
        
                    <div class="subtitle my-3">
                        Anche se l'abito non fa il monaco, una bella immagine ti aiuterà a distinguerti tra i tuoi colleghi Ristoratori della community. Scegli tra le nostre immagini stock, oppure caricane una a tuo piacimento.
                    </div>
        
                    @error("image")
                    <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>
            </div>
            
            {{-- scelta immagine --}} 
            <div class="shade">

                <div class="images_cont">
            
                    {{-- bottone upload immagine --}}
            
            
            
            
                    <div class=" img_card" 
                    @error('image') is-invalid @enderror
                    onclick="document.getElementById('uploadImage').click()">
                
                        <input type="radio" class="input-hidden" name="image" id="0">
                        <label for="0" class="h-100 w-100 d-flex align-items-center justify-content-center bg-deliveboo">
            
                            <div class="d-flex flex-column align-items-center">
                                <span>
                                    <h1>
                                        <i class="bi bi-upload"></i>
                                    </h1>
                                </span>
                                <span class="badge text-dark">
                                    Carica un'immagine 
                                </span>
                                <input type="file" name="uploaded_file" class="d-none" id="uploadImage">
                                <script>
                                uploadImage.onchange = evt => {
                                    const [file] = uploadImage.files
                                    if (file) {
                                        preview.src = URL.createObjectURL(file)
                                        document.getElementById('0').checked = true
                                        document.getElementById('0').value = 'upload_file'
                                    }
                                }
                                </script>
                            </div>
                        </label>
                    </div>
            
                    {{-- Index per ID input / label --}}
            
                    {{-- Immagini di default --}}
            
                    @php
                        $i = 1
                    @endphp
            
                    @foreach(File::glob(public_path('restaurant_images').'/*') as $path)
                        <div class=" img_card" onclick="preview.src = '{!! str_replace(public_path(), '', $path)  !!}'">
                            <input type="radio" class="input-hidden" name="image" id="{{$i}}" value="{{str_replace(public_path(), '', $path)}}">
                            <label for="{{$i}}">
                                <img class="img-fluid" src="{{ str_replace(public_path(), '', $path) }}" alt="default images">
                            </label>
                        </div>
            
                        @php
                            $i++
                        @endphp
                    @endforeach
            
            
            
            
                    @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        
        
            {{-- scelta tipologie ristorante --}}
            <div class="row my-3">
                <div class="col-12">
                    <label class="form-label  @error('types') is-invalid @enderror" for="image">
                        <div class="row my-2">
                            <div class="col-12">
                                <h2 class="title">
                                    Seleziona una o più tipologie del tuo ristorante
                                </h2>
                                <div class="subtitle my-2">
                                    I nostri clienti scelgono i ristoranti più disparati: carne, sushi, pizza! Seleziona una o più tipologie che rispecchiano il tuo locale, così che DeliveBoo possa consigliarti meglio agli utenti.
                                </div>
                            </div>
                        </div>
                    </label>
                    @error("types")
                    <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>
                <div class="shade">
                    <div class="d-flex types_cont">
                        @foreach ($types as $type)
                        <div class="form-check type_form">
                            <input class="form-check-input"  type="checkbox" value="{{$type->id}}" id="type_{{$type->id}}" name="types[]" 
                            @if ($restaurant->containsType($type->id))
                            checked    
                            @endif>
                            <label for="type_{{$type->id}}" class="form-check-label">
                                <img src="{{$type->image}}" alt="">
                                {{$type->name}}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        
            {{-- Bottone invio form --}}
            <div class="send-cont">
                @if ($restaurant->id)
                {{ Aire::submit('Modifica il tuo ristorante') }}
                @else
                {{ Aire::submit('Crea il tuo ristorante') }}
                @endif
            </div>
        
            {{-- chiusura form --}}
            {{Aire::close()}}

        </div>
    </div>
    {{-- * se il ristorante è da modificare / se il ristorante è da creare --}}
    

    @endsection
    
    
    
    
    
        