<template>
    <UserLayout>
        <div class="relative overflow-x-auto max-w-screen-xl px-4 py-8 mx-auto shadow-md sm:rounded-lg">
            <table v-show="order.order_items.length > 0" v-for="order in orders" :key="order.id" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 col-span-6">
                          Order ID #{{ order.id }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    <tr v-for="item in order.order_items" :key="item.id"
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 grid grid-cols-6">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white flex items-center">
                            {{ item.product.title }}
                        </th>
                        <td class="px-6 py-4">
                            <img :src="`/${item.product.product_images[0].image}`" alt="{{ item.product.title }}" width="90px">
                        </td>
                        <td class="px-6 py-4 flex items-center">
                            {{ item.product.category.name }}
                        </td>
                        <td class="px-6 py-4 flex items-center">
                           $ {{ item.product.price }}
                        </td>
                        <td class="px-6 py-4 flex items-center">
                            {{ item.quantity }}
                        </td>
                        <td class="px-6 py-4 flex items-center">
                            On Process Order...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </UserLayout>
</template>

<script setup>
import UserLayout from './Layout/UserLayout.vue';

defineProps({
    orders: Array
})
</script>
