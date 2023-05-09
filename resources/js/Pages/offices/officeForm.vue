<script>
    import InputLabel from '@/MyComponents/InputLabel.vue';
    import TextInput from '@/MyComponents/TextInput.vue';
    import InputError from '@/MyComponents/InputError.vue';

    export default(await import('vue')).defineComponent({
        name: 'OfficeForm',
        props: ['form', 'officeTypes', 'isEdit'],
        components: {
            InputLabel, 
            TextInput, 
            InputError
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

                <select id="countries" v-model="form.type_id" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option v-if="!isEdit" value="0" :selected="true">Choose ...</option>
                    <option v-for="option in officeTypes" 
                        :key="option.value" 
                        :value="option.value"
                        :selectedValue="form.id"
                    >{{ option.label }}</option>
                </select>

                <InputError :message="$page.props.errors.type_id"/>
            </div>

        </div>

    </form>
</template>