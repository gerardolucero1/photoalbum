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
                        <Column field="price" header="Precio" sortable style="min-width: 11rem">
                            <template #body="{data}">
                                <div class="text-sm text-gray-900">
                                    {{ data.price }}
                                </div>
                            </template>
                        </Column>
                        <Column field="photos_count" header="Cantidad de fotos" sortable style="min-width: 14rem">
                            <template #body="{data}">
                                <div class="text-sm text-gray-900">
                                    {{ data.photos_count }}
                                </div>
                            </template>
                        </Column>
                        <Column field="private" header="Privado" sortable style="min-width: 8rem">
                            <template #body="{data}">
                                <div class="text-sm text-gray-900">
                                    <span v-if="data.private">Si</span>
                                    <span v-else>No</span>
                                </div>
                            </template>
                        </Column>
                        <Column field="active" header="Activo" sortable style="min-width: 8rem">
                            <template #body="{data}">
                                <div class="text-sm text-gray-900">
                                    <span v-if="data.active">Si</span>
                                    <span v-else>No</span>
                                </div>
                            </template>
                        </Column>

                        <Column class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium" header="Opciones" headerStyle="width: 4rem; text-align: center" bodyStyle="text-align: center; overflow: visible">
                            <template #body="{data}">
                                <Link v-tooltip.top="'Editar album'" :href="route('albums.edit', data.id)" class="px-2 py-2 border-gray-300 rounded-md border mr-2">
                                    <i class="fas fa-pencil-alt"></i>
                                </Link>
                                <Link v-tooltip.top="'Agregar fotos'" :href="route('albums.show', data.id)" class="px-2 py-2 border-gray-300 rounded-md border mr-2">
                                    <i class="far fa-images"></i>
                                </Link>
                                <button @click="putSale(data)" v-tooltip.top="'Agregar a paquete'" class="px-2 py-2 border-gray-300 rounded-md border mr-2">
                                    <i class="fas fa-boxes"></i>
                                </button>
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </div>
        </div>

        <Sidebar v-model:visible="sidebar" :baseZIndex="1000" position="right">
            <h3 class="text-2xl font-bold">Paquetes activos</h3>

            <ul class="mt-4">
                <li v-for="(sale, index) in sales" :key="index" class="mb-2" @click="selectSale(sale)">
                    <div class="flex items-center hover:bg-gray-50 p-2 hover:cursor-pointer">
                        <i class="fas fa-box text-2xl"></i>
                        <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">
                            {{ sale.name }}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ sale.photos_count }} Fotografias
                        </div>
                        </div>
                    </div>
                </li>
            </ul>
        <Toast></Toast>
        </Sidebar>
        <ConfirmDialog></ConfirmDialog>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/inertia-vue3';
import {FilterMatchMode} from 'primevue/api';

export default defineComponent({
    props: [
        'albums',
        'sales'
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

            sidebar: false,
            album_selected: null,
        }
    },

    methods: {
        putSale(album){
            this.album_selected = album
            this.sidebar = true
        },

        selectSale(sale){
            this.$confirm.require({
                message: `¿Quieres agregar el contenido de este album a ${sale.name}?`,
                header: 'Seleccionar paquete',
                icon: 'pi pi-info-circle',
                acceptClass: 'p-button-info',
                accept: () => {
                    try {
                        let URL = `/dashboard/sales/select-photos`

                        let data = new FormData()
                        data.append('sale_id', sale.id)
                        data.append('album_id', this.album_selected.id)

                        axios.post(URL, data).then(response =>  {
                            this.$toast.add({severity:'info', summary:'Venta actualizada', detail:`Se ha agregado el contenido a ${sale.name}`, life: 3000});
                            let foundIndex = this.sales.findIndex(doc => doc.id == sale.id)
                            this.sales.splice(foundIndex, 1, response.data)
                        })
                    } catch (error) {
                        console.log(error);
                    }
                    
                },
                reject: () => {
                    return
                }
            });
        }
    }

})
</script>
