<template>
  <footer class="ffooter fpy-50">
      <div class="fcontainer">
        <!-- footer-top start -->
        <div class="ffooter-top flex-row justify-content-between align-items-start">
          <!-- Credits start -->
          <div class="fcol-xs-12 fcol-md-2">
              <ul class="ffooter-list fmb-50">
                <li class="ffsmall fitalic text-uppercase fmb-25">un progetto di:</li>
                <li class="norm-li">
                    <a class="norm-hover" href="https://www.linkedin.com/in/alessio-di-pietro-852351221/" target="_blank">
                        Alessio Di Pietro
                    </a>
                </li>
                <li class="norm-li">
                    <a class="norm-hover" href="https://www.linkedin.com/in/emmanuel-parisi-84ba51221/" target="_blank">
                        Emmanuel Parisi
                    </a>
                </li>
                <li class="norm-li">
                    <a class="norm-hover" href="https://www.linkedin.com/in/giulia-fenu-7a0b72221/" target="_blank">
                        Giulia Fenu
                    </a>
                </li>
                <li class="norm-li">
                    <a class="norm-hover" href="https://www.linkedin.com/in/giulia-soccolini-a28a73216/" target="_blank">
                        Giulia Soccolini
                    </a>
                </li>
                <li class="norm-li">
                    <a class="norm-hover" href="https://www.linkedin.com/in/maicolmatteoli/" target="_blank">
                        Maicol Matteoli
                    </a>
                </li>
            </ul>
          </div>
          <!-- Credits end -->

          <!-- Menu Footer start -->
          <div class="fcol-xs-12 fcol-md-2">
              <ul class="ffooter-list fmb-50">
                <li class="ffsmall fitalic text-uppercase fmb-25">Sitemap:</li>
                <li class="norm-li"><a class="norm-hover" href="/#about">About Bootanici</a></li>
                <li class="norm-li"><a class="norm-hover" href="/#search">Cerca un esperto</a></li>
                <li class="norm-li"><a class="norm-hover" href="/#in-evidenza">Bootanici in evidenza</a></li>
            </ul>
          </div>
          <!-- Menu Footer end -->

          <!-- Fake Newsletter + social start -->
          <div class="fcol-xs-12 fcol-md-4">
              <div class="ffsmall fitalic text-uppercase fmb-25">resta aggiornato:</div>
              <div class="newsletter-container">
                  <img @click.prevent="newsletter()" class="footer-ficon" src="../../../public/storage/icons/arrow-right.svg" alt="arrow right">
                  <input @keyup.enter="newsletter()" class="ffsmall finput finput-footer fmb-25" type="email" placeholder="Inserisci la tua email" multiple autocomplete="email">
              </div>
              <transition name="fade" mode="out-in">
                <div class="alert alert-error ffsmall review-alert fmb-25" role="alert" v-if="newsletterControl">
                    Ci dispiace, la nostra newsletter non è ancora attiva
                </div>
              </transition>

              <div class="ffsocial">
                  <span class="ffxs text-uppercase">
                      <a class="norm-hover" href="#">instagram</a>
                  </span>

                  <span class="separator mx-2">/</span>

                  <span class="ffxs text-uppercase">
                      <a class="norm-hover" href="#">Facebook</a>
                  </span>

                  <span class="separator mx-2">/</span>

                  <span class="ffxs text-uppercase">
                      <a class="norm-hover" href="#">Linkedin</a>
                  </span>
              </div>
          </div>
          <!-- Fake Newsletter + social end -->
        </div>
        <!-- footer-top end -->

        <!-- footer-bottom start -->
        <div class="ffooter-bottom fmt-100">
            <div class="flex-row justify-content-between align-items-center">
                <div class="fcol-xs-12 fcol-md-6 ffxs text-uppercase fmb-12">
                    &copy;2021 —  ALL RIGHTS RESERVED
                </div>

                <div class="fcol-xs-12 fcol-md-4 ffxs text-uppercase">
                    <span><a class="norm-hover" href="/login">Login</a></span>
                    <span class="separator mx-2">/</span>
                    <span><a class="norm-hover" href="/register">registrati</a></span>
                </div>
            </div>
        </div>
        <!-- footer-bottom end -->
      </div>
  </footer>
</template>

<script>
export default {
    name: 'Footer',
    data(){
        return{
            newsletterControl: false,
        }
    },
    methods:{
        newsletter(){
            this.newsletterControl = true;

            // dopo 5 secondi sparisce
            setTimeout(()=>{
                this.newsletterControl = false;
            }, 5000);
        }
    }
}
</script>

<style>

</style>