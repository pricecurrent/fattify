<template>
  <label
    :for="id"
    class="inline-flex items-center space-x-2 leading-none"
  >
    <input
      :id="id"
      ref="checkbox"
      v-bind="$attrs"
      :class="classNames"
      type="checkbox"
      :checked="modelValue"
      @change="onChanged($event)"
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
      default() {
        return `checkbox-input-${Math.random().toString(36).substr(2, 9)}`
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
        'bg-gradient-to-r bg-white checked:bg-lime-700 focus:checked:bg-lime-700',
        'transition',
        'focus:outline-none',
        this.error
          ? 'from-rose-100 to-red-500/30 placeholder-red-700'
          : 'from-lime-50 to-lime-200/10',
        this.error
          ? 'border-red-600 border-b-red-800 border-t-red-400 rounded'
          : 'border-lime-600 border-b-lime-800 border-t-lime-400 rounded',
        this.error ? 'focus:ring-rose-600' : 'focus:ring-lime-600',
        this.error ? 'focus:border-rose-600' : 'focus:border-lime-600',
      ]
    },
  },
  methods: {
    onChanged(event) {
      console.log(!event.target.value)
      this.$emit('update:modelValue', !this.modelValue)
    },
  },
}
</script>
