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
                <div class="card-body px-1">
                    <!-- load the view from the application if it exists, otherwise load the one in the package -->
                    <input type="hidden" name="http_referrer" :value="url">
                    <FormFields
                        ref="formFields"
                    ></FormFields>
                </div>
            </div>

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

            <a :href="backUrl" class="btn btn-default">
                <span class="la la-ban"></span> &nbsp;Cancel
            </a>
        </div>
    </div>
</template>

<script>
import FormFields from "./FormFields";
import AvailableLocales from "../../components/AvailableLocales";

export default {
    name: "OptionCreate",
    props: [
        'class_name', 'url', 'translatable',
        'translation_enabled', 'available_locales', 'current_lang',
        'method', 'axios_url', 'locale',
        'option_data','query_string','save_action'
    ],
    data() {
        return {
            availableLocales: JSON.parse(this.available_locales),
            option: {
                option_name: '',
                is_required: false,
                description: '',
                option_type: 'text',
                value_type: 'Yes/No',
                default_value: '',
                limit_min: '',
                limit_max: '',
                limit_choices: [],
            },
            isOptionTypeBoolean: false,
            backUrl: '/admin/option',
            newUrl: '/admin/option/create',
            actionType: 'save_and_back',
            saveAction      : JSON.parse(this.save_action),

        }
    },
    components: {FormFields, AvailableLocales},

    created() {
        if (this.method === 'put') {
            this.initEdit()
        }
    },

    methods: {
        initEdit() {
            let option_data = JSON.parse(this.option_data);
            console.log(option_data);
            this.option = {
                id: option_data.id,
                option_name: option_data.local_name,
                is_required: option_data.is_required,
                description: option_data.description,
                option_type: option_data.option_type,
                value_type: option_data.value_type,
                default_value: option_data.default_value,
                limit_min: option_data.limit_min,
                limit_max: option_data.limit_max,
                limit_choices: option_data.limit_choices,
            }
            setTimeout(() => {
                this.$refs.formFields.onChangeOptionType();
            }, 100);
        },

        saveData() {
            if(this.$refs.formFields.minMaxError){
                new Noty({
                    type: "error",
                    text: "The Max value must be greater than Min value",
                }).show();
                return;
            }
            this.$refs.formFields.validationErrors = '';
            let limit_choices = '';
            if (this.option?.limit_choices?.length > 0) {
                limit_choices = JSON.stringify(this.option.limit_choices);
            }

            let params = _.cloneDeep(this.option);
            params.limit_choices = limit_choices;
            params._save_action = this.actionType; 

            axios[this.method](`${this.axios_url}?locale=${this.locale}`, params)
                .then(response => {
                    new Noty({
                        type: "success",
                        text: 'Saved successfully',
                    }).show();
                    this.$refs.formFields.validationErrors = '';
                      
                    window.location.href = "/"+response.data.redirect_url;

                    // window.location = this.actionType === 'save_and_back' ? this.backUrl : this.newUrl;
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
