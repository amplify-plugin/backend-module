<template>
    <div class="row">
        <div :class="class_name">
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
        </div>
    </div>
</template>

<script>
import _ from "lodash";
import FormFields from "./FormFields";
export default {
    name: "MenusCreate",
    components: { FormFields },

    props: [
        "class_name",
        "url",
        "method",
        "axios_url",
        "local_config",
        "query_string",
    ],
    data() {
        return {
            config: new Form({
                name: "",
                key: "",
                value_type: "string",
                value: "",
            }),
            backUrl: "/admin/cms-config",
            newUrl: "/admin/cms-config/create",
            actionType: "save_and_back",
            validationErrors: {},
        };
    },

    created() {
        if (this.method !== "post") {
            this.initEdit();
        }
    },

    methods: {
        initEdit() {
            let local_menu = JSON.parse(this.local_menu);

            this.menu = {
                name: local_menu.name,
                url_type: local_menu.url_type,
                url: local_menu.url,
                group_id: local_menu.group_id,
                page_id: local_menu.page_id,
                type: local_menu.type,
            };
        },
        saveAndAction(argument) {
            if (argument === "cancel") {
                window.location = "/admin/menu?group_id=" + this.menu.group_id;
            }
        },

        onSubmit() {
            this.config.submit(this.method, this.axios_url)
                .then(res => {
                    console.log(res);
                })
                .catch(error => {
                    console.log(error);
                });
        },
    },
};
</script>

<style scoped>
.height-100 {
    height: 100px;
}

.height-150 {
    height: 150px;
}

.fixed-height {
    height: 350px;
    overflow: auto;
}

.btn-clipboard {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    z-index: 10;
    display: block;
    padding: 0.25rem 0.5rem;
    font-size: 75%;
    color: #ffffff;
    background-color: transparent;
    border: 0;
    border-radius: 0.25rem;
}

.btn-clipboard:hover {
    color: #fff;
    background-color: #ffa000;
}
</style>
