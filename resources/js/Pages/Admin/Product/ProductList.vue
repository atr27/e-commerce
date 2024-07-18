<template>
    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div
                    class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div
                        class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <button type="button" @click="openAddModal"
                            class="flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Add product
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Product name</th>
                                <th scope="col" class="px-4 py-3">Category</th>
                                <th scope="col" class="px-4 py-3">Brand</th>
                                <th scope="col" class="px-4 py-3">Quantity</th>
                                <th scope="col" class="px-4 py-3">Stock</th>
                                <th scope="col" class="px-4 py-3">Price</th>
                                <th scope="col" class="px-4 py-3">Publish</th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="product in products" :key="product.id" class="border-b dark:border-gray-700">
                                <th scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{
                                        product.title }}</th>
                                <td class="px-4 py-3">{{ product.category.name }}</td>
                                <td class="px-4 py-3">{{ product.brand.name }}</td>
                                <td class="px-4 py-3">{{ product.quantity }}</td>
                                <td class="px-4 py-3">
                                    <span v-if="product.inStock == 0"
                                        class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">inStock</span>
                                    <span v-else
                                        class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Out
                                        of Stock</span>
                                </td>
                                <td class="px-4 py-3">${{ product.price }}</td>
                                <td class="px-4 py-3">
                                    <button v-if="product.published == 0" type="button"
                                        class="px-3 py-2 text-xs font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Published</button>
                                    <button v-else type="button"
                                        class="px-3 py-2 text-xs font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Unpublished</button>
                                </td>
                                <td class="px-4 py-3 flex items-center justify-end">
                                    <button :id="`${product.id}-button`"
                                        :data-dropdown-toggle="`${product.id}-dropdown`"
                                        class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                                        type="button">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>
                                    <div :id="`${product.id}-dropdown`"
                                        class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                            :aria-labelledby="`${product.id}-button`">
                                            <li>
                                                <button @click="openEditModal(product)"
                                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</button>
                                            </li>
                                        </ul>
                                        <div class="py-1">
                                            <a href="#" @click="deleteProduct(product, index)"
                                                class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <el-dialog v-model="dialogVisible" :title="editProduct ? 'Edit Product' : 'Add Product'" width="500"
        :before-close="handleClose">

        <form @submit.prevent="editProduct ? updateProduct() : AddProduct()" class="max-w-md mx-auto">
            <div class="relative z-0 w-full mb-5 group">
                <input v-model="title" type="text" name="floating_title" id="floating_title"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    required />
                <label for="floating_title"
                    class="peer-focus:font-medium absolute text-xl text-gray-900 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Title</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input v-model="price" type="number" name="floating_price" id="floating_price"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    required />
                <label for="floating_price"
                    class="peer-focus:font-medium absolute text-xl text-gray-900 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Price</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input v-model="quantity" type="number" name="quantity" id="quantity"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    required />
                <label for="quantity"
                    class="peer-focus:font-medium absolute text-xl text-gray-900 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Quantity</label>
            </div>

            <form class="max-w-md mx-auto">
                <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                    Category</label>
                <select id="category" v-model="category_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option v-for="category in categories" :key="category.id" :value="category.id" selected>{{
                        category.name }}</option>
                </select>
            </form>

            <form class="max-w-md mx-auto my-2">
                <label for="brand" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                    Brand</label>
                <select id="brand" v-model="brand_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option v-for="brand in brands" :key="brand.id" :value="brand.id" selected>{{ brand.name }}</option>
                </select>
            </form>

            <div class="relative z-0 w-full mb-5 group">
                <label for="description"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                <textarea id="description" rows="4" v-model="description"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Write your thoughts here..."></textarea>
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <el-upload v-model:file-list="productImages" list-type="picture-card" multiple
                    :on-preview="handlePictureCardPreview" :on-remove="handleRemove" :on-change="handleChangeFile">
                    <el-icon>
                        <Plus />
                    </el-icon>
                </el-upload>
            </div>
            <div class="flex flex-nowrap mb-8">
                <div v-for="(list, index) in product_images" :key="list.id" class="relative w-32 h-32">
                    <img class="w-24 h-24 rounded" :src="`/${list.image}`" alt="">
                    <a
                        class="absolute top-0 right-8 transform -translate-y-1/2 w-3.5 h-3.5 bg-red-400 border-2 border-white dark:border-gray-800 rounded-full">
                        <a @click="deleteImage(list, index)"
                            class="text-white text-xs font-bold absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 cursor-pointer">x</a>
                    </a>
                </div>
            </div>

            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit
            </button>
        </form>
    </el-dialog>
</template>

<script setup>
import { router, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Plus } from '@element-plus/icons-vue'

defineProps({
    products: Array
});

const categories = usePage().props.category;
const brands = usePage().props.brand;

const isAddProduct = ref(false);
const editProduct = ref(false);
const dialogVisible = ref(false);

//upload multi image
const productImages = ref([]);
const dialogImageUrl = ref('');

const handleChangeFile = (file) => {
    productImages.value.push(file);
}

const handlePictureCardPreview = (file) => {
    dialogImageUrl.value = file.url
    dialogVisible.value = true
}

const handleRemove = (file) => {
    console.log(file)
}

//data product
const id = ref('');
const title = ref('');
const price = ref('');
const quantity = ref('');
const description = ref('');
const product_images = ref([]);
const published = ref('');
const category_id = ref('');
const brand_id = ref('');
const inStock = ref('');


//add product with value data
const AddProduct = async () => {
    const formData = new FormData();
    formData.append('title', title.value);
    formData.append('price', price.value);
    formData.append('quantity', quantity.value);
    formData.append('description', description.value);
    formData.append('category_id', category_id.value);
    formData.append('brand_id', brand_id.value);

    //Add image product to form
    for (const image of productImages.value) {
        formData.append('product_images[]', image.raw);
    }

    try {
        await router.post('product/store', formData, {
            onSuccess: (page) => {
                dialogVisible.value = false;
                resetForm();
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    position: 'top-end',
                    showConfirmButton: false,
                    title: page.props.flash.success
                })
            }
        })
    } catch (error) {
        console.log(error)
    }
}

const resetForm = () => {
    id.value = '';
    title.value = '';
    price.value = '';
    quantity.value = '';
    category_id.value = '';
    brand_id.value = '';
    description.value = '';
    productImages.value = [];
    dialogImageUrl.value = '';
}



const openAddModal = () => {
    isAddProduct.value = true
    dialogVisible.value = true
    editProduct.value = false
}

const openEditModal = (product) => {
    editProduct.value = true
    dialogVisible.value = true
    isAddProduct.value = false

    //edit data
    id.value = product.id
    title.value = product.title
    price.value = product.price
    quantity.value = product.quantity
    description.value = product.description
    category_id.value = product.category_id
    brand_id.value = product.brand_id
    product_images.value = product.product_images
}

const deleteImage = async (list, index) => {
    try {
        await router.delete('/admin/product/image/' + list.id, {
            onSuccess: (page) => {
                product_images.value.splice(index, 1);
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    position: 'top-end',
                    showConfirmButton: false,
                    title: page.props.flash.success
                });
            }
        })
    } catch (error) {
        console.log(error)
    }
}

const updateProduct = async () => {
    const formData = new FormData();
    formData.append('title', title.value);
    formData.append('price', price.value);
    formData.append('quantity', quantity.value);
    formData.append('description', description.value);
    formData.append('category_id', category_id.value);
    formData.append('brand_id', brand_id.value);
    formData.append("_method", 'PUT');

    //Add image product to form
    for (const image of productImages.value) {
        formData.append('product_images[]', image.raw);
    }

    try {
        await router.post('product/update/' + id.value, formData, {
            onSuccess: (page) => {
                dialogVisible.value = false;
                resetForm();
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    position: 'top-end',
                    showConfirmButton: false,
                    title: page.props.flash.success
                })
                dialogVisible.value = false;
                resetForm();
            }
        })
    } catch (error) {
        console.log(error)
    }
}

const deleteProduct = (product, index) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            try{
                router.delete('product/delete/' + product.id, {
                onSuccess: (page) => {
                    this.delete(product, index);
                    Swal.fire({
                        toast: true,
                        icon: 'success',
                        position: 'top-end',
                        showConfirmButton: false,
                        title: page.props.flash.success
                    });
                }
            })
            } catch (error) {
                console.log(error);
            }
        }
    })
}
</script>
