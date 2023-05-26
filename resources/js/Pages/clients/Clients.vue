<script setup>
import { reactive, onMounted } from 'vue';

import AppLayout from '../../Layouts/AppLayout.vue';
import Modal from '../../Shared/Modal.vue';

import AddButton from '../../Components/buttons/AddButton.vue';
import EditButton from '../../Components/buttons/EditButton.vue';
import DeleteButton from '../../Components/buttons/DeleteButton.vue';
import DialogModal from '../../Components/DialogModal.vue';
import SecondaryButton from '../../Components/buttons/SecondaryButton.vue';

const state = reactive({
    editing_client: null,
    deleting_client: null,

    client: newClient(),
    clients: [],

    modal_client_form: null,
    modal_client_delete_confirm: null,

    selected_tags: [],

    showModal: false,
    showDeleteModal: false,
});

const props = defineProps({
    clients: Array,
    tags: Array,
});

onMounted(() => {
    state.clients = props.clients;
});

function closeForm(){
    state.editing_client = null;
    state.client = newClient();
    state.deleting_client = null;
    state.showModal = false;
}

function closeDeleteForm(){
    state.showDeleteModal = false;
}

function newClient_init() {
    state.client = newClient();
    state.editing_client = null;
    //state.modal_client_form.show()
    state.showModal = true;
}

function newClient() {
    return {
        id: null,
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
    
    console.log(state.editing_client);
    console.log(state.client);

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

            state.modal_client_delete_confirm.hide()

        })
        .catch(err => {
            debugger
        })
}

function cancelEdit() {
    state.editing_client = null
    state.client = newClient()
    state.selected_tags = []
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
                const k = res.data.client

                for (let i = 0; i < state.clients.length; i++) {
                    if (state.clients[i].id === k.id) {
                        state.clients[i] = k
                    }
                }

                state.modal_client_form.hide()

            })
            .catch(err => {
                debugger
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
    <AppLayout title="clients">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Clients
            </h2>
        </template>

        <div class="py-12">
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

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">

                        <div class="grid grid-cols-2 gap-2 mb-4">

                            <!-- FILTER -->
                            <div class="flex items-center justify-right rounded bg-gray-50 h-28 dark:bg-gray-800">
                                
                                <label for="countries_multiple" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an option</label>
                                <select multiple id="countries_multiple" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected>Choose countries</option>
                                    <option value="US">United States</option>
                                    <option value="CA">Canada</option>
                                    <option value="FR">France</option>
                                    <option value="DE">Germany</option>
                                </select>

                            </div>

                            <!-- SEARCH -->
                            <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                                
                                <label for="table-search" class="sr-only">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                    </div>
                                    <input type="text" id="table-search" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for items">
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                    <!-- TABLE -->
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th>SELECT ALL</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="_client in state.clients">
                                <td class="w-4 p-4">select</td>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ _client.name_first }} {{ _client.name_last }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ _client.description }}
                                </td>
                                <td class="px-6 py-4">
                                    <!-- EDIT button -->
                                    <EditButton 
                                        @click="editClient(_client)">
                                        Edit
                                    </EditButton>

                                    <!-- DELETE button -->
                                    <DeleteButton 
                                        @click="deleteClient_init(_client)">
                                        Delete
                                    </DeleteButton>

                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <!-- New Client Modal -->
        <DialogModal :show="state.showModal" id="modal_client_form">
            <template #title>
                Client
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
                            placeholder="example@email.com" 
                            v-model="state.client.email" 
                            required>
                    </div>
                    
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
                    @click="closeForm()">
                    Cancel
                </SecondaryButton>
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