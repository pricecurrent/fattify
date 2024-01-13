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
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
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
            class="inline-block w-full transform overflow-hidden border-8 border-teal-700 border-b-teal-900 border-t-teal-500 bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle"
          >
            <div class="px-4 pt-5 sm:p-6 sm:pb-4">
              <div class="sm:flex sm:items-start">
                <div class="mt-3 sm:ml-4 sm:mt-0 sm:text-left">
                  <DialogTitle
                    as="h3"
                    class="text-lg font-medium leading-6 text-gray-900"
                  >
                    Bookmark Your Entry
                  </DialogTitle>
                  <div class="mt-2">
                    <div class="mt-4 space-y-2">
                      <div>
                        <TextInput
                          v-model="form.name"
                          label="Bookmark name"
                          placeholder="Potato"
                          :error="form.errors.name"
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="mt-4 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
              <PrimaryButton
                @click.prevent="submit"
                class="!py-2 !font-num !text-base !normal-case !tracking-normal"
                >Save</PrimaryButton
              >
              <div class="w-full text-center">
                <a
                  href="#"
                  @click.prevent="close"
                  class="mt-3 inline-block border-b border-gray-400 pb-px text-center leading-none text-gray-500"
                  >Cancel</a
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
  props: { open: Boolean, entry: Object },
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
    const form = useForm({
      name: props.entry.dishName,
    })
    const submit = () => {
      form.post(`/bookmarked-nutrition-diary-entries/${props.entry.id}`, {
        preserveScroll: true,
        onSuccess: () => close(),
      })
    }
    return {
      close,
      form,
      submit,
    }
  },
}
</script>
