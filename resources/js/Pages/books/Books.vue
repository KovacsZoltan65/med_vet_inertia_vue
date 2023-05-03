<script>
import AppLayout from '../../Layouts/AppLayout.vue';

import Pagination from '../../Components/Pagination.vue';

//import TextInput from '../../Components/TextInput.vue';

import DialogModal from '../../Components/DialogModal.vue';
import BooksForm from './BooksForm.vue';

import PrimaryButton from '../../Components/buttons/PrimaryButton.vue';
import SecondaryButton from '../../Components/buttons/SecondaryButton.vue';

import {
    PlusSmallIcon, PlusIcon, PencilIcon, TrashIcon
} from '@heroicons/vue/24/solid';

const defaultFormObject = {
    title: null, author: null, image: null
};

export default{
    name: 'Books2',
    props: ['data'],
    components: {
        AppLayout,
        Pagination,
        PrimaryButton,
        SecondaryButton,
        DialogModal,
        //TextInput,
        BooksForm,
        PlusIcon, PlusSmallIcon, PencilIcon, TrashIcon
    },
    data(){
        return {
            showModal: false,
            isEdit: false,
            formObject: defaultFormObject,
        }
    },
    mounted(){},
    created(){},
    methods: {
        openForm(item){
            //console.log(item);
            this.isEdit = !!item;
            this.formObject = item ? Object.assign({}, item) : defaultFormObject;
            this.showModal = true;

            this.$page.props.errors = {};
        },

        closeForm(){
            this.showModal = false;
            this.formObject = defaultFormObject;
        },

        saveItem(item){
            
            let url = '/books';
            if(item.id){
                url += `/${item.id}`;
                item._method = 'PUT';
            }
            console.log(item);
            /*
            this.$inertia.post(url, this.formObject, {
                onError: (err) => { console.log('err', err); },
                onSuccess: () => {
                    this.closeForm();
                }
            });
            */
        },

        deleteItem(item){
            if(window.confirm('are you sure?')){
                this.$inertia.post('/humans/' + item.id, {
                    _method: 'DELETE'
                });
            }
        },
    }
}

</script>

<template>
    <AppLayout title="Books 2">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Modal Demo 2
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                    <!-- Üzenetek -->
                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" 
                        role="alert" 
                        v-if="$page.props.flash.message">
                        <div class="flex">
                            <div>
                                <p class="text-sm">{{ $page.props.flash.message }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- NEW button -->
                    <PrimaryButton 
                        type="button" 
                        @click="openForm()">
                        <PlusIcon class="h-5 w-5" />
                    </PrimaryButton>

                    <!-- Book list -->
                    <table class="table table-bordered table-fixed w-full posts-table">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 w-20">No.</th>
                                <th class="px-4 py-2">Title</th>
                                <th class="px-4 py-2">Author</th>
                                <th class="px-4 py-2">Image</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in data.data">
                                <td class="px-4 py-2 border">{{ item.id }}</td>
                                <td class="px-4 py-2 border">{{ item.title }}</td>
                                <td class="px-4 py-2 border">{{ item.author }}</td>
                                <td class="px-4 py-2 border">{{ item.image }}</td>
                                <td class="px-4 py-2 border">

                                    <!-- EDIT button -->
                                    <PrimaryButton type="button" 
                                        @click="openForm(item)">
                                        <PencilIcon class="h-5 w-5" />
                                    </PrimaryButton>

                                    <!-- DELETE button -->
                                    <SecondaryButton class="ml-3">
                                        <TrashIcon class="h-5 w-5" />
                                    </SecondaryButton>

                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <Pagination :links="data.links"></Pagination>
                </div>
            </div>
        </div>

        <!-- Book Modal -->
        <DialogModal :show="showModal">
            <template #title>
                KÖNYV
            </template>
            <template #content>
                <!--<form>

                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        
                        <div class="mb-4">
                            <label for="formBookTitle" 
                                class="block text-gray-700 text-sm font-bold mb-2"
                            >Title:</label>
                            <input type="text" 
                                v-model="formObject.title"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="formBookTitle" placeholder="Enter Title">
                            <div v-if="$page.props.errors.title" 
                                class="text-red-500"
                            >{{ $page.props.errors.title }}</div>
                        </div>

                        <div class="mb-4">
                            <label for="formBookAuthor" 
                                class="block text-gray-700 text-sm font-bold mb-2"
                            >Author:</label>
                            <input type="text" 
                                v-model="formObject.author"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="formBookAuthor" placeholder="Enter Author">
                            <div v-if="$page.props.errors.author" 
                                class="text-red-500"
                            >{{ $page.props.errors.author }}</div>
                        </div>

                        <div class="mb-4">
                            <label for="formBookImage" 
                                class="block text-gray-700 text-sm font-bold mb-2"
                            >Image:</label>
                            <input type="text" 
                                v-model="formObject.image"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="formBookImage" placeholder="Enter Image">
                            <div v-if="$page.props.errors.image" 
                                class="text-red-500"
                            >{{ $page.props.errors.image }}</div>
                        </div>

                    </div>

                </form>-->

                <BooksForm 
                    :form="formObject"
                ></BooksForm>
            </template>
            <template #footer>
                <SecondaryButton 
                    type="button"
                    @click="closeForm"
                    class="self-start"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 006 5.25v13.5a1.5 1.5 0 001.5 1.5h6a1.5 1.5 0 001.5-1.5V15a.75.75 0 011.5 0v3.75a3 3 0 01-3 3h-6a3 3 0 01-3-3V5.25a3 3 0 013-3h6a3 3 0 013 3V9A.75.75 0 0115 9V5.25a1.5 1.5 0 00-1.5-1.5h-6zm10.72 4.72a.75.75 0 011.06 0l3 3a.75.75 0 010 1.06l-3 3a.75.75 0 11-1.06-1.06l1.72-1.72H9a.75.75 0 010-1.5h10.94l-1.72-1.72a.75.75 0 010-1.06z" clip-rule="evenodd" />
                    </svg>
                </SecondaryButton>

                <PrimaryButton 
                    type="button" 
                    class="ml-3"
                    v-show="!isEdit"
                    @click="saveItem(formObject)"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M10.5 3.75a6 6 0 00-5.98 6.496A5.25 5.25 0 006.75 20.25H18a4.5 4.5 0 002.206-8.423 3.75 3.75 0 00-4.133-4.303A6.001 6.001 0 0010.5 3.75zm2.03 5.47a.75.75 0 00-1.06 0l-3 3a.75.75 0 101.06 1.06l1.72-1.72v4.94a.75.75 0 001.5 0v-4.94l1.72 1.72a.75.75 0 101.06-1.06l-3-3z" clip-rule="evenodd" />
                    </svg>
                </PrimaryButton>

                <PrimaryButton 
                    type="button"
                    class="ml-3"
                    v-show="isEdit"
                    @click="saveItem(formObject)"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 013.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 013.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 01-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875zm6.905 9.97a.75.75 0 00-1.06 0l-3 3a.75.75 0 101.06 1.06l1.72-1.72V18a.75.75 0 001.5 0v-4.19l1.72 1.72a.75.75 0 101.06-1.06l-3-3z" clip-rule="evenodd" />
                        <path d="M14.25 5.25a5.23 5.23 0 00-1.279-3.434 9.768 9.768 0 016.963 6.963A5.23 5.23 0 0016.5 7.5h-1.875a.375.375 0 01-.375-.375V5.25z" />
                    </svg>
                </PrimaryButton>
            </template>
        </DialogModal>

    </AppLayout>
</template>