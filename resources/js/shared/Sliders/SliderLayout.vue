<template>
    <div>
        <div v-show="isOpen" @click="toggleMenu(false)" class="md:hidden z-40" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: black; opacity: .2;"></div>
        <aside
            id="slider"
            :class="`overflow-hidden h-screen block md:hidden fixed top-0 ${position} bottom-0 w-80 bg-white z-50 ${!isOpen ? 'close-slider-animation' : 'open-slider-animation'}`">
            <slot></slot>
        </aside>
    </div>
</template>

<script>

export default {
    name: "SliderLayout",
    props: {
        position: {
            type: String,
            default: 'left-0'
        },
        remove_overflow: {
            type: Boolean,
            default: true
        }
    },
    data() {
        return {
            isOpen: false,
        }
    },
    methods: {
        toggleMenu() {
            this.isOpen = !this.isOpen
            let body = $("body");
            if (this.isOpen) {
                if (!body.hasClass('overflow-hidden')) {
                    body.addClass('overflow-hidden')
                }
            }
            else {
                if (this.remove_overflow) {
                    body.removeClass('overflow-hidden')
                }
            }
            this.$emit('is-open', this.isOpen)
        },
    },
    beforeDestroy() {
        let body = $("body");
        if (this.remove_overflow && body.hasClass('overflow-hidden')) {
            body.removeClass('overflow-hidden')
        }
    },
    mounted() {
        document.addEventListener("keydown", e => {
            if (e.code === '27' && this.isOpen) this.isOpen = false;
        })
    }
}
</script>

<style scoped>
    .open-slider-animation {
        transition-timing-function: cubic-bezier(.4,0,.2,1);
        transition-duration: .5s;
        transform: translateX(0px) translateY(0) rotate(0) skewX(0) skewY(0) scaleX(1) scaleY(1);
    }

    .close-slider-animation {
        transition-timing-function: cubic-bezier(.4,0,.2,1);
        transition-duration: .5s;
        transform: translateX(-100%) translateY(0) rotate(0) skewX(0) skewY(0) scaleX(1) scaleY(1);
    }

</style>
