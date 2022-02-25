<style scoped lang="scss">
    .album-container{
        width: 100%;
        height: 100%;
        aspect-ratio: 1 / 1;

        .image-bg{
            width: 100%;
            height: 100%;
            background-color: rosybrown;
            background-size: cover;
            background-position: center;

            img{
                width: 100%;
                object-fit: cover;
                object-position: center;
            }
        }
    }
</style>

<template>
    <div>
        <div class="grid grid-cols-12 gap-4">
            <div class="album-container col-span-3" v-for="album in albums" :key="album.created_at">
                <div class="album-container grid grid-cols-12 gap-1">
                    <div class="col-span-9">
                        <div v-if="album.photos[0]" class="image-bg" :style="{ backgroundImage: 'url(' + album.photos[0].url_preview + ')' }" />
                        <div v-else class="image-bg" :style="{ backgroundImage: 'url(https://htmlcolorcodes.com/assets/images/colors/light-gray-color-solid-background-1920x1080.png)' }" />
                    </div>
                    <div class="col-span-3 flex justify-center items-center flex-col">
                        <div class="h-1/2 w-full border-b-2 border-white">
                            <div v-if="album.photos[1]" class="image-bg" :style="{ backgroundImage: 'url(' + album.photos[1].url_preview + ')' }" />
                            <div v-else class="image-bg" :style="{ backgroundImage: 'url(https://htmlcolorcodes.com/assets/images/colors/light-gray-color-solid-background-1920x1080.png)' }" />
                        </div>
                        <div class="h-1/2 w-full border-t-2 border-white">
                            <div v-if="album.photos[2]" class="image-bg" :style="{ backgroundImage: 'url(' + album.photos[2].url_preview + ')' }" />
                            <div v-else class="image-bg" :style="{ backgroundImage: 'url(https://htmlcolorcodes.com/assets/images/colors/light-gray-color-solid-background-1920x1080.png)' }" />
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="font-bold text-lg">{{ album.name }}</p>
                    <p class="text-sm text-gray-600">{{ album.photos_count }} fotos - {{ this.user.name }}</p>
                </div>
            </div>
        </div>
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
            albums: [],
        }
    },

    mounted(){
        this.loadDataFromServer()
    },

    methods: {
         loadDataFromServer(){
            try {
                let URL = `/profile/${this.user.id}/albums`

                axios.get(URL).then(response => {
                    this.albums = response.data
                }).catch(error => {
                    console.log(error);
                })

            } catch (error) {
                console.log(error);
            }
        }
    }

})
</script>