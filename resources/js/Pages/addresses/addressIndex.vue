<script>
    import { CircleStackIcon, PencilIcon, PlusIcon, TrashIcon } from '@heroicons/vue/24/solid';
    import AddButton from '../../Components/buttons/AddButton.vue';
    import AppLayout from '../../Layouts/AppLayout.vue';
    import Success from '../../Components/alerts/Success.vue';
    import EditButton from '../../Components/buttons/EditButton.vue';
    import DeleteButton from '../../Components/buttons/DeleteButton.vue';
    import Pagination from '../../Components/Pagination.vue';
    import DialogModal from '../../Components/DialogModal.vue';
    import AddressForm from './addressForm.vue';
    import SecondaryButton from '../../Components/buttons/SecondaryButton.vue';
    import PrimaryButton from '../../Components/buttons/PrimaryButton.vue';
    import ArrowRightOnRectangleIcon from '../../Components/icons/ArrowRightOnRectangleIcon.vue';
    
    import NavLink from '../../Components/NavLink.vue';

    import { 
        initFlowbite, 
        initDropdowns, 
        //Dropdown 
    } from 'flowbite';

    const defaultTypeObject = {
        id: null, company_id: null, human_id: null, type_id: null, city: '', address: ''
    };

    export default (await import('vue')).defineComponent({
        name: 'addressIndex',
        props: ['data', 'companies', 'humans', 'addressTypes'],
        components: {
            AppLayout,
            Success,
            Pagination,
            DialogModal,
            AddressForm,
            AddButton,
            EditButton,
            DeleteButton,
            SecondaryButton,
            PrimaryButton,
            PlusIcon, PencilIcon, TrashIcon, CircleStackIcon,
            ArrowRightOnRectangleIcon,
            NavLink
        },
        data(){
            return {
                showModal: false,
                isEdit: false,
                formObject: defaultTypeObject,

                selected: [],
                selectAll: false,
            }
        },
        created(){},
        mounted(){
            initFlowbite();
            initDropdowns();
        },
        methods: {

            select(){
                this.selected = [];
                if( !this.selectAll ){
                    for( let i in this.data.data ){
                        this.selected.push(this.data.data[i].id)
                    }
                }
            },

            openForm(item){
                
                // TODO: Miért kell konvertálni???
                if( !!item ){
                    item.company_id = String(item.company_id);
                    item.human_id = String(item.human_id);
                    item.type_id = String(item.type_id);
                }else{
                    defaultTypeObject.company_id = '0';
                    defaultTypeObject.human_id = '0';
                    defaultTypeObject.type_id = '0';
                }
                
                this.isEdit = !!item;
                this.formObject = item ? Object.assign({}, item) : defaultTypeObject;
                this.showModal = true;

                //console.log(this.isEdit, this.formObject);

                this.$page.props.errors = {};
            },
            closeForm(){
                this.showModal = false;
                this.formObject = defaultTypeObject;
            },
            saveItem(item){},
            deleteItem(){},
        }
    });
</script>

<template>
    <AppLayout title="Addresses">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Addresses
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

                    <!-- Address List -->
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                        <div class="text-uppercase text-bold">id selected: {{selected}}</div>

                        <!-- SEARCH -->
                        <!--<div class="flex items-center justify-between pb-4 ml-2">
                            <label for="table-search" class="sr-only">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                </div>
                                <input type="text" id="table-search" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for items">
                            </div>
                        </div>-->

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

                                    <!-- COMPANY -->
                                    <th scope="col" class="px-6 py-3">Company</th>
                                    <!-- HUMAN -->
                                    <th scope="col" class="px-6 py-3">Human</th>
                                    <!-- CITY -->
                                    <th scope="col" class="px-6 py-3">City</th>
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

                                    <!-- COMPANY -->
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ item.company_name }}
                                    </th>

                                    <!-- HUMAN -->
                                    <td>
                                        {{ item.human_name }}
                                    </td>

                                    <!-- CITY -->
                                    <td>
                                        {{ item.city }}
                                    </td>

                                    <!-- ACTION -->
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

        <!-- Address Modal -->
        <DialogModal :show="showModal">
            <template #title>
                Address
            </template>

            <template #content>
                <AddressForm :form="formObject" 
                    :companies="companies" 
                    :humans="humans" 
                    :addressTypes="addressTypes"/>
            </template>

            <template #footer>

                <SecondaryButton type="button" @click="closeForm()" class="self-start">
                    <ArrowRightOnRectangleIcon class="w-6 h-6" />
                </SecondaryButton>

                <PrimaryButton type="button" class="ml-3" v-show="!isEdit" @click="saveItem(formObject)">
                    <CircleStackIcon class="h-5 w-5" />
                </PrimaryButton>

                <PrimaryButton type="button" class="ml-3" v-show="isEdit" @click="saveItem(formObject)">
                    <CircleStackIcon class="h-5 w-5" />
                </PrimaryButton>
            </template>

        </DialogModal>

    </AppLayout>
</template>