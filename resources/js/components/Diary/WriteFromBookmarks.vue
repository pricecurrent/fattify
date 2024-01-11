<template>
  <form @submit.prevent="submit">
    <div
      class="space-y-4 sm:grid sm:grid-flow-col sm:grid-rows-2 sm:gap-x-8 sm:space-y-0"
    >
      <div class="row-start-1 sm:col-start-1">
        <BookmarksSearchInput v-model="form.bookmark_id" />
      </div>
      <div
        class="space-y-4 sm:col-start-2 sm:row-span-2 sm:row-start-1 sm:space-y-8"
      >
        <TextInput
          type="tel"
          v-model="form.weight"
          placeholder="Weight"
          :error="form.errors.weight"
          class="font-num font-semibold"
        >
          <template #trailing-addon>g</template>
        </TextInput>
        <SelectInput
          v-model="form.meal_time"
          placeholder="Meal time"
          :error="form.errors.meal_time"
          :options="MEAL_TIMES"
        />
      </div>
      <div
        class="mt-4 justify-end sm:col-start-1 sm:row-start-2 sm:mt-8 sm:flex sm:flex-col"
      >
        <PrimaryButton
          type="submit"
          :loading="form.processing"
        >
          <span>Save</span>
        </PrimaryButton>
      </div>
    </div>
  </form>
</template>

<script>
import { useForm } from '@inertiajs/vue3'
import TextInput from '@/components/Shareable/Input/TextInput.vue'
import SelectInput from '@/components/Shareable/Input/SelectInput.vue'
import PrimaryButton from '@/components/Shareable/Input/PrimaryButton.vue'
import { MEAL_TIMES } from '@/constants'
import BookmarksSearchInput from '@/components/Diary/BookmarksSearchInput.vue'

export default {
  components: { TextInput, SelectInput, PrimaryButton, BookmarksSearchInput },
  setup() {
    const form = useForm({
      bookmark_id: null,
      weight: null,
      meal_time: null,
    })
    const submit = () => {
      form.post('/nutrition-diary-entries/bookmarks', {
        preserveScroll: true,
        onSuccess: () => form.reset('bookmark_id', 'weight'),
      })
    }
    return { form, submit, MEAL_TIMES }
  },
}
</script>
