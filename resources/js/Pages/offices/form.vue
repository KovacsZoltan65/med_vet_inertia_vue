<template>
    <form>

        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            
            <!-- NAME -->
            <div class="mb-4">
                <label for="formName" 
                    class="block text-gray-700 text-sm font-bold mb-2"
                >Name:</label>

                <input type="text" v-model="form.name"
                    id="formName" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                    placeholder="Name" 
                    required>

                <div v-if="$page.props.errors.name" 
                    class="text-red-500"
                >{{ $page.props.errors.name }}</div>
            </div>

            <!-- TYPE -->
            <div class="mb-4">
                <label for="countries" 
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Type:</label>
                <select id="countries" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>Choose a country</option>
                    <option value="US">United States</option>
                    <option value="CA">Canada</option>
                    <option value="FR">France</option>
                    <option value="DE">Germany</option>
                </select>
                <div v-if="$page.props.errors.type_id" 
                    class="text-red-500"
                >{{ $page.props.errors.type_id }}</div>
            </div>

        </div>

    </form>
</template>

<script>
import TextInput from '../../Components/TextInput.vue';

export default(await import('vue')).defineComponent({
    name: 'OfficeForm',
    props: ['form'],
    components: {
        TextInput
    }
});
</script>