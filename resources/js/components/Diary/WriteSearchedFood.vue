<template>
  <form
    class="mt-4 px-4 py-3"
    @submit.prevent="submit"
  >
    <div class="relative">
      <div class="absolute right-4 top-4 mb-4">
        <a
          href="#"
          @click.prevent="showHelpPopup = true"
          class="text-gray-400 hover:text-gray-500"
        >
          <QuestionMarkCircleIcon class="h-5 w-5 text-purple-500" />
        </a>
      </div>

      <TextareaInput
        v-model="form.prompt"
        placeholder="Specify in free form what you have eaten, e.g. 1 chicken breast no skin with mashed potato 1 small portion"
        :error="form.errors.prompt"
        @keydown.meta.enter="submit"
      />
    </div>

    <div class="mt-4 flex justify-end">
      <div>
        <PrimaryButton
          type="submit"
          :loading="form.processing"
          >Analyze</PrimaryButton
        >
      </div>
    </div>
  </form>

  <ul
    role="list"
    class="divide-y divide-gray-100 px-4"
    v-if="nutriDialog?.messages?.length > 0"
  >
    <li
      v-for="(message, i) in nutriDialog.messages"
      :key="i"
      class="py-5"
    >
      <div class="mt-4">
        <div class="flex items-center gap-x-4">
          <div>
            <img
              class="h-8 w-8 rounded-full"
              :src="user.avatar_url"
              alt="Nutritionist Assistant"
            />
          </div>
          <div>
            <a
              href="#"
              @click.prevent="setPreviousPrompt(message)"
              class="inline-flex items-center space-x-1 text-sm text-gray-600"
            >
              <span>Your entry</span>
              <ChevronDoubleRightIcon class="h-3 w-3 text-gray-500" />
            </a>
          </div>
        </div>
        <p class="ml-4 mt-3 border-l-2 border-gray-300 pl-4 text-gray-800">
          {{ message.prompt }}
        </p>
      </div>
      <div class="mt-8 flex min-w-0 gap-x-4">
        <img
          class="h-12 w-12 flex-none rounded-full bg-gray-50"
          src="@/assets/images/nutritionist-avatar.png"
          alt="Nutritionist Assistant"
        />
        <div class="min-w-0 flex-auto">
          <p class="text-sm font-semibold leading-6 text-gray-900">
            Nutritionist Assistant's Analysis
          </p>
          <p class="text-sm leading-6 text-gray-500">Suggested Nutrients</p>
        </div>
      </div>
      <NutriDialogMessage :message="message" />
    </li>
  </ul>
  <HelpNutrySuggestionModal
    :open="showHelpPopup === true"
    @close="showHelpPopup = false"
  />
</template>

<script>
import {
  ChevronDoubleRightIcon,
  QuestionMarkCircleIcon,
} from '@heroicons/vue/24/outline'
import TextareaInput from '@/components/Shareable/Input/TextareaInput.vue'
import PrimaryButton from '@/components/Shareable/Input/PrimaryButton.vue'
import { useForm } from '@inertiajs/vue3'
import HelpNutrySuggestionModal from '@/components/Shareable/Modals/HelpNutrySuggestionModal.vue'
import { usePage } from '@inertiajs/vue3'

import NutriDialogMessage from '@/components/Diary/NutriDialogMessage.vue'

export default {
  components: {
    TextareaInput,
    PrimaryButton,
    ChevronDoubleRightIcon,
    QuestionMarkCircleIcon,
    HelpNutrySuggestionModal,
    NutriDialogMessage,
  },
  props: ['nutriDialog'],
  data() {
    return {
      user: usePage().props.auth.user,
      showHelpPopup: false,
      form: useForm({
        prompt: '',
      }),
    }
  },
  methods: {
    submit() {
      this.form
        .transform(data => ({
          ...data,
          dialog_id: this.nutriDialog?.uuid,
        }))
        .post(route('api.analyze'), {
          onSuccess: () => {
            this.form.reset()
          },
        })
    },
    setPreviousPrompt(message) {
      this.form.prompt = message.prompt
    },
  },
}
</script>
