<template>
    <!-- Main Content-->
    <UserLayout>
        <!--Hero Section-->
        <Hero />
        <!--End Section-->

        <!--Main Content Section-->
        <div class="bg-white">
            <div class="mx-auto max-w-2xl px-4 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Latest Products</h2>
                    <Link :href="route('products.index')"
                        class="text-white bg-red-500 hover:bg-red-400 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-500 dark:hover:bg-red-400 dark:focus:ring-red-600">
                    All Products</Link>
                </div>

                <!-- List Product -->
                <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                    <div v-for="product in products" :key="product.id" class="group">
                        <div
                            class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                            <img v-if="product.product_images.length > 0" :src="`/${product.product_images[0].image}`"
                                :alt="product.title"
                                class="h-full w-full object-cover object-center group-hover:opacity-75" />
                            <img v-else
                                src="https://media.istockphoto.com/vectors/no-image-available-icon-vector-id1216251206?k=20&m=1216251206&s=170667a&w=0&h=A72dFkHkDdSfmT6iWl6eMN9t_JZmqGeMoAycP-LMAw4="
                                :alt="product.title"
                                class="h-full w-full object-cover object-center group-hover:opacity-75" />
                        </div>
                        <Link :href="route('products.show', product.id)" class="mt-4 text-sm text-gray-700">{{ product.title }}</Link>
                        <p class="mt-1 text-lg font-medium text-gray-900">${{ product.price }}</p>
                        <p class="mt-1 text-sm text-gray-500">{{ product.category.name }}, {{ product.brand.name }}</p>
                        <div class="mt-4">
                            <a href="#" @click="addToCart(product)"
                                class="text-white  bg-red-400 hover:bg-red-500 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-500 dark:hover:bg-red-400 dark:focus:ring-red-800">
                                <font-awesome-icon icon="fa-solid fa-cart-plus" />
                                Add to cart
                            </a>
                        </div>
                    </div>
                </div>
                <!--End List Product-->

            </div>
        </div>
        <Footer />
    </UserLayout>
    <!-- End Main Content-->

</template>
<script setup>
import UserLayout from './Layout/UserLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import Hero from './Layout/Hero.vue';
import Footer from './Layout/Footer.vue';

defineProps({
    products: Array
})

const addToCart = (product) => {
    router.post(route('cart.store', product), {
        onSuccess: (page) => {
            if(page.props.flash.success){
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
