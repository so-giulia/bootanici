<template>
    <main>
       <!-- hero section start -->
       <section id="hero" class="app-height">
           <div class="hero_content flex-row justify-content-start align-items-center">
               <h1 class="fcol-lg-5 fcol-xs-12 fcol-md-6 fh1 lh-12 fmb-50 fmx-25 text-uppercase hero-text">
                    Realizza il <span class="fitalic">giardino</span> che hai sempre <span class="fitalic">sognato</span>
               </h1>

               <!-- Test freccia -->
               <img class="scroll-arrow" src="../../../public/storage/icons/arrow-right.svg">

               <!-- hero video desktop -->
              <video class="hero_video hero_desktop fcol-lg-12 video-flip" ref="videoRef" width="100%" height="100%" loop autoplay muted>
                <!-- <source src="../../../public/video/endvideo.mp4" type="video/mp4"> -->
                <source src="http://127.0.0.1:8000/storage/public/videos/home-desktop.mp4" type="video/mp4">
                
                Your browser does not support the video tag.
              </video>
              <!-- hero video mobile -->
              <video class="hero_video hero_mobile fcol-lg-12" ref="videoRef" width="100%" height="100%" loop autoplay muted>
                <!-- <source src="../../../public/video/endvideo.mp4" type="video/mp4"> -->
                <source src="http://127.0.0.1:8000/storage/public/videos/home-mobile.mp4" type="video/mp4">
                
                Your browser does not support the video tag.
              </video>

              <div class="layover"></div>
           </div>

       </section>
       <!-- hero section end -->

       <!-- about section start -->
       <section id="about" class="fmb-50">
           <div class="flex-row about-container justify-content-between">
               <div class="fcol-xs-12 fcol-md-6 about-text-container">
                   <div class="fcontainer">
                       <h6 class="fcol-xs-12 ffxs fcaption fmb-25 lh-12">about bootanici</h6>
                        <h2 class="fcol-xs-12 fcol-sm-8 fcol-md-12 fcol-lg-10 fcol-xl-8 fh2 lh-12 text-uppercase fmb-25">
                    La tua casa non è mai stata così <span class="fitalic">green</span>
                        </h2>

                        <p class="fcol-xs-8 fcol-lg-7 ffsmall lh-12 text-uppercase fmb-50">
                            Con botanici puoi facilmente realizzare un <span class="medium-weight">giardino da sogno</span>, o <span class="medium-weight">arredare</span> la tua casa con le migliori piante da interni.
                        </p>

                        <p class="fcol-xs-6 fcol-md-9 fcol-lg-7 fcol-xl-5 ffxs lh-12 fmb-50">
                            Bootanici ti aiuta a trovare un giardiniere professionista per la tua casa. Sia essa una villa indipendente o un piccolo appartamento, i nostri esperti ti aiuteranno a trovare la soluzione più adatta alle tue esigenze. Puoi restare in contatto con i nostri esperti e affidare a loro la cura del tuo giardino.
                        </p>
                   </div>
               </div>

               <div class="fcol-xs-12 fcol-md-6 about-img-container position-relative">
                   <img class="about-img-2" src="storage/homeimg/about-2.jpg" alt="About Bootanici Flower">
                   <img class="about-img-1" src="storage/homeimg/about-1.jpg" alt="About Bootanici">
               </div>
           </div>
       </section>
       <!-- about section end -->

       <!-- search section start -->
       <section id="search">
           <div class="fcontainer">
               <div class="flex-column fmb-25">
                    <h6 class="desktop-center-home fcol-xs-12 ffxs fcaption fmb-25 lh-12">cerca esperti</h6>
                    <h2 class="desktop-center-home fcol-xs-12 fh2 lh-12 text-uppercase fmb-25">
                        Trova il tuo<br> nuovo giardiniere
                    </h2>

                    <p class="home-search-p desktop-center-home fcol-xs-6 fcol-md-4 fcol-lg-3 ffxs lh-12">
                         Hai bisogno di un Garden Designer? Di alberi per il tuo giardino? O forse vuoi solo arredare con le piante esotiche più belle. Scegli una specializzazione, potrai raffinare la tua ricerca più avanti.
                    </p>
               </div>

               <SpecializationsSlider class="spec-slider-desktop fmb-50" :specializations="specializations"/>
               <SpecializationsSliderMobile class="spec-slider-mobile fmb-50" :specializations="specializations"/>
           </div>
       </section>
       <!-- search section end -->

       <!-- section big start -->
       <section id="big">
           <div class="fcontainer fpy-50">
               <h2 class="fcol-xs-12 fcol-sm-6 fcol-md-4 fh2 lh-12 text-uppercase fmb-25 txt-white">
                    Centinaia di clienti già <span class="fitalic">soddisfatti</span>
               </h2>
           </div>
           <img class="home-section-big" src="storage/homeimg/home-section-big.jpg" alt="Bootanici">
       </section>
       <!-- section big end -->

       <!-- section in evidenza start -->
       <section id="in-evidenza">
           <div class="fcontainer fpy-50">
                <!-- title start -->
                <h6 class="desktop-center-home fcol-xs-12 ffxs fcaption fmb-25 lh-12">
                   bootanici in evidenza
                </h6>

                <h2 class="desktop-center-home fcol-xs-12 fh2 lh-12 text-uppercase fmb-25">
                    Scopri nuovi <span class="fitalic">Bootanici</span>
                </h2>  
                 <!-- title end -->

                <!-- slider bootanici start -->
                <!-- //desktop -->
                <swiper class="swiper evidenza-slider-desktop home-swiper fmb-25" :options="swiperOption">
                    <swiper-slide v-for="sponsor,index in sponsored" :key="index">
                        <div class="evidenza-card fmy-25">
                            <!-- foto profilo -->
                            <div class="evidenza-card-img-wrap">
                                <img class="profile-propic" :src="'/storage/public/' + sponsor.user_details.propic_url" :alt="sponsor.name + sponsor.last_name">
                            </div>

                            <!-- info -->
                            <div class="flex-column sponsored-info fpl-12 fpt-25 fpr-12 fpb-25">
                                <h4 class="fh4 lh-1 text-uppercase">
                                    {{sponsor.name}} {{sponsor.last_name}}
                                </h4>
                                <div class="ffxs txt-accent lh-12 fmb-25">
                                    <span class="medium-weight">Specialista in</span>
                                        <span class="sponsored-specs" v-for="spec in sponsor.specializations" :key="spec.id">
                                            {{spec.spec_name}}<span class="sponsor-separator">, </span>
                                        </span>
                                </div>
                                <p class="ffsmall lh-12 sponsored-bio">
                                    {{sponsor.user_details.bio}}
                                </p>
                            </div>

                            <!-- da cambiare in router-link -->
                            <router-link @click.native="$scrollToTop" class="home-wrap-link" :to="{ name : 'profile', params: {slug : sponsor.slug}}">
                                <div class="home-card-btn ffsmall text-uppercase fpx-25 fpy-12 flex-row w-100 justify-content-between align-items-center">
                                    <span class="btn-card-text fcol-xs-11">vai al profilo</span>
                                    <img class="home-btn-ficon" src="../../../public/storage/icons/arrow-right-dark.svg">
                                    <img class="home-btn-ficon home-ficon-hover" src="../../../public/storage/icons/arrow-right.svg">
                                    <span class="btn-card-hover"></span>
                                </div>
                            </router-link>
                        </div>
                    </swiper-slide>

                    <div class="home-swiper-pagination swiper-pagination" slot="pagination"></div>
                </swiper>

                <!-- //mobile -->
                <EvidenzaSliderMobile class="evidenza-slider-mobile fmb-25" :specializations="specializations" :sponsored="sponsored"/>
                <!-- slider bootanici end -->
           </div>
       </section>
       <!-- section in evidenza end -->

       <Endvideo/>
    </main>
</template>

<script>
import Endvideo from '../components/Endvideo.vue';
import SpecializationsSlider from '../components/SpecializationsSlider.vue';
import SpecializationsSliderMobile from '../components/SpecializationsSliderMobile.vue';
import EvidenzaSliderMobile from '../components/EvidenzaSliderMobile.vue';
import { Swiper, SwiperSlide, directive } from 'vue-awesome-swiper';
import 'swiper/css/swiper.css';

export default {
    name : 'Home',
    components:{
        Swiper,
        SwiperSlide,
        SpecializationsSlider,
        SpecializationsSliderMobile,
        EvidenzaSliderMobile,
        Endvideo
    },
    directives: {
        swiper: directive
    },
    data(){
        return{
            specApi: 'http://localhost:8000/api/specializations',
            sponsorApi: 'http://localhost:8000/api/sponsored',
            specializations : [],
            sponsored: [],
            swiperOption: {
                slidesPerView: 3,
                spaceBetween: 15,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                }
            }
        }
    },
    created(){
        this.getSpecializations();
        this.getSponsored();
    },
    methods:{
        getSpecializations(){
           axios.get( this.specApi )
                .then(response => {
                this.specializations = response.data.results;
        });
        },
        getSponsored(){
            axios.get( this.sponsorApi )
            .then(response => {
                this.sponsored = response.data.results;
            });
        }
    }
}
</script>
