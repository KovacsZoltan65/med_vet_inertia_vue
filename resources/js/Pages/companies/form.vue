<template>
    
    <form>

        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">

            <div class="mb-4">
                <label for="formBookTitle" 
                    class="block text-gray-700 text-sm font-bold mb-2"
                >Name:</label>
                <input type="text" v-model="form.name"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="formBookTitle" placeholder="Enter Title">
                <div v-if="$page.props.errors.name" 
                    class="text-red-500"
                >{{ $page.props.errors.name }}</div>
            </div>

        </div>

    </form>

</template>

<script>
export default {
    name: 'CompanyForm',
    props: ['form'],
}
</script>