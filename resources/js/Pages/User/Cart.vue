<template>
    <UserLayout>
        <section class="text-gray-600 body-font relative">
            <div class="container px-5 py-20 mx-auto flex sm:flex-nowrap flex-wrap">
                <div class="lg:w-2/3 md:w-1/2 bg-red-100 rounded-lg sm:mr-10 p-3">

                    <!--List Cart Item Products-->

                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-16 py-3">
                                    <span class="sr-only">Image</span>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Product
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Qty
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="product in products" :key="product.id"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="p-4">
                                    <img v-if="product.product_images.length > 0"
                                        :src="`/${product.product_images[0].image}`"
                                        class="w-16 md:w-32 max-w-full max-h-full" alt="Item Cart Image">
                                    <img v-else
                                        src="https://media.istockphoto.com/vectors/no-image-available-icon-vector-id1216251206?k=20&m=1216251206&s=170667a&w=0&h=A72dFkHkDdSfmT6iWl6eMN9t_JZmqGeMoAycP-LMAw4="
                                        class="w-16 md:w-32 max-w-full max-h-full" alt="Item Cart Image">
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                    {{ product.title }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <button
                                            @click.prevent="update(product, cartItem[itemId(product.id)].quantity - 1)"
                                            :disabled="cartItem[itemId(product.id)].quantity <= 1"
                                            :class="[cartItem[itemId(product.id)].quantity > 1 ? 'cursor-pointer text-red-500' : 'cursor-not-allowed text-gray-300 dark:text-gray-500', 'inline-flex items-center justify-center p-1 me-3 text-sm font-medium h-6 w-6 text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700']"
                                            type="button">
                                            <span class="sr-only">Quantity button</span>
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 18 2">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                            </svg>
                                        </button>
                                        <div>
                                            <input type="number" id="first_product"
                                                v-model="cartItem[itemId(product.id)].quantity"
                                                class="bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="1" required />
                                        </div>
                                        <button
                                            @click.prevent="update(product, cartItem[itemId(product.id)].quantity + 1)"
                                            class="inline-flex items-center justify-center h-6 w-6 p-1 ms-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                            type="button">
                                            <span class="sr-only">Quantity button</span>
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 18 18">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                    ${{ product.price }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="#" @click="remove(product)"
                                        class="font-medium text-red-600 dark:text-red-500 hover:underline">Remove</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- End -->

                </div>
                <div class="lg:w-1/3 md:w-1/2 bg-white flex flex-col md:ml-auto w-full md:py-8 mt-8 md:mt-0">
                    <h2 class="text-gray-900 text-lg mb-1 font-bold title-font">Total List Cart</h2>
                    <p class="leading-relaxed mb-5 text-gray-600">Price : ${{ total }}</p>
                    <div v-if="userAddress">
                        <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Shipping Address</h2>
                        <p class="leading-relaxed mb-5 text-gray-600">{{ userAddress.address1 }}, {{ userAddress.city
                            }},
                            {{ userAddress.state }}, {{ userAddress.zipcode }}, {{ userAddress.country_code }}
                        </p>
                    </div>
                    <div v-else>
                        <p class="leading-relaxed mb-5 text-gray-600">Add shipping address to continue</p>
                    </div>
                    <form @submit.prevent="submit">
                        <div class="relative mb-4">
                            <label for="address1" class="leading-7 text-sm text-gray-600">Address 1</label>
                            <textarea id="address1" name="address1" v-model="form.address1"
                                class="w-full bg-white rounded border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                rows="1"></textarea>
                        </div>
                        <div class="relative mb-4">
                            <label for="city" class="leading-7 text-sm text-gray-600">City</label>
                            <input type="text" id="city" name="city" v-model="form.city"
                                class="w-full bg-white rounded border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="relative mb-4">
                            <label for="state" class="leading-7 text-sm text-gray-600">State</label>
                            <input type="text" id="state" name="state" v-model="form.state"
                                class="w-full bg-white rounded border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="relative mb-4">
                            <label for="zipCode" class="leading-7 text-sm text-gray-600">Zipcode</label>
                            <input type="number" id="zipCode" name="zipCode" v-model="form.zipCode"
                                class="w-full bg-white rounded border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="relative mb-4">
                            <label for="countryCode" class="leading-7 text-sm text-gray-600">Country Code</label>
                            <input type="text" id="countryCode" name="countryCode" v-model="form.countryCode"
                                class="w-full bg-white rounded border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="relative mb-4">
                            <label for="addressType" class="leading-7 text-sm text-gray-600">Address Type</label>
                            <input type="text" id="addressType" name="addressType" v-model="form.addressType"
                                class="w-full bg-white rounded border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <button v-if="formInserted || userAddress" type="submit"
                            class="text-white bg-red-400 border-0 py-2 px-6 focus:outline-none hover:bg-red-500 rounded text-lg">Checkout</button>
                        <button v-else type="submit"
                            class="text-white bg-gray-400 border-0 py-2 px-6 focus:outline-none hover:bg-gray-500 rounded text-lg">Add
                            Address to Continue Checkout</button>
                    </form>
                </div>
            </div>
        </section>
      <Footer />
    </UserLayout>
</template>

<script setup>
import UserLayout from './Layout/UserLayout.vue';
import { computed, reactive } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import Footer from './Layout/Footer.vue';

const cartItem = computed(() => usePage().props.cart.data.items)
const products = computed(() => usePage().props.cart.data.products)
const total = computed(() => usePage().props.cart.data.total)
const itemId = (id) => cartItem.value.findIndex((item) => item.product_id == id)

defineProps({
    userAddress: Object
})

const form = reactive({
    address1: null,
    city: null,
    state: null,
    zipCode: null,
    countryCode: null,
    addressType: null
})

const formInserted = computed(()=>{
    return (form.address1 !== null &&
            form.city !== null &&
            form.state !== null &&
            form.zipCode !== null &&
            form.countryCode !== null &&
            form.addressType !== null)
})

const update = (product, quantity) => {
    router.patch(route('cart.update', product), {
        quantity
    });
}

const remove = (product) => router.delete(route('cart.delete', product));

//checkout cart

function submit() {
    router.visit(route('checkout.store'), {
        method: 'post',
        data: {
            cartItem: usePage().props.cart.data.items,
            products: usePage().props.cart.data.products,
            total: usePage().props.cart.data.total,
            address: form
        }
    });
}
</script>
