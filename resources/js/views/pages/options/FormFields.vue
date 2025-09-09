<template>
    <div>
        <div class="form-group col-sm-12">
            <div v-if="validationErrors" class="alert alert-danger pb-0">
                <ul class="list-unstyled">
                    <div v-for="single_errors in validationErrors">
                        <li v-for="error in single_errors"><i class="la la-info-circle"></i>
                            {{ getErr(error) }}
                        </li>
                    </div>
                </ul>
            </div>
        </div>
        <!-- text input -->
        <div class="form-group col-sm-12 required">
            <label :class="{'error-color': validationErrors.option_name}">
                Name
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <i title="This field is translatable."
               class="la la-flag-checkered pull-right"
               style="margin-top: 3px;"></i>
            <input type="text" name="name" v-model="$parent.option.option_name" class="form-control"
                   :class="{'is-invalid': validationErrors.option_name}">
            <small v-if="validationErrors.option_name" class="text-danger mt-3">{{
                    validationErrors.option_name[0]
                }}</small>
        </div>

        <div class="form-group col-sm-12">
            <div class="checkbox">
                <input id="is_required" type="checkbox"
                       v-model="$parent.option.is_required">
                <label for="is_required" class="form-check-label font-weight-normal">
                    Is Required
                    <span class="text-danger font-weight-bold">*</span>
                </label>
            </div>
        </div>

        <div class="form-group col-sm-12 required">
            <label :class="{'error-color': validationErrors.description}">
                Description
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <input name="description" type="text"
                   v-model="$parent.option.description"
                   class="form-control"
                   :class="{'is-invalid': validationErrors.description}">
            <small v-if="validationErrors.description" class="text-danger mt-3">{{
                    validationErrors.description[0]
                }}</small>
        </div>

        <div class="form-group col-sm-12">
            <label :class="{'error-color':  checkTypeError().status}">
                Type
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <select @change="onChangeOptionType()" name="option_type" class="form-control"
                    v-model="$parent.option.option_type"
                    :class="{'is-invalid': checkTypeError().status}">
                <option :value="type" v-for="(type,index) in optionTypesArray" :key="index">{{
                        capitalizeFirstLetter(type)
                    }}
                </option>
            </select>
            <small v-if="checkTypeError().status"
                   class="text-danger mt-3">{{ checkTypeError().msg }}</small>
        </div>

        <div v-if="$parent.isOptionTypeBoolean" class="form-group col-sm-12">
            <label>
                Value Type
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <select name="value_type" class="form-control" v-model="$parent.option.value_type">
                <option :value="type" v-for="(type,index) in valueTypesArray" :key="index">{{ type }}
                </option>
            </select>
        </div>

        <div class="form-group col-sm-12">
            <label :class="{'error-color': validationErrors.default_value}">
                Default Value
            </label>
            <input type="text" name="default_value" v-model="$parent.option.default_value" class="form-control"
                   :class="{'is-invalid': validationErrors.default_value}">
            <small v-if="validationErrors.default_value" class="text-danger mt-3">{{
                    validationErrors.default_value[0]
                }}</small>
        </div>

        <div v-if="!$parent.isOptionTypeBoolean" class="border-custom ml-3 mr-3 pt-3 pb-2 rounded" :class="{'red-border': validationErrors.limit_min || validationErrors.limit_max}">
            <div v-if="!$parent.isOptionTypeBoolean && showLimitMinMax" class="form-group col-sm-12 mb-0">
                <label>
                    <strong>
                        Limit Input {{ $parent.option.option_type === 'number' ? 'Value' : 'Characters' }}
                    </strong>
                </label>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label :class="{'error-color': validationErrors.limit_min}">Min</label>
                        <input @input="validateMinMax()" type="number" name="limit_min"
                               v-model="$parent.option.limit_min" class="form-control"
                               :class="{'is-invalid': validationErrors.limit_min}">
                        <small v-if="validationErrors.limit_min" class="text-danger mt-3">
                            {{ validationErrors.limit_min[0] }}
                        </small>
                    </div>
                    <div class="form-group col-sm-6">
                        <label :class="{'error-color': validationErrors.limit_max}">Max</label>
                        <input @input="validateMinMax()" type="number" name="limit_max"
                               v-model="$parent.option.limit_max" class="form-control"
                               :class="{'is-invalid': validationErrors.limit_max}">
                        <small v-if="validationErrors.limit_max" class="text-danger mt-3">
                            {{ validationErrors.limit_max[0] }}
                        </small>
                    </div>
                </div>
            </div>

            <div v-if="!$parent.isOptionTypeBoolean && showLimitChoices" class="form-group col-sm-12">
                <div v-if="showSeparator" class="separator">OR</div>
                <label>Limit Choices</label>
                <multiselect :taggable="true" @tag="addTag"
                             v-model="$parent.option.limit_choices"
                             :options="limitChoicesOptions"
                             :multiple="true"
                             :close-on-select="false"
                             :clear-on-select="false"
                             :preserve-search="true"
                             :hide-selected="true"
                             placeholder="Pick some"
                             label="name"
                             track-by="name"
                >
                </multiselect>
            </div>
        </div>

    </div>
</template>

<script>

import _ from "lodash";

export default {
    name: "FormFields",
    props: [],
    data() {
        return {
            optionTypesArray: ['text', 'number', 'boolean'],
            valueTypesArray: ['Y/N', 'Yes/No', 'On/Off'],
            limitChoicesOptions: [],
            validationErrors: "",
            limitChoiceInputData: '',
            showLimitMinMax: true,
            showSeparator: true,
            showLimitChoices: true,
            minMaxError: false,
        }
    },
    mounted() {
        this.onChangeLimitMinMaxOrLimitChoices();
    },
    components: {},
    methods: {
        capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        },

        getErr(error) {
            if (_.isObject(error)) {
                return _.values(error)[0];
            }
            return error;
        },

        validateMinMax() {
            this.minMaxError = false;
            this.validationErrors = "";
            let max = this.$parent.option.limit_max;
            let min = this.$parent.option.limit_min;
            if (min === "" || max === "") {
                this.renderError();
            } else if (parseFloat(min) > parseFloat(max)) {
                this.renderError();
            }
        },

        renderError() {
            if (typeof this.validationErrors === 'string') {
                this.validationErrors = {
                    "limit_min": ["The Min value must not be greater than Max value\n"],
                    "limit_max": ["The Max value must be greater than Min value\n"]
                };
                this.minMaxError = true;
            } else if (typeof this.validationErrors === 'object') {
                this.validationErrors.limit_min = ["The Min value must not be greater than Max value\n"];
                this.validationErrors.limit_max = ["The Max value must be greater than Min value\n"];
                this.minMaxError = true;
            }
        },

        checkTypeError(value) {
            let err = {status: false, msg: ""};
            if (this.validationErrors.values) {
                this.validationErrors.values.forEach((field) => {
                    if (field.type) {
                        err = {status: true, msg: field.type};
                    }
                })
            }
            return err;
        },

        onChangeOptionType() {
            this.$parent.isOptionTypeBoolean = this.$parent.option.option_type === 'boolean';
        },

        onChangeLimitMinMaxOrLimitChoices() {
            let minVal = this.$parent.option.limit_min ?? '',
                maxVal = this.$parent.option.limit_max ?? '',
                limit_choices = this.$parent.option.limit_choices ?? [];

            if (limit_choices.length > 0) {
                this.showLimitMinMax = false;
                this.showSeparator = false;
                this.showLimitChoices = true;
            } else {
                if ((minVal.toString().length > 0 && maxVal.toString().length > 0)
                    || minVal.toString().length > 0
                    || maxVal.toString().length > 0) {
                    this.showLimitMinMax = true;
                    this.showSeparator = false;
                    this.showLimitChoices = false;
                } else {
                    this.showLimitMinMax = true;
                    this.showSeparator = true;
                    this.showLimitChoices = true;
                }
            }
        },

        addTag(newTag) {
            const tag = {
                name: newTag,
                unique_slug: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.limitChoicesOptions.push(tag)
        },
    },
    watch: {
        "$parent.option.limit_min": function (newVal, oldVal) {
            this.onChangeLimitMinMaxOrLimitChoices();
        },
        "$parent.option.limit_max": function (newVal, oldVal) {
            this.onChangeLimitMinMaxOrLimitChoices();
        },
        "$parent.option.limit_choices": function (newVal, oldVal) {
            this.onChangeLimitMinMaxOrLimitChoices();
        },
    }

}
</script>

<style scoped>
.error-color {
    color: red;
}

.separator {
    display: flex;
    align-items: center;
    text-align: center;
    margin-bottom: 5px;
}

.separator::before,
.separator::after {
    content: '';
    flex: 1;
    border-bottom: 1px solid #00000026;
}

.separator:not(:empty)::before {
    margin-right: .25em;
}

.separator:not(:empty)::after {
    margin-left: .25em;
}

.border-custom {
    border: 1px solid rgba(0, 40, 100, .12);
}

.required-custom {
    color: #ff0000;
}
</style>
