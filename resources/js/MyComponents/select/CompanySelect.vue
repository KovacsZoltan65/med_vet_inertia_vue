<script>
export default(await import('vue')).defineComponent({
    name: 'CompanySelect',
    props: ['form', 'isEdit'],
    data () {
        return {
            companies: []
        };
    },
    created () {
        this.getCompanies();
    },
    methods: {
        getCompanies () {
            axios.get('/get_companies')
            .then(response => {
                this.companies = response.data;
            })
            .catch( err => console.log(err) );
        }
    },
});
</script>

<template>
    <select id="" name="" v-model="form.company_id" 
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        <option v-if="!isEdit" value="0" :selected="true">Choose ...</option>
        <option v-for="option in companies" 
            :key="option.value"
            :value="option.value"
            :selectedValue="form.company_id">{{ option.label }}</option>
    </select>
</template>