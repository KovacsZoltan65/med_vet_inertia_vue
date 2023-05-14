<script>
import InputLabel from '../../MyComponents/InputLabel.vue';
import TextInput from '../../MyComponents/TextInput.vue';
import InputError from '../../MyComponents/InputError.vue';

export default(await import('vue')).defineComponent({
    name: 'PatientForm',
    props: ['form', 'doctors', 'patients', 'offices', 'isEdit'],
    components: {
        InputLabel,
        TextInput,
        InputError
    },
    created(){
        //console.log(this.$page.props);
        console.log(this.form);
    },
});
</script>

<template>
    <form>
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">

            <!-- DOCTOR -->
            <div class="mb-4">
                <InputLabel for="doctor_id" value="Doctor:" />
                
                <select id="group" v-model="form.doctor_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option v-if="!isEdit" value="0" :selected="true">Choose ...</option>
                    <option v-for="doctor in doctors" 
                        :key="doctor.id"
                        :value="doctor.id"
                        :selectedValue="form.doctor_id"
                    >{{ doctor.name }}</option>
                </select>
                <InputError :message="$page.props.errors.doctor_id" />
            </div>

            <!-- ANIMALS -->
            <div class="mb-4">
                <InputLabel for="animal_id" value="Animal:" />
                
                <select id="group" v-model="form.animal_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option v-if="!isEdit" value="0" :selected="true">Choose ...</option>
                    <option v-for="animal in $page.props.animals" 
                        :key="animal.id"
                        :value="animal.id"
                        :selectedValue="animal.id == form.animal_id"
                    >{{ animal.name }}</option>
                </select>
                <InputError :message="$page.props.errors.animal_id" />
            </div>

            <!-- OFFICE -->
            <div class="mb-4">
                <InputLabel for="office_id" value="Office:" />
                
                <select id="group" v-model="form.office_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option v-if="!isEdit" value="0" :selected="true">Choose...</option>
                    <option v-for="office in $page.props.offices" 
                        :key="office.id"
                        :value="office.id"
                        :selectedValue="office.id == form.office_id"
                    >{{ office.name }}</option>
                </select>
                <InputError :message="$page.props.errors.office_id" />
            </div>

        </div>
    </form>
</template>