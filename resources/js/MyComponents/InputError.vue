<script setup>
defineProps({
    message: {
        type: String,
        default: null
    }
});
</script>

<template>
    <div v-if="message" 
        class="text-red-500"
    >{{ message }}</div>
</template>