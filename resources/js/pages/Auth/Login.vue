<template>
    <div class="flex items-center justify-center relative overflow-hidden bg-no-repeat bg-cover h-screen">
        <div class="w-full max-w-lg p-8 justify-items-center bg-white rounded shadow-2xl -mt-4 md:-mt-20">
            <form class="w-full flex flex-col items-center" @submit.prevent="login">
                <div class="w-full px-8 pb-6">
                    <h1 class="text-center font-bold text-3xl mt-8">{{ $t('general.sign_in') }}</h1>
                    <div class="mx-auto mt-4 w-24 border-b-2"></div>
                    <div v-if="$page.props.flash.error" class="w-full my-5 py-5 px-3 text-gray-800 bg-red-100 border border-red-200 rounded-lg" role="alert">
                        <p class="font-bold text-red-600 underline my-1">{{ $t('general.oops_error') }}</p>
                        <p class="text-red-800" v-html="$page.props.flash.error"/>
                    </div>
                    <div v-if="$page.props.flash.success" class="w-full my-5 py-5 px-3 text-gray-800 bg-green-100 border border-green-200 rounded-lg" role="alert">
                        <p class="font-bold text-green-600 underline my-1">{{ $t('general.success') }}</p>
                        <p class="text-green-800" v-html="$page.props.flash.success"/>
                    </div>
                    <div class="w-full grid grid-cols-6 gap-6 mt-10">
                        <div class="col-span-6">
                            <global-input
                                v-model="loginForm.email"
                                :error="errors.email"
                                :label="$t('forms.email_or_username')"
                                :placeholder="'you@app.com'"
                                required
                            />
                        </div>
                        <div class="col-span-6">
                            <global-input
                                v-model="loginForm.password"
                                type="password"
                                :error="errors.password"
                                :label="$t('forms.password')"
                                :placeholder="$t('forms.secret')"
                                required
                            />
                        </div>
                    </div>
                    <div class="mt-5 flex items-end text-right">
                        <inertia-link :href="route('guest.password.request')"  class="text-sm font-semibold leading-relaxed">
                            {{ $t('general.forgot_your_password') }}
                            <span class="text-theme-1">{{ $t('general.click_here') }}</span>
                        </inertia-link>
                    </div>
                    <div class="flex flex-row w-full items-center justify-between my-10">
                        <div class="items-center">
                            <a :href="route('guest.social.auth', 'google')"
                               class="h-10 w-10 inline-block p-1 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md transition duration-150 ease-in-out mx-2">
                                <img :src="'/images/socials/google.png'" alt="facebook-login">
                            </a>
                            <a :href="route('guest.social.auth', 'facebook')"
                               class="h-10 w-10 inline-block p-1 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md transition duration-150 ease-in-out mx-2">
                                <img :src="'/images/socials/facebook.png'" alt="face-login">
                            </a>
                        </div>
                        <button type="submit" class="w-full inline-flex items-center justify-center text-center px-5 py-3 text-white transition duration-500 ease-in-out transform bg-gray-900 border-gray-700 rounded md:w-auto focus:shadow-outline focus:outline-none focus:ring-2 ring-offset-current ring-offset-2 hover:bg-theme-3">
                            {{ $t('general.login') }}
                            <icon v-if="loginForm.processing" :class="loginForm.processing ? 'animate-spin' : ''" name="circle-loader" class="w-5 h-5 mx-2"/>
                            <icon v-else name="arrow-narrow-right" class="w-5 h-5 mx-4 -mt-0.5"/>
                        </button>
                    </div>
                    <div class="mt-5 flex items-end text-right">
                        <inertia-link :href="route('guest.register')"  class="text-sm font-semibold leading-relaxed">
                            {{ $t('general.dont_have_an_account') }}
                            <span class="text-theme-1">{{ $t('general.register') }}</span>
                        </inertia-link>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>

import MainLayout from '../../layouts/MainLayout.vue'
import i18n from "../../i18n"

export default {
    name: "Login",
    metaInfo: {
        title: i18n.t('general.login')
    },
    props: {
        errors: Object,
    },
    layout: MainLayout,
    data() {
        return {
            togglePassword: false,
            loginForm: this.$inertia.form({
                email: null,
                password: null,
                remember: false,
            }),
        }
    },
    methods: {
        login() {
            this.loginForm.post(this.route('guest.login.post'))
        },
    },
}
</script>
