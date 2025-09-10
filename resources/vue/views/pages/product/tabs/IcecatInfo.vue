<template>
    <div role="tabpanel" class="tab-pane active" id="tab_icecat-info">
        <div class="form-row">
            <!-- load the view from type and view_namespace attribute if set -->

            <!-- hidden input -->
            <div class="hidden">
                <input type="hidden" name="icecat-info" value="" class="form-control" />
            </div>

            <div class="form-group col-sm-12" :class="{ 'text-danger': $parent.validationErrors.local_short_description }">
                <label>
                    Product Short Description
                    <span v-if="checkIfProductFieldIsRequired('local_short_description')" class="text-danger font-weight-bold"
                        >*</span
                    >
                </label>
                <i
                    class="la la-flag-checkered pull-right"
                    style="margin-top: 3px"
                    title="This field is translatable."
                ></i>
                <ckeditor
                    v-model="$parent.productData.local_short_description"
                    :class="{ 'is-invalid': $parent.validationErrors.local_short_description }"
                ></ckeditor>
                <small v-if="$parent.validationErrors.local_short_description" class="text-danger mt-3">{{
                    $parent.validationErrors.local_short_description[0]
                }}</small>
            </div>

            <!-- load the view from type and view_namespace attribute if set -->
        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect';
import Treeselect from '@riophae/vue-treeselect';
import '@riophae/vue-treeselect/dist/vue-treeselect.css';
import _ from 'lodash';

export default {
    name: 'IcecatInfo',

    components: { Multiselect, Treeselect },

    data() {
        return {
            productClassifications: [],
            categories: [],
            productTypesArray: ['normal', 'bundle', 'configurable'],
        };
    },

    mounted() {
        if (_.isEmpty(this.$parent.productData.product_type)) {
            this.$parent.productData.product_type = 'normal';
        }

        this.$parent.getDynamicCurrentPreviousTabIds();
    },

    methods: {
        capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        },

        removeError(key) {
            let errorsObject = this.$parent.validationErrors;
            let errorExist = errorsObject[key];
            if (errorExist) {
                delete errorsObject[key];
            }
            //remove classification error in special causes
            if (errorsObject['product_classifications']) {
                delete errorsObject['product_classifications'];
            }
            //for re-render parent component
            if (Object.keys(errorsObject).length <= 0) {
                this.$parent.validationErrors = '';
            }
            this.$parent.validationErrors = errorsObject;
        },

        checkIfProductFieldIsRequired(productFieldName) {
            return !!this.$parent.productMandatoryFields.includes(productFieldName);
        },

        addTag(newTag) {
            const tag = {
                name: newTag,
                unique_slug: newTag.substring(0, 2) + Math.floor(Math.random() * 10000000),
            };
            this.enumOptions.push(tag);
        },
    },
};
</script>
