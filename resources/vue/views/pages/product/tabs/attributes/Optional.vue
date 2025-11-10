<template>
    <div>
        <div class="mt-3">

            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <label>Attributes</label>
                        <button class="btn btn-sm btn-link"
                                type="button"
                                data-toggle="modal"
                                data-target="#inline-create-attribute"
                                @click="$refs.inlineCreate.getModal()">
                            + Add
                        </button>
                    </div>
                    <multiselect :class="{'is-invalid': validationErrors.attributes}"
                                 v-model="$parent.$parent.optionalSelectedAttributes"
                                 :options="$parent.$parent.optionalAttributes"
                                 :multiple="true"
                                 :close-on-select="false"
                                 :clear-on-select="false"
                                 :preserve-search="true"
                                 :hide-selected="true"
                                 placeholder="Pick some"
                                 label="local_name"
                                 track-by="local_name">
                        <template slot="selection" slot-scope="{ values, search, isOpen }"><span
                            class="multiselect__single"
                            v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span>
                        </template>
                    </multiselect>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <table class="table table-default table-hover mb-0">
                        <thead>
                        <tr>
                            <th scope="col" class="text-nowrap">Attribute Name</th>
                            <th scope="col" class="text-nowrap">Attribute Value</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-if="$parent.$parent.optionalSelectedAttributes.length > 0"
                            v-for="(attribute, index) in $parent.$parent.optionalSelectedAttributes"
                            :key="index"
                        >
                            <td style="vertical-align: middle">
                                {{ attribute.local_name }}
                                <span> ({{ attribute.type }}) </span>
                                <span title="Unit" class="btn btn-sm btn-link">
                                {{ attribute.unit }}
                            </span>
                            </td>

                            <td v-if="attribute.type === 'select'">
                                <multiselect
                                    v-model="attribute.attribute_value"
                                    :options="JSON.parse(attribute.select_options).map(option => option.slug)"
                                    :multiple="false"
                                    :close-on-select="true"
                                    :clear-on-select="false"
                                    :preserve-search="true"
                                    :hide-selected="true"
                                    placeholder="Select option"
                                >
                                </multiselect>

                            </td>

                            <td v-else>
                                <input type="text" class="form-control"
                                       v-model="attribute.attribute_value"
                                       :class="{'is-invalid': $parent.getErrorMessage('productAttributes', getOptionalAttributeIndex(index), 'attribute_value')}"
                                >
                                <small
                                    v-if="$parent.getErrorMessage('productAttributes', getOptionalAttributeIndex(index), 'attribute_value')"
                                    class="text-danger mt-3">
                                    {{
                                        $parent.getErrorMessage('productAttributes', getOptionalAttributeIndex(index),
                                            'attribute_value')
                                    }}
                                </small>
                            </td>
                        </tr>
                        <tr v-if="$parent.$parent.optionalSelectedAttributes.length === 0">
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

        </div>

        <InlineCreate
            ref="inlineCreate"
            axios_url="/admin/attribute/inline/create"
            :locale="$parent.$parent.locale"
        ></InlineCreate>

    </div>
</template>

<script>
import FormFields   from "../../../attribute/FormFields";
import InlineCreate from "../../../attribute/InlineCreate";
import _            from "lodash";

export default {
    name      : "Optional",
    components: {FormFields, InlineCreate},
    data() {
        return {
            loadedModal       : 'Loading modal...',
            modalShade        : '',
            modalBody         : 'Loading...',
            attribute         : {
                name         : '',
                is_updated   : false,
                has_range    : false,
                description  : '',
                type         : '',
                unit         : '',
                use_as_filter: false,
                searchable   : false,
                tunable      : false,
            },
            attributeBackup   : _.cloneDeep(this.attribute),
            allAttributes     : [],
            enumOptions       : [],
            enumOption        : "",
            hasMinMaxErr      : false,
            noRanges          : ['text', 'boolean', 'enum'],
            optionalAttributes: [],
            validationErrors  : "",
            masks             : {
                inputDateTime: 'DD-MM-YYYY HH:mm:ss',
            },
            popover           : {
                visibility: 'focus',
            },
            timezone          : this.$parent.$parent.timezone,
            reRenderDateRange : false,
        }
    },

    mounted() {
        if (this.$parent.$parent.method === 'put') {
            this.$parent.$parent.optionalSelectedAttributes.forEach((attribute, index) => {
                if (this.attribute.type === 'date') {
                    attribute.date_range = {
                        start: attribute.min ? new Date(Date.parse(attribute.min)) : '',
                        end  : attribute.max ? new Date(Date.parse(attribute.max)) : '',
                    }
                    this.reRenderDateRange++;
                }
            });
        }
    },

    methods: {
        getOptionalAttributeIndex(index) {
            return this.$parent.$parent.classificationAttributes?.length + index
        },

        addTag(newTag) {
            const tag = {
                name       : newTag,
                unique_slug: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.enumOptions.push(tag)
        },

        checkHasRange(value) {
            return this.noRanges.find((ele) => {
                return ele === value
            })
        },

        getAllAttributes() {
            axios.post('/admin/product/fetch/attributes')
                .then(response => {
                    this.$parent.$parent.allAttributes = response.data;
                    this.getOptionalAttributes();
                })
                .catch(err => {
                    console.error(err)
                });
        },

        getOptionalAttributes() {
            this.$parent.$parent.optionalAttributes = _.xorBy(
                this.$parent.$parent.allAttributes,
                this.$parent.$parent.classificationAttributes,
                'id');
        },

        validateMinMax(index = null) {
            _.isNull(index)
            ? this.$parent.$parent.optionalSelectedAttributes.filter((attribute, index) => {
                this.setError(attribute, index);
            })
            : this.setError(this.$parent.$parent.optionalSelectedAttributes[index], index);
        },

        setError(attribute, index) {
            this.hasMinMaxErr = false;
            if (parseFloat(attribute.min) < 0 || parseFloat(attribute.max) < 0) {
                this.hasMinMaxErr                                             = true;
                this.$parent.$parent.optionalSelectedAttributes[index].errors = {message: "Negative value not allowed"}

                if (parseFloat(attribute.min) < 0) {
                    this.$parent.$parent.optionalSelectedAttributes[index].min
                        = this.$parent.$parent.optionalSelectedAttributes[index].min.substring(1);
                }
                if (parseFloat(attribute.max) < 0) {
                    this.$parent.$parent.optionalSelectedAttributes[index].max
                        = this.$parent.$parent.optionalSelectedAttributes[index].max.substring(1);
                }
            } else if (parseFloat(attribute.min) > parseFloat(attribute.max)) {
                this.hasMinMaxErr                                             = true;
                this.$parent.$parent.optionalSelectedAttributes[index].errors = {
                    message: "The Max value must be greater than Min value"
                }
            } else if (attribute.has_range === "1" && (!attribute.max || !attribute.min)) {
                this.hasMinMaxErr = true;

                this.$parent.$parent.optionalSelectedAttributes[index].errors = {
                    message: "Min and Max value can't be empty"
                }
            } else {
                this.$parent.$parent.optionalSelectedAttributes[index].errors = null;
            }
        },

        saveData() {
            this.$refs.formFields.validationErrors = "";

            let params = _.cloneDeep(this.attribute);
            axios.post(`${this.axios_url}?locale=${this.locale}`, params)
                .then(response => {
                    this.attribute = _.cloneDeep(this.attributeBackup);

                    new Noty({
                        type: "success",
                        text: 'Saved successfully',
                    }).show();
                    //document.querySelector("#cancelButton").click();
                    this.$refs.formFields.validationErrors = "";
                })
                .catch((err) => {
                    this.$refs.formFields.validationErrors = err.response.data.errors;
                    new Noty({
                        type: "error",
                        text: err.response.data.message,
                    }).show();
                    console.error(err);
                });
        },
    },

    watch: {
        allAttributes: function (newVal, oldVal) {
            if (newVal !== oldVal) {
                this.$parent.$parent.allAttributes = newVal;
                this.getOptionalAttributes();
            }
        },
    },

    computed: {
        _() {
            return _;
        },
    },
}
</script>

<style scoped>
.loader,
.loader:before,
.loader:after {
    background: #000000;
    -webkit-animation: load1 1s infinite ease-in-out;
    animation: load1 1s infinite ease-in-out;
    width: 1em;
    height: 4em;
}

.loader {
    color: #000000;
    text-indent: -9999em;
    margin: 88px auto;
    position: relative;
    font-size: 11px;
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
