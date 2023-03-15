<template>
    <div v-if="returnMessage" class="check-mark case">
        <div class="check-mark__content animate">
            <img class="check-mark__img" src="img/check-mark.png" alt="Галочка">
            <h1 class="section-heading text-center">{{ returnMessage }}</h1>
            <a class="check-mark__close" @click="toggleMark">Закрыть</a>
        </div>
    </div>
</template>

<script setup>
import {onMounted} from "vue";

const props = defineProps({
    returnMessage: String,
});

onMounted(() => {
    window.addEventListener('click', windowClose);
});

const emit = defineEmits(['close-popup']);

function toggleMark() {
    emit('close-popup');
}

function windowClose(ev) {
    const success = document.querySelector('.check-mark');

    if (ev.target === success) {
        emit('close-popup');
    }
}
</script>
