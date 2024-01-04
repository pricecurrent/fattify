<template>
  <Head title="Diary — Fittify" />

  <div class="lg:col-span-1 lg:col-start-2 lg:row-start-1 space-y-6">
    <div class="rounded-lg bg-white shadow">
      <Write :date="date" />
    </div>
  </div>
  <div
    class="rounded-lg bg-gradient-to-b from-white to-sky-100 overflow-hidden shadow lg:col-start-1 lg:row-start-1"
  >
    <DailyConsumption :date="date" :dailyCaloriesGoal="dailyCaloriesGoal" />
  </div>
  <div
    class="rounded-lg lg:col-span-1 lg:col-start-3 lg:row-start-1 bg-white overflow-hidden shadow"
  >
    <DiaryEntries :date="date" />
  </div>
</template>

<script>
import DailyConsumption from "./../components/Diary/DailyConsumption";
import DiaryEntries from "./../components/Diary/DiaryEntries";
import Write from "./../components/Diary/Write";
import { Head } from "@inertiajs/inertia-vue3";

export default {
  props: {
    date: String,
    dailyCaloriesGoal: Number,
  },
  components: { DailyConsumption, DiaryEntries, Write, Head },
};
</script>
