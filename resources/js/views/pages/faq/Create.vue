<template>
    <div id="faqCreate" class="animated fadeIn">

        <div class="row">
            <div class="col-lg-8">
                <!-- Default box -->
                <form method="post" @submit.prevent="" :action="backUrl">
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
                                        <button class="dropdown-item"
                                            type="button"
                                            :key="'actionType-'+index"
                                            @click="saveData(k)">
                                            {{ option }}
                                        </button>
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
    </div>
</template>

<script>
import FormFields from "./FormFields";

export default {
    name      : "FaqCreate",
    components: {FormFields},
    props     : [
        'url', 'axios_url', 'query_string',
        'method', 'faq_data', 'all_faq_categories', 'save_action'
    ],

    data() {
        return {
            validationErrors: "",
            backUrl         : '/admin/faq',
            allFaqCategories: JSON.parse(this.all_faq_categories),
            faq             : {
                faq_category_id: null,
                question       : null,
                response       : null
                
            },
            actionType: 'save_and_back',
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
            let faqData = JSON.parse(this.faq_data);
            this.faq    = {
                id             : faqData.id,
                faq_category_id: faqData.faq_category_id,
                question       : faqData.question,
                response       : faqData.response
            };
        },

        saveData(actionType) {
            this.$parent.validationErrors = "";
            let params            = this.faq;
            params._save_action = actionType;

            axios[this.method](`${this.axios_url}`, params)
                .then(response => {
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

        cancel() {
            window.location = this.backUrl;
        },
    },
}
</script>

<style scoped>

</style>
