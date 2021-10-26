<template>
<main>
    <!-- parte alta con dettagli utente -->
    <section id="profile-overview" class="flex-row">
        <!-- Parte alta - foto e primi dettagli start -->
        <div class="fcol-xs-12 fcol-lg-6 position-relative overview-col" v-if="profile.user_details">
            <div class="layover"></div>
           <img class="profile-propic" :src="'/storage/public/' + profile.user_details.propic_url" :alt="profile.name">
        </div>

        <div class="fcol-xs-12 fcol-lg-6 fbg-green overview-col fpy-50" v-if="profile.user_details">

            <div class="overview-text fpl-25">
                <!-- Nome e cognome utente -->
                <div class="fh1 lh-1 text-uppercase fmb-25">
                    {{ profile.name }}<br>
                    {{ profile.last_name }}
                </div>

                <!-- Media recensioni messe a stella -->
                <!-- <div class="ffxs fmb-25">qui vanno le stelline</div> -->

                <!-- Bio -->
                <p class="ffmid lh-12 w-75">
                    {{ profile.user_details.bio }}
                </p>

                <!-- Specializzazioni -->
                <div class="ffxs text-uppercase medium-weight">Specialista in</div>
                <div class="flex-row fmb-25">
                    <span class="ffxs fmr-12" v-for="spec in profile.specializations" :key="spec.id">
                        <span>
                            <img class="ficon" src="../../../public/storage/icons/flower.svg">
                        </span>
                        {{ spec.spec_name }}
                    </span>
                </div>

                <!-- Servizi -->
                <div class="ffxs text-uppercase medium-weight">Servizi</div>
                <p class="ffxs lh-12 w-25">{{ profile.user_details.service }}</p>
            </div>
        </div>
        <!-- Parte alta - foto e primi dettagli end -->
    </section>

    <!-- parte portfolio -->
    <section id="portfolio" v-if="existsPortfolio" class="fcontainer fpy-50">
        <h6 class="desktop-center ffxs fcaption fmb-25 lh-12">scopri di più su<br>{{profile.name}} {{profile.last_name}}</h6>
        <h2 class="desktop-center fh2 text-uppercase fmb-25">Portfolio <span class="fitalic">lavori</span></h2>

        <swiper class="swiper home-swiper profileDesktopSwiper" :options="swiperOption">
            <swiper-slide class="profile-swiper-slide"  v-for="img,index in profile.portfolios" :key="index">
              <div class="profile-img-wrap">
                  <img :src="'/storage/' + img.image_url" :alt="profile.name">
              </div>
            </swiper-slide>
                    
            <div class="home-swiper-pagination swiper-pagination" slot="pagination"></div>
        </swiper>

        <MobileSwiper class="profileMobileSwiper" :portfolio="profile.portfolios" />
    </section>

    <!-- parte recensione con container small -->
    <section id="reviews" class="fcontainer fpy-50">
            <div class="flex-row">
                <!-- Parte testuale: recensioni dei clienti + aggiungi recensione -->
                <div class="fcol-xs-12 fcol-lg-6 fmb-50">
                    <h6 class="ffxs fcaption fmb-25">dicono di {{profile.name}}</h6>
                    <h2 class="fh2 text-uppercase fmb-25">Recensioni<br>dei clienti</h2>
                    <p class="fw-45 ffxs lh-12 fmb-50">Scopri cosa gli altri utenti pensano dei nostri Bootanici e confronta le recensioni con quelle degli altri profili. Se sei il primo cliente di {{profile.name}}, lascia una recensione utile per gli altri visitatori.</p>

                    <span @click="leaveReview" class="ffxs profile-btn profile-btn-review">
                        <span class="btn-light-text">{{leaveReviewText }}</span>
                        <span class="btn-light-hover"></span>
                    </span>

                    <!-- recensione -->
                    <form @submit.prevent="getReview" v-if="reviewClicked">

                        <h2 class="fh2 text-uppercase fmt-50 fmb-25">Nuova<br>recensione</h2>
                        
                        <!-- Conferma recensione -->
                        <transition name="fade" mode="out-in">
                            <div class="w-75 alert alert-success ffsmall review-alert fmb-25" role="alert" v-if="reviewSuccess">
                                Grazie! Hai inviato una recensione a {{profile.name}}
                            </div>
                        </transition>

                        <!-- voto -->
                        <div class="flex-row align-items-center fmb-25">
                            <span class="mr-2 ffsmall text-uppercase fcaption-dark">voto &#42;</span>
                            <star-rating class="w-75" v-model="rating" :increment="1" name="vote" />
                            <transition name="fade" mode="out-in">
                                <div class="alert alert-error w-50 ffsmall review-alert fmb-25" role="alert" v-if="ratingControl">
                                    Devi inserire almeno una stella
                                </div>
                            </transition>
                        </div>

                        <div class="fcol-xs-12 fcol-md-6">
                            <div class="fmb-25">
                                <label class="ffsmall text-uppercase" for="name">Il tuo nome &#42;</label>
                                <input class="finput" type="text" name="name" id="name" v-model="name">
                                <transition name="fade" mode="out-in">
                                    <div class="alert alert-error ffsmall review-alert fmb-25" role="alert" v-if="nameControl">
                                        Il nome è obbligatorio
                                    </div>
                                </transition>
                            </div>
                            
                            <div class="fmb-12">
                                <label class="ffsmall text-uppercase" for="feedback">Feedback</label>
                                <textarea class="finput" name="feedback" id="feedback" cols="30" rows="7" v-model="feedback"></textarea>
                            </div>
                        </div>

                        <div class="ffxs fmb-50">I campi contrassegnati con &#42; sono obbligatori</div>
                        <button type="submit" class="ffxs profile-btn profile-btn-review">  
                            <span class="btn-light-text">Invia recensione</span>
                            <span class="btn-light-hover"></span>
                        </button>
                    </form>
                </div>
                
                <!-- Stampo tutte le recensioni -->
                <div class="fcol-xs-12 fcol-lg-6 reviews-container">
                    <div v-for="(review, index) in reviews" :key="index" class="fmb-25">

                        <SettedRating :value="review.vote" :disabled="true" />
                        <div class="ffxs medium-weight">
                           Recensione di: {{review.name}}
                        </div>
                        <p class="ffxs">
                            {{review.feedback_text}}
                        </p>

                    </div>
                </div>
            </div>
    </section>

    <!-- parte mail con sfondo verde -->
    <section id="contacts" class="fbg-green w-100">
            <div class="fcontainer fpy-50 flex-row justify-content-between">
                <!-- Parte testuale: contatta X per preventivo -->
                <div class="fcol-xs-12 fcol-md-3 fcol-md-5">
                    <h2 class="fh2 lh-12 fmb-50 text-uppercase profile-contact-text">
                        Contatta <span class="fitalic">{{ profile.name }}</span> Per un <span class="fitalic">preventivo</span>
                    </h2>
                    <p class="fcol-md-8 ffsmall lh-12 text-uppercase fmb-25">
                        Tramite questo form di contatto invierai un messaggio a {{profile.name}} che ti risponderà all’indirizzo email da te indicato *.
                    </p>
                    <p class="fcol-md-8 ffxs lh-12 fmb-50">
                        (*) Inviando questo form di contatto acconsenti al trattamento dei tuoi dati secondo la normativa europea attualmente in vigore. Consultala <a class="here" href="#">qui</a>
                    </p>
                </div>

                <!-- Parte form -->
                <div class="fcol-xs-12 fcol-md-6">
                    <!-- Alert conferma messaggio -->
                    <transition name="fade" mode="out-in">
                        <div class="alert alert-success email-alert fmb-50" role="alert" v-if="mailSuccess">
                            Ottimo! Hai inviato un messaggio a <span class="capitalize">{{profile.name}}</span>.<br>
                            <span class="capitalize">{{profile.name}}</span> risponderà a breve al tuo indirizzo mail.
                        </div>
                    </transition>

                    <!-- form per invio messaggi -->
                    <form @submit.prevent="sendForm">
                        <!-- Name + email -->
                        <div class="flex-row justify-content-between fmb-50">
                             <!-- nome guest -->
                            <div class="profile-form-col-half">   
                                <label class="ffsmall text-uppercase">nome &#42;</label>
                                <input class="finput" type="text" v-model='nameEmail' name="name_guest" required>
                            </div>

                            <!-- email guest -->
                            <div class="profile-form-col-half">
                                <label class="ffsmall text-uppercase">email &#42;</label>
                                <input class="finput" type="email" v-model='email' name="from_email" required>
                            </div>
                        </div>

                        <!-- oggetto messaggio -->
                        <div class="fmb-50">
                            <label class="ffsmall text-uppercase">oggetto &#42;</label>
                            <input class="finput" type="text" v-model="oggetto" name="object_email" required>
                        </div>
                        
                        <!-- email text -->
                        <div class="fmb-12">
                            <label class="ffsmall text-uppercase">messaggio &#42;</label>
                            <textarea class="finput" name="message" v-model="messaggio" cols="30" rows="5" required></textarea>
                        </div>
                        
                        <div class="ffxs fmb-50">I campi contrassegnati con &#42; sono obbligatori</div>
                        
                        <button type="submit" class="ffxs btn-mail-container">
                            <!-- <input class="ffxs profile-btn profile-btn-mail" type="submit" value=""> -->
                            <span class="ffxs btn-dark-text">invia messaggio</span>
                            <span class="btn-dark-hover"></span>
                        </button>
                            
                        
                    </form> 
                </div>
            </div>
    </section> 

    <Endvideo/>
</main>
   
    
</template> 

<script>
import SettedRating from '../components/SettedRating.vue'
import MobileSwiper from '../components/MobileSwiper.vue'
import StarRating from 'vue-star-rating';
import { Swiper, SwiperSlide, directive } from 'vue-awesome-swiper';;
import 'swiper/css/swiper.css';
import Endvideo from '../components/Endvideo.vue';

export default {
    name : 'Profile',
    components: {
        StarRating,
        Swiper,
        SwiperSlide,
        MobileSwiper,
        Endvideo,
        SettedRating
    },
    directives: {
        profileDesktopSwiper: directive,
    },
    data(){
        return{
            profile : [],
            reviews: [],
            nameEmail: '',
            email: '',
            oggetto: '',
            messaggio: '',
            reviewClicked: false,
            leaveReviewText: 'Lascia una recensione',
            rating: 0,
            name: '',
            nameControl: false,
            feedback: '',
            mailSuccess: false,
            reviewSuccess: false,
            ratingOutput: 5,
            ratingControl: false,
            existsPortfolio: false,
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
        this.getProfile();
        Vue.prototype.$scrollToTop = () => window.scrollTo(0,0);
    },
    methods:{
        getProfile(){
           axios.get( '/api' + this.$route.fullPath )
            .then(response => {
                this.profile = response.data.results;
                console.log(this.profile);
                this.reviews = this.profile.reviews.reverse();
                if(this.profile.portfolios.length > 0){
                    this.existsPortfolio = true;
                }
           });
        },
        sendForm(){
            // invio il messaggio al botanico
            axios.post('/api/lead', {
                "user_id": this.profile.id,
                "name_guest": this.nameEmail,
                "from_email": this.email,
                "message": this.messaggio,
                "object_email": this.oggetto
            })
            .then(response => {
                //è vero l'alert e si svuotano i campi
                this.mailSuccess = true;
                this.email = '';
                this.nameEmail = '';
                this.oggetto = '';
                this.messaggio = '';

                // dopo 2 secondi sparisce
                setTimeout(()=>{
                    this.mailSuccess = false;
                }, 5000);

                console.log(response.request);
            });
            this.mailSuccess = false;
        },
        leaveReview(){
            this.reviewClicked = !this.reviewClicked;
            if(!this.reviewClicked)this.leaveReviewText='Lascia una recensione';
            if(this.reviewClicked)this.leaveReviewText='Chiudi box recensione';
        },
        getReview(){
            if(this.rating == 0){
                this.ratingControl = true;
                
                // dopo 2 secondi sparisce
                setTimeout(()=>{
                    this.ratingControl = false;
                }, 5000);
            }else if(this.name == '' || this.name == null){
                this.nameControl = true;
                
                // dopo 2 secondi sparisce
                setTimeout(()=>{
                    this.nameControl = false;
                }, 5000);
            }else{
                axios.post('/api' + this.$route.fullPath + '/reviews', {
                    'user_id': this.profile.id,
                    'vote': this.rating,
                    'name': this.name,
                    'feedback_text': this.feedback
                })
                .then(response => {
                    if(response.data.success){
                        //è vero l'alert e si svuotano i campi
                        this.reviewSuccess = true;
                        this.name = '';
                        this.feedback = '';
                        this.rating = 0;
                        // dopo 5 secondi sparisce
                        setTimeout(()=>{
                            this.reviewSuccess = false;
                        }, 5000);
                    }else{
                        this.reviewSuccess = false;
                        this.errors = response.data.errors;
                        console.log(this.errors);
                    } 
                });
            }
            //ritorna falso l'alert
            this.reviewSuccess = false;
        }
    }
}
</script>
