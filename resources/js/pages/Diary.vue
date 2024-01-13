<template>
  <Head title="Diary — Fittify" />

  <div class="space-y-6 lg:col-span-1 lg:col-start-2 lg:row-start-1">
    <div class="rounded-lg bg-white shadow">
      <Write
        :date="date"
        :nutriDialog="nutriDialog"
      />
    </div>
  </div>
  <div
    class="overflow-hidden rounded-lg bg-gradient-to-b from-white to-lime-100 shadow lg:col-start-1 lg:row-start-1"
  >
    <DailyConsumption
      :date="date"
      :dailyCaloriesGoal="dailyCaloriesGoal"
    />
  </div>
  <div
    class="overflow-hidden rounded-lg bg-white shadow lg:col-span-1 lg:col-start-3 lg:row-start-1"
  >
    <DiaryEntries :date="date" />
  </div>
</template>

<script>
import DailyConsumption from '@/components/Diary/DailyConsumption.vue'
import DiaryEntries from '@/components/Diary/DiaryEntries.vue'
import Write from '@/components/Diary/Write.vue'
import { Head } from '@inertiajs/vue3'

export default {
  components: { DailyConsumption, DiaryEntries, Write, Head },
  props: {
    date: String,
    dailyCaloriesGoal: Number,
    nutriDialog: null,
  },
}
</script>
