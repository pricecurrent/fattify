<template>
    <div class="mt-4">
        <h2 class="text-3xl font-extrabold">Sign in to your account</h2>
        <p class="text-gray-600">
            Or <inertia-link
                class="link"
                href="register"
            >get started for free</inertia-link>
        </p>
    </div>
    <form
        @submit.prevent="form.post('/login')"
        class="mt-6"
    >
        <div>
            <TextInput
                v-model="form.email"
                :error="form.errors.email"
                label="Email address"
            />
        </div>
        <div class="mt-4">
            <TextInput
                type="password"
                v-model="form.password"
                :error="form.errors.password"
                label="Password"
            />
        </div>
        <div class="mt-2">
            <CheckboxInput
                v-model="form.remember"
                label="Remember Me"
            />
        </div>
        <div class="mt-4">
            <PrimaryButton
                type="submit"
                :disabled="form.processing"
            >Login</PrimaryButton>
        </div>
    </form>

    <div class="mt-2">
        <p>
            <inertia-link
                class="link text-sm font-normal"
                href="forgot-password"
            >Forgot your password?</inertia-link>
        </p>
    </div>
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
            email: null,
            password: null,
            remember: false,
        })
        return { form }
    }
}

</script>
