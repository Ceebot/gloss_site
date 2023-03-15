<template>
    <a @click="toggleProducts" class="do__button">Открыть весь каталог</a>

    <div v-if="isShow" class="catalog case">
        <div class="catalog__content animate">
            <div class="catalog__content-top">
                <h2 class="catalog__heading">Каталог товаров</h2>
                <span @click="toggleProducts" class="catalog__close" title="Закрыть окно">x</span>
            </div>
            <div class="catalog__container">
                <ul class="catalog__list-product">
                    <li v-for="product in products" :key="product.id" class="catalog__item-product">
                        <strong class="catalog__item-product-heading">
                            {{ product.title }} {{ product.volume }} мл
                        </strong>
                        <p class="catalog__item-product-description">
                            {{ product.price }} &#8381
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref, onMounted} from "vue";

const props = defineProps({
    products: Array,
});

const mount = onMounted(() => {
    window.addEventListener('click', windowClose);
});

let isShow = ref(false);

function toggleProducts() {
    isShow.value = !isShow.value;
}

function windowClose(ev) {
    const catalog = document.querySelector('.catalog');

    if (ev.target === catalog) {
        isShow.value = false;
    }
}

</script>
