<template>
    <button
        :class="classNames"
        :disabled="loading"
        v-bind="$attrs"
        :type="type"
        ref="button"
    >
        <slot />
    </button>
</template>

<script>
export default {
    props: {
        type: { type: String, default: 'button' },
        loading: { type: Boolean, default: false },
    },
    data() {
        return {}
    },
    methods: {},
    computed: {
        classNames() {
            return [
                'w-full md:w-auto px-4 py-3',
                'font-semibold tracking-wider text-white text-lg uppercase',
                'border-4 border-black/60 bg-origin-border',
                'skew-x-2 rotate-1 bg-gradient-to-r from-sky-400 to-fuchsia-600/90 transition duration-300',
                'hover:from-fuchsia-600 hover:to-sky-400',
                'focus:outline-none focus:ring-8 focus:ring-offset-4 focus:ring-fuchsia-600 focus:border-transparent focus:rounded-md focus:scale-105',
                'focus:from-fuchsia-600 focus:to-sky-400'
            ]
        }
    },
}

</script>
