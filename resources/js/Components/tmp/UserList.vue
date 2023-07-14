<script setup>
    import axios from 'axios';
    import { onMounted, onBeforeMount, reactive } from 'vue';

    const state = reactive({
        users: [],
    });

    //onMounted(async () => getUsers());
    onBeforeMount(async () => {
        await getUsers();
    });

    async function getUsers() {

        //const response = await axios.get('https://jsonplaceholder.typicode.com/users');
        //state.users = response.data;
        
        const response = await axios.post('async_get_data');
        //console.log(response.data.users);
        if( response.data.success ){
            state.users = response.data.users;
        }
    }
</script>

<template>

    <ul v-for="user in state.users">
        <li>{{ user.name }}</li>
    </ul>
    
</template>