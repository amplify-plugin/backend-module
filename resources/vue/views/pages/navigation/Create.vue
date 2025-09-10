<template>
    <div class="row">
        <div :class="class_name">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Default box -->
                    <form method="post" @submit.prevent="" :action="backUrl">
                        <!-- load the view from the application if it exists, otherwise load the one in the package -->
                        <div class="card">
                            <div class="card-body">
                                <FormFields ref="formFields"></FormFields>
                            </div>
                        </div>

                        <div id="saveActions" class="form-group" v-if="method !== 'get'">

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
                                            <button
                                                class="dropdown-item"
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
    </div>
</template>

<script>
import _ from "lodash";
import FormFields from "./FormFields";
import { highlight, languages } from "prismjs/components/prism-core";
import "prismjs/components/prism-clike";
import "prismjs/components/prism-javascript";
import "prismjs/themes/prism-okaidia.min.css";
import { PrismEditor } from "vue-prism-editor"; // import syntax highlighting styles

export default {
    name: "NavigationCreate",
    components: {
        FormFields,
        PrismEditor
    },

    props: [
        "class_name",
        "url",
        "method",
        "axios_url",
        "local_navigation",
        "local_menu_group",
        "local_account_menu",
        "local_mobile_menu",
        "query_string",
        "nav_layouts",
        "menu_list",
        "save_action"
    ],
    data() {
        return {
            navigation: {
                name: "",
                layout: "",
                content: {},
                top_bar: false,
                is_enabled: false,
                is_new: this.method !== "put",
                is_updated: false,
            },
            backUrl: "/admin/navigation",
            newUrl: "/admin/navigation/create",
            actionType: "save_and_back",
            validationErrors: {},
            menuList: [],
            allNavLayouts: [],
            selectedLayout: {},
            selectedMenuGroup: {},
            selectedUserAccountMenu:{},
            selectedMobileMenu: {},
            code: "",
            description: "",
            activeWidgetIndex: undefined,
            copyButtonText: "copy",
            saveAction      : JSON.parse(this.save_action),
            content: `<?xml version="1.0"?>
<content>

</content>`,
        };
    },

    created() {
        let obj = JSON.parse(this.nav_layouts);
        this.menuList = JSON.parse(this.menu_list);
        this.allNavLayouts = [];
        for (let i in obj) this.allNavLayouts.push(obj[i]);

        if (this.method !== "post") {
            this.initEdit();
        }
    },

    methods: {
        initEdit() {
            const local_navigation  = JSON.parse(this.local_navigation);
            const local_menu_group  = JSON.parse(this.local_menu_group);
            const local_account_menu = JSON.parse(this.local_account_menu);
            const local_mobile_menu = JSON.parse(this.local_mobile_menu);

            this.navigation = {
                id: local_navigation.id,
                name: local_navigation.name,
                content: JSON.parse(local_navigation.content),
                top_bar: local_navigation.top_bar,
                is_enabled: local_navigation.is_enabled,
                is_new: false,
                is_updated: false,
            };

            this.selectedMenuGroup  = local_menu_group;
            this.selectedUserAccountMenu = local_account_menu;
            this.selectedMobileMenu = local_mobile_menu;
            this.selectedLayout     = this.allNavLayouts.find(layout => layout.unique_identifier === local_navigation.layout);
        },

        onCopy: function (e) {
            this.copyButtonText = "copied";
            setTimeout(() => {
                this.copyButtonText = "copy";
            }, 2000);
            //alert('You just copied: ' + e.text)
        },

        onError: function (e) {
            alert("Failed to copy texts");
        },

        highlighter(code) {
            return highlight(code, languages.js); //returns html
        },

        saveAndAction(argument) {
            if (argument === "cancel") {
                window.location = "/admin/navigation";
            }
        },

        saveData(actionType) {
            this.validationErrors = {};
            this.navigation._save_action = actionType;
            let params             = _.cloneDeep(this.navigation);
            params.content         = JSON.stringify(this.navigation.content);
            params.layout          = this.selectedLayout.unique_identifier;
            params.menu_group_id   = this.selectedMenuGroup?.id ?? null;
            params.account_menu_id = this.selectedUserAccountMenu?.id ?? null;
            params.mobile_menu_id   = this.selectedMobileMenu?.id ?? null;
            params.is_updated      = this.method === "put";


            axios[this.method](`${this.axios_url}`, params)
                .then((response) => {
                    window.location.href = "/"+response.data.redirect_url; 
                })
                .catch((err) => {
                    this.validationErrors = err.response.data.errors;
                    new Noty({
                        type: "error",
                        text: err.response.data.message,
                    }).show();
                });
        },

        showCode(widget) {
            this.code = `<${widget.short_code}></${widget.short_code}>`;
        },

        showPageCode(page) {
            if (page.hasOwnProperty("url")) {
                this.code = `<${page.slug} title="${page.title}" url="${page.url}"></${page.slug}>`;
            } else {
                this.code = `<${page.slug} page="true"></${page.slug}>`;
            }
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
