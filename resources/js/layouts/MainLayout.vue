<template>
    <div class="w-full h-full dark:bg-gray-800">
        <portal-target name="dropdown" slim/>
        <FlashMessages/>
        <Header/>
        <section class="overflow-scroll-container overflow-x-hidden overflow-y-scroll">
            <slot/>
        </section>
        <Footer/>
    </div>
</template>

<script>
import FlashMessages from "../shared/helpers/FlashMessages.vue"
import Header from "../shared/Headers/Header.vue"
import Footer from "../shared/Footers/Footer.vue"
import {mapGetters} from "vuex"

export default {
    name: "MainLayout",
    beforeMount() {
        this.$store.dispatch("initTheme")
        this.$h.hackConsoleWarning()
    },
    components: {
        FlashMessages,
        Header,
        Footer,
    },
    computed: {
        ...mapGetters({theme: "getTheme"}),
    },
    created() {
        $('body').removeClass('overflow-hidden')
    },
    watch: {
        theme(newTheme, oldTheme) {
            let html = $("html");
            newTheme === "light" ? html.removeClass("dark") : html.addClass("dark")
        },
    },
}
</script>

<style scoped>
</style>
