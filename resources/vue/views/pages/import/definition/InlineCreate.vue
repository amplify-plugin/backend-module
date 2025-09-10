<template>
    <div>
        <div
            class="modal fade"
            id="inline-create-import-definition"
            tabIndex="0"
            role="dialog"
            aria-labelledby="inline-create-import-definition-dialog-label"
            data-backdrop="static"
            data-keyboard="false"
            aria-modal="true"
        >
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="inline-create-import-definition-dialog-label">
                            Add Import Definition
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            @click="modalShade = ''"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body bg-light">
                        <!-- Default box -->
                        <div class="card">
                            <div class="card-body">
                                <FormFields :validationErrors="validationErrors" ref="formFields"></FormFields>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                            @click="modalShade = ''"
                            aria-label="Close"
                            id="CancelButtonImportDefinition"
                        >
                            Cancel
                        </button>
                        <button type="button" class="btn btn-primary" @click="saveData()" id="saveButton">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <div v-html="modalShade"></div>
    </div>
</template>

<script>
import FormFields from './FormFields';
import _ from 'lodash';

export default {
    name: 'InlineCreateImportDefinition',
    props: ['axios_url', 'locale'],
    data() {
        return {
            tables: [],
            importTypes: [
                {
                    title: 'Attributes',
                    value: 'Attribute',
                },
                {
                    title: 'Categories',
                    value: 'Category',
                },
                {
                    title: 'Products',
                    value: 'Product',
                },
                {
                    title: 'Product Classifications',
                    value: 'ProductClassification',
                },
                {
                    title: 'Attribute ~ Product',
                    value: 'AttributeProduct',
                },
                {
                    title: 'Attribute ~ Product Classification',
                    value: 'AttributeProductClassification',
                },
                {
                    title: 'Category ~ Product',
                    value: 'CategoryProduct',
                },
                {
                    title: 'Model Codes',
                    value: 'ModelCode',
                },
            ],
            importDefinition: {
                name: '',
                file_type: 'CSV',
                import_type: '',
                description: '',
                is_column_heading: false,
                file: '',
            },
            importDefinitionBackup: [],
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
            fileName: '',
            reRenderFileUpload: 0,
            loadedModal: 'Loading modal...',
            modalShade: '',
            modalBody: 'Loading...',
            sampleDataForSpecificColumn: [],
            dbColumns: [],
            dbColumnsAllData: [],
            requiredFieldsForSpecificModel: [],
            attributes: [],
            dynamicModalTitle: '',
            reRenderTable: 0,
            reRenderBody: 0,
            disableShowSample: false,
            validationErrorInFieldData: [],
        };
    },

    components: { FormFields },

    mounted() {
        this.defaultOption = _.cloneDeep(this.option);
        this.importDefinitionBackup = _.cloneDeep(this.importDefinition);
    },
    methods: {
        getModal() {
            this.resetModalData();
            setTimeout(() => {
                let modalShade = document.querySelector('.modal-backdrop.fade.show');
                modalShade ? modalShade.remove() : null;
                this.modalShade = modalShade.outerHTML;

                this.modalBody = document.querySelector('#inline-create-import-definition .modal-body').innerHTML;
            }, 100);
            this.option = _.cloneDeep(this.defaultOption);
        },

        saveData() {
            this.validationErrors = {};
            this.validationErrorInFieldData = [];

            if (this.columnNames.length > 0) {
                this.requiredFieldsForSpecificModel.forEach((ele) => {
                    let isExist = Boolean(_.find(this.columnNames, { field_or_attribute_name: ele }));
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
                name: this.importDefinition.local_name,
                file_type: this.importDefinition.file_type,
                import_type: this.importDefinition.import_type,
                description: this.importDefinition.description,
                is_column_heading: this.importDefinition.is_column_heading ? 1 : 0,
                column_mapping: this.columnNames.length > 0 ? JSON.stringify(this.columnNames) : '',
            };

            axios
                .post(`${this.axios_url}?locale=${this.locale}`, params)
                .then((response) => {
                    new Noty({
                        type: 'success',
                        text: 'Saved successfully',
                    }).show();
                    this.validationErrors = '';

                    document.getElementById('CancelButtonImportDefinition').click();
                    this.$parent.getImportDefinitions();
                    this.resetModalData();
                })
                .catch((err) => {
                    this.validationErrors = err.response.data.errors;
                    new Noty({
                        type: 'error',
                        text: err.response.data.message,
                    }).show();
                    console.error(err);
                });
        },

        joinOldDataFromMapTo(newMapTo = '', oldMapTo = '') {
            let colName = this.columnNames[this.$refs.formFields.lastChangedMapTo];
            if (newMapTo === 'Ignore' && !!colName) {
                if (colName.field_or_attribute_name != '') {
                    if (oldMapTo === 'Field') {
                        this.dbColumns.push(colName.field_or_attribute_name);
                        this.dbColumns = _.sortBy(this.dbColumns);
                    } else if (oldMapTo === 'Attribute') {
                        this.attributes.push(colName.field_or_attribute_name);
                        this.attributes = _.sortBy(this.attributes);
                    }
                }
            }
            !!colName ? this.onChangeMapTo(colName) : false;
        },

        filterInitialFieldValue(dbColumnsDataFromProp) {
            let initialDbColumnData = _.sortBy(dbColumnsDataFromProp.map((column) => column.name));
            let existingFieldData = this.columnNames.filter((ele) => {
                return ele.field_or_attribute_name != '' && ele.map_to === 'Field';
            });
            let mappedExistingFieldData = existingFieldData.map((ele) => ele.field_or_attribute_name);
            let finalDbColumnData = initialDbColumnData.filter((x) => !mappedExistingFieldData.includes(x));
            return finalDbColumnData;
        },

        filterInitialAttributesValue() {
            let initialAttributesData = JSON.parse(this.attributes_data);
            let existingAttributesData = this.columnNames.filter((ele) => {
                return ele.field_or_attribute_name != '' && ele.map_to === 'Attribute';
            });
            let mappedExistingAttributesData = existingAttributesData.map((ele) => ele.field_or_attribute_name);
            let finalAttributesData = initialAttributesData.filter((x) => !mappedExistingAttributesData.includes(x));
            return finalAttributesData;
        },

        onChangeMapTo(column) {
            column.separator = '';
            column.field_or_attribute_name = '';
            column.field_name = '';
            column.attribute_value = column.map_to === 'Attribute' ? 'Add' : '';
        },

        removeSelectedData(eventData, map_to) {
            if (map_to === 'Field') {
                let dbColumnFilteredData = this.dbColumns.filter((item) => {
                    return item !== eventData;
                });
                this.dbColumns = dbColumnFilteredData;
            } else if (map_to === 'Attribute') {
                let AttributesFilteredData = this.attributes.filter((item) => {
                    return item !== eventData;
                });
                this.attributes = AttributesFilteredData;
            }
        },

        joinOldData(oldData, mapTo) {
            if (!!oldData && mapTo === 'Field') {
                this.dbColumns.push(oldData);
                this.dbColumns = _.sortBy(this.dbColumns);
            } else if (!!oldData && mapTo === 'Attribute') {
                this.attributes.push(oldData);
                this.attributes = _.sortBy(this.attributes);
            }
        },

        getShowSampleModal() {
            setTimeout(() => {
                $('#showSampleModal').modal('show');
                let modalShade = document.querySelector('.modal-backdrop.fade.show');
                modalShade ? modalShade.remove() : null;
                this.modalShade = modalShade.outerHTML;

                this.modalBody = document.querySelector('#showSampleModal .modal-body').innerHTML;
            }, 100);
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
        },

        onChangeImportType() {
            let params = {
                importType: this.importDefinition.import_type,
            };
            axios
                .post(`/admin/import-definition/fetch/column-listing`, params)
                .then((response) => {
                    this.dbColumnsAllData = response.data;
                    this.dbColumns = _.sortBy(response.data.map((column) => column.name));
                    this.requiredFieldsForSpecificModel = response.data
                        .filter((column) => column.is_required)
                        .map((column) => column.name);
                })
                .catch((err) => {
                    console.error(err);
                });
        },

        uploadFile(event) {
            if (this.importDefinition.import_type === '') {
                this.validationErrors.import_type = ['Please select an import type.'];
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

                axios
                    .post(`${this.uploadFileUrl}`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        },
                    })
                    .then((response) => {
                        let columnNamesData = [];
                        response.data.header_rows.forEach(function (data) {
                            columnNamesData.push({
                                column_name: data,
                                map_to: 'Ignore',
                                field_or_attribute_name: '',
                                separator: '',
                                field_name: '',
                                attribute_value: '',
                                availableTableColumns: [],
                            });
                        });
                        this.columnNames = _.cloneDeep(columnNamesData);
                        this.productData = response.data.data;
                        this.dbColumnsAllData = response.data.db_columns;
                        this.dbColumns = _.sortBy(response.data.db_columns.map((column) => column.name));
                        this.requiredFieldsForSpecificModel = response.data.db_columns
                            .filter((column) => column.is_required)
                            .map((column) => column.name);
                        this.attributes = response.data.attributes;
                        this.tables = response.data.tables_name.map((data) => data.title);
                        this.importDefinition.file = true;
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
            document.querySelector('#input_column_' + refId).disabled = false;
            document.querySelector('#input_column_save_' + refId).classList.remove('d-none');
            document.querySelector('#input_column_rename_' + refId).classList.add('d-none');
        },

        updateColumn(refId) {
            document.querySelector('#input_column_' + refId).disabled = true;
            document.querySelector('#input_column_save_' + refId).classList.add('d-none');
            document.querySelector('#input_column_rename_' + refId).classList.remove('d-none');
        },

        showSample(index, column) {
            if (!this.disableShowSample) {
                this.sampleDataForSpecificColumn = [];
                let exampleData = [];
                this.productData.forEach(function (data) {
                    exampleData.push(data[index]);
                });
                this.sampleDataForSpecificColumn = _.cloneDeep(exampleData);
                let dataToShow = 'Sample data for - ' + column + '\n\n' + this.sampleDataForSpecificColumn.join('\n');
                alert(dataToShow);
            } else {
                new Noty({
                    type: 'info',
                    text: 'Please upload a new file to see sample.',
                }).show();
            }
        },

        uploadFileInEditMode() {
            this.$swal
                .fire({
                    title: 'Upload new file?',
                    text: 'All your previous mapping data will be replaced.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#399E7F',
                    cancelButtonColor: '#ff7979',
                    confirmButtonText: 'Yes',
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('fileChooseCreate').click();
                    }
                });
        },

        onChangeFieldOrAttributeName(field) {
            if (this.validationErrorInFieldData.length > 0) {
                if (this.validationErrorInFieldData.includes(field)) {
                    this.validationErrorInFieldData = this.validationErrorInFieldData.filter((item) => item !== field);
                }
            }
        },

        onChangeColumnsName(column) {
            column.field_name = '';
            if (column.map_to === 'Table') {
                let params = {
                    importType: column.field_or_attribute_name,
                };
                axios
                    .post(`/admin/import-definition/fetch/column-listing`, params)
                    .then((response) => {
                        this.dbColumnsAllData = response.data;
                        column.availableTableColumns = _.sortBy(response.data.map((column) => column.name));
                    })
                    .catch((err) => {
                        console.error(err);
                    });
            }
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

        resetModalData() {
            this.importDefinition = _.cloneDeep(this.importDefinitionBackup);
            this.showFileData = false;
            this.columnNames = [];
            this.validationErrorInFieldData = [];
            this.validationErrors = {};
        },
    },
};
</script>

<style scoped>
@media (min-width: 1200px) {
    .modal-xl {
        max-width: 1415px !important;
    }
}
</style>
