<style scoped lang="scss">
    
</style>

<template>
    <main-layout title="Inicio">
        <p>Ola</p>
    </main-layout>
</template>

<script>
import { defineComponent } from 'vue'
import MainLayout from '@/Layouts/MainLayout.vue'
import { Link } from '@inertiajs/inertia-vue3';

export default defineComponent({
    components: {
        MainLayout,
        Link,
    },

    data(){
        return{
            
        }
    },

    methods: {

    }

})
</script>
