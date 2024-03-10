<header
  class="sm:hidden bg-transparent w-full backdrop-blur-md shadow-sm fixed z-40 overflow-y-auto"
  x-state:on="Open"
  x-state:off="Closed"
  x-data="Components.popover({ open: false, focus: false })"
  x-init="init()"
  @keydown.escape="onEscape"
  @close-popover-group.window="onClosePopoverGroup"
>
  <div class="mx-auto px-4 py-2 w-full">
    <div class="relative flex justify-between">
      <div class="flex flex-1 items-center">
        <a href="{{ url('/') }}">
          <x-logo-written class="inline w-7 h-7" />
        </a>
      </div>
      <div class="flex items-center md:absolute md:inset-y-0 md:right-0 lg:hidden">
        <button
          type="button"
          class="relative -mx-2 inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-lime-500"
          @click="toggle"
          @mousedown="if (open) $event.preventDefault()"
          aria-expanded="false"
          :aria-expanded="open.toString()"
        >
          <span class="absolute -inset-0.5"></span>
          <span class="sr-only">Open menu</span>
          <svg
            x-description="Icon when menu is closed."
            x-state:on="Menu open"
            x-state:off="Menu closed"
            class="block h-6 w-6"
            :class="{ 'hidden': open, 'block': !(open) }"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            aria-hidden="true"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
            ></path>
          </svg>
          <svg
            x-description="Icon when menu is open."
            x-state:on="Menu open"
            x-state:off="Menu closed"
            class="hidden h-6 w-6"
            :class="{ 'block': open, 'hidden': !(open) }"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            aria-hidden="true"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M6 18L18 6M6 6l12 12"
            ></path>
          </svg>
        </button>
      </div>
    </div>
  </div>

  <nav
    aria-label="Global"
    x-ref="panel"
    x-show="open"
    x-on:click.away="open = false"
    style="display: none"
  >
    <div class="mx-auto max-w-3xl space-y-1 px-2 pb-3 pt-2 border-t border-gray-400/30">
      <a
        href="#how-it-works"
        aria-current="page"
        class="text-gray-300 block rounded-md py-2 px-3 text-base font-medium"
      >How It Works</a>
      <a
        href="#features"
        class="text-gray-300 block rounded-md py-2 px-3 text-base font-medium"
        x-state-description='undefined: "bg-gray-100 text-gray-900", undefined: "hover:bg-gray-50"'
      >Solutions</a>
      <div class="border-t-gray-300/20 mt-2 pt-2 border-t">
        @guest
          <div class="flex items-center gap-x-4">
            <x-get-started-button />
            <span class="text-gray-300">or</span>
            <a
              href="{{ route('login') }}"
              class="text-gray-300 block rounded-md py-2 text-base font-medium hover:text-white"
            >Sign In</a>
          </div>
        @else
          <a
            href="{{ route('diary') }}"
            class="text-gray-300 block rounded-md py-2 text-base font-medium hover:text-white"
          >My Diary</a>

        @endguest
      </div>
    </div>
  </nav>
</header>
