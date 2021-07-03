<template>
    <div class="min-h-screen bg-gray-100">
        <Popover
            as="header"
            class="pb-24 bg-cyan-800"
            v-slot="{ open }"
        >
            <div class="max-w-3xl mx-auto px-4 py-5 sm:px-6 lg:max-w-7xl lg:px-8">
                <div class="relative py-5 flex items-center justify-center lg:justify-between">
                    <!-- Logo -->
                    <div class="absolute left-0 flex-shrink-0 lg:static">
                        <inertia-link href="/diary">
                            <Logo class="h-8 w-auto" />
                        </inertia-link>
                    </div>

                    <div class="hidden lg:grid grid-cols-3 gap-8 flex-1 mr-auto ml-12">
                        <div class="col-span-2">
                            <nav class="flex space-x-4">
                                <inertia-link
                                    v-for="link in navLinks"
                                    :key="link.title"
                                    :href="url(link)"
                                    :class="[link.active ? 'text-white' : 'text-cyan-100', 'text-sm font-medium rounded-md bg-white bg-opacity-0 px-3 py-2 hover:bg-opacity-10']"
                                    :aria-current="link.active ? 'page' : 'false'"
                                >
                                    {{ link.title }}
                                </inertia-link>
                            </nav>
                        </div>
                    </div>

                    <!-- Right section on desktop -->
                    <div class="hidden lg:ml-4 lg:flex lg:items-center lg:pr-0.5">
                        <button
                            type="button"
                            class="flex-shrink-0 p-1 text-cyan-200 rounded-full hover:text-white hover:bg-white hover:bg-opacity-10 focus:outline-none focus:ring-2 focus:ring-white"
                        >
                            <span class="sr-only">View notifications</span>
                            <BellIcon
                                class="h-6 w-6"
                                aria-hidden="true"
                            />
                        </button>

                        <!-- Profile dropdown -->
                        <Menu
                            as="div"
                            class="ml-4 relative flex-shrink-0"
                        >
                            <div>
                                <MenuButton class="rounded-full flex text-sm border-none focus:outline-none focus:ring-opacity-100">
                                    <!-- <MenuButton class="bg-white rounded-full flex text-sm ring-2 ring-white ring-opacity-20 focus:outline-none focus:ring-opacity-100"> -->
                                    <span class="sr-only">Open user menu</span>
                                    <UserIcon
                                        class="h-8 w-8 rounded-full text-white"
                                        :src="user.imageUrl"
                                    />
                                </MenuButton>
                            </div>
                            <transition
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95"
                            >
                                <MenuItems class="origin-top-right z-40 absolute -right-2 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <MenuItem v-slot="{ active }">
                                    <inertia-link
                                        as="button"
                                        href="logout"
                                        method="post"
                                        :class="[active ? 'bg-gray-100' : '', 'block w-full text-left px-4 py-2 text-sm text-gray-700']"
                                    >
                                        Sign out
                                    </inertia-link>
                                    </MenuItem>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>

                    <!-- Menu button -->
                    <div class="absolute right-0 flex-shrink-0 lg:hidden">
                        <!-- Mobile menu button -->
                        <PopoverButton class="bg-transparent p-2 rounded-md inline-flex items-center justify-center text-cyan-200 hover:text-white hover:bg-white hover:bg-opacity-10 focus:outline-none focus:ring-2 focus:ring-white">
                            <MenuIcon
                                v-if="!open"
                                class="block h-6 w-6"
                                aria-hidden="true"
                            />
                            <XIcon
                                v-else
                                class="block h-6 w-6"
                                aria-hidden="true"
                            />
                        </PopoverButton>
                    </div>
                </div>
                <div class="hidden lg:block py-4 border-t border-cyan-50 border-opacity-20">
                    <h1 class="text-4xl font-bold bg-clip-text bg-gradient-to-r text-transparent inline-block from-cyan-100 to-yellow-50">My Diary</h1>
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
                            class="z-20 fixed inset-0 bg-black bg-opacity-25"
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
                            class="z-30 absolute top-0 inset-x-0 max-w-3xl mx-auto w-full p-2 transition transform origin-top"
                        >
                            <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y divide-gray-200">
                                <div class="pt-3 pb-2">
                                    <div class="flex items-center justify-between px-4">
                                        <div>
                                            <svg
                                                class="h-8 w-auto"
                                                viewBox="0 0 181 184"
                                                fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    d="M160.075 26.6695C146.393 13.4265 128.803 4.61821 109.731 1.45929C90.659 -1.69963 71.0442 0.946391 53.5913 9.0325C36.1385 17.1186 -18.4659 16.0491 12.2878 46.6059C43.0414 77.1627 -1.07562 81.7503 1 100.371C3.07562 118.991 6.04142 178.749 23.8764 150.568C41.7115 122.387 53.6765 174.452 72.5097 178.749C91.3429 183.045 103.041 145.163 129.026 174.557C155.011 203.951 162.207 155.296 172.656 139.533C172.656 139.533 101.921 108.325 93.9605 90.6627C86 73 160.075 26.6695 160.075 26.6695Z"
                                                    fill="#48BB78"
                                                />
                                                <circle
                                                    cx="66"
                                                    cy="123"
                                                    r="12"
                                                    fill="#C4C4C4"
                                                />
                                                <circle
                                                    cx="169"
                                                    cy="91"
                                                    r="12"
                                                    fill="#48BB78"
                                                />
                                            </svg>
                                        </div>
                                        <div class="-mr-2">
                                            <PopoverButton class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-cyan-500">
                                                <span class="sr-only">Close menu</span>
                                                <XIcon
                                                    class="h-6 w-6"
                                                    aria-hidden="true"
                                                />
                                            </PopoverButton>
                                        </div>
                                    </div>
                                    <div class="mt-3 px-2 space-y-1">
                                        <a
                                            v-for="item in navLinks"
                                            :key="item.title"
                                            :href="url(item)"
                                            class="block rounded-md px-3 py-2 text-base text-gray-900 font-medium hover:bg-gray-100 hover:text-gray-800"
                                        >{{ item.title }}</a>
                                    </div>
                                </div>
                                <div class="pt-4 pb-2">
                                    <div class="flex items-center px-5">
                                        <div class="flex-shrink-0">
                                            <UserIcon
                                                class="h-10 w-10 rounded-full text-cyan-500"
                                                :src="user.imageUrl"
                                                alt=""
                                            />
                                        </div>
                                        <div class="ml-3 min-w-0 flex-1">
                                            <div class="text-base font-medium text-gray-800 truncate">{{ user.name }}</div>
                                            <div class="text-sm font-medium text-gray-500 truncate">{{ user.email }}</div>
                                        </div>
                                        <button class="ml-auto flex-shrink-0 bg-white p-1 text-gray-400 rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500">
                                            <span class="sr-only">View notifications</span>
                                            <BellIcon
                                                class="h-6 w-6"
                                                aria-hidden="true"
                                            />
                                        </button>
                                    </div>
                                    <div class="mt-3 px-2 space-y-1">
                                        <inertia-link
                                            as="button"
                                            href="logout"
                                            method="post"
                                            class="block rounded-md px-3 py-2 text-base text-gray-900 font-medium hover:bg-gray-100 hover:text-gray-800"
                                        >
                                            Sign out
                                        </inertia-link>
                                    </div>
                                </div>
                            </div>
                        </PopoverPanel>
                    </TransitionChild>
                </div>
            </TransitionRoot>
        </Popover>
        <main class="-mt-24 pb-8">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                <h1 class="sr-only">Page title</h1>
                <!-- Main 3 column grid -->
                <div class="grid grid-cols-1 gap-4 items-start lg:grid-cols-3 lg:gap-8">
                    <slot />
                </div>
            </div>
        </main>
        <footer>
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 lg:max-w-7xl">
                <div class="border-t border-gray-200 py-8 text-sm text-gray-500 text-center sm:text-left">
                    <span class="block sm:inline">&copy; 2021 Fattify inc.</span>
                    <span class="block sm:inline">All rights reserved.</span>
                </div>
            </div>
        </footer>

        <FlashMessages />

    </div>
</template>

<script>
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
import { Inertia } from '@inertiajs/inertia'
import { BellIcon, MenuIcon, XIcon } from '@heroicons/vue/outline'
import { UserIcon } from '@heroicons/vue/outline'
import FlashMessages from '@/components/Shareable/FlashMessages'
import Logo from '@/components/Shareable/Logo'
const navLinks = [
    { title: 'Diary', active: true, route: 'diary', },
    // { title: 'Profile', active: false, route: 'profile' },
]
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
        MenuIcon,
        XIcon,
        UserIcon,
        FlashMessages,
        Logo,
    },
    setup() {
        const url = (navLink) => {
            return window.route(navLink.route)
        }
        const user = Inertia.page.props.auth.user
        return {
            user,
            navLinks,
            url,
        }
    },
}

</script>
