<template>
    <div :id="id" class="modal z-9999" role="dialog" tabindex="-1">
        <div class="modal__content modal__content-lg px-8 py-3 relative">
            <a class="absolute right-0 top-0 mt-3 mr-3" href="javascript:;" @click="closeModal()">
                <Icon class="w-5 h-5 text-gray-500" name="x"/>
            </a>
            <div class="h-64 flex w-full items-center justify-center">
                <div class="p-10 md:p-20 flex flex-col">
                    <img :src="'/images/logo.png'" class="w-10 h-10 md:w-20 md:h-20" alt="Loading">
                    <p>
                        This is a default modal
                        Feel fee to change the content here
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "DefaultModal",
    props: {
        id: {
            type: String,
            default: 'default-modal'
        },
    },
    data() {
        return {
           //
        }
    },
    methods: {
        openModal() {
            $("#" + this.id).modal("show")
        },
        closeModal() {
            $("#" + this.id).modal("hide")
        },
    }
}
</script>

<style scoped>

</style>
