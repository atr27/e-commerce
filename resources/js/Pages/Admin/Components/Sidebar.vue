<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <aside
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidenav" id="drawer-navigation">
        <div class="overflow-y-auto py-5 px-3 h-full bg-white dark:bg-gray-800">
            <ul class="py-2 space-y-2">
                <li>
                    <Link :href="route('admin.product.index')"
                        class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                    Products</Link>
                </li>
                <hr>
                <li>
                    <Link :href="route('admin.brand.index')"
                        class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Brands</Link>
                </li>
                <hr>
                <li>
                    <Link :href="route('admin.category.index')"
                        class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Categories</Link>
                </li>
                <hr>
                <li>
                    <Link :href="route('admin.order.index')"
                        class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Orders</Link>
                </li>
            </ul>
        </div>
    </aside>
</template>
