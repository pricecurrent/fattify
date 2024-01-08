<template>
  <label v-if="label" :for="id">{{ label }}</label>
  <textarea
    :id="id"
    ref="textarea"
    v-bind="$attrs"
    :class="classNames"
    :value="modelValue"
    v-on:input="$emit('update:modelValue', $event.target.value)"
    rows="4"
  ></textarea>
  <div v-if="error" class="mt-2 text-red-500">{{ error }}</div>
</template>

<script>
export default {
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      default() {
        return `text-input-${Math.random().toString(36).substr(2, 9)}`;
      },
    },
    modelValue: String,
    label: String,
    error: String,
  },
  computed: {
    classNames() {
      return [
        "block w-full",
        "text-base font-normal",
        "border-4 ",
        "shadow-lg",
        "bg-gradient-to-r",
        "transition",
        "focus:outline-none",
        this.error
          ? "from-rose-100 to-red-500/30 placeholder-red-700"
          : "from-sky-50 to-fuchsia-200/10",
        this.error
          ? "border-red-600 border-b-red-800 border-t-red-400 rounded"
          : "border-sky-600 border-b-sky-800 border-t-sky-400 rounded",
        this.error ? "focus:ring-rose-600" : "focus:ring-sky-600",
        this.error ? "focus:border-rose-600" : "focus:border-sky-600",
      ];
    },
  },
  methods: {
    focus() {
      this.$refs.input.focus();
    },
  },
};
</script>
