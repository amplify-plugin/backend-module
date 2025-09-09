<template>
    <div>
        <div class="form-group col-sm-12">
            <div v-if="validationErrors" class="alert alert-danger pb-0">
                <ul class="list-unstyled">
                    <div v-for="single_errors in validationErrors">
                        <li v-for="error in single_errors"><i class="la la-info-circle"></i>
                            {{ getErr(error) }}
                        </li>
                    </div>
                </ul>
            </div>
        </div>
        <!-- text input -->
        <div class="form-group col-sm-12 required">
            <label :class="{'error-color': validationErrors.name}">
                Name
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <i title="This field is translatable."
               class="la la-flag-checkered pull-right"
               style="margin-top: 3px;"></i>
            <input @input="removeError('name');" type="text"
                   name="top_bar_name"
                   v-model="$parent.top_bar.name"
                   placeholder="Enter topbar name"
                   class="form-control" :class="{'is-invalid': $parent.validationErrors.name}"
                   :disabled="$parent.method === 'get'"
            >
            <small v-if="validationErrors.name" class="text-danger mt-3">{{
                    validationErrors.name[0]
                }}</small>
        </div>

        <div class="form-group col-sm-12 required">
            <label :class="{'error-color': validationErrors.content}">
                Topbar Content
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <prism-editor
                class="my-editor height-300 language-xml-doc"
                v-model="$parent.top_bar.content"
                :highlight="highlighter"
                :line-numbers="true"
                :readonly="$parent.method === 'get'"
            ></prism-editor>
            <small v-if="validationErrors.content" class="text-danger mt-3">{{
                    validationErrors.content[0]
                }}</small>
        </div>
        <div class="form-group col-sm-12" :class="{'text-danger': validationErrors.is_enabled}">
            <div class="d-flex justify-content-between">
                <label>Is Enabled</label>
            </div>
            <div class="float-left">
                <input id="is_enabled" type="checkbox" v-model="$parent.top_bar.is_enabled"
                       :value="$parent.top_bar.is_enabled" :disabled="$parent.method === 'get'"/>
                <label for="is_enabled" class="form-check-label ml-1">Enable Topbar</label>
            </div>
            <small v-if="validationErrors.is_enabled"
                   class="text-danger mt-3">{{ validationErrors.is_enabled[0] }}</small>
        </div>

    </div>
</template>

<script>

import {PrismEditor}          from "vue-prism-editor";
import "vue-prism-editor/dist/prismeditor.min.css"; // import the styles somewhere
// import highlighting library (you can use any library you want just return html string)
import {highlight, languages} from "prismjs/components/prism-core";
import "prismjs/components/prism-clike";
import "prismjs/components/prism-javascript";
import "prismjs/themes/prism-okaidia.min.css"; // import syntax highlighting styles

export default {
    name : "FormFields",
    props: [],
    data() {
        return {
            validationErrors: "",
        }
    },
    mounted() {

    },
    components: {PrismEditor},
    methods   : {
        removeError(key) {
            let errorsObject = this.$parent.validationErrors;
            let errorExist   = errorsObject[key];
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
    watch     : {}

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
