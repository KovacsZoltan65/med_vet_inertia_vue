<script>
    import InputError from '../../MyComponents/InputError.vue';
    import TextInput from '../../MyComponents/TextInput.vue';
    import InputLabel from '../../MyComponents/InputLabel.vue';

    export default (await import('vue')).defineComponent({
        name: 'AddressForm',
        props: ['form', 'companies', 'humans', 'addressTypes', 'isEdit'],
        components: {
            InputError,
            TextInput,
            InputLabel
        },
        mounted(){
            console.log('mounted');
        },
        created(){
            //console.log(this.form);
            //console.log(this.companies);
            //this.companies.forEach(company => {
            //    console.log(company.id, company.name);
            //});
            //console.log(this.humans);
            //console.log(this.addressTypes);
            console.log('created');
        },
    });
</script>

<template>
    <form>

        <!-- company_id -->
        <div class="mb-6">
            <InputLabel for="company_id" value="Company:" />
            <select id="company_id" name="company_id" v-model="form.company_id" 
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option v-if="!isEdit" value="0" :selected="true">Choose ...</option>
                <option v-for="company in companies" 
                    :key="company.id" 
                    :value="company.id" 
                    :selectedValue="form.company_id">{{ company.name }}</option>
            </select>
            <InputError :message="$page.props.errors.company_id" />
        </div>

        <!-- human_id -->
        <div class="mb-6">
            <InputLabel for="human_id" value="Human:" />
            <select id="human_id" name="human_id" v-model="form.human_id" 
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option v-if="!isEdit" value="0" :selected="true">Choose ...</option>
                <option v-for="human in humans" 
                    :key="human.id"
                    :value="human.id"
                    :selectedValue="form.human_id">{{ human.name }}</option>
            </select>
            <InputError :message="$page.props.errors.human_id" />
        </div>

        <!-- type_id -->
        <div class="mb-6">
            <InputLabel for="type_id" value="Type:" />
            <select id="type_id" name="type_id" v-model="form.type_id" 
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option v-if="!isEdit" value="0" :selected="true">Choose ...</option>
                <option v-for="type in addressTypes" 
                    :key="type.value" 
                    :value="type.value" 
                    :selectedValue="form.type_id">{{ type.label }}</option>
            </select>
            <InputError :message="$page.props.errors.type_id" />
        </div>

        <!-- city -->
        <div class="mb-6">
            <InputLabel for="city" value="City:" />
            <TextInput id="city" name="city" v-model="form.city" />
            <InputError :message="$page.props.errors.city" />
        </div>

        <!-- address -->
        <div class="mb-6">
            <InputLabel for="address" value="Address:" />
            <TextInput id="address" name="address" v-model="form.address" />
            <InputError :message="$page.props.errors.address" />
        </div>

    </form>
</template>