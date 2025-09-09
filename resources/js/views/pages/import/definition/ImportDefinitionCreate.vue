<template>
    <div class="animated fadeIn">

        <div class="row">
            <div class="col-lg-12 bold-labels">
                <!-- Default box -->

                <form method="post" :action="backUrl">
                    <div v-if="translation_enabled" class="mb-2 text-right">
                        <!-- Single button -->
                        <AvailableLocales :availableLocales="availableLocales" :queryString="query_string"
                            :current_lang="current_lang" :url="url"></AvailableLocales>
                    </div>
                    <div class="card">
                        <FormFields ref="formFields"></FormFields>
                    </div>

                    <div id="saveActions" class="form-group">

                        <input type="hidden" name="save_action" value="save_and_back" v-model="actionType">
                        <div class="btn-group" role="group">

                            <button type="button" class="btn btn-success" @click="actionType = 'save_and_back'; saveData()">
                                <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                                <span data-value="save_and_back">Save and back</span>
                            </button>

                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                        class="caret"></span><span class="sr-only">▼</span></button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <a class="dropdown-item" @click.prevent="actionType = 'save_and_edit'; saveData()"
                                        data-value="save_and_edit">
                                        Save and edit this item
                                    </a>
                                    <a class="dropdown-item" @click.prevent="actionType = 'save_and_new'; saveData()"
                                        data-value="save_and_new">
                                        Save and new item
                                    </a>
                                    <a class="dropdown-item" @click.prevent="actionType = 'save_and_preview'; saveData()"
                                        data-value="save_and_preview">
                                        Save and preview
                                    </a>
                                </div>
                            </div>
                        </div>
                        <a :href="actionFromImportJob ? returnToImportJobUrl : `/admin/import-definition`"
                            class="btn btn-default"><span class="la la-ban"></span> &nbsp;Cancel</a>
                    </div>
                </form>
            </div>
        </div>

        <!--  EditImportFieldModal-->
        <EditImportFieldModal ref="EditImportFieldModal" />
        <!-- Show Sample Modal -->
        <ShowSampleModal ref="showSampleModal"></ShowSampleModal>
    </div>
</template>

<script>
import AvailableLocales from "../../../components/AvailableLocales";
import _ from "lodash";
import FormFields from "./FormFields";
import ShowSampleModal from "./ShowSampleModal";
import EditImportFieldModal from "./EditImportFieldModal";

export default {
    name: "ImportDefinitionCreate",
    components: { ShowSampleModal, FormFields, AvailableLocales, EditImportFieldModal },
    props: [
        'url', 'axios_url', 'current_lang', 'query_string',
        'translation_enabled',
        'method', 'locale', 'import_definition_data',
        'db_columns_data', 'attributes_data', 'tables_name', 'all_hierarchies',
        'import_types'
    ],
    data() {
        return {
            tables: [],
            importTypes: JSON.parse(this.import_types),
            importDefinition: {
                name: '',
                file_type: 'CSV',
                import_type: '',
                description: '',
                is_column_heading: false,
                file: '',
                import_file_field: '',
                import_type_field: '',
                allRequiredFields: [],
            },
            columnName: {
                "column_name": "",
                "map_to": "",
                "field_or_attribute_name": "",
                "separator": "",
                "field_name": "",
                "attribute_value": "",
                "availableTableColumns": []
            },
            acceptFileType: '.csv',
            backUrl: '/admin/import-definition',
            newUrl: '/admin/import-definition/create',
            uploadFileUrl: '/admin/import-definition/upload-file',
            actionType: 'save_and_back',
            validationErrors: {},
            tabsRerender: 0,
            loading: false,
            showFileData: false,
            productData: [],
            columnNames: [],
            importFileFields: [],
            importTypeFields: [],
            fileName: '',
            reRenderFileUpload: 0,
            loadedModal: 'Loading modal...',
            modalShade: '',
            modalBody: 'Loading...',
            sampleDataForSpecificColumn: [],
            dbColumns: [],
            dbColumnsAllData: [],
            requiredFieldsForSpecificModel: [],
            requiredFieldsForSpecificModelBackup: [],
            allRequiredFields: [],
            attributes: [],
            dynamicModalTitle: '',
            reRenderTable: 0,
            reRenderBody: 0,
            disableShowSample: false,
            validationErrorInFieldData: [],
            colIndex: 0,
            editButtonTrigger: false,
            has_hierarchy: false,
            allHierarchies: JSON.parse(this.all_hierarchies),
            actionFromImportJob: false,
            returnToImportJobUrl: '/admin/import-job/create',
            isMultiSelectable: false,
        }
    },

    mounted() {
        if (this.method === 'put') {
            document.querySelector("#fileChooseEdit").classList.remove('d-none');
            document.querySelector("#fileChooseCreateDiv").classList.add('d-none');
        }

        if (this.method === 'post') {
            let getURL = new URL(location.href);
            this.actionFromImportJob = getURL.searchParams.get("action_from") === 'import_job';
        }

    },

    created() {
        if (this.method === 'put') {
            this.initEdit()
        }

        if (this.method === 'post') {
            let queryParameters = JSON.parse(this.query_string);
            this.importDefinition.import_type = queryParameters.importType ?? "";
        }
    },

    methods: {
        initEdit() {
            let dbColumnsDataFromProp = JSON.parse(this.db_columns_data);
            let importDefinitionData = JSON.parse(this.import_definition_data);
            this.tables = JSON.parse(this.tables_name).map((data) => data.title)
            this.importDefinition = {
                id: importDefinitionData.id,
                name: importDefinitionData.name,
                file_type: importDefinitionData.file_type,
                import_type: importDefinitionData.import_type,
                description: importDefinitionData.description,
                is_column_heading: importDefinitionData.is_column_heading,
                import_file_field: importDefinitionData.import_file_field,
                import_type_field: importDefinitionData.import_type_field,
                file: true
            };
            this.has_hierarchy = importDefinitionData.has_hierarchy;
            this.has_hierarchy_readonly = !importDefinitionData.has_hierarchy;
            this.columnNames = JSON.parse(importDefinitionData.column_mapping);
            this.importFileFields = _.cloneDeep(this.columnNames.map(ele => ele.column_name));
            this.dbColumnsAllData = dbColumnsDataFromProp;
            this.importTypeFields = _.cloneDeep(dbColumnsDataFromProp.map(ele => ele.name));
            let finalDbColumnData = this.filterInitialFieldValue(dbColumnsDataFromProp);
            let finalAttributesData = this.filterInitialAttributesValue();
            this.dbColumns = finalDbColumnData;
            this.requiredFieldsForSpecificModel = dbColumnsDataFromProp
                .filter((column) => column.is_required)
                .map(column => column.name);
            this.requiredFieldsForSpecificModelBackup = _.cloneDeep(this.requiredFieldsForSpecificModel);

            if (_.isEmpty(importDefinitionData.required_fields)) {
                this.makeAllRequiredFields();
            } else {
                this.allRequiredFields = JSON.parse(importDefinitionData.required_fields);
                this.allRequiredFields.forEach((field) => {
                    if (!field.is_checked) {
                        this.requiredFieldsForSpecificModel = this.requiredFieldsForSpecificModel.filter(
                            (column) => column !== field.name
                        );
                    }
                });
            }

            this.attributes = finalAttributesData;
            this.showFileData = true;
            this.disableShowSample = true;
        },

        saveData() {
            this.validationErrors = {};
            this.validationErrorInFieldData = [];

            if (this.columnNames.length > 0) {
                this.requiredFieldsForSpecificModel.forEach((ele) => {
                    let isExist = Boolean(_.find(this.columnNames, {
                        'field_or_attribute_name': this.isMultiSelectable? (Array.isArray(ele)? ele : [ele]) : ele
                    }));
                    if (!isExist) {
                        this.validationErrorInFieldData.push(ele);
                    }
                });
            }

            if (this.validationErrorInFieldData.length > 0) {
                this.reRenderBody++;
                return;
            }

            let params = {
                id: this.importDefinition.id ?? '',
                name: this.importDefinition.name,
                file_type: this.importDefinition.file_type,
                import_type: this.importDefinition.import_type,
                description: this.importDefinition.description,
                is_column_heading: this.importDefinition.is_column_heading ? 1 : 0,
                column_mapping: this.columnNames.length > 0 ? JSON.stringify(this.columnNames) : '',
                has_hierarchy: this.has_hierarchy,
                import_type_field: this.importDefinition.import_type_field,
                import_file_field: this.importDefinition.import_file_field,
                required_fields: this.allRequiredFields.length > 0 ? JSON.stringify(this.allRequiredFields) : '',
            };

            axios[this.method](`${this.axios_url}?locale=${this.locale}`, params)
                .then(response => {
                    new Noty({
                        type: "success",
                        text: 'Saved successfully',
                    }).show();
                    this.validationErrors = "";
                    window.location = this.actionFromImportJob ?
                        this.returnToImportJobUrl :
                        (this.actionType === 'save_and_back'
                            ? this.backUrl
                            : this.newUrl);
                })
                .catch((err) => {
                    this.validationErrors = err.response.data.errors;
                    new Noty({
                        type: "error",
                        text: err.response.data.message,
                    }).show();
                    console.error(err);
                });
        },

        joinOldDataFromMapTo(newMapTo = "", oldMapTo = "") {
            let colName = _.cloneDeep(this.columnNames[this.colIndex]);
            if (!!colName) {
                if (colName.field_or_attribute_name != "") {
                    if (oldMapTo === 'Field') {
                        this.dbColumns.push(colName.field_or_attribute_name);
                        this.dbColumns = _.sortBy(this.dbColumns);
                    } else if (oldMapTo === 'Attribute') {
                        this.attributes.push(colName.field_or_attribute_name);
                        this.attributes = _.sortBy(this.attributes);
                    }
                }
            }
            if (!this.editButtonTrigger) {
                this.columnNames[this.colIndex].field_or_attribute_name = "";
                this.columnNames[this.colIndex].separator = "";
                this.columnNames[this.colIndex].field_name = "";
                this.columnNames[this.colIndex].attribute_value = "";
                //this.columnNames[this.colIndex].availableTableColumns = [];
            }
            this.editButtonTrigger = false;
            // !!colName ? this.onChangeMapTo(colName) : false;
        },

        filterInitialFieldValue(dbColumnsDataFromProp) {
            let initialDbColumnData = _.sortBy(dbColumnsDataFromProp.map(column => column.name));
            let existingFieldData = this.columnNames.filter(ele => {
                return ele.field_or_attribute_name != "" && ele.map_to === "Field";
            });
            let mappedExistingFieldData = existingFieldData.map(ele => ele.field_or_attribute_name);
            let finalDbColumnData = initialDbColumnData.filter(x => !mappedExistingFieldData.includes(x));
            return finalDbColumnData;
        },

        filterInitialAttributesValue() {
            let initialAttributesData = JSON.parse(this.attributes_data);
            let existingAttributesData = this.columnNames.filter(ele => {
                return ele.field_or_attribute_name != "" && ele.map_to === "Attribute";
            });
            let mappedExistingAttributesData = existingAttributesData.map(ele => ele.field_or_attribute_name);
            let finalAttributesData = initialAttributesData.filter(x => !mappedExistingAttributesData.includes(x));
            return finalAttributesData;
        },

        onChangeMapTo(column) {
            column.separator = '';
            column.field_or_attribute_name = '';
            column.field_name = '';
            column.attribute_value = column.map_to === "Attribute" ? 'Add' : '';
        },

        removeSelectedData(eventData, map_to) {
            if (map_to === 'Field') {
                let dbColumnFilteredData = this.dbColumns.filter(item => {
                    return item !== eventData;
                });
                this.dbColumns = dbColumnFilteredData;
            } else if (map_to === 'Attribute') {
                let AttributesFilteredData = this.attributes.filter(item => {
                    return item !== eventData;
                });
                this.attributes = AttributesFilteredData;
            }
        },

        joinOldData(oldData, mapTo) {
            if (!!oldData && mapTo === 'Field') {
                if (Array.isArray(oldData)) {
                    this.dbColumns = [...this.dbColumns, ...oldData];
                } else {
                    this.dbColumns.push(oldData);
                }

                this.dbColumns = _.uniq(_.sortBy(this.dbColumns));
            } else if (!!oldData && mapTo === 'Attribute') {
                this.attributes.push(oldData);
                this.attributes = _.sortBy(this.attributes);
            }
        },

        getShowSampleModal() {
            setTimeout(() => {
                $('#showSampleModal').modal('show');
                let modalShade = document.querySelector(".modal-backdrop.fade.show");
                modalShade
                    ? modalShade.remove()
                    : null;
                this.modalShade = modalShade.outerHTML

                this.modalBody = document.querySelector("#showSampleModal .modal-body").innerHTML
            }, 100)
        },

        onChangeFileType() {
            switch (this.importDefinition.file_type) {
                case 'CSV':
                    this.acceptFileType = '.csv';
                    break;
                case 'SQL':
                    this.acceptFileType = '.sql';
                    break;
                case 'JSON':
                    this.acceptFileType = 'application/JSON';
                    break;
                default:
                    break;
            }
            this.resetDataOfFile();
        },

        onChangeImportType() {
            let params = {
                importType: this.importDefinition.import_type
            }
            axios.post(`/admin/import-definition/fetch/column-listing`, params)
                .then(response => {
                    this.dbColumnsAllData = response.data;
                    this.dbColumns = _.sortBy(response.data.map(column => column.name));
                    this.requiredFieldsForSpecificModel = response.data
                        .filter((column) => column.is_required)
                        .map(column => column.name);
                    this.requiredFieldsForSpecificModelBackup = _.cloneDeep(this.requiredFieldsForSpecificModel);
                    this.resetDataOfFile();
                    this.makeAllRequiredFields();
                }).catch(err => {
                    console.error(err)
                })
        },

        uploadFile(event) {
            if (this.importDefinition.import_type === '') {
                this.validationErrors.import_type = ["Please select an import type."];
                this.reRenderBody++;
            } else {
                this.loading = true;
                let file = event.target.files[0];
                this.fileName = file.name;
                let formData = new FormData();
                formData.append('file', file);
                formData.append('locale', this.locale);
                formData.append('import_type', this.importDefinition.import_type);
                formData.append('is_column_heading', this.importDefinition.is_column_heading ? 1 : 0);

                axios.post(`${this.uploadFileUrl}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                    .then(response => {
                        let columnNamesData = [];
                        let importFileFields = [];
                        response.data.header_rows.forEach(function (data) {
                            importFileFields.push(data);
                            columnNamesData.push({
                                column_name: data,
                                map_to: 'Ignore',
                                field_or_attribute_name: '',
                                separator: '',
                                field_name: '',
                                attribute_value: '',
                                availableTableColumns: [],
                            });
                        })
                        this.importFileFields = importFileFields;
                        this.columnNames = _.cloneDeep(columnNamesData);
                        this.productData = response.data.data;
                        this.dbColumnsAllData = response.data.db_columns;
                        this.dbColumns
                            = _.sortBy(response.data.db_columns.map(column => column.name));
                        this.importTypeFields = _.cloneDeep(this.dbColumns);
                        this.requiredFieldsForSpecificModel = response.data.db_columns
                            .filter((column) => column.is_required)
                            .map(column => column.name);
                        this.attributes = response.data.attributes;
                        this.tables = response.data.tables_name.map((data) => data.title);
                        this.importDefinition.file = true;
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
                        this.loading = false;
                        this.showFileData = true;
                        this.reRenderFileUpload++;
                        this.disableShowSample = false;
                    });
            }
        },

        deleteFile() {
            this.importDefinition.file = false;
            this.showFileData = false;
            this.importDefinition.is_column_heading = false;
            this.fileName = '';
            this.columnNames = [];
            this.productData = [];
            this.validationErrorInFieldData = [];
            this.reRenderFileUpload++;
        },

        renameColumn(refId) {
            document.querySelector("#input_column_" + refId).disabled = false;
            document.querySelector("#input_column_show_sample_" + refId).disabled = true;
            document.querySelector("#input_column_edit_" + refId).disabled = true;
            document.querySelector("#input_column_save_" + refId).classList.remove('d-none');
            document.querySelector("#input_column_rename_" + refId).classList.add('d-none');
        },

        updateColumn(refId) {
            document.querySelector("#input_column_" + refId).disabled = true;
            document.querySelector("#input_column_show_sample_" + refId).disabled = false;
            document.querySelector("#input_column_edit_" + refId).disabled = false;
            document.querySelector("#input_column_save_" + refId).classList.add('d-none');
            document.querySelector("#input_column_rename_" + refId).classList.remove('d-none');
        },

        showSample(index, column) {
            if (!this.disableShowSample) {
                this.sampleDataForSpecificColumn = [];
                let exampleData = [];
                this.productData.forEach(function (data) {
                    exampleData.push(data[index] ?? '-');
                })
                this.sampleDataForSpecificColumn = _.cloneDeep(exampleData);
                this.dynamicModalTitle = column;
                this.getShowSampleModal();
            } else {
                new Noty({
                    type: "info",
                    text: "Please upload a new file to see sample.",
                }).show();
            }
        },

        uploadFileInEditMode() {
            this.$swal.fire({
                title: 'Upload new file?',
                text: "All your previous mapping data will be replaced.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#399E7F',
                cancelButtonColor: '#ff7979',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('fileChooseCreate').click();
                }
            })

        },

        onChangeFieldOrAttributeName(field) {
            if (this.validationErrorInFieldData.length > 0) {
                if (this.validationErrorInFieldData.includes(field)) {
                    this.validationErrorInFieldData = this.validationErrorInFieldData.filter(item => item !== field)
                }
            }
        },

        onChangeColumnsName(column) {
            column.field_name = ''
            if (column.map_to === 'Table') {
                let params = {
                    importType: column.field_or_attribute_name.replace(" ", "")
                }
                axios.post(`/admin/import-definition/fetch/column-listing`, params).then(response => {
                    this.dbColumnsAllData = response.data;
                    column.availableTableColumns = _.sortBy(response.data.map(column => column.name));
                }).catch(err => {
                    console.error(err)
                })
            }
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

        resetDataOfFile() {
            this.importDefinition.file = false;
            this.showFileData = false;
            this.fileName = '';
            this.columnNames = [];
            this.productData = [];
            this.validationErrorInFieldData = [];
            this.reRenderFileUpload++;
        },

        makeAllRequiredFields() {
            this.allRequiredFields = [];
            this.requiredFieldsForSpecificModelBackup.forEach((ele) => {
                this.allRequiredFields.push({
                    name: ele,
                    is_checked: true
                });
            });
        },

        onChangeRequiredFields(index) {
            let requiredField = this.allRequiredFields[index];
            if (!requiredField.is_checked) {
                this.requiredFieldsForSpecificModel.push(requiredField.name)
            } else {
                let index = this.requiredFieldsForSpecificModel.findIndex(item => item === requiredField.name);
                if (index > -1) {
                    this.requiredFieldsForSpecificModel.splice(index, 1);
                }
            }
        }
    },

    watch: {
        "importDefinition.import_type"(value) {
            this.isMultiSelectable = value == "ContactPermissions";
        }
    }
}
</script>

<style scoped lang="scss"></style>
