<template>
  <nav
    v-if="entries.length > 0"
    class="h-full overflow-y-auto"
    aria-label="Directory"
  >
    <div
      v-for="mealTime in Object.keys(groupedEntries)"
      :key="mealTime"
      class="relative"
    >
      <div
        class="border-b border-t border-gray-200 bg-gray-50 px-6 py-1 text-sm font-medium text-gray-500"
      >
        <div class="flex items-center justify-between">
          <h3 class="capitalize">{{ mealTime }}</h3>
          <div>
            <span class="font-num font-semibold">{{
              totalCaloriesInMealTime(mealTime)
            }}</span>
            cal.
          </div>
        </div>
      </div>
      <ul class="relative z-0 divide-y divide-gray-200">
        <li
          v-for="entry in groupedEntries[mealTime]"
          :key="entry.id"
          class="bg-white"
        >
          <div
            class="relative flex items-center space-x-3 px-6 py-5 hover:bg-gray-50"
          >
            <div class="min-w-0 flex-1">
              <p class="text-sm font-medium text-gray-900">
                {{ entry.dishName }}
                <span
                  v-show="entry.weight"
                  class="ml-px inline-block text-xs text-cyan-700"
                  >{{ entry.weight }}g.</span
                >
              </p>
              <div class="mt-1 flex items-center text-sm text-gray-500">
                <div>
                  <span class="font-num font-semibold">{{
                    entry.calories
                  }}</span>
                  <span> cal.</span>
                </div>
                <div class="ml-4">
                  <span class="font-num font-semibold text-cyan-700">{{
                    entry.proteins
                  }}</span>
                  &bull;
                  <span class="font-num font-semibold text-cyan-700">{{
                    entry.fats
                  }}</span>
                  &bull;
                  <span class="font-num font-semibold text-cyan-700">{{
                    entry.carbs
                  }}</span>
                </div>
              </div>
            </div>
            <div class="flex items-center space-x-1.5">
              <button
                v-on:click.prevent="bookmark(entry)"
                v-if="
                  entry.isMadeFromBookmark === false &&
                  entry.bookmarkedAt === null
                "
              >
                <BookmarkIcon class="h-4 w-4 text-sky-500" />
              </button>
              <button v-on:click.prevent="remove(entry)">
                <TrashIcon class="h-4 w-4 text-red-900/60" />
              </button>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <div v-else>
    <div class="py-5 text-center">
      <svg
        class="mx-auto h-12 w-12 text-gray-400"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        aria-hidden="true"
      >
        <path
          vector-effect="non-scaling-stroke"
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"
        />
      </svg>
      <h3 class="mt-2 text-sm font-medium text-gray-900">Diary is Empty</h3>
      <p class="mt-1 text-sm text-gray-500">Nothing has been eaten today</p>
    </div>
  </div>
  <BookmarkEntryModal
    v-if="showBookmarkModal"
    :open="showBookmarkModal"
    :entry="bookmarkingEntry"
    @close="showBookmarkModal = false"
  />
</template>

<script>
import { fetchEntries } from './../../api/diary'
import { onUnmounted, onMounted, ref, computed } from 'vue'
import { BookmarkIcon, TrashIcon } from '@heroicons/vue/24/outline'
import _ from 'lodash'
import BookmarkEntryModal from '@/components/Shareable/Modals/BookmarkEntryModal.vue'
import { router } from '@inertiajs/vue3'

export default {
  props: ['date'],
  components: { BookmarkIcon, TrashIcon, BookmarkEntryModal },
  setup(props) {
    const entries = ref([])
    const showBookmarkModal = ref(false)
    const bookmarkingEntry = ref(null)
    const groupedEntries = computed(() => {
      const grouped = _(entries.value).groupBy('mealTime').value()
      const sorted = Object.keys(grouped)
        .sort((a, b) => {
          let indexOfA = ['breakfast', 'lunch', 'dinner', 'other'].indexOf(a)
          let indexOfB = ['breakfast', 'lunch', 'dinner', 'other'].indexOf(b)
          if (indexOfA > indexOfB) return 1
          if (indexOfA < indexOfB) return -1
          return 0
        })
        .reduce((obj, key) => {
          obj[key] = grouped[key]
          return obj
        }, {})
      return sorted
    })
    const totalCaloriesInMealTime = mealTime => {
      return _(groupedEntries.value[mealTime]).sumBy('calories')
    }
    const bookmark = entry => {
      bookmarkingEntry.value = entry
      showBookmarkModal.value = true
    }
    const remove = entry => {
      router.delete(
        route('nutrition-diary-entries.destroy', {
          nutritionDiaryEntry: entry.id,
        }),
        { preserveScroll: true },
      )
    }

    const successfulVisitEventListener = async event => {
      if (event.detail.page.url != '/diary') return
      entries.value = await fetchEntries({ date: props.date })
    }
    onMounted(async () => {
      document.addEventListener('inertia:success', successfulVisitEventListener)
      entries.value = await fetchEntries({ date: props.date })
    })
    onUnmounted(() =>
      document.removeEventListener(
        'inertia:success',
        successfulVisitEventListener,
      ),
    )
    return {
      entries,
      groupedEntries,
      totalCaloriesInMealTime,
      showBookmarkModal,
      bookmark,
      bookmarkingEntry,
      remove,
    }
  },
}
</script>
