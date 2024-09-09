<template>
    <div class="w-full mx-auto">
        <ul class="z-50">
            <li
                v-on:click="toggleSubmenu(index)"
                v-for="(menuItem, index) in menuItems_" :key="index" class="relative py-1 cursor-pointer">
                <div class="flex flex-row items-center text-center justify-between">
                    <inertia-link
                        v-tippy="{ a11y : false, arrow : true }"
                        :content="menuItem.label"
                        :href="menuItem.link"
                        :class="menuClass() + activeMenuClass(routeClass)">
                        <span aria-hidden="true">
                            <icon :name="menuItem.icon" :class="sideBarOpen ? 'w-6 h-6' : 'w-5 h-5'"/>
                        </span>
                        <span :class="sideBarOpen ? 'hidden': ''" class="text-sm px-2">{{ menuItem.label }}</span>
                    </inertia-link>
                    <span :class="sideBarOpen ? 'hidden': ''" aria-hidden="true">
                        <icon v-if="isMenuOpen" class="w-4 h-4 mr-4 transition-transform transform" name="minus-circle"/>
                        <icon v-else class="w-4 h-4 mr-4 transition-transform transform" name="plus-circle"/>
                    </span>
                </div>
                <transition name="slide_x">
                    <ul v-show="menuItem.submenuOpen" class="mt-2 z-999 overflow-hidden">
                        <li v-for="(submenuItem, subIndex) in menuItem.submenuItems" :key="subIndex">
                            <inertia-link
                                v-tippy="{ a11y : false, arrow : true }"
                                :content="submenuItem.label"
                                :href="submenuItem.link"
                                :class="'m-1 ' + menuClass()">
                                <icon v-if="submenuItem.icon" :name="submenuItem.icon" :class="sideBarOpen ? 'w-6 h-6' : 'w-5 h-5'"/>
                                <icon v-else name="ellipsis-horizontal" :class="sideBarOpen ? 'w-6 h-6' : 'w-5 h-5'"/>
                                <span :class="sideBarOpen ? 'hidden': ''" class="ml-2 text-sm">{{ submenuItem.label }}</span>
                            </inertia-link>
                        </li>
                    </ul>
                </transition>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "GlobalSideMenu",
    props: {
        routeClass: String,
        menuItems: Array,
        sideBarOpen: {
            type: Boolean,
            default: true
        }
        // [
        // {
        //     label: String,
        //     submenuOpen: false,
        //     link: '#',
        //     icon: String,
        //     submenuItems: [
        //         {
        //             label: String,
        //             link: String,
        //             icon: String,
        //         }
        //     ]
        // }
        // ]
    },
    data() {
        return {
            isMenuOpen: false,
            menuItems_: this.menuItems
        }
    },
    methods: {
        menuClass() {
            return 'flex items-center p-2 font-semibold hover:font-bold hover:text-gray-800 dark:hover:text-yellow-300 '
        },
        activeMenuClass(route) {
            return this.route().current(route) ? 'text-gray-900 font-bold dark:text-yellow-300' : 'text-gray-500'
        },
        toggleSubmenu(index) {
            this.isMenuOpen = !this.isMenuOpen;
            this.menuItems_[index].submenuOpen = !this.menuItems_[index].submenuOpen;
        }
    }
}
</script>

<style>

</style>
