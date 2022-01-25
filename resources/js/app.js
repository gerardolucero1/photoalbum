require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

//Prime VUE
import PrimeVue from 'primevue/config';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';
import InputText from 'primevue/inputtext';
import InputSwitch from 'primevue/inputswitch';
import Tooltip from 'primevue/tooltip';
import ToastService from 'primevue/toastservice';
import Toast from 'primevue/toast';
import FileUpload from 'primevue/fileupload';
import Galleria from 'primevue/galleria';
import Image from 'primevue/image';
import Dialog from 'primevue/dialog';
import ConfirmDialog from 'primevue/confirmdialog';
import ProgressSpinner from 'primevue/progressspinner';
import Button from 'primevue/button';
import ConfirmationService from 'primevue/confirmationservice';
import Badge from 'primevue/badge';


import { VueMasonryPlugin } from "vue-masonry/src/masonry.plugin";

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(VueMasonryPlugin)
            .use(ConfirmationService)
            .mixin({ methods: { route } })
            .mixin({ methods: {
                prevLink(){
                    window.history.back();
                }
            } })
            .use(PrimeVue)
            .use(ToastService)
            .directive('tooltip', Tooltip)
            .component('DataTable', DataTable)
            .component('Galleria', Galleria)
            .component('Image', Image)
            .component('Column', Column)
            .component('ColumnGroup', ColumnGroup)
            .component('InputText', InputText)
            .component('InputSwitch', InputSwitch)
            .component('Toast', Toast)
            .component('FileUpload', FileUpload)
            .component('ConfirmDialog', ConfirmDialog)
            .component('Dialog', Dialog)
            .component('ProgressSpinner', ProgressSpinner)
            .component('Button', Button)
            .component('Badge', Badge)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
