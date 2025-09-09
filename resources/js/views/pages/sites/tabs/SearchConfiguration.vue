<template>
    <div role="tabpanel" class="tab-pane active"
         id="tab_search-configuration">
        <div class="row">
            <div class="form-group col-sm-12">
                <label :class="{'text-danger': $parent.validationErrors.product_search_by_id_prefix}">Easyask Product Search By Id Prefix</label>

                <input @input="$parent.removeError('product_search_by_id_prefix')" type="text"
                       v-model="$parent.search_configuration.product_search_by_id_prefix"
                       class="form-control"
                       :class="{'is-invalid': $parent.validationErrors.product_search_by_id_prefix}">

                <small v-if="$parent.validationErrors.product_search_by_id_prefix"
                       class="text-danger mt-3">{{ $parent.validationErrors.product_search_by_id_prefix[0] }}</small>
            </div>

            <div class="form-group col-sm-12">
                <label :class="{'text-danger': $parent.validationErrors.easyask_host}">EasyAsk Host</label>

                <input @input="$parent.removeError('easyask_host')" type="text"
                       v-model="$parent.search_configuration.easyask_host"
                       class="form-control"
                       :class="{'is-invalid': $parent.validationErrors.easyask_host}">

                <small v-if="$parent.validationErrors.easyask_host"
                       class="text-danger mt-3">{{ $parent.validationErrors.easyask_host[0] }}</small>
            </div>

            <div class="form-group col-sm-12">
                <label :class="{'text-danger': $parent.validationErrors.easyask_port}">EasyAsk easyask_port</label>

                <input @input="$parent.removeError('easyask_port')" type="text"
                       v-model="$parent.search_configuration.easyask_port"
                       class="form-control"
                       :class="{'is-invalid': $parent.validationErrors.easyask_port}">

                <small v-if="$parent.validationErrors.easyask_port"
                       class="text-danger mt-3">{{ $parent.validationErrors.easyask_port[0] }}</small>
            </div>

            <div class="form-group col-sm-12">
                <label :class="{'text-danger': $parent.validationErrors.easyask_dictionary}">EasyAsk Dictionary</label>

                <input @input="$parent.removeError('easyask_dictionary')" type="text"
                       v-model="$parent.search_configuration.easyask_dictionary"
                       class="form-control"
                       :class="{'is-invalid': $parent.validationErrors.easyask_dictionary}">

                <small v-if="$parent.validationErrors.easyask_dictionary"
                       class="text-danger mt-3">{{ $parent.validationErrors.easyask_dictionary[0] }}</small>
            </div>

            <div class="form-group col-sm-12">
                <label :class="{'text-danger': $parent.validationErrors.sayt_product_id}">Product ID</label>

                <input @input="$parent.removeError('sayt_product_id')" type="text"
                       v-model="$parent.search_configuration.sayt_product_id"
                       class="form-control"
                       :class="{'is-invalid': $parent.validationErrors.sayt_product_id}">

                <small v-if="$parent.validationErrors.sayt_product_id"
                       class="text-danger mt-3">{{ $parent.validationErrors.sayt_product_id[0] }}</small>
            </div>

            <div class="form-group col-sm-12">
                <label :class="{'text-danger': $parent.validationErrors.sayt_product_image}">Product Image</label>

                <input @input="$parent.removeError('sayt_product_image')" type="text"
                       v-model="$parent.search_configuration.sayt_product_image"
                       class="form-control"
                       :class="{'is-invalid': $parent.validationErrors.sayt_product_image}">

                <small v-if="$parent.validationErrors.sayt_product_image"
                       class="text-danger mt-3">{{ $parent.validationErrors.sayt_product_image[0] }}</small>
            </div>

            <div class="form-group col-sm-12">
                <label :class="{'text-danger': $parent.validationErrors.sayt_product_name}">Product Name</label>

                <input @input="$parent.removeError('sayt_product_name')" type="text"
                       v-model="$parent.search_configuration.sayt_product_name"
                       class="form-control"
                       :class="{'is-invalid': $parent.validationErrors.sayt_product_name}">

                <small v-if="$parent.validationErrors.sayt_product_name"
                       class="text-danger mt-3">{{ $parent.validationErrors.sayt_product_name[0] }}</small>
            </div>

            <div class="form-group col-sm-12">
                <label :class="{'text-danger': $parent.validationErrors.sayt_product_price}">Product Price</label>

                <input @input="$parent.removeError('sayt_product_price')" type="text"
                       v-model="$parent.search_configuration.sayt_product_price"
                       class="form-control"
                       :class="{'is-invalid': $parent.validationErrors.sayt_product_price}">

                <small v-if="$parent.validationErrors.sayt_product_price"
                       class="text-danger mt-3">{{ $parent.validationErrors.sayt_product_price[0] }}</small>
            </div>

            <div class="form-group col-sm-12">
                <label :class="{'text-danger': $parent.validationErrors.sayt_product_description}">Product
                    Description</label>

                <input @input="$parent.removeError('sayt_product_description')" type="text"
                       v-model="$parent.search_configuration.sayt_product_description"
                       class="form-control"
                       :class="{'is-invalid': $parent.validationErrors.sayt_product_description}">

                <small v-if="$parent.validationErrors.sayt_product_description"
                       class="text-danger mt-3">{{ $parent.validationErrors.sayt_product_description[0] }}</small>
            </div>

            <div class="form-group col-sm-12">
                <label :class="{'text-danger': $parent.validationErrors.sayt_product_type}">Product Type</label>

                <input @input="$parent.removeError('sayt_product_type')" type="text"
                       v-model="$parent.search_configuration.sayt_product_type"
                       class="form-control"
                       :class="{'is-invalid': $parent.validationErrors.sayt_product_type}">

                <small v-if="$parent.validationErrors.sayt_product_type"
                       class="text-danger mt-3">{{ $parent.validationErrors.sayt_product_type[0] }}</small>
            </div>

            <div class="form-group col-sm-12">
                <label :class="{'text-danger': $parent.validationErrors.sayt_product_sizes}">Product Sizes</label>

                <input @input="$parent.removeError('sayt_product_sizes')" type="text"
                       v-model="$parent.search_configuration.sayt_product_sizes"
                       class="form-control"
                       :class="{'is-invalid': $parent.validationErrors.sayt_product_sizes}">

                <small v-if="$parent.validationErrors.sayt_product_sizes"
                       class="text-danger mt-3">{{ $parent.validationErrors.sayt_product_sizes[0] }}</small>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "SearchConfiguration",
}
</script>

<style scoped>

</style>
