<template>

<AdminLayout>
    <BrandList :brands="brands"/>
</AdminLayout>

</template>

<script setup>

defineProps({
    brands:Array
})

import AdminLayout from '../Components/AdminLayout.vue';
import BrandList from './BrandList.vue';

</script>
