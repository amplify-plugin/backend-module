<template>
    <div role="tabpanel" class="tab-pane active" id="tab_documents">
        <div class="row">
            <!-- hidden input -->
            <div class="hidden">
                <input type="hidden" name="documents" value="" class="form-control" />
            </div>

            <div v-if="$parent.productData.productDocuments.length > 0" class="w-100">
                <div v-for="(document, index) in $parent.productData.productDocuments" :key="index">
                    <div class="form-group col-sm-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div class="row w-100">
                                        <div class="col-4">
                                            <div class="float-left w-25">
                                                <label :class="{ 'text-danger': documentError('order', index) }"
                                                    >Order</label
                                                >
                                                <input
                                                    placeholder="Order"
                                                    type="text"
                                                    class="form-control"
                                                    @click="removeError(documentError('order', index, true))"
                                                    :class="{ 'border border-danger': documentError('order', index) }"
                                                    v-model="document.order"
                                                />
                                                <small v-if="documentError('order', index)" class="text-danger mt-3">
                                                    {{
                                                        $parent.validationErrors[documentError('order', index, true)][0]
                                                    }}
                                                </small>
                                            </div>
                                            <div class="float-right pl-3 w-75">
                                                <label
                                                    :class="{ 'text-danger': documentError('document_type_id', index) }"
                                                    >Document Type</label
                                                >
                                                <div>
                                                    <select
                                                        class="form-control"
                                                        :class="{
                                                            'is-invalid': documentError('document_type_id', index),
                                                        }"
                                                        @change="
                                                            removeError(documentError('document_type_id', index, true))
                                                        "
                                                        v-model="document.document_type_id"
                                                    >
                                                        <option :value="null" disabled>Select a document type</option>
                                                        <option
                                                            v-for="(documentType, index) in $parent.allDocumentTypes"
                                                            :key="index"
                                                            :value="documentType.id"
                                                            :disabled="documentType?.disabled ?? false"
                                                        >
                                                            {{ documentType.name }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <small
                                                    v-if="documentError('document_type_id', index)"
                                                    class="text-danger mt-3"
                                                >
                                                    {{
                                                        $parent.validationErrors[
                                                            documentError('document_type_id', index, true)
                                                        ][0]
                                                    }}
                                                </small>
                                            </div>
                                        </div>

                                        <div
                                            v-if="$parent.productData.productDocuments[index].media_type != 'embedded'"
                                            class="col-4 text-center px-3 m-auto"
                                        >
                                            <div class="btn-group w-100">
                                                <div
                                                    class="w-100"
                                                    v-if="
                                                        document.document_type_id !== null &&
                                                        document.document_type_id !== undefined
                                                    "
                                                >
                                                    <label
                                                        :class="{ 'text-danger': documentError('file_path', index) }"
                                                        class="btn btn-light btn-sm btn-file py-2 mb-0 cursor-pointer w-100"
                                                        style="margin-top: 2rem !important"
                                                        title="select file"
                                                        :for="`documentFile_${index}`"
                                                    >
                                                        <i class="la la-cloud-upload-alt"></i>
                                                        Upload Document
                                                        <input
                                                            :id="`documentFile_${index}`"
                                                            type="file"
                                                            class="form-control d-none file_design"
                                                            title="select file"
                                                            :class="{
                                                                'border border-danger': documentError(
                                                                    'file_path',
                                                                    index,
                                                                ),
                                                            }"
                                                            :accept="document.file_type"
                                                            @click="
                                                                processImagesByType(index);
                                                                getImageBrowseModal();
                                                                canMultiple = false;
                                                                browseThumbImage($event);
                                                            "
                                                        /> </label
                                                    ><br />
                                                    <small
                                                        v-if="documentError('file_path', index)"
                                                        class="text-danger mt-3"
                                                    >
                                                        {{
                                                            $parent.validationErrors[
                                                                documentError('file_path', index, true)
                                                            ][0]
                                                        }}
                                                    </small>
                                                </div>
                                                <label
                                                    v-else
                                                    class="btn btn-light btn-sm btn-file py-2 mb-0 disabled"
                                                    style="margin-top: 2rem !important"
                                                    title="select file"
                                                >
                                                    <i class="la la-cloud-upload-alt"></i>
                                                    Upload Document
                                                </label>
                                            </div>
                                        </div>

                                        <div
                                            v-if="$parent.productData.productDocuments[index].media_type != 'embedded'"
                                            class="col-4"
                                        >
                                            <div class="d-flex gap-3 justify-content-between">
                                                <div :id="`file_path_${index}`" class="w-100">
                                                    <label>File Path</label>
                                                    <input
                                                        placeholder="file path"
                                                        type="text"
                                                        class="form-control"
                                                        @click="removeError(documentError('file_path', index, true))"
                                                        :class="{
                                                            'border border-danger': documentError('file_path', index),
                                                        }"
                                                        v-model="document.file_path"
                                                    />
                                                </div>
                                                <div
                                                    :id="`progressbar_${index}`"
                                                    class="d-none justify-content-center mt-4"
                                                >
                                                    <ProgressBar></ProgressBar>
                                                </div>
                                                <div>
                                                    <i
                                                        class="la la-times bg-danger rounded-circle p-1 e-0 cursor-pointer mt-4"
                                                        style="margin-top: 2.3rem !important; font-weight: 900"
                                                        title="Delete Document"
                                                        @click="
                                                            removeDocument(
                                                                index,
                                                                document.file_path,
                                                                document.document_type_id,
                                                            )
                                                        "
                                                        data-handle="remove"
                                                    ></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            v-if="$parent.productData.productDocuments[index].media_type == 'embedded'"
                                            class="col-8"
                                        >
                                            <div class="d-flex gap-3 justify-content-between">
                                                <div class="w-100">
                                                    <label
                                                        for="content"
                                                        :class="{ 'text-danger': documentError('content', index) }"
                                                        >Script</label
                                                    >
                                                    <textarea
                                                        name="content"
                                                        class="form-control"
                                                        @click="removeError(documentError('content', index, true))"
                                                        :class="{
                                                            'border border-danger': documentError('content', index),
                                                        }"
                                                        v-model="document.content"
                                                    >
                                                    </textarea>
                                                    <small
                                                        v-if="documentError('content', index)"
                                                        class="text-danger mt-3"
                                                    >
                                                        {{
                                                            $parent.validationErrors[
                                                                documentError('content', index, true)
                                                            ][0]
                                                        }}
                                                    </small>
                                                </div>
                                                <div>
                                                    <i
                                                        class="la la-times bg-danger rounded-circle p-1 e-0 cursor-pointer mt-4"
                                                        style="margin-top: 2.3rem !important; font-weight: 900"
                                                        title="Delete Document"
                                                        @click="
                                                            removeDocument(
                                                                index,
                                                                document.file_path,
                                                                document.document_type_id,
                                                            )
                                                        "
                                                        data-handle="remove"
                                                    ></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="form-group col-sm-12">
                <div class="card mb-3">
                    <div class="card-body text-center">No Documents Found</div>
                </div>
            </div>

            <div v-if="$parent.productData.productDocuments < $parent.allDocumentTypes" class="ml-3">
                <button class="btn btn-sm btn-link border-primary" type="button" @click="addDocument()">
                    + Add Document
                </button>
            </div>
        </div>

        <!-- Button to Open file manager Modal -->
        <button type="button" class="btn btn-primary d-none" data-toggle="modal" data-target="#filemanagerModal">
            Open Filemanager
        </button>
    </div>
</template>

<script>
import allDisksMixin from '../../../../allDisks.mixin';
import Treeselect from '@riophae/vue-treeselect';
import _ from 'lodash';
import $ from 'jquery';

export default {
    name: 'Documents',
    mixins: [allDisksMixin],
    components: { Treeselect },
    data() {
        return {
            documentDirectory: 'uploads/product_documents',
            allFileTypes: JSON.parse(this.$parent.accept_file_types),
            index: null,
        };
    },

    methods: {
        removeError(key) {
            let errorsObject = this.$parent.validationErrors;
            let errorExist = errorsObject.hasOwnProperty(key);
            if (errorExist) {
                delete errorsObject[key];
            }
            if (Object.keys(errorsObject).length <= 0) {
                this.$parent.validationErrors = '';
            }
            this.$parent.validationErrors = errorsObject;
        },

        uploadDocument(event) {
            let file = event.target.files[0];
            let fileExtension = file.name.split('.').pop();
            let index = event.target.id.split('_')[1];
            let base64image = '';
            let isFileImage = file['type'].split('/')[0] === 'image';

            if (file.size > 304877000) {
                alert(file['type'] + ' must not be greater than 300 MB');
            } else {
                let reader = new FileReader();
                reader.onload = (event) => {
                    base64image = event.target.result;
                    this.sendDataToServer(
                        base64image,
                        this.documentDirectory,
                        this.$parent.productData.product_code,
                        index,
                        isFileImage,
                        fileExtension,
                    );
                };
                reader.readAsDataURL(file);
            }
        },

        sendDataToServer(base64, directory, product_code = null, index, isImage = false, fileExtension) {
            let progressBar = document.querySelector(`#progressbar_${index}`);
            let filePath = document.querySelector(`#file_path_${index}`);

            progressBar.classList.remove('d-none');
            filePath.classList.add('d-none');

            axios
                .post('/admin/product/upload_document', {
                    document: base64,
                    directory: directory,
                    productCode: product_code,
                    isImage: isImage,
                    fileExtension: fileExtension,
                })
                .then((res) => {
                    let imgLink = '/' + res.data;
                    this.$parent.productData.productDocuments[index].file_path = imgLink;

                    new Noty({
                        type: 'success',
                        text: 'Document file uploaded successfully',
                    }).show();
                })
                .catch((e) => {
                    console.error(e);
                    new Noty({
                        type: 'error',
                        text: e.response.data.message,
                    }).show();
                })
                .finally(() => {
                    progressBar.classList.add('d-none');
                    filePath.classList.remove('d-none');
                });
        },

        documentError(field_name, index, get_key = false) {
            let field = `productDocuments.${index}.${field_name}`;
            if (get_key) {
                return field;
            }
            return _.has(this.$parent.validationErrors, field);
        },

        addDocument() {
            this.$parent.productData.productDocuments.push({
                document_type_id: null,
                file_type: '.pdf',
                order: this.$parent.productData.productDocuments.length + 1,
                file_path: null,
            });
        },

        removeDocument(index, url, document_type_id) {
            this.$swal
                .fire({
                    title: 'Are you sure?',
                    //icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#42ba96',
                    cancelButtonColor: '#ff7979',
                    confirmButtonText: 'Yes, delete it!',
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        let document_type_id = this.$parent.productData.productDocuments[index].document_type_id;
                        if (document_type_id) {
                            this.$parent.productData.productDocuments[index].document_type_id = null;
                        }

                        if (url === null || url.trim() === '') {
                            this.$parent.productData.productDocuments.splice(index, 1);
                            new Noty({
                                type: 'success',
                                text: 'Document removed successfully',
                            }).show();
                            return;
                        }

                        axios
                            .post('/admin/product/remove_document', {
                                product_id: this.$parent.productData.id,
                                document_type_id: document_type_id,
                                url: url,
                            })
                            .then((res) => {
                                this.$parent.productData.productDocuments.splice(index, 1);

                                new Noty({
                                    type: 'success',
                                    text: 'Document removed successfully',
                                }).show();
                            })
                            .catch((e) => {
                                new Noty({
                                    type: 'error',
                                    text: e.response.data.message,
                                }).show();
                            });
                    }
                });
        },

        removeSelectedFiles(index, length = 1) {
            let path = this.$parent.selectedFiles.splice(index, length);
            let noty = {
                type: 'success',
                text: `File (${path}) removed!`,
            };
            new Noty(noty).show();
        },

        browseThumbImage(event) {
            event.preventDefault();
        },
        processImagesByType(index) {
            this.index = index;
        },
        getImageBrowseModal() {
            this.$parent.selectedFiles = this.$parent.productData.productDocuments[this.index].file_path ?? [];
            setTimeout(() => {
                let modal = document.querySelector('[data-target="#filemanagerModal"]');
                modal?.click();

                let modalDismisses = document.querySelectorAll('[data-dismiss="modal"]');
                let modalShadeDefault = document.querySelector('.modal-backdrop.show');
                modalShadeDefault ? modalShadeDefault.remove() : null;

                let modalShade = document.createElement('div');
                modalShade.classList.add('modal-backdrop', 'show');

                this.$parent.modalShade = modalShade.outerHTML;

                modalDismisses.forEach((modalDismiss) => {
                    modalDismiss.addEventListener('click', () => {
                        this.$store.dispatch('fm/resetState');
                        this.$store.dispatch('fm/initializeApp');
                        this.$parent.modalShade = '';
                    });
                });

                this.$parent.modalBody = document.querySelector('#filemanagerModal .modal-body').innerHTML;

                // Initiate draggable
                setTimeout(() => {
                    $('.modal-dialog').draggable({
                        handle: '.modal-moveable',
                    });
                }, 1000);
            }, 100);
        },
        getFileExtension(file) {
            const regexp = /\.([0-9a-z]+)(?:[\?#]|$)/i;
            const extension = file.match(regexp);
            return extension && extension[1];
        },
        getFileAddedMessage() {
            new Noty({
                type: 'success',
                text: 'File path added successfully!',
            }).show();
        },
    },
    watch: {
        '$store.state.fm.left.selected.files': {
            handler(files) {
                if (files.length) {
                    const self = this;

                    let filePath = files.find((file) => {
                        return [
                            'jpg',
                            'jpeg',
                            'png',
                            'mp4',
                            'avi',
                            'mkv',
                            'pdf',
                            'xls',
                            'xlsx',
                            'doc',
                            'docx',
                        ].includes(self.getFileExtension(file.toLowerCase()));
                    });

                    if (filePath) {
                        self.$parent.productData.productDocuments[self.index].file_path = self.all_disks[
                            self.$store.state.fm.left.selectedDisk
                        ].url
                            ? self.all_disks[self.$store.state.fm.left.selectedDisk].url + '/' + filePath
                            : '/' + filePath;
                        self.$parent.selectedFiles = self.$parent.productData.productDocuments[self.index].file_path;
                    }
                    self.getFileAddedMessage();
                }
            },
        },
        '$parent.productData.productDocuments': {
            handler(newData, o) {
                const self = this;

                self.$parent.selectedDocumentTypes = [];
                newData.forEach((document) => {
                    if (document.document_type_id) {
                        let documentType = self.$parent.allDocumentTypes.find(
                            (docType) => docType.id == document.document_type_id,
                        );
                        documentType.disabled = true;

                        document.media_type = documentType.media_type;
                        document.file_type = self.allFileTypes[documentType.media_type] ?? null;

                        self.$parent.selectedDocumentTypes.push(documentType);
                    }
                });

                self.$parent.allDocumentTypes.forEach((docType) => {
                    let isSelected = self.$parent.selectedDocumentTypes.some(
                        (selectedDocType) => selectedDocType.id == docType.id,
                    );
                    if (!isSelected) {
                        docType.disabled = false;
                    }
                });
            },
            deep: true,
        },
    },
};
</script>

<style scoped>
.card-header {
    background: aliceblue;
}

.w-one-third {
    width: 33.33%;
}
.gap-3 {
    gap: 16px;
}
</style>
