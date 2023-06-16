<script setup>
import { computed, onMounted, reactive, watch } from 'vue';
import { initFlowbite } from 'flowbite';
import axios from 'axios';

import VPagination from '@hennge/vue3-pagination';
import '@hennge/vue3-pagination/dist/vue3-pagination.css';

import AppLayout from '../../Layouts/AppLayout.vue';
import AddButton from '../../Components/buttons/AddButton.vue';

import SecondaryButton from '../../Components/buttons/SecondaryButton.vue';
import EditButton from '../../Components/buttons/EditButton.vue';
import DialogModal from '../../Components/DialogModal.vue';
import DeleteButton from '../../Components/buttons/DeleteButton.vue';
import PrimaryButton from '../../Components/buttons/PrimaryButton.vue';

const local_storage_column_key = 'ln_companies_grid_columns';

const props = defineProps({
    tags: Array,
});

const defaultFormObject = {
    name: null,
};

const state = reactive({
    editing_company: null,  // Szerkesztendő cég
    deleting_company: null, // Törlendő cég
    company: newCompany(),  // Aktuális cég
    companies: [],          // Cégek tömbje

    tags: [],
    tag_filter_terms: '',
    filtered_tag_chips: [],
    selected_tags: [],
    filters: {
        tags: [],
        search: null,
    },

    //modal_company_form: null,
    //modal_company_delete_confirm: null,
    showSettingsModal: false,
    showCompanyModal: false,
    showCompanyDeleteConfirm: false,

    isEdit: false,
    formObject: defaultFormObject,

    selected: [],
    selectAll: false,

    columns: {
        name: {
            label: 'Name',
            is_visible: true,
        },
    },

    pagination: {
        current_page: 1,
        per_page: 10,
        total: 0,
        range: 5,
    },

});

const tag_filter_options = computed( () => {
    if( !state.tag_filter_terms ){
        return props.tags;
    }

    const search = state.tag_filter_terms.toLowerCase();

    return props.tags.filter(t => t.name.toLowerCase().indexOf( search )!== -1);
});

watch(state.columns, (new_value, old_value) => {
    localStorage.setItem(local_storage_column_key, JSON.stringify(new_value));
});

// initialize components based on data attribute selectors
onMounted(async () => {
    initFlowbite();

    getCompanies();

    let columns = localStorage.getItem(local_storage_column_key);
    if( columns ){
        columns = JSON.parse(columns);
        for( const column_name in columns ){
            state.columns[column_name] = columns[column_name];
        }
    }
});

function select(){
    state.selected = [];
    if( !state.selectAll ){
        for( let i in state.companies ){
            state.selected.push(state.companies[i].id);
        }
    }
}

function removeChip(chip){
    state.filtered_tag_chips = state.filtered_tag_chips
        .filter(c => c.id !== chip.id);

    getCompanies();
}

function getCompanies(page = state.pagination.current_page){
    state.filters.tags = state.filtered_tag_chips.map(tag => tag.id);

    axios.post('companies/grid-data', {
        filters: state.filters,
        config: {
            per_page: state.pagination.per_page,
        },
        page,
    })
    .then(res => {
        state.pagination.total = res.data.companies.last_page
        state.pagination.current_page = res.data.companies.current_page
        state.companies = res.data.companies.data
    })
    .catch(err => { console.log(err); });
}

function newCompany_init(){
    state.company = newCompany();
    state.editing_company = null;
    state.isEdit = false;

    state.showCompanyModal = true;
}

function newCompany(){
    return {
        name: null,
    };
}

function saveCompany(){
    if(state.editing_company && state.editing_company.id){

        axios.put(
            route('companies_update', {company: state.editing_company.id}), 
            {
                name: state.company.name,
            }
        )
        .then(res => {
            state.showCompanyModal = false;

            const k = res.data.company;
            for( let i = 0; state.companies.length > i; i++ ){
                if(state.companies[i].id === k.id){
                    state.companies[i] = k;
                }
            }
        })
        .catch(err => { console.log(err); });

        cancelEdit();

        return;
    }

    axios.post(route('companies_store', {name: state.company.name,})).then(res => {
        state.company = newCompany();
        state.companies.push(res.data.company);
        state.showCompanyModal = false;
    })
    .catch(err => { console.log(err); });

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

    getCompanies();
}

function editCompany(company){
    state.editing_company = JSON.parse(JSON.stringify(company));
    state.company = state.editing_company;
    //state.selected_tags = state.company.map(t => t.id);
    state.isEdit = true;

    state.showCompanyModal = true;
}

function deleteCompany_init(company){
    state.editing_company = null;
    state.deleting_company = company;

    state.showCompanyDeleteConfirm = true;
}

function deleteCompany(){
    axios.delete( route('companies_delete', {company: state.deleting_company.id}) )
        .then( res => {
            state.companies = state.companies.filter(k => k.id != state.deleting_company.id);
            state.deleting_company = null;

            state.showCompanyDeleteConfirm = false;
        } )
        .catch( err => { console.log(err); } );
}

function settings_init(){
    state.showSettingsModal = true;
}
function closeSettings(){
    state.showSettingsModal = false;
}

function closeEdit(){
    cancelEdit();

    state.showCompanyModal = false;
}

function cancelEdit(){
    state.editing_company = null;
    state.company = newCompany();
    state.selected_tags = [];
}

function closeDeleteForm(){
    state.showCompanyDeleteConfirm = false;
}

</script>

<template>
    <AppLayout title="Companies">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Companies
            </h2>
        </template>

        <!-- NEW COMPANY -->
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">

                        <div class="grid grid-cols-2 gap-2">
                            <div class="flex items-center justify-right rounded bg-gray-50 h-28 dark:bg-gray-800">
                                <div>
                                    <h2 class="heading">Manage Your Companies</h2>
                                    <div>
                                        Use the form to create and edit Company.
                                    </div>
                                </div>
                            </div>

                            <!-- ADD -->
                            <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                                <AddButton type="button" 
                                    @click="newCompany_init">
                                    + New Company
                                </AddButton>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- SEARCH & FILTER -->
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

                                <div class="mt-3 d-flex align-items-center justify-content-end">
                                    <div class="">
                                        <SecondaryButton 
                                            @click="getCompanies"
                                        >Search</SecondaryButton>
                                    </div>
                                </div>

                            </div>

                        </div>
                        
                    </div>

                </div>
            </div>
        </div>

        <!-- Companies table -->
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            
                            <!-- Selected ids -->
                            <div class="text-uppercase text-bold">id selected: {{state.selected}}</div>

                            <!-- Settings -->
                            <div>
                                <SecondaryButton @click="settings_init">
                                    Settings
                                </SecondaryButton>
                            </div>

                            <!-- TABLE -->
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="p-4">
                                            <div>
                                                <input id="checkbox-all" 
                                                    type="checkbox"
                                                    v-model="state.selectAll"
                                                    @click="select"
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"/>
                                                <label for="checkbox-all" 
                                                    class="sr-only">checkbox</label>
                                            </div>
                                        </th>

                                        <th scope="col" v-show="state.columns.name.is_visible">
                                            {{ state.columns.name.label }}
                                        </th>

                                        <th scope="col" class="px-6 py-3 content-center">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="company in state.companies">
                                        <td scope="row" class="w-4 p-4">
                                            <div>
                                                <input :id="company.id"  
                                                    type="checkbox"
                                                    :value="company.id"
                                                    :key="company.id"
                                                    v-model="state.selected"
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"/>
                                                <label class="sr-only" 
                                                    :for="company.id">checkbox</label>
                                            </div>
                                        </td>
                                        <th scope="row" 
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                            v-show="state.columns.name.is_visible">
                                            {{ company.name }}
                                        </th>
                                        <td scope="row" class="px-6 py-4">
                                            <!-- EDIT button -->
                                            <EditButton @click="editCompany(company)">
                                                Edit
                                            </EditButton>

                                            <!-- DELETE button -->
                                            <DeleteButton @click="deleteCompany_init(company)">
                                                Delete
                                            </DeleteButton>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <div class="mb-3 bg-white shadow bg-body rounded w-75 ln-max-width mx-auto p-3 d-flex align-items-center justify-content-center">
                                <v-pagination v-model="state.pagination.current_page" 
                                    :pages="state.pagination.total"  
                                    :range-size="state.pagination.range"
                                    active-color="#DCEDFF"
                                    @update:modelValue="getCompanies"/>
                        </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Settings modal -->
        <DialogModal :show="state.showSettingsModal" id="modal_settings">
            <template #title>
                Settings
            </template>
            <template #content>
                <div v-for="(config, column) in state.columns" 
                    :key="column" class="d-flex align-items-center">
                    <input v-model="config.is_visible" 
                        :id="column" class="me-3" type="checkbox" />
                    <label :for="column">{{ config.label }}</label>
                </div>
            </template>
            <template #footer>
                <SecondaryButton @click="closeSettings">
                    Close
                </SecondaryButton>
            </template>
        </DialogModal>

        <!-- Edit modal -->
        <DialogModal :show="state.showCompanyModal" id="modal_edit">
            <template #title>
                <span>{{ state.isEdit ? 'Edit' : 'Create' }} Company</span>
            </template>
            <template #content>

                <!-- NAME -->
                <div class="mb-6">
                    <label for="name" 
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >First name</label>
                    <input type="text" id="name" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                        placeholder="John" 
                        v-model="state.company.name" required>
                </div>

            </template>
            <template #footer>
                <SecondaryButton type="button" 
                    class="self-start" 
                    @click="closeEdit">
                    Cancel
                </SecondaryButton>

                <PrimaryButton type="button" class="ml-3" 
                    @click="saveCompany">
                    {{ state.isEdit ? 'Update' : 'Create' }} Company
                </PrimaryButton>
            </template>
        </DialogModal>

        <!-- Confirm Delete modal -->
        <DialogModal :show="state.showCompanyDeleteConfirm" id="modal_delete">
            <template #title>
                Confirm Delete
            </template>
            <template #content>
                Are you sure you want to delete this Company?
            </template>
            <template #footer>
                <PrimaryButton @click="deleteCompany">
                    Delete
                </PrimaryButton>

                <SecondaryButton type="button" 
                    class="self-start" 
                    @click="closeDeleteForm">
                    Close
                </SecondaryButton>
            </template>
        </DialogModal>

    </AppLayout>
</template>