<template>
    <div class="row">
        <div class="col-lg-8">

            <!-- Default box -->
            <form method="post" @submit.prevent="" :action="backUrl">
                <!-- load the view from the application if it exists, otherwise load the one in the package -->
                <div class="card">
                    <div class="card-body">
                        <FormFields ref="formFields"></FormFields>
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
                            <button id="bpSaveButtonsGroup" type="button"
                                    class="btn btn-success dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                class="caret"></span><span class="sr-only">▼</span></button>
                            <div class="dropdown-menu" aria-labelledby="bpSaveButtonsGroup">

                                <template v-for="(option, k, index) in saveAction.options">
                                    <button class="dropdown-item"
                                            type="button"
                                            :key="'actionType-'+index"
                                            @click="saveData(k)">
                                        {{ option }}
                                    </button>
                                </template>
                            </div>
                        </div>

                    </div>

                    <a :href="backUrl" class="btn btn-default"><span
                        class="la la-ban"></span> &nbsp;Cancel</a>

                </div>

            </form>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <p class="card-header"><i class="la la-gear"></i>Widgets</p>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Type widget name to search"
                               @keyup="filterWidgetByName"/>
                    </div>
                    <ul class="list-group fixed-height mb-4">
                        <li :class="{ 'active': index === activeWidgetIndex }"
                            v-for="(wl, index) in widgetLists" data-toggle="modal"
                            data-target="#widget-attributes-modal" @click="activeWidget = wl;
                                    activeWidgetIndex = index;
                                    $refs.widgetAttributesModal.getModal();" :key="index"
                            class="list-group-item cursor-pointer" :data-widget-value="wl.name">
                            <p class="mb-1">
                                {{ humanStyleWidgetName(wl.name) }}
                                <i v-show="wl.description" class="la la-info-circle"
                                   data-toggle="tooltip" :title="wl.description"></i>
                            </p>
                            <div v-html="getDataSource(wl.model)"></div>
                        </li>
                    </ul>
                    <div v-show="code || description">
                        <div v-if="code">
                            <div class="d-flex justify-content-between">
                                <h4>Widget Code</h4>
                                <button v-clipboard:copy="code" v-clipboard:success="onCopy"
                                        v-clipboard:error="onError" type="button" class="btn-clipboard"
                                        :style="{ background: copyButtonText === 'copy' ? 'black' : 'green' }">
                                    {{ copyButtonText }}
                                </button>
                            </div>

                            <prism-editor class="my-editor height-150 language-xml-doc" v-model="code"
                                          :highlight="highlighter" :line-numbers="true"
                                          :readonly=true></prism-editor>
                        </div>
                        <div v-if="description">
                            <h4 class="mt-3">Widget Explanation</h4>
                            <p>{{ description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <WidgetAttributesModal ref="widgetAttributesModal"/>
    </div>
</template>

<script>
import _ from "lodash";
import FormFields from "./FormFields";
import {highlight, languages} from "prismjs/components/prism-core";
import "prismjs/components/prism-clike";
import "prismjs/components/prism-javascript";
import "prismjs/themes/prism-okaidia.min.css";
import {PrismEditor} from "vue-prism-editor"; // import syntax highlighting styles
import WidgetAttributesModal from "../pages/WidgetAttributesModal.vue";

export default {
    name: "FooterCreate",
    components: {FormFields, PrismEditor, WidgetAttributesModal},

    props: [
        'class_name', 'url', 'method', 'axios_url', 'active_widgets',
        'local_footer', 'query_string', 'footer_layouts', 'footer_items',
        'save_action', 'footer_templates', 'active_template',
        'merch_zones', 'banner_zones', 'banner_item_codes', 'content_lists',
        'menu_group_lists'
    ],
    data() {
        return {
            page: {
                page_type: 'static_page',
            },
            footer: {
                name: '',
                layout: '',
                content: ``,
                template_id: null,
                is_enabled: false,
                is_new: (this.method !== 'put'),
                is_updated: false,
            },
            templates: [],
            template_id: null,
            backUrl: '/admin/footer',
            newUrl: '/admin/footer/create',
            actionType: 'save_and_back',
            validationErrors: {},
            widgetLists: [],
            widgetListBackUp: [],
            allFooterLayouts: [],
            selectedLayout: {},
            merchLists: [],
            bannerZoneLists: [],
            bannerItemCodes: [],
            showBannerCode: false,
            contentLists: [],
            menuGroupLists: [],
            code: '',
            description: '',
            activeWidgetIndex: undefined,
            activeWidget: null,
            copyButtonText: 'copy',
            saveAction: JSON.parse(this.save_action),
        }
    },
    created() {
        this.merchLists = JSON.parse(this.merch_zones)
        this.bannerZoneLists = JSON.parse(this.banner_zones)
        this.bannerItemCodes = JSON.parse(this.banner_item_codes)
        this.contentLists = JSON.parse(this.content_lists)
        this.menuGroupLists = JSON.parse(this.menu_group_lists)
    },
    async mounted() {
        if (typeof this.footer_templates === 'string') {
            this.templates = JSON.parse(this.footer_templates);
        }
        this.footer.template_id = this.active_template;

        await this.getWidgetLists();

        let obj = JSON.parse(this.footer_layouts);
        this.allFooterLayouts = [];
        for (let i in obj)
            this.allFooterLayouts.push(obj[i]);

        if (this.method !== 'post') {
            this.initEdit();
        }
    },

    methods: {
        initEdit() {
            let local_footer = JSON.parse(this.local_footer);
            this.footer = {
                id: local_footer.id,
                name: local_footer.name,
                content: local_footer.content,
                is_enabled: local_footer.is_enabled,
                template_id: local_footer.template_id,
                is_new: false,
                is_updated: false,
            }
        },
        onCopy: function (e) {
            this.copyButtonText = 'copied';
            setTimeout(() => {
                this.copyButtonText = 'copy';
            }, 2000)
            //alert('You just copied: ' + e.text)
        },
        onError: function (e) {
            alert('Failed to copy texts')
        },
        highlighter(code) {
            return highlight(code, languages.js); //returns html
        },

        saveAndAction(argument) {
            if (argument === 'cancel') {
                window.location = '/admin/footer';
            }
        },
        filterWidgetByName(e) {
            let name = e.target.value;
            if (name.length > 0) {
                this.widgetLists = this.widgetLists.filter(widget => {
                    return widget.name.search(new RegExp(name.trim(), "i")) >= 0;
                });
            } else {
                this.widgetLists = this.widgetListBackUp;
            }
        },
        async getWidgetLists(pageType = null) {
            // Getting all available widgets via props
            let widgetLists = await axios.get(`/admin/page/get-widget`)
            widgetLists = Object.values(widgetLists.data);

            // Filtering widgets if page type is selected
            if (pageType !== null) {
                this.widgetLists = widgetLists.filter(widget => {
                    return true;
                });
            } else {
                this.widgetLists = widgetLists;
            }
            // Backing up the widget list
            this.widgetListBackUp = this.widgetLists;
        },
        getDataSource(source) {
            if (source === 'easy-ask') {
                return 'Data Source: <span class="badge bg-danger">Easy Ask Server</span>';
            } else if (source !== null && source !== 'easy-ask') {
                return 'Data Source: <span class="badge bg-success">Model</span>'
            } else if (source === null) {
                return 'Data Source:  <span class="badge bg-dark">Static</span>'
            }
        },
        saveData(actionType) {
            this.validationErrors = {};
            let params = _.cloneDeep(this.footer);
            params.content = this.footer.content;
            params.layout = 'test'; //TODO Bad thing column not null confined
            params.is_updated = (this.method === 'put');
            params._save_action = actionType;
            axios[this.method](`${this.axios_url}`, params)
                .then(response => {
                    window.location.href = "/" + response.data.redirect_url;
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
        showCode(widget) {
            this.code = `<${widget.short_code}></${widget.short_code}>`;
        },
        humanStyleWidgetName(name) {
            let content = name.replaceAll(".", ' ').replace('x-', '').replace('-', ' ');
            return content.split(' ').map((word) => word[0].toUpperCase() + word.substr(1)).join(" ");
        }
    }
}
</script>

<style scoped>
.height-100 {
    height: 100px;
}

.height-150 {
    height: 150px;
}

.fixed-height {
    height: 350px;
    overflow: auto;
}

.btn-clipboard {
    position: absolute;
    top: .5rem;
    right: .5rem;
    z-index: 10;
    display: block;
    padding: .25rem .5rem;
    font-size: 75%;
    color: #ffffff;
    background-color: transparent;
    border: 0;
    border-radius: .25rem;
}

.btn-clipboard:hover {
    color: #fff;
    background-color: #ffa000;
}
</style>
