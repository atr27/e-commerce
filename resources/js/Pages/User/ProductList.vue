<template>
    <UserLayout>
        <div class="bg-white">
            <div>
                <!-- Mobile filter dialog -->
                <TransitionRoot as="template" :show="mobileFiltersOpen">
                    <Dialog class="relative z-40 lg:hidden" @close="mobileFiltersOpen = false">
                        <TransitionChild as="template" enter="transition-opacity ease-linear duration-300"
                            enter-from="opacity-0" enter-to="opacity-100"
                            leave="transition-opacity ease-linear duration-300" leave-from="opacity-100"
                            leave-to="opacity-0">
                            <div class="fixed inset-0 bg-black bg-opacity-25" />
                        </TransitionChild>

                        <div class="fixed inset-0 z-40 flex">
                            <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
                                enter-from="translate-x-full" enter-to="translate-x-0"
                                leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0"
                                leave-to="translate-x-full">
                                <DialogPanel
                                    class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-12 shadow-xl">
                                    <div class="flex items-center justify-between px-4">
                                        <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                                        <button type="button"
                                            class="-mr-2 flex h-10 w-10 items-center justify-center rounded-md bg-white p-2 text-gray-400"
                                            @click="mobileFiltersOpen = false">
                                            <span class="sr-only">Close menu</span>
                                            <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                                        </button>
                                    </div>

                                    <!-- Filters -->
                                    <form class="mt-4 border-t border-gray-200">
                                        <h3 class="sr-only">Categories</h3>
                                        <ul role="list" class="px-2 py-3 font-medium text-gray-900">
                                            <li v-for="category in subCategories" :key="category.name">
                                                <a :href="category.href" class="block px-2 py-3">{{ category.name
                                                    }}</a>
                                            </li>
                                        </ul>

                                        <Disclosure as="div" v-for="section in filters" :key="section.id"
                                            class="border-t border-gray-200 px-4 py-6" v-slot="{ open }">
                                            <h3 class="-mx-2 -my-3 flow-root">
                                                <DisclosureButton
                                                    class="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500">
                                                    <span class="font-medium text-gray-900">{{ section.name
                                                        }}</span>
                                                    <span class="ml-6 flex items-center">
                                                        <PlusIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
                                                        <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
                                                    </span>
                                                </DisclosureButton>
                                            </h3>
                                            <DisclosurePanel class="pt-6">
                                                <div class="space-y-6">
                                                    <div v-for="(option, optionIdx) in section.options"
                                                        :key="option.value" class="flex items-center">
                                                        <input :id="`filter-mobile-${section.id}-${optionIdx}`"
                                                            :name="`${section.id}[]`" :value="option.value"
                                                            type="checkbox" :checked="option.checked"
                                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                                        <label :for="`filter-mobile-${section.id}-${optionIdx}`"
                                                            class="ml-3 min-w-0 flex-1 text-gray-500">{{
                                                                option.label }}</label>
                                                    </div>
                                                </div>
                                            </DisclosurePanel>
                                        </Disclosure>
                                    </form>
                                </DialogPanel>
                            </TransitionChild>
                        </div>
                    </Dialog>
                </TransitionRoot>

                <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex items-baseline justify-between border-b border-gray-200 pb-6 pt-24">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900">New Arrivals</h1>
                    </div>

                    <section aria-labelledby="products-heading" class="pb-24 pt-6">
                        <h2 id="products-heading" class="sr-only">Products</h2>

                        <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
                            <!-- Filters -->
                            <form class="hidden lg:block">
                                <h3 class="sr-only">Price</h3>
                                <!--Filter Price-->
                                <div class="flex justify-beetween items-center space-x-3">
                                    <div class="basis-1/3">
                                        <label for="filter-price-from"
                                            class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                            From
                                        </label>
                                        <input type="number" id="filter-price-from" placeholder="Min Price"
                                            v-model="priceFilter.prices[0]"
                                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-red-500 focus:ring-red-500">
                                    </div>
                                    <div class="basis-1/3">
                                        <label for="filter-price-from"
                                            class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                            To
                                        </label>
                                        <input type="number" id="filter-price-from" placeholder="Max Price"
                                            v-model="priceFilter.prices[1]"
                                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-red-500 focus:ring-red-500">
                                    </div>
                                    <SecondaryButtonVue class="self-end items-center" @click="priceFilterProcess()">
                                        OK
                                    </SecondaryButtonVue>
                                </div>
                                <!--End-->

                                <!--Brands Filter-->
                                <Disclosure as="div" class="border-b border-gray-200 py-6" v-slot="{ open }">
                                    <h3 class="-my-3 flow-root">
                                        <DisclosureButton
                                            class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500">
                                            <span class="font-medium text-gray-900">Brands</span>
                                            <span class="ml-6 flex items-center">
                                                <PlusIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
                                                <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
                                            </span>
                                        </DisclosureButton>
                                    </h3>
                                    <DisclosurePanel class="pt-6">
                                        <div class="space-y-4">
                                            <div v-for="brand in brands" :key="brand.id" class="flex items-center">
                                                <input :id="`filter-${brand.id}`" :value="brand.id" type="checkbox" v-model="selectedBrands"
                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                                <label :for="`filter-${brand.id}`" class="ml-3 text-sm text-gray-600">{{
                                                    brand.name }}</label>
                                            </div>
                                        </div>
                                    </DisclosurePanel>
                                </Disclosure>
                                <!--End-->

                                <!--Category Filter-->
                                <Disclosure as="div" class="border-b border-gray-200 py-6" v-slot="{ open }">
                                    <h3 class="-my-3 flow-root">
                                        <DisclosureButton
                                            class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500">
                                            <span class="font-medium text-gray-900">Categories</span>
                                            <span class="ml-6 flex items-center">
                                                <PlusIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
                                                <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
                                            </span>
                                        </DisclosureButton>
                                    </h3>
                                    <DisclosurePanel class="pt-6">
                                        <div class="space-y-4">
                                            <div v-for="category in categories" :key="category.id" class="flex items-center">
                                                <input :id="`filter-${category.id}`" :value="category.id" type="checkbox" v-model="selectedCategories"
                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                                <label :for="`filter-${category.id}`" class="ml-3 text-sm text-gray-600">{{
                                                    category.name }}</label>
                                            </div>
                                        </div>
                                    </DisclosurePanel>
                                </Disclosure>
                                <!--End-->
                            </form>

                            <!-- Product grid -->
                            <div class="lg:col-span-3">

                                <!-- List Product -->
                                <div
                                    class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                                    <div v-for="product in products.data" :key="product.id" class="group">
                                        <div
                                            class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                                            <img v-if="product.product_images.length > 0"
                                                :src="`/${product.product_images[0].image}`" :alt="product.title"
                                                class="h-full w-full object-cover object-center group-hover:opacity-75" />
                                            <img v-else
                                                src="https://media.istockphoto.com/vectors/no-image-available-icon-vector-id1216251206?k=20&m=1216251206&s=170667a&w=0&h=A72dFkHkDdSfmT6iWl6eMN9t_JZmqGeMoAycP-LMAw4="
                                                :alt="product.title"
                                                class="h-full w-full object-cover object-center group-hover:opacity-75" />
                                        </div>
                                        <Link :href="route('products.show', product.id)" class="mt-4 text-sm text-gray-700">{{ product.title }}</Link>
                                        <p class="mt-1 text-lg font-medium text-gray-900">${{ product.price }}</p>
                                        <p class="mt-1 text-sm text-gray-500">{{ product.category.name }}, {{
                                            product.brand.name }}</p>
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
                    </section>
                </main>
            </div>
        </div>
    </UserLayout>
</template>

<script setup>
import UserLayout from './Layout/UserLayout.vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import {
    Dialog,
    DialogPanel,
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue'
import { XMarkIcon } from '@heroicons/vue/24/outline'
import { ChevronDownIcon, FunnelIcon, MinusIcon, PlusIcon, Squares2X2Icon } from '@heroicons/vue/20/solid'
import SecondaryButtonVue from '@/Components/SecondaryButton.vue';

const sortOptions = [
    { name: 'Most Popular', href: '#', current: true },
    { name: 'Best Rating', href: '#', current: false },
    { name: 'Newest', href: '#', current: false },
    { name: 'Price: Low to High', href: '#', current: false },
    { name: 'Price: High to Low', href: '#', current: false },
]


const priceFilter = useForm({
    prices: [0, 10000]
})

//method filter price

const priceFilterProcess = () => {
    priceFilter.transform((data) => ({
        ...data,
        prices: {
            from: priceFilter.prices[0],
            to: priceFilter.prices[1]
        }
    })).get('products', {
        preserveState: true,
        replace: true
    });
}

//filter brand and category
const selectedBrands = ref([])
const selectedCategories = ref([])

watch(selectedBrands, () => {
    updateFilteredProducts()
})

watch(selectedCategories, () => {
    updateFilteredProducts()
})

function updateFilteredProducts() {
    router.get('products', {
        brands: selectedBrands.value,
        categories: selectedCategories.value
    }, {
        preserveState: true,
        replace: true
    })
}


const mobileFiltersOpen = ref(false)

const props = defineProps({
    products: Array,
    brands: Array,
    categories: Array
});

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
