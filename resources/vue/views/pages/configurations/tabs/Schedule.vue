<template>
    <div role="tabpanel" class="tab-pane active settings-pane" id="tab_basic-info">
        <fieldset class="settings-shell">
            <div class="settings-header d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
                <legend>
                    <i class="la la-calendar mr-2"></i>
                    Scheduled Tasks
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
                <label>Select Time zone</label>
                <div>
                    <multiselect
                        v-model="multiTimezone"
                        deselect-label="Can't remove this value"
                        track-by="name"
                        label="name"
                        placeholder="Select one"
                        :options="timeZone"
                        :multiple="false"
                        @select="selectTimeZone"
                        :clear-on-select="false"
                        :allow-empty="false"
                        :preserve-search="true"
                    >
                        <template slot="option" slot-scope="{ option }">
                            {{ option.name }} ({{ option.offset }})
                        </template>
                    </multiselect>
                </div>
            </div>

            <div class="form-group">
                <label>Select Command</label>
                <select
                    name="default_schedule"
                    class="form-control custom-select"
                    v-model="scheduleConfigurationData.default_command"
                    @change="updateScheduleInfo"
                >
                    <option
                        :value="index"
                        v-for="(pg, index) in $parent.coreConfigurationData.schedule.labels"
                        :key="index"
                        :selected="index === scheduleConfigurationData.default_command"
                    >
                        {{ pg }}
                    </option>
                </select>
            </div>

            <div class="form-group">
                <div class="d-flex align-items-center pt-2 pb-2">
                    <label for="priority" class="form-label m-0 pr-3">
                        Priority({{ scheduleConfigurationData.priority }})</label
                    >
                    <input
                        type="range"
                        style="
                            :focus {
                                border: 0;
                                box-shadow: 0 0 0 0 #ffffff;
                            }
                        "
                        class="form-range form-control mr-3"
                        min="1"
                        max="10"
                        id="priority"
                        @change="checkPriority"
                        :value="scheduleConfigurationData.priority"
                    />
                </div>
            </div>

            <div class="form-group">
                <label>Select Interval</label>
                <select
                    name="default_schedule"
                    class="form-control custom-select"
                    v-model="scheduleConfigurationData.interval"
                >
                    <option
                        :value="pg.value"
                        v-for="pg in $parent.coreConfigurationData.constant.intervals"
                        :key="pg.name"
                        :selected="pg.value === scheduleConfigurationData.interval"
                    >
                        {{ pg.name }}
                    </option>
                </select>
            </div>

            <div class="d-block" v-if="scheduleConfigurationData.interval === 'cron'">
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 col-lg-4">
                        <label>Minute</label>
                        <select
                            name="default_schedule"
                            class="form-control custom-select"
                            v-model="scheduleConfigurationData.time.minute"
                        >
                            <option
                                :value="index"
                                v-for="(pg, index) in $parent.coreConfigurationData.constant.minutes"
                                :key="index"
                                :selected="index === scheduleConfigurationData.time.minute"
                            >
                                {{ pg }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group col-sm-12 col-md-6 col-lg-2">
                        <label>Hour</label>
                        <select
                            name="default_schedule"
                            class="form-control custom-select"
                            v-model="scheduleConfigurationData.time.hour"
                        >
                            <option
                                :value="index"
                                v-for="(pg, index) in $parent.coreConfigurationData.constant.hours"
                                :key="index"
                                :selected="index === scheduleConfigurationData.time.hour"
                            >
                                {{ pg }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group col-sm-12 col-md-6 col-lg-2">
                        <label>Day</label>
                        <select
                            name="default_schedule"
                            class="form-control custom-select"
                            v-model="scheduleConfigurationData.time.day"
                        >
                            <option
                                :value="index"
                                v-for="(pg, index) in $parent.coreConfigurationData.constant.days"
                                :key="index"
                                :selected="index === scheduleConfigurationData.time.day"
                            >
                                {{ pg }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group col-sm-12 col-md-6 col-lg-2">
                        <label>Month</label>
                        <select
                            name="default_schedule"
                            class="form-control custom-select"
                            v-model="scheduleConfigurationData.time.month"
                        >
                            <option
                                :value="index"
                                v-for="(pg, index) in $parent.coreConfigurationData.constant.months"
                                :key="index"
                                :selected="index === scheduleConfigurationData.time.month"
                            >
                                {{ pg }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group col-sm-12 col-md-12 col-lg-2">
                        <label>Weekday</label>
                        <select
                            name="default_schedule"
                            class="form-control custom-select"
                            v-model="scheduleConfigurationData.time.weekday"
                        >
                            <option
                                :value="index"
                                v-for="(pg, index) in $parent.coreConfigurationData.constant.weekdays"
                                :key="index"
                                :selected="index === scheduleConfigurationData.time.weekday"
                            >
                                {{ pg }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label> Parameters (JSON) </label>
                <prism-editor
                    class="my-editor"
                    v-model="scheduleConfigurationData.variables"
                    :highlight="highlighter"
                    :line-numbers="true"
                ></prism-editor>
                <p v-if="jsonErrorMessage" class="error mt-1">{{ jsonErrorMessage }}</p>
                <p class="text-muted mt-1">
                    Note: Please use this value if the argument has no value
                    <code class="user-select-all">"--no-arg-val--"</code>
                </p>
            </div>

            <div class="form-group">
                <input
                    type="checkbox"
                    name="multiple_warehouse"
                    v-model="scheduleConfigurationData.enabled"
                    :class="{ 'is-invalid': $parent.validationErrors.enabled }"
                />
                <span>Enable</span>
                <small v-if="$parent.validationErrors.enabled" class="text-danger mt-3">{{
                    $parent.validationErrors.enabled[0]
                }}</small>
            </div>

            <div class="form-group">
                <input
                    type="checkbox"
                    name="logger_enabled"
                    v-model="scheduleConfigurationData.logger_enabled"
                    :class="{ 'is-invalid': $parent.validationErrors.logger_enabled }"
                />
                <span>Enable Schedule API Log</span>
                <small v-if="$parent.validationErrors.logger_enabled" class="text-danger mt-3">{{
                    $parent.validationErrors.logger_enabled[0]
                }}</small>
            </div>
        </fieldset>
        <div id="saveActions" class="form-group settings-actions">
            <button
                @click="$parent.saveCoreConfigInfo(scheduleConfigurationData)"
                type="button"
                class="btn btn-success"
                :disabled="hasError"
            >
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
import '@riophae/vue-treeselect/dist/vue-treeselect.css';
import { highlight } from 'prismjs';
import 'prismjs/components/prism-json';
import { PrismEditor } from 'vue-prism-editor';
import 'vue-prism-editor/dist/prismeditor.min.css';

export default {
    name: 'Schedule',
    components: { Multiselect, PrismEditor },

    data() {
        return {
            timezones: {},
            scheduleConfigurationData: {
                tab: 'schedule',
                default_command: Object.keys(this.$parent.coreConfigurationData.schedule.commands)[0] ?? 'product_sync',
                enabled: false,
                interval: '',
                priority: '',
                variables: JSON.stringify({}),
                timezone: this.$parent.coreConfigurationData.schedule.timezone ?? 'UTC',
                logger_enabled: this.$parent.coreConfigurationData.schedule.logger_enabled ?? false,
                time: {
                    minute: '',
                    hour: '',
                    day: '',
                    month: '',
                    weekday: '',
                },
            },
            multiTimezone: '',
            jsonErrorMessage: '',
        };
    },

    mounted() {
        this.timezones = this.sortObject(this.$parent.coreConfigurationData.constant.timezone);
        this.setMultiTimeZone();
        this.setValue(
            this.scheduleConfigurationData.default_command,
            this.$parent.coreConfigurationData.schedule.commands,
        );
    },
    computed: {
        timeZone() {
            return Object.values(this.timezones);
        },
        hasError() {
            return !!this.jsonErrorMessage; // Converts errorMessage to a boolean
        },
    },

    methods: {
        setMultiTimeZone() {
            this.multiTimezone = this.timeZone.find(
                (item) => item.name === this.$parent.coreConfigurationData.schedule.timezone ?? 'UTC',
            );
        },
        selectTimeZone(selectedOption) {
            this.scheduleConfigurationData.timezone = selectedOption.name;
        },
        updateScheduleInfo(event) {
            this.setValue(event.target.value, this.$parent.coreConfigurationData.schedule.commands);
        },
        highlighter(code) {
            return highlight(code, Prism.languages.json, 'json'); // Returns highlighted HTML
        },
        checkPriority(event) {
            for (const [key, value] of Object.entries(this.$parent.coreConfigurationData.schedule.commands)) {
                if (key !== this.scheduleConfigurationData.default_command) {
                    if (parseInt(value.priority) === parseInt(event.target.value)) {
                        event.target.value = this.scheduleConfigurationData.priority;
                        return;
                    }
                }
            }
            this.scheduleConfigurationData.priority = event.target.value;
        },
        setValue(schedule, configurations) {
            for (const [key, value] of Object.entries(configurations)) {
                if (key === schedule) {
                    this.scheduleConfigurationData.logger_enabled = value.logger_enabled ?? false;
                    this.scheduleConfigurationData.enabled = value.enabled ?? false;
                    this.scheduleConfigurationData.priority = value.priority ?? 1;
                    this.scheduleConfigurationData.interval = value.interval ?? false;
                    this.scheduleConfigurationData.variables = JSON.stringify(value.variables ?? {});
                    this.scheduleConfigurationData.time = value.time ?? {};
                    if (value.interval !== 'cron') {
                        this.scheduleConfigurationData.time = {};
                    }
                }
            }
        },
        sortObject(o) {
            var sorted = {},
                key,
                a = [];

            for (key in o) {
                if (o.hasOwnProperty(key)) {
                    a.push(key);
                }
            }

            a.sort();

            for (key = 0; key < a.length; key++) {
                sorted[a[key]] = o[a[key]];
            }
            return sorted;
        },
        validateJson(string) {
            try {
                JSON.parse(string);
                this.jsonErrorMessage = '';
            } catch (e) {
                this.jsonErrorMessage = 'Invalid JSON: ' + e.message;
            }
        },
    },
    watch: {
        'scheduleConfigurationData.variables': function (newVal) {
            this.validateJson(newVal);
        },
    },
};
</script>

<style>
.my-editor {
    background: #2d2d2d;
    color: #ccc;
    font-family:
        Fira code,
        Fira Mono,
        Consolas,
        Menlo,
        Courier,
        monospace;
    font-size: 14px;
    line-height: 1.5;
    padding: 5px;
    border-radius: 5px;
}

.prism-editor__textarea:focus {
    outline: none;
}

.height-300 {
    height: 300px;
}

.prism-editor__editor {
    color: #ccc;
}

.error {
    color: red;
}

.user-select-all {
    user-select: all;
}
</style>

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
