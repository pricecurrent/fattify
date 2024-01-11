<template>
  <input
    :id="id"
    ref="file"
    v-bind="$attrs"
    :class="classNames"
    v-on:input="$emit('update:modelValue', $event.target.files[0])"
    type="file"
  />
  <div
    v-if="error"
    class="text-sm text-red-500"
  >
    {{ error }}
  </div>
</template>

<script>
export default {
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      default() {
        return `text-input-${Math.random().toString(36).substr(2, 9)}`
      },
    },
    modelValue: {},
    label: String,
    error: String,
  },
  computed: {
    classNames() {
      return []
    },
  },
  methods: {
    focus() {
      this.$refs.input.focus()
    },
  },
}
</script>
