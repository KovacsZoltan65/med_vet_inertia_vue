<script setup>
    import { reactive, onMounted, watch, computed } from 'vue';
    import axios from 'axios';
    import VPagination from '@hennge/vue3-pagination';
    import '@hennge/vue3-pagination/dist/vue3-pagination.css';

    //import Modal from '../../Shared/Modal.vue';

    import AppLayout from '../../Layouts/AppLayout.vue';
    import DialogModal from '../../Components/DialogModal.vue';

    import AddButton from '../../Components/buttons/AddButton.vue';

    import SorterIcon from '../../Components/icons/SorterIcon.vue';

    const local_storage_column_key = 'ln_offices_columns';

    const props = defineProps({
        tags: Array
    });

    const state = reactive({
        editing_office: null,
        deleteing_office: null,

        office: newOffice(),
        offices: [],
        tags: [],
        tag_filter_terms: '',
        filtered_tag_chips: [],

        modal_edit: false,
        modal_delete: false,
        modal_settings: false,

        selected_tags: [],
        filters: {
            tags: [],
            search: null,
        },

        columns: {
            name: {
                label: 'Name',
                is_visible: true
            },
            type: {
                label: 'Type',
                is_visible: true
            }
        },

        pagination: {
            current_page: 1,
            per_page: 10,
            number_of_pages: 0,
            range: 5,
        },
    });

    watch(state.columns, (new_value, old_value) => {
        localStorage.setItem(local_storage_column_key, JSON.stringify(new_value));
    });

    onMounted(() => {
        getOffices();

        if( columns ){
            columns = JSON.parse(columns);

            for( const column_name in columns ){
                state.columns[column_name] = columns[column_name];
            }
        }
    });

    function newOffice_init(){
        state.office = newOffice();
        state.editing_office = null;

        openEdit();
    }

    function newOffice(){
        return {
            name: null,
            type: null,
        };
    }

    function editOffice(office){
        state.editing_office = JSON.parse(JSON.stringify(office));
        state.office = state.editing_office;
        state.selected_tags = state.office.tags.map(t => t.id);

        openEdit();
    }

    function deleteOffice_init(office){
        state.editing_office = null;
        state.deleteing_office = office;

        openDelete();
    }
    function deleteOffice(){
        
    }

    function updateFilteredTagChips(tag){
        let found = false;

        for( let i = 0; i < state.filtered_tag_chips.length; i++ ){
            if( state.filtered_tag_chips[i].id === tag.id ){
                found = true;
            }
        }

        if( found ){ return; }

        state.filtered_tag_chips.push(JSON.parse(JSON.stringify(tag)));

        getOffices();
    }

    function removeChips(chip){
        state.filtered_tag_chips = state.filtered_tag_chips.filter( c => c.id != chip.id );

        getOffices();
    }

    function getOffices( page = state.pagination.current_page ){
        state.filters.tags = state.filtered_tag_chips.map(tag => tag.id);

        axios.post('/offices/grid-data', {
            filters: state.filters,
            config: {
                per_page: state.pagination.per_page,
            }, 
            page,
        })
        .then( res => {
            state.pagination.number_of_pages = res.data.offices.last_page;
            state.pagination.current_page = res.data.offices.current_page;
            state.offices = res.data.offices.data;
        } )
        .catch( err => { console.log(err); } );
    }

    function openSettings(){ state.modal_settings = true; }
    function closeSettings(){ state.modal_settings = false; }

    function openEdit(){ state.modal_edit = true; }
    function closeEdit(){ state.modal_edit = false; }

    function openDelete(){ state.modal_delete = true; }
    function closeDelete(){ state.modal_delete = false; }

</script>

<template>
    <AppLayout title="Offices">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Offices
            </h2>
        </template>

        <!-- Panel Add -->
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            
                            <div class="flex items-center justify-right rounded bg-gray-50 h-28 dark:bg-gray-800">
                                <div>
                                    <h2 class="heading">Manage Your Offices</h2>
                                    <div>
                                        Use the form to create and edit Offices.
                                    </div>
                                </div>
                            </div> <!-- <div class="flex items-center justify-right rounded bg-gray-50 h-28 dark:bg-gray-800"> -->
                            
                            <!-- ADD -->
                            <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                                <AddButton type="button" 
                                           @click="openEdit">
                                    + New Office
                                </AddButton>
                            </div>

                        </div> <!-- <div class="grid grid-cols-2 gap-2 mb-4"> -->
                    </div> <!-- <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700"> -->
                </div> <!-- <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4"> -->
            </div><!-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> -->
        </div>

        <!-- Panel Filter & Search -->
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
                            </div>

                        </div> <!-- <div class="grid grid-cols-2 gap-2 mb-4"> -->
                    </div> <!-- <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700"> -->
                </div> <!-- <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4"> -->
            </div> <!-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> -->
        </div>

        <div class="py-2"></div>

        <!-- Settings Modal -->
        <DialogModal></DialogModal>

        <!-- Edit Modal -->
        <DialogModal></DialogModal>

        <!-- Delete Modal -->
        <DialogModal></DialogModal>
    </AppLayout>
</template>