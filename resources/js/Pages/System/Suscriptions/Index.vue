<style scoped lang="scss">

</style>

<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Suscripcion
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-2">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg pb-4">
                    <button @click="subscribe">Subscribe</button>
                </div>
            </div>
        </div>

        <Toast />
        <Dialog :draggable="false" :dismissableMask="true" :showHeader="false" v-model:visible="uploading" :closable="false" :modal="true">
            <div class="uploading">
                <ProgressSpinner />
                <p>Espera un momento...</p>
            </div>
        </Dialog>
        <ConfirmDialog></ConfirmDialog>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/inertia-vue3';

export default defineComponent({
    props: [
        ''
    ],

    components: {
        AppLayout,
        Link,
    },

    data(){
        return{
            uploading: false,
        }
    },

    mounted() {
        
    },

    methods: {
        subscribe(){
            try {
                let URL = '/dashboard/user/subscribe'
                
                axios.post(URL).then(response => {
                    console.log(response);
                })
            } catch (error) {
                console.log(error);
            }
        },

        //Generar UUID
        generateUUID(){
            var h = ['0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f'];
            var k = ['x','x','x','x','x','x','x','x','-','x','x','x','x','-','4','x','x','x','-','y','x','x','x','-','x','x','x','x','x','x','x','x','x','x','x','x'];
            var u = '',i=0,rb=Math.random()*0xffffffff|0;
            while(i++<36) {
                var c=k[i-1],r=rb&0xf,v=c=='x'?r:(r&0x3|0x8);
                u+=(c=='-'||c=='4')?c:h[v];rb=i%8==0?Math.random()*0xffffffff|0:rb>>4
            }
            return u
        },
    }

})
</script>
