<template>
    <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-800">
            How much did you eat?
        </h3>
    </div>
    <div class="md:px-6 md:mt-4">
        <WritingMode v-model="writingMode" />
    </div>
    <div>
        <WriteMacronutrients
            :date="date"
            class="py-6"
            v-if="writingMode === 'macronutrients'"
        />
        <WriteCalories
            class="p-6"
            v-if="writingMode === 'calories'"
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
import WriteCalories from './WriteCalories'
import WriteMacronutrients from './WriteMacronutrients'
import WriteSearchedFood from './WriteSearchedFood'
export default {
    props: {
        date: String,
    },
    components: { WritingMode, WriteCalories, WriteMacronutrients, WriteSearchedFood },
    setup(props) {
        const writingMode = ref('macronutrients')
        return { writingMode }
    }
}

</script>
