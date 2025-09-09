<template>
    <div role="tabpanel" class="tab-pane active" id="tab_basic-info">
        <fieldset>
            <div class="d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
                <legend>
                    <i class="la la-cloud mr-2"></i>
                    Storage Disk Configuration
                </legend>
                <div class="d-md-none custom-sidebar-ar" @click="$parent.toggleSidebar()">
                    <div class="menu-icon-ar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="#1b2a4e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-menu">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </div>
                    <div class="close-icon-ar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>File Manager Display Disks</label>
                <multiselect v-model="file_manager_disks"
                             :options="$parent.coreConfigurationData.constant.available_disks"
                             :multiple="true"
                             label="label"
                             track-by="name"
                             :close-on-select="false"
                             :clear-on-select="false"
                             :preserve-search="true"
                             :hide-selected="true"
                >
                </multiselect>
                <small v-if="$parent.validationErrors.file_manager_disks"
                       class="text-danger mt-3">
                    {{ $parent.validationErrors.file_manager_disks[0] }}
                </small>
            </div>

            <div class="accordion" id="accordion-storage">
                <div class="card">
                    <div class="card-header p-2" id="heading-upload">
                        <h4 class="mb-0" data-toggle="collapse"
                            data-target="#collapse-upload" aria-expanded="true" aria-controls="collapse-upload">
                            Upload Disk
                        </h4>
                    </div>
                    <div id="collapse-upload" class="collapse show" aria-labelledby="heading-upload"
                         data-parent="#accordion-storage">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Driver</label>
                                <select name="uploads[driver]" class="form-control custom-select"
                                        v-model="storageConfigurationData.uploads.driver">
                                    <option v-for="(driver, key) in drivers" :value="key" :key="key">
                                        {{ driver }}
                                    </option>
                                </select>
                                <small v-if="$parent.validationErrors.uploads?.driver" class="text-danger mt-3">{{
                                        $parent.validationErrors.uploads.driver[0]
                                    }}</small>
                            </div>

                            <!-- S3 Storage -->
                            <section v-if="storageConfigurationData.uploads.driver === 's3'">
                                <div class="form-group">
                                    <div>
                                        <label>Access Key</label>
                                        <input :type="accessKeyFieldType" name="uploads[key]"
                                               placeholder="Enter Access Key"
                                               v-model="storageConfigurationData.uploads.key" class="form-control"
                                               :class="{ 'is-invalid': $parent.validationErrors.key }">
                                        <i @click="toggleAccessKeyShow"
                                           :class="{ 'eye-position fas fa-eye-slash': showAccessKey, 'eye-position fas fa-eye': !showAccessKey }"></i>
                                        <small v-if="$parent.validationErrors.uploads?.key" class="text-danger mt-3">{{
                                                $parent.validationErrors.uploads?.key[0]
                                            }}</small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div>
                                        <label>Access Secret</label>
                                        <input :type="secretAccessKeyFieldType" name="secret_access_key"
                                               placeholder="Enter secret_access_key"
                                               v-model="storageConfigurationData.uploads.secret" class="form-control"
                                               :class="{ 'is-invalid': $parent.validationErrors.uploads?.secret }">
                                        <i @click="toggleSecretShow"
                                           :class="{ 'eye-position fas fa-eye-slash': showSecretAccessKey, 'eye-position fas fa-eye': !showSecretAccessKey }"></i>

                                        <small v-if="$parent.validationErrors.uploads?.secret" class="text-danger mt-3">{{
                                                $parent.validationErrors.uploads?.secret[0]
                                            }}</small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div>
                                        <label>Region</label>
                                        <input type="text" name="uploads[region]" placeholder="Enter Default Region"
                                               v-model="storageConfigurationData.uploads.region" class="form-control"
                                               :class="{ 'is-invalid': $parent.validationErrors.uploads?.region }">
                                        <small v-if="$parent.validationErrors.uploads?.region" class="text-danger mt-3">{{
                                                $parent.validationErrors.uploads?.region[0]
                                            }}</small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div>
                                        <label>Bucket</label>
                                        <input type="text" name="bucket" placeholder="Enter Bucket"
                                               v-model="storageConfigurationData.uploads.bucket" class="form-control"
                                               :class="{ 'is-invalid': $parent.validationErrors.uploads?.bucket }">
                                        <small v-if="$parent.validationErrors.uploads?.bucket" class="text-danger mt-3">{{
                                                $parent.validationErrors.uploads?.bucket[0]
                                            }}</small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div>
                                        <label>Url</label>
                                        <input type="text" name="url" placeholder="Enter Url"
                                               v-model="storageConfigurationData.uploads.url" class="form-control"
                                               :class="{ 'is-invalid': $parent.validationErrors.uploads?.url }" :disabled="true">
                                        <small v-if="$parent.validationErrors.uploads?.url" class="text-danger mt-3">{{
                                                $parent.validationErrors.uploads?.url[0]
                                            }}</small>
                                    </div>
                                </div>
                            </section>

                            <!-- OSS Storage -->

                            <!-- One Drive Storage -->
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header p-2" id="heading-backup">
                        <h4 class="mb-0 collapsed" data-toggle="collapse"
                            data-target="#collapse-backup" aria-expanded="false" aria-controls="collapse-backup">
                            Backup Disk
                        </h4>
                    </div>
                    <div id="collapse-backup" class="collapse" aria-labelledby="heading-backup"
                         data-parent="#accordion-storage">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Driver</label>
                                <select name="backups[driver]" class="form-control custom-select"
                                        v-model="storageConfigurationData.backups.driver">
                                    <option v-for="(driver, key) in drivers" :value="key" :key="key">
                                        {{ driver }}
                                    </option>
                                </select>
                                <small v-if="$parent.validationErrors.backups?.driver" class="text-danger mt-3">{{
                                        $parent.validationErrors.backups.driver[0]
                                    }}</small>
                            </div>

                            <!-- S3 Storage -->
                            <section v-if="storageConfigurationData.backups.driver === 's3'">
                                <div class="form-group">
                                    <div>
                                        <label>Access Key</label>
                                        <input :type="accessKeyFieldType" name="backups[key]"
                                               placeholder="Enter Access Key"
                                               v-model="storageConfigurationData.backups.key" class="form-control"
                                               :class="{ 'is-invalid': $parent.validationErrors.key }">
                                        <i @click="toggleAccessKeyShow"
                                           :class="{ 'eye-position fas fa-eye-slash': showAccessKey, 'eye-position fas fa-eye': !showAccessKey }"></i>
                                        <small v-if="$parent.validationErrors.backups?.key" class="text-danger mt-3">{{
                                                $parent.validationErrors.backups?.key[0]
                                            }}</small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div>
                                        <label>Access Secret</label>
                                        <input :type="secretAccessKeyFieldType" name="secret_access_key"
                                               placeholder="Enter secret_access_key"
                                               v-model="storageConfigurationData.backups.secret" class="form-control"
                                               :class="{ 'is-invalid': $parent.validationErrors.backups?.secret }">
                                        <i @click="toggleSecretShow"
                                           :class="{ 'eye-position fas fa-eye-slash': showSecretAccessKey, 'eye-position fas fa-eye': !showSecretAccessKey }"></i>

                                        <small v-if="$parent.validationErrors.backups?.secret" class="text-danger mt-3">{{
                                                $parent.validationErrors.backups?.secret[0]
                                            }}</small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div>
                                        <label>Region</label>
                                        <input type="text" name="backups[region]" placeholder="Enter Default Region"
                                               v-model="storageConfigurationData.backups.region" class="form-control"
                                               :class="{ 'is-invalid': $parent.validationErrors.backups?.region }">
                                        <small v-if="$parent.validationErrors.backups?.region" class="text-danger mt-3">{{
                                                $parent.validationErrors.backups?.region[0]
                                            }}</small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div>
                                        <label>Bucket</label>
                                        <input type="text" name="bucket" placeholder="Enter Bucket"
                                               v-model="storageConfigurationData.backups.bucket" class="form-control"
                                               :class="{ 'is-invalid': $parent.validationErrors.backups?.bucket }">
                                        <small v-if="$parent.validationErrors.backups?.bucket" class="text-danger mt-3">{{
                                                $parent.validationErrors.backups?.bucket[0]
                                            }}</small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div>
                                        <label>Url</label>
                                        <input type="text" name="url" placeholder="Enter Url"
                                               v-model="storageConfigurationData.backups.url" class="form-control"
                                               :class="{ 'is-invalid': $parent.validationErrors.backups?.url }" :disabled="true">
                                        <small v-if="$parent.validationErrors.backups?.url" class="text-danger mt-3">{{
                                                $parent.validationErrors.backups?.url[0]
                                            }}</small>
                                    </div>
                                </div>
                            </section>

                            <!-- OSS Storage -->

                            <!-- One Drive Storage -->
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <div id="saveActions" class="form-group mt-3">
            <button @click="$parent.saveCoreConfigInfo(storageConfigurationData)" type="button"
                    class="btn btn-success">
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
import Multiselect from "vue-multiselect";

import '@riophae/vue-treeselect/dist/vue-treeselect.css';

export default {
    name: "Storage",

    components: {Multiselect},

    data() {
        return {
            file_manager_disks: [],

            drivers: {
                local: "Default",
                s3: "Amazon S3"
                // oss: "Alibaba OSS",
                // onedrive: "Microsoft Onedrive",
            },

            showSecretAccessKey: false,
            showAccessKey: false,

            secretAccessKeyFieldType: "password",
            accessKeyFieldType: "password",

            storageConfigurationData: {
                tab: 'storage',
                file_manager_disks: [],
                uploads: {
                    driver: 'local',
                    url: '',
                    key: '',
                    secret: '',
                    region: '',
                    bucket: '',
                    endpoint: '',
                    use_path_style_endpoint: '',
                    folder_name: ''
                },
                backups: {
                    driver: 'local',
                    url: '',
                    key: '',
                    secret: '',
                    region: '',
                    bucket: '',
                    endpoint: '',
                    use_path_style_endpoint: '',
                    folder_name: ''
                }
            },
        }
    },

    mounted() {
        //mark selected disks on
        for (const disk of this.$parent.coreConfigurationData.storage.file_manager_disks) {
            for (const item of this.$parent.coreConfigurationData.constant.available_disks) {
                if (item.name === disk) {
                    this.file_manager_disks.push(item);
                }
            }
        }

        this.setValue(this.$parent.coreConfigurationData.storage);
    },

    methods: {
        setValue(storage) {
            this.storageConfigurationData.uploads = storage.uploads ?? {};
            this.storageConfigurationData.backups = storage.backups ?? {};
        },
        toggleSecretShow() {
            this.showSecretAccessKey = !this.showSecretAccessKey;
            this.secretAccessKeyFieldType = this.secretAccessKeyFieldType === "password" ? "text" : "password";
        },

        toggleAccessKeyShow() {
            this.showAccessKey = !this.showAccessKey;
            this.accessKeyFieldType = this.accessKeyFieldType === "password" ? "text" : "password";
        },
        generateS3Url(conf) {
            if (conf.driver === 's3' && conf.bucket && conf.region) {
                conf.url = `https://${conf.bucket}.s3.${conf.region}.amazonaws.com`;
            } else {
                conf.url = null;
            }
        }
    },

    watch: {
        file_manager_disks: function (newValues, oldValues) {
            this.storageConfigurationData.file_manager_disks = [];
            for (let disk of newValues) {
                this.storageConfigurationData.file_manager_disks.push(disk.name);
            }
        },
        "storageConfigurationData.uploads": {
            handler: function(conf) {
                this.generateS3Url(conf);
            },
            deep: true
        },
        "storageConfigurationData.backups": {
            handler: function(conf) {
                this.generateS3Url(conf);
            },
            deep: true
        }
    }
}
</script>
