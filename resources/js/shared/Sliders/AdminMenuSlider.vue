<template>
    <SliderLayout ref="dashboardSliderLayout" @is-open="open">
        <admin-side-menu/>
    </SliderLayout>
</template>

<script>

import LanguageSwitcher from "../../shared/LanguageSwitcher.vue"
import AdminSideMenu from "../Menu/AdminSideMenu.vue";
import SliderLayout from "../Sliders/SliderLayout.vue";

export default {
    name: "AdminMenuSlider",
    components: {
        SliderLayout,
        AdminSideMenu,
        LanguageSwitcher,
    },
    data() {
        return {
            isOpen: false
        }
    },
    watch: {
        isOpen: function(value) {
            if (value) {
                setTimeout(() => {
                    if (this.$page.props.auth) {
                        $('#content-body').css('height', `calc(100vh - ${$('#content-header').height() + $('#content-footer').height()}px)`)
                    }
                    else {
                        $('#content-body').css('height', `calc(100vh - ${$('#content-header').height()}px)`)
                    }

                }, 1000)
            }
        },
    },
    methods: {
        toggleMenu() {
            this.$refs.dashboardSliderLayout.toggleMenu()
        },
        open(value) {
            this.isOpen = value
        },
    },
}
</script>

<style scoped>
     .menu-item {
        @apply flex items-center justify-center text-white gap-1 text-xs font-bold uppercase block;
    }
</style>
