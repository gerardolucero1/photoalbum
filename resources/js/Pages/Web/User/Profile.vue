<style scoped lang="scss">
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

    .image-container{
        width: 150px;
        height: 150px;
        
        img{
            width: 150px;
            height: 150px;
            object-fit: cover;
            object-position: center;
            border-radius: 50%;
        }
    }

    .options{

        .active{
            border-color: black;
            color: black;
        }
    }
</style>

<template>
    <main-layout :title="show_user.name"> 
        <div class="container mx-auto mt-5">
            <div class="profile flex justify-center items-center">
                <div class="flex justify-center items-center flex-col">
                    <div class="image-container">
                        <img :src="show_user.profile_photo_path" alt="">
                    </div>
                    <div class="mt-4 mx-auto flex justify-center items-center flex-col">
                        <p class="text-4xl font-bold cursor-pointer text-black">{{ show_user.name }}</p>
                        <div class="w-2/3 mt-2">
                            <p class="text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore maiores sapiente est maxime aperiam.</p>
                        </div>
                    </div>
                    <div class="mt-4 mx-auto flex justify-center items-center flex-col">
                        <div class="image-footer flex justify-center items-start text-md flex-col text-gray-600">
                            <div class="flex justify-center items-center" v-if="show_user.profile.state">
                                <div class="w-5 h-5">
                                    <i class="fas fa-map-marker"></i>
                                </div>
                                <span class="ml-5">{{ show_user.profile.state }}</span>
                            </div>
                            <div class="flex justify-center items-center mt-2" v-if="show_user.profile.country">
                                <div class="w-5 h-5">
                                    <i class="fas fa-flag"></i>
                                </div>
                                <span class="ml-5">{{ show_user.profile.country }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="mt-5">
            <div class="options mt-5">
                <div class="w-full flex justify-center items-center">
                    <button @click="type_view = 'photos'" :class="[type_view == 'photos' ? 'active' : '']" class="px-2 w-1/6 py-1 border border-gray-600 text-gray-600 hover:border-black hover:text-black rounded-sm">
                        <i class="fas fa-image"></i>
                        Imagenes
                    </button>
                    <button @click="type_view = 'videos'" :class="[type_view == 'videos' ? 'active' : '']" class="px-2 w-1/6 ml-2 py-1 border border-gray-600 text-gray-600 hover:border-black hover:text-black rounded-sm">
                        <i class="fas fa-video"></i>
                        Videos
                    </button>
                    <button @click="type_view = 'albums'" :class="[type_view == 'albums' ? 'active' : '']" class="px-2 w-1/6 ml-2 py-1 border border-gray-600 text-gray-600 hover:border-black hover:text-black rounded-sm">
                        <i class="fas fa-boxes"></i>
                        Albums
                    </button>
                </div>
            </div>
            <div class="mt-5">
                <feed-user-component :user="show_user" v-if="type_view == 'photos'"></feed-user-component>
                <album-user-component :user="show_user" v-if="type_view == 'albums'"></album-user-component>
            </div>
        </div>
    </main-layout>
</template>

<script>
import { defineComponent } from 'vue'
import MainLayout from '@/Layouts/MainLayout.vue'
import { Link } from '@inertiajs/inertia-vue3';
import moment from 'moment'
import FeedUserComponent from '../Components/FeedUserComponent.vue'
import AlbumUserComponent from '../Components/AlbumUserComponent.vue'

export default defineComponent({

    name: 'Profile',

    props: [
        'show_user',
    ],

    components: {
        MainLayout,
        Link,
        FeedUserComponent,
        AlbumUserComponent
    },

    setup(){
        
    },

    data(){
        return{
            type_view: 'photos',
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
