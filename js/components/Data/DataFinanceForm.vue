<template>
    <section class="add">
        <h1 class="container section-heading">Управление финансами</h1>
        <div class="container add__container">
            <div class="add__table">
                <h2 class="section-heading text-center add__heading">Доход</h2>
                <form @submit.prevent="sendingData('income')" autocomplete="off">
                    <ul class="add__list">
                        <li class="add__item">
                            <label class="add__item-label" for="income-name">Название: </label>
                            <input class="add__input"
                                   id="income-name"
                                   type="text"
                                   v-model="incName"
                                   required
                            >
                        </li>
                        <li class="add__item">
                            <label class="add__item-label" for="income-quantity">Количество: </label>
                            <input class="add__input"
                                   id="income-quantity"
                                   type="number"
                                   v-model="incQuantity"
                                   required
                            >
                        </li>
                        <li class="add__item">
                            <label class="add__item-label" for="income-price">Цена: </label>
                            <input class="add__input"
                                   id="income-price"
                                   type="text"
                                   v-model="incPrice"
                                   required
                            >
                        </li>
                        <li class="add__item">
                            <label class="add__item-label" for="income-date">Дата: </label>
                            <input class="add__input"
                                   required
                                   id="income-date"
                                   v-model="incDate"
                                   type="date"
                            >
                        </li>
                    </ul>
                    <div class="add__btn-center">
                        <button type="submit" class="add__item-btn finance-btn" :disabled="isButtonDisabled">
                            <img v-if="loadingInc" class="loading" src="img/loading.gif" alt="Загрузка">
                            {{ loadingTextInc }}
                        </button>
                    </div>
                </form>
            </div>

            <div class="add__table">
                <h2 class="section-heading text-center add__heading">Расход</h2>
                <form @submit.prevent="sendingData('expense')" autocomplete="off">
                    <ul class="add__list">
                        <li class="add__item">
                            <label class="add__item-label" for="expense-name">Название: </label>
                            <input class="add__input"
                                   id="expense-name"
                                   type="text"
                                   v-model="expName"
                                   required
                            >
                        </li>
                        <li class="add__item">
                            <label class="add__item-label" for="expense-quantity">Количество: </label>
                            <input class="add__input"
                                   id="expense-quantity"
                                   type="number"
                                   v-model="expQuantity"
                                   required
                            >
                        </li>
                        <li class="add__item">
                            <label class="add__item-label" for="expense-price">Цена: </label>
                            <input class="add__input"
                                   id="expense-price"
                                   type="text"
                                   v-model="expPrice"
                                   required
                            >
                        </li>
                        <li class="add__item">
                            <label class="add__item-label" for="expense-date">Дата: </label>
                            <input class="add__input"
                                   id="expense-date"
                                   type="date"
                                   v-model="expDate"
                                   required
                            >
                        </li>
                    </ul>
                    <div class="add__btn-center">
                        <button type="submit" class="add__item-btn finance-btn">
                            <img v-if="loadingExp" class="loading" src="img/loading.gif" alt="Загрузка">
                            {{ loadingTextExp }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>

<script setup>
import {ref, computed} from "vue";

const loadingInc = ref(false);

const loadingTextInc = computed(() => {
    return loadingInc.value ? '' : 'Сохранить';
});

const loadingExp = ref(false);

const loadingTextExp = computed(() => {
    return loadingExp.value ? '' : 'Сохранить';
});

const emit = defineEmits(['send-form-data'])

const incName = ref('');
const incQuantity = ref('');
const incPrice = ref('');
const incDate = ref('');

const expName = ref('');
const expQuantity = ref('');
const expPrice = ref('');
const expDate = ref('');

function sendingData(typeName) {

    const params = new URLSearchParams()

    if (typeName === 'income') {

        loadingInc.value = true;

        setTimeout(() => {
            loadingInc.value = false;
        }, 2000);

        params.set('name', incName.value);
        params.set('quantity', incQuantity.value);
        params.set('price', incPrice.value);
        params.set('date', incDate.value);
        params.set('type', 'income');

    } else {

        loadingExp.value = true;

        setTimeout(() => {
            loadingExp.value = false;
        }, 2000);

        params.set('name', expName.value);
        params.set('quantity', expQuantity.value);
        params.set('price', expPrice.value);
        params.set('date', expDate.value);
        params.set('type', 'expense');
    }

    emit('send-form-data', params);

    incName.value = '';
    incQuantity.value = '';
    incPrice.value = '';
    incDate.value = '';

    expName.value = '';
    expQuantity.value = '';
    expPrice.value = '';
    expDate.value = '';
}

</script>
