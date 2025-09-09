<style scoped>
.error-color {
    color: red;
}

.required-custom {
    color: #ff0000;
}
</style>
<template>
    <div>
        <!-- text input -->
        <div class="form-group">
            <label :class="{'error-color': validationErrors.name}">
                Name
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <input @input="removeError('name');" type="text" name="name"
                   v-model="$parent.footer.name"
                   placeholder="Enter footer name"
                   class="form-control" :class="{'is-invalid': $parent.validationErrors.name}"
                   :disabled="$parent.method === 'get'"
            >
        </div>

        <div class="form-group">
            <label>Template</label>
            <select name="template_id" class="form-control" v-model="$parent.footer.template_id">
                <option :value="t.id" v-for="(t, i) in $parent.templates"
                        :key="i"
                        :selected="t.id === $parent.footer.template_id">
                    {{ t.label }}
                </option>
            </select>
        </div>

        <div class="col-sm-12 mb-2 pl-0">
            <div class="form-check form-check-inline">
                <label class="form-check-label" :class="{'error-color': validationErrors.is_enabled}">
                    <input name="description" type="checkbox"
                           v-model="$parent.footer.is_enabled"
                           class="form-check-input"
                           :class="{'is-invalid': validationErrors.is_enabled}"
                           :disabled="$parent.method === 'get'"
                    >
                    Enabled
                </label>
                <small v-if="validationErrors.is_enabled" class="text-danger mt-3">{{
                        validationErrors.is_enabled[0]
                    }}</small>
            </div>
        </div>

        <!-- footer content code -->
        <div class="form-group">
            <label :class="{'error-color': validationErrors.content}">
                Contents
            </label>
            <p class="font-sm">You can use <b>__year__</b> to show current year</p>
            <prism-editor
                class="my-editor language-xml-doc"
                v-model="$parent.footer.content"
                :highlight="highlighter"
                :line-numbers="true"
                :readonly="$parent.method === 'get'"
            ></prism-editor>
        </div>
    </div>
</template>

<script>

import {PrismEditor} from "vue-prism-editor";
import "vue-prism-editor/dist/prismeditor.min.css"; // import the styles somewhere

// import highlighting library (you can use any library you want to return HTML string)
import {highlight, languages} from "prismjs/components/prism-core";
import "prismjs/components/prism-clike";
import "prismjs/components/prism-javascript";
import "prismjs/themes/prism-okaidia.min.css"; // import syntax highlighting styles

export default {
    name: "FormFields",
    props: [],
    components: {PrismEditor},
    data() {
        return {
            validationErrors: "",
        }
    },

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
}
</script>

<style lang="scss">
// required class
.my-editor {
    background: #2d2d2d;
    color: #ccc !important;
    font-family: Consolas, Menlo, Courier, monospace;
    font-size: 14px;
    line-height: 1.5;
    padding: 5px;
    border-radius: 4px !important;
    min-height: 350px !important;
}

// optional
.prism-editor__textarea:focus {
    outline: none;
}

pre.prism-editor__editor{
    color: #ffc107!important;
}
</style>
