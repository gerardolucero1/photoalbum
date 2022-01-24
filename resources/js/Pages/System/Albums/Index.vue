<style scoped lang="scss">
::v-deep(.p-datatable.p-datatable-customers) {
    .p-datatable-header {
        padding: 1rem;
        text-align: left;
        font-size: 1.5rem;
    }

    .p-paginator {
        padding: 1rem;
    }

    .p-datatable-thead > tr > th {
        text-align: left;
    }

    .p-datatable-tbody > tr > td {
        cursor: auto;
    }

    .p-dropdown-label:not(.p-placeholder) {
        text-transform: uppercase;
    }
}
</style>

<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Albums
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-end bg-white overflow-hidden shadow-xl sm:rounded-lg p-2 flex">
                    <Link :href="route('albums.create')" class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Crear nuevo album
                    </Link>
                </div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-2">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <DataTable class="p-datatable-customers" 
                        filterDisplay="menu" 
                        :value="albums" 
                        :paginator="true" 
                        :rows="50"
                        dataKey="id" 
                        v-model:filters="filters"
                        :rowHover="true"
                        :globalFilterFields="['name']"
                        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink"
                        responsiveLayout="scroll"
                        :rowsPerPageOptions="[5,10,20,50]"
                        >
                        <template #header>
                            <div class="p-d-flex p-jc-between p-ai-center">
                                <span class="p-input-icon-left">
                                    <i class="pi pi-search" />
                                    <InputText v-model="filters['global'].value" :placeholder="`Filtrar`" />
                                </span>
                            </div>
                        </template>
                        <template #empty>
                            Sin informacion.
                        </template>
                        <Column field="name" header="Nombre" sortable style="min-width: 14rem">
                            <template #body="{data}">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full object-cover object-center" :src="data.photo_url" alt="" />
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ data.name }}
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <template #filter="{filterModel}">
                                <InputText type="text" v-model="filterModel.value" class="p-column-filter" placeholder="Search by name"/>
                            </template>
                        </Column>
                        <Column field="photos_count" header="Cantidad de fotos" sortable style="min-width: 14rem">
                            <template #body="{data}">
                                <div class="text-sm text-gray-900">
                                    {{ data.photos_count }}
                                </div>
                            </template>
                        </Column>
                        <Column field="private" header="Privado" sortable style="min-width: 14rem">
                            <template #body="{data}">
                                <div class="text-sm text-gray-900">
                                    <span v-if="data.private">Si</span>
                                    <span v-else>No</span>
                                </div>
                            </template>
                        </Column>

                        <Column class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium" header="Opciones" headerStyle="width: 4rem; text-align: center" bodyStyle="text-align: center; overflow: visible">
                            <template #body="{data}">
                                <Link :href="route('albums.edit', data.id)" class="px-2 py-2 border-gray-300 rounded-md border mr-2">
                                    <i class="fas fa-pencil-alt"></i>
                                </Link>
                                <Link :href="route('albums.show', data.id)" class="px-2 py-2 border-gray-300 rounded-md border mr-2">
                                    <i class="far fa-images"></i>
                                </Link>
                                <!-- <button v-tooltip.top="'Asignar curso a puesto'" @click="assingCourseModal(data, index)" class="px-2 py-2 border-blue-300 rounded-md border mr-2">
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                                <inertia-link v-tooltip.top="'Lecciones del curso'" :href="route('admin.courses.show', data.id)" class="px-2 py-2 border-green-300 rounded-md border mr-2">
                                    <i class="fas fa-folder-plus"></i>
                                </inertia-link>
                                
                                <button @click="deleteCourse(data, index)" class="px-2 py-2 border-red-300 rounded-md border mr-2">
                                    <i class="fas fa-trash"></i>
                                </button> -->
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/inertia-vue3';
import {FilterMatchMode} from 'primevue/api';

export default defineComponent({
    props: [
        'albums'
    ],

    components: {
        AppLayout,
        Link,
    },

    data(){
        return{
            filters: {
                'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
            },
        }
    },

})
</script>
