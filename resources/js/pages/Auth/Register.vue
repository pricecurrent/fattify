<template>
  <Head title="Sign Up — Fittify" />
  <div class="mt-4">
    <h2 class="font-serif text-4xl font-extrabold">Create an Account</h2>
    <p class="text-stone-600">
      Or
      <Link class="link" href="/login">Sign In</Link>
    </p>
  </div>
  <form v-if="inviteCode && inviteCode === 'BETALIST_FRIEND'" @submit.prevent="form.post('/register')" class="mt-6 pb-8">
    <div class="space-y-2">
      <div>
        <TextInput v-model="form.name" :error="form.errors.name" label="Name" placeholder="John Doe" />
      </div>
      <div>
        <TextInput v-model="form.email" :error="form.errors.email" label="Email address" placeholder="john@doe.com" />
      </div>
      <div>
        <TextInput type="password" v-model="form.password" :error="form.errors.password" label="Password" />
      </div>
      <div>
        <TextInput type="password" v-model="form.password_confirmation" :error="form.errors.password_confirmation" label="Confirm password" />
      </div>
    </div>
    <div class="mt-8">
      <PrimaryButton type="submit" :disabled="form.processing">Login</PrimaryButton>
    </div>
  </form>

  <div v-else>
    <div class="rounded-md bg-orange-50 p-4 mt-4 border border-orange-400">
      <div class="flex">
        <div class="flex-shrink-0">
          <ExclamationTriangleIcon class="h-5 w-5 text-orange-400" aria-hidden="true" />
        </div>
        <div class="ml-3">
          <h3 class="text-sm font-medium text-orange-800">Invalid Invite Code</h3>
          <div class="mt-2 text-sm text-orange-700">
            <p>You cannot sign up without a valid invite code.</p>
          </div>
        </div>
      </div>
    </div>

    <div className="mt-4">
      <TextInput type="text" v-model="inviteCode" label="Invite Code" />
    </div>
  </div>
</template>

<script>
import { ExclamationTriangleIcon } from '@heroicons/vue/20/solid'
import AuthLayout from '@/layouts/AuthLayout.vue'
import { useForm } from '@inertiajs/vue3'
import TextInput from '@/components/Shareable/Input/TextInput.vue'
import PrimaryButton from '@/components/Shareable/Input/PrimaryButton.vue'
import { Link, Head } from '@inertiajs/vue3'
import { ref } from 'vue'

export default {
  layout: AuthLayout,
  props: {
    invite_code: String,
  },
  components: { Head, TextInput, PrimaryButton, Link, ExclamationTriangleIcon },
  setup(props) {
    const inviteCode = ref(props.invite_code)

    const form = useForm({
      name: null,
      email: null,
      password: null,
      password_confirmation: null,
    })
    return { form, inviteCode }
  },
}
</script>
