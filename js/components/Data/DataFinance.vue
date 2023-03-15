<template xmlns="http://www.w3.org/1999/html">

    <DataFinanceForm @send-form-data="sendingData"/>

    <DataFinanceTable @update-finance="updateFinance" :finance="finance" :loadAnimate="loadAnimate"/>

</template>

<script setup>
import DataFinanceTable from "./DataFinanceTable.vue";
import DataFinanceForm from "./DataFinanceForm.vue";
import {ref, computed} from "vue";

const props = defineProps({
    data: Array,
});

const emit = defineEmits(['update-finance']);

async function sendingData(params) {

    let response = await fetch('php/add/add-finance.php', {
        method: 'POST',
        body: params,
    });

    let text = await response.text();

    if (text === 'success') await updateFinance();
}

const finance = ref([]);
const loadAnimate = ref(false);

async function updateFinance(params) {

    loadAnimate.value = true;

    let result = await fetch('php/select-finance.php', {
        method: 'POST',
        body: params,
    });

    finance.value = await result.json();

    loadAnimate.value = false;
}

</script>

