<template>
    <div class="animated fadeIn">

        <div class="row">
            <div class="col-md-8 bold-labels">
                <!-- Default box -->

                <form method="post" @submit.prevent="changeDB()">
                    <div class="card">
                        <div class="card-body row">
                            <div class="form-group col-sm-12">

                                <div class="d-flex justify-content-between">
                                    <label>
                                        Database Name <span class="text-danger">*</span> <code
                                        title="Current Database">({{ dbName }})</code>
                                    </label>
                                </div>
                                <input @input="removeError('newDB')" type="text"
                                       v-model="envSetting.newDB"
                                       class="form-control"
                                       :class="{'is-invalid': validationErrors && validationErrors.newDB}">
                                <small v-if="validationErrors !== undefined && validationErrors.newDB"
                                       class="text-danger mt-3">{{ validationErrors.newDB[0] }}</small>
                            </div>
                            <div class="form-group col-sm-12">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="create-new-db"
                                           v-model="envSetting.createNewDB"/>
                                    <label class="form-check-label" for="create-new-db">Create new database</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="saveActions" class="form-group">

                        <button type="button" :disabled="busy" class="btn btn-success"
                                @click="changeDB()">
                            <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                            <span data-value="save_and_back">Save</span>
                        </button>

                        <a @click="envSetting.newDB = ''" class="btn btn-default"><span
                            class="la la-ban"></span> &nbsp;Reset</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</template>

<script>
import _ from "lodash";


export default {
    name      : "EnvSettingsCreate",
    components: {},
    props     : ['change_db_url', 'check_db_url', 'db_name'],

    data() {
        return {
            envSetting      : {
                newDB   : '',
                createNewDB: false,
            },
            method          : 'post',
            changeDBUrl     : this.change_db_url,
            checkDBUrl      : this.check_db_url,
            validationErrors: {},
            dbName          : this.db_name,
            busy            : false,
        }
    },

    methods: {
        changeDB() {
            this.validationErrors = {};
            this.busy             = true;

            if (!this.envSetting.newDB) {
                let errText                 = 'Database name is required';
                this.validationErrors.newDB = [errText];
                new Noty({
                    type: "error",
                    text: errText,
                }).show();
                this.busy = false;
                return;
            }

            let params = {
                ...this.envSetting
            };

            axios[this.method](this.changeDBUrl, params)
                .then(response => {
                    new Noty({
                        type: response.data.status,
                        text: response.data.message,
                    }).show();
                    this.validationErrors = "";

                    setTimeout(() => {
                        this.dbName = this.envSetting.newDB;
                        this.checkDB();
                    }, 2000);
                })
                .catch((err) => {
                    console.log(err.response)

                    this.busy = false;
                    new Noty({
                        type: "error",
                        text: err.response.data.message,
                    }).show();
                    this.validationErrors = err.response.data.errors;
                    console.error(err);
                    /*setTimeout(() => {
                        window.location.reload();
                    }, 2000);*/
                })
                .finally(() => {
                });
        },
        checkDB() {
            let params = {};
            this.busy  = true;
            axios['get'](this.checkDBUrl, params)
                .then(response => {
                    new Noty({
                        type: response.data.status,
                        text: response.data.message,
                    }).show();
                })
                .catch((err) => {
                    console.log(err.response)
                    new Noty({
                        type: "error",
                        text: err.response?.data?.message
                              ?? err.response?.data
                              ?? 'Something went wrong, reloading the page...',
                    }).show();
                    console.error(err);
                })
                .finally(() => {
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                });
        },

        removeError(key) {
            let errorsObject = this.validationErrors;
            let errorExist   = typeof errorsObject === 'object' ? errorsObject[key] : undefined;
            if (errorExist) {
                delete errorsObject[key];
            }
            if (typeof errorsObject === 'object' && Object.keys(errorsObject).length <= 0) {
                this.validationErrors = "";
            }
            this.validationErrors = errorsObject;
        },
    },
    mounted() {
    },
    watch   : {},
    computed: {
        _() {
            return _;
        },
    },
}
</script>

<style>
#dataTransformationCreate .multiselect__placeholder {
    margin: 0 !important;
}

.ghost {
    opacity: 0.5;
    background: #c8ebfb;
}
</style>
