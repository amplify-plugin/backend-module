<template>
    <div id="settingEmailCreate" class="animated fadeIn">
        <div class="row">
            <div class="col-md-8 bold-labels">
                <form method="post" :action="backUrl">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Trigger <span class="text-danger">*</span></label>
                                <select name="event_id" @change="onEmailTypeChange(); removeError('event_id')"
                                        :class="{ 'is-invalid': validationErrors.event_id }" class="form-control"
                                        v-model="email.event_id">

                                    <option :value="emailType.id" v-for="emailType in allEvents">
                                        {{ emailType.name }}
                                    </option>
                                </select>
                                <small v-if="validationErrors.event_id" class="text-danger mt-3">{{
                                        validationErrors.event_id[0]
                                    }}</small>
                            </div>

                            <div class="form-group">
                                <label>
                                    Name
                                    <span class="text-danger">*</span>
                                </label>

                                <input @input="removeError('name')" type="text" name="name" v-model="email.name"
                                       class="form-control" :class="{ 'is-invalid': validationErrors.name }">
                                <small v-if="validationErrors.name" class="text-danger mt-3">{{
                                        validationErrors.name[0]
                                    }}</small>
                            </div>

                            <div class="form-group"
                                 :class="{ 'text-danger': validationErrors.notification_type }">
                                <label>Send Via<span class="text-danger">*</span></label>
                                <select name="notification_type"
                                        @change="email.email_body = ''; removeError('notification_type')"
                                        :class="{ 'is-invalid': validationErrors.notification_type }"
                                        class="form-control"
                                        v-model="email.notification_type">

                                    <option value="emailable">Email</option>
                                    <option value="messageable">Message</option>
                                </select>
                                <small v-if="validationErrors.notification_type" class="text-danger mt-3">{{
                                        validationErrors.notification_type[0]
                                    }}</small>
                            </div>

                            <div class="form-group" v-if="email.notification_type === 'emailable'">
                                <label>
                                    Subject
                                    <span v-if="email.notification_type ==='emailable'" class="text-danger">*</span>
                                </label>

                                <input @input="removeError('subject')"
                                       type="text" name="subject"
                                       v-model="email.subject"
                                       :required="email.notification_type ==='emailable'"
                                       :class="{ 'is-invalid': validationErrors.subject, 'form-control' : true }">
                                <small v-if="validationErrors.subject" class="text-danger mt-3">{{
                                        validationErrors.subject[0]
                                    }}</small>
                            </div>

                            <div class="form-group">
                                <label>
                                    Content
                                    <span class="text-danger">*</span>
                                </label>

                                <ckeditor v-if="email.notification_type == 'emailable'" v-model="email.email_body"
                                          @input="removeError('email_body')"
                                          :class="{ 'is-invalid': validationErrors.email_body }"></ckeditor>

                                <textarea v-if="email.notification_type == 'messageable'" v-model="email.email_body"
                                          @input="removeError('email_body')"
                                          class="form-control"
                                          :class="{ 'is-invalid': validationErrors.email_body }"></textarea>

                                <small v-if="validationErrors.email_body" class="text-danger mt-3">{{
                                        validationErrors.email_body[0]
                                    }}</small>
                            </div>

                            <div v-show="email.notification_type == 'emailable'">
                                <div class="form-group">
                                    <div class="checkbox my-0 my-lg-2">
                                        <input id="show_button" type="checkbox" v-model="email.show_button">
                                        <label for="show_button" class="form-check-label font-weight-normal">
                                            Show Button
                                        </label>
                                    </div>
                                </div>
                                <div v-show="email.show_button">
                                    <div class="form-group"
                                         :class="{ 'text-danger': validationErrors.button_text }">
                                        <label>
                                            Button Text
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input @input="removeError('button_text')" type="text" name="button_text"
                                               placeholder="See Details" v-model="email.button_text"
                                               class="form-control"
                                               :class="{ 'is-invalid': validationErrors.button_text }">
                                        <small v-if="validationErrors.button_text" class="text-danger mt-3">{{
                                                validationErrors.button_text[0]
                                            }}</small>
                                    </div>
                                    <div class="form-group"
                                         :class="{ 'text-danger': validationErrors.button_url }">
                                        <label>
                                            Button URL
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">{{ host }}</div>
                                            </div>
                                            <input @input="removeError('button_url')" type="text" name="button_url"
                                                   placeholder="/admin/customer" v-model="email.button_url"
                                                   class="form-control"
                                                   :class="{ 'is-invalid': validationErrors.button_url }">
                                        </div>
                                        <small v-if="validationErrors.button_url" class="text-danger mt-3">{{
                                                validationErrors.button_url[0]
                                            }}</small>
                                    </div>
                                </div>
                            </div>
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
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body overflow-auto">
                        <h5 class="card-title text-center border-bottom pb-1">Dynamic Strings</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th colspan="2">String</th>
                                    <th>Value</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-if="dynamicStrings.length === 0">
                                    <td colspan="3" class="text-center">
                                        No dynamic strings found.
                                    </td>
                                </tr>

                                <tr v-else v-for="(dynamicString, index) in dynamicStrings">
                                    <th>
                                        <button @click="copyToClipboard(dynamicString.key)" type="button"
                                                class="btn-clipboard btn-primary">
                                            {{ copyButtonText }}
                                        </button>
                                    </th>
                                    <th scope="row">{{ dynamicString.key }}</th>
                                    <th>{{ dynamicString.value }}</th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import _ from "lodash";

export default {
    name: "SettingEmail",
    components: {},
    props: [
        'url', 'axios_url', 'query_string',
        'method', 'events', 'email_data',
        'save_action'
    ],

    data() {
        return {
            host: window.location.host,
            email: {
                event_id: null,
                name: null,
                subject: null,
                email_body: null,
                notification_type: 'emailable',
                show_button: 0,
                button_text: null,
                button_url: null,
            },
            backUrl: '/admin/event-template',
            validationErrors: {},
            allEvents: JSON.parse(this.events),
            copyButtonText: 'Copy',
            dynamicStrings: [],
            actionType: 'save_and_back',
            saveAction: JSON.parse(this.save_action),
        }
    },
    created() {
        if (this.method === 'put') {
            this.initEdit()
        }
    },
    methods: {
        initEdit() {
            let emailData = JSON.parse(this.email_data);
            this.email = {
                id: emailData.id,
                event_id: emailData.event_id,
                name: emailData.name,
                subject: emailData.subject,
                email_body: emailData.email_body,
                show_button: emailData.show_button,
                notification_type: emailData.notification_type,
                button_text: emailData.button_text,
                button_url: emailData.button_url,
            };

            this.onEmailTypeChange();
        },

        onEmailTypeChange() {
            axios.get('/admin/event/get-variables?event_id=' + this.email.event_id + "&for_admin=false")
                .then(res => {
                    this.dynamicStrings = res.data ?? []
                })
                .catch((err) => {
                    new Noty({
                        type: "error",
                        text: 'Something went wrong!',
                    }).show();
                });

        },

        saveData(actionType) {
            this.validationErrors = {};

            let params = {
                id: this.email.id ?? '',
                event_id: this.email.event_id,
                name: this.email.name,
                subject: this.email.subject,
                email_body: this.email.email_body,
                show_button: this.email.show_button,
                notification_type: this.email.notification_type,
                button_text: this.email.button_text,
                button_url: this.email.button_url,
            };
            params._save_action = actionType;
            console.log('saveData:', this.axios_url);

            axios[this.method](`${this.axios_url}`, params)
                .then(response => {
                    this.validationErrors = "";
                    switch (actionType) {
                        case 'save_and_back':
                            console.log('save_and_back')
                            window.location = '/admin/event-template'
                            break;
                        case 'save_and_edit':
                            console.log('save_and_edit')
                            window.location = '/admin/event-template/' + params.id + '/edit'
                            break;
                        case 'save_and_new':
                            console.log('save_and_new')
                            window.location = '/admin/event-template/create'
                            break;
                        case 'save_and_preview':
                            console.log('save_and_preview')
                            window.location = '/admin/event-template/' + params.id + '/show'
                            break;
                    }
                })
                .catch((err) => {
                    this.validationErrors = err.response.data.errors;
                    new Noty({
                        type: "error",
                        text: err.response.data.message,
                    }).show();
                    console.error(err);
                })
                .finally(() => {

                });
        },

        removeError(key) {
            let errorsObject = this.validationErrors;
            let errorExist = errorsObject[key];
            if (errorExist) {
                delete errorsObject[key];
            }
            if (Object.keys(errorsObject).length <= 0) {
                this.validationErrors = "";
            }
            this.validationErrors = errorsObject;
        },

        copyToClipboard(text) {
            navigator.clipboard.writeText(text);

            new Noty({
                type: "success",
                text: 'Copied to clipboard successfully!',
            }).show();
        },
    },
    watch: {
        'email.show_button'(newValue, oldValue) {
            if (newValue === 0 || newValue === false) {
                this.email.button_text = null;
                this.email.button_url = null;
            }
        },
    },
}
</script>

<style scoped>
.btn-clipboard {
    display: block;
    padding: .25rem .5rem;
    font-size: 75%;
    color: #ffffff;
    border: 0;
    border-radius: .25rem;
}

.btn-clipboard:hover {
    color: #fff;
    background-color: #ffa000;
}
</style>
