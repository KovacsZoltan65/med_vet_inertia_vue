<template>
    <form>

        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            
            <!-- NAME -->
            <div class="mb-4">
                <label for="formName" 
                    class="block text-gray-700 text-sm font-bold mb-2"
                >Name:</label>

                <input type="text" v-model="form.name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                    id="formName" placeholder="Enter Name" required>

                <div v-if="$page.props.errors.name" class="text-red-500"
                >{{ $page.props.errors.name }}</div>
            </div>

        </div>

    </form>
</template>

<script>

export default(await import('vue')).defineComponent({
    name: 'OfficeTypeForm',
    props: ['form'],
    components: {}
});
</script>