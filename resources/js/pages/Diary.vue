<template>
    <inertia-head title="My Diary — Fattify" />

    <litepie-datepicker
        as-single
        v-model="dateValue"
        v-slot="{ value }"
        :formatter="{date: 'MMMM DD, YYYY', month: 'MMMM'}"
    >
        <span class="text-white">
            {{ value || date }}
        </span>
        <button>
            <CalendarIcon class="w-4 h-4 text-white" />
        </button>
    </litepie-datepicker>

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
import { CalendarIcon } from '@heroicons/vue/outline'
import { ref, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'

export default {
    props: {
        date: String,
        dailyCaloriesGoal: Number,
    },
    components: { DailyConsumption, DiaryEntries, Write, CalendarIcon },
    setup(props) {
        const dateValue = ref(props.date)

        watch(dateValue, (newVal) => {
            Inertia.visit(`/diary?date=${newVal}`, {
                preserveScroll: true
            })
        })

        return { dateValue }
    },
}

</script>
