import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import Layout from '@/layouts/Layout.vue'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'

createInertiaApp({
  resolve: name => {
    const resolvedPages = import.meta.glob('./pages/**/*.vue')

    const page = resolvePageComponent(
      `./pages/${name}.vue`,
      resolvedPages,
    ).then(page => {
      page.default.layout = page?.default?.layout || Layout
      return page
    })

    return page
  },
  setup({ el, App, props, plugin }) {
    const vueApp = createApp({ render: () => h(App, props) })
    vueApp.use(plugin)
    vueApp.mount(el)

    const fotion = new Fotion({
      reference: 'OUtDiwFSR',
      email: props.initialPage.props?.auth?.user?.email,
    })

    vueApp.config.globalProperties.$fotion = fotion
  },
})
