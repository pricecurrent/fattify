<template>
    <form @submit.prevent="submit">
        <div class="space-y-4 sm:grid sm:grid-rows-2 sm:grid-flow-col sm:gap-x-8 sm:space-y-0">
            <div class="row-start-1 sm:col-start-1">
                <TextInput
                    v-model="form.calories"
                    placeholder="Calories eaten"
                    class="font-nums"
                    type="tel"
                    :error="form.errors.calories"
                />
            </div>
            <div class="focus-within:opacity-100 opacity-40 transition-opacity space-y-4 sm:space-y-8 sm:row-start-1 sm:row-span-2 sm:col-start-2">
                <SelectInput
                    v-model="form.meal_time"
                    placeholder="Meal time"
                    :error="form.errors.meal_time"
                >
                    <option v-for="meal in mealTimes">{{ meal}}</option>
                </SelectInput>
                <TextInput
                    v-model="form.dish_name"
                    placeholder="Dish name"
                    :error="form.errors.dish_name"
                />
            </div>
            <div class="sm:flex sm:flex-col justify-end mt-4 sm:mt-0 sm:col-start-1 sm:row-start-2 sm:mt-8">
                <PrimaryButton type="submit">
                    <span>Write it down</span>
                </PrimaryButton>
            </div>
        </div>
    </form>
</template>

<script>
import { BookmarkIcon } from '@heroicons/vue/outline'
import { useForm } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import { ref } from 'vue'
import TextInput from '@/components/Shareable/Input/TextInput'
import SelectInput from '@/components/Shareable/Input/SelectInput'
import PrimaryButton from '@/components/Shareable/Input/PrimaryButton'
export default {
    components: { BookmarkIcon, TextInput, PrimaryButton, SelectInput },
    setup() {
        const mealTimes = ['breakfast', 'lunch', 'dinner'];
        const form = useForm({
            calories: null,
            meal_time: null,
            dish_name: null,
        })
        const submit = () => {
            form.post('/nutrition-diary-entries/calories', {
                onSuccess: () => form.reset(),
            })
        }
        return { form, submit, mealTimes }
    }
}

</script>
