<template>
    <div>
        <Head :title="title" />

        <jet-banner />

        <div class="min-h-screen bg-white">
            <header class="grid grid-cols-12 gap-4 bg-white shadow-md">
                <div class="logo col-span-1 p-1">
                    <Link :href="route('web.index')" class="mt-2 flex justify-center items-center">
                        <i class="fas fa-camera-retro"></i>
                        <p class="ml-1 mt-0.5 font-bold">Photoalbum</p>
                    </Link>
                </div>
                <div class="logo col-span-6 p-1 flex justify-center items-center">
                    <input type="search" class="w-full rounded-full border-0 bg-slate-200 focus:border-0">
                </div>
                <div class="logo col-span-1 p-1 flex justify-around items-center">
                    <p><i class="fab fa-facebook-square"></i></p>
                    <p><i class="fab fa-instagram"></i></p>
                    <p><i class="fab fa-twitter-square"></i></p>
                </div>
                <div class="logo col-span-2 p-1 flex justify-around items-center">
                    <p>Blog</p>
                    <p>Descubre</p>
                    <p>Anuncios</p>
                </div>
                <div class="logo col-span-2 p-1 flex justify-center items-center" v-if="$page.props.user">
                    <div class="ml-3 relative">
                        <jet-dropdown align="right" width="48">
                            <template #trigger>
                                <button  class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_path" :alt="$page.props.user.name" />
                                    <span class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                        <div>
                                            <span>{{ $page.props.user.name }}</span>
                                        </div>
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </button>
                            </template>

                            <template #content>
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Administrar cuenta
                                </div>

                                <jet-dropdown-link :href="route('dashboard')">
                                    Dashboard
                                </jet-dropdown-link>

                                <jet-dropdown-link :href="route('web.profile', $page.props.user.id)">
                                    Perfil
                                </jet-dropdown-link>

                                <jet-dropdown-link :href="route('api-tokens.index')" v-if="$page.props.jetstream.hasApiFeatures">
                                    API Tokens
                                </jet-dropdown-link>

                                <div class="border-t border-gray-100"></div>

                                <!-- Authentication -->
                                <form @submit.prevent="logout">
                                    <jet-dropdown-link as="button">
                                        Salir
                                    </jet-dropdown-link>
                                </form>
                            </template>
                        </jet-dropdown>
                    </div>
                </div>
                <div class="logo col-span-2 p-1 flex justify-end items-center" v-else>
                    <Link :href="route('login')" class="text-sm text-gray-700">
                        Iniciar sesion
                    </Link>

                    <Link :href="route('register')" class="ml-4 text-sm text-gray-700">
                        Registrarse
                    </Link>
                </div>
            </header>
            <!-- Page Content -->
            <main>
                <slot></slot>
            </main>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import JetApplicationMark from '@/Jetstream/ApplicationMark.vue'
import JetBanner from '@/Jetstream/Banner.vue'
import JetDropdown from '@/Jetstream/Dropdown.vue'
import JetDropdownLink from '@/Jetstream/DropdownLink.vue'
import JetNavLink from '@/Jetstream/NavLink.vue'
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default defineComponent({
    props: {
        title: String,
    },

    components: {
        Head,
        JetApplicationMark,
        JetBanner,
        JetDropdown,
        JetDropdownLink,
        JetNavLink,
        JetResponsiveNavLink,
        Link,
    },

    data() {
        return {
            showingNavigationDropdown: false,
        }
    },

    methods: {
        switchToTeam(team) {
            this.$inertia.put(route('current-team.update'), {
                'team_id': team.id
            }, {
                preserveState: false
            })
        },

        logout() {
            this.$inertia.post(route('logout'));
        },
    }
})
</script>
