<template>
    <form>

        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            
            <!-- NAME -->
            <div class="mb-4">
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