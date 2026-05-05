<template>
    <div role="tabpanel" class="tab-pane active settings-pane" id="tab_dds">
        <fieldset class="settings-shell">
            <div class="settings-header d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
                <legend>
                    <i class="las la-archive mr-2"></i>
                    DDS Data Import
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
        </fieldset>

        <div class="form-group">
            <label>DDS Files</label>
            <div>
                <multiselect
                    v-model="DDSData.dates"
                    :options="dds_dates"
                    :multiple="true"
                    :close-on-select="true"
                    :clear-on-select="false"
                ></multiselect>
            </div>
        </div>

        <div class="form-group">
            <div class="d-flex justify-content-between">
                <label>
                    Schedule Time
                    <small class="text-primary">({{ $parent.timezone }})</small>
                </label>
            </div>
            <vc-date-picker
                v-model="DDSData.schedule_time"
                mode="dateTime"
                :timezone="$parent.timezone.toLowerCase()"
                :min-date="new Date()"
                :masks="masks"
                :popover="popover"
            >
                <template v-slot="{ inputValue, inputEvents }">
                    <input
                        class="form-control px-2 py-1 border rounded focus:outline-none focus:border-blue-300"
                        :value="inputValue"
                        v-on="inputEvents"
                    />
                </template>
            </vc-date-picker>
        </div>

        <div id="saveActions" class="form-group settings-actions">
            <button @click="handleSubmit" :disabled="!DDSData.dates.length" type="button" class="btn btn-success">
                <span class="la la-cloud-upload-alt" role="presentation" aria-hidden="true"></span> &nbsp;
                <span data-value="save_and_edit">Import Data</span>
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'DDS',
    data: () => ({
        masks: {
            inputDateTime: 'DD-MM-YYYY HH:mm:ss',
        },
        popover: {
            visibility: 'focus',
        },
        dds_dates: [],
        DDSData: {
            tab: 'dds',
            dates: [],
            schedule_time: '',
        },
    }),
    mounted() {
        this.dds_dates = JSON.parse(this.$parent.dds_dates);
    },
    methods: {
        handleSubmit() {
            if (this.DDSData.dates.length < 1) {
                alert('Please select an file(s)');
                return;
            }

            this.dds_dates = this.dds_dates.filter((file) => !this.DDSData.dates.includes(file));

            this.$parent.saveCoreConfigInfo(this.DDSData);

            this.DDSData.dates = [];
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
