<template> 
    <main>
        <!-- jumbotron -->
        <section class="app-height">
                <div class="hero_content debug-hero fpx-25 flex-row justify-content-start align-items-center">
                    <h1 class="fcol-lg-5 fcol-xs-12 fcol-md-6 fh1 lh-12 fmb-50 text-uppercase hero-text">
                            un pool di <span class="fitalic">esperti </span>pronti ad <span class="fitalic">aiutarti</span>
                    </h1>
                    <!-- hero video desktop -->
                <video class="hero_video hero_desktop fcol-lg-12" ref="videoRef" width="100%" height="100%" loop autoplay muted>
                    <!-- <source src="../../../public/video/endvideo.mp4" type="video/mp4"> -->
                    <source src="http://127.0.0.1:8000/storage/public/videos/search-desktop.mp4" type="video/mp4">
                    
                    Your browser does not support the video tag.
                </video>
                <!-- hero video mobile -->
                <video class="hero_video hero_mobile fcol-lg-12" ref="videoRef" width="100%" height="100%" loop autoplay muted>
                    <!-- <source src="../../../public/video/endvideo.mp4" type="video/mp4"> -->
                    <source src="http://127.0.0.1:8000/storage/public/videos/search-mobile.mp4" type="video/mp4">
                    
                    Your browser does not support the video tag.
                </video>
                </div>
        </section>
        <!-- jumbotron -->

        <!-- main part -->
        <section>
            <div class="fcontainer fpy-50">
                <!-- Search title start -->
                <h6 class="desktop-center-home fcol-xs-12 ffxs fcaption fmb-25 lh-12">
                   cerca esperti
                </h6>

                <h2 class="desktop-center-home fcol-xs-12 fh2 lh-12 text-uppercase fmb-50">
                    Risultati di <span class="fitalic">ricerca</span>
                </h2> 
                <!-- Search title end -->
                
                <!-- Filters start -->
                <div class="flex-row justify-content-between fmb-50">
                    <!-- Select Specializations -->
                    <div class="select fmb-25">
                        <label class="ffxs lh-12 text-uppercase fcaption fmr-12" for="scegli">specializzazione</label>
                        <select class="text-capitalize lh-12" id="scegli" v-model="selectValue" @change="getFilteredUsers('/search/' + selectValue)">
                            <option selected v-for="(specialization,index) in specializations" :key="index" :value="specialization.slug_specialization">{{specialization.spec_name}}</option>
                        </select>
                    </div>
                    <!-- End Select Specializations -->

                    <!-- Ordina per start-->
                    <div class="order">
                        <!-- Ordina per recensioni-->
                        <span class="order-input">
                            <input id="order-review" type="checkbox" class="lh-12 fmr-6"
                            @change="orderByReviews(selectValue, currentPage)">
                            <label class="ffxs lh-12 text-uppercase fcaption fmr-12" for="order-review">Ordina per Numero di Recensioni</label>
                        </span>
                        
                        <!-- End Ordina per recensioni -->
                        
                        <!-- Ordina per voti -->
                        <span class="order-input">
                            <input id="order-vote" type="checkbox" class="lh-12 fmr-6"
                            @change="orderByVotes(selectValue, currentPage)">
                            <label class="ffxs lh-12 text-uppercase fcaption" for="order-vote">Ordina per Media Voti</label>
                        </span>
                        <!-- End Ordina per voti -->
                    </div>
                    <!-- Ordina per end -->
                </div>
                <!-- Filters ebd -->
                
                <!-- Sponsored part start -->
                <div class="fmb-50">
                    <!-- Cards utenti sponsorizzati -->
                    <router-link class="flex-row sponsor-card" @click.native="$scrollToTop"
                    v-for="(user, index) in users" :key="index"
                    :to="{ name : 'profile', params: {slug : user.slug} }">
                        <div class="flex-row justify-content-between fmb-25" v-if="user.promo_users">
                            <div class="fcol-md-11 flex-row txt-accent">
                                <!-- immagine card -->
                                <div class="fcol-xs-12 fcol-md-4 fcol-lg-5 inside-card-height">
                                    <img class="inside-card-height card-width" :src="'/storage/public/' + user.user_details.propic_url" :alt="user.name + ' ' + user.last_name">
                                </div>

                                <!-- testo card -->
                                <div class="fcol-md-6 search-text position-relative">
                                    <!-- nome e cognome -->
                                    <div class="ffxs lh-12 fmb-12">Sponsorizzato da Bootanici</div>
                                    <h3 class="fh3 text-uppercase">
                                        {{ user.name }} {{ user.last_name }}
                                    </h3>
                                    <!-- freccia mobile -->
                                    <img class="mobile-search-arrow" src="../../../public/storage/icons/arrow-right-accent.svg">

                                    
                                    <!-- specializzazioni -->
                                    <div class="ffxs text-uppercase medium-weight">Specialista in</div>
                                        <span class="specspan ffxs fmr-12" v-for="spec in user.specializations" :key="spec.id">
                                        <img class="ficon" src="../../../public/storage/icons/flower-brand.svg">
                                        {{ spec.spec_name }}
                                        </span>

                                    <!-- recensioni -->
                                    <div class="ffxs fmt-12">
                                        <span class="medium-weight">Numero recensioni:</span>
                                        <span class="fmr-12">{{ user.nVote }}</span>

                                        <span class="medium-weight">Media voti:</span>
                                        <span>{{ user.avg }}</span>
                                    </div>

                                    <!-- bio -->
                                    <p class="ffsmall lh-12 fcol-md-10 user-bio">{{ user.user_details.bio }}</p>
                                </div>
                            </div>
                            
                            <!-- freccia desktop -->
                            <div class="fcol-md-1 text-right arrow-col">
                                <img class="search-arrow" src="../../../public/storage/icons/arrow-right-accent.svg">
                            </div>
                        </div>
                        <div class="sponsor-line fmb-25" v-if="user.promo_users"></div>
                    </router-link>

                </div>
                <!-- Sponsored part end -->

                <!-- Normal Users part start -->
                <div>
                    <!-- tutti i bootanici -->
                    <h4 class="fh4 fmb-25">Tutti i Bootanici</h4>

                    <!-- Cards utenti normali -->
                    <router-link class="flex-row search-card"
                    v-for="(user, index) in users" :key="index" @click.native="$scrollToTop"
                    :to="{ name : 'profile', params: {slug : user.slug} }">
                        <div class="flex-row justify-content-between fmb-25">
                            <div class="fcol-md-11 flex-row">
                                <!-- immagine card -->
                                <div class="fcol-xs-12 fcol-md-4 fcol-lg-5 inside-card-height">
                                    <img class="inside-card-height card-width" :src="'/storage/public/' + user.user_details.propic_url" :alt="user.name + ' ' + user.last_name">
                                </div>

                                <!-- testo card -->
                                <div class="fcol-md-6 search-text position-relative">
                                    <!-- nome e cognome -->
                                    <h3 class="fh3 text-uppercase fmb-12">
                                        {{ user.name }} {{ user.last_name }}
                                    </h3>
                                    <!-- freccia mobile -->
                                    <img class="mobile-search-arrow" src="../../../public/storage/icons/arrow-right-dark.svg">

                                    <!-- specializzazioni -->
                                    <div class="ffxs text-uppercase medium-weight">Specialista in</div>
                                        <span class="specspan ffxs fmr-12" v-for="spec in user.specializations" :key="spec.id">
                                        <img class="ficon" src="../../../public/storage/icons/flower.svg">
                                        {{ spec.spec_name }}
                                        </span>

                                    <!-- recensioni -->
                                    <div class="ffxs fmt-12">
                                        <span class="medium-weight">Numero recensioni:</span>
                                        <span class="fmr-12">{{ user.nVote }}</span>

                                        <span class="medium-weight">Media voti:</span>
                                        <span>{{ user.avg }}</span>
                                    </div>

                                    <!-- bio -->
                                    <p class="ffsmall lh-12 fcol-md-10 user-bio">{{ user.user_details.bio }}</p>
                                </div>
                            </div>
                            
                            <!-- freccia desktop -->
                            <div class="fcol-md-1 text-right arrow-col">
                                <img class="search-arrow" src="../../../public/storage/icons/arrow-right-dark.svg">
                            </div>
                        </div>

                        <div class="line fmb-25"></div>
                    </router-link>
                </div>
                <!-- Normal Users part end -->

                <!-- FRECCE PAGINAZIONE -->
                <ul class="pagination">
                    <li class="page-item" :class="{'disabled' : currentPage === 0 }"><button class="page-link"  href="#" @click="getFilteredUsers('/search/' + selectValue, currentPage - 1)">Indietro</button></li>
                    <li class="page-item" v-for="i in lastPage" :key="i" @click.prevent="getFilteredUsers('/search/' + selectValue , i)"><a href="#" class="page-link">{{i}}</a>
                    </li>
                    <li class="page-item" :class="{'disabled' : currentPage === lastPage }"><button class="page-link"  href="#"  @click.prevent="getFilteredUsers('/search/' + selectValue, currentPage + 1)">Avanti</button></li>
                </ul>
            </div>
        </section>
        <!-- main part -->
    </main>
</template>

    
<script>
    export default {
        name : 'Search',
        data(){
            return{
                users : [],
                specializations : [],
                selectValue : this.$route.fullPath.slice(8, this.$route.fullPath.length),
                checkbox : false,
                checkboxVote: false,
                lastPage: null,
                currentPage: 1,
            }
        },
        created(){
            Vue.prototype.$scrollToTop = () => window.scrollTo(0,0);
            this.getFilteredUsers(this.$route.fullPath, 1);

            this.getSpecialization()
        },
        methods:{
            getFilteredUsers(route , move){
            // add le due checkbox come params 
            axios.get( '/api' +  route + '/' + this.checkbox + '/' + this.checkboxVote,{
                params: {
                    page : move
                }
            })
                .then(response => {
                    this.users = response.data.results.data;
                    console.log(this.users);

                    // prendo dall'api l'ultima pagina e quella corrente
                    this.lastPage = response.data.results.last_page;
                    this.currentPage = response.data.results.current_page;
            });
            },
            getSpecialization() {
                axios.get( '/api/specializations')
                .then(response => {
                    this.specializations = response.data.results;
                });
            },
            orderByReviews(specialization, page) {
                this.checkbox ^= true;
                // richiamo l'api che ordina per numero di reviews
                this.getFilteredUsers('/search/' + specialization, page);
            },
            orderByVotes(specialization, page) {
                this.checkboxVote ^= true;
                // richiamo l'api che ordina per media voti 
                this.getFilteredUsers('/search/' + specialization, page);
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>              


       


        
              
               
           
            


      



  


