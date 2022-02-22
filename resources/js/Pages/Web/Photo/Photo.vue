<style scoped lang="scss">
    .image-container-info-img{
        margin: 0;
        padding: 0;
        background-color: rgba(0, 0, 0, 0.9);

        img{
            height: 100%;
            width: 100%;
            cursor: pointer;
            
        }
    }
</style>

<template>
    <main-layout title="Inicio"> 
        <div class="p-2">
            <div class="flex justify-between items-center">
                <div class="image-footer flex justify-center items-center">
                    <div class="w-10 h-10 cursor-pointer">
                        <img class="w-10 h-10 object-cover object-center rounded-full" :src="photo.user.profile_photo_path" alt="">
                    </div>
                    <div class="ml-2">
                        <p class="text-sm font-bold cursor-pointer text-slate-600 hover:text-black">{{ photo.user.name }}</p>
                    </div>
                </div>
                <div>
                    <p v-if="!photo.single_sale" class="text-sm">
                        Esta imagen no esta disponible para venta, revisar el album completo al que pertenece
                    </p>
                </div>
            </div>
            <div class="flex justify-center items-center">
                <div class="image-container-info-img">
                    <img v-masonry-tile class="img-tile" :src="photo.url_preview" srcset="" :alt="photo.description" />
                </div>
            </div>
            <div class="publication-container mt-4">
                <div class='scrolling-component' ref='scrollComponent'>
                    <!-- <div class="gallery-item" v-masonry="containerId" transition-duration="0.3s" item-selector=".item" :gutter="20" fit-width="true">
                        <div class="image-container item" v-for="image in posts" :key="image.url_preview">
                            <div class="image-container-info-img">
                                <Link :href="route('web.photos.show', image.slug)">
                                    <img v-masonry-tile class="img-tile" :src="image.url_preview" srcset="" :alt="image.description" />
                                </Link>
                                <div class="image-header flex justify-end items-center w-full absolute top-0 right-0 p-2">
                                    <button class="w-10 h-10 flex justify-center items-center rounded-md bg-white">
                                        <i class="fas fa-folder-open text-gray-400"></i>
                                    </button>
                                </div>
                                <div class="image-footer flex justify-center items-center absolute bottom-0 left-0 p-2">
                                    <div class="w-10 h-10">
                                        <img class="w-10 h-10 object-cover object-center rounded-full" :src="image.user.profile_photo_path" alt="">
                                    </div>
                                    <div class="ml-2">
                                        <p class="text-sm font-bold cursor-pointer text-slate-200 hover:text-white">{{ image.user.name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    
        
    </main-layout>
</template>

<script>
import { defineComponent } from 'vue'
import MainLayout from '@/Layouts/MainLayout.vue'
import { Link } from '@inertiajs/inertia-vue3';

export default defineComponent({

    props: [
        'photo'
    ],

    components: {
        MainLayout,
        Link,
        
    },

    setup(){
        
    },

    data(){
        return{
            
        }
    },

    mounted(){
        
    },

    methods: {
        
    }

})
</script>
