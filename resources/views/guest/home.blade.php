<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Bootanici</title>

        {{-- Scripts --}}
        <script src="{{ asset('js/front.js') }}" defer></script>

        {{-- Gsap! Do not touch --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.8.0/gsap.min.js" integrity="sha512-eP6ippJojIKXKO8EPLtsUMS+/sAGHGo1UN/38swqZa1ypfcD4I0V/ac5G3VzaHfDaklFmQLEs51lhkkVaqg60Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="frontend-body">
      {{-- Header desktop --}}
      <header id="header" class="fixed-header">
        <nav class="flex-row align-items-center justify-content-between">
           <div class="logo fh4 fcol-md-2">
               <a href="{{ url('/') }}">Bootanici</a>
            </div>

           @if (Route::has('login'))
           <div class="fcol-md-9 flex-row justify-content-end">
                <ul class="flex-row align-items-center ffxs text-uppercase fmr-50">
                    <li><a href="/#about">About Bootanici</a></li>
                    <li class="fmx-50"><a href="/#search">Cerca esperti</a></li>
                    <li><a href="/#in-evidenza">Bootanici in evidenza</a></li>
                </ul>

                <div class="nav-btn">
                    @auth
                    <a class="user-area" href="{{ url('/admin/user') }}">Area Riservata</a>
                    @else
                        <a class="user-area" href="{{ route('login') }}">Sei un Bootanico?</a>
                    @endauth
                </div>
                @endif
           </div>
           
        </nav>
      </header>

      {{-- Header mobile --}}
      <header id="header-mobile">
        <nav class="flex-row align-items-center justify-content-between">
           <div class="logo fh4 fcol-11">Bootanici</div>

           <div class="burger fcol-1" id="burger" onclick="openMenu()">
               <span></span>
               <span></span>
               <span></span>
           </div>
        </nav>
      </header>

      {{-- menu mobile tendina --}}
      <div id="mobile-menu">
        <div class="flex-row align-items-center justify-content-end fpt-25">
            <div id="close" onclick="closeMenu()">
                <span></span>
                <span></span>
            </div>
        </div>
            
        <div class="flex-row align-items-center justify-content-center fpt-100">
            <ul class="mobile-ul fcol-xs-10 fcol-sm-8 text-center text-uppercase">
                <li><a href="/#about">About Bootanici</a></li>
                <li><a href="/#search">Cerca esperti</a></li>
                <li><a href="/#in-evidenza">Bootanici in evidenza</a></li>
                @if (Route::has('login'))
                    @auth
                    <li class="fmt-50">
                        <a class="btn-mobile-menu" href="{{ url('/admin/user') }}">
                        Area riservata
                        </a>
                    </li>
                    @else
                    <li class="fmt-50">
                        <a class="btn-mobile-menu" href="{{ route('login') }}">
                        Sei un Bootanico?
                        </a>
                    </li>
                    @endauth
                @endif
              </ul>
        </div>
      </div>

      {{-- Pagine vue iniettate qui (vedere App.vue) --}}
      <div id="root">
       
      </div>

      <script>
        //funzione navbar sticky change on scroll
        window.onscroll = function(){  
            var head = document.getElementById('header');
            var y = window.scrollY;
            
            if(y === 0){
                head.classList.remove("scrolled-header");
                head.classList.add("fixed-header");
            }
            if(y >= 120){
                head.classList.remove("fixed-header");
                head.classList.add("scrolled-header");
            }
        }

        //setting gsap
        var timeline = gsap.timeline();

        //funzioni menu mobile
        function openMenu(){
            // console.log('sto cliccando');

            if(!timeline.reversed()){
                timeline.fromTo("#mobile-menu", 1.5,
                {
                    display: 'none',
                    width: '0',
                    height: '100vh',
                    ease: Expo.easeInOut
                },
                {
                    display: 'block',
                    width: '75%',
                    height: '100vh',
                    ease: Expo.easeInOut
                })
                .from("#close, #close > span", 0.5,{
                    display: 'none',
                    opacity: '0',
                    delay: '-1',
                    ease: Expo.easeOut
                })
                .from(".mobile-ul, .mobile-ul li", 1, {
                    opacity: '0',
                    y: '20',
                    delay: '-0.5',
                    stagger: '0.15',
                    ease: Expo.easeOut
                }); 
            }else{
                timeline.restart();
            }
        }
        function closeMenu(){
            timeline.reverse();
        }
      </script>
    </body>
</html>
