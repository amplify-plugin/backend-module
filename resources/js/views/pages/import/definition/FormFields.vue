<template>
    <div :class="className" :key="$parent.reRenderBody">
        <div class="form-group col-sm-12" :class="{ 'text-danger': $parent.validationErrors.name }">
            <label>Name <span class="text-danger font-weight-bold">*</span></label>
            <input
                @input="$parent.removeError('name')"
                type="text"
                name="name"
                v-model="$parent.importDefinition.name"
                value=""
                class="form-control"
                :class="{ 'is-invalid': $parent.validationErrors.name }"
            />
            <small v-if="$parent.validationErrors.name" class="text-danger mt-3">{{
                $parent.validationErrors.name[0]
            }}</small>
        </div>

        <div class="form-group col-sm-12">
            <label>File Type <span class="text-danger font-weight-bold">*</span></label>
            <select
                name="file_type"
                @change="$parent.onChangeFileType()"
                class="form-control"
                v-model="$parent.importDefinition.file_type"
            >
                <option value="CSV">CSV</option>
                <option value="SQL">SQL</option>
                <option value="JSON">JSON</option>
            </select>
        </div>

        <div class="form-group col-sm-12" :class="{ 'text-danger': $parent.validationErrors.import_type }">
            <label>Import Type <span class="text-danger font-weight-bold">*</span></label>
            <select
                @change="
                    $parent.onChangeImportType();
                    checkHasHierarchy();
                "
                :disabled="$parent.disableShowSample"
                name="import_type"
                :class="{ 'is-invalid': $parent.validationErrors.import_type }"
                class="form-control"
                v-model="$parent.importDefinition.import_type"
            >
                <option :value="importType.value" v-for="importType in $parent.importTypes">
                    {{ importType.title }}
                </option>
            </select>
            <small v-if="$parent.validationErrors.import_type" class="text-danger mt-3">{{
                $parent.validationErrors.import_type[0]
            }}</small>
        </div>

        <div class="form-group col-sm-12">
            <label>Description</label>
            <textarea name="description" v-model="$parent.importDefinition.description" class="form-control"></textarea>
        </div>

        <div class="form-group col-sm-12">
            <div class="checkbox">
                <input id="is_column_heading" type="checkbox" v-model="$parent.importDefinition.is_column_heading" />
                <label for="is_column_heading" class="form-check-label font-weight-normal"> Has Column Heading </label>
            </div>
        </div>

        <div class="form-group col-sm-12">
            <label>Required Fields </label><br />
            <div class="checkbox" v-for="(requiredField, index) in $parent.allRequiredFields">
                <label class="form-check-label font-weight-normal">
                    <input
                        :disabled="!$parent.showFileData"
                        type="checkbox"
                        @input="$parent.onChangeRequiredFields(index)"
                        v-model="requiredField.is_checked"
                    />
                    {{ requiredField.name }}
                </label>
            </div>
        </div>

        <div class="col-12">
            <div class="row">
                <div class="col-3 my-auto">
                    <div class="form-group m-0">
                        <div class="checkbox">
                            <input
                                id="has_hierarchy"
                                type="checkbox"
                                v-model="$parent.has_hierarchy"
                                :disabled="!_.includes($parent.allHierarchies, $parent.importDefinition.import_type)"
                                @change="resetImportFields()"
                            />
                            <label for="has_hierarchy" class="form-check-label font-weight-normal">
                                Has Hierarchy
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-9 d-flex" :class="{ 'disabled-wrapper': !$parent.has_hierarchy }">
                    <div class="mr-3 w-100">
                        <div class="form-group">
                            <label
                                >Import File Fields
                                <span v-if="$parent.has_hierarchy" class="text-danger font-weight-bold">*</span></label
                            >
                            <select
                                name="import_file_field"
                                class="form-control"
                                v-model="$parent.importDefinition.import_file_field"
                                :class="{ 'is-invalid': $parent.validationErrors.import_file_field }"
                                @change="$parent.removeError('import_file_field')"
                            >
                                <option value=""></option>
                                <option v-for="(field, index) in $parent.importFileFields" :key="index" :value="field">
                                    {{ field }}
                                </option>
                            </select>
                            <small v-if="$parent.validationErrors.import_file_field" class="text-danger">
                                {{ $parent.validationErrors.import_file_field[0] }}</small
                            >
                        </div>
                    </div>
                    <div class="mr-3 w-100">
                        <div class="form-group">
                            <label
                                >Import Type Fields
                                <span v-if="$parent.has_hierarchy" class="text-danger font-weight-bold">*</span></label
                            >
                            <select
                                name="import_type_field"
                                class="form-control"
                                v-model="$parent.importDefinition.import_type_field"
                                :class="{ 'is-invalid': $parent.validationErrors.import_type_field }"
                                @change="$parent.removeError('import_type_field')"
                            >
                                <option value=""></option>
                                <option v-for="(field, index) in $parent.importTypeFields" :key="index" :value="field">
                                    {{ field }}
                                </option>
                            </select>
                            <small v-if="$parent.validationErrors.import_type_field" class="text-danger">
                                {{ $parent.validationErrors.import_type_field[0] }}</small
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- File Uploading -->
        <div class="form-group col-sm-12">
            <label>
                Insert Demo {{ $parent.importDefinition.file_type }}
                <span class="text-danger font-weight-bold">*</span>
                <br />
                <small v-if="$parent.validationErrors.column_mapping" class="text-danger mt-3">{{
                    $parent.validationErrors.column_mapping[0]
                }}</small>
            </label>
            <br />
            <div class="btn-group" :key="$parent.reRenderFileUpload">
                <div id="fileChooseCreateDiv" class="">
                    <label
                        class="btn btn-light btn-sm btn-file py-2 mb-0 cursor-pointer"
                        :class="{ 'text-danger': $parent.validationErrors.column_mapping }"
                        title="select file"
                        for="fileChooseCreate"
                    >
                        Choose File
                        <input
                            id="fileChooseCreate"
                            type="file"
                            class="form-control d-none file_design"
                            ref="file"
                            name="file"
                            @input="$parent.removeError('column_mapping')"
                            :accept="$parent.acceptFileType"
                            @change="$parent.uploadFile($event)"
                        />
                    </label>
                </div>
                <div>
                    <button
                        id="fileChooseEdit"
                        type="button"
                        @click="$parent.uploadFileInEditMode()"
                        class="btn btn-light btn-sm btn-file py-2 mb-0 d-none"
                    >
                        <strong> Choose File </strong>
                    </button>
                </div>

                <span class="ml-1 mr-1 my-auto" v-if="$parent.importDefinition.file">
                    {{ $parent.fileName }}
                </span>
                <button
                    class="btn btn-light btn-sm"
                    data-toggle="tooltip"
                    data-placement="top"
                    data-original-title="Remove file"
                    title="Remove file"
                    v-if="$parent.importDefinition.file"
                    @click="$parent.deleteFile()"
                    type="button"
                >
                    <i class="la la-trash"></i>
                </button>
            </div>

            <div v-if="$parent.loading">
                <VueSkeletonLoader type="table" class="skeleton-loader-style" :height="40" animation="fade" />
                <VueSkeletonLoader type="table" class="skeleton-loader-style" :height="40" animation="fade" />
                <VueSkeletonLoader type="table" class="skeleton-loader-style" :height="40" animation="fade" />
                <VueSkeletonLoader type="table" class="skeleton-loader-style" :height="40" animation="fade" />
                <VueSkeletonLoader type="table" class="skeleton-loader-style" :height="40" animation="fade" />
                <VueSkeletonLoader type="table" class="skeleton-loader-style" :height="40" animation="fade" />
                <VueSkeletonLoader type="table" class="skeleton-loader-style" :height="40" animation="fade" />
                <VueSkeletonLoader type="table" class="skeleton-loader-style" :height="40" animation="fade" />
            </div>
            <div v-else>
                <div v-if="$parent.validationErrorInFieldData.length > 0" class="mt-3">
                    <div class="alert alert-danger" role="alert">
                        <span> Please, select below required field(s) in [ Field / Attribute Name ] dropdown... </span>
                        <ul class="m-0">
                            <li v-for="error in $parent.validationErrorInFieldData">
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div v-if="$parent.showFileData" class="text-center tableFixHead mt-3 rounded border">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th scope="col" class="text-left">Sl.</th>
                                <th scope="col" class="text-left">Input Field Name</th>
                                <th scope="col">Map To</th>
                                <th scope="col">Field / Attribute / Table Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(column, index) in $parent.columnNames">
                                <td class="text-left">{{ index + 1 }}.</td>
                                <td>
                                    <div class="form-group mb-0 d-flex">
                                        <input
                                            :id="`input_column_${index}`"
                                            type="text"
                                            v-model="column.column_name"
                                            :disabled="true"
                                            class="form-control"
                                            name="column_name"
                                        />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group mb-0" v-if="$parent.importDefinition.file">
                                        <select
                                            v-model="$parent.columnNames[index].map_to"
                                            name="map_to"
                                            class="form-control"
                                        >
                                            <option value="Field">Field</option>
                                            <option value="Attribute">Attribute</option>
                                            <option value="Table">Table</option>
                                            <option value="Ignore">Ignore</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group mb-0" v-if="$parent.importDefinition.file">
                                        <multiselect
                                            @select="
                                                $parent.joinOldData(
                                                    $parent.columnNames[index].field_or_attribute_name,
                                                    $parent.columnNames[index].map_to,
                                                )
                                            "
                                            @input="
                                                $parent.removeSelectedData($event, $parent.columnNames[index].map_to);
                                                $parent.onChangeFieldOrAttributeName(
                                                    $parent.columnNames[index].field_or_attribute_name,
                                                );
                                                $parent.onChangeColumnsName($parent.columnNames[index]);
                                            "
                                            :disabled="$parent.columnNames[index].map_to === 'Ignore'"
                                            v-model="$parent.columnNames[index].field_or_attribute_name"
                                            :options="
                                                $parent.columnNames[index].map_to === 'Attribute'
                                                    ? $parent.attributes
                                                    : $parent.columnNames[index].map_to === 'Table'
                                                      ? $parent.tables
                                                      : getDbColumns
                                            "
                                            :close-on-select="true"
                                            :hide-selected="false"
                                            :show-labels="false"
                                            :placeholder="
                                                $parent.columnNames[index].map_to !== 'Ignore'
                                                    ? `Select ${$parent.columnNames[index].map_to}`
                                                    : ''
                                            "

                                            v-bind="getMultiSelectProps"
                                        >
                                        </multiselect>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group mt-1">
                                        <button
                                            :id="`input_column_rename_${index}`"
                                            class="btn btn-sm mx-1 rounded btn-primary"
                                            type="button"
                                            @click="$parent.renameColumn(index)"
                                        >
                                            Rename
                                        </button>
                                        <button
                                            :id="`input_column_save_${index}`"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            data-original-title="Save changes"
                                            title="Save changes"
                                            class="btn btn-sm mx-1 rounded btn-success d-none"
                                            type="button"
                                            @click="$parent.updateColumn(index)"
                                        >
                                            Update
                                        </button>
                                        <button
                                            class="btn btn-sm mx-1 rounded"
                                            :id="`input_column_show_sample_${index}`"
                                            :class="$parent.disableShowSample ? 'btn-secondary' : 'btn-primary'"
                                            type="button"
                                            @click="$parent.showSample(index, column.column_name)"
                                        >
                                            Sample
                                        </button>
                                        <button
                                            class="btn btn-sm mx-1 rounded btn-success inline-create-button"
                                            :id="`input_column_edit_${index}`"
                                            data-toggle="modal"
                                            data-target="#edit-import-field-modal"
                                            @click="
                                                $parent.editButtonTrigger = true;
                                                setModalData(index, column);
                                                $parent.$refs.EditImportFieldModal.getModal();
                                            "
                                            type="button"
                                        >
                                            <i class="la la-edit"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import _ from 'lodash';
import VueSkeletonLoader from 'skeleton-loader-vue';

export default {
    name: 'FormFields',
    components: { VueSkeletonLoader },
    props: {
        className: {
            default: 'card-body row',
        },
    },
    data() {
        return {
            lastChangedMapTo: null,
        };
    },
    methods: {
        setModalData(index, column) {
            this.$parent.colIndex = index;
            this.$parent.columnName = _.cloneDeep(column);
        },
        resetImportFields() {
            this.$parent.importDefinition.import_type_field = '';
            this.$parent.importDefinition.import_file_field = '';
            this.$parent.removeError('import_type_field');
            this.$parent.removeError('import_file_field');
        },
        checkHasHierarchy() {
            let hierarchyExist = _.includes(this.$parent.allHierarchies, this.$parent.importDefinition.import_type);
            hierarchyExist ? (this.$parent.has_hierarchy = true) : (this.$parent.has_hierarchy = false);
        },
    },
    // watch   : {
    //     changed(newValue, oldValue) {
    //         this.$parent.joinOldDataFromMapTo(newValue[this.lastChangedMapTo], oldValue[this.lastChangedMapTo]);
    //     }
    // },
    computed: {
        _() {
            return _;
        },
        getDbColumns() {
            if (!this.$parent.isMultiSelectable) {
                return this.$parent.dbColumns;
            }

            let options = [];
            for (const option of this.$parent.dbColumns) {
                let lastIndex = options.length-1;
                let group_name = option.split('.')[0];

                if (lastIndex > -1 && options[lastIndex].name == group_name) {
                    options[lastIndex].options.push(option);
                } else {
                        options[++lastIndex] = {
                        name: group_name,
                        options: [option]
                    };
                }
            }

            return options;
        },
        getMultiSelectProps() {
            if (!this.$parent.isMultiSelectable) {
                return {};
            }

            return {
                "group-label": "name",
                "group-values": "options",
                "group-select": true,
                "multiple": true
            };
        }
    },
};
</script>

<style>
.skeleton-loader-style {
    width: auto !important;
    border-radius: 5px !important;
    margin-top: 10px !important;
    margin-bottom: 10px !important;
}

.tableFixHead table {
    border-collapse: collapse;
    width: 100%;
}

.tableFixHead table th {
    position: sticky;
    top: 0;
    z-index: 1;
    background: #eee !important;
}

.tableFixHead table th,
.tableFixHead table td {
    padding: 8px 16px;
}

.disabled-wrapper::after {
    content: '';
    display: block;
    position: absolute;
    width: 100%;
    height: 100%;
    background: #f1f4f875;
    z-index: 2;
    left: 0;
    top: 0;
    border-radius: 5px;
}

.checkbox {
    display: inline;
    margin-right: 1rem;
}
</style>

<style scoped lang="scss">
.tableFixHead {
    max-height: 500px !important;
    overflow-y: auto !important;
}
</style>
