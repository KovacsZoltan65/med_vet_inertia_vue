<script setup>
    import { reactive, onMounted, watch, computed } from 'vue';
    import axios from 'axios';
    import VPagination from '@hennge/vue3-pagination';
    import '@hennge/vue3-pagination/dist/vue3-pagination.css';

    import Modal from '../../Shared/Modal.vue';

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
        axios.delete(route('offices_delete', { office: state.deleteing_office.id }))
        .then(res => {
            state.offices = state.offices.filter(o => o.id !== state.deleteing_office.id);
            state.deleteing_office = null;
            closeDelete();
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
        .error( err => { console.log(err); } );
    }

    function openSettings(){ state.modal_settings = true; }
    function closeSettings(){ state.modal_settings = false; }

    function openEdit(){ state.modal_edit = true; }
    function closeEdit(){ state.modal_edit = false; }

    function openDelete(){ state.modal_delete = true; }
    function closeDelete(){ state.modal_delete = false; }

</script>

<template></template>