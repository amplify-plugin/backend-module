<template>
    <div role="tabpanel" class="tab-pane active" id="tab_dds">
        <fieldset>
            <div class="d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
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

        <div id="saveActions" class="form-group">
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
