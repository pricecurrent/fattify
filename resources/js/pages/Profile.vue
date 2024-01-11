<template>
  <inertia-head title="My Profile — Fittify" />

  <div class="relative col-span-3">
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <form v-on:submit.prevent="submit" class="px-6 py-4">
        <div class="grid grid-cols-1 md:grid-cols-4 md:gap-x-6 space-y-4">
          <div class="col-span-full md:col-span-1">
            <Avatar
              v-model="form.avatar"
              :preview="$page.props.auth.user.avatar_url"
              :error="form.errors.avatar"
            />
          </div>
          <div class="col-span-full md:col-span-2 md:col-start-2">
            <TextInput
              label="Name"
              v-model="form.name"
              :error="form.errors.name"
            />
          </div>
          <div class="col-span-full md:col-span-2 md:col-start-2">
            <TextareaInput
              label="Bio"
              v-model="form.bio"
              :error="form.errors.bio"
              placeholder="Share a short introduction of yourself, if you wish"
            />
          </div>
        </div>
        <div class="mt-10">
          <PrimaryButton type="submit" :loading="form.processing"
            >Save</PrimaryButton
          >
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";
import TextInput from "@/components/Shareable/Input/TextInput.vue";
import TextareaInput from "@/components/Shareable/Input/TextareaInput.vue";
import PrimaryButton from "@/components/Shareable/Input/PrimaryButton.vue";
import Avatar from "@/components/Profile/Avatar.vue";
import { usePage } from "@inertiajs/vue3";

export default {
  components: {
    TextInput,
    TextareaInput,
    Avatar,
    PrimaryButton,
  },
  setup() {
    const form = useForm({
      _method: "put",
      name: usePage().props.auth.user.name,
      avatar: null,
      bio: usePage().props.auth.user.bio,
    });
    const availableToHire = ref(true);
    const privateAccount = ref(false);
    const allowCommenting = ref(true);
    const allowMentions = ref(true);
    const submit = () => {
      form.post(`/users/${usePage().props.auth.user.id}`, {
        preserveScroll: true,
      });
    };
    return {
      availableToHire,
      privateAccount,
      allowCommenting,
      allowMentions,
      form,
      submit,
    };
  },
};
</script>
