<style scoped lang="scss">
 .gallery-item{
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto;
    }
    .image-container{
        margin-top: 20px;
        width: 230px;
        height: auto;
        cursor: zoom-in;
    }
    .image-container img{
        border-radius: 10px;
    }
    .image-container:hover .image-info{
        visibility: visible;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 22px;
        color: white;
    }
    .image-container-info-img{
        position: relative;
    }
    .image-info{
        border-radius: 10px;
        width: 230px;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        position: absolute;
        top: 0;
        left: 0;
        visibility: hidden;
    }
    .image-user-info{
        margin-top: 5px;
        width: 100%;
        height: auto;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        flex-direction: column;
        span{
            
        }
        .image-image-name{
            margin-top: 10px;
            width: 100%;
            height: auto;
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }
    }
    .image-user-image{
        width: 30px;
        height: 30px;
        background-color: red;
        border-radius: 50%;
        justify-content: center;
        align-items: center;
    }
    .image-user-image img{
        width: 30px;
        height: 30px;
        border-radius: 50%;
        object-fit: cover;
        object-position: center;
    }
    .image-name{
        margin-left: 10px;
        font-weight: bold;
        font-size: 14px;
    }

    .image-tile{
        width: 230px;
    }
</style>

<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Estas viendo {{ album.name }}
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
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <FileUpload ref="uploader" accept="image/*" chooseLabel="Seleccionar" :multiple="true" :auto="false" :fileLimit="10" :showUploadButton="true" :showCancelButton="false" name="files[]" :withCredentials="true" :customUpload="true" @uploader="sendForm" @progress="uploadingFiles">
                        <template #empty>
                            <p>Drag and drop files to here to upload.</p>
                        </template>
                    </FileUpload>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-2 pb-2">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg pb-4">
                    <section ref="gallery" class="grid-container">
                        <div class="gallery-item" v-masonry="containerId" transition-duration="0.3s" item-selector=".item" :gutter="20" fit-width="true">
                            <div class="image-container item" v-for="(image, index) in album.photos" :key="index">
                                <div class="image-container-info-img">
                                    <img v-masonry-tile class="image-tile" :src="image.url_preview" srcset="" :alt="image.description">
                                    
                                </div>
                            </div>
                            
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/inertia-vue3';
import Masonry from "masonry-layout";

export default defineComponent({
    props: [
        'album'
    ],

    components: {
        AppLayout,
        Link,
    },

    data(){
        return{
            containerId: null,
            images: [],
            page: 0,
        }
    },

    methods: {
        imageClick(index) {
            this.activeIndex = index;
            this.displayCustom = true;
        },

        uploadingFiles($event){
            console.log($event);
            console.log('Subiendo archivos...');
        },

        sendForm($event){
            
            try {
                let URL = `/dashboard/albums/upload/${this.album.id}`

                let data = new FormData()
                
                for (let i = 0; i < $event.files.length; i++) {
                    data.append("files[" + i + "]", $event.files[i]);
                }

                axios.post(URL, data).then(response => {
                    console.log(response);
                    this.$toast.add({severity:'success', summary: 'Fotos cargadas', detail:'Se han cargado las nuevas fotos', life: 3000});
                }).catch(error => {
                    console.log(error);
                    this.$toast.add({severity:'error', summary: 'Error', detail:'Ha ocurrido un error', life: 3000});
                })
            } catch (error) {
                console.log(error);
            }
        }
    }

})
</script>
