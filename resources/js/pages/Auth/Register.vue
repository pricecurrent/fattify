<template>
    <div class="mt-4">
        <h2 class="text-3xl font-extrabold">Create an Account</h2>
        <p class="text-gray-600">
            Or <inertia-link
                class="link"
                href="/login"
            >Sign In</inertia-link>
        </p>
    </div>
    <form
        @submit.prevent="form.post('/register')"
        class="mt-6 pb-8"
    >
        <div class="space-y-2">
            <div>
                <TextInput
                    v-model="form.name"
                    :error="form.errors.name"
                    label="Name"
                    placeholder="John Doe"
                />
            </div>
            <div>
                <TextInput
                    v-model="form.email"
                    :error="form.errors.email"
                    label="Email address"
                    placeholder="john@doe.com"
                />
            </div>
            <div>
                <TextInput
                    type="password"
                    v-model="form.password"
                    :error="form.errors.password"
                    label="Password"
                />
            </div>
            <div>
                <TextInput
                    type="password"
                    v-model="form.password_confirmation"
                    :error="form.errors.password_confirmation"
                    label="Confirm password"
                />
            </div>
        </div>
        <div class="mt-8">
            <PrimaryButton
                type="submit"
                :disabled="form.processing"
            >Login</PrimaryButton>
        </div>
    </form>
</template>

<script>
import AuthLayout from '@/layouts/AuthLayout'
import { useForm } from '@inertiajs/inertia-vue3'
import TextInput from '@/components/Shareable/Input/TextInput'
import PrimaryButton from '@/components/Shareable/Input/PrimaryButton'
import CheckboxInput from '@/components/Shareable/Input/CheckboxInput'
export default {
    layout: AuthLayout,
    components: { TextInput, PrimaryButton, CheckboxInput },
    setup() {
        const form = useForm({
            name: null,
            email: null,
            password: null,
            password_confirmation: null,
        })
        return { form }
    }
}

</script>
