<template>
    <div role="tabpanel" class="tab-pane active"
         id="tab_seo">

        <div class="row">
            <!-- load the view from type and view_namespace attribute if set -->

            <!-- hidden input -->
            <div class="hidden">
                <input type="hidden" name="seo" value="" class="form-control">
            </div>

            <div class="form-group col-sm-12">
                <label :class="{'text-danger': $parent.validationErrors.product_slug}">Product Slug <span class="text-danger font-weight-bold">*</span></label>
                <input type="text" name="product_slug" v-model="$parent.productData.product_slug" min="0" placeholder="Enter product slug"
                       @input="removeError('product_slug')"
                       class="form-control"
                       @keypress.enter.prevent
                       :class="{'is-invalid': $parent.validationErrors.product_slug}">
                <small v-if="$parent.validationErrors.product_slug"
                       class="text-danger mt-3">{{ $parent.validationErrors.product_slug[0] }}</small>
            </div>

            <div class="form-group col-sm-12">
                <div class="d-flex justify-content-between">
                    <label :class="{'text-danger': $parent.validationErrors.meta_description}">
                        Meta Description
                        <i class="las la-info-circle pull-right" style="margin-top: 3px;"
                           title="Minimum meta description length is 50 characters and Maximum meta description length is 160 characters"></i>
                    </label>
                </div>
                <textarea v-model="$parent.productData.meta_description"
                          @input="removeError('meta_description')"
                          placeholder="Enter meta description"
                          class="form-control"
                          :class="{'is-invalid': $parent.validationErrors.meta_description}"
                          rows="4"> </textarea>
                <small v-if="$parent.validationErrors.meta_description"
                       class="text-danger mt-3">{{ $parent.validationErrors.meta_description[0] }}</small>
            </div>

            <div class="form-group col-sm-12">
                <div class="d-flex justify-content-between">
                    <label :class="{'text-danger': $parent.validationErrors.meta_keywords}">
                        Meta Keywords
                        <i class="las la-info-circle pull-right" style="margin-top: 3px;"
                           title="Minimum meta keywords length is 100 characters and Maximum meta keywords length is 255 characters"></i>
                    </label>
                </div>
                <textarea v-model="$parent.productData.meta_keywords"
                          @input="removeError('meta_keywords')"
                          placeholder="Enter meta keywords"
                          class="form-control"
                          :class="{'is-invalid': $parent.validationErrors.meta_keywords}"
                          rows="4"> </textarea>
                <small v-if="$parent.validationErrors.meta_keywords"
                       class="text-danger mt-3">{{ $parent.validationErrors.meta_keywords[0] }}</small>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "SEO",
    data() {
        return {}
    },
    mounted() {
       if (_.isNull(this.$parent.productData.product_slug)) {
           this.$parent.convertNameToSlug(this.$parent.productData.local_product_name);
       }
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
    }
}
</script>

<style scoped>
.card-header {
    background: aliceblue;
}
</style>
