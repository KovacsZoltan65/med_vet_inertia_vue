<script>
import AppLayout from '../../Layouts/AppLayout.vue';

import Pagination from '../../Components/Pagination.vue';
import DialogModal from '../../Components/DialogModal.vue';
import OfficeForm from './form.vue';

import PrimaryButton from '../../Components/buttons/PrimaryButton.vue';
import SecondaryButton from '../../Components/buttons/SecondaryButton.vue';
import Success from '../../Components/alerts/Success.vue';

import {
    PlusIcon, PencilIcon, TrashIcon, CircleStackIcon, ArrowRightOnRectangleIcon
} from '@heroicons/vue/24/solid';

const defaultFormObject = {
    name: null, type_id: 0
};

export default(await import('vue')).defineComponent({
    name: 'Offices',
    props: ['data'],
    components: {
        AppLayout,
        Pagination,
        PrimaryButton,
        SecondaryButton,
        DialogModal,
        OfficeForm,
        PlusIcon, PencilIcon, TrashIcon, CircleStackIcon, ArrowRightOnRectangleIcon,
        Success
    },
    data(){
        return {
            showModal: false,
            isEdit: false,
            formObject: defaultFormObject,

            officeTypes: [],
        }
    },
    setup (){},
    mounted(){},
    created(){
        this.getTypes();
    },
    methods: {
        
        getTypes(){

            axios.get('/get_office_types')
                .then(res => {
                    this.officeTypes = res.data;
                })
                .catch(err => { console.log(err); });
        },

        openForm(item){
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
            
            let url = '/offices';
            if(item.id){
                url += `/${item.id}`;
                item._method = 'PUT';
            }

            this.$inertia.post(url, item, {
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
})

</script>

<template>
    <AppLayout title="Companies">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Offices
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

                    <!-- Offices list -->
                    <table class="table table-bordered table-fixed w-full posts-table">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 w-20">No.</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Type</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in data.data">
                                <td class="px-4 py-2 border">{{ item.id }}</td>
                                <td class="px-4 py-2 border">{{ item.name }}</td>
                                <td class="px-4 py-2 border">{{ item.type_name }}</td>
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
                Offices
            </template>
            <template #content>

                <OfficeForm :form="formObject" 
                    :officeTypes="officeTypes"
                    :isEdit="isEdit"
                ></OfficeForm>
            </template>
            <template #footer>

                <!-- Cancel Button -->
                <SecondaryButton type="button"
                    @click="closeForm" class="self-start">
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