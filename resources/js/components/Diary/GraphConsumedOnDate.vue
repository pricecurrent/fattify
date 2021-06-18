<template>
    {{ date }}
    <h2>here is your graph</h2>
    <Graph />

    <section class="px-4 mt-6">
        <h3>Here is your datepicker:</h3>
        <input
            type="text"
            v-model="date"
        >
        <button
            @click="simulateDatepicker"
            class="px-3 rounded py-2 border border-gray-200 uppercase bg-gradient-to-r from-yellow-500 to-fuchsia-400 font-semibold tracking-wide text-red-900"
        >change date to something else</button>
    </section>

</template>

<script>
import axios from 'axios'
import { Inertia } from '@inertiajs/inertia'
import { onMounted, watch, ref, toRefs } from 'vue'
import Graph from './../Shareable/Graph'
Date.prototype.addDays = function(days) {
    var date = new Date(this.valueOf());
    date.setDate(date.getDate() + days);
    return date;
}
export default {
    props: {
        date: String,
    },
    components: { Graph },
    setup(props) {
        const date = ref(props.date)
        const graph = ref({})
        const getGraph = async () => {
            const foo = await axios.get('/api/daily-consumption', { params: { date: date.value } })
            graph.value = foo.data.data
        }
        const simulateDatepicker = () => {
            date.value = new Date().addDays(Math.floor(Math.random() * 100)).toISOString().split('T')[0]
        }
        onMounted(getGraph)
        watch(date, getGraph)
        return { date, graph, simulateDatepicker }
    },
}

</script>
