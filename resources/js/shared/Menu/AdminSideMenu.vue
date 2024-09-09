<template>
    <aside
        :class="!isMenuCollapsed ? 'w-64' : ''"
        class="sidebarMenu h-screen bg-gray-100 dark:bg-black shadow-md flex-shrink-0 border-0">
        <div class="flex flex-col h-full relative">
            <div v-if="isMenuCollapsed" class="flex flex-row text-center justify-center items-center my-2">
                <inertia-link
                    class="flex flex-row text-center justify-center items-center"
                    :href="route('admin.dashboard')"
                    target="_blank">
                    <img :alt="$page.props.app_name" :src="$page.props.logo" class="block items-center w-10 h-10">
                </inertia-link>
            </div>
            <div v-else class="bg-gray-50 dark:bg-black rounded">
                <a :href="route('admin.dashboard')"
                   class="flex flex-row p-2 items-center font-medium tracking-tighter transition duration-500 ease-in-out transform cursor-pointer ">
                    <div class="bg-gray-300 text-white p-2 rounded-md shadow-sm">
                        <img :alt="$page.props.app_name"  :src="$page.props.logo" class="block items-center w-6 h-6">
                    </div>
                    <div class="flex flex-col justify-center uppercase mx-2">
                        <span>{{ $t('menu.dashboard') }}</span>
                        <div class="flex flex-row">
                            <div class="text-theme-3 dark:text-white text-lg font-bold">ADMIN</div>&nbsp;
                            <div class="text-theme-1 text-lg font-bold"> {{ 'PORTAL' }}</div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Sidebar links -->
            <nav aria-label="Admin main menu"
                 class="overflow-scroll-container text-gray-500 dark:text-gray-300 font-medium flex-1 px-2 space-y-1.5 overflow-y-hidden hover:overflow-y-scroll flex-shrink-0">
                <!-- home and dashboard !-->
                <div class="app-menu-item mt-2">
                    <div
                        v-if="!isMenuCollapsed"
                        v-on:click="toggleTopMenu('general')"
                        class="hover:rounded-tr-2xl hover:bg-theme-2 dark:hover:bg-black hover:cursor-pointer px-4 py-4 flex flex-row items-center justify-between">
                        <div class="items-center">
                            <h1 class="text-theme-1 dark:text-orange-200 text-xs uppercase font-bold">
                                {{ $t('menu.general') }}
                            </h1>
                        </div>
                        <icon :class="{ 'rotate-180': topMenu.includes('general') }"
                              class="w-4 h-4 transition-transform transform"
                              name="chevron-down"/>
                    </div>
                    <transition name="slide_x">
                        <div v-if="topMenu.includes('general')" class="pl-2">
                            <inertia-link
                                v-tippy="{ a11y : false, arrow : true }"
                                :content="$t('menu.dashboard')"
                                :href="route('admin.dashboard')"
                                :class="menuClass() + activeMenuClass('admin.dashboard')">
                                        <span aria-hidden="true">
                                            <icon name="home" :class="isMenuCollapsed ? 'w-6 h-6' : 'w-5 h-5'"/>
                                        </span>
                                <span :class="isMenuCollapsed ? 'hidden': ''" class="ml-2 text-sm">{{ $t('menu.dashboard') }}</span>
                            </inertia-link>
                        </div>
                    </transition>
                </div>

                <!-- users and business !-->
                <div class="app-menu-item">
                    <div
                        v-if="!isMenuCollapsed"
                        v-on:click="toggleTopMenu('users')" class="hover:bg-theme-2 dark:hover:bg-black hover:cursor-pointer px-4 py-2 flex flex-row items-center justify-between">
                        <div class="items-center">
                            <h1 class="text-theme-1 dark:text-orange-200 text-xs uppercase font-bold">
                                {{ $t('menu.users_and_sub_menu') }}
                            </h1>
                        </div>
                        <icon :class="{ 'rotate-180': topMenu.includes('users') }"
                              class="w-4 h-4 transition-transform transform"
                              name="chevron-down"/>
                    </div>
                    <transition name="slide_x">
                        <div v-if="topMenu.includes('users')" class="pl-2">
                            <div v-if="hasRole('owner|admin')">
                                <global-side-menu :sideBarOpen="isMenuCollapsed" :menuItems="usersMenuItems" routeClass="admin.users.*"/>
                            </div>
                        </div>
                    </transition>
                </div>
            </nav>
            <!-- Sidebar footer -->
            <footer class="flex items-center justify-center p-4 bg-white dark:bg-dark-2 border-t dark:bg-darker dark:border-primary-darker">
                <div v-if="isMenuCollapsed" class="w-6 h-6">
                    <a href="https://muarachmann.com" target="_blank">
                        <icon v-if="isMenuCollapsed" name="logo" class="w-6 h-6"/>
                    </a>
                </div>
                <div v-else class="text-center">
                    With ❤️ and ☕️ by <a href="https://muarachmann.com" target="_blank" class="text-theme-1 hover:underline">@muarachmann</a>
                </div>
            </footer>
        </div>
    </aside>
</template>

<script>
    import i18n from "../../i18n.js";

    export default {
        name: "AdminSideMenu",
        data() {
            return {
                newNotification: false,
                isMenuCollapsed: !(this.device_type() !== 3),
                // todo .. menus that will be open by default
                topMenu: ['general', 'users'],
                open_menus: [],
                usersMenuItems: [
                    {
                        label: i18n.tc('menu.user', 2),
                        submenuOpen: false,
                        link: '#',
                        icon: 'users',
                        submenuItems: [
                            {
                                label: 'All Users',
                                link: this.route('admin.users.index'),
                                icon: ''
                            },
                            {
                                label: 'Thrashed Users',
                                link: this.route('admin.users.index'),
                                icon: ''
                            },
                        ]
                    }
                ],
            }
        },
        mounted() {
            setTimeout(() => this.toggleRoutes(), 500)
        },
        methods: {
            toggleTopMenu(menu) {
                // todo shuffle menus and open similar menus
                this.topMenu.push(menu)
            },
            menuClass() {
                return 'flex flex-row items-center p-2 font-semibold hover:font-bold hover:text-gray-800 dark:hover:text-yellow-300 '
            },
            activeMenuClass(route) {
                return this.route().current(route) ? 'text-gray-900 font-bold dark:text-yellow-300' : 'text-gray-500'
            },
            url() {
                return location.pathname.substr(1);
            },
            isUrl(...urls) {
                if (urls[0] === '') {
                    return this.url() === ''
                }
                return urls.filter(url => this.url().startsWith(url)).length
            },
            logout() {
                this.$inertia.post(this.route('admin.logout'))
            },
            toggleMenu(type) {
                if (this.open_menus.includes(type)) {
                    this.open_menus.splice(this.open_menus.indexOf(type), 1);
                    return;
                }
                this.open_menus.push(type);
            },
            toggleRoutes() {
                if (this.route().current('admin.users.*')) {
                    this.open_menus.push('users')
                }
            },
            collapseMenu() {
                this.isMenuCollapsed = !this.isMenuCollapsed
            }
        }
    }
</script>

<style scoped>

    .slide_y-enter-active, .slide_y-leave-active {
        transition: transform 0.5s ease;
    }

    .slide_y-enter, .slide_y-leave-to {
        transform: translateY(-100%);
    }
    .slide_xs-enter-active, .slide_sx-leave-active {
        transition: transform 0.6s ease;
    }

    .slides_x-enter, .slide_sx-leave-to {
        transform: translateX(-100%);
    }
</style>
