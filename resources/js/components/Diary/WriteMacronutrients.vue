<template>
  <div class="px-4">
    <form @submit.prevent="submit">
      <div class="grid grid-cols-3 gap-2">
        <div>
          <TextInput
            label="Prots"
            v-model="form.proteins"
            placeholder="Prots"
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
            placeholder="Fats"
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
            placeholder="Carbs"
            class="font-num"
            type="number"
            step="0.01"
            :error="form.errors.carbs"
          />
        </div>
      </div>
      <p class="mt-1 text-gray-400 text-xs">
        Please specify macronutrients contained in
        <span class="font-bold font-num">100g</span>
      </p>
      <div
        class="mt-4 space-y-4 sm:space-y-8 sm:row-start-1 sm:row-span-2 sm:col-start-2"
      >
        <div>
          <TextInput
            v-model="form.weight"
            placeholder="Weight"
            type="tel"
            class="font-num"
            :error="form.errors.weight"
          >
            <template #trailing-addon>g.</template>
          </TextInput>
          <p class="mt-1 text-gray-400 text-xs">
            Here specify the amount of food you actually ate.
          </p>
        </div>
        <div>
          <SelectInput
            v-model="form.meal_time"
            placeholder="Meal time"
            :error="form.errors.meal_time"
            :options="MEAL_TIMES"
          >
          </SelectInput>
          <p class="mt-1 text-gray-400 text-xs">
            Please specify when you ate this meal
          </p>
        </div>
        <div>
          <TextInput
            v-model="form.dish_name"
            placeholder="Dish name"
            :error="form.errors.dish_name"
          />
          <p class="mt-1 text-gray-400 text-xs">What did you eat?</p>
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
