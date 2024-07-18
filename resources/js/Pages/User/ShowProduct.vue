<template>
    <UserLayout>
        <section class="text-gray-600 body-font overflow-hidden">
            <div class="container px-5 py-24 mx-auto">
                <div class="lg:w-4/5 mx-auto flex flex-wrap">
                    <img alt="{{ products.title }}" class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded"
                        :src="`/${products.product_images[0].image}`">
                    <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                        <h2 class="text-sm title-font text-gray-500 tracking-widest">{{ products.brand.name }}</h2>
                        <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">{{ products.title }}</h1>
                        <p class="leading-relaxed">{{ products.description }}</p>
                        <div class="flex">
                            <span class="title-font font-medium text-2xl text-gray-900">{{ products.price }}</span>
                            <a @click="addToCart(products)"
                                class="flex ml-auto text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-red-400 rounded cursor-pointer">Add to Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </UserLayout>
</template>

<script setup>
import UserLayout from "./Layout/UserLayout.vue";
import { router } from '@inertiajs/vue3';

defineProps({
    products: Array
})

const addToCart = (product) => {
    router.post(route('cart.store', product), {
        onSuccess: (page) => {
            if (page.props.flash.success) {
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    position: 'top-end',
                    showConfirmButton: false,
                    title: page.props.flash.success
                })
            }
        }
    });
}
</script>
