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
                'inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-fuchsia-700 bg-fuchsia-100 hover:bg-fuchsia-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fuchsia-500'
            ]
        }
    },
}

</script>
