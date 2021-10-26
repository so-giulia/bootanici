<template>
    <swiper class="swiper mob-sw home-swiper" :options="swiperOption">
        <swiper-slide class="profile-swiper-slide"  v-for="img,index in portfolio" :key="index">
            <div class="profile-img-wrap">
                <img :src="'/storage/' + img.image_url">
            </div>
        </swiper-slide>
                
        <div class="home-swiper-pagination swiper-pagination" slot="pagination"></div>
    </swiper>
</template>

<script>
import { Swiper, SwiperSlide, directive } from 'vue-awesome-swiper';;
import 'swiper/css/swiper.css';

export default {
    name: 'MobileSwiper',
    components:{
        Swiper,
        SwiperSlide
    },
    directives: {
        swiper: directive,
    },
    props:{
        portfolio: Array
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
    },
}
</script>

<style>

</style>