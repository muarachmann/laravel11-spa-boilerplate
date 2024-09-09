<template>
    <div class="relative">
        <button
            type="button"
            :class="getCurrencyColor"
            class="flex items-center mr-2 ml-2 border-none outline-none focus:outline-none focus:border-transparent"
            @click="toggleVisibility"
            @keydown.space.exact.prevent="toggleVisibility"
            @keydown.esc.exact="hideDropdown"
            @keydown.shift.tab="hideDropdown"
            @keydown.up.exact.prevent="startArrowKeys"
            @keydown.down.exact.prevent="startArrowKeys">
            <span class="mx-2 text-sm whitespace-no-wrap">{{ $page.props.user_currency.code }}</span>
            <svg fill="currentColor" class="-ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M15.3 9.3a1 1 0 0 1 1.4 1.4l-4 4a1 1 0 0 1-1.4 0l-4-4a1 1 0 0 1 1.4-1.4l3.3 3.29 3.3-3.3z"></path></svg>
        </button>
        <transition name="dropdown-fade">
            <ul v-on-clickaway="hideDropdown" v-if="isVisible" ref="dropdown"
                class="absolute z-100 font-normal xs:left-0 lg:right-0
                bg-white dark:bg-dark-2 shadow overflow-hidden rounded w-48 border mt-2 py-1 lg:z-100">
                <li v-for="currency in currencies" :key="currency.id">
                    <a href="#"
                       @click.prevent="setCurrency(currency.code)"
                       ref="currency"
                       class="flex items-center px-4 py-2 text-sm whitespace-no-wrap hover:bg-gray-100 dark:hover:bg-dark-2"
                       @keydown.up.exact.prevent=""
                       @keydown.tab.exact="focusNext(false)"
                       @keydown.down.exact.prevent="focusNext(true)"
                       @keydown.esc.exact="hideDropdown">
                        <span class="ml-2 mr-2 capitalize">{{ currency.name  + ' (' + currency.symbol + ')'}}</span>
                    </a>
                </li>
            </ul>
        </transition>
    </div>
</template>

<script>
import { mixin as clickaway } from 'vue-clickaway';

export default {
    name: "CurrencyDropDown",
    mixins: [ clickaway ],
    props: {
        dropDownColor: null,
        currencyLink: {
            type: String,
            default: 'currency.set'
        }
    },
    data() {
        return {
            isVisible: false,
            focusedIndex: 0,
            currencies: this.$page.props.global_currencies
        }
    },
    computed: {
        getCurrencyColor() {
            return this.dropDownColor !== null ? this.dropDownColor : "text-black";
        },
    },
    methods: {
        toggleVisibility() {
            this.isVisible = !this.isVisible;
        },
        hideDropdown() {
            this.isVisible = false;
            this.focusedIndex = 0
        },
        startArrowKeys() {
            if (this.isVisible) {
                this.$refs.currency.focus()
                this.$refs.dropdown.children[0].children[0].focus()
            }
        },
        focusPrevious(isArrowKey) {
            this.focusedIndex = this.focusedIndex - 1;
            if (isArrowKey) {
                this.focusItem()
            }
        },
        focusNext(isArrowKey) {
            this.focusedIndex = this.focusedIndex + 1;
            if (isArrowKey) {
                this.focusItem()
            }
        },
        focusItem() {
            this.$refs.dropdown.children[this.focusedIndex].children[0].focus()
        },
        setCurrency(currency) {
            this.$inertia.visit(this.route(this.currencyLink, currency), {
                preserveState: false
            });
            this.hideDropdown()
        }
    }
}
</script>
