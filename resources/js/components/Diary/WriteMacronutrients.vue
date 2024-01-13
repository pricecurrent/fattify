<template>
  <div class="px-4">
    <form @submit.prevent="submit">
      <div class="grid grid-cols-3 gap-2">
        <div>
          <TextInput
            label="Prots"
            v-model="form.proteins"
            placeholder="0"
            class="font-num"
            type="number"
            step="0.01"
            :error="form.errors.proteins"
          />
        </div>

        <div>
          <TextInput
            label="Fats"
            v-model="form.fats"
            placeholder="0"
            class="font-num"
            type="number"
            step="0.01"
            :error="form.errors.fats"
          />
        </div>
        <div>
          <TextInput
            label="Carbs"
            v-model="form.carbs"
            placeholder="0"
            class="font-num"
            type="number"
            step="0.01"
            :error="form.errors.carbs"
          />
        </div>
      </div>
      <p class="mt-1 text-sm text-gray-400">
        Please specify macronutrients contained in
        <span class="font-num font-bold">100g</span>
      </p>
      <div
        class="mt-4 space-y-4 sm:col-start-2 sm:row-span-2 sm:row-start-1 sm:space-y-8"
      >
        <div>
          <TextInput
            label="Weight"
            v-model="form.weight"
            placeholder="300"
            type="tel"
            class="font-num"
            :error="form.errors.weight"
          >
            <template #trailing-addon>g.</template>
          </TextInput>
          <p class="mt-1 text-sm text-gray-400">
            Here specify the amount of food you actually ate.
          </p>
        </div>
        <div>
          <SelectInput
            label="Select meal time"
            v-model="form.meal_time"
            placeholder="&nbsp;"
            :error="form.errors.meal_time"
            :options="MEAL_TIMES"
          >
          </SelectInput>
          <p class="mt-1 text-sm text-gray-400">
            Please specify when you ate this meal
          </p>
        </div>
        <div>
          <TextInput
            label="Dish name"
            v-model="form.dish_name"
            placeholder="3 eggs"
            :error="form.errors.dish_name"
          />
          <p class="mt-1 text-sm text-gray-400">What did you eat?</p>
        </div>
      </div>
      <div class="mt-6">
        <div class="md:flex md:justify-end">
          <PrimaryButton
            type="submit"
            :loading="form.processing"
          >
            <span>Save</span>
          </PrimaryButton>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { useForm } from '@inertiajs/vue3'
import TextInput from '@/components/Shareable/Input/TextInput.vue'
import SelectInput from '@/components/Shareable/Input/SelectInput.vue'
import PrimaryButton from '@/components/Shareable/Input/PrimaryButton.vue'
import { MEAL_TIMES } from '@/constants'
export default {
  components: { SelectInput, TextInput, PrimaryButton },
  props: ['date'],
  setup(props) {
    const form = useForm({
      weight: null,
      fats: null,
      carbs: null,
      proteins: null,
      date: props.date,
      dish_name: null,
      meal_time: null,
    })
    const submit = () => {
      form.post('nutrition-diary-entries/macronutrients', {
        preserveScroll: true,
        onSuccess: () =>
          form.reset('proteins', 'fats', 'carbs', 'dish_name', 'weight'),
      })
    }
    return { form, submit, MEAL_TIMES }
  },
}
</script>
