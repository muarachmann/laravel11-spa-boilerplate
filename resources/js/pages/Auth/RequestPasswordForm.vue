<template>
    <div class="flex items-center justify-center relative overflow-hidden bg-no-repeat bg-cover h-screen">
        <div class="w-full max-w-lg p-8 justify-items-center bg-white rounded shadow-2xl -mt-4 md:-mt-20">
            <form class="w-full flex flex-col items-center" @submit.prevent="submit">
                <div class="w-full px-8 pt-10 pb-4">
                    <h1 class="text-center font-bold text-3xl mt-8">{{ $t('general.forgot_password') }}</h1>
                    <div class="mx-auto mt-4 w-24 border-b-2"></div>
                    <div v-html="$t('general.forgot_password_text')" class="my-6 text-sm"/>
                    <div v-if="$page.props.flash.success" class="my-2 px-4 py-3 leading-normal text-green-700 bg-green-100 rounded-lg" role="alert">
                        <p class="font-bold">{{ $t('general.success') }}</p>
                        <p v-html="$page.props.flash.success"/>
                    </div>
                    <div v-if="form.errors.email" class="px-4 py-3 leading-normal text-red-700 bg-red-100 rounded-lg" role="alert">
                        <p class="font-bold">{{ $t('general.oops_error') }}</p>
                        <p v-html="form.errors.email"/>
                    </div>
                    <div class="w-full grid grid-cols-6 gap-6 mt-4 mb-6">
                        <div class="col-span-6">
                            <global-input
                                v-model="form.email"
                                :error="form.errors.email"
                                :label="$t('forms.email')"
                                :placeholder="'you@app.com'"
                                required
                            />
                        </div>
                    </div>
                    <div class="flex flex-col w-auto items-center justify-center my-4">
                        <button type="submit" class="w-full inline-flex items-center justify-center text-center px-8 py-3 my-2 mr-2 text-base text-white transition duration-500 ease-in-out transform bg-gray-900 border-gray-700 rounded-md focus:shadow-outline focus:outline-none focus:ring-2 ring-offset-current ring-offset-2 hover:bg-theme-3">
                            {{ $t('general.reset_password') }}
                            <icon v-if="form.processing" :class="form.processing ? 'animate-spin' : ''" name="circle-loader" class="w-5 h-5 mx-2"/>
                            <icon v-else name="arrow-narrow-right" class="w-5 h-5 mx-4 -mt-0.5"/>
                        </button>
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
    name: "ResetPassword",
    metaInfo: {
        title: i18n.t('general.reset_password')
    },
    layout: MainLayout,
    data() {
        return {
            form: this.$inertia.form({ email: null })
        }
    },
    methods: {
        submit() {
            this.form.post(this.route('guest.password.request.send'))
        }
    },
}
</script>
