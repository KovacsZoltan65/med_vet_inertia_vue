<template>
    <form>

        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">

            <div class="mb-4">
                <!--<label for="formCompanyName" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>-->
                <!--<input type="text" v-model="form.name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formCompanyName" placeholder="Enter Name" required>-->
                <!--<div v-if="$page.props.errors.name" class="text-red-500">{{ $page.props.errors.name }}</div>-->
                <InputLabel for="name" value="Name:" />
                <TextInput id="name" name="name" v-model="form.name"/>
                <InputError :message="$page.props.errors.name"/>
            </div>

        </div>

    </form>

</template>

<script>
import InputError from '../../MyComponents/InputError.vue';
import TextInput from '../../MyComponents/TextInput.vue';
import InputLabel from '../../MyComponents/InputLabel.vue';

export default(await import('vue')).defineComponent({
    name: "CompanyForm",
    props: ["form"],
    components: {
        InputError, 
        TextInput,
        InputLabel
    }
});
</script>