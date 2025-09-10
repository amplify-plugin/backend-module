<template>
    <div class="row">
        <div :class="class_name">
            <!-- Default box -->
            <form method="post" @submit.prevent="" :action="backUrl">
                <div v-if="translation_enabled" class="mb-2 text-right">
                    <!-- Single button -->
                    <AvailableLocales
                        :availableLocales="availableLocales"
                        :queryString="query_string"
                        :current_lang="current_lang"
                        :url="url"
                    />
                </div>
                <div class="tab-container  mb-2">
                    <Tabs :key="tabsRerender"/>
                    <div class="tab-content p-0 ">
                        <div class="nav-tabs-custom " id="form_tabs">
                            <component :is="activeTab"/>
                            <SwitchTabs ref="switchTabs"/>

                        </div>
                    </div>
                </div>
                <div id="saveActions" class="form-group">
                    <input type="hidden" name="save_action" value="save_and_back" v-model="actionType">
                    <div class="btn-group" role="group">

                        <button type="button" class="btn btn-success"
                                @click="saveData(saveAction.active.value)">
                            <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                            <span>{{ saveAction.active.label }}</span>
                        </button>

                        <div class="btn-group" role="group">
                            <button id="bpSaveButtonsGroup" type="button" class="btn btn-success dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                class="caret"></span><span class="sr-only">▼</span></button>
                            <div class="dropdown-menu" aria-labelledby="bpSaveButtonsGroup">

                                <template v-for="(option, k, index) in saveAction.options">
                                    <a class="dropdown-item"
                                       href="javascript:void(0);"
                                       :key="'actionType-'+index"
                                       @click="saveData(k)">
                                        {{ option }}
                                        <!-- {{ option }} {{k}} {{index}} -->
                                    </a>
                                </template>
                            </div>
                        </div>

                    </div>

                    <a :href="backUrl" class="btn btn-default"><span
                        class="la la-ban"></span> &nbsp;Cancel</a>

                </div>

            </form>
        </div>
    </div>
</template>

<script>
import Tabs from "./tabs/Tabs";
import BasicInfo from "./tabs/BasicInfo";
import Products from "./tabs/Products";
import AvailableLocales from "../../components/AvailableLocales";
import _ from "lodash";
import SwitchTabs from "../../components/SwitchTabs";

export default {
    name: "CategoryCreate",
    props: [
        'class_name',
        'url',
        'translatable',
        'translation_enabled',
        'available_locales',
        'current_lang',
        'method',
        'axios_url',
        'locale',
        'categorization_required',
        'active_tab',
        'local_category',
        'query_string',
        'easy_ask_default_product_categories',
        'save_action'
    ],
    data() {
        return {
            availableLocales: JSON.parse(this.available_locales),
            category: {
                category_code: '',
                category_name: '',
                description: '',
                category_slug: '',
                pim_category_id: '',
                template: '',
                image: '',
                is_top_nav: 0,
                featured: 0,
                is_updated: false,
                products: []
            },
            selectedProducts: [],
            backUrl: '/admin/category',
            newUrl: '/admin/category/create',
            actionType: 'save_and_back',
            tabs: {
                BasicInfo: {title: 'Basic Info', hash: 'basic-info'},
                Products: {title: 'Products', hash: 'products'},
            },
            activeTab: _.cloneDeep(this.active_tab),
            validationErrors: {},
            tabsRerender: 0,
            easyAskDefaultProductCategories: JSON.parse(this.easy_ask_default_product_categories),
            saveAction: JSON.parse(this.save_action),
            timer: null,
            pim_category_id_required: false
        }
    },
    components: {SwitchTabs, AvailableLocales, Tabs, BasicInfo, Products},

    created() {
        if (this.method === 'put') {
            this.initEdit()
        }
    },

    mounted() {
        this.pim_category_id_required = (this.categorization_required === 'Y');
    },

    methods: {
        initEdit() {
            let local_category = JSON.parse(this.local_category);
            let category_relational_products = local_category.products.map(ele => {
                return ele.id
            });

            this.category = {
                category_name: local_category.label,
                description: local_category.description,
                category_slug: local_category.category_slug,
                id: local_category.id,
                products: category_relational_products,
                category_code: local_category.category_code,
                pim_category_id: local_category.pim_category_id,
                template: local_category.template,
                image: local_category.image,
                is_top_nav: local_category.is_top_nav,
                featured: local_category.featured,
                is_updated: false
            }

            this.selectedProducts = local_category.products.map((product) => {
                return {
                    'Product_Id': product.id,
                    'Product_Name': product.local_product_name,
                    'Thumbnail': product?.product_image?.main ?? null,
                };
            });

            // if (_.isNull(this.category.category_slug)) {
            //     this.convertNameToSlug(this.category.category_name)
            // }
        },

        saveAndAction(argument) {
            if (argument === 'cancel') {
                window.location = '/admin/category';
            }
        },

        saveData(actionType) {
            this.actionType = actionType;
            this.validationErrors = {};
            this.category._save_action = actionType;
            let params = _.cloneDeep(this.category);
            params.values = JSON.stringify(this.category.values);
            // console.log('saveData', actionType, params)
            axios[this.method](`${this.axios_url}?locale=${this.locale}`, params)
                .then(response => {
                    // console.log('response:', response, response.config.url, params)
                    new Noty({
                        type: "success",
                        text: 'Saved successfully',
                    }).show();
                    window.location.href = "/"+response.data.redirect_url;
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

        getNextTab(next = true, tab = this.activeTab) {
            let tabsName = _.keys(this.tabs);
            let tabInd = _.indexOf(tabsName, tab);
            let lastInd = _.lastIndexOf(tabsName);
            tab = tabInd !== -1 && tabInd !== lastInd ? tabsName[tabInd + (next ? 1 : -1)] : tab;

            return tab ?? (next ? 'Products' : 'BasicInfo');
        },

        convertNameToSlug(Name) {
            clearTimeout(this.timer);
            this.timer = setTimeout(() => {
                let slug = Name.trim()
                    .toLowerCase()
                    .replace(/-/g, ' ')
                    .replace(/[^\w ]+/g, '')
                    .replace(/ +/g, '-');

                this.checkCategorySlugUnique(slug);
            }, 500)
        },

        checkCategorySlugUnique(slug) {
            let params = {};
            if (this.method === 'put') {
                params.id = this.category.id
            }
            params.slug = slug;

            axios.post(`/admin/category/fetch/category-slug`, params)
                .then(response => {
                    this.category.category_slug = response.data.slug;
                })
                .catch((err) => {
                    console.error(err);
                });
        }
    }
}
</script>

<style scoped>

</style>
