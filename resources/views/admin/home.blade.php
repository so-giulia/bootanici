@extends('layouts.app')

@section('content')

<div class="container">
{{-- Se l'utente non ha ancora creato il profilo --}}
        @if (!$users->user_details)
        <div class="row">
            <div class="alert col text-center alert-success profile-alert" role="alert">
                <p class="alert-p">
                    Per accedere alla tua dashboard devi prima creare il tuo profilo.
                    <br>
                    Clicca qui sotto per iniziare.
                </p>
    
                <a class="btn button-darkgreen" href="{{ route('admin.user.create') }}" role="button">Crea il tuo profilo</a>
            </div>
        </div>
        @endif

{{-- Se l'utente ha creato il profilo --}}        
        @if ($users->user_details)
        <div class="row">
            
    {{-- DASHBOARD --}}
            <div class="col-12 col-lg-3 back_lgreen  aside-height mb-2">
                @include('partials.aside')
            </div>

    {{-- CONTAINER DESTRO --}}
            <div class="col ml-lg-2 backend-content content-height height-scroll bg-white p-4" id="container_right">

            {{-- ALERT DI AVVENUTA CREAZIONE E MODIFICA --}}
                    {{-- Alert per creazione profilo --}}
                    @if(@session('add_details'))
                    <div class="alert alert-success" >{{@session('add_details')}}</div>
                    @endif

                    {{-- Alert per modifica profilo --}}
                    @if(@session('edited'))
                    <div class="alert alert-success" >{{@session('edited')}}</div>
                    @endif
                    {{-- FINE ALERTS --}}

            {{--SEZIONE PROMO --}}

                    <div class="mb-5 f_weight col ">

                        <div class="mt-5 pl-0 f_weight col">
                            @if(@session('messagePromo'))
                            <div class="alert alert-success" >{{@session('messagePromo')}}</div>
                            @endif
                            @if(@session('messaggino'))
                            <div class="alert alert-danger" >{{@session('messaggino')}}</div>
                            @endif
                        </div>


                        @if(count($users->promoUsers) == 0) 
                        <div class="mb-5 f_weight col mt-5">
                            <h2 class="purple f_weight text-capitalize mb-3">promuovi il tuo profilo!</h2>
                            
                            <div id="accordion">
                            @foreach ($promos as $k => $promo)                            
                                <hr>

                                <button class="add-promo btn button-purple mb-3 mr-4" type="button" data-toggle="collapse"
                                    @if($promo->id==1)data-target="#collapseOne" aria-controls="collapseTwo"@endif
                                    @if($promo->id==2)data-target="#collapseTwo" aria-controls="collapseTwo"@endif
                                    @if($promo->id==3)data-target="#collapseThree" aria-controls="collapseThree"@endif
                                    aria-expanded="false"
                                >
                                    {{$promo->name}}
                                </button>
                                <span >{{$promo->price}} € a Promo</span>
                                    
                                <ul class="collapse"
                                    @if($promo->id==1)id="collapseOne" data-target="#collapseOne" aria-labelledby="collapseOne"@endif
                                    @if($promo->id==2)id="collapseTwo" data-target="#collapseTwo" aria-labelledby="collapseTwo"@endif
                                    @if($promo->id==3)id="collapseThree" data-target="#collapseThree" aria-labelledby="collapseThree"@endif
                                    data-parent="#accordion"
                                    aria-expanded="false"
                                >
                                    <li>
                                        <!-- carrello  -->
                                        <form action="{{ route('admin.promo.index', $promo->id) }}" method="GET">
                                        @csrf
                                            <div class="text-uppercase mb-2">Scegli quante {{$promo->name}} promo vuoi</div>
                                            <button onClick="removePromo(event, {{$promo->id}})" class="btn button-darkgreen">-</button>
                                            <input class="btn" onkeyup="takeType(event, {{$promo->id}} )" name="number_promo" id="number-promo{{$promo->id}}" min="0" max="99" type="number" value="0">
                                            
                                            <button onClick="addPromo(event, {{$promo->id}})" class="btn button-darkgreen">+</button>
                                            <input class="btn button-lightgreen" type="submit" value="Vai">
                                        </form>
                                        <!-- carrello  -->
                                    </li>
                                    <li>
                                        <p name="{{$promo->price}}" id="show-days{{$promo->id}}" class="text-uppercase light_green">totale = € 0</p>
                                    </li>
                                    <li class="mb-2 text-uppercase">
                                        <p>questa promo dura {{$promo->duration}} ore</p> 
                                    </li>
                                    <li class="mb-2 text-uppercase">
                                        <p name="{{$promo->duration}}" id="giorni{{{$promo->id}}}">Durata promo 0 giorni</p> 
                                    </li>
                                    
                                </ul>
                            @endforeach
                            </div> 
                            @else
                            
                                <h2 class="f_weight text-capitalize purple">benvenuto utente premium!</h2>
                                <p class="purple">La promozione scadrà il {{ date("d-m-Y", strtotime($users->promoUsers[0]->end ." + 2 hours")) }} Alle {{ date("H:i", strtotime($users->promoUsers[0]->end ." + 2 hours")) }}</p>
                            
                        @endif

                    </div>    
                                
                               
    
                           
            {{-- SEZIONE MESSAGGI --}}

                    {{-- questi sono i messaggi ricevuti dall'utente --}}
                    <div class="dark_green f_weight col">
                        <h2 class="dark_green f_weight text-capitalize">i tuoi messaggi</h2>
                        <p class="mb-4 light_green">Hai <strong>{{$totalMex}}</strong> messaggi in Totale.</p>
                         <div class="card w-100 mt-3 no-bord">   
                            <div class="row row-cols-sm-1">
                        
                            @foreach ($messaggi as $messaggio)
                            <div class="col">
                                <div class="card w-100 bord-lgreen p-2 height-scroll card-height-big">
                                    
                                    <span class="text-capitalize light_green">nome:</span>
                                    <p class="text-capitalize mb-1">{{$messaggio->name_guest}}</p>
                                    <span class="text-capitalize light_green">email:</span>
                                    <p class="mb-1">{{$messaggio->from_email}}</p>
                                    <span class="text-capitalize light_green">oggetto mail:</span>
                                    <p class="mb-1">{{$messaggio->object_email}}</p>
                                    <span class="text-capitalize light_green">testo mail:</span>
                                    <p>{{$messaggio->message}}</p>
                                    <p class="data text-right">{{$messaggio->created_at->format('d/m/Y H:i')}}</p>
                                </div>
                            </div>
                            @endforeach
                            </div>
                        </div>
                        {{ $messaggi->links() }}  
                    </div>

                              
                {{-- SEZIONE RECENSIONI --}} 

                    {{-- Voti e recensioni --}}
                    <div class="mt-5 dark_green f_weight col">
                        <h2 class="dark_green f_weight text-capitalize">le tue recensioni</h2>
                        <p class="mb-4 light_green">Hai una media voto recensioni pari a <strong>{{$avgVote}}</strong></p>
                        <div class="card w-100  mt-3 no-bord">   
                            <div class="row  row-cols-sm-1">   
                    @foreach ($recs as $rec)
                                <div class="col">
                                    <div class="card w-100  bord-lgreen p-2 height-scroll card-height-small">
                                        <span class="text-capitalize light_green">nome:</span>
                                        <span class="text-capitalize ">{{$rec->name}}</span>
                                        <span class="text-capitalize light_green">voto: </span>
                                        <span class="">{{$rec->vote}}</span>
                                        <span class="text-capitalize light_green">recensione:</span>
                                        <p>{{$rec->feedback_text}}</p>
                                        <p class="data text-right">{{$rec->created_at->format('d/m/Y H:i')}}</p>
                                    </div>
                                </div>
                    @endforeach
                            </div>
                        </div>
                        <div>
                            {{$recs->appends(['messaggi' => $messaggi->currentPage()])->links()}}
                        </div>
                    </div>
                        
                        

                  
                    {{-- SEZIONE STATISTICHE --}}


                    <div class="f_weight col ">
                        <h2 class="f_weight dark_green text-capitalize mt-5 mb-3">le tue statistiche</h2>
                            <div><canvas id="myChart" ></canvas></div>
                        </div>
    
                        <div class="mt-5 f_weight col">
                            <div><canvas id="myChartRev" ></canvas></div>
                        </div>
            </div>
        </div>
        @endif
            
    </div>
</div>
    


                



<script type="application/javascript">

        var leads = {!! json_encode($users->leads->toArray()) !!};

                
        // creiamo i punti dell'asse x
        const labels = [
            'Gennaio',
            'Febbraio',
            'Marzo',
            'Aprile',
            'Maggio',
            'Giugno',
            'Luglio',
            'Agosto',
            'Settembre',
            'Ottobre',
            'Novembre',
            'Dicembre'
        ];

        
        // creo un oggetto con ogni mese il suo totale
        var countsM = {};
        leads.forEach(function(x) { 
            
            const monthN= new Date(x.created_at).getMonth()+1 ;
            
            countsM[monthN] = (countsM[monthN] || 0)+1; 
        });
        
       
        
       


        // creo un array di totali pari ai mesi di un anno 
        let mapY= [];
        
        for (let i = 1; i <= 12; i++) {

           
            for(key in countsM){

                if(key == i){
                    mapY.push(countsM[key]);
                    
                   

                    
                }else{
                    
                    if(key == Object.keys(countsM)[Object.keys(countsM).length-1]){

                        mapY.push(0);
                    }

                    }
                }            
            
            
        }


        //colleghiamo al canvas in home.blade
        var ctx = document.getElementById('myChart');


        // settiamo il grafico
        const data = {
            labels: labels,
            datasets: [{
                label: 'I Tuoi Messaggi',
                backgroundColor: 
                [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',

                ],
                borderColor: 'rgb(255, 99, 132)',
                data: mapY,
            }]
        };

        const config = {
        type: 'bar',
        data: data,
        options: {}
        }

        // confermiamo il grafico con istanza
        var myChart = new Chart(
            document.getElementById('myChart'),
            config
        );


        // -----------------------grafico recensioni-------------------------

        var recs = {!! json_encode($users->reviews->toArray()) !!};
        //  console.log(recs);


    // riduciamo per data i voti
    const groups = recs.reduce((groups, vote) => {
    const date = vote.updated_at.substr(5, 2);
    
        if (!groups[date]) {
            groups[date] = [];
        }
        // console.log(groups[date]);
        groups[date].push(vote.vote);
        return groups;
        }, 
        {});

        //  console.log(Object.values(groups));

        
        for(var key in groups){
            groups[key] = groups[key].reduce((a, b) => a + b, 0)/groups[key].length;
        }
        // console.log(groups);

        // mappiamo l'oggetto per un anno
        let mapYRev= [];
        
        for (let i = 1; i < 12; i++) {
                
            for(key in groups){

                if(key == i){
                    mapYRev.push(groups[key]);
                    
                    

                    
                }else{
                    
                    if(key == Object.keys(groups)[Object.keys(groups).length-1]){

                        mapYRev.push(0);
                    }

                }
            }


        }
        console.log(mapYRev);

        //colleghiamo al canvas in home.blade
        var ctxRev = document.getElementById('myChartRev');

        // settiamo il grafico
        const dataRev = {
            labels: labels,
            datasets: [{
                label: 'La Media Dei Tuoi Voti',
                backgroundColor: 
                [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',

                ],
                borderColor: 'rgb(255, 99, 132)',
                data: mapYRev,
            }]
        };

        const configRev = {
        type: 'bar',
        data: dataRev,
        options: {}
        }

        // confermiamo il grafico con istanza
        var myChartRev = new Chart(
            document.getElementById('myChartRev'),
            configRev
        );



        // JQUERY refresh e stop al punto in cui si trova l'utente prima del refresh


        $('#container_right').scroll(function () {
            sessionStorage.scrollTop = $(this).scrollTop();
        });
        $(document).ready(function () {
            if (sessionStorage.scrollTop != "undefined") {
                $('#container_right').scrollTop(sessionStorage.scrollTop);
            }
        });
        </script>

@endsection
                
                                        

    
    

            
                           


               
            

