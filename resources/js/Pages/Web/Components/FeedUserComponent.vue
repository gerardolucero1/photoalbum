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

</style>

<template>
    <div>
        <infinite-scroll 
            @infinite-scroll="loadDataFromServer" 
            :noResult="noResult"
            :message="message">
            <!-- Place the content of your page here. E.g a list of resources being fetched from a server -->
            
            <div class='scrolling-component' ref='scrollComponent'>
                <div class="gallery-item" v-masonry="containerId" transition-duration="0.3s" item-selector=".item" :gutter="20" fit-width="true">
                    <div class="image-container item" v-for="image in posts" :key="image.url_preview">
                        <div class="image-container-info-img">
                            <figure itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                                <Link itemprop="contentUrl" :href="route('web.photos.show', image.slug)">
                                    <img v-masonry-tile class="img-tile" :src="image.url_preview" srcset="" :alt="image.description" />
                                </Link>
                            </figure>
                            
                            <div class="image-header flex justify-end items-center w-full absolute top-0 right-0 p-2">
                                <button class="w-10 h-10 flex justify-center items-center rounded-md bg-white">
                                    <i class="fas fa-folder-open text-gray-400"></i>
                                </button>
                            </div>
                            <div class="image-footer absolute bottom-0 left-0 p-2">
                                <Link :href="route('web.profile', image.user.id)" class="flex justify-center items-center ">
                                    <div class="w-10 h-10">
                                        <img class="w-10 h-10 object-cover object-center rounded-full" :src="image.user.profile_photo_path" alt="">
                                    </div>
                                    <div class="ml-2">
                                        <p class="text-sm font-bold cursor-pointer text-slate-200 hover:text-white">{{ image.user.name }}</p>
                                    </div>
                                </Link>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </infinite-scroll>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import { Link } from '@inertiajs/inertia-vue3';
import InfiniteScroll from "infinite-loading-vue3";

export default defineComponent({
    props: [
        'user'
    ],

    components: {
        Link,
        InfiniteScroll
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
        this.loadDataFromServer()
    },

    methods: {
         async loadDataFromServer(){
            try {
                let URL = `/profile/${this.user.id}/publications?page=${this.page}`
                let result = await axios.get(URL)

                if(result.data.data.length) {
                    console.log(result.data.data);
                    this.posts.push(...result.data.data)
                    this.page++
                } else {
                    this.noResult = true
                    this.message = "No result found"
                }

            } catch (error) {
                this.noResult = true
                this.message = "Error loading data"
            }
        }
    }

})
</script>