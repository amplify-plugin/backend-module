<template>
    <div>
        <div class="mt-3">

            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <label>Options</label>
                        <button class="btn btn-sm btn-link"
                                type="button"
                                data-toggle="modal"
                                data-target="#inline-create-option"
                                @click="$refs.inlineCreate.getModal()">
                            + Add
                        </button>
                    </div>
                    <multiselect :class="{'is-invalid': validationErrors.options}"
                        v-model="$parent.$parent.optionalSelectedOptions"
                        :options="$parent.$parent.optionalOptions"
                        :multiple="true"
                        :close-on-select="false"
                        :clear-on-select="false"
                        :preserve-search="true"
                        :hide-selected="true"
                        placeholder="Pick some"
                        label="local_name"
                        track-by="local_name"
                    >
                    </multiselect>
                </div>
            </div>

        </div>

        <InlineCreate
            ref="inlineCreate"
            axios_url="/admin/option/inline/create"
            :locale="$parent.$parent.locale"
        ></InlineCreate>

    </div>
</template>

<script>
import FormFields   from "../../../options/FormFields";
import InlineCreate from "../../../options/InlineCreate";
import _            from "lodash";

export default {
    name      : "Optional",
    components: {FormFields, InlineCreate},
    data() {
        return {
            loadedModal       : 'Loading modal...',
            modalShade        : '',
            modalBody         : 'Loading...',
            option            : {
                name  : '',
                values: {}
            },
            allOptions     : [],
            enumOptions       : [],
            enumOption        : "",
            hasMinMaxErr      : false,
            noRanges          : ['text', 'boolean', 'enum'],
            optionalOptions: [],
            validationErrors  : []
        }
    },

    mounted() {
    },

    methods: {
        getOptionalOptionIndex(index) {
            return this.$parent.$parent.classificationOptions?.length + index
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

        getType(values) {
            let parased_value = JSON.parse(values);
            parased_value     = parased_value[0].type;
            return parased_value;
        },

        fetchProductOptions() {
            axios.post('/admin/product/fetch/product-options')
                .then(response => {
                    this.$parent.$parent.allOptions = response.data;
                    this.getOptionalOptions();
                })
                .catch(err => {
                    console.error(err)
                });
        },

        getOptionalOptions() {
            this.$parent.$parent.optionalOptions = _.xorBy(
                this.$parent.$parent.allOptions,
                this.$parent.$parent.classificationOptions,
                'id');
        },

        validateMinMax(index = null) {
            _.isNull(index)
            ? this.$parent.$parent.optionalSelectedOptions.filter((option, index) => {
                this.setError(option, index);
            })
            : this.setError(this.$parent.$parent.optionalSelectedOptions[index], index);
        },

        setError(option, index) {
            this.hasMinMaxErr = false;
            if (parseFloat(option.min) > parseFloat(option.max)) {
                this.hasMinMaxErr = true;

                this.$parent.$parent.optionalSelectedOptions[index].errors = {
                    message: "The Max value must be greater than Min value"
                }
            } else if (option.has_range === "1" && (!option.max || !option.min)) {
                this.hasMinMaxErr = true;

                this.$parent.$parent.optionalSelectedOptions[index].errors = {
                    message: "Min and Max value can't be empty"
                }
            } else {
                this.$parent.$parent.optionalSelectedOptions[index].errors = null;
            }
        },

        saveData() {
            this.$refs.formFields.validationErrors = [];

            let params    = _.cloneDeep(this.option);
            params.values = JSON.stringify(this.option.values);
            axios.post(`${this.axios_url}?locale=${this.locale}`, params)
                .then(response => {

                    new Noty({
                        type: "success",
                        text: 'Saved successfully',
                    }).show();
                    //document.querySelector("#cancelButton").click();
                    this.$refs.formFields.validationErrors = [];
                })
                .catch((err) => {
                    this.$refs.formFields.validationErrors = err.response.data.errors;
                    new Noty({
                        type: "error",
                        text: err.response.data.message,
                    }).show();
                    console.error(err);
                });
        }
    },

    watch: {
        allOptions: function (newVal, oldVal) {
            if (newVal !== oldVal) {
                this.$parent.$parent.allOptions = newVal;
                this.getOptionalOptions();
            }
        }
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
