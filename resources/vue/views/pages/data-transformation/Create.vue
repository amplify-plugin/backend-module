<template>
    <div id="dataTransformationCreate" class="animated fadeIn">

        <div class="row">
            <div class="col-md-12 bold-labels">
                <!-- Default box -->

                <form method="post" :action="backUrl">
                    <!--<div v-if="translation_enabled" class="mb-2 text-right">
                        &lt;!&ndash; Single button &ndash;&gt;
                        <AvailableLocales
                            :availableLocales="availableLocales"
                            :queryString="query_string"
                            :current_lang="current_lang"
                            :url="url"
                        ></AvailableLocales>
                    </div>-->

                    <div class="card">
                        <div class="card-body row">
                            <div class="form-group col-sm-12"
                                 :class="{'text-danger': validationErrors.transformation_name}">

                                <div class="d-flex justify-content-between">
                                    <label>Transformation Name <span class="text-danger">*</span></label>
                                </div>
                                <input @input="removeError('transformation_name')" type="text"
                                       name="transformation_name"
                                       v-model="dataTransformation.transformation_name"
                                       class="form-control"
                                       :class="{'is-invalid': validationErrors.transformation_name}">
                                <small v-if="validationErrors.transformation_name"
                                       class="text-danger mt-3">{{ validationErrors.transformation_name[0] }}</small>
                            </div>

                            <div class="form-group col-sm-12"
                                 :class="{'text-danger': validationErrors.description}">

                                <div class="d-flex justify-content-between">
                                    <label>Description</label>
                                </div>
                                <textarea v-model="dataTransformation.description"
                                          @input="removeError('locale');"
                                          class="form-control"
                                          :class="{'is-invalid': validationErrors.description}"
                                          rows="4">
                                </textarea>
                                <small v-if="validationErrors.description"
                                       class="text-danger mt-3">{{ validationErrors.description[0] }}</small>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-row">
                                    <div class="form-group col-sm-6"
                                         :class="{'text-danger': validationErrors.applies_to}">

                                        <div class="d-flex justify-content-between">
                                            <label>Applies To <span class="text-danger">*</span></label>
                                        </div>
                                        <multiselect :class="{'is-invalid': validationErrors.applies_to}"
                                                     v-model="dataTransformation.applies_to"
                                                     :options="appliesToOptions"
                                                     :multiple="false"
                                                     :close-on-select="true"
                                                     :clear-on-select="false"
                                                     :preserve-search="true"
                                                     :hide-selected="true"
                                                     placeholder="Pick an option"
                                                     label="name"
                                                     track-by="name">
                                        </multiselect>
                                        <small v-if="validationErrors.applies_to"
                                               class="text-danger mt-3">{{
                                                validationErrors.applies_to[0]
                                            }}</small>
                                    </div>

                                    <div class="form-group col-sm-6"
                                         :class="{'text-danger': validationErrors.in_category}">

                                        <div class="d-flex justify-content-between">
                                            <label>In Category</label>
                                        </div>

                                        <treeselect :class="{'is-invalid': validationErrors.in_category}"
                                                    v-model="dataTransformation.in_category"
                                                    :multiple="true"
                                                    :value-consists-of="'ALL'"
                                                    @select="removeError('in_category')"
                                                    :options="inCategoryOptions"/>
                                        <small v-if="validationErrors.in_category"
                                               class="text-danger mt-3">{{
                                                validationErrors.in_category[0]
                                            }}</small>
                                        <!-- :value-consists-of="'ALL'"  -->
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-sm-6" :class="{'text-danger': validationErrors.run_when}">
                                <div class="d-flex justify-content-between">
                                    <label>Run When</label>
                                </div>
                                <div v-for="option in runWhenOptions" class="float-left mr-4">
                                    <input :id="option.name" type="checkbox" v-model="dataTransformation.run_when"
                                           :value="option.name"/>
                                    <label :for="option.name" class="form-check-label">{{ option.name }}</label>
                                </div>
                                <small v-if="validationErrors.run_when"
                                       class="text-danger mt-3">{{ validationErrors.run_when[0] }}</small>
                            </div>
                            <div class="form-group col-sm-6"
                                 :class="{'text-danger': validationErrors.execution_sequence}">

                                <div class="d-flex justify-content-between">
                                    <label>
                                        Execution Sequence
                                    </label>
                                </div>
                                <input @input="removeError('execution_sequence')" type="number"
                                       name="execution_sequence"
                                       v-model="dataTransformation.execution_sequence"
                                       class="form-control"
                                       :class="{'is-invalid': validationErrors.execution_sequence}">
                                <small v-if="validationErrors.execution_sequence"
                                       class="text-danger mt-3">{{ validationErrors.execution_sequence[0] }}</small>
                            </div>

                            <div class="col-sm-12">
                                <div class="d-flex justify-content-between">
                                    <label class="w-100">
                                        <span class="form-row">
                                            <span class="col-sm-2">
                                                Script
                                            </span>
                                        </span>
                                    </label>
                                </div>

                                <div class="form-row py-2">
                                    <div class="form-group m-0 col-sm-10">
                                        <textarea class="form-control script-editor"
                                                  rows="10"
                                                  v-model="dataTransformation.scripts"
                                                  placeholder="Type your script here..."></textarea>
                                    </div>

                                    <div class="form-group m-0 col-sm-2">
                                        <div class="form-row">
                                            <div class="col my-auto text-center">
                                                <button type="button"
                                                        class="btn btn-sm btn-link text-info text-nowrap mx-1 border-info">
                                                    <i class="las la-tasks"></i> Validate Script
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="saveActions" class="form-group">

                        <input type="hidden" name="save_action" value="save_and_back" v-model="actionType">
                        <div class="btn-group" role="group">

                            <button type="button" class="btn btn-success"
                                    @click="actionType='save_and_back'; saveData()">
                                <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                                <span data-value="save_and_back">Save and back</span>
                            </button>

                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                    class="caret"></span><span class="sr-only">▼</span></button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <a class="dropdown-item" href="javascript:void(0);"
                                       @click="actionType='save_and_edit'; saveData()" data-value="save_and_edit">
                                        Save and edit this item
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);"
                                       @click="actionType='save_and_new'; saveData()" data-value="save_and_new">
                                        Save and new item
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);"
                                       @click="actionType='save_and_preview'; saveData()" data-value="save_and_preview">
                                        Save and preview
                                    </a>
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
import AvailableLocales from "../../components/AvailableLocales";
import Treeselect       from "@riophae/vue-treeselect";
import _                from "lodash";
import '@riophae/vue-treeselect/dist/vue-treeselect.min.css'

export default {
    name      : "DataTransformationCreate",
    components: {AvailableLocales, Treeselect},
    props     : [
        'url', 'axios_url', 'query_string',
        'method', 'data_transformation_data', 'applies_to_options',
        'run_when_options', 'locale', 'available_locales'
    ],

    data() {
        return {
            dataTransformationData: JSON.parse(this.data_transformation_data),
            dataTransformation    : {
                id                 : null,
                locale             : 'en',
                transformation_name: '',
                description        : '',
                applies_to         : '',
                in_category        : [],
                execution_sequence : null,
                run_when           : [],
                scripts            : '',
            },
            backUrl               : '/admin/data-transformation',
            newUrl                : '/admin/data-transformation/create',
            actionType            : 'save_and_back',
            validationErrors      : {},
            appliesToOptions      : JSON.parse(this.applies_to_options),
            inCategoryOptions     : [],
            runWhenOptions        : JSON.parse(this.run_when_options),
            enabled               : true,
            dragging              : false,
        }
    },
    created() {
        if (this.method === 'put') {
            this.initEdit();
        }
    },
    methods: {
        initEdit() {
            this.dataTransformation.id                  = this.dataTransformationData.id;
            this.dataTransformation.transformation_name = this.dataTransformationData.transformation_name;
            this.dataTransformation.description         = this.dataTransformationData.description;
            this.dataTransformation.applies_to          = JSON.parse(this.dataTransformationData.applies_to);
            this.dataTransformation.in_category         = JSON.parse(this.dataTransformationData.in_category);
            this.dataTransformation.execution_sequence  = this.dataTransformationData.execution_sequence;
            this.dataTransformation.run_when            = this.dataTransformationData.run_when;
            this.dataTransformation.scripts             = this.dataTransformationData.scripts;
        },

        saveData() {
            this.validationErrors = {};

            let params = {
                id                 : this.dataTransformation.id ?? '',
                transformation_name: this.dataTransformation.transformation_name,
                description        : this.dataTransformation.description,
                applies_to         : this.dataTransformation.applies_to
                                     ? JSON.stringify(this.dataTransformation.applies_to)
                                     : null,
                in_category        : JSON.stringify(this.dataTransformation.in_category),
                execution_sequence : this.dataTransformation.execution_sequence,
                run_when           : JSON.stringify(this.dataTransformation.run_when),
                scripts            : this.dataTransformation.scripts,
            };

            axios[this.method](`${this.axios_url}?locale=${this.locale}`, params)
                .then(response => {
                    new Noty({
                        type: "success",
                        text: 'Saved successfully',
                    }).show();
                    this.validationErrors = "";

                    window.location = this.actionType === 'save_and_back' ? this.backUrl : this.newUrl;
                })
                .catch((err) => {
                    this.validationErrors = err.response.data.errors;
                     if(!err.response.status)
                        new Noty({
                            type: "error",
                            text: err.response.data.message,
                        }).show();
                    });
        },

        removeError(key) {
            let errorsObject = this.validationErrors;
            let errorExist   = errorsObject[key];
            if (errorExist) {
                delete errorsObject[key];
            }
            if (Object.keys(errorsObject).length <= 0) {
                this.validationErrors = "";
            }
            this.validationErrors = errorsObject;
        },

        fetchCategory() {
            axios.post('/admin/product/fetch/category-tree').then(response => {
                this.inCategoryOptions = response.data;
            }).catch(err => {
                console.error(err)
            })
        },
    },
    mounted() {
        this.fetchCategory();
    },
    watch   : {},
    computed: {
        _() {
            return _;
        },
    },
}
</script>

<style>
#dataTransformationCreate .multiselect__placeholder {
    margin: 0 !important;
}

.ghost {
    opacity: 0.5;
    background: #c8ebfb;
}

.script-editor, .script-editor:focus {
    background-color: #0c1021;
    color: #fff;
    font-family: Monospace, monospace;
    border-color: transparent;
    box-shadow: none;
}
</style>
