<template>
    <section class="section-form" id="section-form">
        <div class="container section-form__container">
            <div class="section-form__text">
                <h2 class="section-form__title">
                    Онлайн запись
                </h2>
                <Success></Success>
                <p class="section-form__description">
                    Здесь вы можете записаться на любую услугу
                </p>
            </div>
            <form @submit.prevent="useFetch" autocomplete="off" class="section-form__form">
                <div class="section-form__block-input">
                    <input required
                           type="text"
                           placeholder="Имя*"
                           class="section-form__input"
                           v-model="name"
                    >
                    <input required
                           type="tel"
                           placeholder="Телефон*"
                           class="section-form__input"
                           v-model="tel"
                    >
                    <input required
                           type="email"
                           placeholder="Почта*"
                           class="section-form__input"
                           v-model="mail"
                    >

                    <div class="section-form__div-label">
                        <label class="section-form__label" for="date">Выбрать дату: </label>
                    </div>

                    <input required
                           type="date"
                           class="section-form__input section-form__input_date"
                           v-model="date"
                    >

                    <select class="section-form__set-service"
                            v-model="selected"
                            id="section-form__position"
                    >
                        <option disabled value="">Выбрать услугу</option>
                        <option v-for="service in services" :key="service.id" :value="service.title">
                            {{ service.title }} - {{ service.description }} {{ service.price }} &#8381
                        </option>
                    </select>

                    <textarea v-model="message"
                              maxlength="1000"
                              class="section-form__textarea"
                              rows="5" type="text"
                              placeholder="Сообщение...">
                        </textarea>

                    <button class="section-form__btn-submit" type="submit" :disabled="isButtonDisabled">
                        <img v-if="loading" class="loading" src="img/loading.gif" alt="Загрузка">
                        {{ loadingText }}
                    </button>
                </div>
            </form>
        </div>
    </section>
    <div v-if="returnMessage">
        <Success @close-popup="closePopup" :returnMessage="returnMessage"></Success>
    </div>
</template>

<script setup>
import Success from "./Success.vue";
import {computed, ref} from "vue";

const props = defineProps({
    services: Array,
});

const loading = ref(false);

const loadingText = computed(() => {
    return loading.value ? '' : 'Оставить заявку';
});

const name = ref('');
const tel = ref('');
const mail = ref('');
const date = ref('');
const selected = ref('');
const message = ref('');

const isButtonDisabled = ref(false);

async function useFetch() {
    isButtonDisabled.value = true;
    loading.value = true;

    const params = new URLSearchParams();
    params.set('name', name.value);
    params.set('tel', tel.value);
    params.set('mail', mail.value);
    params.set('date', date.value);
    params.set('selected', selected.value);
    params.set('message', message.value);

    let response = await fetch('php/add/add-application.php', {
        method: 'POST',
        body: params
    });

    let text = await response.text();

    if (text === 'success') {
        name.value = '';
        tel.value = '';
        mail.value = '';
        date.value = '';
        selected.value = '';
        message.value = '';

        returnMessage.value = 'Отправлено!';
        loading.value = false;
        isButtonDisabled.value = false;
    }
}

const returnMessage = ref('');

function closePopup() {
    returnMessage.value = '';
}

</script>
