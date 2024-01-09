<template>
  <form
    class="px-4 mt-4 py-3"
    @submit.prevent="submit"
  >
    <TextareaInput
      v-model="form.prompt"
      placeholder="Specify in free form what you have eaten, e.g. 1 chicken breast no skin with mashed potato 1 small portion"
      :error="form.errors.prompt"
      @keydown.meta.enter="submit"
    />

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
    class="divide-y px-4 divide-gray-100"
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
              class="text-sm text-gray-600 inline-flex space-x-1 items-center"
            >
              <span>Your entry</span>
              <ChevronDoubleRightIcon class="w-3 h-3 text-gray-500" />
            </a>
          </div>
        </div>
        <p class="pl-4 ml-4 mt-3 border-l-2 border-gray-300 text-gray-800">
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
      <div
        class="mt-8 relative flow-root p-6 border border-gray-300 rounded shadow-sm"
      >
        <div class="absolute top-4 right-4 mb-4">
          <a
            href="#"
            @click.prevent="showHelpPopup = true"
            class="text-gray-400 hover:text-gray-500"
          >
            <QuestionMarkCircleIcon class="w-5 h-5 text-purple-500" />
          </a>
        </div>
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div
            class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8"
          >
            <table class="min-w-full divide-y divide-gray-300">
              <thead>
                <tr class="divide-x divide-gray-200">
                  <th
                    scope="col"
                    class="py-3.5 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-0"
                  >
                    Name
                  </th>
                  <th
                    scope="col"
                    class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900"
                  >
                    Fats
                  </th>
                  <th
                    scope="col"
                    class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900"
                  >
                    Carbs
                  </th>
                  <th
                    scope="col"
                    class="py-3.5 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pr-0"
                  >
                    Proteins
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                <tr
                  v-for="(item, index) in message.suggestions"
                  :key="index"
                  class="divide-x divide-gray-200"
                >
                  <td
                    class="py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-0"
                  >
                    {{ item.name }}
                  </td>
                  <td class="whitespace-nowrap p-4 text-sm text-gray-500">
                    {{ item.fats }}
                  </td>
                  <td class="whitespace-nowrap p-4 text-sm text-gray-500">
                    {{ item.carbs }}
                  </td>
                  <td
                    class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-0"
                  >
                    {{ item.proteins }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="mt-4 flex justify-end gap-x-4">
        <div>
          <SecondaryButton @click.prevent="saveToDiary(message)">
            Save to Diary
          </SecondaryButton>
        </div>
      </div>
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
import TextareaInput from '@/components/Shareable/Input/TextareaInput'
import PrimaryButton from '@/components/Shareable/Input/PrimaryButton'
import { useForm } from '@inertiajs/inertia-vue3'
import SecondaryButton from '@/components/Shareable/Input/SecondaryButton'
import { Inertia } from '@inertiajs/inertia'
import HelpNutrySuggestionModal from '@/components/Shareable/Modals/HelpNutrySuggestionModal'

export default {
  components: {
    TextareaInput,
    PrimaryButton,
    SecondaryButton,
    ChevronDoubleRightIcon,
    QuestionMarkCircleIcon,
    HelpNutrySuggestionModal,
  },
  props: ['nutriDialog'],
  data() {
    return {
      user: Inertia.page.props.auth.user,
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
    saveToDiary(message) {
      this.$inertia.post(route(`nutri-dialog-messages.accepted.store`, message))
    },
  },
}
</script>
