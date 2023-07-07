<script setup>
    import { onMounted } from 'vue';
    import axios from 'axios';

    import AppLayout from '../../Layouts/AppLayout.vue';

    onMounted(() => {
        console.log('mounted');
        data = getData();
        console.log('data', data);
    });

    async function getData() {
        console.log('get data');
        const response = axios.post(route('async_get_data'));
        console.log('response.data', response.data);
        return response.data;
    }
</script>

<template>
    <AppLayout title="asyncGrid">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ASYNC
            </h2>
        </template>


    </AppLayout>
</template>