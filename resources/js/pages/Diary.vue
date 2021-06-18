<template>
    <inertia-head title="Welcome" />

    <div class="grid grid-cols-1 gap-4 lg:order-last">
        <div class="rounded-lg bg-white overflow-hidden">
            <div class="p-6">
                <GraphConsumedOnDate :date="date" />
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4 lg:col-span-2">
        <div class="rounded-lg bg-white overflow-hidden">
            <div class="p-6"></div>
        </div>
    </div>
</template>

<script>
import GraphConsumedOnDate from './../components/Diary/GraphConsumedOnDate'
import { computed } from 'vue'
export default {
    props: {
        user: Object,
        date: String,
    },
    components: { GraphConsumedOnDate },
    setup(props) {}
}

</script>
