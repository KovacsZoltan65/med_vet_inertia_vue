<script>
    import InputLabel from '../../MyComponents/InputLabel.vue';
    import TextInput from '../../MyComponents/TextInput.vue';
    import InputError from '../../MyComponents/InputError.vue';

    import OfficeTypeSelect from '../../MyComponents/select/OfficeTypeSelect.vue';

    export default(await import('vue')).defineComponent({
        name: 'OfficeForm',
        props: ['form', 'isEdit'],
        components: {
            InputLabel,
            TextInput,
            InputError,
            OfficeTypeSelect
        },
        created(){},
    });
</script>

<template>
    <form>

        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            
            <!-- NAME -->
            <div class="mb-4">
                <InputLabel for="name" value="Name:" />
                <TextInput id="name" name="name" v-model="form.name"/>
                <InputError :message="$page.props.errors.name"/>
            </div>

            <!-- TYPE -->
            <div class="mb-4">
                <InputLabel for="type" value="Type:" />
                <OfficeTypeSelect :form="form" :isEdit="isEdit"/>
                <InputError :message="$page.props.errors.type_id"/>
            </div>

        </div>

    </form>
</template>