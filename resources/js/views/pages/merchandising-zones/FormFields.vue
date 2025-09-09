<template>
    <div>
        <div class="form-group col-sm-12">
            <div v-if="$parent.validationErrors.length > 0" class="alert alert-danger pb-0">
                <ul class="list-unstyled">
                    <div v-for="single_errors in $parent.validationErrors">
                        <li v-for="error in single_errors"><i class="la la-info-circle"></i>
                            {{ getErr(error) }}
                        </li>
                    </div>
                </ul>
            </div>
        </div>
        <!-- text input -->
        <div class="form-group col-sm-12">
            <label :class="{'error-color': $parent.validationErrors.name}">
                Name
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <i title="This field is translatable."
               class="la la-flag-checkered pull-right"
               style="margin-top: 3px;"></i>
            <input @input="removeError('name'); $parent.convertNameToSlug($parent.merchandising_zone.name)" type="text" name="page_name"
                   v-model="$parent.merchandising_zone.name"
                   placeholder="Enter page name"
                   class="form-control" :class="{'is-invalid': $parent.validationErrors.name}"
                   :disabled="$parent.method === 'get'"
            >
            <small v-if="$parent.validationErrors.name" class="text-danger mt-3">{{
                    $parent.validationErrors.name[0]
                }}</small>
        </div>

        <div class="form-group col-sm-12">
            <label :class="{'error-color': $parent.validationErrors.easyask_key}">
                EasyAsk Key
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <input name="description" type="text"
                   v-model="$parent.merchandising_zone.easyask_key"
                   class="form-control"
                   :class="{'is-invalid': $parent.validationErrors.easyask_key}"
                   :disabled="$parent.method === 'get'"
            >
            <small v-if="$parent.validationErrors.easyask_key" class="text-danger mt-3">{{
                    $parent.validationErrors.easyask_key[0]
                }}</small>
        </div>

        <div class="form-group col-sm-12">
            <label :class="{'error-color': $parent.validationErrors.description}">
                Description
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <textarea name="description" id="description" cols="30" rows="10" class="form-control" v-model="$parent.merchandising_zone.description"></textarea>
            <small v-if="$parent.validationErrors.description" class="text-danger mt-3">{{
                    $parent.validationErrors.description[0]
                }}</small>
        </div>

    </div>
</template>

<script>

import _ from "lodash";
import { PrismEditor } from "vue-prism-editor";
import "vue-prism-editor/dist/prismeditor.min.css"; // import the styles somewhere


export default {
    name: "FormFields",
    props: [],
    data() {
        return {}
    },
    mounted() {
    },
    methods: {
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
    },
    watch: {

    }

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
    color: #ff2e2e;
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

pre.prism-editor__editor{
    color: #ccc;
}

// not required:
.height-300 {
    height: 500px;
}
.prism-editor__editor{
    min-height: 500px;
}
</style>
