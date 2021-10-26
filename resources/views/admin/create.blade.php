@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between">
        @if(!$users->user_details)
            <form  class="backend-content col content-height height-scroll bg-white p-4" onsubmit="checkboxCheck(event),checkTextArea(event)" action="{{ route('admin.user.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <p class="mb-3 text-uppercase dark_green f_weight">Si prega di riempire tutti i campi contrassegnati  &ast;  per procedere e andare online</p>

                <!-- input immagini  -->
                <div class="mb-3">

                    <label for="immagine" class="form-label d-block text-uppercase dark_green f_weight">Scegli un Immagine &ast;</label>
                    <input type="file" name="propic_url" id="immagine" 
                    class=" form-control
                    @error('propic_url')
                        is-invalid
                    @enderror" >

                    @error('propic_url')
                        <div class="alert alert-danger w-50">Devi selezionare un immagine</div>
                    @enderror
                </div>
                <!--  -->
                <!-- input bio  -->
                <div class="mb-3">
                    <label for="biogr" class="form-label text-uppercase dark_green f_weight">bio &ast;</label>
                    <textarea type="text" name="bio" placeholder="descriviti in 500 caratteri" class="form-control @error('bio') is-invalid @enderror" id="biogr" maxlength="500" required
                    oninvalid="this.setCustomValidity('La Bio non può essere vuota')" onchange="this.setCustomValidity('')">{{ old('bio') }}</textarea>
                    @error('bio')
                        <div class="alert alert-danger w-50">{{ $message }}</div>
                    @enderror
                    <div id="bioMsg" class="d-none"></div>
                </div>
                <!--  -->
                <!-- input servizi  -->
                <div class="mb-3">
                    <label class="form-check-label text-uppercase dark_green f_weight" for="servizi">servizi &ast;</label>
                    <textarea type="text" placeholder="max 500 caratteri" class="form-control @error('service') is-invalid @enderror" name="service" id="servizi" maxlength="300" required
                    oninvalid="this.setCustomValidity('Inserisci i Servizi')" onchange="this.setCustomValidity('')">{{ old('service') }}</textarea>
                    @error('service')
                        <div class="alert alert-danger w-50">{{ $message }}</div>
                    @enderror
                    <div id="serviziMsg" class="d-none"></div>

                </div>
                <!--  -->
                <!-- input telefono  -->
                <div class="mb-3">
                    <label class="form-check-label text-uppercase dark_green f_weight" for="telefono">telefono (10 caratteri)</label>
                    <input type="text" maxlength="10" class="form-control @error('phone') is-invalid @enderror"
                    value="{{ old('phone', $users->phone) }}" id="telefono" name="phone" pattern="[0-9]{10}" oninvalid="this.setCustomValidity('Questo campo non può contenere caratteri')" onchange="this.setCustomValidity('')">
                    @error('phone')
                        <div class="alert alert-danger w-50">{{ $message }}</div>
                    @enderror
                </div>
                <!--  -->
                <!-- input avg  -->
                <div class="mb-3">
                    <label class="form-check-label text-uppercase dark_green f_weight" for="avg">tariffa oraria &ast;</label>
                    <input type="number" class="form-control @error('avg_hourly_rate') is-invalid @enderror"
                    value="{{ old('avg_hourly_rate', $users->avg_hourly_rate) }}" id="avg" name="avg_hourly_rate" min="0"max="100" step="0.01" required  oninvalid="this.setCustomValidity('Inserisci un numero')" onchange="this.setCustomValidity('')">
                @error('avg_hourly_rate')
                        <div class="alert alert-danger w-50">{{ $message }}</div>
                @enderror
                </div>
                <!--  -->
                <!-- input specializzazioni  -->
                <div>
                    <h4 class="text-uppercase dark_green f_weight">Specializzazioni &ast;</h4>
                    <ul>
                    @if(count($specs)>0)
                      @foreach($specs as $key => $spec)
                        <li>
                            <input id="spec{{$key}}" type="checkbox" value="{{$spec->id}}" 
                                @if(in_array($spec->id, old('specs', [])))
                                    checked
                                @endif
                            name="specs[]">
                            <label class="mx-2 text-capitalize dark_green" for="spec{{$key}}">{{$spec->spec_name}} </label>
                        </li>
                      @endforeach
                    @endif  
                    
                    </ul>
                    <div id="validation_msg" class="d-none"></div>
                </div>
                <!--  -->

                <button class="btn button-lightgreen">
                    <a href="{{ route('admin.user.index') }}">Torna indietro</a>
                </button>
                <button type="submit" class="btn button-darkgreen">Vai Online</button>
            </form>
        @endif 
    </div>
    <script type="text/javascript">
      function checkboxCheck(event){
        // event.preventDefault(); //da togliere
        let check = false;
        var s = <?php echo(json_encode($specs)); ?>;
        if(s.length > 0 ){
          console.log(s);
          for (let index = 0; index < s.length; index++) {
            // console.log(document.getElementById('spec'+index).checked);
            // console.log('spec'+index);      
            if(document.getElementById('spec'+index).checked){
              check = true; //non c'è neanche una specializzazione selezionata
              console.log("if");//da togliere
            }
          }
          console.log("check finale",check);
          if(check == false){ // nessuna spec selezionata
            event.preventDefault();
            document.getElementById("validation_msg").innerHTML="Devi selezionare almeno una specializzazione";
            document.getElementById("validation_msg").classList.remove("d-none");
            document.getElementById("validation_msg").classList.add("alert","alert-danger");
          }
          else{
            document.getElementById("validation_msg").classList.add("d-none");
            document.getElementById("validation_msg").classList.remove("alert","alert-danger");
          }
      }
     
    }
    
    
    </script>

</div>

@endsection


