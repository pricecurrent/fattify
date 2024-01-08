<template>
  <div>
    <nav
      class="relative rounded-tl-lg rounded-tr-lg shadow flex divide-x divide-gray-200 overflow-x-hidden"
      aria-label="Tabs"
    >
      <a
        href="#"
        @click.prevent="navigate('search')"
        :class="[
          isActive('search')
            ? 'text-gray-900'
            : 'text-gray-500 hover:text-gray-700',
          'rounded-r-lg group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-4 text-sm font-medium text-center hover:bg-gray-50 focus:z-10',
        ]"
      >
        <span>SmartTrack</span>
        <span
          :class="[
            isActive('search') ? 'bg-sky-500' : 'bg-transparent',
            'absolute inset-x-0 bottom-0 h-0.5',
          ]"
        />
      </a>

      <a
        href="#"
        @click.prevent="navigate('macronutrients')"
        :class="[
          isActive('macronutrients')
            ? 'text-gray-900'
            : 'text-gray-500 hover:text-gray-700',
          'group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-4 text-sm font-medium text-center hover:bg-gray-50 focus:z-10',
        ]"
      >
        <span>SelfTrack</span>
        <span
          :class="[
            isActive('macronutrients') ? 'bg-sky-500' : 'bg-transparent',
            'absolute inset-x-0 bottom-0 h-0.5',
          ]"
        />
      </a>
      <a
        href="#"
        @click.prevent="navigate('bookmarks')"
        :class="[
          isActive('bookmarks')
            ? 'text-gray-900'
            : 'text-gray-500 hover:text-gray-700',
          'group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-4 text-sm font-medium text-center hover:bg-gray-50 focus:z-10',
        ]"
      >
        <span>Bookmarks</span>
        <span
          :class="[
            isActive('bookmarks') ? 'bg-sky-500' : 'bg-transparent',
            'absolute inset-x-0 bottom-0 h-0.5',
          ]"
        />
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
    },
  },
  watch: {
    activeTab(value) {
      this.$emit('update:modelValue', value)
    },
  },
  mounted() {
    this.activeTab = this.modelValue
  },
}
</script>
