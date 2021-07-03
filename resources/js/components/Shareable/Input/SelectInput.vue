<template>
    <label
        v-if="label"
        :for="id"
    >{{ label }}</label>
    <div class="flex flex-col items-start space-y-1">
        <select
            :id="id"
            ref="select"
            v-bind="$attrs"
            :class="classNames"
            :value="modelValue"
            @change="$emit('update:modelValue', $event.target.value)"
        >
            <option
                v-if="placeholder"
                :selected="true"
                :disabled="true"
                value=""
            >{{ placeholder }}</option>

            <slot />
        </select>
        <div
            v-if="error"
            class="text-sm text-red-500"
        >{{ error }}</div>
    </div>
</template>

<script>
export default {
    inheritAttrs: false,
    props: {
        id: {
            type: String,
            default () {
                return `text-input-${Math.random().toString(36).substr(2, 9)}`
            },
        },
        modelValue: String,
        label: String,
        error: String,
        placeholder: String,
    },
    computed: {
        classNames() {
            return [
                'block w-full',
                'text-lg font-medium',
                'border-4 ',
                'shadow-lg',
                'transition',
                Math.random() > 0.5 ? 'skew-x-3' : '-skew-x-3',
                'focus:animate-input focus:outline-none',
                this.error ? 'bg-rose-50' : 'bg-sky-50',
                this.error ? 'border-red-600 border-b-red-800 border-t-red-400 rounded' : 'border-sky-600 border-b-sky-800 border-t-sky-400 rounded',
                this.error ? 'focus:ring-rose-600' : 'focus:ring-sky-600',
                this.error ? 'focus:border-rose-600' : 'focus:border-sky-600',
            ]
        }
    },
    methods: {
        focus() {
            this.$refs.select.focus()
        },
    },
}

</script>
