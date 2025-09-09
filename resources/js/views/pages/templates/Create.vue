<template>
    <div class="row">
        <div :class="class_name">
            <!-- Default box -->
            <form method="post" @submit.prevent="" :action="backUrl">

                <!-- load the view from the application if it exists, otherwise load the one in the package -->
                <div class="card">
                    <div class="card-body">
                        <FormFields
                            ref="formFields"
                        ></FormFields>
                    </div>
                </div>


                <div id="saveActions" class="form-group">
                    <input type="hidden" name="save_action" value="save_and_back" v-model="actionType">
                    <div class="btn-group" role="group">

                        <button type="button" class="btn btn-success"
                                @click="saveData(saveAction.active.value)">
                            <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                            <span>{{ saveAction.active.label }}</span>
                        </button>

                        <div class="btn-group" role="group">
                            <button id="bpSaveButtonsGroup" type="button" class="btn btn-success dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                class="caret"></span><span class="sr-only">▼</span></button>
                            <div class="dropdown-menu" aria-labelledby="bpSaveButtonsGroup">

                                <template v-for="(option, k, index) in saveAction.options">
                                    <a class="dropdown-item"
                                         href="javascript:void(0);"
                                        :key="'actionType-'+index"
                                        @click="saveData(k)">
                                        {{ option }}
                                    </a>
                                </template>
                            </div>
                        </div>

                    </div>

                    <a :href="backUrl" class="btn btn-default"><span
                        class="la la-ban"></span> &nbsp;Cancel</a>

                </div>

            </form>
        </div>
    </div>
</template>

<script>
import _          from "lodash";
import FormFields from "./FormFields";

export default {
    name      : "TemplateCreate",
    components: {FormFields},

    props: [
        'class_name', 'url', 'method', 'axios_url', 'local_template', 'query_string', 'save_action'
    ],
    data() {
        return {
            template        : {
                name            : '',
                slug            : '',
                component_folder: '',
                asset_folder    : '',
                is_new          : (this.method !== 'put'),
                is_updated      : false,
            },
            backUrl         : '/admin/template',
            newUrl          : '/admin/template/create',
            actionType      : 'save_and_back',
            saveAction      : JSON.parse(this.save_action),
            validationErrors: {},
        }
    },

    created() {
        if (this.method !== 'post') {
            this.initEdit()
        }
    },

    methods: {
        initEdit() {
            let local_template = JSON.parse(this.local_template);

            this.template = {
                id              : local_template.id,
                name            : local_template.name,
                slug            : local_template.slug,
                component_folder: local_template.component_folder,
                asset_folder    : local_template.asset_folder,
                is_updated      : false,
            }
        },

        saveAndAction(argument) {
            if (argument === 'cancel') {
                window.location = '/admin/template';
            }
        },

        saveData(actionType) {
            this.validationErrors = {};
            this.template._save_action = actionType;
            let params            = _.cloneDeep(this.template);
            params.values         = JSON.stringify(this.template.values);
            axios[this.method](`${this.axios_url}`, params)
                .then(response => {
                    new Noty({
                        type: "success",
                        text: 'Saved successfully',
                    }).show();
                    window.location.href = "/"+response.data.redirect_url;
                })
                .catch((err) => {
                    this.validationErrors = err.response.data.errors;
                    new Noty({
                        type: "error",
                        text: err.response.data.message,
                    }).show();
                    console.error(err);
                });
        },

        convertNameToSlug(Name) {
            clearTimeout(this.timer);
            this.timer = setTimeout(() => {
                let slug = Name.trim()
                    .toLowerCase()
                    .replace(/-/g, ' ')
                    .replace(/[^\w ]+/g, '')
                    .replace(/ +/g, '-');

                this.checkTemplateSlugUnique(slug);
            }, 500)
        },

        checkTemplateSlugUnique(slug) {
            let params = {};
            if (this.method === 'put') {
                params.id = this.template.id
            }
            params.slug = slug;

            axios.post(`/admin/template/fetch/template-slug`, params)
                .then(response => {
                    this.template.slug = response.data.slug;
                })
                .catch((err) => {
                    console.error(err);
                });
        }
    }
}
</script>

<style scoped>

</style>
