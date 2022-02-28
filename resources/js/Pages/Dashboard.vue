<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-6 border rounded-md p-5">
                            <p class="font-bold text-lg">Vistas</p>
                            <p class="font-bold text-3xl">0</p>
                        </div>
                        <div class="col-span-6 border rounded-md p-5">
                            <p class="font-bold text-lg">Descargas</p>
                            <p class="font-bold text-3xl">0</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import Welcome from '@/Jetstream/Welcome.vue'

    export default defineComponent({
        components: {
            AppLayout,
            Welcome,
        },
    })
</script>
