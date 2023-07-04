<script setup>
    import { reactive, onMounted, watch, computed } from 'vue';
    import axios from 'axios';
    import VPagination from '@hennge/vue3-pagination';
    import '@hennge/vue3-pagination/dist/vue3-pagination.css';
    import AppLayout from '../../Layouts/AppLayout.vue';

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

        axios.post(route('/office_types/grid-data'), {
            filters: state.filters,
            config: {
                per_page: state.pagination.per_page,
            }, page,
        })
        .then(res => {
            //

        })
        .catch(err => { console.log(err); });
    };
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
    };
    function editType(type){
        state.editing_type = JSON.parse(JSON.stringify(type));
        state.type = state.editing_type;
        state.selected_tags = state.type.tags.map(t => t.id);
        state.isEdit = true;

        state.showEditModal = true;
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
    function openEditModal() { state.isEdit = true; };
    function closeEditModal() { state.isEdit = false; };
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
    </AppLayout>
</template>