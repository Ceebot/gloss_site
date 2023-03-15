<template>
    <section class="clients" id="section-clients">
        <div class="container clients__container">
            <h2 class="section-heading clients__heading">Отзывы наших клиентов</h2>
            <ul class="clients__list">
                <li v-for="review in reviews" :key="review.id" class="clients__item">
                    <p class="clients__testimonial">
                        {{ review.message }}
                    </p>
                    <div class="clients__user">
                        <img src="img/user.svg" alt="Аватар" class="clients__avatar">
                        <div class="clients__user-info">
                            <div class="clients__username">
                                {{ review.name }}
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <button @click="toggleReview" class="clients__button-review">Оставить отзыв или пожелание</button>
        </div>
    </section>

    <div v-if="isShow" class="review case">
        <div class="review__content animate">
            <h2 class="review__heading text-center">Оставить отзыв</h2>
            <form @submit.prevent="useFetch" class="review__container" autocomplete="off">

                <div class="review__name">
                    <label class="review__label" for="review-name">Ваше имя*</label>
                    <input required
                           v-model="name"
                           maxlength="35"
                           class="review__input"
                           id="review-name"
                           type="text"
                    >
                </div>

                <div class="review__mail">
                    <label class="review__label" for="review-mail">Ваш E-Mail* <span class="review__desc">(не отображается на сайте)</span></label>
                    <input required
                           v-model="mail"
                           maxlength="45"
                           class="review__input"
                           id="review-mail"
                           type="email"
                    >
                </div>

                <label class="review__label" for="review-text">Ваш Отзыв*</label>
                <textarea required
                          v-model="message"
                          maxlength="500"
                          class="review__textarea"
                          id="review-text"
                          rows="5"
                          type="text">
                    </textarea>

                <div class="text-center">
                    <button :disabled="isButtonDisabled" type="submit"
                            class="review__add-review">
                        <img v-if="loading" class="loading" src="img/loading.gif" alt="Загрузка">
                        {{ loadingText }}
                    </button>
                    <button @click="toggleReview" class="close">Закрыть</button>
                </div>
            </form>
        </div>
    </div>
    <div v-if="returnMessage">
        <Success @close-popup="closePopup" :returnMessage="returnMessage"></Success>
    </div>
</template>

<script setup>
import Success from "./Success.vue";
import {ref, computed, onMounted} from "vue";

const props = defineProps({
    initReviews: Array,
});
let reviews = ref(props.initReviews);

let loading = ref(false);
const loadingText = computed(() => {
    return loading.value ? '' : 'Отправить';
});

const mount = onMounted(() => {
    window.addEventListener('click', windowClose);
});

let isShow = ref(false);

function toggleReview() {
    isShow.value = !isShow.value;
}

function windowClose(ev) {
    const review = document.querySelector('.review');
    if (ev.target === review) {
        isShow.value = !isShow.value;
    }
}

let name = ref('');
let mail = ref('');
let message = ref('');

let returnMessage = ref('');
let isButtonDisabled = ref(false);

async function useFetch() {
    isButtonDisabled.value = true;
    loading.value = true;

    const params = new URLSearchParams();
    params.set('name', name.value);
    params.set('mail', mail.value);
    params.set('message', message.value);

    let response = await fetch('php/add/add-review.php', {
        method: 'POST',
        body: params
    });

    let text = await response.text();

    if (text === 'success') {
        isShow.value = !isShow.value;

        name.value = '';
        mail.value = '';
        message.value = '';

        loading.value = false;
        isButtonDisabled.value = false

        returnMessage.value = 'Отправлено!';

        await getReviews();
    }
}

async function getReviews() {
    let result = await fetch('php/select-reviews.php');
    reviews.value = await result.json();
}

function closePopup() {
    returnMessage.value = '';
}

</script>
