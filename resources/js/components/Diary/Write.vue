<template>
    <div class="md:px-6 md:mt-4">
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
            v-if="writingMode === 'search'"
        />
    </div>
</template>
<script>
import { ref } from 'vue'
import WritingMode from './WritingMode'
import WriteFromBookmarks from './WriteFromBookmarks'
import WriteMacronutrients from './WriteMacronutrients'
import WriteSearchedFood from './WriteSearchedFood'
export default {
    props: {
        date: String,
    },
    components: { WritingMode, WriteFromBookmarks, WriteMacronutrients, WriteSearchedFood },
    setup(props) {
        const writingMode = ref('macronutrients')
        return { writingMode }
    }
}

</script>
