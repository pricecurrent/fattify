<template>
  <div class="rounded-md bg-fuchsia-50 p-4">
    <div class="flex">
      <div class="flex-shrink-0">
        <InformationCircleIcon
          class="h-5 w-5 text-fuchsia-400"
          aria-hidden="true"
        />
      </div>
      <div class="ml-3 flex-1">
        <p class="text-sm text-fuchsia-700">
          Set your calorie daily goal to get a better feedback
        </p>
        <p class="mt-3 text-sm">
          <a
            @click.prevent="showField = !showField"
            href="#"
            class="whitespace-nowrap font-medium text-fuchsia-700 hover:text-fuchsia-600"
            >Set it up <span aria-hidden="true">&rarr;</span>
          </a>
        </p>
        <form
          v-if="showField"
          @submit.prevent="form.put(`/users/${$page.props.auth.user.id}`)"
          class="flex items-center mt-2"
        >
          <div class="flex-1">
            <TextInput
              type="text"
              v-if="showField"
              v-model="form.daily_calories_goal"
              placeholder="3000"
            />
          </div>
          <div class="flex-1 flex items-center justify-center">
            <SecondaryButton type="submit" value="save">Save</SecondaryButton>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { InformationCircleIcon } from "@heroicons/vue/24/solid";
import { ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import TextInput from "@/components/Shareable/Input/TextInput";
import SecondaryButton from "@/components/Shareable/Input/SecondaryButton";
export default {
  components: { InformationCircleIcon, TextInput, SecondaryButton },
  setup() {
    const showField = ref(false);
    const form = useForm({
      daily_calories_goal: null,
    });
    return {
      showField,
      form,
    };
  },
};
</script>
