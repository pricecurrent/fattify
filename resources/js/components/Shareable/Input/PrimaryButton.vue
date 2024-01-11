<template>
  <button
    :class="classNames"
    :disabled="loading"
    v-bind="$attrs"
    :type="type"
    ref="button"
  >
    <TransitionRoot
      :show="loading"
      class="absolute inset-0 w-full h-full backdrop-blur flex items-center justify-center"
      enter="transition-opacity duration-75 delay-300"
      enter-from="opacity-0"
      enter-to="opacity-100"
      leave="transition-opacity duration-150 delay-500"
      leave-from="opacity-100"
      leave-to="opacity-0"
    >
      <Puff
        class="stroke-6 stroke-current"
        src="https://samherbert.net/svg-loaders/svg-loaders/three-dots.svg"
      />
    </TransitionRoot>
    <slot />
  </button>
</template>

<script>
import { TransitionRoot } from "@headlessui/vue";
import Puff from "@/components/Icons/SvgLoaders/Puff.vue";
export default {
  props: {
    type: { type: String, default: "button" },
    loading: { type: Boolean, default: false },
  },
  components: { TransitionRoot, Puff },
  data() {
    return {};
  },
  methods: {},
  computed: {
    classNames() {
      return [
        "relative w-full md:w-auto px-3 py-2",
        "text-white font-bold tracking-wide text-sm uppercase font-num",
        "border-2 border-black/60 bg-origin-border rounded-sm",
        "bg-gradient-to-r from-sky-400 to-fuchsia-600/90 transition duration-300",
        "hover:from-fuchsia-600 hover:to-sky-400",
        "focus:outline-none focus:ring focus:ring-offset-4 focus:ring-fuchsia-600 focus:border-transparent",
        "focus:from-fuchsia-600 focus:to-sky-400",
        "disabled:opacity-80 disabled:pointer-event-none",
      ];
    },
  },
};
</script>
