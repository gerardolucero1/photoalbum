<style scoped lang="scss">

</style>

<template>
    <footer class="container mx-auto mt-5 mb-20">
        <div class="mt-2 flex justify-center items-center">
            <i class="fas fa-camera-retro"></i>
            <p class="ml-1 mt-0.5 font-bold">Photoalbum</p>
        </div>
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-6">
                <p class="text-gray-600 font-semibold">Nosotros</p>
                <p class="text-gray-600 font-semibold">Blog</p>
                <p class="text-gray-600 font-semibold">Descubre</p>
                <p class="text-gray-600 font-semibold">Anuncios</p>
            </div>
            <div class="col-span-6 flex justify-end items-end">
                <p><i class="fab fa-facebook-square mr-2"></i></p>
                <p><i class="fab fa-instagram mr-2"></i></p>
                <p><i class="fab fa-twitter-square"></i></p>
            </div>
        </div>
        <hr class="mt-5">
        <div class="mt-5 flex justify-between items-center">
            <div class="flex justify-center items-center">
                <i class="fas fa-camera-retro"></i>
                <p class="ml-1 mt-0.5 font-bold">Photoalbum</p>
            </div>
            <div class="flex justify-between items-center">
                <p class="text-gray-600 font-semibold mr-2">Politica de privacidad</p>
                <p class="text-gray-600 font-semibold">Terminos y condiciones</p>
            </div>
        </div>
    </footer>
</template>

<script>
import { defineComponent } from 'vue'
import { Link } from '@inertiajs/inertia-vue3';
import moment from 'moment'

export default defineComponent({
    name: 'FooterComponent',

    components: {
        Link,
        
    },

    setup(){
        
    },

    data(){
        return{
            
        }
    },

    created(){
        
    },

    methods: {
        
    }

})
</script>
