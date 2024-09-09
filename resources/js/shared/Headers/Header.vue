<template>
    <nav id="app-header" class="sticky top-0 inset-x-0 z-999 default-gradient-inverse dark:bg-black shadow">
        <div class="relative max-w-7xl mx-auto px-2 sm:px-4">
            <div id="w-sub-header" class="flex justify-between h-20">
                <div class="flex px-2 lg:px-0">
                    <div class="shrink-0 flex items-center">
                        <inertia-link :href="route('guest.index')">
                            <img :alt="$page.props.app_name" id="w-sub-header-logo" class="block h-8 w-auto sm:h-12" :src="'/images/logo.png'">
                        </inertia-link>
                        <span class="font-bold mx-2 font-lg">{{ $page.props.app_name }}</span>
                    </div>
                </div>
                <div class="flex items-center lg:hidden">
                    <button type="button"
                            class="inline-flex items-center justify-center p-2 rounded-md text-skin-muted hover:text-skin-base focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500"
                            aria-controls="mobile-menu" @click="is_open = !is_open" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <icon name='menu-alt-2' class="h-6 w-6 block"
                            :class="{ 'hidden': is_open, 'block': !(is_open) }"/>
                        <icon name='x' class="h-6 w-6 block" :class="{ 'block': is_open, 'hidden': !(is_open) }"/>
                    </button>
                </div>
                <div v-if="!$page.props.auth.user" class="hidden lg:ml-6 lg:flex lg:items-center">
                    <div class="relative flex items-center space-x-2 font-sans">
                        <language-switcher/>
                        <inertia-link
                            :href="route('guest.register')"
                            class="py-2 px-4 inline-flex items-center text-sm font-bold">
                            {{ $t('general.register') }}
                        </inertia-link>
                        <inertia-link
                            :href="route('guest.login')"
                            class="bg-theme-1 text-white py-2 px-4 rounded-md inline-flex items-center text-sm font-bold">
                            {{ $t('general.login') }}
                        </inertia-link>
                    </div>
                </div>
                <div v-else class="hidden lg:ml-6 lg:flex lg:items-center space-x-4">
                    <language-switcher/>
                    <dropdown placement="bottom-end">
                        <avatar :image="$page.props.auth.user.image"/>
                        <div slot="dropdown"
                            class="-mt-4 py-2 shadow-xl rounded bg-white dark:bg-dark-2 text-sm relative">
                            <div class="relative inline-block ">
                                <!-- Dropdown menu -->
                                <div
                                    class="absolute right-0 w-64 z-20 py-2 overflow-hidden bg-white rounded-md shadow-xl dark:bg-gray-800">
                                    <div class="flex items-center p-3 -mt-2 text-sm text-gray-600 transition-colors duration-200 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                        <avatar :image="$page.props.auth.user.image" size="9"/>
                                        <div class="mx-2">
                                            <h1 class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                                                {{ $page.props.auth.user.name }}
                                            </h1>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $page.props.auth.user.email }}
                                            </p>
                                        </div>
                                    </div>
                                    <hr class="border-gray-200 dark:border-gray-700 ">
                                    <inertia-link v-if="hasRole('owner|admin')"
                                        :href="route('admin.dashboard')"
                                        class="flex items-center p-3 text-sm text-orange-600 hover:bg-orange-600 hover:text-white font-bold capitalize transition-colors duration-200 transform dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white">
                                        <icon name="profile" class="w-5 h-5 mx-1"/>
                                        <span class="mx-1">{{ $t('menu.admin_portal') }}</span>
                                    </inertia-link>
                                    <inertia-link href="#"
                                        class="flex items-center p-3 text-sm text-gray-600 capitalize transition-colors duration-200 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                        <svg class="w-5 h-5 mx-1" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M21 19H3C1.89543 19 1 18.1046 1 17V16H3V7C3 5.89543 3.89543 5 5 5H19C20.1046 5 21 5.89543 21 7V16H23V17C23 18.1046 22.1046 19 21 19ZM5 7V16H19V7H5Z"
                                                fill="currentColor"></path>
                                        </svg>
                                        <span class="mx-1">Keyboard shortcuts</span>
                                    </inertia-link>
                                    <hr class="border-gray-200 dark:border-gray-700 ">
                                    <inertia-link href="#"
                                        class="flex items-center p-3 text-sm text-gray-600 capitalize transition-colors duration-200 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                        <dark-mode-switcher/>
                                        <span class="mx-1">Switch Dark theme</span>
                                    </inertia-link>
                                    <inertia-link href="#" @click.prevent="logoutUser"
                                        class="flex items-center p-3 text-sm text-gray-600 capitalize transition-colors duration-200 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                        <icon name="logout" class="w-5 h-5 mx-1 text-red-700"/>
                                        <span class="mx-1">Sign Out</span>
                                    </inertia-link>
                                </div>
                            </div>
                        </div>
                    </dropdown>
                </div>
            </div>
        </div>
        <div v-show="is_open" class="lg:hidden font-sans" id="mobile-menu" style="display: none;">
            <div class="pt-4 pb-3 border-t border-skin-light">
                <div class="space-y-1">
                    <a :href="route('guest.login')" class="block px-4 py-2 text-base font-medium text-skin-menu hover:text-skin-menu-hover">Login</a>
                    <a :href="route('guest.register')" class="block px-4 py-2 text-base font-medium text-flag-green">Create an Account</a>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import LanguageSwitcher from "../../shared/LanguageSwitcher.vue"
import CurrencyDropDown from "../CurrencyDropDown.vue"
import {mixin as clickaway} from 'vue-clickaway'
import DarkModeSwitcher from "../DarkModeSwitcher.vue";
import cash from "cash-dom/dist/cash";

export default {
    name: "Header",
    mixins: [clickaway],
    components: {
        DarkModeSwitcher,
        LanguageSwitcher,
        CurrencyDropDown,
    },
    data() {
        return {
            is_open: false,
            flyoutMenu: false
        }
    },
    mounted() {
        this.scrollListener()
    },
    methods: {
        scrollListener() {
            window.addEventListener('scroll', function () {
                let globalHeader = cash("#app-header")
                let subHeader =  cash("#w-sub-header")
                let headerLogo = cash('#w-sub-header-logo')

                if ((window.scrollY + 10) > (globalHeader.outerHeight())) {
                    globalHeader.removeClass('default-gradient-inverse').addClass("bg-white")
                }

                if ((window.scrollY + 10) < (globalHeader.outerHeight())) {
                    globalHeader.addClass('default-gradient-inverse').removeClass("bg-white")
                }
            })
        },
        logoutUser() {
            this.$inertia.post(this.route('guest.logout'))
        },
    }
}
</script>

<style scoped>

</style>
