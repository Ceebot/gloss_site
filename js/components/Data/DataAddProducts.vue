<template>
    <div v-if="description === 'products'" class="add-product case">
        <div class="add__wrap animate">
            <h2 class="text-center">Добавить товар</h2>
            <form @submit.prevent="addProducts('products')" autocomplete="off">
                <div class="add__item">
                    <label class="add__item-label" for="product-name">Название: </label>
                    <input required
                           type="text"
                           id="product-name"
                           class="add__input"
                           v-model="productName"
                    >
                </div>
                <div class="add__item">
                    <label class="add__item-label" for="product-volume">Объем (мм): </label>
                    <input required
                           type="text"
                           id="product-volume"
                           class="add__input"
                           v-model="productVolume"
                    >
                </div>
                <div class="add__item">
                    <label class="add__item-label" for="product-price">Цена: </label>
                    <input required
                           type="text"
                           id="product-price"
                           class="add__input"
                           v-model="productPrice"
                    >
                </div>
                <div class="text-center">
                    <button type="submit" class="finance-btn add__submit" :disabled="buttonDisabled">
                        {{ loadingText }}
                        <img v-if="loading" class="loading" src="img/loading.gif" alt="Загрузка">
                    </button>
                </div>
            </form>
            <div class="text-center">
                <button class="close" @click="emits('close-popup-add-product')">Отменить</button>
            </div>
        </div>
    </div>

    <div v-if="description === 'services'" class="add-product case">
        <div class="add__wrap animate">
            <h2 class="text-center">Добавить услугу</h2>
            <form @submit.prevent="addProducts('services')" autocomplete="off">
                <div class="add__item">
                    <label class="add__item-label" for="service-name">Название: </label>
                    <input required
                           type="text"
                           id="service-name"
                           class="add__input"
                           v-model="serviceName"
                    >
                </div>
                <div class="add__item">
                    <label class="add__item-label" for="service-description">Приписка (от): </label>
                    <input type="text"
                           id="service-description"
                           class="add__input"
                           v-model="serviceDescription"
                    >
                </div>
                <div class="add__item">
                    <label class="add__item-label" for="service-price">Цена: </label>
                    <input required
                           type="text"
                           id="service-price"
                           class="add__input"
                           v-model="servicePrice"
                    >
                </div>
                <div class="add__item">
                    <label class="add__item-label" for="service-img">Фоновый рисунок: </label>
                    <input required
                           type="text"
                           id="service-img"
                           class="add__input"
                           v-model="serviceImg"
                    >
                </div>
                <div class="text-center">
                    <button type="submit" class="finance-btn add__submit" :disabled="buttonDisabled">
                        {{ loadingText }}
                        <img v-if="loading" class="loading" src="img/loading.gif" alt="Загрузка">
                    </button>
                </div>
            </form>
            <div class="text-center">
                <button class="close" @click="emits('close-popup-add-product')">Отменить</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref, onMounted, computed} from "vue";

const props = defineProps({
    description: String,
});

const emits = defineEmits(['close-popup-add-product', 'update-products']);

const mount = onMounted(() => {
        window.addEventListener('click', (event) => {
                const wrapper = document.querySelector('.case');
                if (event.target === wrapper) emits('close-popup-add-product');
            }
        )
    }
);

const productName = ref('');
const productVolume = ref('');
const productPrice = ref('');

const serviceName = ref('');
const serviceDescription = ref('');
const servicePrice = ref('');
const serviceImg = ref('background-blur.jpg');

async function addProducts(typeName) {
    buttonDisabled.value = true;
    loading.value = true;
    const params = new URLSearchParams();
    params.set('typeName', typeName);

    if (typeName === 'products') {
        params.set('name', productName.value);
        params.set('volume', productVolume.value);
        params.set('price', productPrice.value);
    }
    if (typeName === 'services') {
        params.set('name', serviceName.value);
        params.set('description', serviceDescription.value);
        params.set('price', servicePrice.value);
        params.set('img', serviceImg.value);
    }

    const response = await fetch('php/add/add-products.php', {
        method: 'POST',
        body: params,
    })

    let text = await response.text();
    if (text === 'success') {
        buttonDisabled.value = false;
        loading.value = false;

        emits('update-products');
        emits('close-popup-add-product');
    }
}

const buttonDisabled = ref(false);

const loading = ref(false);
const loadingText = computed(() => {
    return loading.value ? '' : 'Выбрать';
});

</script>
