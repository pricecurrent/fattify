require('./bootstrap');
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import Layout from '@/layouts/Layout'
InertiaProgress.init()
createInertiaApp({
    resolve: name => {
        const page = require(`./pages/${name}`).default
        page.layout = page.layout || Layout
        return page
    },
    setup({ el, app, props, plugin }) {
        createApp({ render: () => h(app, props) })
            .use(plugin)
            .mount(el)
    },
})
