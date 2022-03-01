<style scoped lang="scss">
    .header-album{
        
    }
    
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
    <main-layout :title="album.name"> 
        <div class="container mx-auto mt-5">
            <div class="header-album">
                <div class="flex justify-start items-center">
                    <h2 class="text-3xl font-bold">{{ album.name }}</h2>
                </div>
                <div class="flex justify-between items-center mt-5">
                    <div class="image-footer">
                        <Link :href="route('web.profile', album_owner.id)" class=" flex justify-center items-center">
                            <div class="w-10 h-10 cursor-pointer">
                                <img class="w-10 h-10 object-cover object-center rounded-full" :src="album_owner.profile_photo_path" alt="">
                            </div>
                            <div class="ml-2">
                                <p class="text-sm font-bold cursor-pointer text-slate-600 hover:text-black">{{ album_owner.name }}</p>
                            </div>
                        </Link>
                    </div>
                    <div>
                        <div v-if="album.price != null">
                            <button class="px-2 py-1 border border-gray-600 text-gray-600 hover:border-black hover:text-black rounded-sm">
                                <i class="fas fa-cart-plus"></i>
                                Añadir al carrito
                            </button>
                        </div>
                        <p v-else class="text-sm">
                            Esta album no esta disponible para venta.
                        </p>
                    </div>
                </div>
            </div>
            <div class="flex justify-start items-center mt-10">
                <h2 class="text-sm">{{ album.photos.length }} fotos</h2>
            </div>
            <div>
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
                                    <div class="image-footer absolute bottom-0 left-0 p-2">
                                        <Link :href="route('web.profile', album_owner.id)" class="flex justify-center items-center ">
                                            <div class="w-10 h-10">
                                                <img class="w-10 h-10 object-cover object-center rounded-full" :src="album_owner.profile_photo_path" alt="">
                                            </div>
                                            <div class="ml-2">
                                                <p class="text-sm font-bold cursor-pointer text-slate-200 hover:text-white">{{ album_owner.name }}</p>
                                            </div>
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="mt-6 flex">
                    <h2 class="text-xl font-bold">Etiquetas relacionadas</h2>
                </div>
                <div class="py-5 flex flex-wrap">
                    <Link :href="null" class="px-2 py-1 text-gray-600 bg-gray-200 mr-2 hover:bg-gray-300 hover:text-black" v-for="tag in album.tags" :key="tag.created_at">
                        {{ tag.name.en }}
                    </Link>
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
        'album',
        'album_owner'
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
