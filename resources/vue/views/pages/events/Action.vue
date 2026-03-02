<template>
  <div id="settingEmailCreate" class="animated fadeIn">

    <div class="row">
      <div :class="class_name">
        <form method="post" :action="backUrl">
          <div class="card">
            <div class="card-body">
              <div class="form-group">
                <label>Name<span class="text-danger">*</span>
                </label>
                <input @input="removeError('name')" type="text" name="name" v-model="event_action.name"
                       class="form-control" :class="{ 'is-invalid': validationErrors.name }">
                <small v-if="validationErrors.name" class="text-danger mt-3">{{
                    validationErrors.name[0]
                  }}</small>
              </div>

              <div class="form-group">
                <label>Trigger<span class="text-danger">*</span></label>
                <select name="event_id" @change="onEventChange(); removeError('event_id')"
                        :class="{ 'is-invalid': validationErrors.event_id }" class="form-control custom-select"
                        v-model="event_action.event_id">

                  <option :value="event.id" v-for="(event, index) in allEvents" :key="'event-'+index">
                    {{ event.name }}
                  </option>
                </select>
                <small v-if="validationErrors.event_id" class="text-danger mt-3">{{
                    validationErrors.event_id[0]
                  }}</small>
              </div>

              <div class="form-group">
                <label>Notification Template <span class="text-danger">*</span></label>
                <select name="event_template_id"
                        :class="{ 'is-invalid': validationErrors.event_template_id }"
                        class="form-control  custom-select"
                        v-model="event_action.event_template_id">

                  <option :value="template.id" v-for="(template, index) in allTemplates"
                          :key="'template-'+index">
                    {{ template.name }}
                  </option>
                </select>
                <small v-if="validationErrors.event_template_id" class="text-danger mt-3">{{
                    validationErrors.event_template_id[0]
                  }}</small>
              </div>

              <div class="form-group">
                <label class="mr-4">Recipients<span class="text-danger">*</span></label>

                <div class="form-check form-check-inline" v-for="recipent in recipents"
                     :key="recipent.id">
                  <input
                      :id="recipent.event_action_field"
                      class="form-check-input"
                      type="checkbox"
                      :name="recipent.event_action_field"
                      v-model="allRecipents[recipent.event_action_field]"
                  >
                  <label class="form-check-label"
                         :for="recipent.event_action_field">{{ recipent.name }}</label>
                </div>
                <p>
                  <small v-if="validationErrors.event_action_field" class="text-danger mt-3">
                    {{ validationErrors?.event_action_field[0] ?? '' }}
                  </small>
                </p>
              </div>

              <div class="form-group">
                <label>Extra Recipient Emails</label>
                <input @input="removeError('recipient_emails')" type="text" name="name"
                       v-model="event_action.recipient_emails"
                       class="form-control"
                       :class="{ 'is-invalid': validationErrors.recipient_emails }">
              </div>
              <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="enabled"
                         id="eventActionEnabled"
                         v-model="event_action.enabled"
                         :checked="event_action.enabled">
                  <label class="form-check-label" for="eventActionEnabled">
                    Enabled?
                  </label>
                </div>
                <p>
                  <small v-if="validationErrors.enabled" class="text-danger mt-3">
                    {{ validationErrors.enabled[0] ?? '' }}</small>
                </p>
              </div>
            </div>
          </div>

          <div id="saveActions" class="form-group">
            <div class="btn-group" role="group">
              <button type="button" class="btn btn-success"
                      @click="saveData(saveAction.active.value)">
                <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                <span>{{ saveAction.active.label }}</span>
              </button>
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

export default {
  name: "EventAction",
  components: {},
  props: [
    'url', 'axios_url', 'class_name',
    'method', 'events', 'event_action_data', 'save_action'
  ],

  data() {
    return {
      host: window.location.host,
      event_action: {
        event_id: null,
        event_template_id: null,
        name: null,
        enabled: true,
        recipient_emails: '',
      },
      backUrl: '/admin/event-action',
      validationErrors: {},
      allEvents: JSON.parse(this.events),
      allTemplates: [],
      recipents: [],
      allRecipents: {
        is_get_admin: false,
        is_get_customer: false,
        is_get_contact: false,
        is_get_salesperson: false,
        is_quote_sales_person: false,
      },
      saveAction: JSON.parse(this.save_action),
      selectedRecipents: []
    }
  },
  mounted() {
    if (this.method === 'put') {
      this.initEdit()
    }
  },
  methods: {
    initEdit() {
      let eventAction = JSON.parse(this.event_action_data);
      console.log(eventAction);
      this.event_action = {
        id: eventAction.id,
        event_id: eventAction.event_id,
        name: eventAction.name,
        event_template_id: eventAction.event_template_id,
        is_get_admin: eventAction.is_get_admin,
        is_get_customer: eventAction.is_get_customer,
        is_get_contact: eventAction.is_get_contact,
        is_get_salesperson: eventAction.is_get_salesperson,
        is_quote_sales_person: eventAction.is_quote_sales_person,
        recipient_emails: eventAction.recipient_emails,
        enabled: eventAction.enabled,
      };
      this.allRecipents.is_get_admin = this.event_action.is_get_admin;
      this.allRecipents.is_get_customer = this.event_action.is_get_customer;
      this.allRecipents.is_get_contact = this.event_action.is_get_contact;
      this.allRecipents.is_get_salesperson = this.event_action.is_get_salesperson;
      this.allRecipents.is_quote_sales_person = this.event_action.is_quote_sales_person;

      this.onEventChange();
    },

    onEventChange() {
      axios.get('/admin/event/get-recipents?event_id=' + this.event_action.event_id)
          .then(res => {
            console.log('get-recipents', res);
            this.recipents = res.data ?? []
          })
          .catch((err) => {
            new Noty({
              type: "error",
              text: 'Something went wrong!',
            }).show();
          });

      axios.get('/admin/event/get-templates?event_id=' + this.event_action.event_id)
          .then(res => {
            console.log('get-themes', res);
            this.allTemplates = res.data ?? []
          })
          .catch((err) => {
            new Noty({
              type: "error",
              text: 'Something went wrong!',
            }).show();
          });
      // console.log('allRecipents on EventChange', this.allRecipents);
    },

    saveData(actionType) {
      // console.log('saveData:', this.allRecipents);
      this.validationErrors = {};
      let params = {
        id: this.event_action.id ?? '',
        event_id: this.event_action.event_id,
        event_template_id: this.event_action.event_template_id,
        name: this.event_action.name,
        ...this.allRecipents,
        recipient_emails: this.event_action.recipient_emails,
        enabled: this.event_action.enabled ?? true,
      };
      params._save_action = actionType;
      axios[this.method](`${this.axios_url}`, params)
          .then(response => {
            window.location.href = "/" + response.data.redirect_url;
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
  },
  watch: {},
}
</script>

<style scoped>
</style>
