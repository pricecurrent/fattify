<template>
    <div>
        <nav
            class="relative z-0 rounded-lg shadow flex divide-x divide-gray-200"
            aria-label="Tabs"
        >
            <a
                @click.prevent="navigate('calories')"
                :class="[isActive('calories') ? 'text-gray-900' : 'text-gray-500 hover:text-gray-700',  'rounded-l-lg', 'group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-4 text-sm font-medium text-center hover:bg-gray-50 focus:z-10']"
            >
                <span>Calories</span>
                <span :class="[isActive('calories') ? 'bg-indigo-500' : 'bg-transparent', 'absolute inset-x-0 bottom-0 h-0.5']" />
            </a>
            <a
                @click.prevent="navigate('macronutrients')"
                :class="[isActive('macronutrients') ? 'text-gray-900' : 'text-gray-500 hover:text-gray-700', 'group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-4 text-sm font-medium text-center hover:bg-gray-50 focus:z-10']"
            >
                <span>Macro nutrients</span>
                <span :class="[isActive('macronutrients') ? 'bg-indigo-500' : 'bg-transparent', 'absolute inset-x-0 bottom-0 h-0.5']" />
            </a>
            <a
                @click.prevent="navigate('search')"
                :class="[isActive('search') ? 'text-gray-900' : 'text-gray-500 hover:text-gray-700', 'rounded-r-lg group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-4 text-sm font-medium text-center hover:bg-gray-50 focus:z-10']"
            >
                <span>Search Food</span>
                <span :class="[isActive('search') ? 'bg-indigo-500' : 'bg-transparent', 'absolute inset-x-0 bottom-0 h-0.5']" />
            </a>
        </nav>
    </div>
</template>

<script>
export default {
    props: ['modelValue'],
    data() {
        return {
            activeTab: null,
        }
    },
    methods: {
        navigate(tab) {
            this.activeTab = tab
        },
        isActive(tab) {
            return this.activeTab === tab
        }
    },
    watch: {
        activeTab(value) {
            this.$emit('update:modelValue', value)
        },
    },
    mounted() {
        this.activeTab = this.modelValue
    }
}

</script>
