<template>
    <div role="tabpanel" class="tab-pane active" id="tab_features-and-specifications">
        <div class="form-row">
            <!-- load the view from type and view_namespace attribute if set -->

            <!-- hidden input -->
            <div class="hidden">
                <input type="hidden" name="features-and-specifications" value="" class="form-control" />
            </div>

            <div class="form-group col-sm-12" :class="{ 'text-danger': $parent.validationErrors.features }">
                <label>
                    Product Features
                    <span v-if="checkIfProductFieldIsRequired('features')" class="text-danger font-weight-bold">*</span>
                </label>
                <div
                    class="card bg-secondary shadow shadow-sm mb-2"
                    v-for="(feature, index) in $parent.productData.features"
                    :key="`feature-group-${index}`"
                >
                    <div class="card-header">
                        <div class="row align-items-center">
                            <label :for="`feature-group-name-${index}`" class="col-sm-2 col-form-label"
                                >Group Name</label
                            >
                            <div class="col-sm-9">
                                <input
                                    type="text"
                                    class="form-control"
                                    :id="`feature-group-name-${index}`"
                                    v-model="feature.group_name"
                                />
                            </div>
                            <div class="col-sm-1 text-right">
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-danger"
                                    title="Remove group"
                                    @click="removeGroup($parent.productData.features, index)"
                                >
                                    <i class="la la-trash font-weight-bold"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-1">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr class="text-center">
                                    <th>Name</th>
                                    <th>Value</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(attribute, attrIndex) in feature.group_items || []"
                                    :key="`feature-${index}-attr-${attrIndex}`"
                                >
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control form-control-sm"
                                            :id="`feature-group-${index}-attr-${attrIndex}-name`"
                                            v-model="attribute.name"
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control form-control-sm"
                                            :id="`feature-group-${index}-attr-${attrIndex}-value`"
                                            v-model="attribute.value"
                                        />
                                    </td>
                                    <th width="40">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger"
                                            title="Remove"
                                            @click="removeAttr(feature.group_items, attrIndex)"
                                        >
                                            <i class="la la-minus font-weight-bold" style="font-size: 150%"></i>
                                        </button>
                                    </th>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <button
                                            type="button"
                                            class="btn btn-warning btn-sm btn-block"
                                            @click="addNewAttr(feature?.group_items ?? [])"
                                        >
                                            Add Feature Option
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <button class="btn btn-primary btn-block btn-sm" @click="addNewGroup($parent.productData.features)">
                    Add Feature Group
                </button>
                <small v-if="$parent.validationErrors.features" class="text-danger mt-3">{{
                    $parent.validationErrors.features[0]
                }}</small>
            </div>

            <div class="form-group col-sm-12" :class="{ 'text-danger': $parent.validationErrors.specifications }">
                <label>
                    Product Specifications
                    <span v-if="checkIfProductFieldIsRequired('specifications')" class="text-danger font-weight-bold"
                        >*</span
                    >
                </label>
                <div
                    class="card bg-secondary shadow shadow-sm mb-2"
                    v-for="(specs, index) in $parent.productData.specifications"
                    :key="`spec-group-${index}`"
                >
                    <div class="card-header">
                        <div class="row align-items-center">
                            <label :for="`spec-group-name-${index}`" class="col-sm-2 col-form-label"
                                >Group Name</label
                            >
                            <div class="col-sm-9">
                                <input
                                    type="text"
                                    class="form-control"
                                    :id="`spec-group-name-${index}`"
                                    v-model="specs.group_name"
                                />
                            </div>
                            <div class="col-sm-1 text-right">
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-danger"
                                    title="Remove group"
                                    @click="removeGroup($parent.productData.specifications, index)"
                                >
                                    <i class="la la-trash font-weight-bold"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-1">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr class="text-center">
                                    <th>Name</th>
                                    <th>Value</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(attribute, attrIndex) in specs.group_items || []"
                                    :key="`spec-${index}-attr-${attrIndex}`"
                                >
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control form-control-sm"
                                            :id="`spec-group-${index}-attr-${attrIndex}-name`"
                                            v-model="attribute.name"
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control form-control-sm"
                                            :id="`spec-group-${index}-attr-${attrIndex}-value`"
                                            v-model="attribute.value"
                                        />
                                    </td>
                                    <th width="40">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger"
                                            title="Remove"
                                            @click="removeAttr(specs.group_items, attrIndex)"
                                        >
                                            <i class="la la-minus font-weight-bold" style="font-size: 150%"></i>
                                        </button>
                                    </th>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <button
                                            type="button"
                                            class="btn btn-warning btn-sm btn-block"
                                            @click="addNewAttr(specs?.group_items ?? [])"
                                        >
                                            Add Specs Option
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <button
                    class="btn btn-primary btn-block btn-sm"
                    @click="addNewGroup($parent.productData.specifications)"
                >
                    Add Specification Group
                </button>
                <small v-if="$parent.validationErrors.specifications" class="text-danger mt-3">{{
                    $parent.validationErrors.specifications[0]
                }}</small>
            </div>

            <!-- load the view from type and view_namespace attribute if set -->
        </div>
    </div>
</template>

<script>
export default {
    name: 'FeaturesAndSpecifications',
    methods: {
        checkIfProductFieldIsRequired(productFieldName) {
            return !!this.$parent.productMandatoryFields.includes(productFieldName);
        },
        removeAttr(source, index) {
            source.splice(index, 1);
        },
        addNewAttr(source) {
            if (!Array.isArray(source)) {
                return;
            }
            source.push({
                name: '',
                value: '',
            });
        },
        addNewGroup(source) {
            if (!Array.isArray(source)) {
                return;
            }
            source.push({
                group_name: '',
                group_items: [
                    {
                        name: '',
                        value: '',
                    },
                ],
            });
        },
        removeGroup(source, index) {
            if (!Array.isArray(source)) {
                return;
            }
            source.splice(index, 1);
        },
    },
};
</script>
