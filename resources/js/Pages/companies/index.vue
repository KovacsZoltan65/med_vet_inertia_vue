<script>
import AppLayout from '../../Layouts/AppLayout.vue';

import Pagination from '../../Components/Pagination.vue';

import TextInput from '../../Components/TextInput.vue';

import DialogModal from '../../Components/DialogModal.vue';
import CompanyForm from './form.vue';

import PrimaryButton from '../../Components/buttons/PrimaryButton.vue';
import SecondaryButton from '../../Components/buttons/SecondaryButton.vue';

import {
    PlusSmallIcon, PlusIcon, PencilIcon, TrashIcon, CircleStackIcon
} from '@heroicons/vue/24/solid';

import ArrowRightOnRectangleIcon from '../../Components/icons/ArrowRightOnRectangleIcon.vue';

import Success from '../../Components/alerts/Success.vue';

const defaultFormObject = {
    name: null
};

export default(await import('vue')).defineComponent({
    name: 'Companies',
    props: ['data'],
    components: {
        AppLayout,
        Pagination,
        PrimaryButton,
        SecondaryButton,
        DialogModal,
        TextInput,
        CompanyForm,
        PlusIcon, PlusSmallIcon, PencilIcon, TrashIcon,CircleStackIcon,
        ArrowRightOnRectangleIcon
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
            
            let url = '/companies';
            if(item.id){
                url += `/${item.id}`;
                item._method = 'PUT';
            }

            this.$inertia.post(url, this.formObject, {
                onError: (err) => { console.log('err', err); },
                onSuccess: () => {
                    this.closeForm();
                }
            });
            
        },

        deleteItem(){
            console.log('deleteItem', this.formObject);
        },
    }
});

</script>

<template>
    <AppLayout title="Companies">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Companies
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                    <!-- Üzenetek -->
                    <Success :message="$page.props.flash.message" v-if="$page.props.flash.message"/>

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
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in data.data">
                                <td class="px-4 py-2 border">{{ item.id }}</td>
                                <td class="px-4 py-2 border">{{ item.name }}</td>
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

                    <!-- PAGINATION -->
                    <Pagination :links="data.links"></Pagination>

                </div>
            </div>
        </div>

        <!-- Company Modal -->
        <DialogModal :show="showModal">
            <template #title>
                Companies
            </template>
            <template #content>

                <CompanyForm  
                    :form="formObject"
                ></CompanyForm>
            </template>
            <template #footer>

                <!-- Cancel Button -->
                <SecondaryButton type="button"
                    @click="closeForm" 
                    class="self-start"
                >
                    <!--
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" 
                        fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" 
                            d="M7.5 3.75A1.5 1.5 0 006 5.25v13.5a1.5 1.5 0 001.5 1.5h6a1.5 1.5 0 001.5-1.5V15a.75.75 0 011.5 0v3.75a3 3 0 01-3 3h-6a3 3 0 01-3-3V5.25a3 3 0 013-3h6a3 3 0 013 3V9A.75.75 0 0115 9V5.25a1.5 1.5 0 00-1.5-1.5h-6zm10.72 4.72a.75.75 0 011.06 0l3 3a.75.75 0 010 1.06l-3 3a.75.75 0 11-1.06-1.06l1.72-1.72H9a.75.75 0 010-1.5h10.94l-1.72-1.72a.75.75 0 010-1.06z" 
                            clip-rule="evenodd" />
                    </svg>
                    -->
                    <ArrowRightOnRectangleIcon class="w-6 h-6" />
                </SecondaryButton>

                <!-- Create Button -->
                <PrimaryButton type="button" class="ml-3"
                    v-show="!isEdit" @click="saveItem(formObject)">
                    <CircleStackIcon class="h-5 w-5" />
                </PrimaryButton>

                <!-- Update Button -->
                <PrimaryButton type="button" class="ml-3"
                    v-show="isEdit" @click="saveItem(formObject)">
                    <CircleStackIcon class="h-5 w-5" />
                </PrimaryButton>
            </template>
        </DialogModal>

    </AppLayout>
</template>