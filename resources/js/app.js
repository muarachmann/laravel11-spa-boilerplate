import './pusher';
import '../assets/sass/app.scss';

import Vue from "vue";
import PortalVue from "portal-vue"
import VueMeta from "vue-meta"
import { createInertiaApp, Link } from '@inertiajs/vue2'
import * as Sentry from "@sentry/browser"
import Notifications from 'vue-notification'
import Vuelidate from "vuelidate"
import VueTelInput from "vue-tel-input"
import VueClipboard from 'vue-clipboard2'
import store from "./store";
import RolesPermissions from "./shared/helpers/RolesPermissions.vue"
import "./global-components"
import "./utils"
import i18n from "./i18n"

window.Vue = Vue;
Vue.config.productionTip = false
Vue.use(Vuelidate)
Vue.mixin({ methods: { route: window.route } })
Vue.use(PortalVue)
Vue.use(Notifications)
Vue.use(VueTelInput)
Vue.use(VueMeta)
VueClipboard.config.autoSetContainer = true
Vue.use(VueClipboard)
Vue.mixin(RolesPermissions)
Vue.component("inertia-link", Link)

Pusher.logToConsole = (import.meta.env.VITE_APP_ENV !== "production")

Sentry.init({ dsn: import.meta.env.VITE_SENTRY_LARAVEL_DSN })

createInertiaApp({
    progress: { delay: 250, color: "#990011", showSpinner: true },
    resolve: name => {
        const pages = import.meta.glob('./pages/**/*.vue', { eager: true })
        return pages[`./pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
        Vue.use(plugin)
        new Vue({
            store,
            i18n,
            metaInfo: {
                titleTemplate: title => title ? `${title} | ${window.app_name}` : window.app_name,
            },
            render: h => h(App, props),
        }).$mount(el)
    },
})
