<script setup>
import { computed, onMounted, reactive, watch } from 'vue';
import { initFlowbite } from 'flowbite';
import axios from 'axios';

import AppLayout from '../../Layouts/AppLayout.vue';
import DialogModal from '../../Components/DialogModal.vue';
import SecondaryButton from '../../Components/buttons/SecondaryButton.vue';
import PrimaryButton from '../../Components/buttons/PrimaryButton.vue';
import EditButton from '../../Components/buttons/EditButton.vue';
import DeleteButton from '../../Components/buttons/DeleteButton.vue';

const local_storage_column_key = 'ln_roles_grid_columns';
const defaultFormObject = {
    title: null
};

const props = defineProps({
    roles: Array,
    filters: Object,
    config: Object
});

const state = reactive({

    editing_role: null,     // Szerkesztendő rekord
    deleting_role: null,    // Törlesndő rekord
    role: newRole(),        // Aktuális rekord
    roles: [],              // Rekordok
    isEdit: false,          // Szerkesztő mód megjelölése

    selected: [],
    selectAll: false,

    showSettingsModal: false,       // Beállítások Modal megnyitása / becsukása
    showRoleModal: false,           // Create / Edit Modal megnyitása / becsukása
    showDeleteConfirmModal: false,  // Törlés megerősítés Modal megnyitása / becsukása

    isEdit: false,
    formObject: defaultFormObject,

    tags: [],
    tag_filter_terms: '',
    filtered_tag_chips: [],
    selected_tags: [],

    filters: {
        tags: [],
        search: null,
    },

    config: {},

    columns: {
        title: {
            label: 'Title',
            is_visible: true
        }
    },
    pagination: {
        current_page: 1,
        per_page: props.config.per_page,
        total: 0,
        range: 5,
    }
});

onMounted( async() => {
    initFlowbite();

    getRoles();

    let columns = localStorage.getItem(local_storage_column_key);
    if(columns){
        columns = JSON.parse(columns);
        for( const column_name in columns ){
            state.columns[column_name] = columns[column_name];
        }
    }

    //console.log(props.roles);
    //console.log(props.filters);
    //console.log(props.config);
    //console.log(state.pagination);
});

function getRoles(page = state.pagination.current_page){
    state.filters.tags = state.filtered_tag_chips.map(tag => tag.id);

    axios.post(route('roles_grid_data'), {
        filters: state.filters,
        config: {
            per_page: state.pagination.per_page,
        },
        page
    })
    .then(res => {
        state.pagination.total = res.data.roles.last_page;
        state.pagination.current_page = res.data.roles.current_page;
        state.roles = res.data.roles.data;
    })
    .catch(err => { console.log(err); });
}

function select(){
    state.selected = [];
    if( !state.selectAll ){
        for( let i in state.roles ){
            state.selected.push(state.roles[i].id);
        }
    }
}

//
function updateFilteredTagChips(tag){
    let found = false;

    for( let i = 0; i < state.filtered_tag_chips; i++ ){
        if( state.filtered_tag_chips[i].id == tag.id ){
            found = true;
        }
    }

    if ( found ){ return; }
    state.filtered_tag_chips.push( JSON.parse(JSON.stringify(tag)) );

    getRoles();
}
//
function removeChip(chip){
    state.filtered_tag_chips = state.filtered_tag_chips.filter(c => c.id != chip.id);
    getRoles();
}

// Settings modal close
function closeSettingsModal(){
    state.showSettingsModal = false;
}

//
function newRole_init(){
    state.role = newRole();
    state.editing_role = null;
    state.showRoleModal = true;
}
//
function newRole(){
    return {
        title: null,
    };
}
// Adatok mentése
function saveRole(){
    if(state.editing_role && state.editing_role.id){
        //
        axios.put(route('role_update', {role: state.editing_role.id}), {
            title: state.role.title
        })
        .then(res => {
            const r = res.data.role;
            for(let i = 0; i < state.roles.length; i++){
                if(state.roles[i].id == r.id){
                    state.roles[i] = r;
                }
            }
            state.showRoleModal = false;
        })
        .catch(err => {
            console.log(err);
        });
    }
}
// Create / Edit modal close
function closeEditModal(){
    cancelEdit();

    state.showRoleModal = false;
}
//
function cancelEdit(){
    state.editing_role = null;
    state.role = newRole();
    state.selected_tags = [];
}
//
function editRole(role){
    state.editing_role = JSON.parse(JSON.stringify(role));
    state.role = state.editing_role;
    
    //state.selected_tags = state.role.tags.map(t => t.id);
    state.isEdit = true;

    state.showRoleModal = true;
}
// Törlés előkészítése
function deleteRole_init(role){
    state.editing_role = null;
    state.deleting_role = role;
    state.showDeleteConfirmModal = true;
}
// Rekord törlése
function deleteRole(){
    axios.delete(route('roles_delete'), {role: state.deleting_role.id})
    .then(res => {
        state.roles = state.roles.filter(r => r.id != state.deleting_role.id);
        state.deleting_role = null;
        state.showDeleteConfirmModal = false;
    })
    .catch(err => { console.log(err); });
}
// ConfirmDelete modal close
function closeDeleteModal(){
    state.showDeleteConfirmModal = false;
}

</script>

<template>
    <AppLayout title="Roles">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Roles
            </h2>
        </template>

        <!-- NEW ROLE -->
        <div class="py-2"></div>

        <!-- SEARCH & FILTER -->
        <div class="py-2"></div>

        <!-- ROLES TABLE -->
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

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

                                        <th scope="col" v-show="state.columns.title.is_visible">
                                            {{ state.columns.title.label }}
                                        </th>

                                        <th scope="col" class="px-6 py-3 content-center">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="role in state.roles">
                                        <td scop="row" class="w-4 p-4">
                                            <div>
                                                <input type="checkbox" 
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                    :id="role.id"
                                                    :value="role.id"
                                                    :key="role.id"
                                                    v-model="state.selected"/>
                                                <label class="sr-only" 
                                                    :for="role.id">checkbox</label>
                                            </div>
                                        </td>
                                        <th scope="row" 
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" 
                                            v-show="state.columns.title.is_visible">
                                            {{ role.title }}
                                        </th>

                                        <td scope="row" class="px-6 py-4">
                                            <!-- EDIT button -->
                                            <EditButton @click="editRole(role)">
                                                Edit
                                            </EditButton>

                                            <!-- DELETE button -->
                                            <DeleteButton @click="deleteRole_init(role)">
                                                Delete
                                            </DeleteButton>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Modal -->
        <DialogModal :show="state.showRoleModal" id="settings_modal">
            <template #title>
                <span>Settings</span>
            </template>
            
            <template #content>

                <div v-for="(config, column) in state.columns" 
                    :key="column" class="d-flex align-items-center">
                    <input v-model="config.is_visible" :id="column" class="me-3" type="checkbox"/>
                    <label :from="column">{{ config.label }}</label>
                </div>

            </template>

            <template #footer>
                <SecondaryButton @click="closeSettingsModal" class="self-start">
                    Close
                </SecondaryButton>
            </template>
        </DialogModal>

        <!-- Create / Edit Modal -->
        <DialogModal :show="state.showRoleModal" id="edit_modal">
            <template #title>
                <span>{{ state.isEdit ? 'Edit' : 'Create' }} Role</span>
            </template>
            <template #content>

                <div class="mb-6">
                    <label for="title" 
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Title</label>
                    <input type="text" id="title" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                        placeholder="John" 
                        v-model="state.role.title" required>
                </div>

            </template>
            <template #footer>
                <PrimaryButton class="ml-3" @click="saveRole">
                    {{ state.isEdit ? 'Update' : 'Create' }} Role
                </PrimaryButton>
                <SecondaryButton @click="closeEditModal" class="self-start">
                    Cancel
                </SecondaryButton>
            </template>
        </DialogModal>

        <!-- Confirm Delete Modal -->
        <DialogModal :show="state.showDeleteConfirmModal" id="delete_confirm_modal">
            <template #title>
                Confirm Delete
            </template>
            <template #content>
                Are you sure you want to delete this Role?
            </template>
            <template #footer>
                <PrimaryButton @click="deleteRole"></PrimaryButton>
                <SecondaryButton @click="closeDeleteModal" class="self-start">
                    Cancel
                </SecondaryButton>
            </template>
        </DialogModal>

    </AppLayout>
</template>