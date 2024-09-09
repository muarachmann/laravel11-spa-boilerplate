<template>
    <label
        :for="id"
        :class="classNames"
        class="flex inline-flex items-center space-x-2 mb-1 text-gray-700 dark:text-white">
        <icon v-if="icon" :name="icon" class="w-4 h-4"/>
        <span v-html="label"/>
        <span class="text-red-600 text-xs">{{ required ? '*' : '' }}</span>
    </label>
</template>

<script>
export default {
    name: "GlobalLabel",
    props: {
        label: String,
        id: String,
        icon: String,
        classNames: String,
        required: {
            type: Boolean,
            default: false
        }
    }
}
</script>
