<template>
    <div class="row">
        <div :class="class_name">
            <form method="post" @submit.prevent="" :action="backUrl">

                <!-- load the view from the application if it exists, otherwise load the one in the package -->
                <div class="card">
                    <div class="card-body">
                        <FormFields
                            ref="formFields"
                        ></FormFields>
                    </div>
                </div>


                <div id="saveActions" class="form-group" v-if="method !== 'get'">

                    <input type="hidden" name="save_action" v-model="actionType">

                    <button @click="actionType='save_and_back';
                                saveData()"
                            type="button" class="btn btn-success">
                        <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                        <span data-value="save_and_edit"> Save</span>
                    </button>

                    <button @click="actionType='save_and_new';
                                saveData()"
                            type="button"
                            class="btn btn-outline-primary">
                        <span class="la la-folder-open" role="presentation" aria-hidden="true"></span> &nbsp;
                        <span data-value="save_and_edit"> Save and new</span>
                    </button>

                    <button v-has-role="'Super Admin, User'" @click="actionType='save_and_next';
                                saveData()"
                            type="button"
                            class="btn btn-outline-info">
                        <span class="la la-step-forward" role="presentation" aria-hidden="true"></span> &nbsp;
                        <span data-value="save_and_edit"> Save and next</span>
                    </button>

                    <button @click="saveAndAction('cancel')" type="button"
                            class="btn btn-default">
                        <span class="la la-ban"></span> Cancel
                    </button>

                </div>
            </form>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="display-flex justify-content-between align-items-center">
                        <h4 class="card-title">
                            <span class="la la-gear"></span>
                            <span>Topbar Widget List</span>
                        </h4>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Type widget name to search" @keyup="filterWidgetByName"/>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-group fixed-height">
                        <li :class="{'active': index === activeWidgetIndex }" v-for="(wl,index) in widgetLists"
                            data-toggle="modal"
                            data-target="#widget-attributes-modal"
                            @click="activeWidget=wl;
                                    activeWidgetIndex=index;
                                    $refs.widgetAttributesModal.getModal();" :key="index"
                            class="list-group-item cursor-pointer">
                            {{ wl.name }} <br>
                            <div v-html="getDataSource(wl.model)"></div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card" v-show="code || description">
                <div class="card-body">
                    <div v-if="code">
                        <div class="d-flex justify-content-between">
                            <h4>Widget Code</h4>
                            <button v-clipboard:copy="code"
                                    v-clipboard:success="onCopy"
                                    v-clipboard:error="onError"
                                    type="button" class="btn-clipboard"
                                    :style="{background: copyButtonText === 'copy' ? 'black' : 'green'}">
                                {{ copyButtonText }}
                            </button>
                        </div>

                        <prism-editor
                            class="my-editor height-150 language-xml-doc"
                            v-model="code"
                            :highlight="highlighter"
                            :line-numbers="true"
                            :readonly=true
                        ></prism-editor>
                    </div>
                    <div v-if="description">
                        <h4 class="mt-3">Widget Explanation</h4>
                        <p>{{ description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <WidgetAttributesModal
            ref="widgetAttributesModal"
        ></WidgetAttributesModal>
    </div>
</template>

<script>
import _          from "lodash";
import FormFields from "./FormFields";

import {highlight, languages} from "prismjs/components/prism-core";
import "prismjs/components/prism-clike";
import "prismjs/components/prism-javascript";
import "prismjs/themes/prism-okaidia.min.css";
import WidgetAttributesModal from "../pages/WidgetAttributesModal";
import {PrismEditor}         from "vue-prism-editor"; // import syntax highlighting styles

export default {
    name      : "TopBarCreate",
    components: {FormFields, PrismEditor, WidgetAttributesModal},

    props: [
        'class_name', 'url', 'method', 'axios_url', 'local_top_bar', 'query_string', 'active_topbar_widgets',
    ],
    //`template_id``name``is_enabled``content`
    data() {
        return {
            top_bar          : {
                name      : '',
                is_enabled: false,
                content   : `<?xml version="1.0"?>
<content>

</content>`,
            },
            backUrl          : '/admin/top-bar',
            newUrl           : '/admin/top-bar/create',
            actionType       : 'save_and_back',
            widgetLists      : [],
            validationErrors : {},
            code             : '',
            description      : '',
            copyButtonText   : 'copy',
            activeWidgetIndex: undefined,
            activeWidget     : null,
        }
    },

    created() {
        this.widgetLists = JSON.parse(this.active_topbar_widgets);
        if (this.method !== 'post') {
            this.initEdit()
        }
    },

    methods: {
        initEdit() {
            let local_top_bar = JSON.parse(this.local_top_bar);

            this.top_bar = {
                id        : local_top_bar.id,
                name      : local_top_bar.name,
                is_enabled: local_top_bar.is_enabled,
                content   : local_top_bar.content,
            }
        },

        showCode(widget) {
            this.code        = widget.code;
            this.description = widget.description;
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

        saveAndAction(argument) {
            if (argument === 'cancel') {
                window.location = '/admin/top-bar';
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

        saveData() {
            this.validationErrors = {};
            let params            = _.cloneDeep(this.top_bar);
            axios[this.method](`${this.axios_url}`, params)
                .then(response => {
                    console.log(response)
                    new Noty({
                        type: "success",
                        text: 'Saved successfully',
                    }).show();
                    this.validationErrors = "";

                    window.location = this.actionType === 'save_and_back' ? this.backUrl : this.newUrl;
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

        filterWidgetByName(e){
            let name = e.target.value;
            this.widgetLists = JSON.parse(this.active_topbar_widgets);
            this.widgetLists = this.widgetLists.filter(widget => {
                console.log(widget.name.toLowerCase());
                return widget.name.toLowerCase().includes(name.toLowerCase());
            });
        },
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
