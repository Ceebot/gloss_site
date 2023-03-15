<template>
    <div class="finance-container container mt-5">
        <h2 class="section-heading">Товары</h2>
        <div class="table-wrap">
            <table class="table table-hover table-striped finance-table">
                <thead class="table-dark">
                <tr>
                    <th scope="col">№</th>
                    <th scope="col">Название</th>
                    <th scope="col">Объем</th>
                    <th scope="col">Цена</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, index) in products"
                    :key="item.id"
                    @contextmenu.prevent="popupRow($event, item, 'products')"
                    class="cursor-pointer"
                >
                    <th scope="row">{{ index + 1 }}</th>
                    <td>{{ item.title }}</td>
                    <td>{{ item.volume }} мл</td>
                    <td>{{ item.price }} &#8381</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <button @click="popupAddProducts = true" class="finance-btn add__product">Добавить товар</button>
        </div>

        <div v-if="popupAddProducts">
            <DataAddProducts @update-products="updateProducts"
                             @close-popup-add-product="closePopupAddProduct"
                             :description="propsMessage = 'products'">
            </DataAddProducts>
        </div>

        <h2 class="section-heading">Услуги</h2>
        <div class="table-wrap">
            <table class="table table-hover table-striped finance-table">
                <thead class="table-dark">
                <tr>
                    <th scope="col">№</th>
                    <th scope="col">Название</th>
                    <th scope="col">Цена</th>
                    <th scope="col">Фон</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, index) in services"
                    :key="item.id"
                    @contextmenu.prevent="popupRow($event, item, 'services')"
                    class="cursor-pointer"
                >
                    <th scope="row">{{ index + 1 }}</th>
                    <td>{{ item.title }}</td>
                    <td>{{ item.description }} {{ item.price }} &#8381</td>
                    <td>{{ item.img }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <button @click="popupAddServices = true" class="finance-btn add__product">Добавить услугу</button>
        </div>

        <div v-if="popupAddServices">
            <DataAddProducts @update-products="updateProducts"
                             @close-popup-add-product="closePopupAddProduct"
                             :description="propsMessage = 'services'">
            </DataAddProducts>
        </div>
    </div>

    <transition class="bounce" name="bounce">
        <div v-if="isPopupRow" class="popup-edit_wrapper">
            <div class="popup-edit" :style="{left: editX + 'px', top: editY - 80 + 'px',}">
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
                Вы уверены, что хотите удалить строку с названием <strong>`{{ currentRow.title }}`</strong> ?
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

    <section v-if="isShowEditProduct" class="case edit">
        <div class="container edit__container animate">
            <h2 class="section-heading-big text-center">Редактировать строку</h2>
            <form @submit.prevent="sendingEditRow('edit')" class="edit__form" autocomplete="off">
                <div class="edit__item">
                    <label class="edit__label" for="name">Название: </label>
                    <input type="text" id="name" class="edit__input" v-model="editTitleProduct">
                </div>
                <div class="edit__item">
                    <label class="edit__label" for="quantity">Объем (мл): </label>
                    <input type="number" id="quantity" class="edit__input" v-model="editVolumeProduct">
                </div>
                <div class="edit__item">
                    <label class="edit__label" for="price">Цена: </label>
                    <input type="text" id="price" class="edit__input" v-model="editPriceProduct">
                </div>
                <div class="text-center">
                    <button type="submit" class="edit__btn">
                        {{ loadingTextEdit }}
                        <img v-if="loadingEdit" class="loading" src="img/loading.gif" alt="Загрузка">
                    </button>
                </div>
            </form>
            <div class="text-center">
                <button class="close" @click="isShowEditProduct = false; isShowEditService = false">Отменить</button>
            </div>
        </div>
    </section>

    <section v-if="isShowEditService" class="case edit">
        <div class="container edit__container animate">
            <h2 class="section-heading-big text-center">Редактировать строку</h2>
            <form @submit.prevent="sendingEditRow('edit')" class="edit__form" autocomplete="off">
                <div class="edit__item">
                    <label class="edit__label" for="name">Название: </label>
                    <input type="text" id="name" class="edit__input" v-model="editTitleService">
                </div>
                <div class="edit__item">
                    <label class="edit__label" for="quantity">Приписка (от): </label>
                    <input type="text" id="quantity" class="edit__input" v-model="editDescriptionService">
                </div>
                <div class="edit__item">
                    <label class="edit__label" for="price">Цена: </label>
                    <input type="text" id="price" class="edit__input" v-model="editPriceService">
                </div>
                <div class="edit__item">
                    <label class="edit__label" for="price">Фоновый рисунок: </label>
                    <input type="text" id="price" class="edit__input" v-model="editImgService">
                </div>
                <div class="text-center">
                    <button type="submit" class="edit__btn">
                        {{ loadingTextEdit }}
                        <img v-if="loadingEdit" class="loading" src="img/loading.gif" alt="Загрузка">
                    </button>
                </div>
            </form>
            <div class="text-center">
                <button class="close" @click="isShowEditProduct = false; isShowEditService = false">Отменить</button>
            </div>
        </div>
    </section>
</template>

<script setup>
import {computed, onMounted, ref} from "vue";
import DataAddProducts from "./DataAddProducts.vue"

const props = defineProps({
    data: Array,
});

const popupAddProducts = ref(false);
const popupAddServices = ref(false);
const propsMessage = ref('');

const products = ref(props.data[0]);
const services = ref(props.data[1]);
const updateArray = ref([]);

function closePopupAddProduct() {
    popupAddProducts.value = false;
    popupAddServices.value = false;
}

async function updateProducts() {
    const response = await fetch('php/update-products.php', {
        method: 'POST',
    })
    updateArray.value = await response.json();
    products.value = updateArray.value[0];
    services.value = updateArray.value[1];
}

const mounted = onMounted(() => {
    window.addEventListener('click', windowClose);
});

function windowClose(ev) {
    const edit = document.querySelector('.popup-edit_wrapper');
    if (ev.target === edit) isPopupRow.value = !isPopupRow.value;

    const editCurrentRow = document.querySelector('.edit');
    if (ev.target === editCurrentRow) {
        isShowDelete.value = false;
        isShowEditProduct.value = false;
        isShowEditService.value = false;
    }
}

const isShowDelete = ref(false);
const isShowEditProduct = ref(false);
const isShowEditService = ref(false);

const isPopupRow = ref(false);

function popupDeleteCurrentRow() {
    isPopupRow.value = false;
    isShowDelete.value = true;
}

const loadingEdit = ref(false);
const loadingTextEdit = computed(() => {
    return loadingEdit.value ? '' : 'Редактировать';
});

const loadingDelete = ref(false);
const loadingTextDelete = computed(() => {
    return loadingDelete.value ? '' : 'Удалить';
});

const editTitleProduct = ref('');
const editVolumeProduct = ref('');
const editPriceProduct = ref('');

const editTitleService = ref('');
const editDescriptionService = ref('');
const editPriceService = ref('');
const editImgService = ref('');

function popupEditCurrentRow() {
    isPopupRow.value = false;

    if (type.value === 'products') {
        isShowEditProduct.value = true;
        editTitleProduct.value = currentRow.value.title;
        editVolumeProduct.value = currentRow.value.volume;
        editPriceProduct.value = currentRow.value.price;
    }
    if (type.value === 'services') {
        isShowEditService.value = true;
        editTitleService.value = currentRow.value.title;
        editDescriptionService.value = currentRow.value.description;
        editPriceService.value = currentRow.value.price;
        editImgService.value = currentRow.value.img;
    }
}

const editX = ref(null);
const editY = ref(null);

const currentRow = ref({});
const type = ref('');

function popupRow(ev, item, typeName) {
    isPopupRow.value = false;
    setTimeout(() => {
        isPopupRow.value = true;
    }, 0);
    editX.value = ev.clientX;
    editY.value = ev.clientY;
    currentRow.value = item;
    type.value = typeName;
    console.log(type.value);
    console.log(currentRow.value);
}

async function sendingEditRow(operation) {
    loadingEdit.value = true;
    loadingDelete.value = true;
    const params = new URLSearchParams();
    params.set('operation', operation)
    params.set('type', type.value);
    params.set('id', currentRow.value.id);

    if (type.value === 'products') {
        params.set('title', editTitleProduct.value);
        params.set('volume', editVolumeProduct.value);
        params.set('price', editPriceProduct.value);
    }
    if (type.value === 'services') {
        params.set('title', editTitleService.value);
        params.set('description', editDescriptionService.value);
        params.set('price', editPriceService.value);
        params.set('img', editImgService.value);
    }
    const response = await fetch('php/edit/edit-row-product.php', {
        method: 'POST',
        body: params,
    });

    let text = await response.text();

    if (text === 'success') {
        isShowDelete.value = false;
        isShowEditProduct.value = false;
        isShowEditService.value = false;
        await updateProducts();

        loadingEdit.value = false;
        loadingDelete.value = false;
    }
}
</script>

