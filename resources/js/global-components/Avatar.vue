<template>
    <div v-on:click='loadUrl(url)'
        :class="randomBg() + ' ' + getSize"
        class="relative rounded-full shadow cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-theme-1">
        <img v-if="image" class="rounded-full object-cover h-full w-full" :class="getSize" :src="image" :alt="label">
        <div v-else :class="getSize"
            class="flex items-center justify-center rounded-full text-gray-400 text-lg font-semibold">
            <div class="text-white">
                {{ $page.props.auth.user.initials }}
            </div>
        </div>
        <div v-if="type === 'admin'" class="-bottom-1 left-7 absolute w-4 h-4 border-2 bg-blue-400 border-white dark:border-gray-800 rounded-full">
            <icon name="check-badge" class="text-gray-400"/>
        </div>
    </div>
</template>

<script>

export default {
    name: "Avatar",
    props: {
        type: {
            type: String,
            default: 'user',
        },
        label: {
            type: String,
            default: 'avatar',
        },
        image: {
            type: String,
            default: '/images/logo.png',
        },
        url: {
            type: String,
            default: null,
        },
        size: {
            type: String,
            default: '12',
        },
    },
    computed: {
        getSize() {
            return `w-${this.size} h-${this.size}`
        },
    },
    methods: {
        loadUrl(url) {
            //
        },
        randomBg() {
            const colors = ["bg-black", "bg-theme-1", "bg-blue-900",
            ];
            return colors[Math.floor(Math.random() * colors.length)];
        }
    }
}
</script>

<style scoped>

</style>
