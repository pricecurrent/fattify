<template>
  <div class="pb-3 pt-6">
    <p class="text-center text-lime-600">Your calories today</p>
    <h2
      class="flex items-center justify-center px-6 text-2xl font-medium text-stone-800"
    >
      <CalendarIcon class="h-8 w-5 text-lime-600/70" />
      <span class="ml-2 font-serif font-bold tracking-wider">{{ date }}</span>
    </h2>
    <SetCaloriesGoal
      v-if="!dailyCaloriesGoal"
      class="mt-8"
    />

    <div class="mx-auto mt-8 w-52 px-6 md:w-64">
      <Graph
        :progress="consumption.percentage"
        :text="consumption.calories"
      />
    </div>
    <div
      v-if="dailyCaloriesGoal"
      class="mt-8 px-6"
    >
      <p class="text-sm text-stone-700">
        * Your daily calories goal is
        <span class="font-num font-semibold">{{ dailyCaloriesGoal }}.</span>
      </p>
    </div>
  </div>

  <div
    class="mt-3 border-t-2 border-lime-200/50 bg-gradient-to-br from-lime-50 to-lime-400/30 px-6 pb-6 pt-3"
  >
    <div class="grid grid-cols-3 gap-x-8">
      <div class="text-center">
        <div class="text-xs font-medium uppercase tracking-wide text-lime-500">
          Proteins
        </div>
        <div class="font-num text-2xl font-bold text-lime-700">
          <span>{{ consumption.proteins }}</span>
          <span class="text-base">g.</span>
        </div>
        <div class="border-t border-lime-300">
          <span class="text-xs font-medium text-lime-600"
            >{{ consumption.proteinsPercentage }}%</span
          >
        </div>
      </div>
      <div class="text-center">
        <div class="text-xs font-medium uppercase tracking-wide text-lime-500">
          Fats
        </div>
        <div class="font-num text-2xl font-bold text-lime-700">
          <span>{{ consumption.fats }}</span>
          <span class="text-base">g.</span>
        </div>
        <div class="border-t border-lime-300">
          <span class="text-xs font-medium text-lime-600"
            >{{ consumption.fatsPercentage }}%</span
          >
        </div>
      </div>
      <div class="text-center">
        <div class="text-xs font-medium uppercase tracking-wide text-lime-500">
          Carbs
        </div>
        <div class="font-num text-2xl font-bold text-lime-700">
          <span>{{ consumption.carbs }}</span>
          <span class="text-base">g.</span>
        </div>
        <div class="border-t border-lime-300">
          <span class="text-xs font-medium text-lime-600"
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
import Graph from '@/components/Shareable/Graph.vue'
import { CalendarIcon } from '@heroicons/vue/24/outline'
import SetCaloriesGoal from '@/components/Diary/SetCaloriesGoal.vue'
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
