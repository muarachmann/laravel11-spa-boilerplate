<template>
    <div class="flex flex-col relative overflow-hidden bg-no-repeat bg-cover h-screen justify-between">
        <div class="grid grid-cols-1 justify-items-center">
            <div class="place-self-center mt-12 mb-10 lg:col-span-12 items-center">
                <div class="w-full flex flex-col bg-white rounded shadow-2xl justify-center">
                    This is the about page
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import MainLayout from "../layouts/MainLayout.vue"
import i18n from "../i18n";

export default {
    name: "About",
    layout: MainLayout,
    metaInfo: {
        title: i18n.t('menu.about')
    },
}

</script>
<style lang="scss" scoped>

</style>
