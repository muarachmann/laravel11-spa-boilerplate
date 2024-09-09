<template>
    <button type="button" @click="show = true">
        <slot />
        <portal v-if="show" to="dropdown">
            <div>
                <div style="position: fixed; top: 0; right: 0; left: 0; bottom: 0; z-index: 99998; background: black; opacity: .1" @click="show = false" />
                <div ref="dropdown" style="position: absolute;" :style="customCss" @click.stop="show = !auto_close">
                    <div class="absolute top-4 right-1 transform -translate-y-full w-4 h-4 bg-gray-100 rotate-45 shadow-lg rounded-sm"></div>
                    <slot name="dropdown"/>
                </div>
            </div>
        </portal>
    </button>
</template>

<script>
import { createPopper } from '@popperjs/core'

export default {
    props: {
        placement: {
            type: String,
            default: 'bottom-end',
        },
        customCss: {
            type: String,
            default: "z-index: 99999"
        },
        boundary: {
            type: String,
            default: 'scrollParent',
        },
        autoClose: {
            type: Boolean,
            default: true,
        },
    },

    data() {
        return {
            auto_close: this.autoClose,
            show: false,
        }
    },
    watch: {
        show(show) {
            if (show) {
                this.$nextTick(() => {
                    createPopper(this.$el, this.$refs.dropdown, {
                        placement: this.placement,
                        modifiers: {
                            name: 'arrow',
                        },
                    });
                })
            } else if (this.popper) {
                setTimeout(() => this.popper.destroy(), 100)
            }
        },
        'auto_close': {
            handler(value) {
                this.auto_close = value
            }
        },
        deep: true
    },
    mounted() {
        document.addEventListener('keydown', (e) => {
            if (e.keyCode === 27) {
                this.show = false
            }
        })
    },
    methods: {
        toggleDropDown(autoClose = true) {
            this.auto_close = autoClose
        },
    }
}
</script>

