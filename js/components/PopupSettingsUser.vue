<template>
    <div v-for="user in users" :key="user.id">
        <button class="btn btn-secondary dropdown-toggle"
                @click="togglePopupUserSettings"
        >
            Администратор: {{ user.firstname }} {{ user.lastname }}
        </button>
    </div>
    <transition name="show-popup-settings">
        <div v-if="settingsUser" class="popup-settings-user">
            <ul class="popup-settings-user__list">
                <li class="popup-settings-user__item">
                    <a @click="showChangePass" href="#" class="popup-settings-user__link">Сменить пароль</a>
                </li>
                <li class="popup-settings-user__item">
                    <a href="php/exit.php" class="popup-settings-user__link">Выйти из аккаунта</a>
                </li>
            </ul>
        </div>
    </transition>

    <transition name="show-change-password">

        <div v-if="toggleChangePass" class="change-pass case">

            <form @submit.prevent="changePass" class="change-pass__form">

                <div class="change-pass__user-icon"></div>

                <h2 class="change-pass__title">Сменить пароль</h2>

                <input class="change-pass__input"
                       type="password"
                       placeholder="Старый пароль"
                       required
                       v-model="oldPassword"
                >

                <input class="change-pass__input"
                       type="password"
                       placeholder="Новый пароль"
                       required
                       v-model="newPassword"
                >

                <input class="change-pass__input"
                       type="password"
                       placeholder="Подтверждение пароля"
                       required
                       v-model="confirmPassword"
                >

                <button class="change-pass__submit" type="submit">Подтвердить</button>

                <div class="pass__false message" v-if="showError">{{ responseText }}</div>
            </form>
        </div>
    </transition>

    <Success v-if="isShowSuccess" :returnMessage="responseText" @close-popup="closeSuccessPopup"/>

</template>

<script setup>

import {ref, onMounted, onBeforeUnmount} from "vue";
import Success from "./Success.vue";

const props = defineProps({
    users: Array
});

const settingsUser = ref(false);

function closePopupSettings(ev) {
    if (!ev.target.closest('.popup-settings-user') && settingsUser.value)
        settingsUser.value = false;
}

onMounted(() => {
    document.addEventListener('click', closePopupSettings);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', closePopupSettings)
});

function togglePopupUserSettings(ev) {
    ev.stopPropagation();
    settingsUser.value = !settingsUser.value;
}

const toggleChangePass = ref(false);

onMounted(() => {
    document.addEventListener('click', onChangePass)
})

function onChangePass(ev) {
    const blockChangePass = document.querySelector('.change-pass');

    if (ev.target === blockChangePass)
        toggleChangePass.value = false;
}

function showChangePass() {
    settingsUser.value = false;
    toggleChangePass.value = true;
}

const oldPassword = ref('');
const newPassword = ref('');
const confirmPassword = ref('');

const responseText = ref('');

const showError = ref(false);

const isShowSuccess = ref(false);

async function changePass() {

    showError.value = false;

    responseText.value = '';

    const params = new URLSearchParams();

    params.set('oldPassword', oldPassword.value);
    params.set('newPassword', newPassword.value);
    params.set('confirmPassword', confirmPassword.value);

    let response = await fetch('php/change-password.php', {
       method: 'POST',
       body: params
    });

    let text = await response.text();

    switch (text) {
        case 'success':
            toggleChangePass.value = false;

            responseText.value = 'Пароль изменен!';

            isShowSuccess.value = true;

            oldPassword.value = '';
            newPassword.value = '';
            confirmPassword.value = '';

            break;

        case 'error-confirm-password':
            responseText.value = 'Ошибка подтверждения пароля!';

            confirmPassword.value = '';

            showError.value = true;

            break;

        case 'error-old-pass-equl-new-pass':
            responseText.value = 'Старый пароль равен новому!';

            newPassword.value = '';
            confirmPassword.value = '';

            showError.value = true;

            break;

        case 'error-old-pass':
            responseText.value = 'Неверный старый пароль!';

            oldPassword.value = '';

            showError.value = true;

            break;
    }

    console.log(text);
}

function closeSuccessPopup() {
    isShowSuccess.value = false;
}



</script>
