<template>
  <div
    class="bg-white min-h-screen bg-gradient-to-br from-sky-50 to-fuchsia-50"
  >
    <a
      href="/"
      class="px-4 py-5 flex items-center"
    >
      <Logo class="h-6 w-auto" />
      <h1
        class="ml-4 bg-clip-text bg-gradient-to-bl from-lime-400 to-green-700 text-transparent text-3xl font-extrabold tracking-wide"
      >
        Fittify
      </h1>
    </a>
    <div class="px-4 sm:px-6 md:max-w-md md:mx-auto">
      <slot />
    </div>
  </div>
</template>

<script>
import Logo from '@/components/Shareable/Logo.vue'
export default {
  components: { Logo },
}
</script>
