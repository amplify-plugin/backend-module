<template>
    <div role="tabpanel" class="tab-pane active"
         id="tab_page-configuration">
        <div class="row">
            <div class="form-group col-sm-12 required">
                <label :class="{'text-danger': $parent.validationErrors.template_id}">Select Template<span
                    class="text-danger">*</span></label>
                <treeselect
                    @select=" $parent.removeError('template_id')"
                    :class="{'is-invalid':  $parent.validationErrors.template_id}"
                    :multiple="false"
                    placeholder="Pick a template"
                    :options=" $parent.allTemplates"
                    v-model=" $parent.site.template_id"/>
                <small v-if=" $parent.validationErrors.template_id"
                       class="text-danger mt-3">{{ $parent.validationErrors.template_id[0] }}</small>
            </div>

            <div class="form-group col-sm-12 required">
                <label :class="{'text-danger': $parent.validationErrors.front_page_id}">Select Home Page<span
                    class="text-danger">*</span></label>
                <treeselect
                    :disabled="!$parent.isTemplateSelected"
                    @select="$parent.removeError('front_page_id')"
                    :class="{'is-invalid':  $parent.validationErrors.front_page_id}"
                    :multiple="false"
                    placeholder="Pick a home page"
                    :options=" $parent.allHomePages"
                    v-model=" $parent.site.front_page_id"/>
                <small v-if=" $parent.validationErrors.front_page_id"
                       class="text-danger mt-3">{{ $parent.validationErrors.front_page_id[0] }}</small>
            </div>

            <div class="form-group col-sm-12 required">
                <label :class="{'text-danger': $parent.validationErrors.shop_page_id}">Select Category List Page<span
                    class="text-danger">*</span></label>
                <treeselect
                    :disabled="!$parent.isTemplateSelected"
                    @select=" $parent.removeError('shop_page_id')"
                    :class="{'is-invalid':  $parent.validationErrors.shop_page_id}"
                    :multiple="false"
                    placeholder="Pick a category list page"
                    :options=" $parent.allShopPages"
                    v-model=" $parent.site.shop_page_id"/>
                <small v-if=" $parent.validationErrors.shop_page_id"
                       class="text-danger mt-3">{{ $parent.validationErrors.shop_page_id[0] }}</small>
            </div>

            <div class="form-group col-sm-12 required">
                <label :class="{'text-danger': $parent.validationErrors.product_page_id}">Select Default Template For Products<span
                    class="text-danger">*</span></label>
                <treeselect
                    :disabled="!$parent.isTemplateSelected"
                    @select=" $parent.removeError('product_page_id')"
                    :class="{'is-invalid':  $parent.validationErrors.product_page_id}"
                    :multiple="false"
                    placeholder="Pick a default template for product"
                    :options=" $parent.allProductPages"
                    v-model=" $parent.site.product_page_id"/>
                <small v-if=" $parent.validationErrors.product_page_id"
                       class="text-danger mt-3">{{ $parent.validationErrors.product_page_id[0] }}</small>
            </div>
        </div>
    </div>
</template>

<script>
import Treeselect from "@riophae/vue-treeselect";

export default {
    name: "PageConfiguration",
    components: {Treeselect},
}
</script>

<style scoped>

</style>
