<template>
  <div
    class="rounded-lg border bg-gray-100 shadow"
    :class="[error ? 'ring-2 ring-red-600' : '']"
  >
    <header class="border-b border-gray-300 px-4 py-3">
      <div class="flex items-center justify-between">
        <div>
          <label
            v-if="label"
            class="md:text-lg"
            :for="id"
            >{{ label }}</label
          >
        </div>
        <div>
          <slot name="actions"></slot>
        </div>
      </div>
      <div
        v-if="error"
        class="mt-1 text-red-500"
      >
        {{ error }}
      </div>
    </header>
    <div class="relative">
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
        class="absolute inset-y-0 right-0 flex items-center justify-center bg-gray-200 px-4"
      >
        <slot name="trailing-addon" />
      </div>
    </div>
  </div>
</template>

<script>
import { inputClassNames } from '@/html-classes'

export default {
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      default() {
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
        ...inputClassNames,
        this.error ? 'bg-red-100 placeholder-red-600/50' : 'bg-transparent',
        this.$slots['trailing-addon'] ? 'pr-10' : '',
      ]
    },
    wrapperClasses() {
      return [
        'relative border-4 block w-full shadow-lg',
        'bg-gradient-to-r',
        'transition',
        this.error
          ? 'from-rose-100 to-red-500/30 placeholder-red-700'
          : 'from-sky-50 to-fuchsia-200/10',
        this.error
          ? 'border-red-600 border-b-red-800 border-t-red-400 rounded'
          : 'border-sky-600 border-b-sky-800 border-t-sky-400 rounded',
        this.error
          ? 'focus-within:border-rose-600'
          : 'focus-within:border-sky-600',
        this.error ? 'focus-within:ring-rose-600' : 'focus-within:ring-sky-600',
      ]
    },
  },
  methods: {
    focus() {
      this.$refs.input.focus()
    },
  },
}
</script>
