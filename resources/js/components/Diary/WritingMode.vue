<template>
  <div>
    <nav
      class="relative flex divide-x divide-stone-200 overflow-x-hidden rounded-tl-lg rounded-tr-lg shadow"
      aria-label="Tabs"
    >
      <a
        href="#"
        @click.prevent="navigate('search')"
        :class="[
          isActive('search')
            ? 'text-stone-900'
            : 'text-stone-500 hover:text-stone-700',
          'group relative min-w-0 flex-1 overflow-hidden rounded-r-lg bg-white px-4 py-4 text-center text-sm font-medium hover:bg-stone-50 focus:z-10',
        ]"
      >
        <span>SmartTrack</span>
        <span
          :class="[
            isActive('search') ? 'bg-lime-500' : 'bg-transparent',
            'absolute inset-x-0 bottom-0 h-0.5',
          ]"
        />
      </a>

      <a
        href="#"
        @click.prevent="navigate('macronutrients')"
        :class="[
          isActive('macronutrients')
            ? 'text-stone-900'
            : 'text-stone-500 hover:text-stone-700',
          'group relative min-w-0 flex-1 overflow-hidden bg-white px-4 py-4 text-center text-sm font-medium hover:bg-stone-50 focus:z-10',
        ]"
      >
        <span>SelfTrack</span>
        <span
          :class="[
            isActive('macronutrients') ? 'bg-lime-500' : 'bg-transparent',
            'absolute inset-x-0 bottom-0 h-0.5',
          ]"
        />
      </a>
      <a
        href="#"
        @click.prevent="navigate('bookmarks')"
        :class="[
          isActive('bookmarks')
            ? 'text-stone-900'
            : 'text-stone-500 hover:text-stone-700',
          'group relative min-w-0 flex-1 overflow-hidden bg-white px-4 py-4 text-center text-sm font-medium hover:bg-stone-50 focus:z-10',
        ]"
      >
        <span>Bookmarks</span>
        <span
          :class="[
            isActive('bookmarks') ? 'bg-lime-500' : 'bg-transparent',
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
