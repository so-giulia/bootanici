<template>
<swiper class="swiper evidenza-slider-mobile home-swiper fmb-25" :options="swiperOption">
    <swiper-slide v-for="sponsor,index in sponsored" :key="index">
        <div class="evidenza-card fmy-25">
            <!-- foto profilo -->
            <div class="evidenza-card-img-wrap">
                <img class="profile-propic" :src="'/storage/public/' + sponsor.user_details.propic_url" :alt="sponsor.name + sponsor.last_name">
            </div>

            <!-- info -->
            <div class="flex-column sponsored-info fpl-12 fpt-25 fpr-12 fpb-25">
                <!-- name -->
                <h4 class="fh4 lh-1 text-uppercase">
                    {{sponsor.name}} {{sponsor.last_name}}
                </h4>
                <!-- specializations -->
                <div class="ffxs txt-accent lh-12 fmb-25">
                    <span class="medium-weight">Specialista in</span>
                        <span class="sponsored-specs" v-for="spec in sponsor.specializations" :key="spec.id">
                            {{spec.spec_name}}<span class="sponsor-separator">, </span>
                        </span>
                </div>
                <!-- bio -->
                <p class="ffsmall lh-12 sponsored-bio">
                    {{sponsor.user_details.bio}}
                </p>
            </div>

            <!-- da cambiare in router-link -->
            <router-link @click.native="$scrollToTop" class="home-wrap-link" :to="{ name : 'profile', params: {slug : sponsor.slug}}">
                <div class="home-card-btn ffsmall text-uppercase fpx-25 fpy-12 flex-row w-100 justify-content-between align-items-center">
                    <span class="btn-light-text fcol-xs-11">vai al profilo</span>
                    <img class="mobile-btn-ficon fcol-xs-1" src="../../../public/storage/icons/arrow-right.svg">
                </div>
            </router-link>
        </div>
    </swiper-slide>
    <div class="home-swiper-pagination swiper-pagination" slot="pagination"></div>
</swiper>
</template>

<script>
import { Swiper, SwiperSlide, directive } from 'vue-awesome-swiper';
import 'swiper/css/swiper.css';
export default {
    name:'EvidenzaSliderMobile',
    components:{
        Swiper,
        SwiperSlide,
    },
    props:{
        specializations: Array,
        sponsored: Array
    },
    directives: {
        swiper: directive
    },
    data(){
        return{
            swiperOption: {
                slidesPerView: 1,
                spaceBetween: 15,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                }
            }
        }
    }
}
</script>

<style lang="scss">

</style>