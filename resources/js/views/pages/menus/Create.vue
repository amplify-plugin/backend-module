<template>
    <div class="row">
        <div :class="class_name">
            <!-- Default box -->
            <form method="post" @submit.prevent="" :action="backUrl">
                <div class="mb-2 text-right">
                    <!-- Single button -->
                    <AvailableLocales
                        :availableLocales="availableLocales"
                        :queryString="query_string"
                        :current_lang="current_lang"
                        :url="url"
                    ></AvailableLocales>
                </div>

                <!-- load the view from the application if it exists, otherwise load the one in the package -->
                <div class="card">
                    <div class="card-body">
                        <FormFields ref="formFields"></FormFields>
                    </div>
                </div>

                <div id="saveActions" class="form-group" v-if="method !== 'get'">
                    <input type="hidden" name="save_action" v-model="actionType"/>

                    <button @click="actionType = 'save_and_back';saveData();" type="button" class="btn btn-success">
                        <span class="la la-save" role="presentation" aria-hidden="true"></span>
                        &nbsp;
                        <span data-value="save_and_edit"> Save</span>
                    </button>

                    <button @click="actionType = 'save_and_new';saveData();" type="button"
                            class="btn btn-outline-primary">
                        <span class="la la-folder-open" role="presentation" aria-hidden="true"></span>
                        &nbsp;
                        <span data-value="save_and_edit"> Save and new</span>
                    </button>

                    <button v-has-role="'Super Admin, User'" @click="actionType = 'save_and_next';saveData();"
                            type="button" class="btn btn-outline-info">
                        <span class="la la-step-forward" role="presentation" aria-hidden="true"></span>
                        &nbsp;
                        <span data-value="save_and_edit"> Save and next</span>
                    </button>

                    <button @click="saveAndAction('cancel')" type="button" class="btn btn-default">
                        <span class="la la-ban"></span> Cancel
                    </button>
                </div>

                <div id="saveActions" class="form-group" v-else>
                    <input type="hidden" name="save_action" value="save_and_back" v-model="actionType">
                    <div class="btn-group" role="group">
                        <button type="submit" class="btn btn-success">
                            <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                            <span @click="actionType=saveAction.active.value; saveData()">{{
                                    saveAction.active.label
                                }}</span>
                        </button>
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                class="caret"></span><span class="sr-only">▼</span></button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                <template v-for="(option, index) in saveAction.options">
                                    <button class="dropdown-item" @click="actionType=index; saveData()">{{
                                            option
                                        }}
                                    </button>
                                </template>

                            </div>
                        </div>
                    </div>
                    <a :href="backUrl" class="btn btn-default"><span class="la la-ban"></span> &nbsp;Cancel</a>
                </div>

            </form>
        </div>
    </div>
</template>

<script>
import _ from "lodash";
import AvailableLocales from "../../components/AvailableLocales";
import Form from "../../../utilities/Form";
import FormFields from "./FormFields";

export default {
    name: "MenusCreate",
    components: {FormFields, AvailableLocales},

    props: [
        "class_name",
        "url",
        "method",
        "axios_url",
        "local_menu",
        "query_string",
        "pages",
        "group",
        "translation_enabled",
        "available_locales",
        "current_lang",
        "locale",
        'save_action'
    ],
    data() {
        return {
            menu: new Form({
                name: "",
                visibility_for: {
                    authenticated: false,
                    admin: false,
                    approver: false,
                    guest: false
                },
                url_type: "external",
                url: "",
                group_id: "",
                page_id: "",
                type: "default",
            }),
            groupId: "",
            backUrl: "/admin/menu",
            newUrl: "/admin/menu/create",
            actionType: "save_and_back",
            saveAction: JSON.parse(this.save_action),
            pageLists: [],
            availableLocales: JSON.parse(this.available_locales),
        };
    },

    created() {
        this.pageLists = JSON.parse(this.pages);
        this.menu.group_id = JSON.parse(this.group).id;
        this.groupId = JSON.parse(this.group).id;

        if (this.method !== "post") {
            this.initEdit();
        }
    },

    methods: {
        initEdit() {
            let local_menu = JSON.parse(this.local_menu);

            this.menu = new Form({
                name: local_menu.local_name,
                visibility_for: local_menu.visibility_for,
                group_id: local_menu.group_id,
                type: local_menu.type,
                url_type: local_menu.url_type,
                url: local_menu.url_type === "external" ? local_menu.url : null,
                page_id: local_menu.url_type === "page" ? local_menu.page_id : null,
                locale: this.locale
            });
        },
        saveAndAction(argument) {
            if (argument === "cancel") {
                window.location = "/admin/menu?group_id=" + this.groupId;
            }
        },

        saveData() {
            this.menu._save_action = this.actionType;
            this.menu
                .submit(this.method, this.axios_url)
                .then((res) => {
                    new Noty({
                        type: "success",
                        text: "Saved successfully",
                    }).show();
                    switch (this.actionType) {
                        case 'save_and_back':
                            console.log('save_and_back')
                            window.location = '/admin/menu?group_id=' + this.groupId
                            break;
                        case 'save_and_edit':
                            console.log('save_and_edit')
                            window.location = '/admin/menu/' + params.id + '/edit?group_id=' + this.groupId
                            break;
                        case 'save_and_new':
                            console.log('save_and_new')
                            window.location = '/admin/menu/create?group_id=' + this.groupId
                            break;
                        case 'save_and_preview':
                            console.log('save_and_preview')
                            window.location = '/admin/menu/' + params.id + '/show?group_id=' + this.groupId
                            break;
                    }

                })
                .catch((error) => {
                    new Noty({
                        type: "error",
                        text: error.message,
                    }).show();
                });

            // this.validationErrors = {};
            // let params = _.cloneDeep(this.menu);
            // params.values = JSON.stringify(this.menu);

            // axios[this.method](`${this.axios_url}`, params)
            //   .then((response) => {

            //     new Noty({
            //       type: "success",
            //       text: "Saved successfully",
            //     }).show();
            //     this.validationErrors = "";

            //     window.location =
            //       this.actionType === "save_and_back"
            //         ? this.backUrl + "?group_id=" + this.menu.group_id
            //         : this.newUrl;
            //   })
            //   .catch((err) => {
            //     this.validationErrors = err.response.data.errors;
            //     new Noty({
            //       type: "error",
            //       text: err.response.data.message,
            //     }).show();
            //   });
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
