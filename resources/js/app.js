import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import Layout from '@/layouts/Layout.vue'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'

createInertiaApp({
  resolve: name =>
    resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob('./Pages/**/*.vue'),
    ).then(page => {
      page.default.layout = page?.default?.layout || Layout
      return page
    }),

  // resolve: name => {
  //   const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
  //   console.log({ pages })
  //   let page = pages[`./Pages/${name}.vue`]
  //   console.log({ page })
  // page.default.layout = page?.default?.layout || Layout
  //   return page
  // },
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
