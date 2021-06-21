<template>
    <div class="px-6 pt-6 pb-3">
        <h2 class="text-3xl font-semibold text-gray-500 flex items-center">
            <CalendarIcon class="w-8 h-8 text-sky-600/70" />
            <span class="ml-2">{{ date }}</span>
        </h2>
        <div class="mt-8 w-full max-w-xs mx-auto">
            <Graph
                :progress="consumption.percentage"
                :text="consumption.calories"
            />
        </div>

        <div
            v-if="dailyCaloriesGoal"
            class="mt-8"
        >
            <p class="text-gray-500 text-sm">
                * Your daily calories goal is <span class="font-num font-semibold">{{ dailyCaloriesGoal }}</span>
            </p>
        </div>

        <div
            v-if="consumption.calories == 0"
            class="mt-8"
        >
            <p class="text-sky-800 text-base font-semibold text-center">
                <span class="px-2 py-1 rounded-lg shadow bg-gradient-to-r from-cyan-500/40 to-sky-400/50">Time to eat — go get some!</span>
            </p>
        </div>
    </div>

    <div class="px-6 pb-6 pt-3 mt-3 border-t-2 border-sky-200/50 bg-gradient-to-br from-sky-50 to-sky-400/30">
        <div class="grid grid-cols-3">
            <div class="text-center">
                <div class="font-medium text-xs uppercase text-sky-500 tracking-wide">Fats</div>
                <div class="font-num font-bold text-2xl text-sky-700">
                    <span>{{ consumption.fats }}</span>
                    <span class="text-base">g.</span>
                </div>
            </div>
            <div class="text-center">
                <div class="font-medium text-xs uppercase text-sky-500 tracking-wide">Carbs</div>
                <div class="font-num font-bold text-2xl text-sky-700">
                    <span>{{ consumption.carbs }}</span>
                    <span class="text-base">g.</span>
                </div>
            </div>
            <div class="text-center">
                <div class="font-medium text-xs uppercase text-sky-500 tracking-wide">Proteins</div>
                <div class="font-num font-bold text-2xl text-sky-700">
                    <span>{{ consumption.proteins }}</span>
                    <span class="text-base">g.</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import { Inertia } from '@inertiajs/inertia'
import { onMounted, watch, ref, toRefs } from 'vue'
import Graph from './../Shareable/Graph'
import { CalendarIcon } from '@heroicons/vue/solid'
export default {
    props: {
        date: String,
        dailyCaloriesGoal: Number
    },
    components: { Graph, CalendarIcon },
    setup(props) {
        const date = ref(props.date)
        const consumption = ref({})
        const getGraph = async () => {
            const foo = await axios.get('/api/daily-consumption', { params: { date: date.value } })
            consumption.value = foo.data.data
        }
        onMounted(getGraph)
        watch(date, getGraph)
        return { date, consumption }
    },
}

</script>
