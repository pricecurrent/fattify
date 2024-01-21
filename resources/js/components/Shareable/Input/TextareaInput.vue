<template>
  <div class="rounded-lg border bg-stone-100 shadow" :class="[error ? 'ring-2 ring-red-600' : '']">
    <header class="border-b border-stone-300 px-4 py-3">
      <div class="flex items-center justify-between">
        <div>
          <label v-if="label" class="md:text-lg" :for="id">{{ label }}</label>
        </div>
        <div>
          <slot name="actions"></slot>
        </div>
      </div>
      <div v-if="error" class="mt-1 text-red-500">
        {{ error }}
      </div>
    </header>
    <textarea :id="id" ref="textarea" v-bind="$attrs" :class="classNames" :value="modelValue" v-on:input="$emit('update:modelValue', $event.target.value)" rows="4"></textarea>
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
    modelValue: String,
    label: String,
    error: String,
  },
  computed: {
    classNames() {
      return [...inputClassNames, this.error ? 'bg-red-100 placeholder-red-600/50' : '']
    },
  },
  watch: {
    modelValue() {
      this.$nextTick(() => {
        this.$refs.textarea.style.height = 'auto'
        this.$refs.textarea.style.height = `${this.$refs.textarea.scrollHeight}px`
      })
    },
  },
  methods: {
    focus() {
      this.$refs.input.focus()
    },
  },
}
</script>
