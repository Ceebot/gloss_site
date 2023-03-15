<template>
    <section class="select-period">
        <div class="container select-period__container">
            <h2 class="section-heading">Выбрать период подсчета доходов:</h2>
            <div class="form-check form-flex">
                <input class="form-check-input check-margin"
                       type="radio"
                       name="flexRadioDefault"
                       id="allTime"
                       value="За все время"
                       v-model="picked"
                >
                <label class="form-check-label" for="allTime">За все время</label>
            </div>

            <div class="form-check form-flex">
                <input class="form-check-input check-margin"
                       type="radio"
                       name="flexRadioDefault"
                       id="lastMonth"
                       value="За последний месяц"
                       v-model="picked"
                >
                <label class="form-check-label" for="lastMonth">За последний месяц</label>
            </div>
            <div class="form-check form-flex">
                <input class="form-check-input check-margin"
                       type="radio"
                       name="flexRadioDefault"
                       id="lastDay"
                       value="За последний день"
                       v-model="picked"
                >
                <label class="form-check-label" for="lastDay">За последний день</label>
            </div>
            <div class="form-check form-flex form-flex_period">
                <input class="form-check-input check-margin"
                       type="radio"
                       name="flexRadioDefault"
                       id="period"
                       value="За период с"
                       v-model="picked"
                >
                <label class="form-check-label" for="period">За период с </label>
                <input class="select-period__input"
                       type="date"
                       name="begin-date"
                       id="select-period-begin"
                       v-model="firstDate"
                >
                <label for="select-period-end" class="select-period__label"> по: </label>
                <input class="select-period__input"
                       type="date"
                       name="end-date"
                       id="select-period-end"
                       v-model="lastDate"
                >
            </div>
            <button @click="selectPeriod"
                    class="select-period__btn finance-btn"
            >
                <img v-if="loading" class="loading" src="img/loading.gif" alt="Загрузка">
                {{ loadingText }}
            </button>
        </div>
    </section>

    <div v-if="tablesShow" class="finance-container container">
        <h2 class="section-heading">Таблица доходов</h2>
        <div class="table-wrap">
            <table class="table table-hover table-striped finance-table">
                <thead class="table-dark">
                <tr>
                    <th scope="col">№</th>
                    <th scope="col">Название</th>
                    <th scope="col">Количество</th>
                    <th scope="col">Цена</th>
                    <th scope="col">Дата</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, index) in income"
                    :key="item.id"
                    @contextmenu.prevent="popupEditRow($event, item)"
                    class="cursor-pointer"
                >
                    <th scope="row">{{ index + 1 }}</th>
                    <td>{{ item.name }}</td>
                    <td>{{ item.quantity }} шт</td>
                    <td>{{ item.price }} &#8381</td>
                    <td>{{ item.date }}</td>
                </tr>
                </tbody>
                <tfoot>
                <tr class="table-dark">
                    <th colspan="5">Сумма доходов: {{ incomePrice }} &#8381</th>
                </tr>
                </tfoot>
            </table>
        </div>

        <h2 class="section-heading">Таблица расходов</h2>
        <div class="table-wrap">
            <table class="table table-hover table-striped finance-table">
                <thead>
                <tr class="table-dark">
                    <th scope="col">№</th>
                    <th scope="col">Название</th>
                    <th scope="col">Количество</th>
                    <th scope="col">Цена</th>
                    <th scope="col">Дата</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, index) in expense"
                    :key="item.id"
                    @contextmenu.prevent="popupEditRow($event, item)"
                    class="cursor-pointer"
                >
                    <th scope="row">{{ index + 1 }}</th>
                    <td>{{ item.name }}</td>
                    <td>{{ item.quantity }} шт</td>
                    <td>{{ item.price }} &#8381</td>
                    <td>{{ item.date }}</td>
                </tr>
                </tbody>
                <tfoot>
                <tr class="table-dark">
                    <th colspan="5">Сумма расходов: {{ expensePrice }} &#8381</th>
                </tr>
                </tfoot>
            </table>
        </div>

        <div class="result">
            Результат {{ totalAmount }}
        </div>
    </div>


    <transition class="bounce" name="bounce">
        <div v-if="isPopupEdit" class="popup-edit_wrapper">
            <div class="popup-edit" :style="{left: editX + 'px', top: editY - 80 + 'px'}">
                <button @click="popupDeleteCurrentRow" class="popup-edit__btn text-center">
                    <img class="popup-edit__img" src="img/delete-row.png" alt="Удалить">
                </button>
                <button @click="popupEditCurrentRow" class="popup-edit__btn text-center">
                    <img class="popup-edit__img" src="img/edit-row.png" alt="Редактировать">
                </button>
            </div>
        </div>
    </transition>

    <div v-if="isShowDelete" class="case edit">
        <div class="container edit__container animate">
            <h2 class="section-heading-big text-center">Подтвердить удаление</h2>
            <div class="edit__description text-center">
                Вы уверены, что хотите удалить строку с названием <strong>`{{ currentRow.name }}`</strong> ?
            </div>
            <div class="text-center edit-btn-width">
                <button @click="sendingEditRow('delete')" class="edit__btn">
                    {{ loadingTextDelete }}
                    <img v-if="loadingDelete" class="loading" src="img/loading.gif" alt="Загрузка">
                </button>
            </div>
            <div class="text-center">
                <button @click="isShowDelete = false" class="close">Отменить</button>
            </div>
        </div>
    </div>

    <section v-if="isShowEdit" class="case edit">
        <div class="container edit__container animate">
            <h2 class="section-heading-big text-center">Редактировать строку</h2>
            <form @submit.prevent="sendingEditRow('edit')" class="edit__form" autocomplete="off">
                <div class="edit__item">
                    <label class="edit__label" for="name">Название: </label>
                    <input type="text" id="name" class="edit__input" v-model="editName">
                </div>
                <div class="edit__item">
                    <label class="edit__label" for="quantity">Количество: </label>
                    <input type="number" id="quantity" class="edit__input" v-model="editQuantity">
                </div>
                <div class="edit__item">
                    <label class="edit__label" for="price">Цена: </label>
                    <input type="text" id="price" class="edit__input" v-model="editPrice">
                </div>
                <div class="edit__item">
                    <label class="edit__label" for="date">Дата: </label>
                    <input id="date" class="edit__input" type="date" v-model="editDate">
                </div>
                <div class="text-center">
                    <button type="submit" class="edit__btn">
                        {{ loadingTextEdit }}
                        <img v-if="loadingEdit" class="loading" src="img/loading.gif" alt="Загрузка">
                    </button>
                </div>
            </form>
            <div class="text-center">
                <button class="close" @click="isShowEdit = false">Отменить</button>
            </div>
        </div>
    </section>
</template>

<script setup>
import {computed, ref, onMounted} from "vue";

const props = defineProps({
    finance: Array,
    loadAnimate: Boolean,
});

const incomePrice = ref(0);
const expensePrice = ref(0);

const income = computed(() => {

    incomePrice.value = 0;

    return props.finance.filter(item => {

        if (item.type === 'income') {

            incomePrice.value += (Number(item.price) * Number(item.quantity));

            return item.type;
        }
    })
});

const expense = computed(() => {

    expensePrice.value = 0;

    return props.finance.filter(item => {

        if (item.type === 'expense') {

            expensePrice.value += (Number(item.price) * Number(item.quantity));

            return item.type;
        }
    })
});

const picked = ref('');
const firstDate = ref('');
const lastDate = ref('');

const tablesShow = ref(false);

const emit = defineEmits(['update-finance']);

const loading = ref(false);

const loadingText = computed(() => {

    return loading.value ? '' : 'Выбрать';
});

function selectPeriod() {

    loading.value = props.loadAnimate;

    let params = new URLSearchParams();

    if (picked.value === 'За период с') {

        params.set('firstDate', firstDate.value);
        params.set('lastDate', lastDate.value);
    }

    params.set('period', picked.value);

    emit('update-finance', params);

    tablesShow.value = true;
    loading.value = false;
}

const mounted = onMounted(() => {
    window.addEventListener('click', windowClose);
});

function windowClose(ev) {

    const edit = document.querySelector('.popup-edit_wrapper');

    if (ev.target === edit)
        isPopupEdit.value = !isPopupEdit.value;

    const editCurrentRow = document.querySelector('.edit');

    if (ev.target === editCurrentRow) {

        isShowDelete.value = false;
        isShowEdit.value = false;
    }
}

const isPopupEdit = ref(false);
const editX = ref(null);
const editY = ref(null);

const currentRow = ref({});

function popupEditRow(ev, item) {

    isPopupEdit.value = false;

    setTimeout(() => {
        isPopupEdit.value = true;
    }, 0);

    editX.value = ev.clientX;
    editY.value = ev.clientY;
    currentRow.value = item;
}

const isShowDelete = ref(false);

function popupDeleteCurrentRow() {
    isPopupEdit.value = false;
    isShowDelete.value = true;
}

const editName = ref('');
const editQuantity = ref(null);
const editPrice = ref(null);
const editDate = ref(null);
const isShowEdit = ref(false);

function popupEditCurrentRow() {

    isPopupEdit.value = false;
    isShowEdit.value = true;

    editName.value = currentRow.value.name;
    editQuantity.value = currentRow.value.quantity;
    editPrice.value = currentRow.value.price;
    editDate.value = currentRow.value.date;
}

const loadingEdit = ref(false);

const loadingTextEdit = computed(() => {
    return loadingEdit.value ? '' : 'Редактировать';
});

const loadingDelete = ref(false);

const loadingTextDelete = computed(() => {
    return loadingDelete.value ? '' : 'Удалить';
});

async function sendingEditRow(description) {

    const params = new URLSearchParams();

    params.set('id', currentRow.value.id);
    params.set('typeManagement', 'finance');
    params.set('description', description);

    if (description === 'edit') {

        loadingEdit.value = true;
        params.set('name', editName.value);
        params.set('quantity', editQuantity.value);
        params.set('price', editPrice.value);
        params.set('date', editDate.value);

    } else {

        loadingDelete.value = true;
    }

    let response = await fetch('php/edit/edit-row.php', {
        method: 'POST',
        body: params,
    });

    let text = await response.text();

    console.log(text);

    emit('update-finance');

    if (text === 'success') {
        loadingEdit.value = false;
        isShowEdit.value = false;

        loadingDelete.value = false;
        isShowDelete.value = false;
    }
}

const totalAmount = computed(() => {

    let summ = incomePrice.value - expensePrice.value;

    let result = '';

    if (summ >= 0) result = 'доход';

    else result = 'убыток';

    if (picked.value !== 'За период с')
        return `${picked.value.toLowerCase()}: ${result} ${summ} ₽`;

    else return `${picked.value.toLowerCase()} ${firstDate.value} по ${lastDate.value}: ${result} ${summ} ₽`;
});

</script>

