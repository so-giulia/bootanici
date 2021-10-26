<!doctype html>
<html lang="IT-it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bootanici') }}</title>

    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>


    {{-- Feather icons --}}
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    {{-- chart.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body class="app-height overflow-hidden">
    <div class="fix-mobile-scroll">
        <nav class="navbar navbar-expand-md navbar-light backend-navbar">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Bootanici') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item nav-login mr-2">
                                <a href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item nav-login">
                                    <a href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-5">
            @yield('content')
        </main>
    </div>

    <script>
        feather.replace()
    </script>

    <script type="text/javascript">
        //script pagina profilo
        function validateForm(event){
          if(!confirm("Vuoi veramente eliminare il tuo profilo?")){
              event.preventDefault(); 
          }
        }

        // script pagina register

        function registerValidations(event){ 

          // ---------------Cap validation---------------------
          //messaggio validation form
          document.getElementById("validation_msg").innerHTML=" ";
          // event.preventDefault(); //disabilito temporaneamente il submit del form 
          // prendo il valore dell campo input cap
          let input = document.getElementById("cap").value;
          let input_number = parseInt(input);

          if(input.length != 5)
          {
            // note to future coders : if(input_number < 6121 || input_number > 6135) works only if there is a 0 in front ! 
            event.preventDefault(); 
            if(input_number < 6121 || input_number > 6135){ //lunghezza e valore non rispettano la validation
              document.getElementById("validation_msg").innerHTML="Il cap deve avere 5 cifre! E essere compreso tra 06121 e 06135";
              document.getElementById("validation_msg").classList.remove("d-none");
              document.getElementById("validation_msg").classList.add("alert","alert-danger");
            }
            else{ //il valore è corretto ma il numero di cifre no
              document.getElementById("validation_msg").innerHTML="Il cap deve avere 5 cifre!";
              document.getElementById("validation_msg").classList.remove("d-none");
              document.getElementById("validation_msg").classList.add("alert","alert-danger");
            }
          }
          else{
            if(input_number < 6121 || input_number > 6135){ //lunghezza corretta ma valore sbagliato
              event.preventDefault(); 

              document.getElementById("validation_msg").innerHTML="Il cap deve essere compreso tra 06121 e 06135";
              document.getElementById("validation_msg").classList.remove("d-none");
              document.getElementById("validation_msg").classList.add("alert","alert-danger");
            }
            else{ //tutte le condizioni della validation sono verificate
              document.getElementById("validation_msg").classList.add("d-none");
              document.getElementById("validation_msg").classList.remove("alert","alert-danger");
            }
           
          }

          // --------------- Name Surname validation ---------------------

          // console.log(input_number);
          // console.log(input);
        }
        function checkTextArea(event){
          // check bio
          document.getElementById('bioMsg').innerHTML=" ";
          console.log("test");
          // event.preventDefault(); //debug
          let bio = document.getElementById('biogr').value;
          let servizi = document.getElementById('servizi').value;
          console.log(bio);
          if(bio.trim() == ""){
            event.preventDefault();
            console.log("spazio vuoto");
            document.getElementById('bioMsg').innerHTML="La Bio non può essere vuota";
            document.getElementById("bioMsg").classList.remove("d-none");
            document.getElementById("bioMsg").classList.add("alert","alert-danger");
          }
          else{
            document.getElementById("bioMsg").classList.add("d-none");
            document.getElementById("bioMsg").classList.remove("alert","alert-danger");
          }
          // check servizi
          if(servizi.trim() == ""){
            event.preventDefault();
            console.log("spazio vuoto");
            document.getElementById('serviziMsg').innerHTML="Il campo servizi non può essere vuoto";
            document.getElementById("serviziMsg").classList.remove("d-none");
            document.getElementById("serviziMsg").classList.add("alert","alert-danger");
          }
          else{
            document.getElementById("serviziMsg").classList.add("d-none");
            document.getElementById("serviziMsg").classList.remove("alert","alert-danger");
          }

      }
        // function checkPsw(event){
        //   document.getElementById("validation_msg").innerHTML=" ";
        //   // event.preventDefault(); //da togliere
        //   let psw = document.getElementById('password').value;
        //   let pswConfirm = document.getElementById('password-confirm').value;
        //   console.log("psw : ", psw , "  pswConfirm: ", pswConfirm);
        //   if(psw != pswConfirm){
        //     // event.preventDefault();
        //     document.getElementById("validation_msg").innerHTML="Le due password non corrispondono!";
        //     document.getElementById("validation_msg").classList.remove("d-none");
        //     document.getElementById("validation_msg").classList.add("alert","alert-danger");
        //   }
        //   else{
        //       document.getElementById("validation_msg").classList.add("d-none");
        //       document.getElementById("validation_msg").classList.remove("alert","alert-danger");
        //   }
        // }




        // Section Promo 
        let counted = 0;

        // AGGIUNGO E TOLGO PROMO
        let addPromo = function (e, id){
            console.log(e);
            e.preventDefault();
            counted = document.getElementById('number-promo' + id).value;
            let counter = document.getElementById('number-promo' + id).value = ++counted;
            //Mostra il prezzo totale
            let price = document.getElementById('show-days' + id).getAttribute('name');
            let duration = document.getElementById('giorni' + id).getAttribute('name');

            totalPrice = document.getElementById('show-days' + id).innerHTML = 'Il prezzo totale è € ' + (counted * price).toFixed(2);
            if(id == 1 && counted == 1) {
                document.getElementById('giorni' + id).innerHTML = 'La promo è valida per ' + (counted * duration)/ 24 + ' giorno';
            } else {
                document.getElementById('giorni' + id).innerHTML = 'La promo è valida per ' + (counted * duration)/ 24 + ' giorni';
            }
            //
        }
        let removePromo = function (e, id){
            console.log(e);
            e.preventDefault();
            // prendo il valore dentro l'input 
            counted = document.getElementById('number-promo' + id).value;
            //

            if(counted == 0) {
                counted = 0
            } else {
                let counter = document.getElementById('number-promo'+ id).value = --counted;
                //Mostra il prezzo totale
                let price = document.getElementById('show-days' + id).getAttribute('name');
                let duration = document.getElementById('giorni' + id).getAttribute('name');

                totalPrice = document.getElementById('show-days' + id).innerHTML = 'Il prezzo totale è € ' + (counted * price).toFixed(2);
                if(id == 1 && counted == 1) {
                    document.getElementById('giorni' + id).innerHTML = 'La promo è valida per ' + (counted * duration)/ 24 + ' giorno';
                } else {
                    document.getElementById('giorni' + id).innerHTML = 'La promo è valida per ' + (counted * duration)/ 24 + ' giorni';
                }
                //
            }
        }
        // prendo il valore che scrive dentro l'input promo e calcolo prezzo totale 
        let takeType = function(e, id) {

            counter = document.getElementById('number-promo'+ id).value;
            let price = document.getElementById('show-days' + id).getAttribute('name');
            let duration = document.getElementById('giorni' + id).getAttribute('name');

            totalPrice = document.getElementById('show-days' + id).innerHTML = 'Il prezzo totale è € ' + (counter * price).toFixed(2);
            if(id == 1 && counter == 1) {
                document.getElementById('giorni' + id).innerHTML = 'La promo è valida per ' + (counter * duration)/ 24 + ' giorno';
            } else {
                document.getElementById('giorni' + id).innerHTML = 'La promo è valida per ' + (counter * duration)/ 24 + ' giorni';
            }

        };
        //
        // ------------------------------- Section Promo ---------------------------

        // ------------------------------------chart-----------------------------------
        
        // passiamo i messaggi in formato JSON x js da PHP
       
       
        
        
      
    </script>
</body>
</html>
