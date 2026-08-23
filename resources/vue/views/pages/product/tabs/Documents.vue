<template>
    <div role="tabpanel" class="tab-pane active" id="tab_documents">
        <div class="row">
            <!-- hidden input -->
            <div class="hidden">
                <input type="hidden" name="documents" value="" class="form-control" />
            </div>

            <div v-if="$parent.productData.productDocuments.length > 0" class="w-100">
                <sortable-list
                    :items="$parent.productData.productDocuments"
                    item-key="_uid"
                    order-key="order"
                    hint="Drag the handle to change document order."
                    ghost-selector=".card"
                    item-class="form-group col-sm-12"
                    @before-reorder="onDocumentBeforeReorder"
                >
                    <template #item="{ item: document, index, dragStart, dragEnd }">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="document-card-row">
                                <sortable-handle
                                    :index="index"
                                    align="fields"
                                    :drag-start="dragStart"
                                    :drag-end="dragEnd"
                                />
                                <div class="document-fields-row">
                                    <div class="document-type-col">
                                        <div class="w-100">
                                            <label
                                                class="d-flex align-items-center"
                                                :class="{ 'text-danger': documentError('document_type_id', index) }"
                                            >
                                                Document Type
                                                <span class="document-order-badge ml-2">{{ document.order }}</span>
                                            </label>
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
                                                            v-for="documentType in $parent.allDocumentTypes"
                                                            :key="documentType.id"
                                                            :value="documentType.id"
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
                                            class="document-meta-col"
                                        >
                                            <div class="document-meta-row">
                                                <div class="document-label-col">
                                                    <label>Label</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        :placeholder="documentLabelPlaceholder(document)"
                                                        :value="document.label || ''"
                                                        title="Leave empty to use the file name"
                                                        @input="document.label = $event.target.value"
                                                        @blur="commitDocumentLabel(document)"
                                                    />
                                                </div>
                                                <div class="document-path-wrap">
                                                <div :id="`file_path_${index}`" class="document-path-col">
                                                    <label
                                                        class="document-path-label"
                                                        :class="{ 'text-danger': documentError('file_path', index) }"
                                                    >
                                                        File Path/URL
                                                        <span
                                                            class="document-path-info"
                                                            tabindex="0"
                                                            aria-label="Use Upload to pick a file from the file manager, or paste any valid file URL such as an S3 or CDN link."
                                                        >
                                                            <i class="la la-info-circle" aria-hidden="true"></i>
                                                            <span class="document-path-info-tip" role="tooltip">
                                                                Use Upload to pick a file from the file manager, or
                                                                paste any valid file URL (S3, CDN, or other direct
                                                                link to a PDF, image, video, or document).
                                                            </span>
                                                        </span>
                                                    </label>
                                                    <div class="document-path-input-row">
                                                        <div class="input-group document-path-group">
                                                        <div class="input-group-prepend">
                                                            <label
                                                                v-if="
                                                                    document.document_type_id !== null &&
                                                                    document.document_type_id !== undefined
                                                                "
                                                                class="btn btn-light mb-0 cursor-pointer document-upload-addon"
                                                                :class="{
                                                                    'text-danger': documentError('file_path', index),
                                                                }"
                                                                title="Upload document"
                                                                :for="`documentFile_${index}`"
                                                            >
                                                                <i class="la la-cloud-upload-alt"></i>
                                                                Upload
                                                                <input
                                                                    :id="`documentFile_${index}`"
                                                                    type="file"
                                                                    class="form-control d-none file_design"
                                                                    title="select file"
                                                                    :accept="document.file_type"
                                                                    @click="
                                                                        processImagesByType(index);
                                                                        getImageBrowseModal();
                                                                        canMultiple = false;
                                                                        browseThumbImage($event);
                                                                    "
                                                                />
                                                            </label>
                                                            <button
                                                                v-else
                                                                type="button"
                                                                class="btn btn-light document-upload-addon"
                                                                disabled
                                                                title="Select a document type first"
                                                            >
                                                                <i class="la la-cloud-upload-alt"></i>
                                                                Upload
                                                            </button>
                                                        </div>
                                                        <input
                                                            placeholder="file path or URL"
                                                            type="text"
                                                            class="form-control"
                                                            @click="
                                                                removeError(documentError('file_path', index, true))
                                                            "
                                                            :class="{
                                                                'is-invalid': documentError('file_path', index),
                                                            }"
                                                            v-model="document.file_path"
                                                            @blur="suggestDocumentLabelFromPath(document)"
                                                        />
                                                    </div>
                                                        <div class="document-delete-col">
                                                            <i
                                                                class="la la-times bg-danger rounded-circle p-1 e-0 cursor-pointer"
                                                                title="Delete Document"
                                                                @click="removeDocument(index)"
                                                                data-handle="remove"
                                                            ></i>
                                                        </div>
                                                    </div>
                                                    <small
                                                        v-if="documentError('file_path', index)"
                                                        class="text-danger d-block mt-1"
                                                    >
                                                        {{
                                                            $parent.validationErrors[
                                                                documentError('file_path', index, true)
                                                            ][0]
                                                        }}
                                                    </small>
                                                </div>
                                                <div
                                                    :id="`progressbar_${index}`"
                                                    class="d-none justify-content-center mt-4"
                                                >
                                                    <ProgressBar></ProgressBar>
                                                </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            v-if="$parent.productData.productDocuments[index].media_type == 'embedded'"
                                            class="document-meta-col"
                                        >
                                            <div class="document-meta-row">
                                                <div class="document-label-col">
                                                    <label>Label</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        :placeholder="documentLabelPlaceholder(document)"
                                                        :value="document.label || ''"
                                                        title="Leave empty to use the file name"
                                                        @input="document.label = $event.target.value"
                                                        @blur="commitDocumentLabel(document)"
                                                    />
                                                </div>
                                                <div class="document-path-wrap">
                                                    <div class="document-path-col">
                                                        <label
                                                            for="content"
                                                            :class="{ 'text-danger': documentError('content', index) }"
                                                            >Script</label
                                                        >
                                                        <div class="document-path-input-row is-multiline">
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
                                                        <div class="document-delete-col">
                                                            <i
                                                                class="la la-times bg-danger rounded-circle p-1 e-0 cursor-pointer"
                                                                title="Delete Document"
                                                                @click="removeDocument(index)"
                                                                data-handle="remove"
                                                            ></i>
                                                        </div>
                                                        </div>
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    </template>
                </sortable-list>
            </div>
            <div v-else class="form-group col-sm-12">
                <div class="card mb-3">
                    <div class="card-body text-center">No Documents Found</div>
                </div>
            </div>

            <div class="ml-3">
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
import SortableList from '../../../components/sortable-list/SortableList.vue';
import SortableHandle from '../../../components/sortable-list/SortableHandle.vue';

export default {
    name: 'Documents',
    mixins: [allDisksMixin],
    components: { Treeselect, SortableList, SortableHandle },
    data() {
        return {
            documentDirectory: 'uploads/product_documents',
            allFileTypes: JSON.parse(this.$parent.accept_file_types),
            index: null,
        };
    },

    methods: {
        filenameWithoutExtension(filePath) {
            if (!filePath) {
                return '';
            }

            const path = String(filePath).split('?')[0];
            const basename = decodeURIComponent(path.split('/').pop() || '');
            const lastDot = basename.lastIndexOf('.');

            if (lastDot > 0) {
                return basename.slice(0, lastDot);
            }

            return basename;
        },

        documentLabelPlaceholder(document) {
            return this.filenameWithoutExtension(document.file_path) || 'Uses file name if empty';
        },

        commitDocumentLabel(document) {
            const trimmed = String(document.label ?? '').trim();
            if (trimmed !== '') {
                document.label = trimmed;
                return;
            }

            document.label = this.filenameWithoutExtension(document.file_path) || null;
        },

        suggestDocumentLabelFromPath(document, previousFilePath = null) {
            const nextName = this.filenameWithoutExtension(document.file_path);
            if (!nextName) {
                return;
            }

            const current = String(document.label ?? '').trim();
            const previousName = this.filenameWithoutExtension(previousFilePath);
            if (current === '' || current === previousName) {
                document.label = nextName;
            }
        },

        ensureDocumentUid(document) {
            if (!document._uid) {
                document._uid = document.id
                    ? `doc-${document.id}`
                    : `new-${Date.now()}-${Math.random().toString(36).slice(2, 8)}`;
            }
        },

        reindexDocumentOrder() {
            this.$parent.productData.productDocuments.forEach((document, index) => {
                document.order = index + 1;
            });
        },

        onDocumentBeforeReorder({ fromIndex, toIndex, length }) {
            this.moveDocumentValidationErrors(fromIndex, toIndex, length);
        },

        getValidationErrors() {
            const errors = this.$parent.validationErrors;
            if (!errors || typeof errors !== 'object') {
                return {};
            }

            return errors;
        },

        setValidationErrors(errors) {
            this.$parent.validationErrors = { ...errors };
        },

        removeError(key) {
            if (!key) {
                return;
            }

            const errors = { ...this.getValidationErrors() };
            delete errors[key];
            this.setValidationErrors(errors);
        },

        rekeyDocumentValidationErrors(indexMap) {
            const next = {};

            Object.entries(this.getValidationErrors()).forEach(([key, value]) => {
                const match = key.match(/^productDocuments\.(\d+)\.(.+)$/);
                if (!match) {
                    next[key] = value;
                    return;
                }

                const oldIndex = Number(match[1]);
                if (!Object.prototype.hasOwnProperty.call(indexMap, oldIndex)) {
                    return;
                }

                next[`productDocuments.${indexMap[oldIndex]}.${match[2]}`] = value;
            });

            this.setValidationErrors(next);
        },

        removeDocumentValidationErrors(removedIndex) {
            const length = this.$parent.productData.productDocuments.length;
            const indexMap = {};

            for (let i = 0; i < length; i++) {
                if (i === removedIndex) {
                    continue;
                }

                indexMap[i] = i > removedIndex ? i - 1 : i;
            }

            this.rekeyDocumentValidationErrors(indexMap);
        },

        moveDocumentValidationErrors(fromIndex, toIndex, length) {
            if (fromIndex === toIndex) {
                return;
            }

            const indexMap = {};
            for (let i = 0; i < length; i++) {
                if (i === fromIndex) {
                    indexMap[i] = toIndex;
                } else if (fromIndex < toIndex && i > fromIndex && i <= toIndex) {
                    indexMap[i] = i - 1;
                } else if (fromIndex > toIndex && i >= toIndex && i < fromIndex) {
                    indexMap[i] = i + 1;
                } else {
                    indexMap[i] = i;
                }
            }

            this.rekeyDocumentValidationErrors(indexMap);
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
                    const document = this.$parent.productData.productDocuments[index];
                    const previousFilePath = document.file_path;
                    document.file_path = '/' + res.data;
                    this.suggestDocumentLabelFromPath(document, previousFilePath);

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
                label: null,
                _uid: `new-${Date.now()}-${Math.random().toString(36).slice(2, 8)}`,
            });
            this.reindexDocumentOrder();
        },

        removeDocument(index) {
            const document = this.$parent.productData.productDocuments[index];
            const isPersisted = document.id != null;
            const hasFilePath = document.file_path != null && String(document.file_path).trim() !== '';
            const hasEmbeddedContent = document.content != null && String(document.content).trim() !== '';

            this.$swal
                .fire({
                    title: 'Are you sure?',
                    showCancelButton: true,
                    confirmButtonColor: '#42ba96',
                    cancelButtonColor: '#ff7979',
                    confirmButtonText: 'Yes, delete it!',
                })
                .then((result) => {
                    if (!result.isConfirmed) {
                        return;
                    }

                    if (!isPersisted && !hasFilePath && !hasEmbeddedContent) {
                        this.removeDocumentValidationErrors(index);
                        this.$parent.productData.productDocuments.splice(index, 1);
                        this.reindexDocumentOrder();
                        new Noty({
                            type: 'success',
                            text: 'Document removed successfully',
                        }).show();
                        return;
                    }

                    axios
                        .post('/admin/product/remove_document', {
                            product_id: this.$parent.productData.id,
                            document_id: document.id ?? null,
                            document_type_id: document.document_type_id,
                            url: document.file_path,
                            content: document.content ?? null,
                        })
                        .then(() => {
                            this.removeDocumentValidationErrors(index);
                            this.$parent.productData.productDocuments.splice(index, 1);
                            this.reindexDocumentOrder();

                            new Noty({
                                type: 'success',
                                text: 'Document removed successfully',
                            }).show();
                        })
                        .catch((e) => {
                            new Noty({
                                type: 'error',
                                text: e.response?.data?.message ?? 'Unable to remove document.',
                            }).show();
                        });
                });
        },

        syncDocumentTypeMetadata(document) {
            if (!document.document_type_id) {
                return;
            }

            const documentType = this.$parent.allDocumentTypes.find(
                (docType) => docType.id == document.document_type_id,
            );

            if (!documentType) {
                return;
            }

            document.media_type = documentType.media_type;
            document.file_type = this.allFileTypes[documentType.media_type] ?? null;
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
                        const document = self.$parent.productData.productDocuments[self.index];
                        const previousFilePath = document.file_path;
                        document.file_path = self.all_disks[self.$store.state.fm.left.selectedDisk].url
                            ? self.all_disks[self.$store.state.fm.left.selectedDisk].url + '/' + filePath
                            : '/' + filePath;
                        self.suggestDocumentLabelFromPath(document, previousFilePath);
                        self.$parent.selectedFiles = document.file_path;
                    }
                    self.getFileAddedMessage();
                }
            },
        },
        '$parent.productData.productDocuments': {
            handler(newData) {
                (newData || []).forEach((document) => {
                    this.ensureDocumentUid(document);
                    this.syncDocumentTypeMetadata(document);
                });
            },
            deep: true,
            immediate: true,
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

.document-card-row {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    min-width: 0;
}

.document-fields-row {
    display: flex;
    flex: 1 1 auto;
    min-width: 0;
    flex-wrap: wrap;
    align-items: flex-start;
    gap: 12px;
}

.document-type-col {
    flex: 1 1 200px;
    min-width: 0;
    max-width: 100%;
}

.document-meta-col {
    flex: 2 1 320px;
    min-width: 0;
}

.document-meta-row {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-start;
    gap: 12px;
}

.document-label-col {
    flex: 1 1 180px;
    min-width: 0;
    max-width: 100%;
}

.document-path-wrap {
    display: flex;
    flex: 2 1 240px;
    min-width: 0;
    max-width: 100%;
    align-items: flex-start;
    gap: 8px;
}

.document-path-col {
    flex: 1 1 auto;
    min-width: 0;
}

.document-path-input-row {
    display: flex;
    align-items: center;
    gap: 8px;
    min-width: 0;
}

.document-path-input-row .document-path-group,
.document-path-input-row textarea {
    flex: 1 1 auto;
    min-width: 0;
}

.document-path-input-row.is-multiline {
    align-items: flex-start;
}

.document-path-label {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
}

.document-path-info {
    position: relative;
    display: inline-flex;
    align-items: center;
    color: #6c757d;
    cursor: help;
    font-size: 15px;
    line-height: 1;
}

.document-path-info:hover,
.document-path-info:focus {
    color: #42ba96;
    outline: none;
}

.document-path-info-tip {
    position: absolute;
    top: calc(100% + 8px);
    left: 0;
    z-index: 20;
    width: min(280px, 70vw);
    padding: 8px 10px;
    border-radius: 4px;
    background: #343a40;
    color: #fff;
    font-size: 12px;
    font-weight: 400;
    line-height: 1.4;
    white-space: normal;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity 0.15s ease, visibility 0.15s ease;
}

.document-path-info:hover .document-path-info-tip,
.document-path-info:focus .document-path-info-tip {
    opacity: 1;
    visibility: visible;
}

.document-path-group {
    flex-wrap: nowrap;
    width: 100%;
    overflow: hidden;
}

.document-path-group .form-control {
    min-width: 0;
    width: 1%;
}

.document-delete-col {
    flex: 0 0 auto;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    height: calc(1.5em + 0.75rem + 2px);
    font-weight: 900;
}

.document-path-input-row.is-multiline .document-delete-col {
    height: auto;
    padding-top: 0.45rem;
}

.document-upload-addon {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
}

@media (max-width: 991.98px) {
    .document-card-row {
        align-items: stretch;
    }

    .document-fields-row,
    .document-meta-row {
        flex-direction: column;
        flex-wrap: nowrap;
    }

    .document-type-col,
    .document-meta-col,
    .document-label-col,
    .document-path-wrap {
        flex: 1 1 auto;
        width: 100%;
        max-width: 100%;
    }
}

@media (min-width: 1400px) {
    .document-type-col {
        flex: 0 0 280px;
        max-width: 280px;
    }

    .document-label-col {
        flex: 0 0 380px;
        max-width: 380px;
    }
}

.document-order-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 22px;
    height: 22px;
    padding: 0 6px;
    border-radius: 999px;
    background: #eef2f6;
    color: #495057;
    font-size: 11px;
    font-weight: 700;
    line-height: 1;
    transition: background-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
}

.is-sorting .document-order-badge {
    background: #42ba96;
    color: #fff;
}
</style>
