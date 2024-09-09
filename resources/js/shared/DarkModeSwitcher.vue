<template>
    <div
        id="global_theme_toggle"
        v-on:click="toggle"
        class="cursor-pointer flex items-center justify-center rounded-full w-8 h-8 p-1">
        <icon :class="getColor" name="light-bulb" class="flex items-center"/>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import i18n from "../i18n"
export default {
    name: "DarkModeSwitcher",
    props: {
        color: null,
    },
    computed: {
        ...mapGetters({theme: "getTheme"}),
        getColor() {
            return this.color !== null ? this.color : "text-black";
        },
    },
    mounted() {
        this.toggleThemeBackground(this.$store.getters.getTheme)
    },
    watch: {
        theme(newTheme) {
            this.toggleThemeBackground(newTheme)
        },
    },
    methods: {
        toggle() {
            this.$store.dispatch("toggleTheme");
            this.$notify({
                title: "Dark mode",
                text: "Dark mode activated. You can always change this.",
            })
        },
        toggleThemeBackground(theme) {
            let toggle = $("#global_theme_toggle");
            theme === "light" ?
                toggle.removeClass("bg-yellow-300 bg-opacity-80") :
                toggle.addClass("bg-yellow-300 bg-opacity-80")
        }
    },
}
</script>

<style scoped>

</style>
