<script>
    export default{
        name: 'OfficeTypeSelect',
        props: ['form', 'isEdit'],
        data(){
            return {
                officeTypes: []
            }
        },
        created(){
            this.getOfficeTypes();
        },
        methods:{
            getOfficeTypes(){
                axios.get('/get_office_types')
                    .then( res => {
                        this.officeTypes = res.data;
                    } )
                    .catch( err => console.log(err) );
            }
        }
    };
</script>

<template>
    <select id="type_id" name="type_id" v-model="form.type_id" 
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        <option v-if="!isEdit" value="0" :selected="true">Choose ...</option>
        <option v-for="option in officeTypes" 
            :key="option.value"
            :value="option.value"
            :selectedValue="form.type_id">{{ option.label }}</option>
    </select>
</template>