import './bootstrap'
import '../css/app.scss'
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'

import 'primevue/resources/themes/mdc-light-indigo/theme.css'
import 'primevue/resources/primevue.min.css'
import 'primeflex/primeflex.css'
import 'primeicons/primeicons.css'
import PrimeVue from 'primevue/config'
import StyleClass from 'primevue/styleclass'
import AutoComplete from 'primevue/autocomplete'
import Badge from 'primevue/badge'
import Button from 'primevue/button'
import Calendar from 'primevue/calendar'
import Card from 'primevue/card'
import Chart from 'primevue/chart'
import Column from 'primevue/column'
import ConfirmationService from 'primevue/confirmationservice'
import ConfirmDialog from 'primevue/confirmdialog'
import DataTable from 'primevue/datatable'
import DialogService from 'primevue/dialogservice'
import DynamicDialog from 'primevue/dynamicdialog'
import Divider from 'primevue/divider'
import Dropdown from 'primevue/dropdown'
import Editor from 'primevue/editor'
import InputNumber from 'primevue/inputnumber'
import InputText from 'primevue/inputtext'
import Message from 'primevue/message'
import Password from 'primevue/password'
import TabView from 'primevue/tabview'
import TabPanel from 'primevue/tabpanel'
import Tooltip from 'primevue/tooltip'

createInertiaApp({
  title: (title) => `${title} - Cahaya Agung`,
  resolve: (name) =>
    resolvePageComponent(
      `./pages/${name}.vue`,
      import.meta.glob('./pages/**/*.vue')
    ),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(PrimeVue, {
        ripple: true,
      })
      .use(ConfirmationService)
      .use(DialogService)
      .mixin({ methods: { route } })
      .directive('styleclass', StyleClass)
      .directive('tooltip', Tooltip)
      .component('AutoComplete', AutoComplete)
      .component('Button', Button)
      .component('Badge', Badge)
      .component('Card', Card)
      .component('Calendar', Calendar)
      .component('Chart', Chart)
      .component('Column', Column)
      .component('ConfirmDialog', ConfirmDialog)
      .component('DataTable', DataTable)
      .component('Divider', Divider)
      .component('DynamicDialog', DynamicDialog)
      .component('Dropdown', Dropdown)
      .component('Editor', Editor)
      .component('InputNumber', InputNumber)
      .component('InputText', InputText)
      .component('Message', Message)
      .component('Password', Password)
      .component('TabView', TabView)
      .component('TabPanel', TabPanel)
      .mount(el)
  },
})

InertiaProgress.init({
  color: '#4F46E5',
})
