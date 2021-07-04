<template>
    <label
        :for="id"
        class="space-x-2 inline-flex items-center leading-none"
    >
        <input
            :id="id"
            ref="checkbox"
            v-bind="$attrs"
            :class="classNames"
            type="checkbox"
            :value="modelValue"
            v-on:input="$emit('update:modelValue', $event.target.value)"
        />
        <span>{{ label }}</span>
    </label>

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
        modelValue: Boolean,
        label: String,
        error: String,
    },
    computed: {
        classNames() {
            return [
                'w-5 h-5',
                'border-2',
                'bg-gradient-to-r bg-white checked:bg-sky-700 focus:checked:bg-sky-700',
                'transition',
                'focus:outline-none',
                this.error ? 'from-rose-100 to-red-500/30 placeholder-red-700' : 'from-sky-50 to-fuchsia-200/10',
                this.error ? 'border-red-600 border-b-red-800 border-t-red-400 rounded' : 'border-sky-600 border-b-sky-800 border-t-sky-400 rounded',
                this.error ? 'focus:ring-rose-600' : 'focus:ring-sky-600',
                this.error ? 'focus:border-rose-600' : 'focus:border-sky-600',
            ]
        }
    },
    methods: {
        focus() {
            this.$refs.input.focus()
        },
    },
}

</script>
