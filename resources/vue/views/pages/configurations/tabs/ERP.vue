<template>
  <div role="tabpanel" class="tab-pane active settings-pane" id="tab_basic-info">
    <fieldset class="settings-shell">
      <div class="settings-header d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
        <legend>
          <i class="la la-trello mr-2"></i>
          ERP API Configuration
        </legend>
        <div class="d-md-none custom-sidebar-ar" @click="$parent.toggleSidebar()">
          <div class="menu-icon-ar">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="#1b2a4e"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="feather feather-menu"
            >
              <line x1="3" y1="12" x2="21" y2="12"></line>
              <line x1="3" y1="6" x2="21" y2="6"></line>
              <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
          </div>
          <div class="close-icon-ar">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="red"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="feather feather-x"
            >
              <line x1="18" y1="6" x2="6" y2="18"></line>
              <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label>Select ERP</label>
        <select
            name="default_erp"
            class="form-control custom-select"
            v-model="erpConfigurationData.default_erp"
            @change="updateERPInfo"
        >
          <option
              :value="index"
              v-for="(pg, index) in $parent.coreConfigurationData.erp.labels"
              :key="index"
              :selected="index === erpConfigurationData.default_erp"
          >
            {{ pg }}
          </option>
        </select>
      </div>
      <div class="form-group" v-if="['csd-erp', 'apprise-erp'].includes(erpConfigurationData.default_erp)">
        <div>
          <label>Company Number</label>
          <input
              type="text"
              name="company_number"
              placeholder="Enter Tenant Company Number"
              v-model="erpConfigurationData.company_number"
              class="form-control"
              :class="{ 'is-invalid': $parent.validationErrors.company_number }"
          />
          <small v-if="$parent.validationErrors.company_number" class="text-danger mt-3">{{
              $parent.validationErrors.company_number[0]
            }}</small>
        </div>
      </div>
      <div class="form-group" v-if="['csd-erp'].includes(erpConfigurationData.default_erp)">
        <div>
          <label>Operator Init</label>
          <input
              type="text"
              name="operator_init"
              placeholder="Enter Tenant Operator Init"
              v-model="erpConfigurationData.operator_init"
              class="form-control"
              :class="{ 'is-invalid': $parent.validationErrors.operator_init }"
          />
          <small v-if="$parent.validationErrors.operator_init" class="text-danger mt-3">{{
              $parent.validationErrors.operator_init[0]
            }}</small>
        </div>
      </div>
      <div class="form-group" v-if="['csd-erp', 'apprise-erp'].includes(erpConfigurationData.default_erp)">
        <div>
          <label>Client ID</label>
          <input
              type="text"
              name="username"
              placeholder="Enter Username"
              v-model="erpConfigurationData.client_id"
              class="form-control"
              :class="{ 'is-invalid': $parent.validationErrors.client_id }"
          />
          <small v-if="$parent.validationErrors.client_id" class="text-danger mt-3">{{
              $parent.validationErrors.client_id[0]
            }}</small>
        </div>
      </div>
      <div class="form-group" v-if="['csd-erp', 'apprise-erp'].includes(erpConfigurationData.default_erp)">
        <div>
          <label>Client Secret</label>
          <input
              :type="clientSecretFieldType"
              name="password"
              placeholder="Enter password"
              v-model="erpConfigurationData.client_secret"
              class="form-control"
              :class="{ 'is-invalid': $parent.validationErrors.client_secret }"
          />
          <i
              @click="toggleClientSecretShow"
              :class="{
                            'eye-position las la-eye-slash': showPassword,
                            'eye-position las la-eye': !showPassword,
                        }"
          ></i>

          <small v-if="$parent.validationErrors.client_secret" class="text-danger mt-3">{{
              $parent.validationErrors.client_secret[0]
            }}</small>
        </div>
      </div>
      <div class="form-group" v-if="['csd-erp', 'facts-erp'].includes(erpConfigurationData.default_erp)">
        <label>User Name</label>
        <input
            type="text"
            name="username"
            placeholder="Enter Username"
            v-model="erpConfigurationData.username"
            class="form-control"
            :class="{ 'is-invalid': $parent.validationErrors.username }"
        />
        <small v-if="$parent.validationErrors.username" class="text-danger mt-3">{{
            $parent.validationErrors.username[0]
          }}</small>
      </div>
      <div class="form-group" v-if="['csd-erp', 'facts-erp'].includes(erpConfigurationData.default_erp)">
        <div>
          <label>Password</label>
          <input
              :type="passwordFieldType"
              name="password"
              placeholder="Enter password"
              v-model="erpConfigurationData.password"
              class="form-control"
              :class="{ 'is-invalid': $parent.validationErrors.password }"
          />
          <i
              @click="togglePasswordShow"
              :class="{
                            'eye-position las la-eye-slash': showPassword,
                            'eye-position las la-eye': !showPassword,
                        }"
          ></i>

          <small v-if="$parent.validationErrors.password" class="text-danger mt-3">{{
              $parent.validationErrors.password[0]
            }}</small>
        </div>
      </div>
      <div class="form-group" v-if="['csd-erp', 'facts-erp', 'apprise-erp'].includes(erpConfigurationData.default_erp)">
        <div>
          <label>End Point</label>
          <input
              type="url"
              name="url"
              placeholder="Enter endpoint"
              v-model="erpConfigurationData.url"
              class="form-control"
              :class="{ 'is-invalid': $parent.validationErrors.url }"
          />
          <small v-if="$parent.validationErrors.url" class="text-danger mt-3">{{
              $parent.validationErrors.url[0]
            }}</small>
        </div>
      </div>
      <div class="form-group" v-if="['csd-erp', 'apprise-erp'].includes(erpConfigurationData.default_erp)">
        <div>
          <label>Token Endpoint</label>
          <input
              type="url"
              name="token_url"
              placeholder="Enter refresh token endpoint"
              v-model="erpConfigurationData.token_url"
              class="form-control"
              :class="{ 'is-invalid': $parent.validationErrors.token_url }"
          />
          <small v-if="$parent.validationErrors.token_url" class="text-danger mt-3">{{
              $parent.validationErrors.token_url[0]
            }}</small>
        </div>
      </div>
      <div class="form-group">
        <div>
          <label>Customer Identification Field</label>
          <select
              type="text"
              name="customer_id_field"
              v-model="erpConfigurationData.customer_id_field"
              class="form-control"
              :class="{ 'is-invalid': $parent.validationErrors.customer_id_field }"
          >
            <option v-for="(field, index) in customerERPAuthFields" :key="index" :value="field.value">
              {{ field.name }}
            </option>
          </select>
          <small v-if="$parent.validationErrors.customer_id_field" class="text-danger mt-3">{{
              $parent.validationErrors.customer_id_field[0]
            }}</small>
        </div>
      </div>
      <div class="form-group">
        <input
            type="checkbox"
            name="enabled"
            id="erp_enabled"
            v-model="erpConfigurationData.enabled"
            :class="{ 'is-invalid': $parent.validationErrors.enabled }"
        />
        <label for="erp_enabled">Enabled</label>
        <small v-if="$parent.validationErrors.enabled" class="text-danger mt-3">{{
            $parent.validationErrors.enabled[0]
          }}</small>
      </div>
      <div class="form-group">
        <input
            type="checkbox"
            name="multiple_warehouse"
            id="erp_multiple_warehouse"
            v-model="erpConfigurationData.multiple_warehouse"
            :class="{ 'is-invalid': $parent.validationErrors.multiple_warehouse }"
        />
        <label for="erp_multiple_warehouse">Allow Multiple Warehouse</label>
        <small v-if="$parent.validationErrors.multiple_warehouse" class="text-danger mt-3">{{
            $parent.validationErrors.multiple_warehouse[0]
          }}</small>
      </div>
      <div class="form-group">
        <div class="form-check">
          <input
              class="form-check-input"
              type="checkbox"
              v-model="erpConfigurationData.use_single_warehouse_cart"
              id="use_single_warehouse_cart"
          />
          <label class="form-check-label" for="use_single_warehouse_cart">
            Use Single Warehouse in Cart
          </label>
        </div>
        <small class="text-muted mt-2 d-block"
        >If enabled the user can add products based on a single warehouse to the cart for ordering.</small
        >
      </div>
      <div class="form-group">
        <div class="form-check">
          <input
              class="form-check-input"
              type="checkbox"
              v-model="erpConfigurationData.auto_create_cash_customer"
              id="auto_create_cash_customer"
          />
          <label class="form-check-label" for="auto_create_cash_customer">
            Create Retail/Cash Customer on ERP
          </label>
        </div>
        <small class="text-muted mt-2 d-block">
          If enabled when a entry created in system, Amplify will send a customer create request to ERP.
        </small>
      </div>
      <div class="form-group">
        <div class="form-check">
          <input
              class="form-check-input"
              type="checkbox"
              v-model="erpConfigurationData.auto_create_contact"
              id="auto_create_contact"
          />
          <label class="form-check-label" for="auto_create_contact">
            Create Contact on ERP
          </label>
        </div>
        <small class="text-muted mt-2 d-block">
          If enabled when a entry created in system, Amplify will send a contact create request to ERP.
        </small>
      </div>
      <div class="form-group">
        <div class="form-check">
          <input
              class="form-check-input"
              type="checkbox"
              v-model="erpConfigurationData.auto_create_ship_to"
              id="auto_create_ship_to"
          />
          <label class="form-check-label" for="auto_create_ship_to">
            Create Customer ShipTo Address on ERP
          </label>
        </div>
        <small class="text-muted mt-2 d-block">
          If enabled when a entry created in system, Amplify will send a ship to address create request to ERP.
        </small>
      </div>
      <div class="form-group">
        <div class="form-check">
          <input
              class="form-check-input"
              type="checkbox"
              v-model="erpConfigurationData.use_amplify_shipping"
              id="use_amplify_shipping"
          />
          <label class="form-check-label" for="use_amplify_shipping">
            Use Amplify system to calculate shipping cost.
          </label>
        </div>
        <small class="text-muted mt-2 d-block">
          If enabled Amplify system will calculate shipping cost and append the cost to the create order request.
        </small>
      </div>
      <div class="form-group">
        <div class="form-check">
          <input
              class="form-check-input"
              type="checkbox"
              v-model="erpConfigurationData.add_ship_will_call_option"
              id="add_ship_will_call_option"
          />
          <label class="form-check-label" for="add_ship_will_call_option">
            Add "WILL CALL" Ship Option
          </label>
        </div>
        <small class="text-muted mt-2 d-block">
          If enabled system will append the default <b>*WILL CALL*</b> options to all configured ship options.
        </small>
      </div>

    </fieldset>
    <div id="saveActions" class="form-group settings-actions">
      <button @click="$parent.saveCoreConfigInfo(erpConfigurationData)" type="button" class="btn btn-success">
        <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
        <span data-value="save_and_edit"> Save</span>
      </button>

      <button @click="$parent.saveAndAction()" type="button" class="btn btn-default">
        <span class="la la-ban"></span> Cancel
      </button>
    </div>
  </div>
</template>

<script>
import Multiselect from 'vue-multiselect';

export default {
  name: 'ERP',
  components: {Multiselect},
  data() {
    return {
      erps: [],
      customerERPAuthFields: [
        {value: 'id', name: 'Customer Table ID Number'},
        {value: 'customer_code', name: 'ERP Customer Number'},
        {value: 'ar_number', name: 'Customer AR Invoice Number'},
      ],
      erpConfigurationData: {
        tab: 'erp',
        default_erp: this.$parent.coreConfigurationData.erp.default ?? 'default',
        enabled: false,
        url: '',
        delivery_options: [],
        customer_id_field: '',
        username: '',
        password: '',
        multiple_warehouse: false,
        company_number: '1',
        operator_init: 'sys',
        use_single_warehouse_cart: false,
        auto_create_cash_customer: this.$parent.coreConfigurationData.erp.auto_create_cash_customer ?? false,
        auto_create_contact: this.$parent.coreConfigurationData.erp.auto_create_contact ?? false,
        auto_create_ship_to: this.$parent.coreConfigurationData.erp.auto_create_ship_to ?? false,
        use_amplify_shipping: this.$parent.coreConfigurationData.erp.use_amplify_shipping ?? false,
        add_ship_will_call_option: this.$parent.coreConfigurationData.erp.add_ship_will_call_option ?? false,
        display_contact: false,
      },
      showPassword: false,
      showClientSecretShow: false,
      passwordFieldType: 'password',
      clientSecretFieldType: 'password',
      erp: [],
    };
  },

  mounted() {
    this.setValue(this.erpConfigurationData.default_erp, this.$parent.coreConfigurationData.erp.configurations);
  },

  methods: {
    updateERPInfo(event) {
      this.setValue(event.target.value, this.$parent.coreConfigurationData.erp.configurations);
    },

    setValue(erp, configurations) {
      for (const [key, value] of Object.entries(configurations)) {
        if (key === erp) {
          this.erpConfigurationData.url = value.url ?? '';
          this.erpConfigurationData.customer_id_field = value.customer_id_field ?? '';
          this.erpConfigurationData.delivery_options = value.delivery_options ?? [];
          this.erpConfigurationData.token_url = value.token_url ?? '';
          this.erpConfigurationData.client_id = value.client_id ?? '';
          this.erpConfigurationData.client_secret = value.client_secret ?? '';
          this.erpConfigurationData.username = value.username ?? '';
          this.erpConfigurationData.password = value.password ?? '';
          this.erpConfigurationData.company_number = value.company_number ?? '1';
          this.erpConfigurationData.operator_init = value.operator_init ?? 'sys';
          this.erpConfigurationData.enabled = value.enabled ?? false;
          this.erpConfigurationData.multiple_warehouse = value.multiple_warehouse ?? false;
          this.erpConfigurationData.use_single_warehouse_cart = value.use_single_warehouse_cart ?? false;
        }
      }
    },

    togglePasswordShow() {
      this.showPassword = !this.showPassword;
      this.passwordFieldType = this.passwordFieldType === 'password' ? 'text' : 'password';
    },
    toggleClientSecretShow() {
      this.showClientSecretShow = !this.showClientSecretShow;
      this.clientSecretFieldType = this.clientSecretFieldType === 'password' ? 'text' : 'password';
    },

    addItem() {
      this.erpConfigurationData.delivery_options.push({
        code: '',
        label: '',
      });
    },
    removeItem(index) {
      this.erpConfigurationData.delivery_options.splice(index, 1);
    },
  },
};
</script>

<style scoped>
/* codex-basic-theme */
.settings-pane {
  padding: 1rem 0;
}

.settings-shell {
  border: 1px solid #e6ebf2;
  border-radius: 16px;
  padding: 1.25rem;
  background: #f7fafc;
  margin-bottom: 0.75rem;
}

.settings-header {
  border-bottom: 1px solid #e7edf5 !important;
}

.settings-header legend,
.settings-shell legend {
  margin: 0;
  color: #1f2a44;
  font-size: 1.2rem;
  font-weight: 600;
}

.settings-shell .form-group {
  background: #fff;
  border: 1px solid #e7edf5;
  border-radius: 12px;
  padding: 0.9rem;
}

.settings-shell .form-group > label,
.settings-shell .form-group label {
  color: #31415e;
  font-weight: 600;
  margin-bottom: 0.5rem;
}

.settings-shell .form-control,
.settings-shell .custom-select,
.settings-shell .multiselect .multiselect__tags,
.settings-shell .vue-treeselect .vue-treeselect__control {
  border: 1px solid #d7dfec !important;
  border-radius: 10px !important;
  min-height: 40px;
  box-shadow: none !important;
}

.settings-shell .form-control:focus,
.settings-shell .custom-select:focus,
.settings-shell .multiselect.multiselect--active .multiselect__tags {
  border-color: #7aa7ff !important;
  box-shadow: 0 0 0 3px rgba(62, 125, 255, 0.12) !important;
}

.settings-shell .multiselect .multiselect__tags {
  padding-top: 8px !important;
}

.settings-shell .form-check,
.settings-shell .custom-checkbox {
  padding: 0.68rem 0.78rem !important;
  border: 1px solid #dbe5f0;
  border-radius: 10px;
  background: #fff;
}

.settings-shell .form-check-label {
  display: inline-flex;
  align-items: center;
  margin-bottom: 0;
}

.settings-shell .form-check-input,
.settings-shell input[type='checkbox'] {
  position: static;
  margin-left: 0;
  margin-right: 0.5rem;
}

.settings-actions {
  margin-top: 1.2rem;
  display: flex;
  align-items: center;
  gap: 0.6rem;
  border: 0 !important;
  padding: 0 !important;
  background: transparent !important;
}

@media (max-width: 991.98px) {
  .settings-shell {
    padding: 1rem;
  }
}
</style>

<style scoped>
/* codex-spacing-fix */
.settings-shell {
  padding: 0.9rem !important;
  margin-bottom: 0.6rem !important;
}

.settings-header {
  margin: -0.2rem -0.2rem 0.7rem !important;
  padding: 0.2rem 0.2rem 0.6rem !important;
}

.settings-shell .form-row,
.settings-shell .row {
  margin-left: -0.35rem;
  margin-right: -0.35rem;
}

.settings-shell .form-row > [class*='col-'],
.settings-shell .row > [class*='col-'] {
  padding-left: 0.35rem;
  padding-right: 0.35rem;
}

.settings-shell .form-group {
  padding: 0.65rem !important;
  margin-bottom: 0.55rem !important;
}

.settings-shell .row .form-group,
.settings-shell .form-row .form-group {
  margin-bottom: 0.7rem !important;
}

.settings-shell .form-control,
.settings-shell .custom-select,
.settings-shell .multiselect .multiselect__tags {
  min-height: 36px !important;
}

.settings-shell .form-group > label,
.settings-shell .form-group label {
  margin-bottom: 0.38rem !important;
}

.settings-actions {
  margin-top: 0.8rem !important;
}

.settings-actions .btn {
  padding-top: 0.35rem;
  padding-bottom: 0.35rem;
}

@media (max-width: 991.98px) {
  .settings-shell {
    padding: 0.75rem !important;
  }

  .settings-shell .form-group {
    padding: 0.6rem !important;
  }
}
</style>
