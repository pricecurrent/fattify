<template>
  <!-- Global notification live region, render this permanently at the end of the document -->
  <div
    aria-live="assertive"
    class="pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6"
  >
    <div class="flex w-full flex-col items-center space-y-4 sm:items-end">
      <!-- Notification panel, dynamically insert this into the live region when it needs to be displayed -->
      <transition
        enter-active-class="transform ease-out duration-300 transition"
        enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
        leave-active-class="transition ease-in duration-100"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div
          v-if="show"
          class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg shadow-lg ring-1 ring-black ring-opacity-5"
          :class="[error ? 'bg-red-50' : 'bg-green-50']"
        >
          <div class="p-4">
            <div class="flex items-start">
              <div class="flex-shrink-0">
                <XCircleIcon
                  v-if="error"
                  class="h-6 w-6 text-red-400"
                  aria-hidden="true"
                />
                <CheckCircleIcon
                  v-if="success"
                  class="h-6 w-6 text-green-400"
                  aria-hidden="true"
                />
              </div>
              <div class="ml-3 w-0 flex-1 pt-0.5">
                <p
                  class="text-sm font-medium"
                  :class="[error ? 'text-red-900' : 'text-green-900']"
                >
                  {{ error ? error : success }}
                </p>
                <p
                  v-if="subtext"
                  class="mt-1 text-sm"
                  :class="[error ? 'text-red-500' : 'text-green-500']"
                >
                  Fix that
                </p>
              </div>
              <div class="ml-4 flex flex-shrink-0">
                <button
                  @click="show = false"
                  class="inline-flex rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2"
                  :class="[error ? 'text-red-50' : 'text-green-50']"
                >
                  <XMarkIcon
                    class="h-5 w-5"
                    :class="[error ? 'text-red-400' : 'text-green-400']"
                    aria-hidden="true"
                  />
                </button>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
import { ref, watch, toRefs } from 'vue'
import { CheckCircleIcon } from '@heroicons/vue/24/outline'
import { XCircleIcon } from '@heroicons/vue/24/outline'
import { XMarkIcon } from '@heroicons/vue/24/outline'
import { router } from '@inertiajs/vue3'
export default {
  components: {
    CheckCircleIcon,
    XMarkIcon,
    XCircleIcon,
  },
  data() {
    return {
      show: false,
    }
  },
  computed: {
    error() {
      return this.$page.props.flash.error
    },
    subtext() {},
    success() {
      return this.$page.props.flash.success
    },
  },
  watch: {
    '$page.props.flash': {
      handler(newValue) {
        if (newValue.error || newValue.success) {
          this.show = true
        }
      },
      deep: true,
    },
    show(newValue) {
      if (newValue === true) {
        setTimeout(() => (this.show = false), 3000)
      }
    },
  },
}
</script>
