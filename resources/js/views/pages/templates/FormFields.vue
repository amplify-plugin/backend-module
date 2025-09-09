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
            <label :class="{'error-color': validationErrors.name}">
                Template Name
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <i title="This field is translatable."
               class="la la-flag-checkered pull-right"
               style="margin-top: 3px;"></i>
            <input @input="removeError('name'); $parent.convertNameToSlug($parent.template.name)" type="text"
                   name="template_name"
                   v-model="$parent.template.name"
                   placeholder="Enter template name"
                   class="form-control" :class="{'is-invalid': $parent.validationErrors.name}"
            >
            <small v-if="validationErrors.name" class="text-danger mt-3">{{
                    validationErrors.name[0]
                }}</small>
        </div>

        <div class="form-group col-sm-12 required">
            <label :class="{'error-color': validationErrors.slug}">
                Template Slug
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <input name="description" type="text"
                   v-model="$parent.template.slug"
                   class="form-control"
                   placeholder="Enter template slug"
                   :class="{'is-invalid': validationErrors.slug}"
            >
            <small v-if="validationErrors.slug" class="text-danger mt-3">{{
                    validationErrors.slug[0]
                }}</small>
        </div>

        <div class="form-group col-sm-12 required">
            <label :class="{'error-color': validationErrors.component_folder}">
                Component Location
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <input name="description" type="text"
                   v-model="$parent.template.component_folder"
                   class="form-control"
                   placeholder="Enter template component folder location"
                   :class="{'is-invalid': validationErrors.component_folder}"
            >
            <small v-if="validationErrors.component_folder" class="text-danger mt-3">{{
                    validationErrors.component_folder[0]
                }}</small>
        </div>

        <div class="form-group col-sm-12 required">
            <label :class="{'error-color': validationErrors.asset_folder}">
                Asset Location
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <input name="description" type="text"
                   v-model="$parent.template.asset_folder"
                   class="form-control"
                   placeholder="Enter asset folder location"
                   :class="{'is-invalid': validationErrors.asset_folder}"
            >
            <small v-if="validationErrors.asset_folder" class="text-danger mt-3">{{
                    validationErrors.asset_folder[0]
                }}</small>
        </div>

    </div>
</template>

<script>

export default {
    name : "FormFields",
    props: [],
    data() {
        return {
            validationErrors: "",
        }
    },
    mounted() {

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
    },
    watch  : {}

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
