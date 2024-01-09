<template>
    <div>
        <Listbox
            v-bind="$attrs"
            as="div"
            v-model="selected"
            :id="id"
        >
            <ListboxLabel
                v-if="label"
                class="block text-sm font-medium text-gray-700"
            >
                {{ label }}
            </ListboxLabel>
            <div class="mt-1 relative">
                <ListboxButton :class="classNames">
                    <span
                        v-if="selected"
                        class="block truncate"
                    >{{ selected.name }}</span>
                    <span
                        v-else
                        class="block truncate"
                    >{{ placeholder ? placeholder : 'Select' }}</span>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <SelectorIcon
                            class="h-5 w-5 text-gray-400"
                            aria-hidden="true"
                        />
                    </span>
                </ListboxButton>

                <transition
                    leave-active-class="transition ease-in duration-100"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <ListboxOptions class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                        <ListboxOption
                            as="template"
                            v-for="option in options"
                            :key="option.value"
                            :value="option"
                            v-slot="{ active, selected }"
                        >
                            <li :class="[active ? 'text-white bg-sky-600' : 'text-gray-900', 'cursor-default select-none relative py-2 pl-8 pr-4']">
                                <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">
                                    {{ option.name }}
                                </span>

                                <span
                                    v-if="selected"
                                    :class="[active ? 'text-white' : 'text-sky-600', 'absolute inset-y-0 left-0 flex items-center pl-1.5']"
                                >
                                    <CheckIcon
                                        class="h-5 w-5"
                                        aria-hidden="true"
                                    />
                                </span>
                            </li>
                        </ListboxOption>
                    </ListboxOptions>
                </transition>
            </div>
        </Listbox>
        <div
            v-if="error"
            class="mt-1 text-sm text-red-500 leading-4"
        >{{ error }}</div>
    </div>
</template>

<script>
import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'
import { CheckIcon, SelectorIcon } from '@heroicons/vue/24/solid'

export default {
    inheritAttrs: false,
    components: {
        Listbox,
        ListboxButton,
        ListboxLabel,
        ListboxOption,
        ListboxOptions,
        CheckIcon,
        SelectorIcon,
    },
    props: {
        id: {
            type: String,
            default () {
                return `select-input-${Math.random().toString(36).substr(2, 9)}`
            },
        },
        modelValue: String,
        label: String,
        error: String,
        options: Array,
        placeholder: String,
    },
    data() {
        return {
            selected: null,
        }
    },
    computed: {
        classNames() {
            return [
                'block w-full py-2 px-3',
                'text-lg font-medium text-left',
                'border-4 ',
                'shadow-lg',
                'transition',
                'focus:outline-none',
                this.error ? 'bg-rose-50' : 'bg-white',
                this.error ? 'border-red-600 border-b-red-800 border-t-red-400 rounded' : 'border-sky-600 border-b-sky-800 border-t-sky-400 rounded',
                this.error ? 'focus:ring-rose-600' : 'focus:ring-sky-600',
                this.error ? 'focus:border-rose-600' : 'focus:border-sky-600',
            ]
        }
    },
    watch: {
        selected(selected) {
            this.$emit('update:modelValue', selected.value)
        }
    },
}

</script>
