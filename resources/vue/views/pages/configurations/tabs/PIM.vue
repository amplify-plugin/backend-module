<template>
  <div role="tabpanel" class="tab-pane active" id="tab_basic-info">
    <fieldset>
      <div class="d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
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
      <div class="form-group">
        <div>
          <label>Auto Publish</label><br/>
          <input
              type="radio"
              name="auto_publish"
              :value="false"
              v-model="pimConfigurationData.auto_publish"
              :class="{ 'is-invalid': $parent.validationErrors.auto_publish }"
          />
          <span class="mr-2">No</span>
          <input
              type="radio"
              name="auto_publish"
              :value="true"
              v-model="pimConfigurationData.auto_publish"
              :class="{ 'is-invalid': $parent.validationErrors.auto_publish }"
          />
          <span class="mr-2">Yes</span>
          <small v-if="$parent.validationErrors.auto_publish" class="text-danger mt-3">{{
              $parent.validationErrors.auto_publish[0]
            }}</small>
        </div>
      </div>
      <div class="form-group">
        <label>Required Fields</label><br/>
        <input
            type="radio"
            name="required_fields"
            :value="false"
            v-model="pimConfigurationData.required_fields"
            :class="{ 'is-invalid': $parent.validationErrors.required_fields }"
        />
        <span class="mr-2">No</span>
        <input
            type="radio"
            name="required_fields"
            :value="true"
            v-model="pimConfigurationData.required_fields"
            :class="{ 'is-invalid': $parent.validationErrors.required_fields }"
        />
        <span class="mr-2">Yes</span>
        <small v-if="$parent.validationErrors.required_fields" class="text-danger mt-3">
          {{ $parent.validationErrors.required_fields[0] }}</small
        >
      </div>
      <div class="form-group" v-if="pimConfigurationData.required_fields">
        <div>
          <label>All Fields <small class="text-primary"> (Required Fields)</small> </label><br/>
          <div class="row">
            <div
                class="col-sm-4 my-1"
                v-for="(label, key) in this.$parent.coreConfigurationData.pim.mandatory_field_labels"
            >
              <div class="checkbox form-check">
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
      <div class="form-group">
        <div>
          <label>Use Classifications</label><br/>
          <input
              type="radio"
              name="use_classifications"
              :value="false"
              v-model="pimConfigurationData.use_classifications"
              :class="{ 'is-invalid': $parent.validationErrors.use_classifications }"
          />
          <span class="mr-2">No</span>
          <input
              type="radio"
              name="use_classifications"
              :value="true"
              v-model="pimConfigurationData.use_classifications"
              :class="{ 'is-invalid': $parent.validationErrors.use_classifications }"
          />
          <span class="mr-2">Yes</span>
          <small v-if="$parent.validationErrors.use_classifications" class="text-danger mt-3">{{
              $parent.validationErrors.use_classifications[0]
            }}</small>
        </div>
      </div>
      <div class="form-group">
        <div class="form-check">
          <input
              class="form-check-input"
              type="checkbox"
              v-model="pimConfigurationData.use_product_specific_detail_page"
              id="use_product_specific_detail_page"
          />
          <label class="form-check-label" for="use_product_specific_detail_page">
            Use Product Unique Detail Page
          </label>
        </div>
        <small class="text-muted mt-2 d-block"
        >If enabled user can set different page layout for different page.</small
        >
      </div>
      <div class="form-group">
        <div class="form-check">
          <input
              class="form-check-input"
              type="checkbox"
              v-model="pimConfigurationData.use_minimum_order_quantity"
              id="use_minimum_order_quantity"
          />
          <label class="form-check-label" for="use_minimum_order_quantity">
            Use Minimum Order Quantity and Quantity Interval Settings
          </label>
        </div>
        <small class="text-muted mt-2 d-block"
        >If enabled user can set minimum order quantity and quantity interval for orders.</small
        >
      </div>
      <div class="form-group">
        <div>
          <label>Categorization Required</label><br/>
          <input
              type="radio"
              name="categorization_required"
              :value="false"
              v-model="pimConfigurationData.categorization_required"
              :class="{ 'is-invalid': $parent.validationErrors.categorization_required }"
          />
          <span class="mr-2">No</span>
          <input
              type="radio"
              name="categorization_required"
              :value="true"
              v-model="pimConfigurationData.categorization_required"
              :class="{ 'is-invalid': $parent.validationErrors.categorization_required }"
          />
          <span class="mr-2">Yes</span>
          <small v-if="$parent.validationErrors.web_order_prefix" class="text-danger mt-3">{{
              $parent.validationErrors.web_order_prefix[0]
            }}</small>
        </div>
      </div>
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
            {{ doc.name }} — <small class="text-muted">{{ doc.media_type }}</small>
          </option>
        </select>
        <small v-if="$parent.validationErrors.document_type" class="text-danger mt-3">
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
        <small v-if="$parent.validationErrors.default_status" class="text-danger mt-3">
          {{ $parent.validationErrors.default_status[0] }}
        </small>
        <small class="text-muted mt-2 d-block">
          These status will be applied when system create new product from catalog synchronization.
        </small>
      </div>
      <div class="form-group">
        <label>UOM – Unit of Measurements</label>
        <table class="table table-striped table-hover table-sm">
          <thead>
          <tr class="text-center align-baseline">
            <th>Code</th>
            <th>Label</th>
            <th width="35">
              <button
                  type="button"
                  style="width: 35px; height: 35px"
                  role="button"
                  @click.prevent="() => pimConfigurationData.unit_of_measurements.push({code: '', label: ''})"
                  class="btn btn-sm btn-primary">
                <b>+</b>
              </button>
            </th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(uom, index) in pimConfigurationData.unit_of_measurements" :key="index">
            <td>
              <input class="form-control"
                     type="text"
                     required
                     min="5"
                     max="255"
                     v-model="uom.code"
              >
            </td>
            <td>
              <input class="form-control"
                     type="text"
                     required
                     min="5"
                     max="255"
                     v-model="uom.label"
              >
            </td>
            <td width="35">
              <button
                  type="button"
                  role="button"
                  style="width: 35px; height: 35px"
                  @click.prevent="() => pimConfigurationData.unit_of_measurements.splice(index,1)"
                  class="btn btn-sm btn-danger">
                <b>-</b>
              </button>
            </td>
          </tr>
          </tbody>
          <tfoot>
          <tr class="text-center align-baseline">
            <th>Code</th>
            <th>Label</th>
            <th width="35">
              <button
                  type="button"
                  style="width: 35px; height: 35px"
                  role="button"
                  @click.prevent="() => pimConfigurationData.unit_of_measurements.push({code: '', label: ''})"
                  class="btn btn-sm btn-primary">
                <b>+</b>
              </button>
            </th>
          </tr>
          </tfoot>
        </table>
      </div>
    </fieldset>
    <div id="saveActions" class="form-group">
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
      productStatues : this.$parent.coreConfigurationData.pim.product_statuses ?? {},
      pimConfigurationData: {
        tab: 'pim',
        mandatory_fields: this.$parent.coreConfigurationData.pim.mandatory_fields ?? [],
        auto_publish: this.$parent.coreConfigurationData.pim.auto_publish ?? false,
        required_fields: this.$parent.coreConfigurationData.pim.required_fields ?? false,
        use_classifications: this.$parent.coreConfigurationData.pim.use_classifications ?? false,
        use_product_specific_detail_page:
            this.$parent.coreConfigurationData.pim.use_product_specific_detail_page ?? false,
        use_minimum_order_quantity: this.$parent.coreConfigurationData.pim.use_minimum_order_quantity ?? false,
        categorization_required: this.$parent.coreConfigurationData.pim.categorization_required ?? false,
        document_type: this.$parent.coreConfigurationData.pim.document_type ?? '',
        default_status: this.$parent.coreConfigurationData.pim.default_status ?? '',
        unit_of_measurements: this.$parent.coreConfigurationData.pim.unit_of_measurements ?? [{
          code: 'EA',
          label: 'Each'
        }]
      },
    };
  },
};
</script>
