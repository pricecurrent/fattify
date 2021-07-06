<template>
    <inertia-head title="My Diary — Fattify" />

    <div class="lg:col-span-2 rounded-lg bg-white overflow-hidden">
        <Write :date="date" />
    </div>
    <div class="rounded-lg bg-gradient-to-b from-white to-sky-100 overflow-hidden shadow">
        <DailyConsumption
            :date="date"
            :dailyCaloriesGoal="dailyCaloriesGoal"
        />
    </div>
</template>

<script>
import DailyConsumption from './../components/Diary/DailyConsumption'
import Write from './../components/Diary/Write'
import { computed } from 'vue'
export default {
    props: {
        user: Object,
        date: String,
        dailyCaloriesGoal: Number,
    },
    components: { DailyConsumption, Write },
}

</script>
