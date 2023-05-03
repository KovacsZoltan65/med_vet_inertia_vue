<template>
    <form>

        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">

            <!-- NAME -->
            <div class="mb-4">
                <InputLabel for="name" value="Name:" />
                <TextInput id="name" name="name" v-model="form.name" />
                <InputError :message="$page.props.errors.name" />
            </div>

            <!-- TYPE -->
            <div class="mb-4">
                <InputLabel for="type" value="Type:" />

                <select id="countries" v-model="form.post_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option v-if="!isEdit" value="0" :selected="true">Choose ...</option>
                    <option v-for="option in posts" :key="option.id" :value="option.id" :selectedValue="form.id">{{
                        option.name }}</option>
                </select>
                <InputError :message="$page.props.errors.post_id" />
            </div>

            <!-- IMAGE -->
            <div class="mb-4">
                <label for="formBookImage" class="block text-gray-700 text-sm font-bold mb-2">Image:</label>
                <file-pond
                    name="imageFilepond" ref="pond"
                    v-bind:allow-multiple="false"
                    accepted-file-types="image/png, image/jpeg"
                    v-bind:server="{
                        url: '',
                        timeout: 7000,
                        process: {
                            url: '/upload-humans',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $page.props.csrf_token
                            },
                            withCredentials: false,
                            onload: handleFilePondLoad,
                            onerror: () => {},
                        },
                        remove: handleFilePondRemove,
                        revert: handleFilePondRevert
                    }"
                    v-bind:files="myFiles"
                    v-on:init="handleFilePondInit"
                ></file-pond>
            </div>

        </div>

    </form>
</template>

<script>
    import axios from 'axios';

    import vueFilePond from 'vue-filepond';
    import 'filepond/dist/filepond.min.css';
    // Import image preview plugin styles
    import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

    // Import the plugin code
    import FilePondPluginFilePoster from 'filepond-plugin-file-poster';

    // Import the plugin styles
    import 'filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css';

    // Import image preview and file type validation plugins
    import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
    import FilePondPluginImagePreview from "filepond-plugin-image-preview";

    import InputLabel from '@/MyComponents/InputLabel.vue';
    import TextInput from '@/MyComponents/TextInput.vue';
    import InputError from '@/MyComponents/InputError.vue';

    const FilePond = vueFilePond(
        FilePondPluginFileValidateType,
        FilePondPluginImagePreview,
        FilePondPluginFilePoster
    );

    export default (await import('vue')).defineComponent({
        name: 'HumanForm',
        props: ['form', 'posts', 'isEdit'],
        components: {
            InputLabel,
            TextInput,
            InputError,
            FilePond
        },
        data(){
            return {
                myFiles: []
            }
        },
        methods: {
            handleFilePondInit() {
                if (this.form.image) {
                    this.myFiles = [{
                        source: '/' + this.form.image,
                        options: {
                            type: 'local',
                            metadata: {
                                poster: '/' + this.form.image
                            }
                        }
                    }];
                } else {
                    this.myFiles = [];
                }
            },
            handleFilePondLoad(response) {
                this.form.image = response;
            },
            handleFilePondRemove(source, load, error) {
                this.form.image = '';
                load();
            },
            handleFilePondRevert(uniqueId, load, error) {
                axios.post('/upload-humans-revert', {
                    image: this.form.image
                });
                load();
            }
        },
    });
</script>