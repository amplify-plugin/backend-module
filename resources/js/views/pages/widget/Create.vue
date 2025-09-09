<template>
    <div id="widgetCreate" class="animated fadeIn">

        <div class="row">
            <div class="col-md-8 bold-labels">
                <!-- Default box -->

                <form method="post" :action="backUrl">

                    <div class="card">
                        <div class="card-body row">
                            <div class="form-group col-sm-12"
                                 :class="{'text-danger': validationErrors.name}">
                                <label> Name <span class="text-danger font-weight-bold">*</span></label>
                                <input @input="removeError('name');" type="text" name="name"
                                       v-model="widget.name"
                                       class="form-control" :class="{'is-invalid': validationErrors.name}">
                                <small v-if="validationErrors.name"
                                       class="text-danger mt-3">{{ validationErrors.name[0] }}</small>
                            </div>

                            <div class="form-group col-sm-12"
                                 :class="{'text-danger': validationErrors.model}">
                                <label> Model </label>
                                <input @input="removeError('model');" type="text" name="model"
                                       v-model="widget.model"
                                       class="form-control" :class="{'is-invalid': validationErrors.model}">
                                <small v-if="validationErrors.model"
                                       class="text-danger mt-3">{{ validationErrors.model[0] }}</small>
                            </div>

                            <div class="form-group col-sm-12"
                                 :class="{'text-danger': validationErrors.data}">
                                <label> Data </label>
                                <input @input="removeError('data');" type="text" name="data"
                                       v-model="widget.data"
                                       class="form-control" :class="{'is-invalid': validationErrors.data}">
                                <small v-if="validationErrors.data"
                                       class="text-danger mt-3">{{ validationErrors.data[0] }}</small>
                            </div>

                            <div class="form-group col-sm-12"
                                 :class="{'text-danger': validationErrors.placement}">

                                <div class="d-flex justify-content-between">
                                    <label>Placement <span class="text-danger font-weight-bold">*</span></label>
                                </div>
                                <treeselect
                                    @select="removeError('placement')"
                                    :class="{'is-invalid': validationErrors.placement}"
                                    :multiple="false"
                                    name="placement"
                                    placeholder="Pick an placement"
                                    :options="allPlacements"
                                    v-model="widget.placement"/>
                                <small v-if="validationErrors.placement"
                                       class="text-danger mt-3">{{ validationErrors.placement[0] }}</small>
                            </div>

                            <div v-if="widget.placement === 'page'" class="form-group col-sm-12"
                                 :class="{'text-danger': validationErrors.page_types}">

                                <div class="d-flex justify-content-between">
                                    <label>Page Types <span class="text-danger font-weight-bold">*</span></label>
                                </div>
                                <treeselect
                                    @select="removeError('page_types')"
                                    :class="{'is-invalid': validationErrors.page_types}"
                                    name="page_types"
                                    placeholder="Pick some page types"
                                    :options="allPageTypes"
                                    :multiple="true"
                                    v-model="widget.page_types"/>
                                <small v-if="validationErrors.page_types"
                                       class="text-danger mt-3">{{ validationErrors.page_types[0] }}</small>
                            </div>

                            <div class="form-group col-sm-12"
                                :class="{'text-danger': validationErrors.tags}">

                                <div class="d-flex justify-content-between">
                                    <label>Tags</label>
                                </div>

                                <multiselect
                                    @select="removeError('tags')"
                                    :class="{'is-invalid': validationErrors.tags}"
                                    name="tags"
                                    label="name"
                                    track-by="id"
                                    placeholder="Pick some tags"
                                    :options="allTags"
                                    :multiple="true"
                                    v-model="widget.tags">
                                </multiselect>


                                <small v-if="validationErrors.tags"
                                    class="text-danger mt-3">{{ validationErrors.tags[0] }}</small>
                            </div>

                            <div class="form-group col-sm-12"
                                 :class="{'text-danger': validationErrors.blade}">
                                <label> Blade <span class="text-danger font-weight-bold">*</span></label>
                                <input @input="removeError('blade');" type="text" name="blade"
                                       v-model="widget.blade"
                                       class="form-control" :class="{'is-invalid': validationErrors.blade}">
                                <small v-if="validationErrors.blade"
                                       class="text-danger mt-3">{{ validationErrors.blade[0] }}</small>
                            </div>

                            <div class="form-group col-sm-12"
                                 :class="{'text-danger': validationErrors.template_id}">

                                <div class="d-flex justify-content-between">
                                    <label>Template</label>
                                </div>
                                <treeselect
                                    @select="removeError('template_id')"
                                    :class="{'is-invalid': validationErrors.template_id}"
                                    :multiple="false"
                                    name="placement"
                                    placeholder="Pick a template"
                                    :options="allTemplates"
                                    v-model="widget.template_id"/>
                                <small v-if="validationErrors.template_id"
                                       class="text-danger mt-3">{{ validationErrors.template_id[0] }}</small>
                            </div>

                            <div class="form-group col-sm-12"
                                 :class="{'text-danger': validationErrors.description}">

                                <div class="d-flex justify-content-between">
                                    <label>Description</label>
                                </div>
                                <textarea v-model="widget.description"
                                          @input="removeError('description');"
                                          class="form-control"
                                          :class="{'is-invalid': validationErrors.description}"
                                          rows="3">
                                </textarea>
                                <small v-if="validationErrors.description"
                                       class="text-danger mt-3">{{ validationErrors.description[0] }}</small>
                            </div>


                            <div class="form-group col-sm-12 required">
                                <label :class="{'error-color': validationErrors.code}">
                                    Code
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <prism-editor
                                    class="my-editor language-xml-doc"
                                    v-model="widget.code"
                                    :highlight="highlighter"
                                    :line-numbers="true"
                                    :readonly="$parent.method === 'get'"
                                ></prism-editor>
                                <small v-if="validationErrors.code" class="text-danger mt-3">
                                    {{ validationErrors.code[0] }}
                                </small>
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
        </div>
    </div>
</template>

<script>
import Treeselect  from "@riophae/vue-treeselect";
import Multiselect from "vue-multiselect";
import { PrismEditor } from "vue-prism-editor";
import "vue-prism-editor/dist/prismeditor.min.css"; // import the styles somewhere

// import highlighting library (you can use any library you want just return html string)
import {highlight, languages} from "prismjs/components/prism-core";
import "prismjs/components/prism-clike";
import "prismjs/components/prism-javascript";
import "prismjs/themes/prism-okaidia.min.css"; // import syntax highlighting styles

export default {
    name      : "WidgetCreate",
    components: {Multiselect, Treeselect, PrismEditor},
    props     : [
        'url', 'axios_url', 'query_string',
        'method', 'widget_data', 'all_templates',
        'all_placements', 'all_page_types', 'all_tags', 'save_action'
    ],

    data() {
        return {
            validationErrors: {},
            backUrl         : '/admin/widget',
            widget          : {
                name       : null,
                model      : null,
                data       : null,
                placement  : null,
                page_types : null,
                tags       : [],
                blade      : null,
                template_id: null,
                code       : null,
                description: null,
            },
            allPlacements   : JSON.parse(this.all_placements),
            allTemplates    : JSON.parse(this.all_templates),
            allPageTypes    : JSON.parse(this.all_page_types),
            allTags    : JSON.parse(this.all_tags),
            saveAction : JSON.parse(this.save_action),
            actionType : 'save_and_back'
        }
    },
    created() {
        if (this.method === 'put') {
            this.initEdit()
        }
    },
    methods: {
        initEdit() {
            let widgetData = JSON.parse(this.widget_data);
            this.widget    = {
                id         : widgetData.id,
                name       : widgetData.name,
                model      : widgetData.model,
                data       : widgetData.data,
                placement  : widgetData.placement,
                page_types : !_.isNull(widgetData.page_types)
                             ? JSON.parse(widgetData.page_types)
                             : null,
                tags       : (Array.isArray(widgetData.tags) && widgetData.tags.length)
                             ? widgetData.tags
                             : [],
                blade      : widgetData.blade,
                template_id: widgetData.template_id,
                code       : widgetData.code,
                description: widgetData.description,
            };
        },

        highlighter(code) {
            return highlight(code, languages.js); //returns html
        },

        saveData(actionType) {
            this.validationErrors = {};
            let params            = { ...this.widget};

            params.tags = params.tags.map(tag => {
                return {
                    tag_id: tag.id
                };
            });

            params._save_action = actionType;
            params.page_types     = _.isNull(this.widget.page_types) || this.widget.page_types === undefined
                                    ? null
                                    : (this.widget.page_types.length > 0
                                       ? JSON.stringify(this.widget.page_types)
                                       : null);

            axios[this.method](`${this.axios_url}`, params)
                .then(response => {
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

        removeError(key) {
            let errorsObject = this.validationErrors;
            let errorExist   = errorsObject[key];
            if (errorExist) {
                delete errorsObject[key];
            }
            //for re-render parent component
            if (Object.keys(errorsObject).length <= 0) {
                this.validationErrors = "";
            }
            this.validationErrors = errorsObject;
        },
    },
}
</script>

<style scoped>
</style>
