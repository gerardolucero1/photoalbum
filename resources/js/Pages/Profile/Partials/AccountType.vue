<template>
    <div>
        <div>
            <h2 class="text-2xl font-bold">Tipo de cuenta:
                <Badge :value="plan.name" severity="success" />
            </h2>
        </div>
        <div class="mt-2">
            <p class="text-md font-extralight">Espacio en disco: {{ value }} Mb</p>
            <progress style="width: 100%;" :max="plan.disk_space" :value="value">
            </progress>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'profile',
        'plan'
    ],

    data(){
        return{
            value: 1000,
        }
    },

    created(){
        this.getTotalSize()
    },

    methods: {
        getTotalSize(){
            try {
                let URL = '/dashboard/profiles/get-total-size'

                axios.get(URL).then(response => {
                    console.log(response);
                    this.value = response.data
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