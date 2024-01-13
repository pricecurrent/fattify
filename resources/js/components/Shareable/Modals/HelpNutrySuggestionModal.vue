<template>
  <TransitionRoot
    as="template"
    :show="open"
  >
    <Dialog
      as="div"
      static
      class="fixed inset-0 z-10 overflow-y-auto"
      @close="close"
      :open="open"
    >
      <div
        class="flex min-h-screen items-end justify-center px-4 pb-20 pt-4 sm:block sm:p-0"
      >
        <TransitionChild
          as="template"
          enter="ease-out duration-300"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="ease-in duration-200"
          leave-from="opacity-100"
          leave-to="opacity-0"
        >
          <DialogOverlay
            class="fixed inset-0 bg-stone-500 bg-opacity-75 transition-opacity"
          />
        </TransitionChild>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span
          class="hidden sm:inline-block sm:h-screen sm:align-middle"
          aria-hidden="true"
          >&#8203;</span
        >
        <TransitionChild
          as="template"
          enter="ease-out duration-300"
          enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          enter-to="opacity-100 translate-y-0 sm:scale-100"
          leave="ease-in duration-200"
          leave-from="opacity-100 translate-y-0 sm:scale-100"
          leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
          <div
            class="inline-block w-full transform overflow-hidden border-8 border-lime-700 border-b-lime-900 border-t-lime-500 bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle"
          >
            <div class="px-4 pt-5 sm:p-6 sm:pb-4">
              <div class="sm:flex sm:items-start">
                <div class="prose mt-3 sm:ml-4 sm:mt-0 sm:text-left">
                  <DialogTitle
                    as="h3"
                    class="text-lg font-bold leading-6 text-stone-900"
                  >
                    Nutritionist Assistant Guide
                  </DialogTitle>
                  <div class="mt-2">
                    <ul>
                      <li>
                        <h4>Direct Communication:</h4>
                        <p>
                          If the nutrition breakdown needs tweaking, talk to the
                          assistant. Mention any specifics from your meal, like
                          "I had half a portion of the salad," or ask to modify
                          numbers, such as "Change my protein intake to 25
                          grams."
                        </p>
                      </li>
                      <li>
                        <h4>Confirm Your Changes:</h4>
                        <p>
                          Once you are happy with the suggestions, click "Save
                          to Diary." This action will log the details into your
                          daily records, ensuring your diary is up-to-date with
                          your nutritional journey.
                        </p>
                      </li>
                      <p>
                        Lean on the Nutritionist Assistant to simplify your meal
                        tracking and stay aligned with your health goals.
                      </p>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="mt-4 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
              <div class="w-full text-center">
                <a
                  href="#"
                  @click.prevent="close"
                  class="mt-3 inline-block border-b border-stone-400 pb-px text-center leading-none text-stone-500"
                  >Ok</a
                >
              </div>
            </div>
          </div>
        </TransitionChild>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script>
import {
  Dialog,
  DialogOverlay,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import { ExclamationTriangleIcon } from '@heroicons/vue/24/outline'
import PrimaryButton from '@/components/Shareable/Input/PrimaryButton.vue'
import SecondaryButton from '@/components/Shareable/Input/SecondaryButton.vue'
import TextInput from '@/components/Shareable/Input/TextInput.vue'
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'

export default {
  props: { open: Boolean },
  components: {
    Dialog,
    DialogOverlay,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
    ExclamationTriangleIcon,
    PrimaryButton,
    SecondaryButton,
    TextInput,
  },
  setup(props, context) {
    const close = () => context.emit('close')
    return {
      close,
    }
  },
}
</script>
