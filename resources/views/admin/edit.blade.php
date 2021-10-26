@extends('layouts.app')

@section('content')

<div class="container">
@if (Auth::user()->id == $user->id)
    <div class="row justify-content-between">   
        <div class="col-12 col-lg-3 back_lgreen aside-height mb-2">
            @include('partials.aside')
        </div>
        {{-- Aside nav end --}}
        
        <div class="backend-content col-9 content-height height-scroll bg-white p-4">
            <form  class="w-75" action="{{ route('admin.user.update', $details->user_id) }}" onsubmit="registerValidations(event),checkboxCheck(event)" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- input nome -->
                <div class="mb-4">
                    <label for="name" class="form-label text-uppercase dark_green f_weight">nome</label>

                    <input type="text" name="name" maxlength="20" placeholder="max 20 caratteri" id="name" value="{{ old('name', $user->name) }}"
                    class="form-control @error('name') is-invalid @enderror" required pattern="[A-Za-z]+"
                    oninvalid="this.setCustomValidity('Nome non può essere vuoto o contenere numeri')" onchange="this.setCustomValidity('')">
                    @error('name')
                        <div class="alert alert-danger w-50">{{ $message }}</div>
                    @enderror
                </div>
                <!--  -->

                <!-- input cognome -->
                <div class="mb-4">
                    <label for="last_name" class="form-label text-uppercase  dark_green f_weight">cognome</label>

                    <input type="text" name="last_name" maxlength="20" placeholder="max 20 caratteri" id="last_name" value="{{ old('last_name', $user->last_name) }}"
                    class="form-control @error('last_name') is-invalid @enderror" required pattern="[A-Z a-z]+"
                    oninvalid="this.setCustomValidity('Cognome non può essere vuoto o contenere numeri')" onchange="this.setCustomValidity('')">
                    @error('last_name')
                        <div class="alert alert-danger w-50">{{ $message }}</div>
                    @enderror
                </div>
                <!--  -->

                <!-- input indirizzo -->
                <div class="mb-4">
                    <label for="address" class="form-label text-uppercase  dark_green f_weight">indirizzo</label>

                    <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}"
                    class="form-control @error('address') is-invalid @enderror" required pattern="[A-Z a-z 0-9]+">
                    @error('address')
                        <div class="alert alert-danger w-50">{{ $message }}</div>
                    @enderror
                </div>
                <!--  -->

                <!-- input cap -->
                <div class="mb-4">
                    <label for="cap" class="form-label text-uppercase  dark_green f_weight">cap</label>

                    <input type="text" name="cap" id="cap" value="{{ old('cap', $user->cap) }}"
                    class="form-control @error('cap') is-invalid @enderror" required min="00000" max="98100">
                    @error('cap')
                        <div class="alert alert-danger w-50">{{ $message }}</div>
                    @enderror
                    <div id="validation_msg" class="d-none"></div>

                </div>
                <!--  -->

                <!-- input immagini  -->
                <div class="mb-4">
                    <label for="immagine" class="form-label d-block text-uppercase  dark_green f_weight">Scegli un Immagine</label>
                    
                    <!-- Vecchia immagine -->
                    @if($details->propic_url)
                        {{-- !GIULIAS: non prende --}}
                        <img class="w-50 mb-4" src="{{ asset('storage/public/' . $user->user_details->propic_url) }}">
                    @endif
                    <!--  -->

                    <input type="file" name="propic_url" id="immagine" 
                    class=" form-control
                    @error('propic_url')
                        is-invalid
                    @enderror">

                    @error('propic_url')
                        <div class="alert alert-danger w-50">{{ $message }}</div>
                    @enderror
                </div>
                <!--  -->
                <!-- input bio  -->
                <div class="mb-4">
                    <label for="biogr" class="form-label text-uppercase  dark_green f_weight" required >bio</label>

                    <textarea type="text" name="bio" id="biogr"
                    class="form-control @error('bio') is-invalid @enderror" required maxlength="500">{{ old('bio', $details->bio) }}</textarea>
                    @error('bio')
                        <div class="alert alert-danger w-50">Il campo Bio non può essere vuoto</div>
                    @enderror
                    <div id="bioMsg" class="d-none"></div>
                </div>
                <!--  -->
                <!-- input servizi  -->
                <div class="mb-4">
                    <label class="form-check-label text-uppercase  dark_green f_weight" for="servizi">servizi</label>
                    <textarea type="text" class="form-control @error('service') is-invalid @enderror" name="service" id="servizi" maxlength="300">{{ old('service', $details->service) }}</textarea>
                    @error('service')
                        <div class="alert alert-danger w-50">Il campo Servizi non può essere vuoto</div>
                    @enderror
                    <div id="serviziMsg" class="d-none"></div>
                </div>
                <!--  -->
                <!-- input telefono  -->
                <div class="mb-4">
                    <label class="form-check-label text-uppercase  dark_green f_weight" for="telefono">telefono (10 caratteri)</label>
                    <input type="text" maxlength="10"  class="form-control @error('phone') is-invalid @enderror"
                    value="{{ old('phone', $details->phone) }}" id="telefono" name="phone" pattern="[0-9]{10}" required
                    oninvalid="this.setCustomValidity('Il Telefono non può contenere caratteri')" onchange="this.setCustomValidity('')">
                    @error('phone')
                        <div class="alert alert-danger w-50" >{{ $message }}</div>
                    @enderror
                </div>
                <!--  -->
                <!-- input avg  -->
                <div class="mb-4">
                    <label class="form-check-label text-uppercase  dark_green f_weight" for="avg">tariffa oraria</label>
                    <input type="number" class="form-control @error('avg_hourly_rate') is-invalid @enderror"
                    value="{{ old('avg_hourly_rate', $details->avg_hourly_rate) }}" id="avg" name="avg_hourly_rate" required min="0"max="100" step="0.01">
                @error('avg_hourly_rate')
                        <div class="alert alert-danger w-50">{{ $message }}</div>
                @enderror
                </div>
                <!--  -->
                <div>
                <!-- input specializzazioni  -->
                <h5 class="text-uppercase dark_green f_weight">Specializzazioni &ast;</h5>
                <ul>
                @foreach ($specializations as $k => $specialization)
                    <li>
                        <input class="mx-2 " type="checkbox" id="specialization{{$k}}" value="{{$specialization->id}}" 
                        @if ($user->specializations->contains($specialization->id) && $errors)
                            checked
                        @elseif (in_array($specialization->id, old('specializations', [])))
                            checked
                        @endif name="specializations[]" >
                        <label class="text-capitalize dark_green" for="specialization{{$k}}"> {{$specialization->spec_name}}</label>
                    </li>
                    @endforeach
                </ul>
                <div id="validation_msg2"></div>

                </div>
            
                <!--  -->
                <div>
                    <button class="btn button-lightgreen">
                        <a   href="{{ route('admin.user.index') }}">Torna indietro</a>
                    </button>
                    <button type="submit" class="btn button-darkgreen">Modifica profilo</button>

                </div>

            </form>
        </div>
    </div>
    @else
        <h2>Mi dispiace al momento questa non è una pagina fertile </h2>
        <a class="btn btn-success" href="{{ route('admin.user.index') }}">Ritorna alla Tua Home</a>
    @endif

    <script type="text/javascript">
      function checkboxCheck(event){
        let check = false;
        var s = <?php echo(json_encode($specializations)); ?>;
        if(s.length > 0 ){
          console.log(s);
          for (let index = 0; index < s.length; index++) {
            if(document.getElementById('specialization'+index).checked){
              check = true; //non c'è neanche una specializzazione selezionata
              console.log("if");//da togliere
            }
          }
          console.log("check finale",check);
          if(check == false){ // nessuna spec selezionata
            console.log("check");
            event.preventDefault();
            console.log(document.getElementById("validation_msg2").classList);
            document.getElementById("validation_msg2").innerHTML="Devi selezionare almeno una specializzazione";
            document.getElementById("validation_msg2").classList.remove("d-none");
            document.getElementById("validation_msg2").classList.add("alert","alert-danger");
          }
          else{
            document.getElementById("validation_msg2").classList.add("d-none");
            document.getElementById("validation_msg2").classList.remove("alert","alert-danger");
          }
      }
      
    }
    
    
    </script>
</div>
@endsection
