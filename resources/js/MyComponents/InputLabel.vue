<script setup>
defineProps({
    value: String,
});
</script>

<template>

    <label for="first_name" 
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
    >
        <span v-if="value">
            {{ value }}
        </span>
        <span v-else>
            <slot/>
        </span>
    </label>

    <!--<label class="block font-medium text-sm text-gray-700">
        <span v-if="value">
            {{ value }}
        </span>
        <span v-else>
            <slot />
        </span>
    </label>-->
</template>
