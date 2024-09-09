<template>
    <header class="sticky top-0 z-1000 shadow-md bg-gray-50 dark:bg-dark-1">
        <div class="flex items-center justify-between p-2">
            <!-- Mobile menu button -->
            <div v-if="device_type() === 3" class="p-1" v-on:click="$parent.$refs.dashboardSideMenu.collapseMenu()">
                <span class="sr-only">Open main menu</span>
                <icon name="menu-alt-2" class="md:hidden w-8 h-8"/>
            </div>
            <div v-if="device_type() === 3" class="font-bold text-center text-lg text-theme-1">ADMIN DASHBOARD</div>
            <div v-else class="px-2">
                <div class="flex inline-flex items-center space-x-2">
                    <div v-on:click="$parent.$refs.dashboardSideMenu.collapseMenu()">
                        <icon name="menu-bars" class="cursor-pointer w-6 h-6"/>
                    </div>
                </div>
            </div>
            <div v-if="device_type() === 3" class="w-10 h-10 rounded-full border border-theme-3">
                <dropdown placement="bottom-end">
                    <avatar :image="$page.props.auth.user.image" size="10"/>
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
            <!-- Desktop Right buttons -->
            <nav aria-label="Secondary" class="hidden md:flex items-center align-center justify-center">
                <LanguageSwitcher/>
                <div class="bg-blue-100 dark:bg-black bg-opacity-80 rounded px-3 mx-2">
                    <button class="inline-flex p-2 transition-colors duration-200 rounded-full focus:outline-none focus:bg-primary-100 dark:focus:bg-primary-dark focus:ring-primary-darker">
                      <span class="sr-only">Open search panel</span>
                      <icon name="search" class="w-5 h-5"/>
                    </button>
                    <div class="relative inline-flex p-2 cursor-pointer duration-200 rounded-full focus:outline-none focus:bg-primary-100 dark:focus:bg-primary-dark focus:ring-primary-darker">
                        <dropdown placement="bottom-end">
                            <div class="relative">
                                <div class="absolute -right-2 -top-3">
                                    <span style="font-size: 9px !important;" class="inline-flex items-center px-1.5 border-1 border-white rounded-full font-semibold bg-red-500 text-white">
                                      {{$h.kNumber(9999) }}
                                    </span>
                                </div>
                                <span class="sr-only">Open Notification panel</span>
                                <icon name="bell" class="w-6 h-6"/>
                            </div>
                            <div slot="dropdown"
                                 class="-mt-4 py-2 shadow-xl rounded bg-white dark:bg-dark-2 text-sm relative">
                                <div class="relative inline-block ">
                                    <!-- Dropdown menu -->
                                    <div class="absolute right-0 w-64 max-h-[350px] z-20 p-4 overflow-scroll-container overflow-y-scroll bg-white rounded-md shadow-xl dark:bg-gray-800">
                                        <div class="px-4.5 py-3">
                                            <h5 class="text-sm font-medium">Notifications</h5>
                                        </div>
                                        <ul class="flex flex-col">
                                            <li v-for="i in 5">
                                                <a class="flex flex-col gap-2.5 border-t border-stroke px-4.5 py-3 hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4" href="#">
                                                    <div class="text-sm">
                                                        <h4 class="font-bold">Notification Title</h4>
                                                        <p>
                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                                        </p>
                                                    </div>
                                                    <p class="text-xs">09 Sep, 2024</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </dropdown>
                    </div>
                </div>
                <div class="relative">
                    <dropdown placement="bottom-end">
                        <avatar :image="$page.props.auth.user.image" size="10"/>
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
            </nav>
        </div>
    </header>
</template>

<script>
import DarkModeSwitcher from "../../shared/DarkModeSwitcher.vue";
import LanguageSwitcher from "../../shared/LanguageSwitcher.vue";

export default {
    name: "AdminHeader",
    components: {
        LanguageSwitcher,
        DarkModeSwitcher
    },
    methods: {
        logoutUser() {
            this.$inertia.post(this.route('guest.logout'))
        }
    }
}
</script>

<style scoped>

</style>
