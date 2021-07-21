<template>
    <label
        v-if="label"
        :for="id"
    >{{ label }}</label>
    <div :class="wrapperClasses">
        <input
            :id="id"
            ref="input"
            v-bind="$attrs"
            :class="classNames"
            :type="type"
            :value="modelValue"
            v-on:input="$emit('update:modelValue', $event.target.value)"
        />
        <div
            v-if="$slots['trailing-addon']"
            class="absolute inset-y-0 right-0 flex items-center justify-center px-4 bg-gradient-to-br from-fuchsia-50 to-cyan-50"
        >
            <slot name="trailing-addon" />
        </div>
    </div>
    <div
        v-if="error"
        class="mt-1 text-sm text-red-500 leading-4"
    >{{ error }}</div>
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
        type: {
            type: String,
            default: 'text',
        },
        modelValue: String,
        label: String,
        error: String,
    },
    computed: {
        classNames() {
            return [
                'block w-full border-none',
                'text-lg font-medium',
                'transition',
                'focus:outline-none',
                this.$slots['trailing-addon'] ? 'pr-10' : '',
            ]
        },
        wrapperClasses() {
            return [
                'relative border-4 block w-full shadow-lg',
                'bg-gradient-to-r',
                'transition',
                this.error ? 'from-rose-100 to-red-500/30 placeholder-red-700' : 'from-sky-50 to-fuchsia-200/10',
                this.error ? 'border-red-600 border-b-red-800 border-t-red-400 rounded' : 'border-sky-600 border-b-sky-800 border-t-sky-400 rounded',
                this.error ? 'focus-within:border-rose-600' : 'focus-within:border-sky-600',
                this.error ? 'focus-within:ring-rose-600' : 'focus-within:ring-sky-600',
            ];
        },
    },
    methods: {
        focus() {
            this.$refs.input.focus()
        },
    },
}

</script>
