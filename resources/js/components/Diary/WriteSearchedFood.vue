<template>
    <div class="px-8 py-8 font-extrabold text-4xl text-gray-600">
        Coming soon
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
                onSuccess: () => form.reset(),
            })
        }
        return { form, submit, MEAL_TIMES }
    }
}

</script>
