<template>
  <div
    class="rounded-lg border bg-gray-100 shadow"
    :class="[error ? 'ring-2 ring-red-600' : '']"
  >
    <header class="border-b border-gray-300 px-4 py-3">
      <div class="flex items-center justify-between">
        <div>
          <label
            v-if="label"
            class="md:text-lg"
            :for="id"
            >{{ label }}</label
          >
        </div>
        <div>
          <slot name="actions"></slot>
        </div>
      </div>
      <div
        v-if="error"
        class="mt-1 text-red-500"
      >
        {{ error }}
      </div>
    </header>
    <Listbox
      v-bind="$attrs"
      as="div"
      v-model="selected"
      :id="id"
    >
      <div class="relative mt-1">
        <ListboxButton :class="classNames">
          <span
            v-if="selected"
            class="block truncate"
            >{{ selected.name }}</span
          >
          <span
            v-else
            class="block truncate"
            >{{ placeholder ? placeholder : 'Select' }}</span
          >
          <span
            class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
          >
            <ChevronUpDownIcon
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
          <ListboxOptions
            class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
          >
            <ListboxOption
              as="template"
              v-for="option in options"
              :key="option.value"
              :value="option"
              v-slot="{ active, selected }"
            >
              <li
                :class="[
                  active ? 'bg-teal-600 text-white' : 'text-gray-900',
                  'relative cursor-default select-none py-2 pl-8 pr-4',
                ]"
              >
                <span
                  :class="[
                    selected ? 'font-semibold' : 'font-normal',
                    'block truncate',
                  ]"
                >
                  {{ option.name }}
                </span>

                <span
                  v-if="selected"
                  :class="[
                    active ? 'text-white' : 'text-teal-600',
                    'absolute inset-y-0 left-0 flex items-center pl-1.5',
                  ]"
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
      class="mt-1 text-sm leading-4 text-red-500"
    >
      {{ error }}
    </div>
  </div>
</template>

<script>
import { inputClassNames } from '@/html-classes'

import {
  Listbox,
  ListboxButton,
  ListboxLabel,
  ListboxOption,
  ListboxOptions,
} from '@headlessui/vue'
import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/24/solid'

export default {
  inheritAttrs: false,
  components: {
    Listbox,
    ListboxButton,
    ListboxLabel,
    ListboxOption,
    ListboxOptions,
    CheckIcon,
    ChevronUpDownIcon,
  },
  props: {
    id: {
      type: String,
      default() {
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
        ...inputClassNames,
        this.error ? 'bg-red-100 placeholder-red-600/50' : '',
      ]
    },
  },
  watch: {
    selected(selected) {
      this.$emit('update:modelValue', selected.value)
    },
  },
}
</script>
