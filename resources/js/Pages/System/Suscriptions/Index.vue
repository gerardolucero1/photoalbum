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
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-1" v-for="plan in plans" :key="plan.created_at">
                            <div class="max-w-md py-4 px-8 bg-white rounded-lg my-20">
                                <div class="flex justify-center md:justify-end -mt-16">
                                    <img class="w-20 h-20 object-cover rounded-full border-2" src="https://uxwing.com/wp-content/themes/uxwing/download/42-business-professional-services/recurring-subscription.png">
                                </div>
                                <div>
                                    <h2 class="text-gray-800 text-3xl font-semibold">{{ plan.name }}</h2>
                                    <p class="mt-2 text-gray-600">
                                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Numquam recusandae veniam, nostrum optio dignissimos fuga natus a atque libero voluptatem laboriosam error aliquam officia tempora deleniti consequatur iure quidem nihil?
                                    </p>

                                    <h4 class="text-2xl mt-5">${{ plan.price }}</h4>
                                </div>
                                <div class="flex justify-end mt-4">
                                    <button @click="makeVisibleCard(plan)" class="text-xl font-medium text-indigo-500">Comprar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <Toast />
        <Sidebar v-model:visible="isVisible" position="right" class="p-sidebar-md">
            <div>
                <div class="px-4 py-5 bg-white sm:p-6">
                    <h2 class="text-2xl">{{ plan_selected.name }}</h2>
                </div>
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
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-6">
                           <!-- Stripe Elements Placeholder -->
                            <div id="card-element"></div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 text-right sm:px-6">
                    <button id="card-button" @click="makePayment" :data-secret="intent.client_secret" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Make payment
                    </button>
                </div>
            </div>
        </Sidebar>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/inertia-vue3';

export default defineComponent({
    props: [
        'intent',
        'profile',
        'plans'
    ],

    components: {
        AppLayout,
        Link,
    },

    data(){
        return{
            uploading: false,
            isVisible: false,
            stripe: null,
            cardElement: null,

            plan_selected: null,
        }
    },

    created() {
        this.stripe = Stripe('pk_test_51KOnyzLwFtk4DPRSHivAFBz83Rxg1mz0ZJH3riFb77ajWuoPnL0JSkt6JWcPTRnoaedrcqZtyIfKnNQYxtrUnKHI00ao7pHqip');
    },

    methods: {
        subscribe(cardConfirm){
            try {
                let URL = '/dashboard/user/subscribe'

                let data = new FormData()

                let props = {
                    card: cardConfirm.setupIntent,
                    plan: this.plan_selected
                }

                data.append('props', JSON.stringify(props))
                
                axios.post(URL, data).then(response => {
                    console.log(response);
                })
            } catch (error) {
                console.log(error);
            }
        },

        makeVisibleCard(plan){
            this.plan_selected = plan
            this.isVisible = true

            setTimeout(() => {
                const elements = this.stripe.elements();
                this.cardElement = elements.create('card');
            
                this.cardElement.mount('#card-element');
            }, 1000);
        },

        makePayment(){
            try {
                const cardButton = document.getElementById('card-button');
                const clientSecret = cardButton.dataset.secret;

                this.stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: this.cardElement,
                            billing_details: { name: this.profile.name + ' ' + this.profile.last_name }
                        }
                    }
                ).then(response => {
                    console.log(response);
                    this.subscribe(response)
                }).catch(error => {
                    console.log(error);
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
