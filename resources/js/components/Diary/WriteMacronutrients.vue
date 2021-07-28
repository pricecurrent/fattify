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
            <div class="mt-6 space-y-4 sm:space-y-8 sm:row-start-1 sm:row-span-2 sm:col-start-2">
                <SelectInput
                    v-model="form.meal_time"
                    placeholder="Meal time"
                    :error="form.errors.meal_time"
                    :options="MEAL_TIMES"
                >
                </SelectInput>
                <TextInput
                    v-model="form.dish_name"
                    placeholder="Dish name"
                    :error="form.errors.dish_name"
                />
            </div>
            <div class="mt-6">
                <div class="md:flex md:justify-end">
                    <PrimaryButton
                        type="submit"
                        :loading="form.processing"
                    >
                        <span>Write it down</span>
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import { BookmarkIcon } from '@heroicons/vue/outline'
import { useForm } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import { ref } from 'vue'
import TextInput from './../Shareable/Input/TextInput'
import SelectInput from './../Shareable/Input/SelectInput'
import PrimaryButton from './../Shareable/Input/PrimaryButton'
import { MEAL_TIMES } from '@/constants'
export default {
    components: { BookmarkIcon, SelectInput, TextInput, PrimaryButton },
    props: ['date'],
    setup(props) {
        const form = useForm({
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
                onSuccess: () => form.reset('proteins', 'fats', 'carbs', 'dish_name'),
            })
        }
        return { form, submit, MEAL_TIMES }
    }
}

</script>
