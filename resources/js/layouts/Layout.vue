<template>
  <div class="min-h-screen bg-stone-100">
    <Popover
      as="header"
      class="bg-gradient-to-l  md:block from-lime-800 to-teal-900 pt-safe-top"
      v-slot="{ open }"
    >
      <div class="mx-auto max-w-3xl px-4 py-5 sm:px-6 lg:max-w-7xl lg:px-8">
        <div
          class="relative flex items-center justify-center py-5 lg:justify-between"
        >
          <div class="absolute left-0 flex-shrink-0 lg:static">
            <Link
              href="/diary"
              class="flex items-center focus:rounded-sm focus:outline-none focus:ring focus:ring-lime-400"
            >
              <Logo class="h-6 w-auto" />
              <h1
                class="ml-2 inline-block bg-gradient-to-br from-lime-400 to-lime-400/60 bg-clip-text text-2xl font-extrabold text-transparent"
              >
                Fittify
              </h1>
            </Link>
          </div>

          <div class="ml-12 mr-auto hidden flex-1 grid-cols-3 gap-8 lg:grid">
            <div class="col-span-2">
              <nav class="flex space-x-4">
                <Link
                  v-for="link in NAV_LINKS"
                  :key="link.title"
                  :href="url(link)"
                  :class="[
                    link.active ? 'text-white' : 'text-lime-100',
                    'rounded-md bg-white bg-opacity-0 px-3 py-2 text-sm font-medium hover:bg-opacity-10',
                  ]"
                  :aria-current="link.active ? 'page' : 'false'"
                >
                  {{ link.title }}
                </Link>
              </nav>
            </div>
          </div>

          <div class="hidden lg:ml-4 lg:flex lg:items-center lg:pr-0.5">
            <button
              type="button"
              class="flex-shrink-0 rounded-full p-1 text-lime-200 hover:bg-white hover:bg-opacity-10 hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
            >
              <span class="sr-only">View notifications</span>
              <BellIcon
                class="h-6 w-6"
                aria-hidden="true"
              />
            </button>

            <Menu
              as="div"
              class="relative ml-4 flex-shrink-0"
            >
              <div>
                <MenuButton
                  class="flex rounded-full border-none text-sm focus:outline-none focus:ring-opacity-100"
                >
                  <span class="sr-only">Open user menu</span>
                  <img
                    class="h-8 w-8 rounded-full bg-cover text-white"
                    :src="user.avatar_url"
                    alt="avatat"
                  />
                </MenuButton>
              </div>
              <transition
                leave-active-class="transition ease-in duration-75"
                leave-from-class="transform opacity-100 scale-100"
                leave-to-class="transform opacity-0 scale-95"
              >
                <MenuItems
                  class="absolute -right-2 z-40 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                >
                  <MenuItem v-slot="{ active }">
                    <Link
                      as="button"
                      href="logout"
                      method="post"
                      :class="[
                        active ? 'bg-stone-100' : '',
                        'block w-full px-4 py-2 text-left text-sm text-stone-700',
                      ]"
                    >
                      Sign out
                    </Link>
                  </MenuItem>
                </MenuItems>
              </transition>
            </Menu>
          </div>

          <div class="absolute right-0 flex-shrink-0 lg:hidden">
            <PopoverButton
              class="inline-flex items-center justify-center rounded-md bg-transparent p-2 text-lime-200 hover:bg-white hover:bg-opacity-10 hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
            >
              <Bars3Icon
                v-if="!open"
                class="block h-6 w-6"
                aria-hidden="true"
              />
              <XMarkIcon
                v-else
                class="block h-6 w-6"
                aria-hidden="true"
              />
            </PopoverButton>
          </div>
        </div>
        <div
          class="hidden border-t border-lime-50 border-opacity-20 py-4 lg:block"
        >
          <h1
            class="inline-block bg-gradient-to-r from-lime-100 to-yellow-50 bg-clip-text text-4xl font-bold text-transparent"
          ></h1>
        </div>
      </div>

      <TransitionRoot
        as="template"
        :show="open"
      >
        <div class="lg:hidden">
          <TransitionChild
            as="template"
            enter="duration-150 ease-out"
            enter-from="opacity-0"
            enter-to="opacity-100"
            leave="duration-150 ease-in"
            leave-from="opacity-100"
            leave-to="opacity-0"
          >
            <PopoverOverlay
              static
              class="fixed inset-0 z-20 bg-black bg-opacity-25"
            />
          </TransitionChild>

          <TransitionChild
            as="template"
            enter="duration-150 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-150 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
            <PopoverPanel
              focus
              static
              class="absolute inset-x-0 top-0 z-30 mx-auto w-full max-w-3xl origin-top transform p-2 transition"
            >
              <div
                class="divide-y divide-stone-200 rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5"
              >
                <div class="pb-2 pt-3">
                  <div class="flex items-center justify-between px-4">
                    <div></div>
                    <div class="-mr-2">
                      <PopoverButton
                        class="inline-flex items-center justify-center rounded-md bg-white p-2 text-stone-400 hover:bg-stone-100 hover:text-stone-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-lime-500"
                      >
                        <span class="sr-only">Close menu</span>
                        <XMarkIcon
                          class="h-6 w-6"
                          aria-hidden="true"
                        />
                      </PopoverButton>
                    </div>
                  </div>
                  <div class="mt-3 space-y-1 px-2">
                    <a
                      v-for="item in NAV_LINKS"
                      :key="item.title"
                      :href="url(item)"
                      class="block rounded-md px-3 py-2 text-base font-medium text-stone-900 hover:bg-stone-100 hover:text-stone-800"
                      >{{ item.title }}</a>
                  </div>
                </div>
                <div class="pb-2 pt-4">
                  <div class="flex items-center px-5">
                    <div class="flex-shrink-0">
                      <img
                        class="h-10 w-10 rounded-full bg-cover"
                        :src="user.avatar_url"
                        alt=""
                      />
                    </div>
                    <div class="ml-3 min-w-0 flex-1">
                      <div class="truncate text-base font-medium text-stone-800">
                        {{ user.name }}
                      </div>
                      <div class="truncate text-sm font-medium text-stone-500">
                        {{ user.email }}
                      </div>
                    </div>
                    <button
                      class="ml-auto flex-shrink-0 rounded-full bg-white p-1 text-stone-400 hover:text-stone-500 focus:outline-none focus:ring-2 focus:ring-lime-500 focus:ring-offset-2"
                    >
                      <span class="sr-only">View notifications</span>
                      <BellIcon
                        class="h-6 w-6"
                        aria-hidden="true"
                      />
                    </button>
                  </div>
                  <div class="mt-3 space-y-1 px-2">
                    <Link
                      as="button"
                      href="logout"
                      method="post"
                      class="block rounded-md px-3 py-2 text-base font-medium text-stone-900 hover:bg-stone-100 hover:text-stone-800"
                    >
                      Sign out
                    </Link>
                  </div>
                </div>
              </div>
            </PopoverPanel>
          </TransitionChild>
        </div>
      </TransitionRoot>
    </Popover>
    <main class="pb-8 mt-4">
      <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
        <h1 class="sr-only">My Diary</h1>
        <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-3 lg:gap-8">
          <slot />
        </div>
      </div>
    </main>
    <footer>
      <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
        <div
          class="border-t border-stone-200 py-8 text-center text-sm text-stone-500 sm:text-left"
        >
          <span class="block sm:inline">&copy; 2024 Fittify.</span>
          <span class="block sm:inline">All rights reserved.</span>
        </div>
      </div>
    </footer>

    <FlashMessages />
  </div>
<!--   <div class="fixed bottom-0 right-0 mb-5 mr-5">
    <button
      class="rounded-full bg-transparent backdrop-blur p-3 ring ring-lime-400 ring-offset-2 hover:bg-lime-100"
      @click="$fotion.open()"
    >
      <BugAntIcon class="h-7 w-7 text-lime-500" />
    </button>
  </div>
 --></template>

<script>
import Logo from '@/components/Shareable/Logo.vue'

import {
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  Popover,
  PopoverButton,
  PopoverOverlay,
  PopoverPanel,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import { router } from '@inertiajs/vue3'
import {
  BellIcon,
  Bars3Icon,
  XMarkIcon,
  BugAntIcon,
} from '@heroicons/vue/24/outline'
import FlashMessages from '@/components/Shareable/FlashMessages.vue'
import { NAV_LINKS } from '@/constants'
import { Link } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3'

export default {
  components: {
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    Popover,
    PopoverButton,
    PopoverOverlay,
    PopoverPanel,
    TransitionChild,
    TransitionRoot,
    BellIcon,
    Bars3Icon,
    XMarkIcon,
    FlashMessages,
    Link,
    BugAntIcon,
    Logo,
  },
  setup() {
    const url = navLink => {
      return window.route(navLink.route)
    }
    const user = usePage().props.auth.user
    return {
      user,
      NAV_LINKS,
      url,
    }
  },
}
</script>
