<template>
    <Listbox
        v-model="selectedBookmark"
        v-slot="{ open }"
    >
        <div class="relative mt-1">
            <ListboxButton :class="selectButtonClassNames">
                <span
                    v-if="selectedBookmark"
                    class="block truncate"
                >
                    <span>{{ selectedBookmark.name }}</span>
                    <span class="ml-2 text-xs text-gray-500 font-num inline-block font-bold"> {{ selectedBookmark.proteins }} / {{ selectedBookmark.fats }} / {{ selectedBookmark.carbs }} </span>
                </span>

                <span
                    v-else
                    class="block truncate"
                >
                    Select Bookmark
                </span>
                <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <SelectorIcon
                        class="w-5 h-5 text-gray-400"
                        aria-hidden="true"
                    />
                </span>
            </ListboxButton>
            <transition
                leave-active-class="transition duration-100 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div v-show="open">
                    <ListboxOptions class="absolute z-10 w-full pb-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg max-h-72 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                        <div class="sticky top-0 z-10 border-b px-3 pt-4 pb-3 bg-gray-100 border-gray-200 border-b-2  border-transparent focus-within:border-sky-500 focus-within:bg-white transition">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-2 flex items-center justify-center">
                                    <SearchIcon class="w-5 h-5 text-gray-400" />
                                </div>
                                <input
                                    type="search"
                                    placeholder="Search..."
                                    v-on:keydown.space.stop="foo"
                                    v-model="keyword"
                                    class="w-full block px-0 pl-8 bg-white shadow-sm focus:shadow-none border-none rounded-md focus:outline-none focus:border-none focus:ring-0"
                                >
                            </div>
                        </div>
                        <ListboxOption
                            v-show="bookmarks.length"
                            v-slot="{ active, selected }"
                            v-for="bookmark in bookmarks"
                            :key="bookmark.id"
                            :value="bookmark"
                            as="template"
                        >
                            <li :class="[active ? 'text-amber-900 bg-amber-100' : 'text-gray-900', 'cursor-default select-none relative py-2 pl-10 pr-4']">
                                <span :class="[selected ? 'font-medium' : 'font-normal', 'block truncate', ]">{{ bookmark.name }}</span>
                                <span
                                    v-if="selected"
                                    class="absolute inset-y-0 left-0 flex items-center pl-3 text-amber-600"
                                >
                                    <CheckIcon
                                        class="w-5 h-5"
                                        aria-hidden="true"
                                    />
                                </span>
                            </li>
                        </ListboxOption>
                        <div v-show="bookmarks.length == 0">
                            <div class="cursor-default select-none relative px-4 py-3 flex flex-col justify-center items-center">
                                <BookmarkIcon class="w-8 h-8 text-sky-500/50" />
                                <div class="mt-2 text-sm">{{ emptyBookmarksCopy }}</div>
                                <!-- <div class="mt-1 text-sm">You may <a href="#"class="link">create one</a> here</div> -->
                            </div>
                        </div>
                    </ListboxOptions>
                </div>
            </transition>
        </div>
    </Listbox>
</template>

<script>
import {
    Listbox,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
} from '@headlessui/vue'
import { selectInputClassNames } from '@/html-classes'
import { CheckIcon, SelectorIcon, SearchIcon } from '@heroicons/vue/solid'
import { BookmarkIcon } from '@heroicons/vue/outline'
import axios from 'axios'
import { debounce } from 'lodash'

export default {
    props: ['modelValue'],
    components: {
        Listbox,
        ListboxButton,
        ListboxOptions,
        ListboxOption,
        CheckIcon,
        SelectorIcon,
        SearchIcon,
        BookmarkIcon,
    },
    data() {
        return {
            selectedBookmark: null,
            keyword: null,
            bookmarks: [],
        }
    },
    methods: {
        async fetchBookmarks() {
            const response = await axios.get(`/api/users/${this.$page.props.auth.user.id}/bookmarks`, {
                params: { search: this.keyword }
            })
            this.bookmarks = response.data.data
        },
        inertiaSuccessEventListener(event) {
            if (event.detail.page.url != '/diary') return
            this.keyword = null
            this.fetchBookmarks()
        }
    },
    computed: {
        selectButtonClassNames() {
            return [...selectInputClassNames, 'text-base'];
        },
        emptyBookmarksCopy() {
            return this.keyword && this.bookmarks.length == 0 ?
                'There are no bookmarks found.' :
                'You have no bookmarks.'
        }
    },
    watch: {
        keyword: {
            handler: debounce(function() {
                this.fetchBookmarks()
            }, 333)
        },
        selectedBookmark(value) {
            if (value) {
                this.$emit('update:modelValue', value.id)
            }
        },
        modelValue(value) {
            if (value === null) {
                this.selectedBookmark = null
            }
        },
    },
    async mounted() {
        await this.fetchBookmarks()
        document.addEventListener('inertia:success', this.inertiaSuccessEventListener)
    },
    unmounted() {
        document.removeEventListener('inertia:success', this.inertiaSuccessEventListener)
    }
}

</script>
