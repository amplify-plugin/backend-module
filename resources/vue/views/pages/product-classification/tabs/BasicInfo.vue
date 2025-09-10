<template>
    <div role="tabpanel" class="tab-pane  active" id="tab_basic-info">
        <div v-if="$parent.validationErrors" class="alert alert-danger pb-0">
            <ul class="list-unstyled">
                <li v-for="error in $parent.validationErrors"><i class="la la-info-circle"></i>
                    {{ error[0] }}
                </li>
            </ul>
        </div>
        <div class="row">

            <!-- hidden input -->
            <div class="hidden" element="div">
                <input type="hidden" name="basic-info" value="" class="form-control">
            </div><!-- load the view from type and view_namespace attribute if set -->

            <!-- text input -->
            <div class="form-group col-sm-12 required" element="div">
                <label :class="{'text-danger': $parent.validationErrors.title}">Classification Title</label>

                <i class="la la-flag-checkered pull-right" style="margin-top: 3px;"
                   title="This field is translatable."></i>

                <input @input="$parent.removeError('title')" type="text"
                       v-model="$parent.productClassification.label"
                       class="form-control"
                       :class="{'is-invalid': $parent.validationErrors.title}">

                <small v-if="$parent.validationErrors.title"
                       class="text-danger mt-3">{{ $parent.validationErrors.title[0] }}</small>
            </div>

            <div class="form-group col-sm-12 ">
                <div class="d-flex justify-content-between">
                    <label :class="{'text-danger': $parent.validationErrors.attributes}">Attributes </label>
                    <button class="btn btn-sm btn-link"
                            type="button"
                            data-toggle="modal"
                            data-target="#inline-create-attribute"
                            @click="$parent.$refs.inlineCreate.getModal()">
                        + Add
                    </button>
                </div>
                <multiselect :class="{'is-invalid': $parent.validationErrors.attributes}"
                             @open="$parent.checkUseInProducts('input')"
                             @input="$parent.removeError('attributes')"
                             v-model="$parent.selectedAttribute"
                             :options="$parent.allAttributes"
                             :multiple="true"
                             :close-on-select="false"
                             :clear-on-select="false"
                             :preserve-search="true"
                             :hide-selected="true"
                             placeholder="Pick some"
                             label="local_name"
                             track-by="local_name">
                    <template slot="selection"
                              slot-scope="{ values, search, isOpen }"><span
                        class="multiselect__single"
                        v-if="values.length &amp;&amp; !isOpen">{{
                            values.length
                        }} options selected</span>
                    </template>
                </multiselect>

                <small v-if="$parent.validationErrors.attributes"
                       class="text-danger mt-3">{{
                        $parent.validationErrors.attributes[0]
                    }}</small>
            </div>

            <div class="form-group col-sm-12">
                <!-- v-if="_.first(JSON.parse(attribute.values))['has_range'] !== '0'"-->
                <div class="card mb-3" v-for="(attribute, index) in $parent.selectedAttribute"
                     :class="{'red-border': attribute.errors}">
                    <div class="card-body">
                        <div v-if="attribute.errors && attribute.errors.message"
                             class="alert alert-danger">{{ attribute.errors.message }}
                        </div>
                        <label class="mb-3 d-flex justify-content-between">
                            <span>
                                <strong> {{ attribute.local_name }} </strong>
                                <span> ({{ attribute.type }}) </span>
                            </span>
                            <span title="Unit" class="btn btn-sm btn-link">
                                {{ attribute.unit }}
                            </span>
                        </label>
                        <span class="mb-3">
                            <input v-model="attribute.is_multiple" type="checkbox"
                                    :id="`is_multiple-${attribute.id}`"
                                    class="mr-2 cursor-pointer">
                            <label class="cursor-pointer"
                                    :for="`is_multiple-${attribute.id}`">Allow Multiple</label>
                        </span>
                        <span class="mb-3">
                            <input v-model="attribute.is_required" type="checkbox"
                                    :id="`is_required-${attribute.id}`"
                                    class="mr-2 cursor-pointer">
                            <label class="cursor-pointer"
                                    :for="`is_required-${attribute.id}`">Is Required</label>
                        </span>
                        <div v-if="!$parent.checkHasRange(attribute.type)"
                             class="d-flex">
                            <div class="form-group col-sm-6 pl-0">
                                <label>Min</label>
                                <input type="number" @input="$parent.validateMinMax(index)"
                                       class="form-control"
                                       v-model="attribute.min">
                            </div>
                            <div class="form-group col-sm-6 pr-0">
                                <label>Max</label>
                                <input type="number" @input="$parent.validateMinMax(index)"
                                       class="form-control"
                                       v-model="attribute.max">
                            </div>
                        </div>

                        <div v-if="attribute.type === 'boolean'"
                             class="d-flex">
                            <div class="form-group col-sm-6 pl-0">
                                <label>Affirmative </label>
                                <input type="text" @input="$parent.validateMinMax(index)"
                                       class="form-control"
                                       v-model="attribute.boolean_true">
                            </div>
                            <div class="form-group col-sm-6 pr-0">
                                <label>Negative</label>
                                <input type="text" @input="$parent.validateMinMax(index)"
                                       class="form-control"
                                       v-model="attribute.boolean_false">
                            </div>
                        </div>

                        <div v-if="attribute.type === 'enum'">
                            <div class="form-group col-sm-12 p-0">
                                <label>Options </label>
                                <multiselect :taggable="true"
                                             @tag="$parent.addTag($event,index)"
                                             @input="$parent.validateMinMax(index)"
                                             :class="{'is-invalid': $parent.validationErrors.attributes}"
                                             v-model="attribute.enums"
                                             :options="$parent.enumOptions"
                                             :multiple="true"
                                             :close-on-select="false"
                                             :clear-on-select="false"
                                             :preserve-search="true"
                                             :hide-selected="true"
                                             placeholder="Pick some"
                                             label="name"
                                             track-by="name">
                                </multiselect>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div class="form-group col-sm-12">
                <div class="d-flex justify-content-between">
                    <label>Options</label>
                    <button class="btn btn-sm btn-link"
                            type="button"
                            data-toggle="modal"
                            data-target="#inline-create-option"
                            @click="$parent.$refs.optionInlineCreate.getModal()">
                        + Add
                    </button>
                </div>
                <multiselect
                    :class="{'is-invalid': $parent.validationErrors.selected_product_options}"
                    v-model="$parent.selected_product_options"
                    :options="$parent.allProductOptions"
                    :multiple="true"
                    :close-on-select="false"
                    :clear-on-select="false"
                    :preserve-search="true"
                    :hide-selected="true"
                    placeholder="Pick some"
                    label="local_name"
                    track-by="local_name">
                    <template slot="selection"
                              slot-scope="{ values, search, isOpen }"><span
                        class="multiselect__single"
                        v-if="values.length &amp;&amp; !isOpen">{{
                            values.length
                        }} options selected</span>
                    </template>
                </multiselect>
            </div>

            <div class="form-group col-sm-12">
                <label>Product Detail Page</label>
                <select class="form-control" v-model="$parent.productClassification.single_product_page_id">
                    <option value="">-</option>
                    <option v-for="(page, index) in $parent.allSingleProductPages.single_product" :key="index" :value="page.id">
                        {{ page.name }}
                    </option>
                </select>
            </div>
            <!-- load the view from type and view_namespace attribute if set -->

        </div>
    </div>
</template>

<script>
import Treeselect  from "@riophae/vue-treeselect";

export default {
    name: "BasicInfo",
    components: {Treeselect},
}
</script>

<style scoped>

</style>
