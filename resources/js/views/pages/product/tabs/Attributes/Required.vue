<template>
    <div class="row mt-3">
        <!-- text input -->
        <div v-if="loader" class="text-center w-100" style="height: 250px">
            <div class="loader">Loading...</div>
        </div>

        <!-- Old Attributes View -->
<!--        <div v-else class="form-group col-sm-12 mb-0"-->
<!--             v-for="(attribute, index) in $parent.$parent.classificationAttributes">-->
<!--            <div class="card mb-3">-->
<!--                <div class="card-body">-->
<!--                    <div class="mb-3 d-flex justify-content-between">-->
<!--                        <label>-->
<!--                        <span>-->
<!--                            <strong> {{ attribute.local_name }}  <span class="badge badge-danger"-->
<!--                                                                       v-if="attribute.is_multiple">multiple</span></strong>-->
<!--                        </span>-->
<!--                        </label>-->
<!--                        <div>-->
<!--                            <button class="btn btn-sm btn-link"-->
<!--                                    type="button"-->
<!--                                    @click="incrementField(index)"-->
<!--                                    v-if="attribute.is_multiple">+ Add-->
<!--                            </button>-->
<!--                            <button class="btn btn-sm btn-link text-danger"-->
<!--                                    type="button"-->
<!--                                    @click="removeField(index)"-->
<!--                                    v-if="attribute.is_multiple">&times; Delete-->
<!--                            </button>-->
<!--                            <span title="Unit" class="btn btn-sm btn-link">-->
<!--                                {{ attribute.unit }}-->
<!--                            </span>-->
<!--                        </div>-->
<!--                    </div>-->

<!--                    <div class="d-flex">-->
<!--                        <div class="form-group col-sm-12 p-0"-->
<!--                             :class="{'text-danger': $parent.getErrorMessage('productAttributes', index, 'attribute_value')}">-->
<!--                            <label>Attribute Value</label>-->
<!--                            <i class="la la-flag-checkered pull-right"-->
<!--                               style="margin-top: 3px;"-->
<!--                               title="This field is translatable."></i>-->
<!--                            <div v-if="attribute.is_multiple">-->
<!--                                <div class="d-flex justify-content-between mb-3">-->
<!--                                    <div class="w-100">-->
<!--                                        <input type="text" class="form-control"-->
<!--                                               v-model="attribute.attribute_value"-->
<!--                                               :class="{'is-invalid': $parent.getErrorMessage('productAttributes', index, 'attribute_value')}">-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div v-else>-->
<!--                                <input type="text" class="form-control"-->
<!--                                       v-model="attribute.attribute_value"-->
<!--                                       :class="{'is-invalid': $parent.getErrorMessage('productAttributes', index, 'attribute_value')}">-->
<!--                                <small v-if="$parent.getErrorMessage('productAttributes', index, 'attribute_value')"-->
<!--                                       class="text-danger mt-3">-->
<!--                                    {{ $parent.getErrorMessage('productAttributes', index, 'attribute_value') }}-->
<!--                                </small>-->
<!--                            </div>-->

<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->

        <div v-else class="col-sm-12">
            <table class="table table-default table-hover mb-0">
                <thead>
                <tr>
                    <th scope="col" class="text-nowrap">Attribute Name</th>
                    <th scope="col" class="text-nowrap">Attribute Value</th>
                </tr>
                </thead>
                <tbody>
                <tr
                    v-if="$parent.$parent.classificationAttributes"
                    v-for="(attribute, index) in $parent.$parent.classificationAttributes"
                    :key="index"
                >
                    <td style="vertical-align: middle">
                        {{ attribute.local_name }}
                        <span class="badge badge-danger" v-if="attribute.is_multiple">multiple</span>
                    </td>

                    <td>
                        <input type="text" class="form-control"
                               v-model="attribute.attribute_value"
                               :class="{'is-invalid': $parent.getErrorMessage('productAttributes', index, 'attribute_value')}">
                    </td>
                </tr>
                <tr v-if="$parent.$parent.classificationAttributes.length === 0">
                    <td class="text-center w-100" colspan="100%">
                        No attributes found.
                    </td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th scope="col" class="text-nowrap">Attribute Name</th>
                    <th scope="col" class="text-nowrap">Attribute Value</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</template>

<script>
import FormFields from "../../../attribute/FormFields";
import _          from "lodash";

export default {
    name: "Required",
    data() {
        return {
            validationErrors: "",
            loader          : false,
            // multipleAttributes  : [{value: ""}]
        }
    },

    components: {
        FormFields
    },
    mounted() {
    },
    methods: {
        removeField(index) {
            this.$parent.$parent.classificationAttributes.splice(index, 1);

            new Noty({
                type: "info",
                text: 'Attribute removed',
            }).show();
        },
        incrementField(index) {
            let attribute             = _.cloneDeep(this.$parent.$parent.classificationAttributes[index]);
            attribute.attribute_value = '';
            this.$parent.$parent.classificationAttributes.splice(index + 1, 0, attribute);

            new Noty({
                type: "success",
                text: 'New Attribute added',
            }).show();
        }
    }
}
</script>

<style scoped>
.loader,
.loader:before,
.loader:after {
    background: #7c88a0;
    -webkit-animation: load1 1s infinite ease-in-out;
    animation: load1 1s infinite ease-in-out;
    width: 1em;
    height: 4em;
}

.btn-cross {
    border-radius: 0 5px 5px 0 !important;
}

.loader {
    color: #7c88a0;
    text-indent: -9999em;
    margin: 88px auto;
    position: relative;
    font-size: 6px;
    -webkit-transform: translateZ(0);
    -ms-transform: translateZ(0);
    transform: translateZ(0);
    -webkit-animation-delay: -0.16s;
    animation-delay: -0.16s;
}

.loader:before,
.loader:after {
    position: absolute;
    top: 0;
    content: '';
}

.loader:before {
    left: -1.5em;
    -webkit-animation-delay: -0.32s;
    animation-delay: -0.32s;
}

.loader:after {
    left: 1.5em;
}

@-webkit-keyframes load1 {
    0%,
    80%,
    100% {
        box-shadow: 0 0;
        height: 4em;
    }
    40% {
        box-shadow: 0 -2em;
        height: 5em;
    }
}

@keyframes load1 {
    0%,
    80%,
    100% {
        box-shadow: 0 0;
        height: 4em;
    }
    40% {
        box-shadow: 0 -2em;
        height: 5em;
    }
}
</style>
