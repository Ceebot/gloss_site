<template>
    <section class="nav-data">
        <div class="container nav-data__container">
            <div class="nav-data__list">
                <button v-for="template in templates"
                        :key="template"
                        class="nav-data__link"
                        @click="currentTab = template"
                        :class="['nav-data__link', { 'is-active': currentTab === template }]">
                    {{ template }}
                </button>
            </div>
        </div>
    </section>
    <component :is="currentTabComponent" :data="componentProps"></component>
</template>

<script setup>
import DataFinance from "./Data/DataFinance.vue";
import DataClients from "./Data/DataClients.vue";
import DataProducts from "./Data/DataProducts.vue";
import {ref, computed} from "vue";

const props = defineProps({
    finance: Array,
    application: Array,
    review: Array,
    product: Array,
    service: Array,
});

const currentTab = ref('Управление финансами');
const templates = ref(['Управление финансами', 'Управление клиентами', 'Управление товарами и услугами']);
const componentProps = ref(null);

const currentTabComponent = computed(() => {
    switch (currentTab.value) {
        case 'Управление финансами':
            componentProps.value = props.finance;
            return DataFinance;
        case 'Управление клиентами':
            componentProps.value = [props.application, props.review];
            return DataClients;
        case 'Управление товарами и услугами':
            componentProps.value = [props.product, props.service];
            return DataProducts;
    }
});

</script>
