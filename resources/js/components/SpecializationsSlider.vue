<template>
    <swiper class="swiper home-swiper" :options="swiperOption">
        <swiper-slide v-for="specialization,index in specializations" :key="index">
            <div class="home-card fmy-25">
                    <div class="home-card-img-wrap">
                        <img :src="'/storage/' + specialization.spec_image" :alt="specialization.name">
                    </div>
                    <div class="flex-column fpl-25 fpt-25 fpb-25">
                        <img class="home-ficon fmb-12" src="../../../public/storage/icons/flower.svg">
                        <h4 class="fh4 lh-12 text-uppercase">{{specialization.spec_name}}</h4>
                        <!-- <p class="ffsmall lh-12">Hai bisogno di uno specialista in {{specialization.spec_name}}? Clicca qui per cercarlo</p> -->
                    </div>

                    <router-link @click.native="$scrollToTop" class="home-wrap-link" :to="{ name : 'search', params: {slug_specialization : specialization.slug_specialization}}">
                        <div class="home-card-btn ffsmall text-uppercase fpx-25 fpy-12 flex-row w-100 justify-content-between align-items-center">
                            <span class="btn-card-text fcol-xs-11">vai agli esperti</span>
                            <img class="home-btn-ficon fcol-xs-1" src="../../../public/storage/icons/arrow-right-dark.svg">
                            <img class="home-btn-ficon home-ficon-hover" src="../../../public/storage/icons/arrow-right.svg">
                            <span class="btn-card-hover"></span>
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
    name: 'SpecializationsSlider',
    components:{
        Swiper,
        SwiperSlide
    },
    directives: {
        swiper: directive
    },
    props:{
        specializations: Array
    },
    data(){
        return{
            swiperOption: {
                slidesPerView: 2,
                spaceBetween: 15,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                }
            }
        }
    },
    methods : {
        scrollToTop() {
            window.scrollTo(0,0);
        }
    }
}
</script>

<style>

</style>