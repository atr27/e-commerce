<template>
   <Header />
   <slot />

</template>

<script setup>
import Header from './Header.vue';
import { onMounted } from 'vue';
import { initFlowbite } from 'flowbite';

onMounted(() => {
    initFlowbite();
})
</script>
