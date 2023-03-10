import './bootstrap'
import '../css/app.css'

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'


import VueMultiselect from "vue-multiselect";
import Chart from "chart.js";
import VuePaginate from 'vuejs-paginate';
import { TailwindPagination } from 'laravel-vue-pagination';

const appName =
    window.document.getElementsByTagName('title')[0]?.innerText || 'K UI'

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue')
        ),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .component('VueMultiselect', VueMultiselect)
            .component('TailwindPagination', TailwindPagination)
            .mount(el)
    },
})

InertiaProgress.init({ color: '#a855f7' })
