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
                                <FormFields
                                    ref="formFields"
                                ></FormFields>
                            </div>
                        </div>


                        <div id="saveActions" class="form-group" v-if="method !== 'get'">

                            <input type="hidden" name="save_action" v-model="actionType">

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
                            <button @click="saveAndAction('cancel')" type="button"
                                    class="btn btn-default">
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
import _                      from "lodash";
import FormFields             from "./FormFields";
import {highlight, languages} from "prismjs/components/prism-core";
import "prismjs/components/prism-clike";
import "prismjs/components/prism-javascript";
import "prismjs/themes/prism-okaidia.min.css";
import {PrismEditor}          from "vue-prism-editor"; // import syntax highlighting styles
export default {
    name      : "MerchandisingZoneCreate",
    components: {FormFields, PrismEditor},

    props: [
        'class_name', 'url', 'method', 'axios_url', 'local_merchandising_zone', 'query_string', 'save_action'
    ],
    data() {
        return {
            merchandising_zone: {
                name       : '',
                easyask_key: '',
                description: '',
                is_new     : (this.method !== 'put'),
                is_updated : false,
            },
            backUrl           : '/admin/merchandising-zone',
            newUrl            : '/admin/merchandising-zone/create',
            actionType        : 'save_and_back',
            validationErrors  : {},
            code              : '',
            description       : '',

            copyButtonText: 'copy',
            saveAction      : JSON.parse(this.save_action),

        }
    },

    created() {
        if (this.method !== 'post') {
            this.initEdit();
        }
    },

    methods: {
        initEdit() {
            let local_merchandising_zone = JSON.parse(this.local_merchandising_zone);

            this.merchandising_zone = {
                name       : local_merchandising_zone.name,
                easyask_key: local_merchandising_zone.easyask_key,
                description: local_merchandising_zone.description,
                id         : local_merchandising_zone.id,
                is_updated : true
            }
        },
        onCopy : function (e) {
            this.copyButtonText = 'copied';
            setTimeout(() => {
                this.copyButtonText = 'copy';
            }, 2000)
            //alert('You just copied: ' + e.text)
        },
        onError: function (e) {
            alert('Failed to copy texts')
        },
        highlighter(code) {
            return highlight(code, languages.js); //returns html
        },

        saveAndAction(argument) {
            if (argument === 'cancel') {
                window.location = '/admin/merchandising-zone';
            }
        },

        saveData() {
            this.validationErrors = {};
            let params            = _.cloneDeep(this.merchandising_zone);
            params.values         = JSON.stringify(this.merchandising_zone.values);
            params._save_action = this.actionType;   

            axios[this.method](`${this.axios_url}`, params)
                .then(response => {
                    new Noty({
                        type: "success",
                        text: 'Saved successfully',
                    }).show();
                    this.validationErrors = "";
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
                let easyask_key = Name.trim()
                    .toLowerCase()
                    .replace(/-/g, ' ')
                    .replace(/[^\w ]+/g, '')
                    .replace(/ +/g, '-');

                this.checkMerchandisingZoneSlugUnique(easyask_key);
            }, 500)
        },
        getDataSource(source) {
            if (source === 'easy-ask') {
                return 'Data Source: <span class="badge bg-danger">Easy Ask Server</span>';
            } else if (source !== null && source !== 'easy-ask') {
                return 'Data Source: <span class="badge bg-success">Model</span>'
            } else if (source === null) {
                return 'Data Source:  <span class="badge bg-dark">Static</span>'
            }
        },

        checkMerchandisingZoneSlugUnique(easyask_key) {
            let params = {};
            if (this.method === 'put') {
                params.id = this.merchandising_zone.id
            }
            params.easyask_key = easyask_key;

            axios.post(`/admin/merchandising-zone/fetch/merchandising-zone-slug`, params)
                .then(response => {
                    this.merchandising_zone.easyask_key = response.data.easyask_key;
                })
                .catch((err) => {
                    console.error(err);
                });
        }
    }
}
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
    top: .5rem;
    right: .5rem;
    z-index: 10;
    display: block;
    padding: .25rem .5rem;
    font-size: 75%;
    color: #ffffff;
    background-color: transparent;
    border: 0;
    border-radius: .25rem;
}

.btn-clipboard:hover {
    color: #fff;
    background-color: #ffa000;
}
</style>
