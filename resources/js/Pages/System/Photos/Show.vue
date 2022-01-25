<style scoped lang="scss">
    .img-tile{
        width: 100%;

        img{
            width: 100% !important;
        }
    }

    .p-image-preview-container{
        img{
            width: 100% !important;
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
                Estas viendo {{ photo.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-start bg-white overflow-hidden shadow-xl sm:rounded-lg p-2 flex">
                    <Link :href="route('albums.show', photo.album.id)" class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
                        <div class="md:grid md:grid-cols-12 md:gap-6">
                            <div class="md:col-span-6">
                                <img style="width: 100%;" class="img-tile" :src="photo.url_preview" srcset="" :alt="photo.description" preview />
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-6">
                                <div class="shadow overflow-hidden sm:rounded-md">
                                    <div class="px-4 py-5 bg-white sm:p-6">
                                        <div class="grid grid-cols-6 gap-6">
                                            <div class="col-span-6 sm:col-span-6">
                                                <h1 class="text-2xl font-bold">{{ photo.name }}</h1>
                                            </div>
                                            <div class="col-span-6 sm:col-span-6">
                                                <p class="font-extralight">{{ photo.description }}</p>
                                            </div>
                                            <div class="col-span-6 sm:col-span-6">
                                                <Badge value="Privada" severity="warning" v-if="photo.private"></Badge>
                                                <Badge value="Publica" severity="success" v-else></Badge>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                        <Link :href="route('photos.edit', photo.id)" type="button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Editar
                                        </Link>
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

export default defineComponent({
    props: [
        'photo'
    ],

    components: {
        AppLayout,
        Link,
    },

    created(){
        this.photo.private == 1 ? this.photo.private = true :  this.photo.private = false
    },

    data(){
        return{
            uploading: false,
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
            console.log($event);
            try {
                let URL = `/dashboard/photos/edit/${this.photo.id}`

                let data = new FormData()
                
                data.append('props', JSON.stringify(this.photo))
                data.append("file", $event.files[0]);
                data.append('_method', 'PUT')


                axios.post(URL, data).then(response => {
                    console.log(response);
                    this.$toast.add({severity:'success', summary: 'Foto editada', detail:'Se ha editado la foto', life: 3000});
                    this.uploading = false
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
