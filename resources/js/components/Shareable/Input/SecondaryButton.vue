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
    type: { type: String, default: "button" },
    loading: { type: Boolean, default: false },
  },
  data() {
    return {};
  },
  methods: {},
  computed: {
    classNames() {
      return [
        "inline-flex items-center px-3 py-2",
        "border border-transparent rounded-md",
        "text-sm leading-4 font-medium text-fuchsia-800",
        "bg-fuchsia-50 hover:bg-fuchsia-100",
        "focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fuchsia-500",
      ];
    },
  },
};
</script>
