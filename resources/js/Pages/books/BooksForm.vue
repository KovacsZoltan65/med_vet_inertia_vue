<template>
    
    <form>

        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">

            <!-- TITLE -->
            <div class="mb-4">
                <label for="formBookTitle" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                <input type="text" v-model="form.title"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="formBookTitle" placeholder="Enter Title">
                <div v-if="$page.props.errors.title" class="text-red-500">{{ $page.props.errors.title }}</div>
            </div>

            <!-- AUTHOR -->
            <div class="mb-4">
                <label for="formBookAuthor" class="block text-gray-700 text-sm font-bold mb-2">Author:</label>
                <input type="text" v-model="form.author"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="formBookAuthor" placeholder="Enter Author">
                <div v-if="$page.props.errors.author" class="text-red-500">{{ $page.props.errors.author }}</div>
            </div>

            <!-- IMAGE -->
            <div class="mb-4">
                <label for="formBookImage" class="block text-gray-700 text-sm font-bold mb-2"
                >Image:</label>
                <input type="text" v-model="form.image"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="formBookImage" placeholder="Enter Image">
                <div v-if="$page.props.errors.image" class="text-red-500">{{ $page.props.errors.image }}</div>
            </div>

        </div>

    </form>

</template>

<script>
export default {
    name: 'BooksForm',
    props: ['form'],
}
</script>