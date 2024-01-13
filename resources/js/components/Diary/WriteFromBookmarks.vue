<template>
  <form @submit.prevent="submit">
    <div class="space-y-4 sm:grid">
      <div>
        <BookmarksSearchInput v-model="form.bookmark_id" />
      </div>
      <div class="space-y-4 sm:space-y-8">
        <TextInput
          label="Weight"
          type="tel"
          v-model="form.weight"
          placeholder="100"
          :error="form.errors.weight"
          class="font-num font-semibold"
        >
          <template #trailing-addon>g</template>
        </TextInput>
        <SelectInput
          label="Select meal time"
          v-model="form.meal_time"
          placeholder="Meal time"
          :error="form.errors.meal_time"
          :options="MEAL_TIMES"
        />
      </div>
      <div class="mt-4 justify-end sm:mt-8 sm:flex sm:flex-col">
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
