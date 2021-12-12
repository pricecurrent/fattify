<template>

    <Head title="My Diary — Fattify" />

    <div class="lg:col-span-2 space-y-6">
        <div class="rounded-lg bg-white shadow">
            <Write :date="date" />
        </div>
    </div>
    <div class="rounded-lg bg-gradient-to-b from-white to-sky-100 overflow-hidden shadow">
        <DailyConsumption
            :date="date"
            :dailyCaloriesGoal="dailyCaloriesGoal"
        />
    </div>
    <div class="rounded-lg bg-white overflow-hidden shadow">
        <DiaryEntries :date="date" />
    </div>

</template>

<script>
import DailyConsumption from './../components/Diary/DailyConsumption'
import DiaryEntries from './../components/Diary/DiaryEntries'
import Write from './../components/Diary/Write'
import { Head } from '@inertiajs/inertia-vue3'

export default {
    props: {
        date: String,
        dailyCaloriesGoal: Number,
    },
    components: { DailyConsumption, DiaryEntries, Write, Head },
}

</script>
