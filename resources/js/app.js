import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import Layout from '@/layouts/Layout.vue'

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    let page = pages[`./Pages/${name}.vue`]
    page.default.layout = page.default.layout || Layout
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
