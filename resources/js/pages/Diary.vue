<template>
    <inertia-head title="Welcome" />

    <div class="grid grid-cols-1 gap-4 order-last">
        <div class="rounded-lg bg-gradient-to-b from-white to-sky-100 overflow-hidden shadow">
            <DailyConsumption
                :date="date"
                :dailyCaloriesGoal="dailyCaloriesGoal"
            />
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4 lg:col-span-2">
        <div class="rounded-lg bg-white overflow-hidden">
            <Write :date="date" />
        </div>
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
