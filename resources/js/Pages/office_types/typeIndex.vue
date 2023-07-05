<script setup>
    import { reactive, onMounted, watch, computed } from 'vue';
    import axios from 'axios';
    import VPagination from '@hennge/vue3-pagination';
    import '@hennge/vue3-pagination/dist/vue3-pagination.css';
    import AppLayout from '../../Layouts/AppLayout.vue';
    import AddButton from '../../Components/buttons/AddButton.vue';
    import PrimaryButton from '../../Components/buttons/PrimaryButton.vue';
    import SecondaryButton from '../../Components/buttons/SecondaryButton.vue';
    import EditButton from '../../Components/buttons/EditButton.vue';
    import DeleteButton from '../../Components/buttons/DeleteButton.vue';
    import SorterIcon from '../../Components/icons/SorterIcon.vue';
    import DialogModal from '../../Components/DialogModal.vue';

    const local_storage_column_key = 'ln_officeType_grid_columns';
    const props = defineProps({
        tags: Array
    });
    const defaultFormObject = {
        name: null,
    };
    const state = reactive({
        editing_type: null,
        deleting_type: null,
        type: newType(),
        types: [],
        tags: [],
        tag_filter_terms: '',
        filtered_tag_chips: [],
        showEditModal: false,
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
            name: {
                label: 'Name',
                is_visible: true,
            },
            label: {
                label: 'Label',
                is_visible: true,
            },
            tags: {
                label: 'Tags',
                is_visible: true,
            }
        },
        pagination: {
            current_page: 1,
            per_page: 10,
            number_of_pages: 0,
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
        localStorage.setItem(local_storage_column_key, JSON.stringify(new_value));
    });

    onMounted(async () => {
        getOfficeTypes();
    });

    function getOfficeTypes(page = state.pagination.current_page) {
        state.filters.tags = state.filtered_tag_chips.map(tag => tag.id);

        axios.post(route('office_types_grid_data'), {
            filters: state.filters,
            config: {
                per_page: state.pagination.per_page,
            }, 
            page,
        })
        .then(res => {
            state.types = res.data.office_types.data;
            state.pagination.current_page = res.data.office_types.current_page;
            state.pagination.number_of_pages = res.data.office_types.last_page;
        })
        .catch(err => { console.log(err); });
    };
    
    function getOfficeType(){
        //
    }

    function updateFilteredTagChips(tag){
        let found = false;

        for (let i = 0; i < state.filtered_tag_chips.length; i++) {
            if (state.filtered_tag_chips[i].id == tag.id) {
                found = true;
            }
        }

        if( found) return;

        state.filtered_tag_chips.push(JSON.parse(JSON.stringify(tag)));

        getOfficeTypes();
    }
    function removeChip(chip) {
        // remove from chips
        state.filtered_tag_chips = state.filtered_tag_chips
            .filter(c => c.id != chip.id);

        getOfficeTypes();
    }
    function newType_init() {
        state.type = newType();
        state.editing_type = null;
        state.isEdit = false;
        state.showEditModal = true;
    };
    function newType() {
        return {
            name: null
        };
    };
    function cancelEdit(){
        state.editing_type = null;
        state.type = newType();
        state.selected_tags = [];
        closeEditModal();
    };
    function editType(type){
        state.editing_type = JSON.parse(JSON.stringify(type));
        state.type = state.editing_type;
        console.log('state.type',state.type);
        //state.selected_tags = state.type.tags.map(t => t.id);
        state.isEdit = true;

        openEditModal();
    };
    function deleteType_init(type){
        state.editing_type = null;
        state.deleting_type = type;
        state.showDeleteModal = true;
    }
    function deleteType(){
        axios.delete(route('/office_types/delete'), {client:state.deleting_type.id})
        .then(res => {
            state.types = state.types.filter(t => t.id!= state.deleting_type.id);
            state.deleting_type = null;
            state.showDeleteModal = false;
        })
        .catch(err => { console.log(err); });
    }
    function cancelDelete(){
        state.deleting_type = null;
        state.showDeleteModal = false;
    }
    function saveType(){
        if(state.editing_type && state.editing_type.id){
            axios.put(
                route('/office_types/update'), 
                {type:state.editing_type.id}, 
                { name: state.type.name }
            )
            .then(res => {
                const t = res.data.type;
                for(let i = 0; i < state.types.length; i++){
                    if(state.types[i].id === t.id){
                        state.types[i] = t;
                    }
                }
                state.showEditModal = false;
            })
            .catch(err => { console.log(err); });

            cancelEdit();

            return;
        }
    };

    function openSettingsModal() { state.showSettingsModal = true; };
    function closeSettingsModal() { state.showSettingsModal = false; };
    function openEditModal() { state.showEditModal = true; };
    function closeEditModal() { state.showEditModal = false; };
    function openDeleteModal() { state.showDeleteModal = true; };
    function closeDeleteModal() { state.showDeleteModal = false; };

</script>

<template>
    <AppLayout title="Office Types">
        <template>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Office Types
            </h2>
        </template>

        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div class="flex items-center justify-right rounded bg-gray-50 h-28 dark:bg-gray-800">
                                <div>
                                    <h2 class="heading">Manage Your Office Types</h2>
                                    <div>
                                        Use the form to create and edit Office Types.
                                    </div>
                                </div>
                            </div>

                            <!-- ADD -->
                            <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                                <AddButton type="button" 
                                    @click="newType_init()">
                                    + New Office Type
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
                                            @click="getOfficeTypes()"
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
                                <th scope="col" class="px-6 py-3" 
                                    v-show="state.columns.name.is_visible">
                                    <div class="flex items-center">
                                        Name
                                        <a href="#">
                                            <SorterIcon/>
                                        </a>
                                    </div>
                                </th>
                                
                                <th scope="col" class="px-6 py-3" 
                                    v-show="state.columns.label.is_visible">
                                    <div class="flex items-center">
                                        Label
                                        <a href="#">
                                            <SorterIcon/>
                                        </a>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3" 
                                    v-show="state.columns.tags.is_visible">
                                    <div class="flex items-center">
                                        Tags
                                        <a href="#">
                                            <SorterIcon/>
                                        </a>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(type, index) in state.types">
                                <td class="w-4 p-4">select</td>
                                <th scope="row" 
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    v-show="state.columns.name.is_visible">
                                    {{ type.name }}
                                </th>
                                <td class="px-6 py-4"
                                    v-show="state.columns.label.is_visible">
                                    {{ type.label }}
                                </td>
                                <td class="px-6 py-4"
                                    v-show="state.columns.tags.is_visible">
                                    aa
                                </td>
                                <td class="px-6 py-4">
                                    <EditButton @click="editType(type)">
                                        EDIT
                                    </EditButton>
                                    <DeleteButton @click="deleteType_init(type)">
                                        DELETE
                                    </DeleteButton>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div>
                        <v-pagination v-model="state.pagination.current_page"
                            :pages="state.pagination.number_of_pages"
                            :range-size="state.pagination.range"
                            active-color="#DCEDFF"
                            @update:model-value="getOfficeTypes"/>
                    </div>

                    <!-- Settings Modal -->
                    <DialogModal></DialogModal>

                    <!-- Type Modal -->
                    <DialogModal :show="state.showEditModal" id="modal_edit">
                        <template #title>
                            <span>{{ state.isEdit ? 'Edit' : 'Create' }} Office Type</span>
                        </template>

                        <template #content>
                            
                            <!-- NAME -->
                            <div class="mb-6">
                                <label for="name" 
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >Name</label>
                                <input type="text" id="name" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                    placeholder="" 
                                    v-model="state.type.name" required>
                            </div>

                            <!-- LABEL -->
                            <div class="mb-6">
                                <label for="name" 
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >Label</label>
                                <input type="text" id="label" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                    placeholder="" 
                                    v-model="state.type.label" required>
                            </div>
                        </template>

                        <template #footer>
                            <SecondaryButton @click="cancelEdit()">
                                Cancel
                            </SecondaryButton>
                            
                            <PrimaryButton type="button" class="ml-3" 
                                           @click="saveType">
                                {{ state.isEdit ? 'Edit' : 'Create' }}
                            </PrimaryButton>
                        </template>
                    </DialogModal>

                    <!-- Confirm Delete Modal --->
                    <DialogModal :show="state.showDeleteModal" 
                                 id="modal_confirm_delete">
                        <template #title>
                            Delete Office Type
                        </template>
                        <template #content>
                            Are you sure you want to delete this type?
                        </template>
                        <template #footer>
                            <PrimaryButton type="button" class="btn btn-danger" 
                                           @click="deleteType_init(type)">
                                Delete
                            </PrimaryButton>
                            <SecondaryButton type="button" class="self-start"
                                             @click="cancelDelete()">
                                Cancel
                            </SecondaryButton>
                        </template>
                    </DialogModal>
                </div>
            </div>
        </div>

    </AppLayout>
</template>