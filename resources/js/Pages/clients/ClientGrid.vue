<script setup>
    import { reactive, onMounted, watch, computed } from 'vue';
    import axios from 'axios';
    import SecondaryButton from '../../Components/buttons/SecondaryButton.vue';
    import PrimaryButton from '../../Components/buttons/PrimaryButton.vue';

    import DialogModal from '../../Components/DialogModal.vue';
    import AddButton from '../../Components/buttons/AddButton.vue';
    import AppLayout from '../../Layouts/AppLayout.vue';
    import EditButton from '../../Components/buttons/EditButton.vue';
    import DeleteButton from '../../Components/buttons/DeleteButton.vue';

    import SorterIcon from '../../Components/icons/SorterIcon.vue';

    import VPagination from '@hennge/vue3-pagination';
    import '@hennge/vue3-pagination/dist/vue3-pagination.css';

    const local_storage_column_key = 'ln_client_grid_columns';

    const props = defineProps({
        tags: Array,
    });

    const defaultFormObject = {
        name_first: null, name_last: null, email: null, description: null,
    };

    const state = reactive({
        editing_client: null,
        deleting_client: null,

        client: newClient(),
        clients: [],
        tags: [],
        tag_filter_terms: '',
        filtered_tag_chips: [],

        showModal: false,
        showDeleteModal: false,
        showSettingsModal: false,

        isEdit: false,
        formObject: defaultFormObject,

        selected_tags: [],
        filters: {
            tags: [],
            search: null,
        },

        columns: {
            name_first: {
                label: 'First Name',
                is_visible: true,
            },
            name_last: {
                label: 'Last Name',
                is_visible: true,
            },
            email: {
                label: 'Email',
                is_visible: true,
            },
            description: {
                label: 'Description',
                is_visible: true,
            },
            tags: {
                label: 'Tags',
                is_visible: true,
            },
        },

        pagination: {
            current_page: 1,
            total_number_of_pages: 0,
            per_page: 10,
            range: 5,
        },
    });

    const tag_filter_options = computed(() => {
        if( !state.tag_filter_terms )
        {
            return props.tags;
        }

        const search = state.tag_filter_terms.toLowerCase();

        return props.tags.filter(t => t.name.toLowerCase().indexOf(search) > -1);
    });

    watch(state.columns, (new_value, old_value) => {
        localStorage.setItem(local_storage_column_key, JSON.stringify(new_value))
    });

    onMounted(async () => {
        getClients();

        let columns = localStorage.getItem(local_storage_column_key);
        if(columns){
            columns = JSON.parse(columns);
            for(const column_name in columns){
                state.columns[column_name] = columns[column_name];
            }
        }
    });

    /*
    onMounted(() => {
        getClients();

        let columns = localStorage.getItem(local_storage_column_key);
        if(columns){
            columns = JSON.parse(columns);
            for(const column_name in columns){
                state.columns[column_name] = columns[column_name];
            }
        }
    });
    */

    // ==============
    // SETTINGS MODAL
    // ==============
    function openSettings(){
        state.showSettingsModal = true;
    }

    function closeSettings(){
        state.showSettingsModal = false;
    }
    // ==============

    function updateFilteredTagChips(tag){
        let found = false;

        for (let i = 0; i < state.filtered_tag_chips.length; i++) {
            if (state.filtered_tag_chips[i].id == tag.id) {
                found = true;
            }
        }

        if( found) return;

        state.filtered_tag_chips.push(JSON.parse(JSON.stringify(tag)));

        getClients();
    }

    function removeChip(chip) {
        // remove from chips
        state.filtered_tag_chips = state.filtered_tag_chips
            .filter(c => c.id != chip.id);

        getClients();

    }

    function getClients(page = state.pagination.current_page) {
        state.filters.tags = state.filtered_tag_chips.map(tag => tag.id)

        axios.post('/clients/grid-data', {
            filters: state.filters,
            config: {
                per_page: state.pagination.per_page,
            },
            page,
        })
            .then(res => {
                state.pagination.total_number_of_pages = res.data.clients.last_page
                state.pagination.current_page = res.data.clients.current_page
                state.clients = res.data.clients.data
            })
            .catch(err => {
                //debugger
                console.log(err);
            });
    }

    function newClient_init() {
        state.client = newClient();
        state.editing_client = null;
        state.isEdit = false;

        state.showModal = true;
    }

    function closeForm(){
        this.cancelEdit();
        state.showModal = false;
    }

    function cancelEdit() {
        state.editing_client = null
        state.client = newClient()
        state.selected_tags = []
    }

    function newClient() {
        return {
            name_first: null,
            name_last: null,
            description: null,
            email: null,
        }
    }

    function editClient(_client) {
        // avoid mutating by reference
        state.editing_client = JSON.parse(JSON.stringify(_client))
        state.client = JSON.parse(JSON.stringify(_client))
        state.selected_tags = state.client.tags.map(t => t.id)
        state.isEdit = true;
        
        //state.modal_client_form.show()
        state.showModal = true;
    }

    function deleteClient_init(client) {
        state.editing_client = null
        state.deleting_client = client

        //state.modal_client_delete_confirm.show()
        state.showDeleteModal = true;
    }

    function deleteClient() {

        axios.delete(route('clients_delete', { client: state.deleting_client.id }))
        .then(res => {

            state.clients = state.clients.filter(k => k.id != state.deleting_client.id)

            state.deleting_client = null

            //state.modal_client_delete_confirm.hide()
            state.showDeleteModal = false;
        })
        .catch(err => {
            debugger
        })
    }

    function saveClient() {
        if (state.editing_client && state.editing_client.id) {

            axios.put(
                route('clients_update', { client: state.editing_client.id }),
                {
                    name_first: state.client.name_first,
                    name_last: state.client.name_last,
                    description: state.client.description,
                    email: state.client.email,
                    tags: state.selected_tags,
                }
            )
                .then(res => {

                    //state.modal_client_form.hide()
                    state.showModal = false;
                    
                    const k = res.data.client

                    for (let i = 0; i < state.clients.length; i++) {
                        if (state.clients[i].id === k.id) {
                            state.clients[i] = k
                        }
                    }
                })
                .catch(err => {
                    //debugger
                    console.log(err);
                })

            cancelEdit()
            return
        }

        axios.post(route('clients_store'), {
            name_first: state.client.name_first,
            name_last: state.client.name_last,
            description: state.client.description,
            email: state.client.email,
            tags: state.selected_tags,
        })
            .then(res => {

                // clear the form
                state.client = newClient()
                state.clients.push(res.data.client)

                state.modal_client_form.hide()
            })
            .catch(err => {
                debugger
            })

    }
</script>

<template>
    <AppLayout title="clientGrid">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Client Grid
            </h2>
        </template>

        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">

                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div class="flex items-center justify-right rounded bg-gray-50 h-28 dark:bg-gray-800">
                                <div>
                                    <h2 class="heading">Manage Your Clients</h2>
                                    <div>
                                        Use the form to create and edit Clients.
                                    </div>
                                </div>
                            </div>

                            <!-- ADD -->
                            <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                                <AddButton type="button" 
                                    @click="newClient_init()">
                                    + New Client
                                </AddButton>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">

                        <div class="grid grid-cols-2 gap-2 mb-4">

                            <!-- FILTER -->
                            <div class="flex items-center justify-right rounded bg-gray-50 h-28 dark:bg-gray-800">
                                
                                <label for="countries_multiple" 
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >Select an option</label>
                                <!--<h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Password requirements:</h2>-->
                                <ul class="max-w-md space-y-1 text-gray-500 list-inside dark:text-gray-400" 
                                    v-if="props.tags.length > 0">
                                    <li class="flex items-center" v-for="tag in props.tags" 
                                        :value="tag.id" :key="tag.id"
                                        @click="updateFilteredTagChips(tag)">
                                        <svg class="w-4 h-4 mr-1.5 text-green-500 dark:text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ tag.name }}
                                    </li>
                                </ul>

                                <div v-else>
                                    You don't have any tags.
                                </div>

                                <div class="">
                                    <div class="form-group mb-3 chips">
                                        <div class="d-flex align-items-center justify-content-start">
                                            <div class="ms-1 me-1" 
                                                v-for="chip in state.filtered_tag_chips" 
                                                :key="chip.id">
                                                <button class="btn btn-success" 
                                                    @click="removeChip(chip)">
                                                    @{{ chip.name }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SEARCH -->
                            <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                                
                                <label for="table-search" class="sr-only">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" 
                                            aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" 
                                            xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" 
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input type="text" id="filter.search" 
                                        class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                        placeholder="Search for items"
                                        v-model="state.filters.search">
                                </div>

                                <div class="mt-3 d-flex align-items-center justify-content-end">
                                    <div class="">
                                        <SecondaryButton 
                                            @click="getClients"
                                        >Search</SecondaryButton>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                    <SecondaryButton @click="openSettings">
                        Settings
                    </SecondaryButton>

                    <!-- TABLE -->
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th>SELECT ALL</th>
                                <th scope="col" class="px-6 py-3" v-show="state.columns.name_first.is_visible">
                                    <div class="flex items-center">
                                        First Name
                                        <a href="#">
                                            <!--<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>-->
                                            <SorterIcon/>
                                        </a>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3" v-show="state.columns.name_last.is_visible">
                                    <div class="flex items-center">
                                        Last Name
                                        <a href="#">
                                            <!--<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>-->
                                            <SorterIcon/>
                                        </a>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3" v-show="state.columns.email.is_visible">
                                    <div class="flex items-center">
                                        Email
                                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3" v-show="state.columns.description.is_visible">
                                    <div class="flex items-center">
                                        Description
                                        <a href="#">
                                            <!--<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>-->
                                            <SorterIcon/>
                                        </a>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3" v-show="state.columns.tags.is_visible">
                                    <div class="flex items-center">
                                        Tags
                                        <a href="#">
                                            <!--<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>-->
                                            <SorterIcon/>
                                        </a>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="client in state.clients">
                                <td class="w-4 p-4">select</td>
                                
                                <th scope="row" 
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    v-show="state.columns.name_first.is_visible">
                                    {{ client.name_first }}
                                </th>
                                
                                <th scope="row" 
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    v-show="state.columns.name_last.is_visible">
                                    {{ client.name_last }}
                                </th>
                                
                                <td class="px-6 py-4"
                                    v-show="state.columns.email.is_visible">
                                    {{ client.email }}
                                </td>

                                <td class="px-6 py-4"
                                    v-show="state.columns.description.is_visible">
                                    {{ client.description }}
                                </td>
                                
                                <td class="px-6 py-4"
                                    v-show="state.columns.tags.is_visible">
                                    {{ client.tags.map( t => t.name ).join(',') }}
                                </td>

                                <td class="px-6 py-4">
                                    <!-- EDIT button -->
                                    <EditButton 
                                        @click="editClient(client)">
                                        Edit
                                    </EditButton>

                                    <!-- DELETE button -->
                                    <DeleteButton 
                                        @click="deleteClient_init(client)">
                                        Delete
                                    </DeleteButton>

                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div>
                        <v-pagination v-model="state.pagination.current_page"
                            :pages="state.pagination.total_number_of_pages"
                            :range-size="state.pagination.range"
                            active-color="#DCEDFF"
                            @update:modelValue="getClients"/>
                    </div>

                </div>

                
            </div>
        </div>

        <!-- Settings Modal -->
        <DialogModal :show="state.showSettingsModal" 
            id="modal_settings">
            <template #title>
                Settings
            </template>

            <template #content>
                <!--<div v-for="(config, column) in state.columns" 
                    :key="column" 
                    class="d-flex align-item-center">
                    <input v-model="config.is_visible" 
                        :id="column" class="mb-3" 
                        type="checkbox"/>
                    <label :for="column">{{ config.label }}</label>
                </div>-->
                <fieldset>
                    <legend class="sr-only">Checkbox variants</legend>

                    <div class="flex items-center mb-4" 
                        v-for="(config, column) in state.columns" 
                        :key="column">

                        <input v-model="config.is_visible" 
                            :id="column" type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label :for="column" 
                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                        >{{ config.label }}</label>
                    </div>

                </fieldset>
            </template>

            <template #footer>
                <SecondaryButton @click="closeSettings">
                    Close
                </SecondaryButton>
            </template>
        </DialogModal>

        <!-- New Client Modal -->
        <DialogModal :show="state.showModal" id="modal_client_form">
            <template #title>
                <span v-if="state.editing_client && state.editing_client.id">Edit Client</span>
                <span v-else>Create Client</span>
                {{ state.isEdit ? 'Edit Client' : 'Create Client'}}
            </template>

            <template #content>

                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <!-- first name -->
                    <div>
                        <label for="name_first" 
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >First name</label>
                        <input type="text" id="name_first" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            placeholder="John" 
                            v-model="state.client.name_first"
                            required>
                    </div>
                    <!-- last name -->
                    <div>
                        <label for="name_last" 
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Last name</label>
                        <input type="text" id="name_last" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            placeholder="Doe" 
                            v-model="state.client.name_last"
                            required>
                    </div>
                    <!-- email -->
                    <div>
                        <label for="email" 
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Email</label>
                        <input type="text" id="email" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            placeholder="example@email.com" v-model="state.client.email" required>
                    </div>
                    <!-- description -->
                    <div>
                        <label for="description" 
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Description</label>
                        <input type="text" id="description" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            v-model="state.client.description" required>
                    </div>

                </div>

                <!-- Select Tags -->
                <div class="mb-6">
                    <label for="select_tags" 
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Select Tags</label>
                    
                    <select multiple id="select_tags" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        v-if="props.tags.length > 0"
                        v-model="state.selected_tags">
                        <option v-for="tag in props.tags" 
                            :value="tag.id" 
                            :key="tag.id">{{ tag.name }}</option>
                    </select>
                    <div v-else>
                        You don't have any tags.
                    </div>
                </div>

            </template>

            <template #footer>
                <SecondaryButton type="button" class="self-start" 
                    @click="closeForm()"
                >Cancel</SecondaryButton>

                <PrimaryButton type="button" class="ml-3" 
                    v-show="!state.isEdit" @click="saveClient()"
                >Create</PrimaryButton>

                <PrimaryButton type="button" class="ml-3" 
                    v-show="state.isEdit" @click="saveClient()"
                >Update</PrimaryButton>

            </template>
        </DialogModal>

        <!-- Confirm Delete Modal -->
        <DialogModal :show="state.showDeleteModal" 
            id="modal_client_delete_confirm">
            <template #title>
                Delete Client
            </template>

            <template #content>
                Are you sure you want to delete this Client?
            </template>

            <template #footer>
                <SecondaryButton type="button" class="self-start" 
                    @click="closeDeleteForm()">
                    Cancel
                </SecondaryButton>
            </template>
        </DialogModal>

    </AppLayout>
</template>