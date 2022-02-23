<style scoped lang="scss">
    .image-container-info-img{
        margin: 0;
        padding: 0;
        background-color: rgba(0, 0, 0, 0.9);

        img{
            height: 100%;
            width: 100%;
            cursor: pointer;
            pointer-events: none;
        }
    }

    .gallery-item{
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto;

        .image-container{
            margin-bottom: 17px;
            height: auto;
            
            .image-container-info-img{
                margin: 0;
                padding: 0;

                img{
                    height: 100%;
                    width: 300px;
                    cursor: pointer;
                    
                }

                &:hover{
                    div{
                        visibility: visible;
                    }
                }

                &>div{
                    visibility: hidden;
                }
            }

            
        }

        
    }
</style>

<template>
    <main-layout title="Inicio"> 
        <div class="container mx-auto mt-5">
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
                        Esta imagen no esta disponible para venta, revisa el album al que pertenece.
                    </p>
                    <div v-else>
                        <button class="px-2 py-1 border border-gray-600 text-gray-600 hover:border-black hover:text-black rounded-sm">
                            <i class="fas fa-cart-plus"></i>
                            Añadir al carrito
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex justify-center items-center mt-5">
                <div class="image-container-info-img">
                    <img id="image_preview" class="img-tile" :src="photo.url_preview" srcset="" :alt="photo.description" />
                </div>
            </div>
            <div class="flex justify-between items-center mt-5">
                <div class="image-footer flex justify-center items-start text-sm flex-col">
                    <div class="flex justify-center items-center">
                        <div class="w-5 h-5">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <span class="ml-5">Publicada {{ formatDate(photo.created_at) }}</span>
                    </div>
                    <div class="flex justify-center items-center mt-2" v-if="photo.single_sale">
                        <div class="w-5 h-5">
                            <i class="fas fa-coins"></i>
                        </div>
                        <span class="ml-5">Precio {{ toCurrency(Number(photo.price)) }}</span>
                    </div>
                </div>
                <div>
                    <div>
                        <button class="px-2 py-1 border border-gray-600 text-gray-600 hover:border-black hover:text-black rounded-sm">
                            <i class="fas fa-share"></i>
                            Compartir
                        </button>
                        <button class="ml-2 px-2 py-1 border border-gray-600 text-gray-600 hover:border-black hover:text-black rounded-sm">
                            <i class="fas fa-flag"></i>
                            Reportar
                        </button>
                    </div>
                </div>
            </div>
            <div v-if="album != null">
                <hr class="mt-6">
                <div class="mt-6 flex">
                    <h2 class="text-xl font-bold">Contenido del album: </h2>
                    <Link :href="null" class="text-xl font-bold ml-2 text-blue-600 hover:text-blue-700">
                        {{ album.name }}
                    </Link>
                </div>
                <div class="publication-container mt-6">
                    <div class='scrolling-component' ref='scrollComponent'>
                        <div class="gallery-item" v-masonry="containerId" transition-duration="0.3s" item-selector=".item" :gutter="20" fit-width="true">
                            <div class="image-container item" v-for="image in album.photos" :key="image.url_preview">
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
                                            <img class="w-10 h-10 object-cover object-center rounded-full" :src="photo.user.profile_photo_path" alt="">
                                        </div>
                                        <div class="ml-2">
                                            <p class="text-sm font-bold cursor-pointer text-slate-200 hover:text-white">{{ photo.user.name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        
    </main-layout>
</template>

<script>
import { defineComponent } from 'vue'
import MainLayout from '@/Layouts/MainLayout.vue'
import { Link } from '@inertiajs/inertia-vue3';
import moment from 'moment'

export default defineComponent({

    props: [
        'photo',
        'album'
    ],

    components: {
        MainLayout,
        Link,
        
    },

    setup(){
        
    },

    data(){
        return{
            containerId: null,
        }
    },

    created(){
        
    },

    methods: {
        formatDate(date){
            moment.locale('es')
            return moment(date).format('ll')
        }
    }

})
</script>
