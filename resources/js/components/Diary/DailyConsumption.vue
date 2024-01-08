<template>
  <div class="pt-6 pb-3">
    <h2
      class="px-6 text-2xl font-medium text-gray-800 flex items-center justify-center"
    >
      <CalendarIcon class="w-5 h-8 text-sky-600/70" />
      <span class="ml-2 font-num">{{ date }}</span>
    </h2>
    <SetCaloriesGoal
      v-if="!dailyCaloriesGoal"
      class="mt-8"
    />

    <div class="px-6 mt-8 w-full max-w-xs mx-auto">
      <Graph
        :progress="consumption.percentage"
        :text="consumption.calories"
      />
    </div>
    <div
      v-if="dailyCaloriesGoal"
      class="mt-8 px-6"
    >
      <p class="text-gray-700 text-sm">
        * Your daily calories goal is
        <span class="font-num font-semibold">{{ dailyCaloriesGoal }}.</span>
      </p>
    </div>
  </div>

  <div
    class="px-6 pb-6 pt-3 mt-3 border-t-2 border-sky-200/50 bg-gradient-to-br from-sky-50 to-sky-400/30"
  >
    <div class="grid grid-cols-3 gap-x-8">
      <div class="text-center">
        <div class="font-medium text-xs uppercase text-sky-500 tracking-wide">
          Proteins
        </div>
        <div class="font-num font-bold text-2xl text-sky-700">
          <span>{{ consumption.proteins }}</span>
          <span class="text-base">g.</span>
        </div>
        <div class="border-t border-sky-300">
          <span class="text-xs text-sky-600 font-medium"
            >{{ consumption.proteinsPercentage }}%</span
          >
        </div>
      </div>
      <div class="text-center">
        <div class="font-medium text-xs uppercase text-sky-500 tracking-wide">
          Fats
        </div>
        <div class="font-num font-bold text-2xl text-sky-700">
          <span>{{ consumption.fats }}</span>
          <span class="text-base">g.</span>
        </div>
        <div class="border-t border-sky-300">
          <span class="text-xs text-sky-600 font-medium"
            >{{ consumption.fatsPercentage }}%</span
          >
        </div>
      </div>
      <div class="text-center">
        <div class="font-medium text-xs uppercase text-sky-500 tracking-wide">
          Carbs
        </div>
        <div class="font-num font-bold text-2xl text-sky-700">
          <span>{{ consumption.carbs }}</span>
          <span class="text-base">g.</span>
        </div>
        <div class="border-t border-sky-300">
          <span class="text-xs text-sky-600 font-medium"
            >{{ consumption.carbsPercentage }}%</span
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { onMounted, ref, onUnmounted } from 'vue'
import Graph from './../Shareable/Graph'
import { CalendarIcon } from '@heroicons/vue/outline'
import SetCaloriesGoal from '@/components/Diary/SetCaloriesGoal'
export default {
  props: {
    date: String,
    dailyCaloriesGoal: Number,
  },
  components: { Graph, CalendarIcon, SetCaloriesGoal },
  setup(props) {
    const date = ref(props.date)
    const consumption = ref({})
    const getGraph = async () => {
      const response = await axios.get('/api/daily-consumption', {
        params: { date: date.value },
      })
      consumption.value = response.data.data
    }
    const successfulVisitEventListener = event => {
      if (event.detail.page.url != '/diary') return
      getGraph()
    }
    onMounted(() => {
      getGraph()
      document.addEventListener('inertia:success', successfulVisitEventListener)
    })
    onUnmounted(() =>
      document.removeEventListener(
        'inertia:success',
        successfulVisitEventListener,
      ),
    )
    return { date, consumption }
  },
}
</script>
