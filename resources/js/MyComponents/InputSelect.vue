<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    data: [],
    isEdit: false,
});

onMounted(() => {
    console.log(this.data);
});

</script>

<template>
    <select id="countries" 
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        <option v-if="isEdit" value="0" :selected="true">Choose ...</option>
        <option v-for="d in this.data">{{ d.name }}</option>
    </select>
</template>