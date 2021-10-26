@if ($users->user_details)  
<aside class="content-height py-2 p-sm-2 p-lg-4 aside-height aside-400-width">      
    <ul class="flex-lg-column navbar-aside">
        {{-- home --}}
        <li class="mb-lg-4 ">
            <i data-feather="home"></i>
            <a class="d-none d-md-block" href="{{ route('admin.user.index') }}">{{ $users->name }} {{ $users->last_name }}</a>
        </li>

        {{-- modifica profilo --}}
        <li class="mb-lg-4">        
            <i data-feather="edit"></i>
            <a class="d-none d-md-block" href="{{ route('admin.user.edit', $users->id) }}">Modifica il tuo profilo</a>
        </li>
        
        {{-- visualizza profilo --}}
        <li class="mb-lg-4">
            <i data-feather="user"></i>
            @if (Auth::check())
                <a class="d-none d-md-block" href="{{ route('admin.user.show', $users->id) }}">Visualizza il tuo profilo</a>
                
            @endif
        </li>

        {{-- promo --}}
        {{-- <li class="mb-lg-4">        
            <i data-feather="arrow-up-circle"></i>
            <a class="d-none d-md-block" href="{{ route() }}">Promuovi il tuo profilo!</a>
        </li> --}

        {{-- vai a portfolio --}}
        <li class="mb-lg-4">
            <i data-feather="image"></i>
            <a class="d-none d-md-block" href="{{ route('admin.portfolio.index') }}">Crea il tuo portfolio</a>
        </li>

        {{-- elimina profilo --}}
        <li class="mb-lg-4">
            <form id="myForm" onsubmit="validateForm(event)" action="{{ route('admin.user.destroy', $users->id) }}" method="post" class="delete-form d-inline-block">
                @csrf
                @method('DELETE')
                <i data-feather="trash"></i>
                <input id="submitBtn" type="submit" value="Elimina profilo" class="d-none d-md-block aside-delete"></input>
            </form>   
        </li>
    </ul>
</aside>
@endif


