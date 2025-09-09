<template>
    <div class="row">
        <div :class="class_name">
            <div v-if="translation_enabled" class="mb-2 text-right">
                <!-- Single button -->
                <AvailableLocales
                    :availableLocales="availableLocales"
                    :current_lang="current_lang"
                    :queryString="query_string"
                    :url="url"
                ></AvailableLocales>
            </div>

            <!-- Default box -->
            <div class="card">
                <div class="card-body">
                    <!-- load the view from the application if it exists, otherwise load the one in the package -->
                    <input type="hidden" name="http_referrer" :value="url">
                    <FormFields
                        ref="formFields"
                    ></FormFields>

                </div>
            </div>
            <div id="saveActions" class="form-group">
                <input type="hidden" name="save_action" value="save_and_back">
                <div class="btn-group" role="group">
                    <button type="submit" class="btn btn-success">
                        <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                        <span @click="actionType=saveAction.active.value; saveData()">{{ saveAction.active.label }}</span>
                    </button>
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span><span class="sr-only">▼</span></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                            <template v-for="(option, index) in saveAction.options">
                                <button class="dropdown-item" @click="actionType=index; saveData()">{{ option }}</button>
                            </template>
                          
                        </div>
                    </div>
                </div>
                <a :href="backUrl" class="btn btn-default"><span class="la la-ban"></span> &nbsp;Cancel</a>
                </div>
        </div>
    </div>
</template>

<script>
import FormFields       from "./FormFields";
import AvailableLocales from "../../components/AvailableLocales";
import { exit } from "process";

export default {
    name      : "AttributeCreate",
    components: {FormFields, AvailableLocales},
    props     : [
        'class_name', 'url', 'translatable',
        'translation_enabled', 'available_locales', 'current_lang',
        'method', 'axios_url', 'locale',
        'local_attribute', 'query_string','save_action'
    ],
    data() {
        return {
            availableLocales: JSON.parse(this.available_locales),
            attribute       : {
                slug         : '',
                name         : '',
                is_updated   : false,
                has_range    : false,
                description  : '',
                type         : '',
                unit         : '',
                use_as_filter: false,
                searchable   : false,
                tunable      : false,
                _save_action : ''
            },
            backUrl         : '/admin/attribute',
            newUrl          : '/admin/attribute/create',
            actionType      : 'save_and_back',
            saveAction      : JSON.parse(this.save_action),
        }
    },

    created() {
        if (this.method === 'put') {
            this.initEdit()
        }
    },

    methods: {
        initEdit() {
            let local_attribute = JSON.parse(this.local_attribute);
            this.attribute      = {
                name         : local_attribute.local_name,
                slug         : local_attribute.slug,
                is_updated   : false,
                id           : local_attribute.id,
                has_range    : local_attribute.has_range,
                description  : local_attribute.description,
                type         : local_attribute.type,
                unit         : local_attribute.unit,
                use_as_filter: local_attribute.use_as_filter,
                searchable   : local_attribute.searchable,
                tunable      : local_attribute.tunable,
            }
        },

        saveData() {

            this.attribute._save_action = this.actionType;   
            this.$refs.formFields.validationErrors = "";
            let params                             = _.cloneDeep(this.attribute);
            axios[this.method](`${this.axios_url}?locale=${this.locale}`, params)
                .then(response => {
                    new Noty({
                        type: "success",
                        text: 'Saved successfully',
                    }).show();
                    this.$refs.formFields.validationErrors = "";
                    window.location.href = "/"+response.data.redirect_url;
                   
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
    }
}
</script>

<style scoped>

</style>
