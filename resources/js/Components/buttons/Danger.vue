<template>
    <button :type="type">
        <slot />
    </button>
</template>

<script setup>
    defineProps({
        props: {
            type: {
                type: String,
                default: 'button'
            }
        }
    });
</script>