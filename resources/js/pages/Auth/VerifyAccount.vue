<template>
    <div class="relative overflow-hidden bg-no-repeat bg-cover h-screen" style="background-color: #55c86f; background-image: linear-gradient(360deg, #55c86f 0%, #ececec 70%, #ffffff 100%);">
        <div class="grid grid-cols-1 justify-items-center">
            <div class="place-self-center mt-12 mb-10 lg:col-span-12 items-center">
                <div class="max-w-xl flex flex-col bg-white rounded shadow-2xl justify-center">
                    <form class="max-w-xl flex flex-col items-center" @submit.prevent="sendVerificationEmail">
                        <div class="w-full mx-10 px-10 pb-6">
                            <h1 class="text-center font-bold text-3xl mt-8">{{ $t('general.verify_account') }}</h1>
                            <div class="mx-auto mt-4 w-24 border-b-2"></div>
                            <div v-if="$page.props.flash.error" class="w-full my-5 py-5 px-3 text-gray-800 bg-red-100 border border-red-200 rounded-lg" role="alert">
                                <p class="font-bold text-red-600">{{ $t('general.oops_error') }}</p>
                                <p v-html="$page.props.flash.error"/>
                            </div>
                            <div v-if="$page.props.flash.success" class="p-4 my-4 border border-green-300 rounded-lg bg-green-100 dark:bg-green-200" role="alert">
                                <div class="flex items-center">
                                    <svg aria-hidden="true" class="w-5 h-5 mr-2 text-green-700 dark:text-green-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                    <span class="sr-only">Info</span>
                                    <h3 class="text-lg font-medium text-green-700 dark:text-green-800">
                                        {{ $t('general.reset_link_title') }}!
                                    </h3>
                                </div>
                                <div v-html="$t('general.reset_link_paragraph', { email: $page.props.auth.user.email })" class="mt-2 mb-4 text-sm text-green-700 dark:text-green-800"/>
                                <div class="flex">
                                    <button
                                        @click="triggerForm"
                                        type="button" class="text-green-700 bg-transparent border border-green-700 hover:bg-green-800 hover:text-white focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:border-green-800 dark:text-green-800 dark:hover:text-white" data-dismiss-target="#alert-additional-content-3" aria-label="Close">
                                        {{ $t('general.resend') }}
                                    </button>
                                </div>
                            </div>
                            <div class="w-full grid grid-cols-6 gap-6 md:text-lg my-8">
                                <div class="col-span-6" v-html="$t('general.email_not_verified_text', {app_name: $page.props.app_name })"></div>
                            </div>
                            <div class="flex flex-col w-auto items-center justify-center my-4">
                                <button
                                    @click="triggerForm"
                                    :type="'submit'"
                                    class="w-full flex items-center justify-center text-center px-8 py-3 my-2 mr-2 text-base text-white transition duration-500 ease-in-out transform bg-gray-900 border-gray-700 rounded-md focus:shadow-outline focus:outline-none focus:ring-2 ring-offset-current ring-offset-2 hover:bg-theme-3">
                                    {{ $t('general.resend') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 justify-items-center">
            <div class="flex px-4 py-1.5 items-center rounded text-black text-sm font-bold justify-center">
                Powered by <a class="underline px-1" href="#">{{$page.props.app_name}}</a>
            </div>
        </div>
    </div>
</template>

<script>
import i18n from "../../i18n"
import MainLayout from '../../layouts/MainLayout.vue'

export default {
    name: "VerifyAccount",
    metaInfo: {
        title: i18n.t('general.verify_account')
    },
    layout: MainLayout,
    props: {
        errors: Object
    },
    data() {
        return {
            loginForm: this.$inertia.form({}),
            showVerifyForm: false
        }
    },
    methods: {
        triggerForm() {
            if (!this.showVerifyForm) {
                this.showVerifyForm = !this.showVerifyForm
            }
        },
        sendVerificationEmail() {
            this.loginForm.post(this.route('verification.send'))
        },
    },
}
</script>
