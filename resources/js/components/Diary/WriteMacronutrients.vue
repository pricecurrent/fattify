<template>
    <div>
        <form @submit.prevent="submit">
            <div class="px-1 grid grid-cols-3 gap-2 md:px-6 md:gap-6">
                <TextInput
                    v-model="form.fats"
                    placeholder="Fats"
                    class="font-nums"
                    type="tel"
                    :error="form.errors.fats"
                />
                <TextInput
                    v-model="form.carbs"
                    placeholder="Carbs"
                    class="font-nums"
                    type="tel"
                    :error="form.errors.carbs"
                />
                <TextInput
                    v-model="form.proteins"
                    placeholder="Prots"
                    class="font-nums"
                    type="tel"
                    :error="form.errors.proteins"
                />
            </div>
            <div class="px-6 mt-6">
                <div class="md:flex md:justify-end">
                    <PrimaryButton type="submit">
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
import PrimaryButton from './../Shareable/Input/PrimaryButton'
export default {
    components: { BookmarkIcon, TextInput, PrimaryButton },
    props: ['date'],
    setup(props) {
        const form = useForm({
            fats: null,
            carbs: null,
            proteins: null,
            date: props.date,
        })
        const submit = () => {
            console.log('lol');
            form.post('nutrition-diary-entries/macronutrients')
        }
        return { form, submit }
    }
}

</script>
