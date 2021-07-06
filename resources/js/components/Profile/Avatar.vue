<template>
    <div>
        <label class="relative flex items-center justify-center w-36 h-36 mx-auto">
            <img
                v-if="preview"
                class="object-cover rounded-full h-full w-full"
                :src="preview"
                alt="avatar"
            />
            <UserCircleIcon
                v-else
                class="text-emerald-300 w-full h-full"
            />
            <FileInput
                id="user-photo"
                v-model="file"
                class="absolute w-full h-full opacity-0 cursor-pointer border-gray-300 rounded-md"
            />
        </label>
    </div>
</template>
<script>
import { UserCircleIcon, } from '@heroicons/vue/solid'
import { ref, watch, computed, toRef } from 'vue'
import FileInput from '@/components/Shareable/Input/FileInput'
export default {
    props: ['modelValue', 'preview'],
    components: { FileInput, UserCircleIcon },
    setup(props, { emit }) {
        const file = ref(null)
        const preview = ref(props.preview)
        watch(file, (value) => {
            if (!value) {
                return preview.value = null
            }
            const reader = new FileReader()
            reader.readAsDataURL(value);
            reader.onload = (e) => {
                preview.value = e.target.result;
            };
            emit('update:modelValue', value)
        })
        return { file, preview }
    }
}

</script>
