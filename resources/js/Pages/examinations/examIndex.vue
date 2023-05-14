<script>
import axios from 'axios';
import AppLayout from '../../Layouts/AppLayout.vue';
import Success from '../../Components/alerts/Success.vue';
import AddButton from '../../Components/buttons/AddButton.vue';
import { PlusIcon } from '@heroicons/vue/24/solid';
import Table from '../../MyComponents/Table.vue';

export default (await import('vue')).defineComponent({
    name: 'Examinations',
    components: {
    AppLayout,
    Success,
    AddButton,
    PlusIcon,
    Table
},
    data(){
        return {

            selected: [],
            selectAll: false,

            latest_id: 5,
            
        };
    },
    setup(){
        //An array of values for the data
        const studentData = [
            {ID:"01", Name: "Abiola Esther", Course:"Computer Science", Gender:"Female", Age:"17"},
            {ID:"02", Name: "Robert V. Kratz", Course:"Philosophy", Gender:"Male", Age:'19'},
            {ID:"03", Name: "Kristen Anderson", Course:"Economics", Gender:"Female", Age:'20'},
            {ID:"04", Name: "Adam Simon", Course:"Food science", Gender:"Male", Age:'21'},
            {ID:"05", Name: "Daisy Katherine", Course:"Business studies", Gender:"Female", Age:'22'},  
        ]
        const fields = [
            'ID','Name','Course','Gender','Age'
        ]
        return{studentData,fields}
    },
    mounted() {
        
    },

    created() {
        //this.getExaminations();
    },
    methods: {
        
        getExaminations(){
            
            axios.get('/getExaminations')
                .then(res => {
                    console.log(res.data);

                })
                .catch(err => { console.log(err); });
        },



    },
});
</script>

<template>
    <AppLayout title="Exam">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Examinations
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                    <!-- Üzenetek -->
                    <Success :message="$page.props.flash.message" v-if="$page.props.flash.message" />

                    <!-- NEW button -->
                    <AddButton type="button" @click="openForm()">
                        <PlusIcon class="h-5 w-5" />
                    </AddButton>

                    <!-- Book list -->
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <div class="text-uppercase text-bold">id selected: {{ selected }}</div>

                        <Table :fields="fields" :studentData="studentData"></Table>

                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>