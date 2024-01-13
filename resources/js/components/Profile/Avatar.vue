<template>
  <div class="flex items-center">
    <img
      v-if="preview"
      class="h-32 w-32 rounded-full object-cover shadow-xl ring ring-lime-500/70 ring-offset-4"
      :src="preview"
      alt="avatar"
    />
    <label class="relative mx-auto flex h-36 w-36 items-center justify-center">
      <SecondaryButton>Change photo</SecondaryButton>
      <FileInput
        id="user-photo"
        v-model="file"
        class="absolute h-full w-full cursor-pointer rounded-md border-stone-300 opacity-0"
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
