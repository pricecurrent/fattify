<template>
  <div
    class="min-h-screen bg-white bg-gradient-to-br from-lime-50 to-lime-50"
  >
    <a
      href="/"
      class="flex items-center px-4 py-5"
    >
      <Logo class="h-6 w-auto" />
      <h1
        class="ml-4 bg-gradient-to-bl from-lime-400 to-lime-700 bg-clip-text text-3xl font-extrabold tracking-wide text-transparent"
      >
        Fittify
      </h1>
    </a>
    <div class="px-4 sm:px-6 md:mx-auto md:max-w-md">
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
