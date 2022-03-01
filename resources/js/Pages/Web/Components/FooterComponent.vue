<style scoped lang="scss">

</style>

<template>
    <footer>
        <div class="mt-2 flex justify-center items-center">
            <i class="fas fa-camera-retro"></i>
            <p class="ml-1 mt-0.5 font-bold">Photoalbum</p>
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
