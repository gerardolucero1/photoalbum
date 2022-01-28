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
</style>

<template>
    <app-layout title="Dashboard">
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
                                            </div>
                                            <div class="col-span-6 sm:col-span-6">
                                                <label for="description" class="block text-sm font-medium text-gray-700">Descripcion</label>
                                                <textarea rows="5" v-model="photo.description" name="description" id="description" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </textarea>
                                            </div>
                                            <div class="col-span-6 sm:col-span-6">
                                                <label for="private" class="block text-sm font-medium text-gray-700">Privado</label>
                                                <InputSwitch id="private" v-model="photo.private" />
                                            </div>
                                            <div class="col-span-6 sm:col-span-6">
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
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
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

export default defineComponent({
    props: [
        'photo'
    ],

    components: {
        AppLayout,
        Link,
        VueTagsInput
    },

    created(){
        this.photo.private == 1 ? this.photo.private = true :  this.photo.private = false
        this.photo.single_sale == 1 ? this.photo.single_sale = true :  this.photo.single_sale = false

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
            this.uploading = true
            this.photo.tags = this.tags.map(doc => doc.text);

            this.photo.single_sale == false ? this.photo.price = null : this.photo.price = this.photo.price

            try {
                let URL = `/dashboard/photos/edit/${this.photo.id}`

                let data = new FormData()
                
                data.append('props', JSON.stringify(this.photo))
                data.append("file", $event.files[0]);
                data.append("size", $event.files[0].size);
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
