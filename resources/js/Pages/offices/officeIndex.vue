<script setup>
    import { reactive, onMounted, watch, computed } from 'vue';
    import axios from 'axios';

    import AppLayout from '../../Layouts/AppLayout.vue';
    import DialogModal from '../../Components/DialogModal.vue';

    import VPagination from '@hennge/vue3-pagination';
    import '@hennge/vue3-pagination/dist/vue3-pagination.css';

    import SecondaryButton from '../../Components/buttons/SecondaryButton.vue';
import PrimaryButton from '../../Components/buttons/PrimaryButton.vue';

    const local_storage_column_key = 'ln_office_grid_columns';

    const props = defineProps({
        tags: Array
    });
    const defaultFormObject = { name: null };

    const state = reactive({
        editing_office: null,
        deleting_office: null,

        office: newOffice(),
        offices: [],

        tags: [],
        tag_filter_terms: '',
        filtered_tag_chips: [],

        showEditModal: false,
        showDeleteModal: false,
        showSettingsModal: false,

        isEdit: false,
        forMobject: defaultFormObject,

        selected_tags: [],
        filters: {
            tags: [],
            search: null
        },

        columns: {
            name: {
                label: 'Name',
                is_visible: true,
            }
        },

        pagination: {
            current_page: 1,
            total_number_of_pages: 0,
            per_page: 10,
            range: 5,
        },
    });

    const tag_filter_options = computed(() => {
        if( !state.tag_filter_terms ){
            return props.tags;
        }
        const search = state.tag_filter_terms.toLowerCase();

        return props.tags.filter(t => t.name.toLowerCase().indexOf(search) > -1);
    });

    watch(state.columns, (new_value, old_value) => {
        localStorage.setItem(local_storage_column_key, JSON.stringify(new_value));
    });

    onMounted(async () => {
        getClients();

        let columns = local_storage_column_key.getItem(ln_office_grid_columns);
        if( columns ){
            columns = JSON.parse(columns);
            for( const column_name in columns ){
                state.columns[column_name] = columns[column_name];
            }
        }
    });

    function updateFilteredTagChips(tag){
        let found = false;

        for( let i = 0; i < state.filtered_tag_chips.length; i++ ){
            if( state.filtered_tag_chips[i].name === tag.id ){
                found = true;
            }
        }

        if( found ) return;

        state.filtered_tag_chips.push( JSON.parse(JSON.stringify(tag)) );

        getOffices();
    }

    function removeChip(chip){
        state.filters.tags = state.filtered_tag_chips.map(tag => tag.id);

        getOffices();
    }

    function getOffices(page = state.pagination.current_page){
        state.filters.tags = state.filtered_tag_chips.map(tag => tag.id);

        axios.post('/offices/grid-data', {
            filters: state.filters,
            config: {
                per_page: state.pagination.per_page,
            },
            page,
        })
        .then(res => {
            state.pagination.total_number_of_pages = res.data.offices.last_pages;
            state.pagination.current_page = res.data.offices.current_page;
            state.offices = res.data.offices.data;
        })
        .catch(err => { console.log(); });
    }

    // ==============
    // NEW OFFICE
    // ==============
    function newOffice_init(){
        state.office = newOffice();
        state.editing_office = null;
        state.isEdit = false;
    }

    function newOffice(){
        return {
            name: null,
        };
    }
    // ==============

    // ==============
    // EDIT OFFICE
    // ==============
    function editOffice(_office){
        state.editing_office = JSON.parse(JSON.stringify(_office));
        state.office = state.editing_office;
        state.selected_tags = state.office.tags.map(t => t.id);
        state.isEdit = true;

        openEditModal();
    }
    // ==============

    // ==============
    // DELETE OFFICE
    // ==============
    function deleteOffice_init(_office){
        state.editing_office = JSON.parse(JSON.stringify(_office));
        state.office = state.editing_office;
        state.selected_tags = state.office.tags.map(t => t.id);
        state.isEdit = true;
    }
    function deleteOffice(){
        axios.delete(route('office_delete', {office: state.deleting_office.id}))
        .then(res => {
            state.offices = state.offices.filter(k => k.id != state.deleting_office.id);
            state.deleting_office = null;
            closeDeleteModal();
        })
        .catch(err => { console.log(err); });
    }
    // ==============

    function saveOffice(){
        if( state.editing_office && state.editing_office.id ){
            axios.put(route('office_update'), {client:state.editing_office.id}, 
            {
                name: state.office.name,
                tags: state.selected_tags,
            })
            .then(res => {
                closeEditModal();
                const k = res.data.office;

                for(  let i = 0; i < state.offices.length; i++ ){
                    if( state.offices[i].id === k.id ){
                        state.offices[i].id = k;
                    }
                }
            })
            .catch(err => { console.log(err); });

            cancelEdit();
            return;
        }

        axios.post(route('office_store'), {
            name: state.office.name,
            tags: state.selected_tags,
        })
        .then(res => {
            state.office = newOffice();
            state.offices.push(res.data.office);
            closeEditModal();
        })
        .error(err => { console.log(err); });
    }

    function cancelEdit(){
        state.editing_office = null;
        state.office = newOffice();
        state.selected_tags = [];
    }

    // ==============
    // EDIT MODAL
    // ==============
    function openEditModal(){ state.showEditModal = true; }
    function closeEditModal(){ state.showEditModal = false; }

    // ==============

    // ==============
    // DELETE MODAL
    // ==============
    function openDeleteModal(){ state.showDeleteModal = true; }
    function closeDeleteModal(){ state.showDeleteModal = false; }

    // ==============

    // ==============
    // SETTINGS MODAL
    // ==============
    function openSettingsModal(){ state.showSettingsModal = true; }
    function closeSettingsModal(){ state.showSettingsModal = false; }
    // ==============

    
</script>

<template>
    <AppLayout title="OfficeGrid">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Office Grid</h2>
        </template>

        <div class="py-2"></div>

        <div class="py-2"></div>

        <div class="py-2"></div>

        <!-- settings modal -->
        <DialogModal :show="state.showSettingsModal" id="modal_settings">
            <template #title>SETTINGS</template>
            <template #content>
                <fieldset>
                    <legend class="sr-only">Checkbox variant</legend>

                    <div class="flex items-center mb-4" 
                        v-for="(config, column) in state.columns" :key="column">
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
                <SecondaryButton @click="closeSettingsModal()">CLOSE</SecondaryButton>
            </template>
        </DialogModal>

        <!-- edit modal -->
        <DialogModal :show="state.showEditModal" id="modal_edit">
            <template #title>
                <span v-if="state.editing_office && state.editing_office.id">Edit Office</span>
                <span v-else>Create Office</span>
                {{ state.isEdit? 'EDIT' : 'CREATE' }} OFFICE
            </template>
            
            <template #content>
                <div class="mb-6">
                    <label for="name_first" 
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Name</label>
                    <input type="text" id="name_first" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                        placeholder="John" 
                        v-model="state.office.name"
                        required>
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
                                 @click="closeEditModal()">Cancel</SecondaryButton>
                <PrimaryButton type="button" class="ml-3" 
                               @click="saveOffice()">
                    {{ state.isEdit ? 'SAVE' : 'CREATE' }} OFFICE
                </PrimaryButton>
            </template>
        </DialogModal>

        <!-- delete modal -->
        <DialogModal :show="state.showDeleteModal" id="modal_delete">
            <template #title>DELETE CLIENT</template>
            <template #content>Are you sure you want to delete this Client?</template>
            <template #footer>
                <SecondaryButton @click="closeDeleteModal()">Cancel</SecondaryButton>
            </template>
        </DialogModal>

    </AppLayout>
</template>