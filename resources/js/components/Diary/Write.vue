<template>
  <div class="md:mt-4 md:px-6 lg:mt-0">
    <WritingMode v-model="writingMode" />
  </div>
  <div>
    <WriteMacronutrients
      :date="date"
      class="py-6"
      v-if="writingMode === 'macronutrients'"
    />

    <WriteFromBookmarks
      class="p-6"
      v-if="writingMode === 'bookmarks'"
    />

    <WriteSearchedFood
      :date="date"
      :nutriDialog="nutriDialog"
      v-if="writingMode === 'search'"
    />
  </div>
</template>
<script>
import { ref } from 'vue'
import WritingMode from '@/components/Diary/WritingMode.vue'
import WriteFromBookmarks from '@/components/Diary/WriteFromBookmarks.vue'
import WriteMacronutrients from '@/components/Diary/WriteMacronutrients.vue'
import WriteSearchedFood from '@/components/Diary/WriteSearchedFood.vue'
export default {
  props: {
    date: String,
    nutriDialog: null,
  },
  components: {
    WritingMode,
    WriteFromBookmarks,
    WriteMacronutrients,
    WriteSearchedFood,
  },

  setup() {
    const writingMode = ref('search')
    return { writingMode }
  },
}
</script>
