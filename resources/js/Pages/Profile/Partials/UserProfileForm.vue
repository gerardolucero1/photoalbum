<template>
    <div>
        <div class="">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Informacion personal</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Informacion adicional del usuario para su perfil.
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                                    <input type="text" v-model="profile.name" name="name" id="name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="last_name" class="block text-sm font-medium text-gray-700">Apellidos</label>
                                    <input type="text" v-model="profile.last_name" name="last_name" id="last_name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="city" class="block text-sm font-medium text-gray-700">Ciudad</label>
                                    <input type="text" v-model="profile.city" name="city" id="city" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="state" class="block text-sm font-medium text-gray-700">Estado</label>
                                    <input type="text" v-model="profile.state" name="state" id="state" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="country" class="block text-sm font-medium text-gray-700">Pais</label>
                                    <input type="text" v-model="profile.country" name="country" id="country" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                </div>
                                <div class="col-span-6 sm:col-span-4">
                                    <label for="direction" class="block text-sm font-medium text-gray-700">Direccion</label>
                                    <input type="text" v-model="profile.direction" name="direction" id="direction" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="cp" class="block text-sm font-medium text-gray-700">CP</label>
                                    <input type="text" v-model="profile.cp" name="cp" id="cp" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button @click="sendForm" type="button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Actualizar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden sm:block mt-3" aria-hidden="true">
            <div class="py-5">
            <div class="border-t border-gray-200" />
            </div>
        </div>

        <Toast />
    </div>
</template>

<script>
export default {
    props: [
        'profile',
    ],

    data(){
        return{

        }
    },

    methods: {
        sendForm(){
            try {
                let URL = `/dashboard/profiles/edit/${this.profile.id}`

                let data = new FormData()
                data.append('props', JSON.stringify(this.profile))
                data.append('_method', 'PUT')

                axios.post(URL, data).then(response => {
                    console.log(response.data);
                    this.$toast.add({severity:'success', summary: 'Informacion actualizada', detail:'Se ha actualizado la informacion de perfil', life: 3000});
                }).catch(error => {
                    console.log(error);
                })
            } catch (error) {
                console.log(error);
            }
        }
    }
}
</script>

<style>

</style>