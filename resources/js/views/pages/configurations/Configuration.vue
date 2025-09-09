<template>
    <div class="row">
        <div :class="class_name">
            <!-- Default box -->
            <form method="post" @submit.prevent="" :action="backUrl">
                <input type="hidden" name="current_tab" value="basic-info" />
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="setting-menu px-2">
                                <Tabs :key="tabsRerender"></Tabs>
                            </div>
                            <div class="setting-content px-0">
                                <div class="tab-content p-0 border-0 shadow-none">
                                    <component ref="component" :is="activeTab"></component>
                                </div>
                                <SwitchTabs ref="switchTabs" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- File Manager Modal -->
        <div id="fileManagerModalWrapper">
            <div
                class="modal"
                id="filemanagerModal"
                role="dialog"
                aria-labelledby="filemanagerModal"
                data-backdrop="static"
                data-keyboard="false"
                aria-modal="true"
                style="top: -10px !important"
            >
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header modal-moveable">
                            <h4 class="modal-title">File Manager</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <file-manager ref="fileManager"></file-manager>
                                </div>
                            </div>
                        </div>

                        <div class="modal-header border-top rounded-0">
                            <h4 class="modal-title">Selected File(s)</h4>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="rounded">
                                        <table
                                            class="bg-white table table-striped table-hover nowrap rounded shadow-xs border-xs mt-2 dataTable dtr-inline"
                                        >
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Path</th>
                                                    <th>View</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody
                                                v-if="
                                                    typeof selectedFiles === 'object' &&
                                                    selectedFiles &&
                                                    selectedFiles.length
                                                "
                                            >
                                                <tr v-for="(selectedFile, index) in selectedFiles">
                                                    <td>{{ index + 1 }}</td>
                                                    <td>{{ selectedFile }}</td>
                                                    <td class="py-1">
                                                        <img
                                                            :src="selectedFile"
                                                            @error="$root.getDefaultImage"
                                                            :alt="selectedFile"
                                                            style="height: 47px"
                                                        />
                                                    </td>
                                                    <td>
                                                        <!-- remove path from selectedFiles -->
                                                        <button
                                                            type="button"
                                                            class="btn btn-danger btn-sm"
                                                            title="Remove"
                                                            @click="$refs.component.removeSelectedFiles(index)"
                                                        >
                                                            <i class="la la-minus"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tbody
                                                v-else-if="
                                                    typeof selectedFiles === 'string' &&
                                                    selectedFiles &&
                                                    selectedFiles.length
                                                "
                                            >
                                                <tr>
                                                    <td>{{ 1 }}</td>
                                                    <td>{{ selectedFiles }}</td>
                                                    <td class="py-1">
                                                        <img
                                                            :src="selectedFiles"
                                                            @error="$root.getDefaultImage"
                                                            :alt="selectedFiles"
                                                            style="height: 47px"
                                                        />
                                                    </td>
                                                    <td>
                                                        <!-- remove path from selectedFiles -->
                                                        <button
                                                            type="button"
                                                            class="btn btn-danger btn-sm"
                                                            title="Remove"
                                                            @click="selectedFiles = ''"
                                                        >
                                                            <i class="la la-minus"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tbody v-else>
                                                <tr>
                                                    <td colspan="100%" class="bg-light text-center">
                                                        No files selected
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer modal-moveable">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-html="modalShade"></div>
        </div>
    </div>
</template>

<script>
import Tabs from './tabs/Tabs';
import SwitchTabs from '../../components/SwitchTabs';
import _ from 'lodash';
import Basic from './tabs/Basic';
import PIM from './tabs/PIM';
import Search from './tabs/Search';
import Report from './tabs/Report';
import Sayt from './tabs/Sayt';
import Icecat from './tabs/Icecat';
import Google from './tabs/Google';
import Frontend from './tabs/Frontend';
import Payment from './tabs/Payment';
import ERP from './tabs/ERP';
import Invoice from './tabs/Invoice';
import Email from './tabs/Email';
import CMS from './tabs/CMS';
import Schedule from './tabs/Schedule';
import Storage from './tabs/Storage';
import Marketing from './tabs/Marketing';
import API from './tabs/API.vue';
import Order from './tabs/Order';
import Prop65 from './tabs/Prop65';
import DDS from './tabs/DDS';
import Security from "./tabs/Security";
import AlertMessage from './tabs/AlertMessage.vue';

export default {
    name: 'Configuration',
    props: [
        'class_name',
        'url',
        'translatable',
        'menu_groups',
        'product_classification',
        'attributes',
        'translation_enabled',
        'available_locales',
        'current_lang',
        'method',
        'axios_url',
        'locale',
        'active_tab',
        'page_types',
        'query_string',
        'can_publish',
        'core_configs',
        'options',
        'all_currencies',
        'easy_ask_default_product_categories',
        'all_erps',
        'date_time_formats',
        'date_formats',
        'hierarchies',
        'countries',
        'mail_configuration_data',
        'accept_file_types',
        'product_indexes',
        'core_configuration_data',
        'available_locales',
        'app_url',
        'dds_dates',
        'timezone',
        'catalogs',
        'document_types',
    ],
    components: {
        SwitchTabs,
        Tabs,
        Basic,
        PIM,
        Search,
        Report,
        Sayt,
        Icecat,
        Google,
        Frontend,
        Payment,
        ERP,
        Invoice,
        Email,
        Schedule,
        CMS,
        Storage,
        Marketing,
        API,
        Order,
        Prop65,
        DDS,
        Security,
        AlertMessage
    },
    data() {
        return {
            backUrl: '/admin/product',
            tabsRerender: 0,
            validationErrors: {},
            activeTab: '',
            actionType: 'save_and_edit',
            selectedFiles: [],
            modalShade: '',
            paymentGateways: [],
            productIndexes: [],
            menuGroupOptions: JSON.parse(this.menu_groups),
            tabs: {
                Basic: { title: 'Basic', hash: 'basic' },
                PIM: { title: 'PIM', hash: 'pim' },
                Search: { title: 'Search', hash: 'search' },
                Report: { title: 'Report', hash: 'report' },
                Sayt: { title: 'SAYT', hash: 'sayt' },
                Icecat: { title: 'Icecat', hash: 'icecat' },
                Google: { title: 'Google', hash: 'google' },
                Frontend: { title: 'Frontend', hash: 'frontend' },
                Payment: { title: 'Payment', hash: 'payment' },
                ERP: { title: 'ERP', hash: 'erp' },
                Invoice: { title: 'Invoice', hash: 'invoice' },
                Email: { title: 'Email', hash: 'email' },
                Schedule: { title: 'Schedule', hash: 'schedule' },
                CMS: { title: 'CMS', hash: 'cms' },
                Storage: { title: 'Storage', hash: 'storage' },
                Marketing: { title: 'Marketing', hash: 'marketing' },
                API: { title: 'Amplify API', hash: 'api' },
                Order: { title: 'Order', hash: 'order' },
                Prop65: { title: 'Prop65', hash: 'prop65' },
                // DDS: { title: 'DDS', hash: 'dds' },
                Security: { title: 'Security', hash: 'security' },
                AlertMessage: { title: 'Alert Message', hash: 'message' },
            },
            coreConfigurationData: {
                ...JSON.parse(this.core_configuration_data),
            },
            allCurrencies: JSON.parse(this.all_currencies),
            availableLocales: JSON.parse(this.available_locales),
            hierarchiesData: Object.values(JSON.parse(this.hierarchies)),
            countriesData: JSON.parse(this.countries),
            dateTimes: JSON.parse(this.date_time_formats),
            dates: JSON.parse(this.date_formats),
            mailConfigurationData: JSON.parse(this.mail_configuration_data),
            documentTypes: JSON.parse(this.document_types),
            pageTypes: {},
        };
    },
    mounted() {
        this.activeTab = localStorage.getItem('systemTabActiveTab' ?? 'Basic');
        this.pageTypes = JSON.parse(this.page_types);
        for (let key in JSON.parse(this.product_indexes)) {
            this.productIndexes.push({
                code: key,
                name: JSON.parse(this.product_indexes)[key],
            });
        }
    },
    created() {
        if (this.coreConfigurationData.basic.client_code === 'ACT') {
            this.$set(this.tabs, 'DDS', { title: 'DDS', hash: 'dds' });
        }
    },
    methods: {
        getNextTab(next = true, tab = this.activeTab) {
            let tabsName = _.keys(this.tabs);
            let tabInd = _.indexOf(tabsName, tab);
            let nextTabName = tabsName[tabInd + (next ? 1 : -1)];
            return !!nextTabName ? nextTabName : tab;
        },
        changeTab(name) {
            localStorage.setItem('systemTabActiveTab', name);
            this.activeTab = name;
        },
        saveCoreConfigInfo(params = null) {
            // getFullPageLoader();
            axios
                .put(this.axios_url, params)
                .then((response) => {
                    // removeFullPageLoader();
                    new Noty({
                        type: response.data.status,
                        text: response.data.message,
                    }).show();
                })
                .catch((err) => {
                    // removeFullPageLoader();
                    console.error(err);
                    new Noty({
                        type: 'error',
                        text: err.response.data.message,
                    }).show();
                });
        },
        saveAndAction() {
            window.location.reload();
        },
        toggleSidebar() {
            document.querySelector('.setting-menu').classList.toggle('show');
            document.querySelector('.custom-sidebar-ar').classList.toggle('show');
        },
    },
};
</script>

<style>
.eye-position {
    position: absolute;
    right: 10px !important;
    bottom: 15% !important;
    cursor: pointer;
}

.cke_contents {
    min-height: 300px !important;
}

.required-custom {
    color: #ff0000;
}

.custom-sidebar-ar.show .menu-icon-ar {
    display: none;
}

.custom-sidebar-ar .close-icon-ar {
    display: none;
}

.custom-sidebar-ar.show .close-icon-ar {
    display: block;
}

.tab-pane {
    padding-top: 0;
}

.setting-menu {
    width: 200px;
}

.setting-content {
    width: calc(100% - 200px);
}

@media only screen and (max-width: 767px) {
    legend {
        font-size: 1.25rem;
    }

    .setting-menu {
        position: absolute;
        left: -210px;
        z-index: 9;
        background: #ffffff;
        transition: all 0.4s;
        box-shadow: 0 0 10px #ddd;
        top: -20px;
        padding: 12px !important;
    }

    .setting-menu.show {
        left: -4px;
    }

    .setting-content {
        width: 100%;
    }
}
</style>
