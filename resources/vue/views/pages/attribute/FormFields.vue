<template>
    <div class="row">
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
            <label :class="{'error-color': validationErrors.name}">Display Name</label>
            <input
                type="text"
                name="name"
                v-model="$parent.attribute.name"
                class="form-control"
                :class="{'is-invalid': validationErrors.name}"
                @input="removeError('name'); $parent.convertNameToSlug($parent.attribute.name)"
            >

            <small v-if="validationErrors.name" class="text-danger mt-3">{{ validationErrors.name[0] }}</small>
        </div>

        <div class="form-group col-sm-12 required">
            <label :class="{'error-color': validationErrors.slug}">Slug</label>
            <input
                type="text"
                name="slug"
                v-model="$parent.attribute.slug"
                class="form-control"
                :class="{'is-invalid': validationErrors.slug}"
                @input="removeError('slug')"
            >

            <small v-if="validationErrors.slug" class="text-danger mt-3">{{ validationErrors.slug[0] }}</small>
        </div>
        <!-- load the view from type and view_namespace attribute if set -->

        <!-- hidden input -->
        <div class="hidden required">
            <input type="hidden" name="values" value="" class="form-control">
        </div>    <!-- load the view from type and view_namespace attribute if set -->

        <div class="form-group col-sm-12">
            <label>Description</label>
            <input class="form-control" v-model="$parent.attribute.description"/>
        </div>


        <!-- load the view from type and view_namespace attribute if set -->

        <!-- select from array -->
        <div class="form-group col-sm-12">
            <label :class="{'error-color':  validationErrors.type}">
                Type
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <select @change="checkHasRange()" name="type" class="form-control" v-model="$parent.attribute.type"
                    :class="{'is-invalid': validationErrors.type}">
                <option :value="type" v-for="(type,index) in typesArray" :key="index">{{
                        capitalizeFirstLetter(type)
                    }}
                </option>
            </select>
            <small v-if="validationErrors.type"
                   class="text-danger mt-3">{{ validationErrors.type[0] }}</small>
        </div>    <!-- load the view from type and view_namespace attribute if set -->

        <div v-if="$parent.attribute.type === 'select'" class="form-group col-sm-12">
            <label>Select Options</label>
            <div class="table-responsive">
                <table class="table table-sm table-bordered mb-2">
                    <thead>
                    <tr>
                        <th>Label</th>
                        <th>Slug</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(option, index) in $parent.attribute.select_options" :key="`opt-${index}`">
                        <td>
                            <input
                                type="text"
                                class="form-control"
                                v-model="option.label"
                                @input="syncOptionSlug(index)"
                                placeholder="Label"
                            >
                        </td>
                        <td>
                            <input
                                type="text"
                                class="form-control"
                                v-model="option.slug"
                                placeholder="slug"
                            >
                        </td>
                        <td class="text-center align-middle">
                            <button type="button" class="btn btn-sm btn-outline-danger" @click="removeOptionRow(index)">
                                <i class="la la-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr v-if="!$parent.attribute.select_options.length">
                        <td colspan="3" class="text-muted text-center">No options added.</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm" @click="addOptionRow">Add Option</button>
        </div>

        <!-- text input -->
        <div class="form-group col-sm-12"><label :class="{'error-color':  checkUnitError().status}">Unit</label>
            <input type="text" name="unit" v-model="$parent.attribute.unit" class="form-control"
                   :class="{'is-invalid':  checkUnitError().status}">
            <small v-if="checkUnitError().status"
                   class="text-danger mt-3">{{ checkUnitError().msg }}</small>
        </div>

        <!-- checkbox field -->
        <div class="form-group col-sm-12">
            <div class="checkbox">
                <input :disabled="!hasRange" @change="checkHasRange()" id="has_range" type="checkbox"
                       v-model="$parent.attribute.has_range">
                <label for="has_range" class="form-check-label font-weight-normal">Has Range</label>
            </div>
        </div>

        <!-- checkbox field -->
        <div class="form-group col-sm-12">
            <div class="checkbox">
                <input id="use_as_filter" type="checkbox" v-model="$parent.attribute.use_as_filter">
                <label for="use_as_filter" class="form-check-label font-weight-normal">Use As Filter</label>
            </div>
        </div>

        <div class="form-group col-sm-12">
            <div class="checkbox">
                <input id="is_required" type="checkbox" v-model="$parent.attribute.is_required">
                <label for="is_required" class="form-check-label font-weight-normal">Is Required</label>
            </div>
        </div>

        <div class="form-group col-sm-12">
            <div class="checkbox">
                <input id="is_updated" type="checkbox" v-model="$parent.attribute.is_updated">
                <label for="is_updated" class="form-check-label font-weight-normal">Is Updated</label>
            </div>
        </div>

        <!-- checkbox field -->
        <div class="form-group col-sm-12">
            <div class="checkbox">
                <input id="searchable" type="checkbox" v-model="$parent.attribute.searchable">
                <label for="searchable" class="form-check-label font-weight-normal">Searchable</label>
            </div>
        </div>

        <!-- checkbox field -->
        <div class="form-group col-sm-12">
            <div class="checkbox">
                <input id="tunable" type="checkbox" v-model="$parent.attribute.tunable">
                <label for="tunable" class="form-check-label font-weight-normal">Treat As Column</label>
            </div>
        </div>
    </div>
</template>

<script>
import _ from "lodash";

export default {
    name : "FormFields",
    props: [],
    data() {
        return {
            content         : '',
            typesArray      : ['text', 'date', 'integer', 'decimal', 'boolean', 'enum', 'select'],
            hasRange        : true,
            validationErrors: "",
        }
    },
    mounted() {
        this.checkHasRange();
    },
    components: {},
    methods   : {
        removeError(field) {
            if (this.validationErrors && this.validationErrors[field]) {
                this.$delete(this.validationErrors, field);
            }
        },

        capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        },

        checkUnitError(value) {
            let err = {status: false, msg: ""};
            if (this.validationErrors.values) {
                this.validationErrors.values.forEach((field) => {
                    if (field.unit) {
                        err = {status: true, msg: field.unit};
                    }
                })
            }
            return err;
        },

        checkHasRange() {
            const selectedType = this.$parent.attribute.type;
            this.hasRange = selectedType === 'date';
            this.$parent.attribute.has_range = this.hasRange;

            if (selectedType !== 'select') {
                this.$parent.attribute.select_options = [];
            } else if (!Array.isArray(this.$parent.attribute.select_options)) {
                this.$parent.attribute.select_options = [];
            }
        },

        addOptionRow() {
            this.$parent.attribute.select_options.push({ label: '', slug: '' });
        },

        removeOptionRow(index) {
            this.$parent.attribute.select_options.splice(index, 1);
        },

        syncOptionSlug(index) {
            const option = this.$parent.attribute.select_options[index];
            option.slug = this.makeSlug(option.label);
        },

        makeSlug(value) {
            return (value || '')
                .trim()
                .toLowerCase()
                .replace(/-/g, ' ')
                .replace(/[^\w ]+/g, '')
                .replace(/ +/g, '-');
        },

        getErr(error) {
            if (_.isObject(error)) {
                return _.values(error)[0];
            }
            return error;
        },
    },


}
</script>

<style scoped>
.error-color {
    color: red;
}

.required-custom {
    color: #ff0000;
}
</style>
