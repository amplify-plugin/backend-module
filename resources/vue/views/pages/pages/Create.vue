<template>
    <div class="row" id="scroll-top" :class="sidebarNav ? 'sidebarNav' : ''">
        <div :class="class_name">
            <div class="row">
                <div class="col-lg-8">
                    <form method="post" @submit.prevent="" :action="backUrl">
                        <FormFields ref="formFields"></FormFields>
                        <div id="saveActions" class="form-group">
                            <input type="hidden" name="save_action" value="save_and_back" v-model="actionType">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-success"
                                        @click="saveData(saveAction.active.value)">
                                    <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                                    <span>{{ saveAction.active.label }}</span>
                                </button>

<!--                                <div class="btn-group" role="group">-->
<!--                                    <button id="bpSaveButtonsGroup" type="button"-->
<!--                                            class="btn btn-success dropdown-toggle"-->
<!--                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span-->
<!--                                        class="caret"></span><span class="sr-only">▼</span></button>-->
<!--                                    <div class="dropdown-menu" aria-labelledby="bpSaveButtonsGroup">-->

<!--                                        <template v-for="(option, k, index) in saveAction.options">-->
<!--                                            <a class="dropdown-item"-->
<!--                                               href="javascript:void(0);"-->
<!--                                               :key="'actionType-'+index"-->
<!--                                               @click="saveData(k)">-->
<!--                                                {{ option }}-->
<!--                                            </a>-->
<!--                                        </template>-->
<!--                                    </div>-->
<!--                                </div>-->

                            </div>

                            <a :href="backUrl" class="btn btn-default"><span
                                class="la la-ban"></span> &nbsp;Cancel</a>

                        </div>
                    </form>
                </div>
                <div class="col-lg-4 px-0">
                    <div class="d-lg-none custom-sidebar-ar btn btn-light" id="custom-sidebar-ar"
                         @click="toggleSidebar()">
                        <div v-show="sidebarNav === false" class="menu-icon-ar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="#1b2a4e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-menu">
                                <line x1="3" y1="12" x2="21" y2="12"></line>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <line x1="3" y1="18" x2="21" y2="18"></line>
                            </svg>
                        </div>
                        <div v-show="sidebarNav === true" class="close-icon-ar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-x">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </div>
                    </div>
                    <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                               aria-controls="home"
                               aria-selected="false">Widget
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="options-tab" data-toggle="tab" href="#options" role="tab"
                               aria-controls="options"
                               aria-selected="true">Options</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                               aria-controls="profile"
                               aria-selected="false">SEO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="style-tab" data-toggle="tab" href="#style" role="tab"
                               aria-controls="style" title="Custom Style for this page"
                               aria-selected="false">CSS</a>
                        </li>
                    </ul>
                    <div class="tab-content" style="min-height: 469px; overflow-y: auto" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Type widget name to search"
                                       @keyup="filterWidgetByName"/>
                            </div>
                            <ul class="list-group fixed-height">
                                <li :class="{ 'active': index === activeWidgetIndex }"
                                    v-for="(wl, index) in widgetLists" data-toggle="modal"
                                    data-target="#widget-attributes-modal" @click="activeWidget = wl;
                                    activeWidgetIndex = index;
                                    $refs.widgetAttributesModal.getModal();" :key="index"
                                    class="list-group-item cursor-pointer" :data-wizard-value="wl.name">
                                    <p class="mb-1">
                                        {{ humanStyleWidgetName(wl.name) }}
                                        <i v-show="wl.description" class="la la-info-circle"
                                           data-toggle="tooltip" :title="wl.description"></i>
                                    </p>
                                    <div v-html="getDataSource(wl.model)"></div>
                                </li>
                            </ul>
                            <div class="d-flex justify-content-between my-2">
                                <p class="font-weight-bold mb-0">Snippet</p>
                                <div v-if="code.length > 0">
                                    <button
                                        v-clipboard:copy="code"
                                        v-clipboard:success="onCopy"
                                        v-clipboard:error="onError" type="button" class="btn-clipboard position-static"
                                        :style="{ background: copyButtonText === 'copy' ? 'black' : 'green' }">
                                        {{ copyButtonText }}
                                    </button>
                                </div>

                            </div>
                            <div class="d-flex justify-content-between">
                                <prism-editor class="my-editor height-150 language-xml-doc" v-model="code"
                                              :highlight="highlighter" :line-numbers="true"
                                              :readonly=true></prism-editor>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="options" role="tabpanel" aria-labelledby="options-tab">
                            <div class="form-group">
                                <label :class="{'error-color': validationErrors.slug}">
                                    Slug
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <input name="description" type="text"
                                       v-model="page.slug"
                                       class="form-control"
                                       required
                                       :class="{'is-invalid': validationErrors.slug}"
                                       :disabled="method === 'get'"
                                >
                                <small v-if="validationErrors.slug" class="text-danger mt-3">
                                    {{ validationErrors.slug[0] }}
                                </small>
                            </div>
                            <div class="form-group">
                                <label :class="{'error-color': validationErrors.page_type}">
                                    Page Type <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <multiselect
                                    placeholder="Select an page type"
                                    v-model="currentPageType"
                                    :options="pageTypesArray"
                                    :custom-label="labelWithDescription"
                                    label="label"
                                    track-by="code"
                                    :disabled="method === 'get'">
                                    <template slot="option" slot-scope="props">
                        <span class="font-weight-bold d-block" :title="props.option.description">
                            {{ props.option.label }} <i v-if="props.option.description.length !== 0"
                                                        class="mr-1 la la-info-circle"></i>
                        </span>
                                        <div class="text-sm text-gray-dark mt-1">
                                            <small>
                                                <b>Accessibility</b>:
                                                <span class="mr-1" :key="index"
                                                      v-for="(middleware, index) in props.option.middleware">{{
                                                        displayMiddleware(middleware)
                                                    }}</span>
                                                <span class="mr-1"
                                                      v-if="props.option.middleware.length == 0">None</span>
                                            </small>
                                        </div>
                                    </template>
                                </multiselect>

                                <small v-if="validationErrors.page_type" class="text-danger mt-3">
                                    {{ validationErrors.page_type[0] }}
                                </small>
                            </div>
                            <div class="form-group"
                                 v-if="page.page_type === 'static_page' || page.page_type == ''">
                                <label :class="{'error-color': validationErrors.middleware}">
                                    Accessibility
                                </label>
                                <multiselect
                                    placeholder="Select Accessibility Level(s)"
                                    v-model="page.middleware"
                                    :options="middlewareList"
                                    :custom-label="labelWithDescription"
                                    label="label"
                                    track-by="guard"
                                    :multiple="true"
                                    :preserve-search="true"
                                    :disabled="method === 'get'"
                                >
                                    <template slot="option" slot-scope="props">
                                        <span class="font-weight-bold d-block">{{ props.option.label }}</span>
                                        <small class="text-sm d-block text-gray-dark">{{
                                                props.option.description
                                            }}</small>
                                    </template>
                                </multiselect>

                                <small v-if="validationErrors.middleware" class="text-danger mt-3">
                                    {{ validationErrors.middleware[0] }}
                                </small>
                            </div>
                            <div class="form-group">
                                <div class="form-check form-check-inline d-block mb-3 mb-lg-0 d-lg-inline-flex">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="has-breadcrumbs"
                                           v-model="page.has_breadcrumb">
                                    <label class="form-check-label" for="has-breadcrumbs">Show Breadcrumbs</label>
                                </div>
                            </div>
                            <div class="form-group" v-if="page.has_breadcrumb">
                                <label>Breadcrumb Title</label>
                                <input type="text"
                                       :class="{'form-control' : true, 'is-invalid' : validationErrors.breadcrumb_title}"
                                       v-model="page.breadcrumb_title"/>
                                <small v-if="validationErrors.breadcrumb_title" class="text-danger mt-3">
                                    {{ validationErrors.breadcrumb_title[0] }}
                                </small>
                            </div>
                            <div class="form-group">
                                <div class="form-check form-check-inline d-block mb-3 mb-lg-0 d-lg-inline-flex">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="has-footer"
                                           v-model="page.has_footer">
                                    <label class="form-check-label" for="has-footer">Display Footer</label>
                                </div>
                            </div>
                            <div class="form-group" v-if="rightSideBarOptionEnabled">
                                <div class="form-check form-check-inline d-block mb-3 mb-lg-0 d-lg-inline-flex">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="has_right_sidebar"
                                           v-model="page.has_right_sidebar">
                                    <label class="form-check-label" for="has_right_sidebar">Display Right Side Panel</label>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="form-group">
                                <label>Meta Description:</label>
                                <textarea class="form-control" type="text" id="meta_description" name="meta_description"
                                          v-model="page.meta_description"
                                          placeholder="Enter meta description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Meta Keywords:</label>
                                <textarea class="form-control" type="text" id="meta_key" name="meta_key"
                                          v-model="page.meta_key" placeholder="Enter meta keyword"></textarea>
                            </div>
                            <div class="form-group">
                                <label>
                                    Meta Image
                                </label>
                                <div class="controls">
                                    <div class="input-group">
                                        <input type="text" name="meta_image_path" v-model="page.meta_image_path"
                                               id="meta_image_path" class="form-control">

                                        <span class="input-group-append">
                                        <button type="button" class="btn btn-light btn-sm popup_selector"
                                                data-toggle="modal" data-target="#file-manager-modal"
                                                @click="prepareModal(); processImagesByType(); canMultiple = false;">
                                            <i class="la la-cloud-upload"></i> Browse
                                        </button>
                                        <button type="button" class="btn btn-light btn-sm"
                                                @click="deleteImage()"><i class="la la-eraser"></i> Clear</button>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Title:</label>
                                <input class="form-control" type="text" id="title" name="title" v-model="page.title"
                                       placeholder="Enter title">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="style" role="tabpanel" aria-labelledby="style-tab">
                            <div class="form-group">
                                <label>Styles:</label>
                                <textarea class="form-control"
                                          style="height: 100%"
                                          type="text"
                                          id="styles"
                                          name="styles"
                                          v-model="page.styles"
                                          placeholder="Enter custom css styles"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <WidgetAttributesModal ref="widgetAttributesModal"></WidgetAttributesModal>
        <div class="modal fade" id="file-manager-modal" tabIndex="0" role="dialog"
             aria-labelledby="widget-attributes-modal-dialog-label" data-backdrop="static" data-keyboard="false"
             aria-modal="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="attribute-inline-create-dialog-label">
                            Set image for Seo Meta Image <strong> </strong>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" @click="modalShade = '';"
                                aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body bg-light">

                        <!-- Default box -->
                        <div class="card" style="margin-bottom: 0!important;">
                            <div class="card-body">
                                <div class="col-12 mt-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <file-manager ref="fileManager"></file-manager>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="modalShade = '';"
                                aria-label="Close" id="cancelWidgetAttributesModalBtn">Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import allDisksMixin from '../../../allDisks.mixin';
import _ from "lodash";
import FormFields from "./FormFields";
import {highlight, languages} from "prismjs/components/prism-core";
import "prismjs/components/prism-clike";
import "prismjs/components/prism-javascript";
import 'prismjs/themes/prism-tomorrow.css';
import {PrismEditor} from "vue-prism-editor";
import WidgetAttributesModal from "./WidgetAttributesModal";

export default {
    name: "PageCreate",
    mixins: [allDisksMixin],
    components: {FormFields, PrismEditor, WidgetAttributesModal},

    props: [
        'class_name', 'url', 'method', 'axios_url', 'local_page', 'save_action',
        'query_string', 'active_template', 'active_widgets',
        'page_types_array', 'middleware_list', 'use_right_sidebar'
    ],

    data() {
        return {
            page: {
                name: '',
                slug: '',
                breadcrumb_title: '',
                paramModel: '',
                modelFindColumn: '',
                meta_description: '',
                meta_key: '',
                meta_image_path: '',
                title: '',
                page_type: ((this.method !== 'post') ? null : 'static_page'),
                content: '',
                middleware: [],
                is_new: (this.method !== 'post'),
                is_updated: false,
                has_breadcrumb: true,
                has_footer: true,
                has_right_sidebar: true,
                styles: '',
            },
            currentPageType: null,
            selectedFiles: [],
            backUrl: '/admin/page',
            newUrl: '/admin/page/create',
            actionType: 'save_and_back',
            saveAction: JSON.parse(this.save_action),
            validationErrors: {},
            widgetLists: [],
            widgetListBackUp: [],
            showBannerCode: false,
            code: '',
            description: '',
            activeWidgetIndex: undefined,
            copyButtonText: 'copy',
            activeWidget: null,
            activeTemplateId: null,
            pageTypesArray: JSON.parse(this.page_types_array),
            middlewareList: JSON.parse(this.middleware_list),
            sidebarNav: false,
            rightSideBarOptionEnabled: this.use_right_sidebar || false
        }

    },

    async mounted() {

        await this.getWidgetLists();

        if (this.method !== 'post') {
            this.initEdit();
        } else {
            this.setPageType(this.page.page_type);
        }
    },

    methods: {
        toggleSidebar() {
            this.sidebarNav = !this.sidebarNav
        },

        initEdit() {
            let local_page = this.local_page;
            this.page = {
                name: local_page.name,
                slug: local_page.slug,
                title: local_page.title,
                meta_description: local_page.meta_description,
                meta_image_path: local_page.meta_image_path,
                meta_key: local_page.meta_key,
                page_type: local_page.page_type,
                paramModel: local_page.paramModel,
                modelFindColumn: local_page.modelFindColumn,
                id: local_page.id,
                content: local_page.content,
                is_updated: false,
                has_breadcrumb: local_page.has_breadcrumb,
                breadcrumb_title: local_page.breadcrumb_title,
                has_footer: local_page.has_footer,
                styles: local_page.styles
            }
            this.page.middleware = this.middlewareList.filter(function (middleware) {
                if (local_page.middleware) {
                    return local_page.middleware.includes(middleware.guard)
                }
            });
            if (local_page.page_type) {
                this.setPageType(local_page.page_type);
            }
        },

        setPageType(type) {
            for (const pageType of this.pageTypesArray) {
                if (pageType.code === type) {
                    this.currentPageType = pageType;
                    return;
                }
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
                window.location = '/admin/page';
            }
        },

        saveData(actionType) {
            this.validationErrors = {};
            this.page._save_action = actionType;
            let params = _.cloneDeep(this.page);
            params.values = JSON.stringify(this.page.values);
            params.template_id = JSON.parse(this.active_template).id;
            /*params.middleware = params.middleware.map(function (middleware) {
                return middleware.guard;
            });*/

            axios[this.method](`${this.axios_url}`, params)
                .then(response => {
                    this.validationErrors = "";
                    switch (actionType) {
                        case 'save_and_back':
                            console.log('save_and_back')
                            window.location = '/admin/page'
                            break;
                        case 'save_and_edit':
                            console.log('save_and_edit')
                            window.location = '/admin/page/' + params.id + '/edit'
                            break;
                        case 'save_and_new':
                            console.log('save_and_new')
                            window.location = '/admin/page/create'
                            break;
                        case 'save_and_preview':
                            console.log('save_and_preview')
                            window.location = '/admin/page/' + params.id + '/show'
                            break;
                    }
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
            this.description = widget.description;
            this.activeWidget = widget;
        },

        getDataSource(source) {
            let pages = [];

            for (const sourceElement of source) {
                for (const pageTypesArrayElement of this.pageTypesArray) {
                    if (pageTypesArrayElement.code === sourceElement) {
                        pages.push(pageTypesArrayElement.label);
                        break;
                    }
                }
            }

            return '<span class="badge badge-info">Page</span>' + pages.join(", ");
            // if (source === 'easy-ask') {
            //     return 'Data Source: <span class="badge bg-danger">Easy Ask Server</span>';
            // } else if (source !== null && source !== 'easy-ask') {
            //     return 'Data Source: <span class="badge bg-success">Model</span>'
            // } else if (source === null) {
            //     return 'Data Source:  <span class="badge bg-dark">Static</span>'
            // }
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

        changeURLType(e) {
            let urlType = e.target.value;
            if (urlType === "page") {
                this.$parent.menu.url = "";
                this.page = true;
            } else {
                this.page = false;
            }
        },

        // File Manager methods
        prepareModal() {
            setTimeout(() => {
                let modalShade = document.querySelector(".modal-backdrop.fade.show");
                modalShade ? modalShade.remove() : null;
                this.modalShade = modalShade.outerHTML
                this.modalBody = document.querySelector("#file-manager-modal .modal-body").innerHTML
            }, 10);
        },
        removeSelectedFiles(index, length = 1) {
            let path = this.selectedFiles.splice(index, length);
            let noty = {
                type: 'success',
                text: `File (${path}) removed!`,
            };
            new Noty(noty).show()
        },

        browseMainImage(event) {
            event.preventDefault();
        },

        processImagesByType(indexOfAttributes = 0) {
            this.indexOfAttributes = indexOfAttributes;
            this.selectedFiles = this.page.meta_image_path;
        },

        getFileAddedMessage() {
            let noty = {
                type: "success",
                text: "File path added!",
            };

            new Noty(noty).show();
        },

        deleteImage(indexOfAttributes = 0) {
            this.$swal({
                title: 'Remove this Image?',
                //icon              : 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff6b81',
                cancelButtonColor: '#399E7F',
                confirmButtonText: 'Remove'

            }).then((result) => {
                if (result.isConfirmed) {
                    this.page.meta_image_path = '';
                }
            });
        },

        getFileExtension(file) {
            const regexp = /\.([0-9a-z]+)(?:[\?#]|$)/i;
            const extension = file.match(regexp);
            return extension && extension[1];
        },

        labelWithDescription(option, field) {
            return option.label;
        },

        displayMiddleware(guard) {
            if (guard !== '') {
                for (const middleware of this.middlewareList) {
                    if (middleware.guard === guard) {
                        return middleware.label + ',';
                    }
                }

                return guard[0].toUpperCase() + guard.slice(1) + ','
            }

            return guard;
        },

        humanStyleWidgetName(name) {
            let content = name.replaceAll(".", ' ').replace('x-', '').replace('-', ' ');
            return content.split(' ').map((word) => word[0].toUpperCase() + word.substr(1)).join(" ");
        },
    },

    watch: {
        "this.page.page_type": function (newVal, oldVal) {
            if (newVal !== oldVal) {
                this.getWidgetLists(newVal);
            }
        },
        "$store.state.fm.left.selected.files": {
            handler(files) {
                if (files.length) {
                    const self = this;

                    if (self.canMultiple) {
                        let filesPath = files.filter(file => {
                            return ['jpg', 'jpeg', 'png'].includes(self.getFileExtension(file.toLowerCase()));
                        });

                        if (filesPath) {
                            self.selectedFiles = filesPath.map(filePath => {
                                return self.all_disks[self.$store.state.fm.left.selectedDisk].url ? self.all_disks[self.$store.state.fm.left.selectedDisk].url + "/" + filePath : "/" + filePath;
                            })
                        }
                    } else {
                        let filePath = files.find(file => {
                            return ['jpg', 'jpeg', 'png'].includes(self.getFileExtension(file.toLowerCase()));
                        });

                        if (filePath) {
                            self.selectedFiles = self.all_disks[self.$store.state.fm.left.selectedDisk].url ? self.all_disks[self.$store.state.fm.left.selectedDisk].url + "/" + filePath : "/" + filePath;
                        }
                    }
                    self.page.meta_image_path = self.selectedFiles;
                    self.getFileAddedMessage();
                }
            }
        },
        currentPageType: function (value) {
            if (value) {
                this.page.page_type = value.code;
                this.page.middleware = value.middleware;
            } else {
                this.page.page_type = ''
                this.page.middleware = [];
            }
        }

    }
}


function alignSidebar() {
    let prevScrollpos = window.scrollY;
    let scrollTop = document.getElementById('scroll-top');
    if (scrollTop) {
        if (prevScrollpos > 110) {
            scrollTop.classList.add('fixed-nav')
        } else {
            scrollTop.classList.remove('fixed-nav')
        }
    }
}

window.onscroll = () => alignSidebar();

document.addEventListener('DOMContentLoaded', () => {
    let sidebar = document.getElementById('custom-sidebar-ar');
    if (sidebar) {
        sidebar.addEventListener('click', () => alignSidebar());
    }
});


</script>

<style scoped>
.height-100 {
    height: 100px;
}

.height-150 {
    height: 150px !important;
}

.fixed-height {
    height: 300px;
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

@media (max-width: 991px) {
    .sidebarNav {
        position: relative;
        overflow: hidden;
    }

    .col-lg-4 {
        position: fixed;
        top: 110px;
        right: -340px;
        background: #f1f4f8;
        height: 100%;
        width: calc(90% - 15px);
        transition: all .5s;
        max-width: 340px;
        padding: 15px;
        border: 1px solid rgba(0, 40, 100, .12);
        border-radius: 4px;
        box-shadow: 0 0 16px 0 #00000073;
    }

    .sidebarNav .col-lg-4 {
        right: 0;
    }

    .custom-sidebar-ar {
        z-index: 9010;
        top: 50%;
        position: fixed;
        right: 0;
        transition: all .5s;
    }

    .sidebarNav .custom-sidebar-ar {
        right: 340px;
    }

    .fixed-nav .col-lg-4 {
        top: 0;
    }
}
</style>
