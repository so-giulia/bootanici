@extends('layouts.app')

@section('content')
<div class="container">
    @if (Auth::user()->id == $user->id)
        
    
    <div class="row justify-content-between">
        
        {{-- Aside nav start --}}
        <div class="col-12 col-lg-3 back_lgreen  aside-height mb-2">
            @include('partials.aside')
        </div>
        {{-- Aside nav end --}}

        
        {{-- Content start --}}
        <div class="col ml-lg-2 backend-content content-height height-scroll bg-white p-4">
            {{-- upper - details start --}}
            <div class="mb-5">
                <img class="mb-3 w-25 " src="{{ asset('storage/public/' . $user->user_details->propic_url) }}" alt="{{ $user->name . ' ' .  $user->last_name }}">
        
                {{-- nome e cognome --}}
                <div class="mb-4 dark_green f_weight text-capitalize">
                    <h2>{{ $user->name }} {{ $user->last_name }}</h2>
                    <p>{{ $user->address }}, {{ $user->cap }}</p>
                </div>
        
                @if($user->user_details)
                    {{-- bio --}}
                    <div class="mb-4 dark_green f_weight text-capitalize">
                        <h4 class="light_green">Bio:</h4>
                        <p>{{ $user->user_details->bio }}</p>
                    </div>
            
                    {{-- servizi --}}
                    <div class="mb-4 dark_green f_weight text-capitalize">
                        <h4 class="light_green">Servizi:</h4>
                        <p>{{ $user->user_details->service }}</p>
                    </div>
            
                    {{-- tariffa oraria --}}
                    <div class="mb-4 dark_green f_weight text-capitalize">
                        <h4 class="light_green">Tariffa oraria: </h4> 
                        <span>{{ $user->user_details->avg_hourly_rate }}&euro;/ora</span>
                    </div>
                @endif

                {{-- specializzazioni --}}
                <div class="mb-4 dark_green f_weight text-capitalize">
                    <h4 class="light_green">Specializzazioni:</h4>
                    
                    @if($user->specializations)
                        <div class="w-50">
                            <ul>
                                @forelse($user->specializations as $specialization)
                                <li>
                                    <span class="mr-2">{{ $specialization->spec_name }}</span>
                                </li>
                                @empty
                                    <span>Nessuna specializzazione</span>
                                @endforelse
                                </ul>
                        </div>
                    @endif
                    
                </div>
        
                <div class="dark_green f_weight text-capitalize">
                    <h4 class="light_green">Il tuo portfolio:</h4>
                   
                    @if($portfolio)
                        <div class="w-100">
                            <div class="row row-cols-3 m-0">
                                @forelse($portfolio as $img)
                                <div class="col">
                                    <div class="card w-100 mb-4" style="height: 250px;">
                                        <div class="img-container" style="overflow: hidden; height: 100%;">
                                            <img class="w-100 " style="width: 100%; object-fit: cover; height: 100%;"
                                            src="{{ asset('storage/' . $img->image_url) }}">
                                        </div>
                                    </div>
                                </div>
                                @empty
                                    <span>Non hai ancora un portfolio</span>
                                @endforelse
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            {{-- upper - details end --}}
        
            {{-- button to edit --}}
            <a class="btn button-lightgreen " href="{{ route('admin.user.edit', $user->id) }}">Modifica il tuo profilo</a>
        
            {{-- button to portfolio --}}
            <a class="btn button-lightgreen " href="{{ route('admin.portfolio.index') }}">Modifica il tuo portfolio</a>
        </div>
        {{-- Content end --}}
    </div>
    @else
        <h2>Mi dispiace al momento questa non è una pagina fertile </h2>
        <a class="btn btn-success" href="{{ route('admin.user.index') }}">Ritorna alla Tua Home</a>
    @endif
</div>
@endsection