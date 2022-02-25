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

    .banner-container{
        width: 100%;
        height: 35em;
        background-color: red;
        background-image: url('https://images.unsplash.com/photo-1644167804910-0f4b8dc53799?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1vZi10aGUtZGF5fHx8fGVufDB8fHx8&dpr=1&auto=format%2Ccompress&fit=crop&w=1799&h=594');
        background-position: center;
        background-size: cover;
        
        .layer{
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background-color: rgba(0, 0, 0, 0.4);
            color: white;
        }
    }
</style>

<template>
    <main-layout title="Inicio"> 
        <div>
            <div class="banner-container">
                <div class="layer">
                    <Link :href="route('web.index')" class="mt-2 flex justify-center items-center text-3xl">
                        <i class="fas fa-camera-retro"></i>
                        <p class="ml-1 mt-1 font-bold">Photoalbum</p>
                    </Link>
                    <p class="font-bold text-lg mt-2">Lorem ipsum dolor sit amet adipisicing elit. Tempore alias est eius beatae iure.</p>
                    <div class="flex flex-wrap mt-2">
                        <Link :href="null" class="px-2 py-1 text-sm text-gray-500 bg-gray-100 mr-2 hover:bg-gray-300 hover:text-black" v-for="tag in 10">
                            Lorem
                        </Link>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mx-auto">
            <feed-index-component></feed-index-component>
        </div>
       
            
        
    </main-layout>
</template>

<script>
import { defineComponent } from 'vue'
import MainLayout from '@/Layouts/MainLayout.vue'
import { Link } from '@inertiajs/inertia-vue3';
import FeedIndexComponent from './Components/FeedIndexComponent.vue'

export default defineComponent({
    components: {
        MainLayout,
        Link,
        FeedIndexComponent
    },

    setup(){
        
    },

    data(){
        return{
            containerId: null,
            page: 1,
            noResult: false,
            message: "",

            posts: [],
        }
    },

    mounted(){
        
    },

    methods: {

    }

})
</script>
