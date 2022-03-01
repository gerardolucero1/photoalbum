<style scoped lang="scss">
    .photo-container{
        width: 230px;

        img{
            width: 100%;
        }
    }

    .uploading{
        width: 200px; 
        height: 200px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    @keyframes p-progress-spinner-color {
        100%,
        0% {
            stroke: #d62d20;
        }
        40% {
            stroke: #0057e7;
        }
        66% {
            stroke: #008744;
        }
        80%,
        90% {
            stroke: #ffa700;
        }
    }

    .ti-input{
        border-color: rgb(209, 213, 219) !important;
        border-radius: 0.375rem !important;   
    }
</style>

<template>
    <app-layout :title="photo.name">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar la fotografia {{ photo.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-start bg-white overflow-hidden shadow-xl sm:rounded-lg p-2 flex">
                    <Link v-if="photo.album" :href="route('albums.show', photo.album.id)" class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-arrow-left mr-1"></i> Regresar
                    </Link>
                    <button v-else @click="goBack" class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-arrow-left mr-1"></i> Regresar
                    </button>
                </div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-2">
                <div>
                    <div class="hidden sm:block" aria-hidden="true">
                        <div class="py-5">
                        <div class="border-t border-gray-200" />
                        </div>
                    </div>

                    <div class="">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <div class="px-4 sm:px-0">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Informacion de la foto</h3>
                                    <p class="mt-1 text-sm text-gray-600">
                                        Edita la informacion de origen de esta foto
                                    </p>
                                </div>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <div class="shadow overflow-hidden sm:rounded-md">
                                    <div class="px-4 py-5 bg-white sm:p-6">
                                        <div class="grid grid-cols-6 gap-6">
                                            <div class="col-span-6 sm:col-span-6">
                                                <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                                                <input type="text" v-model="photo.name" name="name" id="name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                                <div v-if="v$.photo.name.$error">
                                                    <span class="text-red-500 text-xs" v-for="error in v$.photo.name.$silentErrors" :key="error">{{ error.$message }}</span>
                                                </div>
                                            </div>
                                            <div class="col-span-6 sm:col-span-6">
                                                <label for="description" class="block text-sm font-medium text-gray-700">Descripcion</label>
                                                <textarea rows="5" v-model="photo.description" name="description" id="description" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </textarea>
                                            </div>
                                            <div class="col-span-6 sm:col-span-6">
                                                <label for="single_sale" class="block text-sm font-medium text-gray-700">Album</label>
                                                <Dropdown class="w-full" v-model="album_selected" :options="albums" optionLabel="name" :filter="true" placeholder="Selecciona un album" :showClear="true">
                                                    <template #value="slotProps">
                                                        <div class="country-item country-item-value" v-if="slotProps.value">
                                                            <div class="flex items-center">
                                                                <div class="flex-shrink-0 h-6 w-6">
                                                                    <img class="h-6 w-6 rounded-full object-cover object-center" :src="slotProps.value.photo_url" alt="" />
                                                                </div>
                                                                <div class="ml-4">
                                                                    <div class="text-sm font-medium text-gray-900">
                                                                        {{ slotProps.value.name }}
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <span v-else>
                                                            {{slotProps.placeholder}}
                                                        </span>
                                                    </template>
                                                    <template #option="slotProps">
                                                        <div class="country-item">
                                                            <div class="flex items-center">
                                                                <div class="flex-shrink-0 h-6 w-6">
                                                                    <img class="h-6 w-6 rounded-full object-cover object-center" :src="slotProps.option.photo_url" alt="" />
                                                                </div>
                                                                <div class="ml-4">
                                                                    <div class="text-sm font-medium text-gray-900">
                                                                        {{ slotProps.option.name }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </Dropdown>
                                            </div>
                                            <div class="col-span-6 sm:col-span-6">
                                                <label for="private" class="block text-sm font-medium text-gray-700">Privado</label>
                                                <InputSwitch id="private" v-model="photo.private" />
                                            </div>
                                            <div class="col-span-6 sm:col-span-6">
                                                <label for="private" class="block text-sm font-medium text-gray-700">Poner como descargar libre</label>
                                                <InputSwitch id="private" v-model="photo.free" />
                                                <p class="text-sm text-gray-500">Si marcas esta opcion la foto estara disponible para que cualquiera pueda descargar la imagen en su maxima resolucion.</p>
                                            </div>
                                            <div class="col-span-6 sm:col-span-6" v-if="!photo.free">
                                                <label for="single_sale" class="block text-sm font-medium text-gray-700">Venta individual</label>
                                                <InputSwitch id="single_sale" v-model="photo.single_sale" />
                                            </div>

                                            <div v-if="photo.single_sale" class="col-span-6 sm:col-span-6">
                                                <label for="price" class="block text-sm font-medium text-gray-700">Precio</label>
                                                <input type="number" v-model="photo.price" name="price" id="price" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                            </div>
                                            <div class="col-span-6 sm:col-span-6">
                                                <label for="tags" class="block text-sm font-medium text-gray-700">Etiquetas</label>
                                                <vue-tags-input
                                                    class="mt-1 w-full"
                                                    placeholder=""
                                                    v-model="tag"
                                                    :tags="tags"
                                                    @tags-changed="newTags => tags = newTags"
                                                    />
                                            </div>
                                             <div class="col-span-6 sm:col-span-6">
                                                <FileUpload ref="uploader" accept="image/*" chooseLabel="Seleccionar" :multiple="false" :auto="false" :fileLimit="1" :showUploadButton="false" :showCancelButton="false" name="files[]" :withCredentials="true" :customUpload="true" @uploader="sendForm" @progress="uploadingFiles">
                                                    <template #empty>
                                                        <p>Drag and drop files to here to upload.</p>
                                                    </template>
                                                </FileUpload>
                                            </div>
                                            <div class="col-span-6 sm:col-span-6">
                                                <div class="flex justify-center items-center">
                                                    <div class="photo-container">
                                                        <Image class="img-tile" :src="photo.url_preview" srcset="" :alt="photo.description" preview />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                        <button @click="uploadAlbum" type="button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Guardar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Toast />
        <Dialog :draggable="false" :dismissableMask="true" :showHeader="false" v-model:visible="uploading" :closable="false" :modal="true">
            <div class="uploading">
                <ProgressSpinner />
                <p>Espera un momento...</p>
            </div>
        </Dialog>

    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/inertia-vue3';
import VueTagsInput from '@sipec/vue3-tags-input';
import useVuelidate from '@vuelidate/core'
import { required } from '@vuelidate/validators'

export default defineComponent({
    props: [
        'photo',
        'albums',
    ],

    setup () {
        return { v$: useVuelidate() }
    },

    components: {
        AppLayout,
        Link,
        VueTagsInput
    },

    validations () {
        return {
            photo: {
                name: {
                    required
                },
            }
        }
    },

    watch: {
        'photo.free'() {
            if (this.photo.free) {
                this.photo.single_sale = false
            }
        }
    },

    created(){
        this.photo.private == 1 ? this.photo.private = true :  this.photo.private = false
        this.photo.single_sale == 1 ? this.photo.single_sale = true :  this.photo.single_sale = false
        this.album_selected = this.albums.find(doc => doc.id == this.photo.album_id)

        this.tags = this.photo.tags.map(doc => {
            let tag = {
                text: doc.name.en
            }
            return tag
        })
    },

    data(){
        return{
            uploading: false,
            tag: '',
            tags: [],
            album_selected: null,
        }
    },

    methods: {
        uploadingFiles($event){
            console.log($event);
            console.log('Subiendo archivos...');
        },

        uploadAlbum(){
            this.$refs.uploader.upload()
        },

        sendForm($event){
            if (this.v$.photo.$invalid) {
                this.$toast.add({severity:'error', summary: 'Error', detail:'Checa tus datos.', life: 3000});
                this.v$.$touch()
                return
            }

            this.uploading = true
            this.photo.tags = this.tags.map(doc => doc.text);
            if (this.album_selected != null) {
                this.photo.album_id = this.album_selected.id
            }

            this.photo.single_sale == false ? this.photo.price = null : this.photo.price = this.photo.price

            try {
                let URL = `/dashboard/photos/edit/${this.photo.id}`

                let data = new FormData()
                
                data.append('props', JSON.stringify(this.photo))
                data.append("file", $event.files[0]);
                if ($event.files[0]) {
                    data.append("size", $event.files[0].size);
                }
                
                data.append('_method', 'PUT')


                axios.post(URL, data).then(response => {
                    console.log(response);
                    this.$toast.add({severity:'success', summary: 'Foto editada', detail:'Se ha editado la foto', life: 3000});
                    this.uploading = false
                }).catch(error => {
                    console.log(error);
                    if (error.response.data.message) {
                        this.$toast.add({severity:'error', summary: 'Error', detail: error.response.data.message, life: 3000});
                    }else{
                        this.$toast.add({severity:'error', summary: 'Error', detail: 'Ha ocurrido un error', life: 3000});
                    }
                    this.uploading = false
                })
            } catch (error) {
                console.log(error);
                this.uploading = false
            }
        },

        goBack(){
            window.history.back()
        }
    }

})
</script>
