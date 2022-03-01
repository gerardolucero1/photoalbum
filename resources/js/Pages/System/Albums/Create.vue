<style scoped lang="scss">
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
    <app-layout title="Crear Album">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear nuevo album
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-start bg-white overflow-hidden shadow-xl sm:rounded-lg p-2 flex">
                    <Link :href="route('albums.index')" class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-arrow-left mr-1"></i> Regresar
                    </Link>
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
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Informacion del nuevo album</h3>
                                    <p class="mt-1 text-sm text-gray-600">
                                        Agrega la informacion requerida para la creacion de este album.
                                    </p>
                                </div>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <div class="shadow overflow-hidden sm:rounded-md">
                                    <div class="px-4 py-5 bg-white sm:p-6">
                                        <div class="grid grid-cols-6 gap-6">
                                            <div class="col-span-6 sm:col-span-6">
                                                <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                                                <input type="text" v-model="new_album.name" name="name" id="name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                                <div v-if="v$.new_album.name.$error">
                                                    <span class="text-red-500 text-xs" v-for="error in v$.new_album.name.$silentErrors" :key="error">{{ error.$message }}</span>
                                                </div>
                                            </div>
                                            <div class="col-span-6 sm:col-span-6">
                                                <label for="description" class="block text-sm font-medium text-gray-700">Descripcion</label>
                                                <textarea rows="5" v-model="new_album.description" name="description" id="description" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </textarea>
                                            </div>
                                            <div class="col-span-6 sm:col-span-6">
                                                <label for="active" class="block text-sm font-medium text-gray-700">Poner en venta</label>
                                                <InputSwitch id="active" v-model="new_album.show_price" />
                                            </div>
                                            <div class="col-span-6 sm:col-span-6" v-if="new_album.show_price">
                                                <label for="price" class="block text-sm font-medium text-gray-700">Precio</label>
                                                <input type="number" v-model="new_album.price" name="price" id="price" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                            </div>
                                            <div class="col-span-6 sm:col-span-6">
                                                <label for="active" class="block text-sm font-medium text-gray-700">Activo</label>
                                                <InputSwitch id="active" v-model="new_album.active" />
                                            </div>
                                            <div class="col-span-6 sm:col-span-6">
                                                <label for="private" class="block text-sm font-medium text-gray-700">Privado</label>
                                                <InputSwitch id="private" v-model="new_album.private" />

                                                <div class="mt-2">
                                                    <p v-if="new_album.private" class="text-sm text-gray-500">Este album incluido todo su contenido se pondra en estatus "privado" y no se indexara dentro de la plataforma.</p>
                                                    <p v-else class="text-sm text-gray-500">Este album incluido todo su contenido se pondra en estatus "publico" y se indexara dentro de la plataforma.</p>
                                                </div>
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
                                                <label for="private" class="block text-sm font-medium text-gray-700">Elige una imagen para tu album</label>
                                                <FileUpload class="mt-1" ref="uploader" accept="image/*" chooseLabel="Seleccionar" :multiple="false" :auto="false" :fileLimit="1" :showUploadButton="false" :showCancelButton="false" name="files[]" :withCredentials="true" :customUpload="true" @uploader="sendForm" @progress="uploadingFiles">
                                                    <template #empty>
                                                        <p>Drag and drop files to here to upload.</p>
                                                    </template>
                                                </FileUpload>
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
import useVuelidate from '@vuelidate/core'
import { required } from '@vuelidate/validators'
import VueTagsInput from '@sipec/vue3-tags-input';

export default defineComponent({
    props: [
        'albums'
    ],

    setup () {
        return { v$: useVuelidate() }
    },

    components: {
        AppLayout,
        Link,
        VueTagsInput
    },

    data(){
        return{
            new_album: {
                name: '',
                description: '',
                private: false,
                price: null,
                active: false,
            },
            tag: '',
            tags: [],
            uploading: false,
        }
    },

    validations () {
        return {
            new_album: {
                name: {
                    required
                },
            }
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
            if (this.v$.new_album.$invalid) {
                this.$toast.add({severity:'error', summary: 'Error', detail:'Checa tus datos.', life: 3000});
                this.v$.$touch()
                return
            }
            this.uploading = true
            try {
                let URL = '/dashboard/albums'

                let data = new FormData()

                if (!this.new_album.show_price) {
                    this.new_album.price = null
                }
                this.album.tags = this.tags.map(doc => doc.text);

                data.append('props', JSON.stringify(this.new_album))
                data.append("file", $event.files[0]);


                axios.post(URL, data).then(response => {
                    console.log(response);
                    this.$toast.add({severity:'success', summary: 'Album creado', detail:'Se ha creado un nuevo album', life: 3000});
                    this.uploading = false

                    this.new_album = {
                        name: '',
                        description: '',
                        private: false,
                        price: null,
                        active: false,
                    }

                    this.$refs.uploader.clear()
                }).catch(error => {
                    console.log(error);
                    this.$toast.add({severity:'error', summary: 'Error', detail:'Ha ocurrido un error', life: 3000});
                    this.uploading = false
                })
            } catch (error) {
                console.log(error);
                this.uploading = false
            }
        }
    }

})
</script>
