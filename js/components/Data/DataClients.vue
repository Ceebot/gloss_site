<template>
    <div class="finance-container container mt-5">
        <h2 class="section-heading">Заявки клиентов</h2>
        <div class="table-wrap">
            <table class="table table-hover table-striped finance-table">
                <thead class="table-dark">
                <tr>
                    <th scope="col">№</th>
                    <th scope="col">Имя</th>
                    <th scope="col">Телефон</th>
                    <th scope="col">Почта</th>
                    <th scope="col">Сообщение</th>
                    <th scope="col">Дата</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, index) in applications"
                    :key="item.id"
                    @contextmenu.prevent="popupDeleteRow($event, item, 'applications')"
                    class="cursor-pointer"
                >
                    <th scope="row">{{ index + 1 }}</th>
                    <td>{{ item.name }}</td>
                    <td>{{ item.tel }}</td>
                    <td>{{ item.mail }}</td>
                    <td :title="item.text">{{ limitSymbolsReview(item.text, 40) }}</td>
                    <td>{{ item.date }}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <h2 class="section-heading">Отзывы клиентов</h2>
        <div class="table-wrap">
            <table class="table table-hover table-striped finance-table">
                <thead class="table-dark">
                <tr>
                    <th scope="col">№</th>
                    <th scope="col">Имя</th>
                    <th scope="col">Почта</th>
                    <th scope="col">Сообщение</th>
                    <th scope="col">Дата публикации</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, index) in reviews"
                    :key="item.id"
                    @contextmenu.prevent="popupDeleteRow($event, item, 'reviews')"
                    class="cursor-pointer"
                >
                    <th scope="row">{{ index + 1 }}</th>
                    <td>{{ item.name }}</td>
                    <td>{{ item.mail }}</td>
                    <td :title="item.review">{{ limitSymbolsReview(item.review, 55) }}</td>
                    <td>{{ item.date }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <transition class="bounce" name="bounce">
        <div v-if="isPopupEdit" class="popup-edit_wrapper ">
            <div class="popup-edit popup-edit__only-btn" :style="{left: editX + 'px', top: editY - 80 + 'px',}">
                <button @click="popupDeleteCurrentRow" class="popup-edit__btn text-center">
                    <img class="popup-edit__img" src="img/delete-row.png" alt="Удалить">
                </button>
            </div>
        </div>
    </transition>

    <div v-if="isShowDelete" class="case edit">
        <div class="container edit__container animate">
            <h2 class="section-heading-big text-center">Подтвердить удаление</h2>
            <div class="edit__description text-center">
                Вы уверены, что хотите удалить строку клиента {{ currentRow.name }} ?
            </div>
            <div class="text-center edit-btn-width">
                <button @click="sendingDeleteRow" class="edit__btn">
                    {{ loadingTextDelete }}
                    <img v-if="loadingDelete" class="loading" src="img/loading.gif" alt="Загрузка">
                </button>
            </div>
            <div class="text-center">
                <button @click="isShowDelete = false" class="close">Отменить</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import {computed, onMounted, ref} from "vue";

const props = defineProps({
    data: Array,
});

function limitSymbolsReview(review, limit) {
    let reviewArray = review.split('');
    let reviewWord = '';
    for (let i = 0; i < limit; i++) {
        if (reviewArray.length <= i) {
            return reviewWord;
        } else reviewWord += reviewArray[i];
    }
    return `${reviewWord}...`;
}

const mount = onMounted(() => {
    window.addEventListener('click', windowClose);
});

function windowClose(ev) {
    const edit = document.querySelector('.popup-edit_wrapper');
    if (ev.target === edit) isPopupEdit.value = !isPopupEdit.value;

    const editCurrentRow = document.querySelector('.edit');
    if (ev.target === editCurrentRow) {
        isShowDelete.value = false;
    }
}

const isPopupEdit = ref(false);
const editX = ref(null);
const editY = ref(null);
const currentRow = ref({});
const tableName = ref('');

function popupDeleteRow(ev, item, name) {
    isPopupEdit.value = false;
    setTimeout(() => {
        isPopupEdit.value = true;
    }, 0);
    editX.value = ev.clientX;
    editY.value = ev.clientY;
    currentRow.value = item;
    tableName.value = name;
}

const isShowDelete = ref(false);

function popupDeleteCurrentRow() {
    isPopupEdit.value = false;
    isShowDelete.value = true;
}

const loadingDelete = ref(false);
const loadingTextDelete = computed(() => {
    return loadingDelete.value ? '' : 'Удалить';
});

async function sendingDeleteRow() {
    loadingDelete.value = true;

    const params = new URLSearchParams();

    params.set('id', currentRow.value.id);
    params.set('typeManagement', 'clients');

    params.set('description', tableName.value);


    let response = await fetch('php/edit/edit-row.php', {
        method: 'POST',
        body: params,
    });

    let text = await response.text();

    await updateClients();

    if (text === 'success') {
        loadingDelete.value = false;
        isShowDelete.value = false;
    }
}

const clients = ref(null);

const applications = ref(props.data[0]);
const reviews = ref(props.data[1]);

async function updateClients() {
    let result = await fetch('php/update-clients.php');
    clients.value = await result.json();
    applications.value = clients.value[0];
    reviews.value = clients.value[1];
}

</script>
