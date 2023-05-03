<template>
    <button :type="type"
        class="text-white 
            bg-red-700 
            hover:bg-red-800 
            focus:ring-4 
            focus:outline-none 
            focus:ring-red-300 
            font-medium rounded-lg 
            text-sm p-2.5 
            text-center 
            inline-flex 
            items-center mr-2 
            dark:bg-red-600 
            dark:hover:bg-red-700 
            dark:focus:ring-red-800">
        <slot />
    </button>
</template>

<script setup>
    defineProps({
        type: {
            type: String,
            default: 'submit'
        }
    });
</script>