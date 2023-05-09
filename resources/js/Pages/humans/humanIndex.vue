<script>
    import AppLayout from '../../Layouts/AppLayout.vue';

    import Pagination from '../../Components/Pagination.vue';
    import DialogModal from '../../Components/DialogModal.vue';
    import HumanForm from './humanForm.vue';

    import PrimaryButton from '../../Components/buttons/PrimaryButton.vue';
    import SecondaryButton from '../../Components/buttons/SecondaryButton.vue';
    import AddButton from '../../Components/buttons/AddButton.vue';
    import EditButton from '../../Components/buttons/EditButton.vue';
    import DeleteButton from '../../Components/buttons/DeleteButton.vue';

    import ArrowRightOnRectangleIcon from '../../Components/icons/ArrowRightOnRectangleIcon.vue';

    import {
        PlusIcon, PencilIcon, TrashIcon, CircleStackIcon
    } from '@heroicons/vue/24/solid';

    import Success from '../../Components/alerts/Success.vue';

    const defaultTypeObject = {
        id: 0, name: null, type_id: 0, image: null
    };

    export default (await import('vue')).defineComponent({
        name: 'Humans',
        props: ['data', 'humanTypes'],

        components: {
            AppLayout,
            Pagination,
            DialogModal,
            HumanForm,
            PrimaryButton, SecondaryButton, 
            AddButton, EditButton, DeleteButton,
            PlusIcon, PencilIcon, TrashIcon, CircleStackIcon,
            Success, ArrowRightOnRectangleIcon
        },
        setup() {},
        data() {
            return {
                showModal: false,
                isEdit: false,
                formObject: defaultTypeObject,

                types: [],

                selected: [],
                selectAll: false,
            }
        },
        mounted() { },
        created() { 
            this.types = this.humanTypes;
        },
        methods: {
            
            image_path(image){
                return '/' + image;
            },

            saveItem(item) {
                let url = '/humans';
                if (item.id) {
                    url += `/${item.id}`;
                    item._method = 'PUT';
                }
                //console.log(item);
                
                this.$inertia.post(url, item, {
                    onError: (err) => { console.log(err); },
                    onSuccess: () => {
                        this.closeForm();
                    },
                });
                
            },

            select(){
                this.selected = [];
                if( !this.selectAll ){
                    for( let i in this.data.data ){
                        this.selected.push(this.data.data[i].id)
                    }
                }
            },

            openForm(item) {
                //console.log(item);
                //console.log(defaultTypeObject);

                this.isEdit = !!item;
                this.formObject = item ? Object.assign({}, item) : defaultTypeObject;
                this.showModal = true;

                this.$page.props.errors = {};
            },

            closeForm() {
                this.showModal = false;
                this.formObject = defaultTypeObject;
            },

            deleteItem() {
                console.log('deleteItem', this.formObject);
            },
        }
    });
</script>

<template>
    <AppLayout title="Humans">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Humans
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                    <!-- Üzenetek -->
                    <Success :message="$page.props.flash.message" v-if="$page.props.flash.message" />

                    <!-- NEW button -->
                    <AddButton type="button" @click="openForm()">
                        <PlusIcon class="h-5 w-5" />
                    </AddButton>

                    <!-- Human list -->
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        
                        <div class="text-uppercase text-bold">id selected: {{selected}}</div>

                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <!-- SELECT ALL -->
                                    <th scope="col" class="p-4">
                                        <div class="flex items-center">
                                            <input id="checkbox-all-search" 
                                                type="checkbox"
                                                v-model="selectAll" 
                                                @click="select"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox-all-search" 
                                                class="sr-only">checkbox</label>
                                        </div>
                                    </th>
                                    <!-- NAME -->
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <!-- TYPE -->
                                    <th scope="col" class="px-6 py-3">Type</th>
                                    <!-- IMAGE -->
                                    <th scope="col" class="px-6 py-3">Image</th>
                                    <!-- ACTION -->
                                    <th scope="col" class="px-6 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in data.data" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    
                                    <!-- Row checkbox -->
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input id="checkbox-table-search-1" 
                                                type="checkbox"
                                                :value="item.id"
                                                v-model="selected"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                        </div>
                                    </td>
                                    
                                    <!-- Name -->
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ item.name }}
                                    </th>

                                    <!-- Type -->
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ item.type_name }}
                                    </th>

                                    <!-- Image -->
                                    <td class="px-6 py-4">
                                        <img v-if="item.image" :src="image_path(item.image)" 
                                            width="100" height="auto"/>
                                    </td>

                                    <td class="px-6 py-4">

                                        <!-- EDIT button -->
                                        <EditButton type="button" 
                                            @click="openForm(item)">
                                            <PencilIcon class="h-5 w-5" />
                                        </EditButton>

                                        <!-- DELETE button -->
                                        <DeleteButton class="ml-3">
                                            <TrashIcon class="h-5 w-5" />
                                        </DeleteButton>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- PAGINATION -->
                    <div class="flex items-center justify-between pt-4" aria-label="Table navigation">
                        <Pagination :links="data.links"></Pagination>
                    </div>

                </div>
            </div>
        </div>

        <!-- Human Modal -->
        <DialogModal :show="showModal">
            <template #title>
                Human
            </template>
            <template #content>
                <HumanForm :form="formObject" 
                    :types="types" 
                    :isEdit="isEdit"></HumanForm>
            </template>
            <template #footer>
                <!-- Cancel Button -->
                <SecondaryButton type="button" @click="closeForm()" class="self-start">
                    <ArrowRightOnRectangleIcon class="w-6 h-6" />
                </SecondaryButton>

                <!-- Create Button -->
                <PrimaryButton type="button" class="ml-3" v-show="!isEdit" @click="saveItem(formObject)">
                    <CircleStackIcon class="h-5 w-5" />
                </PrimaryButton>

                <!-- Update Button -->
                <PrimaryButton type="button" class="ml-3" v-show="isEdit" @click="saveItem(formObject)">
                    <CircleStackIcon class="h-5 w-5" />
                </PrimaryButton>
            </template>
        </DialogModal>

    </AppLayout>
</template>