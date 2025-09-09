<template>
    <div>
        <div class="form-group col-sm-12">
            <div v-if="validationErrors" class="alert alert-danger pb-0">
                <ul class="list-unstyled">
                    <div v-for="(single_errors, index) in validationErrors" :key="index">
                        <li v-for="(error, index) in single_errors" :key="index"><i class="la la-info-circle"></i>
                            {{ getErr(error) }}
                        </li>
                    </div>
                </ul>
            </div>
        </div>

        <!-- text input -->
        <div class="form-group col-sm-12 required">
            <label :class="{ 'error-color': $parent.validationErrors.name }">
                Name
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <i title="This field is translatable." class="la la-flag-checkered pull-right" style="margin-top: 3px;"></i>
            <input @input="removeError('name');" type="text" name="name" v-model="$parent.navigation.name"
                placeholder="Enter navigation name" class="form-control"
                :class="{ 'is-invalid': $parent.validationErrors.name }" :disabled="$parent.method === 'get'">
            <small v-if="$parent.validationErrors.name" class="text-danger mt-3">{{ $parent.validationErrors.name[0] }}</small>
        </div>

        <div class="form-group col-12">
            <label :class="{ 'error-color': $parent.validationErrors.layout }">
                Please Select Menu Layout
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <multiselect v-model="$parent.selectedLayout" :options="$parent.allNavLayouts" :multiple="false" @input="removeError('layout');"
                :preserve-search="true" :allow-empty="false" placeholder="Please select a layout" label="name" track-by="unique_identifier"
                :class="{ 'is-invalid': $parent.validationErrors.layout }" :disabled="$parent.method === 'get'">
                <template slot="selection" slot-scope="{ values, isOpen }"><span class="multiselect__single"
                        v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span>
                </template>
            </multiselect>
            <small v-if="$parent.validationErrors.layout" class="text-danger mt-3">{{ $parent.validationErrors.layout[0] }}</small>
        </div>

        <div class="form-group col-12">
            <label  :class="{ 'error-color': $parent.validationErrors.menu_group_id }">
                Please Select Primary Menu
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <multiselect v-model="$parent.selectedMenuGroup" :options="$parent.menuList" :multiple="false" @input="removeError('menu_group_id');"
                :preserve-search="true" :allow-empty="false" placeholder="Please select a menu group" label="name" track-by="id"
                :class="{ 'is-invalid': $parent.validationErrors.menu_group_id }" :disabled="$parent.method === 'get'">
                <template slot="selection" slot-scope="{ values, isOpen }"><span class="multiselect__single"
                        v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span>
                </template>
            </multiselect>
            <small v-if="$parent.validationErrors.menu_group_id" class="text-danger mt-3">{{ $parent.validationErrors.menu_group_id[0] }}</small>
        </div>

        <div class="form-group col-12">
            <label  :class="{ 'error-color': $parent.validationErrors.user_account_menu }">
                Please Select Account Menu
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <multiselect v-model="$parent.selectedUserAccountMenu" :options="$parent.menuList" :multiple="false" @input="removeError('user_account_menu');"
                         :preserve-search="true" :allow-empty="false" placeholder="Please select a user account menu" label="name" track-by="id"
                         :class="{ 'is-invalid': $parent.validationErrors.user_account_menu }" :disabled="$parent.method === 'get'">
                <template slot="selection" slot-scope="{ values, isOpen }"><span class="multiselect__single"
                                                                                 v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span>
                </template>
            </multiselect>
            <small v-if="$parent.validationErrors.user_account_menu" class="text-danger mt-3">{{ $parent.validationErrors.user_account_menu[0] }}</small>
        </div>

        <div class="form-group col-12">
            <label  :class="{ 'error-color': $parent.validationErrors.mobile_menu_id }">
                Please Select Mobile Menu
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <multiselect v-model="$parent.selectedMobileMenu" :options="$parent.menuList" :multiple="false" @input="removeError('mobile_menu_id');"
                :preserve-search="true" :allow-empty="false" placeholder="Please select a Mobile Menu" label="name" track-by="id"
                :class="{ 'is-invalid': $parent.validationErrors.mobile_menu_id }" :disabled="$parent.method === 'get'">
                <template slot="selection" slot-scope="{ values, isOpen }"><span class="multiselect__single"
                        v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span>
                </template>
            </multiselect>
            <small v-if="$parent.validationErrors.mobile_menu_id" class="text-danger mt-3">{{ $parent.validationErrors.mobile_menu_id[0] }}</small>
        </div>
        <div class="col-sm-12 mb-2">
            <div class="form-check form-check-inline">
                <label :class="{ 'error-color': validationErrors.top_bar }" class="form-check-label">
                    <input name="description" type="checkbox" v-model="$parent.navigation.top_bar"
                        class="form-check-input ml-2" :class="{ 'is-invalid': validationErrors.top_bar }"
                        :disabled="$parent.method === 'get'">
                    Header Topbar
                </label>
                <small v-if="validationErrors.top_bar" class="text-danger mt-3">{{ validationErrors.top_bar[0] }}</small>
            </div>

            <div class="form-check form-check-inline">
                <label class="form-check-label" :class="{ 'error-color': validationErrors.is_enabled }">
                    <input name="description" type="checkbox" v-model="$parent.navigation.is_enabled"
                        class="form-check-input" :class="{ 'is-invalid': validationErrors.is_enabled }"
                        :disabled="$parent.method === 'get'">
                    Is Enabled
                </label>
                <small v-if="validationErrors.is_enabled" class="text-danger mt-3">{{ validationErrors.is_enabled[0] }}</small>
            </div>
        </div>

        <div v-if="$parent.selectedLayout.hasOwnProperty('menu')">
            <h4>Navigation Contents</h4>

            <div v-for="(layout, index) in $parent.selectedLayout.menu" :key="index">
                <div class="form-group col-sm-12 required" v-if="layout.type === 'xml'">
                    <label :class="{ 'error-color': validationErrors.content }">{{ layout.title }}</label>
                    <prism-editor class="my-editor height-300 language-xml-doc"
                        v-model="$parent.navigation.content[index]" :highlight="highlighter" :line-numbers="true"
                        :readonly="$parent.method === 'get'"></prism-editor>
                    <small v-if="validationErrors.content" class="text-danger mt-3">{{ validationErrors.content[0] }}</small>
                </div>

                <div class="ml-3 form-check" v-if="layout.type === 'boolean'">
                    <label :class="{ 'error-color': validationErrors.content }">
                        <input type="checkbox" v-model="$parent.navigation.content[index]" class="form-check-input"
                            :disabled="$parent.method === 'get'">
                        {{ layout.title }}
                    </label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { PrismEditor } from "vue-prism-editor";
import "vue-prism-editor/dist/prismeditor.min.css"; // import the styles somewhere
import Multiselect from "vue-multiselect";

// import highlighting library (you can use any library you want just return html string)
import { highlight, languages } from "prismjs/components/prism-core";
import "prismjs/components/prism-clike";
import "prismjs/components/prism-javascript";
import "prismjs/themes/prism-okaidia.min.css"; // import syntax highlighting styles

export default {
    name: "FormFields",
    props: [],
    data() {
        return {
            validationErrors: "",
        }
    },
    mounted() {

    },
    components: { Multiselect, PrismEditor },
    methods: {
        removeError(key) {
            let errorsObject = this.$parent.validationErrors;
            let errorExist = errorsObject[key];
            if (errorExist) {
                delete errorsObject[key];
            }
            //for re-render parent component
            if (Object.keys(errorsObject).length <= 0) {
                this.$parent.validationErrors = "";
            }
            this.$parent.validationErrors = errorsObject;
        },

        highlighter(code) {
            return highlight(code, languages.js); //returns html
        },
    },
    watch: {}

}
</script>

<style scoped lang="scss">
.error-color {
    color: red;
}

.separator {
    display: flex;
    align-items: center;
    text-align: center;
    margin-bottom: 5px;
}

.separator::before,
.separator::after {
    content: '';
    flex: 1;
    border-bottom: 1px solid #00000026;
}

.separator:not(:empty)::before {
    margin-right: .25em;
}

.separator:not(:empty)::after {
    margin-left: .25em;
}

.border-custom {
    border: 1px solid rgba(0, 40, 100, .12);
}

.required-custom {
    color: #ff0000;
}

// required class
.my-editor {
    background: #2d2d2d;
    color: #ccc;
    font-family: Fira code, Fira Mono, Consolas, Menlo, Courier, monospace;
    font-size: 14px;
    line-height: 1.5;
    padding: 5px;
}

// optional
.prism-editor__textarea:focus {
    outline: none;
}

pre.prism-editor__editor {
    color: #ccc;
}

// not required:
.height-300 {
    height: 500px;
}

.prism-editor__editor {
    min-height: 490px;
}
</style>
