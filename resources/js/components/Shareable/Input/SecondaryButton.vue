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
        'relative w-full px-3.5 py-2 rounded-lg shadow-lg border border-teal-300',
        'text-gray-900 font-num tracking-wide',
        'bg-white',
        'focus:outline-none focus:ring focus:ring-offset-1 focus:ring-teal-500 focus:border-transparent',
        'disabled:opacity-80 disabled:pointer-event-none',
      ]
    },
  },
}
</script>
