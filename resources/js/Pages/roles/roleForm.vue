<script>
    import InputError from '@/MyComponents/InputError.vue';
    import TextInput from '@/MyComponents/TextInput.vue';
    import InputLabel from '@/MyComponents/InputLabel.vue';

    export default(await import('vue')).defineComponent({
        name: 'RoleForm',
        props: ['form'],
        components: {
            InputError,
            TextInput,
            InputLabel,
        }
    });
</script>

<template>
    <form>
        <!-- TITLE -->
        <div class="mb-6">
            <InputLabel for="title" value="Title:" />
            <TextInput id="title" name="title" v-model="form.title" />
            <InputError :message="$page.props.errors.title" />
        </div>

    </form>
</template>