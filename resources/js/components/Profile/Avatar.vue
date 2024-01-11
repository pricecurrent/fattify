<template>
  <div class="flex items-center">
    <img
      v-if="preview"
      class="object-cover rounded-full h-32 w-32 shadow-xl ring ring-offset-4 ring-fuchsia-500/70"
      :src="preview"
      alt="avatar"
    />
    <label class="relative flex items-center justify-center w-36 h-36 mx-auto">
      <SecondaryButton>Change photo</SecondaryButton>
      <FileInput
        id="user-photo"
        v-model="file"
        class="absolute w-full h-full opacity-0 cursor-pointer border-gray-300 rounded-md"
      />
    </label>
  </div>
  <p
    class="text-sm text-red-500"
    v-if="error"
  >
    {{ error }}
  </p>
</template>
<script>
import { UserCircleIcon } from '@heroicons/vue/24/solid'
import { ref, watch, computed, toRef } from 'vue'
import FileInput from '@/components/Shareable/Input/FileInput.vue'
import SecondaryButton from '@/components/Shareable/Input/SecondaryButton.vue'
export default {
  props: ['modelValue', 'preview', 'error'],
  components: { FileInput, UserCircleIcon, SecondaryButton },
  setup(props, { emit }) {
    const file = ref(null)
    const preview = ref(props.preview)
    watch(file, value => {
      if (!value) {
        return (preview.value = props.preview)
      }
      const reader = new FileReader()
      reader.readAsDataURL(value)
      reader.onload = e => {
        preview.value = e.target.result
      }
      emit('update:modelValue', value)
    })
    return { file, preview }
  },
}
</script>
