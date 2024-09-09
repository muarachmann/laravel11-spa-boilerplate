<template>
    <div :class="error ? 'has-error' : ''" class="flex flex-col capitalize">
        <global-label
            v-if="label"
            :id="id"
            :required="required"
            :label="label"
        />
        <div v-if="type.replace('-', '') === 'textarea'" class="relative">
            <textarea
                class="py-2.5 px-3 outline-none focus:outline-none focus:border-green-500 focus:ring block w-full border border-gray-300 rounded leading-normal appearance-none placeholder:text-gray-500 placeholder:opacity-100"
                :class="customClass"
                :disabled="disabled"
                :readonly="read_only"
                :value="value"
                @input="$emit('input', $event.target.value)"
                :id="id" :cols="cols" :rows="rows"
                v-bind="$attrs" :minlength="minLength"
                :maxlength="maxLength" :placeholder="placeholder"
                :required="required"></textarea>
        </div>
        <div v-else-if="type === 'select'" class="relative">
            <select
                :disabled="disabled"
                :required="required"
                @input="$emit('input', $event.target.value)"
                id="underline_select"
                class="block py-2.5 px-3 w-full bg-transparent rounded focus:border-green-500 focus:ring border border-gray-300 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none leading-normal placeholder:text-gray-500 placeholder:opacity-100">
                <template v-if="options.length">
                    <option class="text-gray-100" v-if="show_index" value="">
                        {{ placeholder ? placeholder : 'Choose a value' }}
                    </option>
                    <option :selected="value === option.id" v-for="option in options" :key="option.id"
                            :value="option.id">
                        {{ option.name }}
                    </option>
                </template>
                <slot name="options"></slot>
            </select>
        </div>
        <div v-else-if="type === 'radio'" class="relative">
            <label class="radio mr-4" v-for="(option, index) in options" :key="index">
                <template v-if="value === option.id">
                    <input type="radio" class="mt-1"
                        @input="$emit('input', $event.target.value)"
                        :value="option.id" checked/>
                </template>
                <template v-else>
                    <input type="radio" class="mt-1"
                        @input="$emit('input', $event.target.value)"
                        :value="option.id"/>
                </template>
                {{ option.name }}
            </label>
        </div>
        <div v-else-if="type === 'switch'" class="relative">
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" class="sr-only peer" @change="check($event)" @input="emitValue"
                       :checked="status">
                <span class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-theme-1 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-theme-1"></span>
            </label>
        </div>
        <div v-else-if="type === 'date'" class="relative">
            <input type="date"
                   class="py-3 px-3 w-full border border-gray-300 focus:ring-1 focus:ring-theme-1 rounded appearance-none focus:border-theme-1 leading-tight focus:outline-none placeholder:text-gray-500 placeholder:opacity-100"
                   :class="customClass"
                   :value="value"
                   :max="max"
                   :min="min"
                   @input="$emit('input', $event.target.value)"/>
        </div>
        <input v-else-if="type === 'quantity'"
               type="text" @input="$emit('input', $event.target.value)"
               class="flex items-center w-10 font-semibold
                text-center text-gray-700 placeholder-gray-700
                bg-white outline-none dark:text-gray-400 dark:placeholder-gray-400
                dark:bg-gray-900 focus:outline-none text-md hover:text-black"
               :value="value"
               :placeholder="placeholder">
        <div v-else class="relative">
            <slot name="prefix"></slot>
            <input
                :id="id"
                ref="input"
                :disabled="disabled"
                :readonly="read_only"
                v-bind="$attrs"
                :minlength="minLength"
                :placeholder="placeholder"
                :required="required"
                :type="this.isPassword ? this.togglePassword ? 'password' : 'text' : this.type"
                :value="value"
                class="py-2.5 px-3 w-full border border-gray-300 focus:ring-1 focus:ring-theme-1 rounded appearance-none focus:border-theme-1 leading-tight focus:outline-none placeholder:text-gray-500 placeholder:opacity-100"
                :class="customClass"
                @input="$emit('input', $event.target.value)"/>
            <div v-if="isPassword" class="absolute right-2 h-5 w-5 top-0 bottom-0 my-auto cursor-pointer"
                 @click="changeType(togglePassword)">
                <icon :name="togglePassword ? 'eye' : 'eye-off'" class="w-full h-full"/>
            </div>
            <slot name="suffix"></slot>
        </div>
        <div v-if="description && !error" v-html="description"
             class="italic text-gray-700 dark:text-yellow-500 text-xs lowercase p-1"/>
        <div v-if="error" class="text-red-600 mt-1">{{ error }}</div>
    </div>
</template>

<script>
export default {
    name: "GlobalInput",
    inheritAttrs: false,
    props: {
        status: {
            type: Boolean|Number,
            default: false
        },
        id: {
            type: String,
            default() {
                return `text-input-${this._uid}`
            },
        },
        show_index: {
            type: Boolean,
            default: true
        },
        customClass: {
            type: String,
            default: 'dark:bg-dark-2 dark:border dark:border-white'
        },
        type: {
            type: String,
            default: 'text',
        },
        cols: {
            type: Number,
            default: 30
        },
        rows: {
            type: Number,
            default: 7
        },
        value: {
            type: [String, Number, Boolean, Array],
        },
        label: String,
        selected: String,
        description: String,
        error: String,
        required: Boolean,
        maxLength: String,
        minLength: String,
        placeholder: String,
        disabled: {
            type: Boolean,
            default: false
        },
        read_only: {
            type: Boolean,
            default: false
        },
        options: {
            type: [Array, Object],
            default: () => []
        },
        max: {
            type: String|Number,
            default: () => null
        },
        min: {
            type: String|Number,
            default: () => null
        }
    },
    data() {
        return {
            isPassword: this.type === "password",
            togglePassword: true,
            isChecked: false,
            //value_: this.value
        }
    },
    methods: {
        focus() {
            this.$refs.input.focus()
        },
        select() {
            this.$refs.input.select()
        },
        changeType() {
            this.togglePassword = !this.togglePassword
        },
        emitValue() {
            this.isChecked = !this.isChecked
            this.$emit('input-switch-changed', this.isChecked)
        },
        check(event) {
            this.isChecked = event.target.checked;
            this.$emit('on-change', this.isChecked)
        }
    }
}
</script>
