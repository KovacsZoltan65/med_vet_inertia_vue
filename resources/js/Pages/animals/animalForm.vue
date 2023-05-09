<script>
    import InputLabel from '@/MyComponents/InputLabel.vue';
    import TextInput from '@/MyComponents/TextInput.vue';
    import InputError from '@/MyComponents/InputError.vue';

    export default(await import('vue')).defineComponent({
        name: 'AnimalForm',
        props: ['form', 'sex', 'group', 'isEdit'],
        components: {
            InputLabel, 
            TextInput, 
            InputError
        },
        created(){
            //console.log(this.sex);
            
            //this.sex.forEach(element => {
            //    console.log(element.value);
            //});

            //console.log(this.form);
            //console.log('form.sex: ' + this.form.sex);
        },
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

            <!-- SEX -->
            <div class="mb-4">
                <InputLabel for="sex" value="Sex:" />
                <select id="sex" v-model="form.sex" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option v-if="!isEdit" value="0" :selected="true">Choose ...</option>
                    <option v-for="option in sex" 
                        :key="option.value"
                        :value="option.value"
                        :selectedValue="form.sex"
                    >{{ option.label }}</option>
                </select>
                <InputError :message="$page.props.errors.sex"/>
            </div>

            <!-- GROUP -->
            <div class="mb-4">
                <InputLabel for="group" value="Group:" />
                <select id="group" v-model="form.group" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option v-if="!isEdit" value="0" :selected="true">Choose ...</option>
                    <option v-for="option in group" 
                        :key="option.value" 
                        :value="option.value" 
                        :selectedValue="form.group"
                    >{{ option.label }}</option>
                </select>
                <InputError :message="$page.props.errors.group"/>
            </div>

        </div>

    </form>
</template>