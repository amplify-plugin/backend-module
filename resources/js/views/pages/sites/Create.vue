<template>
    <div class="row">
        <div :class="class_name">
            <!-- Default box -->
            <form method="post" @submit.prevent="saveData()" :action="url">
                <div class="tab-container mb-2">
                    <Tabs :key="tabsRerender" ref="tabs"/>

                    <div class="tab-content p-0 ">
                        <Loader v-if="loader" ref="loader"/>

                        <div v-else>
                            <component :is="activeTab"/>

                            <SwitchTabs ref="switchTabs"/>
                        </div>
                    </div>
                </div>

                <div id="saveActions" class="form-group">

                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-success"
                                @click="saveData()">
                                <span data-value="save_and_back">
                                    <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                                    Save and back
                                </span>
                        </button>
                    </div>

                    <a :href="backUrl" class="btn btn-default">
                        <span class="la la-ban"></span> &nbsp;Cancel
                    </a>

                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Tabs                from "./tabs/Tabs";
import BasicInfo           from "./tabs/BasicInfo";
import PageConfiguration   from "./tabs/PageConfiguration";
import SearchConfiguration from "./tabs/SearchConfiguration";
import _                   from "lodash";
import SwitchTabs          from "../../components/SwitchTabs";
import Loader              from "../../components/Loader";

export default {
    name      : 'SiteCreate',
    props     : [
        'class_name', 'url', 'method', 'axios_url', 'query_string', 'active_tab',
        'site_data', 'all_templates', 'all_pages', 'search_config_data'
    ],
    components: {Loader, SwitchTabs, Tabs, BasicInfo, PageConfiguration, SearchConfiguration},

    data() {
        return {
            tabsRerender      : 1,
            loader            : false,
            validationErrors  : "",
            tabs              : {
                BasicInfo          : {title: 'Basic Info', hash: 'basic-info'},
                PageConfiguration  : {title: 'Page Configuration', hash: 'page-configuration'},
                SearchConfiguration: {title: 'Search Configuration', hash: 'search-configuration'},
            },
            activeTab         : _.cloneDeep(this.active_tab),
            backUrl           : '/admin/site',
            site              : {
                site_name       : null,
                site_description: null,
                url             : null,
                template_id     : null,
                front_page_id   : null,
                shop_page_id    : null,
                product_page_id : null,
                protocol        : 'http',
            },
            search_configuration : {
                product_search_by_id_prefix : null,
                easyask_host                : null,
                easyask_port                : null,
                easyask_dictionary          : null,
                sayt_product_id             : null,
                sayt_product_image          : null,
                sayt_product_name           : null,
                sayt_product_price          : null,
                sayt_product_description    : null,
                sayt_product_type           : null,
                sayt_product_sizes          : null,
            },
            allTemplates      : JSON.parse(this.all_templates),
            allPages          : JSON.parse(this.all_pages),
            allHomePages      : [],
            allShopPages      : [],
            allProductPages   : [],
            isTemplateSelected: false,
            protocolTypesArray: ['http', 'https'],
        }
    },

    mounted() {
        console.log(this.all_templates);
    },

    created() {
        if (this.method === 'put') {
            this.initEdit()
        }
    },

    methods: {
        initEdit() {
            let sitesData = JSON.parse(this.site_data);
            let siteSearchConfigData = JSON.parse(this.search_config_data);

            this.site     = {
                id              : sitesData.id,
                site_name       : sitesData.site_name,
                site_description: sitesData.site_description,
                url             : sitesData.url,
                template_id     : sitesData.template_id,
                front_page_id   : sitesData.front_page_id,
                shop_page_id    : sitesData.shop_page_id,
                product_page_id : sitesData.product_page_id,
                protocol        : sitesData.protocol ?? 'http',
            };

            this.search_configuration     = {
                product_search_by_id_prefix : siteSearchConfigData.product_search_by_id_prefix,
                easyask_host                : siteSearchConfigData.easyask_host,
                easyask_port                : siteSearchConfigData.easyask_port,
                easyask_dictionary          : siteSearchConfigData.easyask_dictionary,
                sayt_product_id             : siteSearchConfigData.sayt_product_id,
                sayt_product_image          : siteSearchConfigData.sayt_product_image,
                sayt_product_name           : siteSearchConfigData.sayt_product_name,
                sayt_product_price          : siteSearchConfigData.sayt_product_price,
                sayt_product_description    : siteSearchConfigData.sayt_product_description,
                sayt_product_type           : siteSearchConfigData.sayt_product_type,
                sayt_product_sizes          : siteSearchConfigData.sayt_product_sizes,
            };
        },

        removeError(key) {
            let errorsObject = this.validationErrors;
            let errorExist   = errorsObject[key];
            if (errorExist) {
                delete errorsObject[key];
            }
            //for re-render component
            if (Object.keys(errorsObject).length <= 0) {
                this.validationErrors = "";
            } else {
                this.validationErrors = errorsObject;
            }
        },

        saveData() {
            this.validationErrors  = "";
            let params             = this.site;
            params.template_id     = params.template_id === undefined
                                     ? null
                                     : params.template_id;
            params.front_page_id   = params.front_page_id === undefined
                                     ? null
                                     : params.front_page_id;
            params.shop_page_id    = params.shop_page_id === undefined
                                     ? null
                                     : params.shop_page_id;
            params.product_page_id = params.product_page_id === undefined
                                     ? null
                                     : params.product_page_id;

            params.search_config   = this.search_configuration;

            axios[this.method](`${this.axios_url}`, params)
                .then(response => {
                    let message = 'Saved successfully!';
                    new Noty({
                        type: "success",
                        text: message,
                    }).show();

                    this.validationErrors = "";

                    window.location = this.backUrl;
                })
                .catch((err) => {
                    this.validationErrors = err.response.data.errors;
                    new Noty({
                        type: "error",
                        text: err.response.data.message,
                    }).show();
                    console.error(err);
                });
        },

        setPages(template_id) {
            // Get all home pages by template id
            this.allHomePages    = this.getPages(template_id, 'home');
            // Get all shop pages by template id
            this.allShopPages    = this.getPages(template_id, 'shop');
            // Get all product pages by template id
            this.allProductPages = this.getPages(template_id, 'single_product');
        },

        getPages(template_id, page_type) {
            return this.allPages.filter(page => {
                return page.template_id === template_id && page.page_type === page_type;
            });
        },

        capitalizeAllLetter(string) {
            return string.replace(/\w\S*/g, function (txt) {
                return txt.toUpperCase();
            });
        },

        getNextTab(next = true, tab = this.activeTab) {
            let tabsName = _.keys(this.tabs);
            let tabInd   = _.indexOf(tabsName, tab);
            let lastInd  = _.lastIndexOf(tabsName);
            tab          = tabInd !== -1 && tabInd !== lastInd ? tabsName[tabInd + (next ? 1 : -1)] : tab;

            return tab ?? (next ? 'PageConfiguration' : 'BasicInfo');
        },
    },

    watch   : {
        'site.template_id': function (newVal, oldVal) {
            if (newVal !== oldVal) {
                if (!_.isNull(newVal) || newVal !== undefined) {
                    this.isTemplateSelected = true;
                    this.setPages(newVal);
                    if (this.method === 'post' ||
                        (this.method === 'put' && JSON.parse(this.site_data).template_id !== newVal)
                    ) {
                        this.site.front_page_id   = null;
                        this.site.shop_page_id    = null;
                        this.site.product_page_id = null;
                    }
                }

                if (newVal === undefined) {
                    this.isTemplateSelected   = false;
                    this.site.front_page_id   = null;
                    this.site.shop_page_id    = null;
                    this.site.product_page_id = null;
                }
            }
        }
    },
    computed: {
        _() {
            return _;
        },
    },
}
</script>

<style>
.noty_theme__mint.noty_type__success {
    padding: .75rem 1.25rem !important;
    background: #42BA96;
}

.multiselect.is-invalid {
    border: 1px solid red;
    border-radius: 5px;
}

.red-border {
    border: 1px solid red !important;
}

</style>
