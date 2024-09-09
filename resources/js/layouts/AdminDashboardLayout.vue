<template>
    <div class="h-screen overflow-hidden w-full bg-gray-100 bg-gradient-to-l dark:from-gray-600 dark:to-theme-2">
        <FlashMessages/>
        <div :class="isPlatformOnline ? 'hidden' : ''" class="absolute z-9999 left-1/2 transform -translate-x-1/2 top-2 m-auto px-4 bg-transparent">
            <div class="flex gap-4 bg-yellow-100 p-4 rounded-md shadow">
                <div class="w-max">
                    <div class="h-10 w-10 flex text-center items-center justify-center rounded-full bg-yellow-600 from-yellow-100 to-yellow-300 text-yellow-700">
                        <icon class="w-6 h-6 text-white" name="lightning-bolt"/>
                    </div>
                </div>
                <div class="space-y-1 text-sm">
                    <h6 class="font-medium text-yellow-900">{{ $t('general.oops_error') }}</h6>
                    <div ref="reload" v-html="$t('general.connection_lost_message', {minutes: '05:23s'})"/>
                </div>
            </div>
        </div>
        <portal-target ref="adminDropDown" name="dropdown" slim />
        <div class="flex h-full flex-shrink-0 text-gray-900 dark:text-theme-1">
            <admin-side-menu
                ref="dashboardSideMenu"
                v-if="hasRole('owner|admin')
                && device_type() !== 3"/>
            <div class="h-full w-full z-100 overflow-x-scroll">
                <admin-header/>
                <!-- Main content -->
                <main class="flex-1 w-full h-full pb-20 overflow-scroll-container overflow-x-hidden">
                    <div class="w-full px-5 py-4 pb-10">
                        <slot/>
                    </div>
                </main>
            </div>
            <PortalTarget name="sliders"/>
        </div>
    </div>
</template>

<script>
import FlashMessages from "../shared/helpers/FlashMessages.vue"
import DarkModeSwitcher from "../shared/DarkModeSwitcher.vue"
import AdminHeader from "../shared/Headers/AdminHeader.vue"
import AdminSideMenu from "../shared/Menu/AdminSideMenu.vue"
import { mapGetters } from "vuex"

export default {
    name: "AdminDashboardLayout",
    beforeMount() {
        this.$store.dispatch("initTheme")
        this.$h.hackConsoleWarning()
    },
    components: {
        AdminHeader,
        AdminSideMenu,
        DarkModeSwitcher,
        FlashMessages
    },
    data() {
        return {
            open: null,
            isNotificationsPanelOpen: false,
            isSidebarOpen: window.innerWidth >= 768,
            isUserPanelOpen: window.innerWidth >= 1280,
            isSettingsPanelOpen: false,
            isSearchPanelOpen: false,
            isMobileMainMenuOpen: false,
            open_menus: [],
            loadingSearchResults: false,
            searchResults: [],
            searchQuery: '',
            admin_notifications: [],
            isPlatformOnline: navigator.onLine,
        }
    },
    mounted() {
        let updateOnlineStatus = this.updateOnlineStatus
        window.addEventListener('load', function() {
            window.addEventListener('online',  updateOnlineStatus)
            window.addEventListener('offline',  updateOnlineStatus)
        })
        setTimeout(() => this.toggleRoutes(), 500)
        this.$refs['reload'].firstChild.addEventListener('click', (event) => {
            event.preventDefault()
            this.reloadPage()
        })
    },
    computed: {
        ...mapGetters({theme: "getTheme"}),
    },
    watch: {
        theme(newTheme, oldTheme) {
            let html = $("html");
            newTheme === "light" ? html.removeClass("dark") : html.addClass("dark")
        },
    },
    created() {
        $('body').addClass('overflow-hidden')
    },
    destroyed() {
        $('body').removeClass('overflow-hidden')
    },
    methods: {
        toggleMenu(type) {
            if (this.open_menus.includes(type)) {
                this.open_menus.splice(this.open_menus.indexOf(type), 1);
                return;
            }
            this.open_menus.push(type);
        },
        toggleRoutes() {
            // add routes you wish to be opened by default here
            // if (this.route().current('admin.users.*')) {
            //     this.open_menus.push('users_routes')
            // }
        },
        reloadPage() {
            this.$inertia.reload()
        },
        updateOnlineStatus() {
            this.isPlatformOnline = navigator.onLine
        },
    }
}
</script>

<style scoped>

</style>
