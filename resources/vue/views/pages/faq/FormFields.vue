<template>
    <div>
        <div class="form-group col-sm-12 required">
            <label :class="{'error-color': $parent.validationErrors.faq_category_id}">
                FAQ Category 
            </label>
            <div>
                <treeselect
                    :multiple="false"
                    :class="{'is-invalid': $parent.validationErrors.faq_category_id}"
                    @input="removeError('faq_category_id');"
                    name="faq_category_id"
                    placeholder="Select a category"
                    :options="$parent.allFaqCategories"
                    v-model="$parent.faq.faq_category_id"/>
            </div>
            <small v-if="$parent.validationErrors.faq_category_id" class="text-danger mt-3">{{
                $parent.validationErrors.faq_category_id[0]
                }}</small>
        </div>

        <div class="form-group col-sm-12 required">
            <label :class="{'error-color': $parent.validationErrors.question}">
                FAQ Question 
            </label>
            <input @input="removeError('question');" type="text"
                   name="question"
                   v-model="$parent.faq.question"
                   placeholder="Enter question"
                   class="form-control" :class="{'is-invalid': $parent.validationErrors.question}"
            >
            <small v-if="$parent.validationErrors.question" class="text-danger mt-3">{{
                $parent.validationErrors.question[0]
                }}</small>
        </div>

        <div class="form-group col-sm-12 required">
            <label :class="{'error-color': $parent.validationErrors.response}">
                FAQ Response Text 
            </label>
            <ckeditor v-model="$parent.faq.response"
                      :class="{'is-invalid': $parent.validationErrors.response}"></ckeditor>
            <small v-if="$parent.validationErrors.response" class="text-danger mt-3">{{
                    $parent.validationErrors.response[0]
                }}</small>
        </div>
    </div>
</template>

<script>
import Treeselect  from "@riophae/vue-treeselect";

import '@riophae/vue-treeselect/dist/vue-treeselect.css';

export default {
    name : "FormFields",
    data() {
        return {
        }
    },
    mounted() {
    },
    components: {Treeselect},
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
    },
    watch     : {}

}
</script>

<style scoped>
.error-color {
    color: red;
}

.required-custom {
    color: #ff0000;
}
.vue-treeselect .vue-treeselect__control,
.multiselect .multiselect__tags {
    height: 38px !important;
    border-radius: 4px !important;
    border: 1px solid rgba(0, 40, 100, .12) !important;
}
.vue-treeselect.is-invalid {
    border: 1px solid red;
    border-radius: 5px;
}
.required-custom {
    color: #ff0000;
}
.cke_contents {
    min-height: 300px !important;
}
.vue-treeselect__multi-value {
    margin-bottom: 8px;
}
</style>
