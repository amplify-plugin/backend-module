<template>
    <div class="row" id="importCreate">
        <div :class="class_name">
            <!-- Default box -->
            <form method="post" :action="backUrl">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group" :class="{ 'text-danger': validationErrors.import_definition_id }">
                            <div class="d-flex justify-content-between mb-1">
                                <label>Import Definition <span class="text-danger font-weight-bold">*</span></label>
                                <div v-if="method !== 'put'">
                                    <a
                                        class="btn btn-sm btn-link float-right inline-create-button"
                                        :href="import_definition_create_route"
                                    >
                                        <i class="la la-plus"></i> Add
                                    </a>
                                    <!--                                        <button @click="getImportDefinitions()" type="button"-->
                                    <!--                                                class="btn btn-default btn-sm"><i :class="{'la-pulse': loader}"-->
                                    <!--                                                                                  class="las la-sync"></i>-->
                                    <!--                                        </button>-->
                                </div>
                            </div>
                            <!--                              @input="removeError('import_definition_id'); activeImportDefinition = ''"-->

                            <select
                                v-model="importJob.import_definition_id"
                                :disabled="method === 'put'"
                                :class="{ 'is-invalid': validationErrors.import_definition_id }"
                                class="form-control select2_field select2-hidden-accessible"
                            >
                                <option
                                    v-for="(importDefinition, index) in importDefinitions"
                                    :key="index"
                                    :disabled="importDefinition.id == ''"
                                    :value="importDefinition.id"
                                >
                                    {{ importDefinition.name }}
                                </option>
                            </select>
                            <small v-if="validationErrors.import_definition_id" class="text-danger mt-3">{{
                                validationErrors.import_definition_id[0]
                            }}</small>
                        </div>

                        <div class="form-group" :class="{ 'text-danger': validationErrors.locale }">
                            <div class="d-flex justify-content-between">
                                <label>Locale <span class="text-danger font-weight-bold">*</span></label>
                            </div>
                            <!--                              @input="removeError('locale');"-->
                            <select
                                v-model="importJob.locale"
                                :disabled="method === 'put'"
                                :class="{ 'is-invalid': validationErrors.locale }"
                                class="form-control select2_field select2-hidden-accessible"
                            >
                                <option v-for="(locales, index) in availableLocales" :key="index" :value="index">
                                    {{ locales }}
                                </option>
                            </select>
                            <small v-if="validationErrors.locale" class="text-danger mt-3">{{
                                validationErrors.locale[0]
                            }}</small>
                        </div>

                        <div class="form-group" :class="{ 'text-danger': validationErrors.description }">
                            <div class="d-flex justify-content-between">
                                <label>Description</label>
                            </div>
                            <textarea
                                v-model="importJob.description"
                                @input="removeError('locale')"
                                class="form-control"
                                :class="{ 'is-invalid': validationErrors.description }"
                                rows="3"
                            >
                            </textarea>
                            <small v-if="validationErrors.description" class="text-danger mt-3">{{
                                validationErrors.description[0]
                            }}</small>
                        </div>

                        <div class="form-group">
                            <div class="d-flex justify-content-between">
                                <label
                                    >Schedule Time <small class="text-primary">({{ timezone }})</small></label
                                >
                            </div>

                            <vc-date-picker
                                v-model="importJob.schedule_time"
                                mode="dateTime"
                                :timezone="timezone.toLowerCase()"
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

                        <div class="form-group mb-0" :class="{ 'text-danger': validationErrors.file_path }">
                            <label>
                                Import {{ activeImportDefinition.file_type }}
                                <span class="text-danger font-weight-bold">*</span>
                                <small
                                    class=""
                                    v-if="
                                        typeof activeImportDefinition.file_type !== 'undefined' &&
                                        activeImportDefinition.file_type
                                    "
                                    v-html="
                                        `(Please select a .${activeImportDefinition.file_type} file <strong>
                                                    ${
                                                        activeImportDefinition.is_column_heading ? 'with' : 'without'
                                                    } column heading </strong>)`
                                    "
                                ></small>
                            </label>
                            <br />
                            <div class="btn-group btn-block border rounded">
                                <div id="fileChooseImportJobsDiv" class="d-none">
                                    <label
                                        title="select file"
                                        for="fileChooseImportJobs"
                                        class="btn btn-light btn-sm btn-file py-2 mb-0 cursor-pointer border-right-0"
                                    >
                                        Upload File
                                        <input
                                            id="fileChooseImportJobs"
                                            type="file"
                                            name="fileImportJobs"
                                            @input="removeError('file_path')"
                                            @change="makeFileChuckAble()"
                                            :accept="`.${activeImportDefinition.file_type}`"
                                            class="form-control d-none file_design"
                                        />
                                    </label>
                                </div>
                                <div>
                                    <button
                                        id="fileChooseEditImportJobs"
                                        type="button"
                                        @click="
                                            file = null;
                                            uploadFileInEditMode();
                                        "
                                        class="btn btn-light btn-sm btn-file py-2 mb-0"
                                    >
                                        <strong> Upload File </strong>
                                    </button>
                                    <strong class="mx-3" v-if="!processingFile">
                                        <span v-if="method === 'put' && oldFilePath === importJob.file_path">
                                            <a
                                                class="text-success"
                                                title="Click to download"
                                                href="#"
                                                @click="downloadFile(importJob.file_path)"
                                            >
                                                <i class="la la-download mr-1"></i>
                                                {{ importJob.file_path }}
                                            </a>
                                        </span>
                                        <span v-else>
                                            {{ importJob.file_path }}
                                        </span>
                                        <span v-if="importJob.file_path" class="text-primary">
                                            (Total Rows: {{ importJob.row_count }})
                                        </span>
                                    </strong>
                                </div>
                            </div>
                            <div :style="`visibility: ${progress > 0 ? '' : 'hidden'}`" class="progress mt-3">
                                <div
                                    class="progress-bar"
                                    :class="getBarColor()"
                                    role="progressbar"
                                    :style="`width: ${progress}%`"
                                    :aria-valuenow="progress"
                                    aria-valuemin="0"
                                    aria-valuemax="100"
                                >
                                    {{ this.progress === 100 && this.processingFile ? processingText : `${progress}%` }}
                                </div>
                            </div>
                            <small v-if="validationErrors.file_path" class="text-danger mt-3">{{
                                validationErrors.file_path[0]
                            }}</small>
                        </div>
                    </div>
                </div>
                <div id="saveActions" class="form-group">
                    <input type="hidden" name="save_action" value="save_and_back" v-model="actionType" />
                    <div class="btn-group" role="group">
                        <button
                            type="button"
                            class="btn btn-success"
                            :disabled="loadingWhenSave || busy"
                            @click="
                                actionType = 'save_and_back';
                                saveData();
                            "
                        >
                            <span v-if="loadingWhenSave" class="text-center">
                                <i class="spinner-border spinner-border-sm my-1" role="status" aria-hidden="true"> </i>
                                <span class="sr-only">Loading...</span>
                                Saving...
                            </span>
                            <span v-else data-value="save_and_back">
                                <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp; Save and
                                back
                            </span>
                        </button>

                        <button
                            v-if="method === 'put'"
                            type="button"
                            class="btn btn-warning ml-1"
                            :disabled="loadingWhenSaveAndRetry || busy"
                            @click="
                                actionType = 'save_and_retry';
                                saveData();
                            "
                        >
                            <span v-if="loadingWhenSaveAndRetry" class="text-center">
                                <i class="spinner-border spinner-border-sm my-1" role="status" aria-hidden="true"> </i>
                                <span class="sr-only">Loading...</span>
                                Saving...
                            </span>
                            <span v-else data-value="save_and_retry">
                                <span class="las la-retweet" role="presentation" aria-hidden="true"></span> &nbsp; Save
                                and retry
                            </span>
                        </button>
                    </div>

                    <a :href="backUrl" class="btn btn-default"><span class="la la-ban"></span> &nbsp;Cancel</a>
                </div>
            </form>
        </div>
        <InlineCreateImportDefinition
            ref="inlineCreateImportDefinition"
            axios_url="/admin/import-definition/inline/create"
            :locale="locale"
        ></InlineCreateImportDefinition>

        <!-- Show Sample Modal -->
        <ShowSampleModal ref="showSampleModal"></ShowSampleModal>
    </div>
</template>

<script>
import AvailableLocales from '../../components/AvailableLocales';
import FormFields from './definition/FormFields';
import ShowSampleModal from './definition/ShowSampleModal';
import InlineCreateImportDefinition from './definition/InlineCreate';
import _ from 'lodash';

export default {
    name: 'ImportCreate',
    components: { ShowSampleModal, InlineCreateImportDefinition, FormFields, AvailableLocales },
    props: [
        'url',
        'axios_url',
        'query_string',
        'class_name',
        'method',
        'import_definition',
        'import_job_data',
        'locale',
        'import_definition_create_route',
        'available_locales',
        'timezone',
    ],

    data() {
        return {
            activeImportDefinition: {},
            importJob: {
                import_definition_id: '',
                locale: 'en',
                schedule_time: null,
                row_count: 0, // row count is job count
            },
            busy: false,
            processingFile: false,
            processingText: 'Processing...',
            eachPieceContains: 1000,
            importDefinitions: JSON.parse(this.import_definition),
            availableLocales: JSON.parse(this.available_locales),
            acceptFileType: '.csv',
            backUrl: '/admin/import-job',
            newUrl: '/admin/import-job/create',
            actionType: 'save_and_back',
            actionTypes: ['save_and_back', 'save_and_retry'],
            validationErrors: {},

            chunks: [],
            uploaded: 0,
            chunkedFilePath: null,
            showButtonDuringEdit: false,
            file: null,
            testFile: null,
            loader: false,
            oldFilePath: '',
            storageLocation: window.location.origin + '/storage/',
            masks: {
                inputDateTime: 'DD-MM-YYYY HH:mm:ss',
            },
            popover: {
                visibility: 'focus',
            },
            loadingWhenSave: false,
            loadingWhenSaveAndRetry: false,
        };
    },
    created() {
        this.importDefinitions.unshift({ id: '', name: 'Please select an import definition.' });
        if (this.method === 'put') {
            this.initEdit();
        }
    },
    methods: {
        getBarColor() {
            return this.progress === 100 && !this.processingFile ? 'bg-success' : '';
        },
        initEdit() {
            let importJobData = JSON.parse(this.import_job_data);
            this.importJob = {
                id: importJobData.id,
                import_definition_id: importJobData.import_definition_id,
                locale: importJobData.locale,
                description: importJobData.description,
                file_path: importJobData.file_path,
                schedule_time: importJobData.schedule_time,
                row_count: importJobData.row_count,
            };

            this.oldFilePath = importJobData.file_path;
        },

        uploadFileInEditMode() {
            if (_.isNull(this.importJob.import_definition_id)) {
                this.validationErrors = {
                    import_definition_id: ['Please select import definition first'],
                };
                return;
            }
            document.querySelector('#fileChooseImportJobs').click();
        },

        getImportDefinitions() {
            this.loader = true;
            axios
                .post('/admin/import-job/fetch/import-definitions')
                .then((response) => {
                    this.importDefinitions = response.data;
                    console.log(this.importDefinitions);
                })
                .catch((err) => {
                    console.error(err);
                })
                .finally(() => {
                    this.loader = false;
                });
        },

        saveData() {
            this.actionType === 'save_and_back' ? (this.loadingWhenSave = true) : (this.loadingWhenSaveAndRetry = true);

            this.validationErrors = {};

            let params = {
                id: this.importJob.id ?? '',
                import_definition_id: this.importJob.import_definition_id,
                locale: this.importJob.locale,
                description: this.importJob.description ?? '',
                schedule_time: this.importJob.schedule_time,
                row_count: this.importJob.row_count ?? 0,
                chunk_size: this.importJob.chunk_size ?? this.eachPieceContains,
                file_path: this.importJob.file_path,
                retry: this.actionType === 'save_and_retry',
            };

            axios[this.method](`${this.axios_url}?locale=${this.locale}`, params)
                .then((response) => {
                    let message =
                        this.actionType === 'save_and_retry'
                            ? 'Updated and pushed back onto the queue!'
                            : 'Saved successfully!';
                    new Noty({
                        type: 'success',
                        text: message,
                    }).show();

                    this.validationErrors = '';

                    window.location = this.actionTypes.includes(this.actionType) ? this.backUrl : this.newUrl;
                })
                .catch((err) => {
                    this.validationErrors = err.response.data.errors;
                    new Noty({
                        type: 'error',
                        text: err.response.data.message,
                    }).show();
                    console.error(err);
                })
                .finally(() => {
                    this.actionType === 'save_and_back'
                        ? (this.loadingWhenSave = false)
                        : (this.loadingWhenSaveAndRetry = false);
                });
        },

        removeError(key) {
            let errorsObject = this.validationErrors;
            let errorExist = errorsObject[key];
            if (errorExist) {
                delete errorsObject[key];
            }
            if (Object.keys(errorsObject).length <= 0) {
                this.validationErrors = '';
            }
            this.validationErrors = errorsObject;
        },

        downloadFile(file_path) {
            let dataURL = this.storageLocation + file_path;
            let filename = file_path.split('/').slice(-1)[0];
            const link = document.createElement('a');
            link.href = dataURL;
            link.download = filename;
            link.click();
        },

        //Start Chunk File Upload
        makeFileChuckAble() {
            setTimeout(() => {
                const place = document.querySelector("[name='fileImportJobs']");
                if (typeof place != 'undefined' && place != null) {
                    this.file = place.files[0];
                    this.createChunks();
                }
            }, 300);
        },

        uploadChunkFile() {
            this.busy = true;
            this.processingFile = true;
            axios(this.config)
                .then(({ data }) => {
                    this.chunks.shift();

                    if (!data.path.includes('.part')) {
                        this.chunkedFilePath = data.path;
                    }

                    if (data.path) {
                        this.importJob.file_path = data.path;
                        this.importJob.row_count = data.row_count;
                        this.busy = false;
                        this.createPieceContains();
                    }
                })
                .catch((error) => {
                    console.log(error);
                    this.processingText = 'Error!';
                })
                .finally(() => {
                    this.processingText = 'Processing...';
                });
        },

        createPieceContains() {
            this.processingFile = true;
            this.busy = true;

            let params = {
                chunk_size: this.eachPieceContains,
                row_count: this.importJob.row_count,
                file_path: this.importJob.file_path,
                import_definition_id: this.activeImportDefinition.id,
            };

            axios
                .post('/admin/import-job/fetch/make-pieces', params)
                .then((response) => {
                    // console.log(
                    //     response.data
                    // )
                    this.processingFile = false;
                })
                .catch((err) => {
                    console.error(err);
                    this.processingText = 'Error!';
                })
                .finally(() => {
                    this.processingFile = false;
                    this.busy = false;
                    this.processingText = 'Done!';
                });
        },

        createChunks() {
            if (this.file == null) {
                return;
            }
            let size = 1000000,
                chunks = Math.ceil(this.file.size / size);

            for (let i = 0; i < chunks; i++) {
                this.chunks.push(this.file.slice(i * size, Math.min(i * size + size, this.file.size), this.file.type));
            }
        },
        //End Chunk File Upload
    },
    watch: {
        'importJob.import_definition_id': function (newVal, oldVal) {
            let activeImportDefinition = [];
            if (newVal !== oldVal) {
                activeImportDefinition = this.importDefinitions.filter((ele) => {
                    return ele.id === newVal;
                });
                this.activeImportDefinition = _.first(activeImportDefinition);
            }
        },
        //Start Chunk File Upload
        chunks(newVal, oldVal) {
            if (newVal.length > 0) {
                this.uploadChunkFile();
            }
        },
        //End Chunk File Upload
    },
    computed: {
        //Start Chunk File Upload
        progress() {
            if (this.file == null) {
                return 0;
            }
            let progress = Math.floor((this.uploaded * 100) / this.file.size);
            return progress >= 100 ? 100 : progress;
        },
        formData() {
            let formData = new FormData();

            formData.set('is_last', this.chunks.length === 1);
            formData.set('file', this.chunks[0], `${this.file.name}.part`);
            formData.set('is_column_heading', this.activeImportDefinition.is_column_heading);
            formData.set('model_name', this.activeImportDefinition.import_type);

            return formData;
        },
        config() {
            return {
                method: 'POST',
                data: this.formData,
                url: '/admin/import-job/upload-file',
                headers: {
                    'Content-Type': 'application/octet-stream',
                },
                onUploadProgress: (event) => {
                    this.uploaded += event.loaded;
                },
            };
        },
        //End Chunk File Upload
    },
};
</script>

<style scoped>
.required-custom {
    color: red !important;
}
</style>
