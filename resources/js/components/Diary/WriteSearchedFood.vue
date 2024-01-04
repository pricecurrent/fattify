<template>
  <form class="px-4 py-3" @submit.prevent="analyze">
    <TextareaInput
      v-model="form.prompt"
      placeholder="Specify in free form what you have eaten, e.g. 1 chicken breast no skin with mashed potato 1 small portion"
    />

    <div class="mt-4 flex justify-end">
      <div>
        <PrimaryButton type="submit">Analyze</PrimaryButton>
      </div>
    </div>
  </form>

  <ul role="list" class="divide-y px-4 divide-gray-100">
    <li v-for="(suggestion, i) in conversation" :key="i" class="py-5">
      <div class="flex min-w-0 gap-x-4">
        <img
          class="h-12 w-12 flex-none rounded-full bg-gray-50"
          src="@/assets/images/nutritionist-avatar.png"
          alt="Nutritionist Assistant"
        />
        <div class="min-w-0 flex-auto">
          <p class="text-sm font-semibold leading-6 text-gray-900">Jackob</p>
          <p class="text-sm leading-6 text-gray-500">Nutritionist Assistant</p>
        </div>
      </div>
      <div class="mt-8 flow-root p-6 border border-gray-300 rounded shadow-sm">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div
            class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8"
          >
            <table class="min-w-full divide-y divide-gray-300">
              <thead>
                <tr class="divide-x divide-gray-200">
                  <th
                    scope="col"
                    class="py-3.5 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-0"
                  >
                    Name
                  </th>
                  <th
                    scope="col"
                    class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900"
                  >
                    Fats
                  </th>
                  <th
                    scope="col"
                    class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900"
                  >
                    Carbs
                  </th>
                  <th
                    scope="col"
                    class="py-3.5 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pr-0"
                  >
                    Proteins
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                <tr
                  v-for="(item, index) in suggestion"
                  :key="index"
                  class="divide-x divide-gray-200"
                >
                  <td
                    class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-0"
                  >
                    {{ item.name }}
                  </td>
                  <td class="whitespace-nowrap p-4 text-sm text-gray-500">
                    {{ item.fats }}
                  </td>
                  <td class="whitespace-nowrap p-4 text-sm text-gray-500">
                    {{ item.carbs }}
                  </td>
                  <td
                    class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-0"
                  >
                    {{ item.proteins }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </li>
  </ul>
</template>

<script>
import TextareaInput from "@/components/Shareable/Input/TextareaInput";
import PrimaryButton from "@/components/Shareable/Input/PrimaryButton";
export default {
  components: { TextareaInput, PrimaryButton },
  data() {
    return {
      conversation: [
        [
          { name: "chicken breast", carbs: 0, fats: 3, proteins: 46 },
          { name: "greek yogurt", carbs: 6, fats: 5, proteins: 17 },
        ],
        [
          { name: "chicken breast", carbs: 0, fats: 3, proteins: 46 },
          { name: "greek yogurt", carbs: 6, fats: 5, proteins: 17 },
        ],
      ],
      form: {
        prompt: "",
      },
    };
  },
  methods: {
    analyze() {
      axios
        .post(route("api.analyze"), {
          prompt: this.form.prompt,
        })
        .then((response) => {
          console.log({ response });
          this.conversation.push(response.data);
        });
    },
  },
};
</script>
