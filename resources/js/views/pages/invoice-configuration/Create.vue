<template>
    <div class="row">
        <div class="col-lg-8">
            <!-- Default box -->
            <form method="post" @submit.prevent="" :action="backUrl">
                <!-- load the view from the application if it exists, otherwise load the one in the package -->
                <div class="card">
                    <div class="card-body">
                        <FormFields ref="formFields"></FormFields>
                    </div>
                </div>

                <div id="saveActions" class="form-group" v-if="method !== 'get'">
                    <input type="hidden" name="save_action" v-model="actionType" />

                    <button @click="actionType = 'save_and_back';onSubmit();" type="button" class="btn btn-success">
                        <span class="la la-save" role="presentation" aria-hidden="true"></span>
                        &nbsp;
                        <span data-value="save_and_edit"> Save</span>
                    </button>

                    <button @click="actionType = 'save_and_new';saveData();" type="button" class="btn btn-outline-primary">
                        <span class="la la-folder-open" role="presentation" aria-hidden="true"></span>
                        &nbsp;
                        <span data-value="save_and_edit"> Save and new</span>
                    </button>

                    <button v-has-role="'Super Admin, User'" @click="actionType = 'save_and_next';saveData();" type="button" class="btn btn-outline-info">
                        <span class="la la-step-forward" role="presentation" aria-hidden="true"></span>
                        &nbsp;
                        <span data-value="save_and_edit"> Save and next</span>
                    </button>

                    <button @click="saveAndAction('cancel')" type="button" class="btn btn-default">
                        <span class="la la-ban"></span> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import _ from "lodash";
import FormFields from "./FormFields";

export default {
    name : 'ProductCreate',
    components: { FormFields },
    props: [
        "url",
        "method",
        "axios_url",
        "query_string",
        "configuration_details"
    ],
    data() {
        return {
            invoiceConfiguration: new Form({
                header_content_type: "html",
                header_content: "",
                header_image_path: "",
                footer_content: "",
            }),
            backUrl: "/admin/invoice-configuration/1/show",
            newUrl: "/admin/invoice-configuration/create",
            actionType: "save_and_back",
            validationErrors: {},
            configurationDetails: {}
        };
    },

    created() {
        this.configID = JSON.parse(this.configuration_details).id;
        this.configurationDetails = JSON.parse(this.configuration_details);

        if (this.method !== "post") {
            this.initEdit();
        }
    },

    methods: {
        initEdit() {
            console.log(this.configurationDetails);

            this.invoiceConfiguration = new Form({
                id: this.configurationDetails.id,
                header_content_type: this.configurationDetails.header_content_type,
                header_content: this.configurationDetails.header_content,
                header_image_path: this.configurationDetails.header_image_path,
                footer_content: this.configurationDetails.footer_content,
            });
        },
        onSubmit() {
            this.invoiceConfiguration.submit(this.method, this.axios_url)
                .then(res => {
                    console.log(res);

                    let id = res?.data?.id ?? this.configurationDetails.id;
                    window.location = `/${res.redirect_url}/${id}/show`;
                })
                .catch(error => {
                    console.log(error);
                });
        },
    },
}

</script>