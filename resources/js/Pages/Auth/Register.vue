<style lang="scss" scoped>
    .bg-container{
        width: 100%;
        height: 100vh;
        background-image: url('https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80');
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;

        img{
            width: 100%;
            height: 100vh;
            object-fit: cover;
            object-position: center;
        }
    }

    .form-container{
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;

        form{
            width: 60%;

            .btn-submit{
                margin-top: 10px;
                width: 100%;
                background-color: #016EFC;
                font-weight: bold;
                padding: 5px 10px;
                color: white;
            }
        }
    }
</style>

<template>
    <Head title="Register" />
    <div>
        <div class="grid grid-cols-12">
            <div class="col-span-8">
                <div class="bg-container">
                    
                </div>
            </div>
            <div class="col-span-4">
                <div class="form-container">
                    <div class="logo-container">
                        <Link :href="route('web.index')">
                            <h1 class="font-bold mb-4">DOOYA</h1>
                            <!-- <img style="width: 100px;" src="https://static.wikia.nocookie.net/rocketpunch/images/4/4c/Rocket_Punch_Logo_2.png" alt=""> -->
                        </Link>
                    </div>
                    <div style="width: 80%;">
                        <jet-validation-errors class="mb-4" />

                        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                            {{ status }}
                        </div>

                        <div v-if="$page.props.flash" class="mb-4 font-medium text-sm text-green-600">
                            
                        </div>
                    </div>

                    <form @submit.prevent="submit">
                        <div>
                            <jet-label for="name" value="Nombre" />
                            <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
                        </div>

                        <div class="mt-4">
                            <jet-label for="email" value="Email" />
                            <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
                        </div>

                        <div class="mt-4">
                            <jet-label for="password" value="Contraseña" />
                            <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
                        </div>

                        <div class="mt-4">
                            <jet-label for="password_confirmation" value="Confirmar contraseña" />
                            <jet-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
                        </div>

                        <div class="mt-4" v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature">
                            <jet-label for="terms">
                                <div class="flex items-center">
                                    <jet-checkbox name="terms" id="terms" v-model:checked="form.terms" />

                                    <div class="ml-2">
                                        I agree to the <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Privacy Policy</a>
                                    </div>
                                </div>
                            </jet-label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">
                                Olvidaste tu contraseña?
                            </Link>
                        </div>
                        <div>
                            <button type="submit" class="btn-submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Registrarse
                            </button>
                        </div>
                        <div class="text-center mt-2">
                            <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900 text-center">
                                ¿Ya tinenes una cuenta? Inicia sesion.
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- <jet-authentication-card>
        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <jet-label for="name" value="Nombre" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
            </div>

            <div class="mt-4">
                <jet-label for="password" value="Contraseña" />
                <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <jet-label for="password_confirmation" value="Confirmar contraseña" />
                <jet-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="mt-4" v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature">
                <jet-label for="terms">
                    <div class="flex items-center">
                        <jet-checkbox name="terms" id="terms" v-model:checked="form.terms" />

                        <div class="ml-2">
                            I agree to the <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Privacy Policy</a>
                        </div>
                    </div>
                </jet-label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    ¿Ya estas registrado? Inicia sesion
                </Link>

                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Registrarse
                </jet-button>
            </div>
        </form>
    </jet-authentication-card> -->
</template>

<script>
    import { defineComponent } from 'vue'
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Head,
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
            Link,
        },

        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    terms: false,
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('register'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    })
</script>
