<template>
  <button
    :class="twMerge(classNames)"
    :disabled="loading"
    v-bind="$attrs"
    :type="type"
    ref="button"
  >
    <TransitionRoot
      :show="loading"
      class="absolute inset-0 flex h-full w-full items-center justify-center backdrop-blur"
      enter="transition-opacity duration-75 delay-300"
      enter-from="opacity-0"
      enter-to="opacity-100"
      leave="transition-opacity duration-150 delay-500"
      leave-from="opacity-100"
      leave-to="opacity-0"
    >
      <Puff
        class="stroke-current stroke-6"
        src="https://samherbert.net/svg-loaders/svg-loaders/three-dots.svg"
      />
    </TransitionRoot>
    <slot />
  </button>
</template>

<script>
import { twMerge } from 'tailwind-merge'
import { TransitionRoot } from '@headlessui/vue'
import Puff from '@/components/Icons/SvgLoaders/Puff.vue'
export default {
  props: {
    type: { type: String, default: 'button' },
    loading: { type: Boolean, default: false },
  },
  components: { TransitionRoot, Puff },
  data() {
    return {}
  },
  methods: {
    twMerge,
  },
  computed: {
    classNames() {
      return [
        'relative w-full px-3.5 py-2 rounded-lg shadow shadow-lime-200',
        'text-stone-900 font-num text-sm uppercase tracking-wider',
        'bg-lime-200 transition duration-300',
        'hover:bg-lime-300',
        'focus:outline-none focus:ring focus:ring-offset-1 focus:ring-lime-500 focus:border-transparent',
        'disabled:opacity-80 disabled:pointer-event-none',
      ]
    },
  },
}
</script>
