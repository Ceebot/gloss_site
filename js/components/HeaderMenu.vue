<template>
    <div v-if="url === '/index.php' || url === '/'">
        <ul class="header__list">
            <li class="header__item">
                <button class="header__link header__link_burger"
                        @click="openBurger = true">
                    <img class="header__menu" src="img/burger-menu.svg" alt="Меню">
                </button>
            </li>
            <li class="header__item">
                <a href="index.php" class="header__link">Главная</a>
            </li>
            <li class="header__item">
                <a href="#section-do" class="header__link">Товары и услуги</a>
            </li>
            <li class="header__item">
                <a href="#section-contacts" class="header__link">Контакты</a>
            </li>
            <li class="header__item">
                <a href="#section-clients" class="header__link">Отзывы</a>
            </li>
            <div v-if="session" class="header__item">
                <a v-for="user in users" :key="user.id" href="/admin.php" class="header__link">
                    Вход: {{ user.firstname }}
                </a>
            </div>
            <div v-else class="header__item">
                <a @click="toggleLogAdmin" class="header__link">Администрирование</a>
            </div>
        </ul>

        <div class="burger" :style="{transform: toggleBurgerMenu}">
            <ul class="burger__list">
                <li class="burger__item burger__item_close" @click="openBurger = false">
                    Свернуть меню
                </li>
                <li class="burger__item">
                    <a href="index.php" class="burger__link">Главная</a>
                </li>
                <li class="burger__item">
                    <a href="#section-do" class="burger__link">Товары и услуги</a>
                </li>
                <li class="burger__item">
                    <a href="#section-contacts" class="burger__link">Контакты</a>
                </li>
                <li class="burger__item">
                    <a href="#section-clients" class="burger__link">Отзывы</a>
                </li>
                <div v-if="session" class="burger__item">
                    <a v-for="user in users" :key="user.id" href="/admin.php" class="burger__link">
                        Вход: {{ user.firstname }}
                    </a>
                </div>
                <div v-else class="burger__item">
                    <a @click="toggleLogAdmin" class="burger__link">Администрирование</a>
                </div>
            </ul>
        </div>
    </div>

    <div v-else>
        <ul class="header__list">
            <li class="header__item">
                <button class="header__link header__link_burger"
                        @click="openBurger = true">
                    <img class="header__menu" src="img/burger-menu.svg" alt="Меню">
                </button>
            </li>
            <li class="header__item header__item_settings">
                <PopupSettingsUser :users="users"/>
            </li>
            <li class="header__item">
                <a href="index.php" class="header__link">На главную страницу</a>
            </li>
        </ul>

        <div class="burger" :style="{transform: toggleBurgerMenu}">
            <ul class="burger__list">
                <li class="burger__item burger__item_close" @click="openBurger = false">
                    Свернуть меню
                </li>
                <li class="burger__item">
                    <div v-for="user in users" :key="user.id" class="burger__link burger__link_user">
                        Администратор: {{ user.firstname }} {{ user.lastname }}
                    </div>
                </li>
                <li class="burger__item">
                    <a href="index.php" class="burger__link">На главную страницу</a>
                </li>
                <li class="burger__item">
                    <a href="php/exit.php" class="burger__link">Выйти из аккаунта</a>
                </li>
            </ul>
        </div>
    </div>

    <div v-if="isShowLog" class="log case">
        <form @submit.prevent="useFetch" class="log__content animate">
            <h2 class="log__heading">Вход от администратора</h2>
            <div class="log__container">
                <label for="login">Логин</label>
                <input class="log__input"
                       id="login"
                       type="text"
                       v-model="login"
                       required
                >
                <label for="password">Пароль</label>
                <input class="log__input"
                       id="password"
                       type="password"
                       v-model="password"
                       required
                >
                <div class="log__center-btn">
                    <button class="log__btn" type="submit" :disabled="isButtonDisabled">
                        <img v-if="loading" class="loading" src="img/loading.gif" alt="Загрузка">
                        {{ loadingText }}
                    </button>
                </div>
                <div class="pass__false message" v-if="message">{{ message }}</div>
            </div>
            <div class="text-center">
                <button @click="toggleLogAdmin" class="close">Закрыть</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import PopupSettingsUser from "./PopupSettingsUser.vue";
import {ref, computed, onMounted} from "vue";

let login = ref('');
let password = ref('');
let isShowLog = ref(false);
let message = ref('');
let loading = ref(false);
let isButtonDisabled = ref(false);

const props = defineProps({
    users: Array,
    session: Boolean,
    url: String
});

const loadingText = computed(() => {
    return loading.value ? '' : 'Вход';
});

onMounted(() => {
    window.addEventListener('click', windowClose);
});

function toggleLogAdmin() {
    isShowLog.value = !isShowLog.value;
    message.value = '';
    loading.value = false;
    login.value = '';
    password.value = '';
}

function windowClose(ev) {
    const logAdmin = document.querySelector('.log');

    if (ev.target === logAdmin) {
        isShowLog.value = false;
        message.value = '';
        loading.value = false;
        login.value = '';
        password.value = '';
    }
}

async function useFetch() {
    isButtonDisabled.value = true;
    loading.value = true;
    message.value = '';

    const params = new URLSearchParams();
    params.set('login', login.value);
    params.set('password', password.value);

    let response = await fetch('php/check-log.php', {
        method: 'POST',
        body: params
    });

    let text = await response.text();

    if (text === 'success')
        location.href = 'admin.php';
    else {
        message.value = 'Неверные данные!';
        loading.value = false;
        isButtonDisabled.value = false;
    }
}

const openBurger = ref(false);

const toggleBurgerMenu = computed(() => {
    return openBurger.value ? 'translateX(0)' : 'translateX(-120%)';
})

</script>
