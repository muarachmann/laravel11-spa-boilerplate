<template>
    <div class="relative overflow-hidden bg-no-repeat bg-cover h-screen" style="background-color: #55c86f; background-image: linear-gradient(360deg, #55c86f 0%, #ececec 70%, #ffffff 100%);">
        <div class="grid grid-cols-1 justify-items-center">
            <div class="place-self-center mt-12 mb-10 lg:col-span-12 items-center">
                <div class="flex flex-col bg-white rounded shadow-2xl justify-center">
                    <form class="flex flex-col items-center" @submit.prevent="submit">
                        <div class="w-full mx-10 p-10">
                            <h1 class="text-center font-bold text-3xl mt-8">{{ $t('general.reset_password') }}</h1>
                            <div class="mx-auto mt-4 w-24 border-b-2"></div>
                            <div v-if="$page.props.flash.error" class="w-full my-5 py-5 px-3 text-gray-800 bg-red-100 border border-red-200 rounded-lg" role="alert">
                                <p class="font-bold text-red-600">{{ $t('general.oops_error') }}</p>
                                <p v-html="$page.props.flash.error"/>
                            </div>
                            <div class="w-full grid grid-cols-6 gap-6 mt-10">
                                <div class="col-span-6">
                                    <global-input
                                        v-model="form.password"
                                        type="password"
                                        :error="form.errors.password"
                                        :label="$t('forms.password')"
                                        :placeholder="$t('forms.secret')"
                                        required
                                    />
                                </div>
                                <div class="col-span-6">
                                    <global-input
                                        v-model="form.password_confirmation"
                                        type="password"
                                        :error="form.errors.password_confirmation"
                                        :label="$t('forms.password_confirmation')"
                                        :placeholder="$t('forms.secret')"
                                        required
                                    />
                                </div>
                            </div>
                            <div class="flex flex-col w-auto items-center justify-center my-4">
                                <button type="submit" class="w-full flex items-center justify-center text-center px-8 py-3 my-2 mr-2 text-base text-white transition duration-500 ease-in-out transform bg-gray-900 border-gray-700 rounded-md focus:shadow-outline focus:outline-none focus:ring-2 ring-offset-current ring-offset-2 hover:bg-theme-3">
                                    <icon v-if="form.processing" :class="form.processing ? 'animate-spin' : ''" name="circle-loader" class="w-5 h-5 mx-2 "/>
                                    {{ $t('general.reset_password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 justify-items-center">
            <div class="flex px-4 py-1.5 items-center rounded text-black text-sm font-bold justify-center">
                Powered by <a class="underline px-1" href="#">{{ $page.props.app_name }}</a>
            </div>
        </div>
    </div>
</template>

<script>
import MainLayout from '../../layouts/MainLayout.vue'
import i18n from "../../i18n"

export default {
    name: "ResetPasswordForm",
    metaInfo: {
        title: i18n.t('general.reset_password')
    },
    layout: MainLayout,
    props: {
        token: String,
        email: String,
    },
    data() {
        return {
            form: this.$inertia.form({
                password: null,
                password_confirmation: null,
                token: this.token,
                email: this.email
            })
        }
    },
    methods: {
        submit() {
           this.form.post(this.route('guest.password.update'))
        },
    },
}
</script>
