<template>
  <div v-if="message.type === 'suggestion'">
    <div
      class="mt-8 flow-root rounded border border-gray-300 bg-green-50 p-6 shadow-sm"
    >
      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
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
  </div>
  <div v-if="message.type === 'clarification'">
    <div class="mt-4 rounded-md bg-yellow-50 p-4">
      <div class="flex">
        <div class="flex-shrink-0">
          <ExclamationTriangleIcon
            class="h-5 w-5 text-yellow-400"
            aria-hidden="true"
          />
        </div>
        <div class="ml-3">
          <h3 class="text-sm font-medium text-yellow-800">
            I need clarifications
          </h3>
          <div class="mt-2 text-sm text-yellow-700">
            <p>{{ message.clarification }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { router } from '@inertiajs/vue3'
import SecondaryButton from '@/components/Shareable/Input/SecondaryButton.vue'
import { ExclamationTriangleIcon } from '@heroicons/vue/24/outline'

export default {
  props: ['message'],
  components: {
    SecondaryButton,
    ExclamationTriangleIcon,
  },
  data() {
    return {}
  },
  methods: {
    saveToDiary(message) {
      router.post(route(`nutri-dialog-messages.accepted.store`, message))
    },
  },
  computed: {},
  mounted() {
    console.log('booted')
  },
}
</script>
