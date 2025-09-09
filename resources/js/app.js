import './bootstrap';

import Vue from 'vue';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import Multiselect from 'vue-multiselect';
import VCalendar from 'v-calendar';
import CKEditor from 'ckeditor4-vue';
import DataTable from 'laravel-vue-datatable';
import FileManager from './modules/file-manager/init';
import './componentRegister';

import store from './store';

Vue.config.productionTip = false;
import VueClipboard from 'vue-clipboard2';
// register globally
Vue.component('multiselect', Multiselect);
VueClipboard.config.autoSetContainer = true; // add this line
Vue.use(VueClipboard);
Vue.use(VueSweetalert2);
Vue.use(VCalendar, {
    componentPrefix: 'vc', // Use <vc-calendar /> instead of <v-calendar />
});
Vue.use(CKEditor);
Vue.use(DataTable);
Vue.use(FileManager, { store });

const app = new Vue({
    el: '#app',
    store,
    data() {
        return {
            config: {},
            placeholderImage: 'assets//No-Image-Placeholder-min.png',
            perPages: [2, 6, 12, 24, 48, 96, 150, 500],
        };
    },

    async created() {
        await axios.get('/admin/app/config').then((response) => {
            this.config = response.data;
        });
    },
    methods: {
        renderTooltip() {
            $(function () {
                let tooltip = $('[data-toggle="tooltip"]');
                tooltip.tooltip();
                tooltip.on('click', function () {
                    $(this).tooltip('hide');
                });
            });
        },
        getDefaultImage(event) {
            event.target.src = this.config.fallback_image;
            event.onerror = null;
        },
    },
});
