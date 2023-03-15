<template>
    <swiper
        :slidesPerView="quantityPicture"
        :modules="modules"
        :space-between="40"
        :loop="true"
        :pagination="{clickable: true}"
        :autoplay="{
        delay: 3000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
        }"
    >
        <swiper-slide class="do__list-services" v-for="(service, id) in services" :key="service.id">
            <div class="do__item-services"
                 :style="{
                backgroundImage: 'url(img/services/' + service.img + ')',
                alignItems: findNumberPicture(id),
            }"
            >
                <div class="do__item-services-content">
                    <strong class="do__item-services-heading">
                        {{ service.title }}
                    </strong>
                    <p class="do__item-services-description">
                        {{ service.description }} {{ service.price }} &#8381
                    </p>
                </div>
            </div>
            <div class="swiper-pagination swiper-custom"></div>
        </swiper-slide>
    </swiper>
</template>

<script setup>
import {Swiper, SwiperSlide} from 'swiper/vue';
import {Autoplay, Pagination} from 'swiper';
import 'swiper/swiper-bundle.css';
import 'swiper/css/pagination';
import {ref} from 'vue';

const props = defineProps({
    services: Array,
});

const modules = ref([Pagination, Autoplay]);

function findNumberPicture(id) {
    if (id % 2 === 0)
        return 'flex-end';
    else return 'flex-start';
}

const quantityPicture = ref(2);

const mediaQuery = window.matchMedia('(max-width: 1024px)');

function identifySizeScreen(e) {
    if (e.matches) {
        quantityPicture.value = 1;
    } else quantityPicture.value = 2;
}

mediaQuery.addListener(identifySizeScreen);
identifySizeScreen(mediaQuery);
</script>
