<template>
    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        <!-- Navbar -->
        <Navbar />
        <!-- Sidebar -->
        <Sidebar />
        <!-- Main -->\

        <main class="p-4 md:ml-64 h-auto pt-16">
            <slot />
        </main>


    </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import Navbar from './Navbar.vue';
import Sidebar from './Sidebar.vue';

onMounted(() => {
    initFlowbite();
})
</script>
