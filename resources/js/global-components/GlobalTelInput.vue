<template>
    <div class="w-full flex flex-col capitalize font-medium">
        <global-label :label="label" :required="required" />
        <div class="relative">
            <vue-tel-input
                v-model="phone"
                @validate="onValidate"
                :disabled="disabled"
                v-bind="bindProps">
                <template v-slot:arrow-icon>
                    <svg fill="currentColor" class="flex items-center my-1 w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M15.3 9.3a1 1 0 0 1 1.4 1.4l-4 4a1 1 0 0 1-1.4 0l-4-4a1 1 0 0 1 1.4-1.4l3.3 3.29 3.3-3.3z"></path></svg>
                </template>
                <template v-slot:icon-right>
                    <icon v-if='isValid' name='check-circle' class='flex items-center text-green-700 w-5 h-5 mx-1'/>
                    <icon v-else name='exclamation-circle' class='flex items-center text-yellow-700 w-5 h-5 mx-1'/>
                </template>
            </vue-tel-input>
        </div>
        <div v-if="error" class="text-red-600 mt-1">{{ error }}</div>
    </div>
</template>

<script>

import { VueTelInput } from 'vue-tel-input'
import i18n from "../i18n";

export default {
    name: "GlobalTelInput",
    components: {
        VueTelInput
    },
    props: {
        id: String,
        error: {
            type: String,
            default: null,
        },
        placeholder: {
            type: String,
            default: ''
        },
        label: {
            type: String,
            default: i18n.t('forms.phone_number')
        },
        default: String,
        required: {
            type: Boolean,
            default: false
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },
    watch: {
        'default': {
            handler: function(val) {
                this.phone = val
            }
        }
    },
    data() {
        return {
            phone: this.default,
            isValid: false,
            bindProps: {
                mode: "international",
                autocomplete: "on",
                defaultCountry: "CM",
                onlyCountries: ['CM', 'CI', 'CD', 'SN'],
                validCharactersOnly: true,
                dropdownOptions: {
                    // showDialCodeInList: true,
                    showDialCodeInSelection: true,
                    showFlags: true,
                    // showSearchBox: true
                },
                inputOptions: {
                    placeholder: this.placeholder,
                    required: this.required,
                    readonly: this.readonly,
                    styleClasses: "mx-2 py-0 px-4 text-base dark:bg-dark-2 dark:border-dark-2 focus:border-green-500 block w-20 border border-white appearance-none leading-normal placeholder:text-gray-500 placeholder:opacity-100"
                },
                styleClasses: "flex items-center py-0 px-3 focus:outline-none outline-none focus:border-green-500 focus:ring block w-full bg-white border !border-gray-300 dark:bg-dark-2 dark:border dark:border-white !rounded"
            },
        }
    },
    methods: {
        onValidate(phoneObject) {
            this.isValid = phoneObject.valid
            this.$emit("update", phoneObject)
        }
    }
}
</script>

<style src="vue-tel-input/dist/vue-tel-input.css"></style>
