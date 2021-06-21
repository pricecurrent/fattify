<template>
    <div class="p-6">
        <div class="relative text-white focus-within:text-gray-600">
            <div class="pointer-events-none absolute inset-y-0 left-0 pl-3 flex items-center">
                <BookmarkIcon
                    class="h-5 w-5 text-sky-700/50"
                    aria-hidden="true"
                />
            </div>

            <input
                class="block w-full bg-sky-100 py-2 pl-10 pr-3 border border-transparent rounded-md leading-5 text-gray-900 font-semibold font-nums placeholder-sky-700/50 transition focus:outline-none focus:bg-opacity-20 focus:border-transparent focus:placeholder-sky-500 focus:ring focus:ring-sky-300"
                placeholder="I know the calories"
                type="text"
            />
        </div>
    </div>
</template>
<script>
import { ref } from 'vue'
import { BookmarkIcon } from '@heroicons/vue/outline'
export default {
    props: {
        date: String,
    },
    components: { BookmarkIcon },
    setup(props) {
        const calories = ref(0)
    }
}

</script>
