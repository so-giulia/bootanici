@extends('layouts.app')
@section('content')

<div class="container">
  
  <div class="row justify-content-between">

    {{-- Aside nav start --}}
    <div class="col-12 col-lg-3 back_lgreen  aside-height mb-2">
        @include('partials.aside')
    </div>
    {{-- Aside nav end --}}

    {{-- area upload --}}
    <div class="card no-bord col ml-lg-2 backend-content content-height height-scroll bg-white p-4">
       <div class="card-header dark_green f_weight text-uppercase">Carica un'immagine</div>
         <div class="card-body my-3">
            @if ($message = Session::get('success'))
 
                <div class="alert alert-success alert-block">
 
                    <button type="button" class="close" data-dismiss="alert">×</button>
 
                    <strong>{{ $message }}</strong>
 
                </div>
            @endif
 
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(@session('deleted'))
                <div class="alert alert-danger" >{{@session('deleted')}}</div>
            @endif
 
            <form action="{{ route('admin.portfolio.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="file" class="form-control-file" name="file[]" id="file" multiple="">
                   
                </div>
                <button type="submit" class="btn button-darkgreen">Conferma</button>
            </form>

            {{-- area show --}}
            <div class="row justify-content-center p-2">
                <div class="card w-100  mt-5 no-bord">   
                    <div class="row row-cols-3 ">
                        @foreach($portfolio as $img)
                        <div class="col ">
                            <div class="card w-100 mb-5 no-bord">
                                <div class="img-container " style="overflow: hidden; height: 130px;">
                                    <img class="w-100" style="width: 100%; object-fit: cover; height: 100%;"
                                    src="{{ asset('storage/' . $img->image_url) }}">
                                </div>
                                

                                <div class="card-body p-0 my-3">
                                    <form action="{{ route('admin.portfolio.destroy', $img) }}" method="post" class="delete-form d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="Cancella" class="btn btn-danger"></input>
                                    </form>    
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- area show --}}

         </div>
     </div>
  </div>
  {{-- area upload --}}

  
</div>


@endsection
