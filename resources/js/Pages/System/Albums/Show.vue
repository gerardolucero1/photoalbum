<style scoped lang="scss">
    .grid-container{
        padding: 3.5% 0;
    }

    .gallery-item{
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto;

        .image-container{
            
            height: auto;

            img{
                width: 210px;
                height: 100%;
                width: 210px;
                cursor: pointer;
            }

            .image-container-info-img{
                margin: 0;
                padding: 0;
            }

            .options-tile{
                width: 100%;
                display: flex;
                justify-content: center;
                align-items: center;

                button{
                    width: 20px;
                    height: 20px;
                    margin: 5px;
                    padding: 15px;
                    border-radius: 50%;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    font-size: 13px;
                }
            }
        }
    }

    .uploading{
        width: 200px; 
        height: 200px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    @keyframes p-progress-spinner-color {
        100%,
        0% {
            stroke: #d62d20;
        }
        40% {
            stroke: #0057e7;
        }
        66% {
            stroke: #008744;
        }
        80%,
        90% {
            stroke: #ffa700;
        }
    }

    ::v-deep(.custom-galleria) {
        &.fullscreen {
            display: flex;
            flex-direction: column;

            .p-galleria-content {
                flex-grow: 1;
                justify-content: center;
            }
        }

        .p-galleria-content {
            position: relative;
        }

        .p-galleria-thumbnail-wrapper {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
        }

        .p-galleria-thumbnail-items-container {
            width: 100%;
        }

        .custom-galleria-footer {
            display: flex;
            align-items: center;
            background-color: rgba(0, 0, 0, .9);
            color: #ffffff;

            button {
                background-color: transparent;
                color: #ffffff;
                border: 0 none;
                border-radius: 0;
                margin: .2rem 0;

                &.fullscreen-button {
                    margin-left: auto;
                }

                &:hover {
                    background-color: rgba(255, 255, 255, 0.1);
                }
            }
        }

        .title-container {
            > span {
                font-size: .9rem;
                padding-left: .829rem;

                &.title {
                    font-weight: bold;
                }
            }
        }
    }

</style>

<template>
    <app-layout :title="album.name">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Estas viendo {{ album.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-start bg-white overflow-hidden shadow-xl sm:rounded-lg p-2 flex">
                    <Link :href="route('albums.index')" class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-arrow-left mr-1"></i> Regresar
                    </Link>
                </div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-2">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <FileUpload ref="uploader" accept="image/*" chooseLabel="Seleccionar" :multiple="true" :auto="false" :fileLimit="10" :showUploadButton="true" :showCancelButton="false" name="files[]" :withCredentials="true" :customUpload="true" @uploader="sendForm" @progress="uploadingFiles">
                        <template #empty>
                            <p>Drag and drop files to here to upload.</p>
                        </template>
                    </FileUpload>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-2">
                <div class="flex justify-start bg-white overflow-hidden shadow-xl sm:rounded-lg p-2">
                    <button @click="type_view = 'table'" class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-table mr-1"></i> Vista tabla
                    </button>
                    <button @click="type_view = 'grid'" class="ml-2 py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-border-all mr-1"></i> Vista grid
                    </button>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-2">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg pb-4">
                    <div v-if="type_view == 'table'">
                        <DataTable class="p-datatable-customers" 
                            filterDisplay="menu" 
                            :value="album.photos" 
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
                                            <img class="h-10 w-10 rounded-full object-cover object-center" :src="data.url_preview" alt="" />
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
                                        {{ toCurrency(Number(data.price)) }}
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
                            <Column class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium" header="Opciones" headerStyle="width: 4rem; text-align: center" bodyStyle="text-align: center; overflow: visible">
                                <template #body="{data}">
                                    <Link v-tooltip.top="'Ver foto'" :href="route('photos.show', data.id)" class="px-2 py-2 border-gray-300 rounded-md border mr-2">
                                        <i class="fas fa-eye"></i>
                                    </Link>
                                    <Link v-tooltip.top="'Editar foto'" :href="route('photos.edit', data.id)" class="px-2 py-2 border-gray-300 rounded-md border mr-2">
                                        <i class="fas fa-pencil-alt"></i>
                                    </Link>
                                    <button v-tooltip.top="'Eliminar foto'" class="px-2 py-2 border-gray-300 rounded-md border mr-2" @click="deletePhoto(image, index)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </template>
                            </Column>
                        </DataTable>
                    </div>
                    <section v-else ref="gallery" class="grid-container" :key="index">

                        <Galleria :value="album.photos" v-model:activeIndex="activeIndex" thumbnailsPosition="left" :responsiveOptions="responsiveOptions" :numVisible="7" containerStyle="max-width: 850px"
                            :circular="true" :fullScreen="true" :showItemNavigators="true" :showThumbnails="false" v-model:visible="displayCustom">
                            <template #item="slotProps">
                                <img :src="slotProps.item.url_photo" :alt="slotProps.item.description" style="width: 100%; display: block;" />
                            </template>
                            <template #thumbnail="slotProps">
                                <div class="w-full h-full">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full object-cover object-center" :src="slotProps.item.url_preview" :alt="slotProps.item.description" style="display: block;" />
                                    </div>
                                </div>
                            </template>
                        </Galleria>

                        <div class="gallery-item" v-masonry="containerId" transition-duration="0.3s" item-selector=".item" :gutter="20" fit-width="true">
                            <div class="image-container item" v-for="(image, index) in album.photos" :key="image.url_preview">
                                <div class="image-container-info-img" @click="imageClick(index)">
                                    <img v-masonry-tile class="img-tile" :src="image.url_preview" srcset="" :alt="image.description" />
                                </div>
                                <div class="options-tile">
                                    <Link :href="route('photos.show', image.id)">
                                        <button class="bg-pink-500 text-neutral-50" >
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </Link>
                                    <Link :href="route('photos.edit', image.id)">
                                        <button class="bg-indigo-600 text-neutral-50" >
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                    </Link>
                                    <button class="bg-red-500 text-neutral-50" @click="deletePhoto(image, index)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                            
                        </div>
                    </section>
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
import Masonry from "masonry-layout";
import {FilterMatchMode} from 'primevue/api';

export default defineComponent({
    props: [
        'album'
    ],

    components: {
        AppLayout,
        Link,
    },

    data(){
        return{
            type_view: 'table',
            containerId: null,
            uploading: false,

            activeIndex: 0,
			responsiveOptions: [
				{
                    breakpoint: '1024px',
                    numVisible: 5
                },
                {
                    breakpoint: '768px',
                    numVisible: 3
                },
                {
                    breakpoint: '560px',
                    numVisible: 1
                }
            ],
            displayCustom: false,
            index: '1',

            filters: {
                'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
            },
        }
    },

    methods: {
        imageClick(index) {
            this.activeIndex = index;
            this.displayCustom = true;
        },

        uploadingFiles($event){
            console.log($event);
            console.log('Subiendo archivos...');
        },

        deletePhoto(image, index){
            this.$confirm.require({
                message: `¿Quieres eliminar esta foto?`,
                header: 'Eliminar',
                icon: 'pi pi-info-circle',
                acceptClass: 'p-button-danger',
                accept: () => {
                    try {
                        let URL = `/dashboard/photos/${image.id}`

                        axios.delete(URL).then(response => {
                            this.album.photos.splice(index, 1)
                            this.$toast.add({severity:'info', summary:'Eliminada', detail:'La foto ha sido eliminada', life: 3000});
                        }).catch(error => {
                            console.log(error);
                            this.$toast.add({severity:'error', summary: 'Error', detail:'Ha ocurrido un error', life: 3000});
                        })
                    } catch (error) {
                        console.log(error);
                    }
                },
                reject: () => {
                    
                }
            });
        },

        sendForm($event){
            this.uploading = true
            try {
                let URL = `/dashboard/albums/upload/${this.album.id}`

                let size = 0
                let data = new FormData()
                
                for (let i = 0; i < $event.files.length; i++) {
                    size = size + $event.files[i].size
                    data.append("files[" + i + "]", $event.files[i]);
                }
                data.append('size', size)

                axios.post(URL, data).then(response => {
                    console.log(response);
                    this.$toast.add({severity:'success', summary: 'Fotos cargadas', detail:'Se han cargado las nuevas fotos', life: 3000});
                    response.data.forEach(doc => {
                        this.album.photos.push(doc)
                    })

                    this.$refs.uploader.clear()
                    this.uploading = false
                }).catch(error => {
                    console.log(error);
                    if (error.response.data.message) {
                        this.$toast.add({severity:'error', summary: 'Error', detail: error.response.data.message, life: 3000});
                    }else{
                        this.$toast.add({severity:'error', summary: 'Error', detail: 'Ha ocurrido un error', life: 3000});
                    }
                    this.uploading = false
                })
            } catch (error) {
                console.log(error);
                this.uploading = false
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
