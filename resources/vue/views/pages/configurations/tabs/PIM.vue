<template>
  <div role="tabpanel" class="tab-pane active pim-settings-pane" id="tab_basic-info">
    <fieldset class="pim-settings-shell">
      <div class="pim-settings-header">
        <legend>
          <i class="la la-boxes mr-2"></i>
          Product Information Management
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

      <div class="settings-grid">
        <div class="form-group">
          <div>
            <label>Auto Publish</label>
            <div class="toggle-group">
              <label class="toggle-pill">
                <input
                  type="radio"
                  name="auto_publish"
                  :value="false"
                  v-model="pimConfigurationData.auto_publish"
                  :class="{ 'is-invalid': $parent.validationErrors.auto_publish }"
                />
                <span>No</span>
              </label>
              <label class="toggle-pill">
                <input
                  type="radio"
                  name="auto_publish"
                  :value="true"
                  v-model="pimConfigurationData.auto_publish"
                  :class="{ 'is-invalid': $parent.validationErrors.auto_publish }"
                />
                <span>Yes</span>
              </label>
            </div>
            <small v-if="$parent.validationErrors.auto_publish" class="text-danger mt-2 d-block">{{
              $parent.validationErrors.auto_publish[0]
            }}</small>
          </div>
        </div>

        <div class="form-group">
          <label>Required Fields</label>
          <div class="toggle-group">
            <label class="toggle-pill">
              <input
                type="radio"
                name="required_fields"
                :value="false"
                v-model="pimConfigurationData.required_fields"
                :class="{ 'is-invalid': $parent.validationErrors.required_fields }"
              />
              <span>No</span>
            </label>
            <label class="toggle-pill">
              <input
                type="radio"
                name="required_fields"
                :value="true"
                v-model="pimConfigurationData.required_fields"
                :class="{ 'is-invalid': $parent.validationErrors.required_fields }"
              />
              <span>Yes</span>
            </label>
          </div>
          <small v-if="$parent.validationErrors.required_fields" class="text-danger mt-2 d-block">
            {{ $parent.validationErrors.required_fields[0] }}</small
          >
        </div>
      </div>

      <div class="form-group" v-if="pimConfigurationData.required_fields">
        <div>
          <label>Product Mandatory Fields <small class="text-muted"> (Fields that are required to create/update a product)</small> </label>
          <div class="row mt-2">
            <div
              class="col-sm-4 my-1"
              v-for="(label, key) in this.$parent.coreConfigurationData.pim.mandatory_field_labels"
              :key="key"
            >
              <div class="checkbox form-check mandatory-card">
                <label class="font-weight-normal form-check-label" :for="key">
                  <input
                    type="checkbox"
                    class="form-check-input"
                    v-model="pimConfigurationData.mandatory_fields"
                    :value="key"
                    :id="key"
                    :checked="pimConfigurationData.mandatory_fields.includes(key) ? true : ''"
                  />
                  {{ label }}
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="settings-grid">
        <div class="form-group">
          <div>
            <label>Use Classifications</label>
            <div class="toggle-group">
              <label class="toggle-pill">
                <input
                  type="radio"
                  name="use_classifications"
                  :value="false"
                  v-model="pimConfigurationData.use_classifications"
                  :class="{ 'is-invalid': $parent.validationErrors.use_classifications }"
                />
                <span>No</span>
              </label>
              <label class="toggle-pill">
                <input
                  type="radio"
                  name="use_classifications"
                  :value="true"
                  v-model="pimConfigurationData.use_classifications"
                  :class="{ 'is-invalid': $parent.validationErrors.use_classifications }"
                />
                <span>Yes</span>
              </label>
            </div>
            <small v-if="$parent.validationErrors.use_classifications" class="text-danger mt-2 d-block">{{
              $parent.validationErrors.use_classifications[0]
            }}</small>
          </div>
        </div>

        <div class="form-group">
          <div>
            <label>Categorization Required</label>
            <div class="toggle-group">
              <label class="toggle-pill">
                <input
                  type="radio"
                  name="categorization_required"
                  :value="false"
                  v-model="pimConfigurationData.categorization_required"
                  :class="{ 'is-invalid': $parent.validationErrors.categorization_required }"
                />
                <span>No</span>
              </label>
              <label class="toggle-pill">
                <input
                  type="radio"
                  name="categorization_required"
                  :value="true"
                  v-model="pimConfigurationData.categorization_required"
                  :class="{ 'is-invalid': $parent.validationErrors.categorization_required }"
                />
                <span>Yes</span>
              </label>
            </div>
            <small v-if="$parent.validationErrors.web_order_prefix" class="text-danger mt-2 d-block">{{
              $parent.validationErrors.web_order_prefix[0]
            }}</small>
          </div>
        </div>
      </div>

      <div class="toggle-grid">
        <div class="form-group custom-control custom-checkbox pl-0">
          <input
            class="form-check-input"
            type="checkbox"
            v-model="pimConfigurationData.use_product_specific_detail_page"
            id="use_product_specific_detail_page"
          />
          <label class="form-check-label" for="use_product_specific_detail_page">
            Use Product Unique Detail Page
          </label>
          <small class="text-muted mt-2 d-block"
            >If enabled user can set different page layout for different page.</small
          >
        </div>

        <div class="form-group custom-control custom-checkbox pl-0">
          <input
            class="form-check-input"
            type="checkbox"
            v-model="pimConfigurationData.use_minimum_order_quantity"
            id="use_minimum_order_quantity"
          />
          <label class="form-check-label" for="use_minimum_order_quantity">
            Use Minimum Order Quantity and Quantity Interval Settings
          </label>
          <small class="text-muted mt-2 d-block"
            >If enabled user can set minimum order quantity and quantity interval for orders.</small
          >
        </div>

        <div class="form-group custom-control custom-checkbox pl-0">
          <input
            class="form-check-input"
            type="checkbox"
            v-model="pimConfigurationData.use_product_code_unique_check"
            id="use_product_code_unique_check"
          />
          <label class="form-check-label" for="use_product_code_unique_check">Use Product Code Unique Check</label>
          <small class="text-muted mt-2 d-block"
            >If enabled system will validate that product code is unique when updating product status (prevents duplicate product codes).</small
          >
        </div>

        <div class="form-group custom-control custom-checkbox pl-0">
          <input
            class="form-check-input"
            type="checkbox"
            v-model="pimConfigurationData.allow_back_order_on_catalog_sync"
            id="allow_back_order_on_catalog_sync"
          />
          <label class="form-check-label" for="allow_back_order_on_catalog_sync">
            Allow Back Order on catalog sync
          </label>
          <small class="text-muted mt-2 d-block"
            >If enabled, back orders are allowed when catalog sync items are created and when those items are processed into products. If disabled, the ERP Allow Back Order value is used.</small
          >
        </div>
      </div>

      <div class="settings-grid">
        <div class="form-group">
          <label>Product Default Document Type</label>
          <select
            name="document_type"
            class="form-control custom-select"
            :class="{ 'is-invalid': $parent.validationErrors.document_type }"
            v-model="pimConfigurationData.document_type"
          >
            <option value="" :selected="pimConfigurationData.document_type !== null" disabled>
              Select a Document Type
            </option>
            <option v-for="(doc, index) in $parent.documentTypes" :key="index" :value="doc.id">
              {{ doc.name }} - <small class="text-muted">{{ doc.media_type }}</small>
            </option>
          </select>
          <small v-if="$parent.validationErrors.document_type" class="text-danger mt-2 d-block">
            {{ $parent.validationErrors.document_type[0] }}
          </small>
          <small class="text-muted mt-2 d-block">
            This dropdown shows the document name along with its media type (e.g., pdf, image ).
          </small>
        </div>

        <div class="form-group">
          <label>Product Default Status</label>
          <select
            name="default_status"
            class="form-control custom-select"
            :class="{ 'is-invalid': $parent.validationErrors.default_status }"
            v-model="pimConfigurationData.default_status"
          >
            <option value="" :selected="pimConfigurationData.default_status !== null" disabled>
              Select a Product Status
            </option>
            <option v-for="(label, key) in productStatues" :key="key" :value="key">
              {{ label }}
            </option>
          </select>
          <small v-if="$parent.validationErrors.default_status" class="text-danger mt-2 d-block">
            {{ $parent.validationErrors.default_status[0] }}
          </small>
          <small class="text-muted mt-2 d-block">
            These status will be applied when system create new product from catalog synchronization.
          </small>
        </div>
      </div>

      <div class="form-group">
        <div>
          <label>ERP Synchronization Attributes <small class="text-muted"> (Amplify product fields that will get overwritten by ERP data)</small> </label>
          <div class="row mt-2">
            <div
                class="col-sm-4 my-1"
                v-for="(label, key) in this.$parent.coreConfigurationData.pim.synchronization.attributes"
                :key="key"
            >
              <div class="checkbox form-check mandatory-card">
                <label class="font-weight-normal form-check-label" :for="key">
                  <input
                      type="checkbox"
                      class="form-check-input"
                      v-model="pimConfigurationData.overwrites"
                      :value="key"
                      :id="key"
                      :checked="pimConfigurationData.overwrites.includes(key) ? true : ''"
                  />
                  {{ label }}
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label>UOM - Unit of Measurements</label>
        <div class="table-responsive table-uom">
          <table class="table table-striped table-hover table-sm">
            <thead>
              <tr class="text-center align-baseline">
                <th>Code</th>
                <th>Label</th>
                <th>Quantity</th>
                <th width="35">
                  <button
                    type="button"
                    style="width: 35px; height: 35px"
                    role="button"
                    @click.prevent="() => pimConfigurationData.unit_of_measurements.push({code: '', label: '', quantity: 1})"
                    class="btn btn-sm btn-primary"
                  >
                    <b>+</b>
                  </button>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(uom, index) in pimConfigurationData.unit_of_measurements" :key="index">
                <td>
                  <input class="form-control" type="text" required min="5" max="255" v-model="uom.code" />
                </td>
                <td>
                  <input class="form-control" type="text" required min="5" max="255" v-model="uom.label" />
                </td>
                <td>
                  <input class="form-control" type="number" required step="any" v-model="uom.quantity" />
                </td>
                <td width="35">
                  <button
                    type="button"
                    role="button"
                    style="width: 35px; height: 35px"
                    @click.prevent="() => pimConfigurationData.unit_of_measurements.splice(index,1)"
                    class="btn btn-sm btn-danger"
                  >
                    <b>-</b>
                  </button>
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr class="text-center align-baseline">
                <th>Code</th>
                <th>Label</th>
                <th>Quantity</th>
                <th width="35">
                  <button
                    type="button"
                    style="width: 35px; height: 35px"
                    role="button"
                    @click.prevent="() => pimConfigurationData.unit_of_measurements.push({code: '', label: '', quantity: 1})"
                    class="btn btn-sm btn-primary"
                  >
                    <b>+</b>
                  </button>
                </th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </fieldset>

    <div id="saveActions" class="form-group settings-actions">
      <button @click="$parent.saveCoreConfigInfo(pimConfigurationData)" type="button" class="btn btn-success">
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
export default {
  name: 'PIM',
  components: {},
  data() {
    return {
      productStatues: this.$parent.coreConfigurationData.pim.product_statuses ?? {},
      pimConfigurationData: {
        tab: 'pim',
        mandatory_fields: this.$parent.coreConfigurationData.pim.mandatory_fields ?? [],
        overwrites: this.$parent.coreConfigurationData.pim?.synchronization?.overwrites ?? [],
        auto_publish: this.$parent.coreConfigurationData.pim.auto_publish ?? false,
        required_fields: this.$parent.coreConfigurationData.pim.required_fields ?? false,
        use_classifications: this.$parent.coreConfigurationData.pim.use_classifications ?? false,
        use_product_specific_detail_page:
          this.$parent.coreConfigurationData.pim.use_product_specific_detail_page ?? false,
        use_minimum_order_quantity: this.$parent.coreConfigurationData.pim.use_minimum_order_quantity ?? false,
        use_product_code_unique_check: this.$parent.coreConfigurationData.pim.use_product_code_unique_check ?? true,
        allow_back_order_on_catalog_sync:
          this.$parent.coreConfigurationData.pim.allow_back_order_on_catalog_sync ?? false,
        categorization_required: this.$parent.coreConfigurationData.pim.categorization_required ?? false,
        document_type: this.$parent.coreConfigurationData.pim.document_type ?? '',
        default_status: this.$parent.coreConfigurationData.pim.default_status ?? '',
        unit_of_measurements: this.$parent.coreConfigurationData.pim.unit_of_measurements ?? [
          {
            code: 'EA',
            label: 'Each',
            quantity: 1,
          },
        ],
      },
    };
  },
};
</script>
<style scoped lang="css">
.pim-settings-pane {
  padding: 1rem 0;
}

.pim-settings-shell {
  border: 1px solid #e6ebf2;
  border-radius: 16px;
  padding: 1.25rem;
  background: #f7fafc;
}

.pim-settings-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-bottom: 1rem;
  margin-bottom: 1.25rem;
  border-bottom: 1px solid #e7edf5;
}

.pim-settings-header legend {
  margin: 0;
  color: #1f2a44;
  font-size: 1.2rem;
  font-weight: 600;
}

.settings-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  grid-column-gap: 1rem;
  grid-row-gap: 0.75rem;
  margin-bottom: 0.75rem;
}

.form-group {
  background: #ffffff;
  border: 1px solid #e7edf5;
  border-radius: 12px;
  padding: 0.9rem;
  margin-bottom: 0.75rem;
}

.form-group > label,
.form-group label {
  color: #31415e;
  font-weight: 600;
  margin-bottom: 0.5rem;
}

.form-control,
.custom-select {
  border: 1px solid #d7dfec !important;
  border-radius: 10px !important;
  min-height: 40px;
  box-shadow: none !important;
}

.form-control:focus,
.custom-select:focus {
  border-color: #7aa7ff !important;
  box-shadow: 0 0 0 3px rgba(62, 125, 255, 0.12) !important;
}

.toggle-grid {
  margin-top: 0.2rem;
  margin-bottom: 0.75rem;
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 0.75rem;
}

.toggle-group {
  display: inline-flex;
  gap: 0.6rem;
  align-items: center;
}

.toggle-pill {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  border: 1px solid #d7dfec;
  border-radius: 999px;
  padding: 0.3rem 0.7rem;
  background: #f7faff;
  margin-bottom: 0;
  font-weight: 500;
}

.toggle-pill input {
  margin-top: 0;
}

.custom-checkbox {
  padding: 0.68rem 0.78rem !important;
  border: 1px solid #dbe5f0;
  border-radius: 10px;
  background: #fff;
}

.custom-checkbox .form-check-label {
  display: inline-flex;
  align-items: center;
  margin-bottom: 0;
}

.custom-checkbox input[type='checkbox'] {
  position: static;
  margin-left: 0;
  margin-right: 0.5rem;
}

.mandatory-card {
  border: 1px solid #dbe5f0;
  border-radius: 8px;
  background: #fff;
  padding: 0.45rem 0.6rem;
}

.mandatory-card .form-check-label {
  display: inline-flex;
  align-items: center;
  margin-bottom: 0;
}

.mandatory-card .form-check-input {
  position: static;
  margin-left: 0;
  margin-right: 0.5rem;
}

small.text-muted {
  display: block;
  color: #5f738f !important;
  margin-top: 0.32rem;
}

.table-uom {
  max-height: 500px;
  overflow: auto;
  position: relative;
  border: 1px solid #d7dfec;
  border-radius: 10px;
}

.table-uom table {
  margin-bottom: 0;
}

.table-uom table > thead th {
  position: sticky;
  top: 0;
  z-index: 2;
  background-color: #f7faff;
  border-bottom: 1px solid #d7dfec;
}

.table-uom table > tfoot th {
  position: sticky;
  bottom: 0;
  z-index: 2;
  background-color: #f7faff;
  border-top: 1px solid #d7dfec;
}

.settings-actions {
  margin-top: 1.2rem;
  display: flex;
  align-items: center;
  gap: 0.6rem;
  border: 0;
  padding: 0;
  background: transparent;
}

@media (max-width: 991.98px) {
  .settings-grid,
  .toggle-grid {
    grid-template-columns: 1fr;
  }

  .pim-settings-shell {
    padding: 1rem;
  }
}
</style>
