<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

import DialogModal from '../Components/DialogModal.vue';
import TextInput from '../Components/TextInput.vue';
import InputError from '../Components/InputError.vue';
import SecondaryButton from '../Components/SecondaryButton.vue';
import PrimaryButton from '../Components/PrimaryButton.vue';

const showDialogModal = ref(false);
const form = useForm({
    title: '',
});

// Modal ablak megjelenítése
const showModal = () => {
    showDialogModal.value = true;
};

// Modal ablak bezárása
const closeModal = () => {
    console.log('closeModal');
    showDialogModal.value = false;

    form.reset();
};

const saveBook = () => {
    console.log('saveBook');
}

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Modal Demo
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                    
                    <!-- New Book -->
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3"
                        @click="showModal"
                    >Show Modal</button>

                    <!-- Dialog Modal -->
                    <DialogModal :show="showDialogModal">
                        <template #title>
                            Új könyv
                        </template>

                        <template #content>
                            TARTALOM
                            <div class="mt-4">
                                <TextInput 
                                    ref="input"
                                    v-model="form.title"
                                    type="text"
                                    class="mt-1 block w-3/4"
                                    placeholder="Könyv"
                                />
                                <InputError
                                    :message="form.errors.title"
                                    class="mt-2"
                                />
                            </div>
                        </template>

                        <template #footer>

                            <SecondaryButton 
                                @click="closeModal"
                            >Cancel
                            </SecondaryButton>

                            <PrimaryButton
                                class="ml-3"
                                :class="{'opacity-25': form.processing}"
                                :disabled="form.processing"
                                @click="saveBook"
                            >Save</PrimaryButton>
                        </template>
                        
                    </DialogModal>
                </div>
            </div>
        </div>
    </AppLayout>
</template>