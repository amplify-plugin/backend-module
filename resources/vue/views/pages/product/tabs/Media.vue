<template>
    <div role="tabpanel" class="tab-pane active" id="tab_media">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <div class="card mb-3">
                        <div class="card-body">
                            <strong
                                class="media-section-label"
                                :class="{ 'text-danger': $parent.validationErrors.main }"
                            >
                                Main Image
                                <span
                                    class="media-info"
                                    tabindex="0"
                                    aria-label="Use Upload to pick an image from the file manager, or paste a direct image URL."
                                >
                                    <i class="la la-info-circle" aria-hidden="true"></i>
                                    <span class="media-info-tip" role="tooltip">
                                        Use Upload to pick an image from the file manager, or paste a direct image URL
                                        (S3, CDN, or other hosted image). PDFs and other documents belong on the
                                        Documents tab.
                                    </span>
                                </span>
                            </strong>

                            <div class="media-row">
                                <div class="media-path-col">
                                    <div class="input-group media-path-group">
                                        <div class="input-group-prepend">
                                            <label
                                                class="btn btn-light mb-0 cursor-pointer media-upload-addon"
                                                title="Upload image"
                                                for="main-image-browse"
                                            >
                                                <i class="la la-cloud-upload-alt"></i>
                                                Upload
                                                <input
                                                    id="main-image-browse"
                                                    type="text"
                                                    class="form-control d-none file_design"
                                                    title="select file"
                                                    @click="
                                                        processImagesByType('main');
                                                        getImageBrowseModal();
                                                        canMultiple = false;
                                                        browseMainImage($event);
                                                    "
                                                />
                                            </label>
                                        </div>
                                        <input
                                            placeholder="Select a File or Enter URL"
                                            type="text"
                                            class="form-control"
                                            :class="{ 'is-invalid': $parent.validationErrors.main }"
                                            v-model="$parent.productData.product_image.main"
                                        />
                                    </div>
                                    <small v-if="$parent.validationErrors.main" class="text-danger d-block mt-1">{{
                                        $parent.validationErrors.main[0]
                                    }}</small>
                                </div>

                                <div class="media-preview-col">
                                    <div v-if="uploading.main" class="media-thumb-card">
                                        <ProgressBar></ProgressBar>
                                    </div>
                                    <div v-else-if="$parent.productData.product_image.main" class="media-thumb-card">
                                        <div class="media-thumb-frame">
                                            <img
                                                @error="$root.getDefaultImage"
                                                class="img-thumbnail media-preview-image"
                                                :src="$parent.productData.product_image.main"
                                                alt="Main image"
                                            />
                                            <button
                                                type="button"
                                                class="btn btn-sm bg-danger rounded-circle p-1 media-delete-btn"
                                                data-handle="remove"
                                                title="Remove main image"
                                                @click="deleteImage('main', $parent.productData.product_image.main)"
                                            >
                                                <i class="la la-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div v-else class="media-empty media-empty-compact">No main image selected</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="card mb-3">
                        <div class="card-body">
                            <strong
                                class="media-section-label"
                                :class="{ 'text-danger': $parent.validationErrors.additional }"
                            >
                                Additional Media
                                <span
                                    class="media-info"
                                    tabindex="0"
                                    aria-label="Add extra product images from the file manager or by pasting a direct image URL."
                                >
                                    <i class="la la-info-circle" aria-hidden="true"></i>
                                    <span class="media-info-tip" role="tooltip">
                                        Add extra product images. Use Upload to pick files from the file manager, or
                                        paste a direct image URL and press Enter. PDFs and other documents belong on
                                        the Documents tab.
                                    </span>
                                </span>
                            </strong>

                            <div class="media-additional-path mb-3">
                                <div class="input-group media-path-group">
                                    <div class="input-group-prepend">
                                        <label
                                            class="btn btn-light mb-0 cursor-pointer media-upload-addon"
                                            title="Upload images"
                                            for="additional-image-browse"
                                        >
                                            <i class="la la-cloud-upload-alt"></i>
                                            Upload
                                            <input
                                                id="additional-image-browse"
                                                type="text"
                                                class="form-control d-none file_design"
                                                title="select file"
                                                @click="
                                                    processImagesByType('additional');
                                                    getImageBrowseModal();
                                                    canMultiple = true;
                                                    browseAdditionalMedia($event);
                                                "
                                            />
                                        </label>
                                    </div>
                                    <input
                                        placeholder="Select a File or paste a URL and press Enter"
                                        type="text"
                                        class="form-control"
                                        :class="{ 'is-invalid': $parent.validationErrors.additional }"
                                        v-model="additionalUrlDraft"
                                        @keydown.enter.prevent="addAdditionalUrl"
                                    />
                                </div>
                                <small v-if="$parent.validationErrors.additional" class="text-danger d-block mt-1">{{
                                    $parent.validationErrors.additional[0]
                                }}</small>
                            </div>

                            <div v-if="uploading.additional" class="mb-2">
                                <ProgressBar></ProgressBar>
                            </div>

                            <sortable-list
                                v-if="additionalItems.length > 0"
                                :items="additionalItems"
                                order-key=""
                                drop-axis="horizontal"
                                hint="Drag the handle to change additional media order."
                                ghost-selector=".media-thumb-card"
                                item-class="media-gallery-item"
                            >
                                <template #item="{ item: additional, index, dragStart, dragEnd }">
                                    <div class="media-thumb-card">
                                        <sortable-handle
                                            :index="index"
                                            :drag-start="dragStart"
                                            :drag-end="dragEnd"
                                            title="Drag to reorder"
                                        />
                                        <div class="media-thumb-frame">
                                            <img
                                                v-if="isYouTubeLink(additional)"
                                                class="img-thumbnail media-gallery-image"
                                                :src="getYouTubeThumbnail(additional)"
                                                :alt="`Additional media ${index + 1}`"
                                                loading="lazy"
                                            />
                                            <div v-else-if="isVideoUrl(additional)" class="media-video-tile">
                                                <i class="la la-play-circle"></i>
                                                <span>{{ mediaFileName(additional) }}</span>
                                            </div>
                                            <img
                                                v-else
                                                @error="$root.getDefaultImage"
                                                class="img-thumbnail media-gallery-image"
                                                :src="additional"
                                                :alt="`Additional media ${index + 1}`"
                                                loading="lazy"
                                            />
                                            <button
                                                type="button"
                                                class="btn btn-sm bg-danger rounded-circle p-1 media-delete-btn"
                                                title="Remove additional media"
                                                @click="deleteAdditionalMedia(index)"
                                            >
                                                <i class="la la-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </sortable-list>
                            <div v-else class="media-empty">No additional media yet</div>
                        </div>
                    </div>
                </div>

                <button
                    type="button"
                    class="btn btn-primary d-none"
                    data-toggle="modal"
                    data-target="#filemanagerModal"
                >
                    Open Filemanager
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import allDisksMixin from '../../../../allDisks.mixin';
import $ from 'jquery';
import SortableList from '../../../components/sortable-list/SortableList.vue';
import SortableHandle from '../../../components/sortable-list/SortableHandle.vue';

export default {
    name: 'Media',
    mixins: [allDisksMixin],
    components: { SortableList, SortableHandle },
    data() {
        return {
            image: {
                main: { directory: '' },
                thumb: { directory: '' },
                additional: { directory: '' },
            },
            placeholder: this.$root.config.fallback_image,
            uploading: {
                main: false,
                thumb: false,
                additional: false,
            },
            titles: {
                upload_file: ' Upload File',
                choose_file: ' Choose / Upload File',
            },
            canMultiple: false,
            domLoaded: false,
            type: 'main',
            additionalUrlDraft: '',
        };
    },
    computed: {
        additionalItems() {
            const items = this.$parent.productData.product_image.additional;
            return Array.isArray(items) ? items : [];
        },
    },
    mounted() {
        this.$parent.checkIfProductCode();
        let type_name = this.$parent.productData.product_type;

        this.image.main.directory = `uploads/images/product/${type_name}/main`;
        this.image.thumb.directory = `uploads/images/product/${type_name}/thumbnail`;
        this.image.additional.directory = `uploads/images/product/${type_name}/additional`;

        this.ensureAdditionalArray();
        this.$parent.getDynamicCurrentPreviousTabIds();
    },
    methods: {
        ensureAdditionalArray() {
            const current = this.$parent.productData.product_image.additional;
            if (Array.isArray(current)) {
                return current;
            }

            this.$parent.productData.product_image.additional = current ? [current] : [];
            return this.$parent.productData.product_image.additional;
        },

        looksLikeMediaUrl(value) {
            return /^(https?:\/\/|\/)/i.test(String(value || '').trim());
        },

        addAdditionalUrl() {
            const url = String(this.additionalUrlDraft || '').trim();
            if (!this.looksLikeMediaUrl(url)) {
                return;
            }

            const items = this.ensureAdditionalArray();
            if (items.indexOf(url) === -1) {
                items.push(url);
            }

            this.additionalUrlDraft = '';
        },

        mediaFileName(url) {
            if (!url) {
                return 'Media';
            }

            try {
                const path = String(url).split('?')[0];
                return decodeURIComponent(path.split('/').pop() || 'Media');
            } catch (_error) {
                return 'Media';
            }
        },

        isVideoUrl(url) {
            const extension = this.getFileExtension(String(url || '').toLowerCase());
            return ['mp4', 'avi', 'mkv', 'webm', 'mov'].includes(extension);
        },

        removeSelectedFiles(index, length = 1) {
            let path = this.$parent.selectedFiles.splice(index, length);
            let noty = {
                type: 'success',
                text: `File (${path}) removed!`,
            };
            new Noty(noty).show();
        },

        processImagesByType(type = 'main') {
            this.type = type;
            const currentValue = this.$parent.productData.product_image[this.type];

            if (this.type === 'additional') {
                this.$parent.selectedFiles = this.ensureAdditionalArray();
            } else {
                this.$parent.selectedFiles = currentValue || null;
            }
        },

        getFileAddedMessage() {
            let noty = {
                type: 'success',
                text: 'File path added!',
            };

            new Noty(noty).show();
        },

        deleteImage(type, url) {
            this.$swal({
                title: 'Remove this Image?',
                showCancelButton: true,
                confirmButtonColor: '#ff6b81',
                cancelButtonColor: '#399E7F',
                confirmButtonText: 'Remove',
            }).then((result) => {
                if (result.isConfirmed) {
                    let product_id = this.$parent.productData.id ? this.$parent.productData.id : '';
                    axios
                        .post('/admin/product/remove_image', { url: url, product_id: product_id, type: type })
                        .then((res) => {
                            new Noty({
                                type: 'success',
                                text: res.data + ' deleted successfully',
                            }).show();
                            this.$parent.productData.product_image[type] = '';
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

        deleteAdditionalMedia(index) {
            this.$swal({
                title: 'Remove this Image?',
                showCancelButton: true,
                confirmButtonColor: '#ff6b81',
                cancelButtonColor: '#399E7F',
                confirmButtonText: 'Remove',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.ensureAdditionalArray().splice(index, 1);

                    new Noty({
                        type: 'success',
                        text: 'Additional media removed successfully',
                    }).show();
                }
            });
        },

        sendDataToServer(base64, directory, local_url, type, product_code = null) {
            this.uploading[type] = true;
            axios
                .post('/admin/product/upload_image', { image: base64, directory: directory, productCode: product_code })
                .then((res) => {
                    let imgLink = '/' + res.data;
                    if (type === 'main') this.$parent.productData.product_image.main = imgLink;
                    else if (type === 'thumb') this.$parent.productData.product_image.thumbnail = imgLink;
                    else if (type === 'additional') {
                        this.ensureAdditionalArray().push(imgLink);
                    }

                    new Noty({
                        type: 'success',
                        text: res.data + ' Uploaded successfully',
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
                    this.uploading[type] = false;
                });
        },

        uploadMainImage(event) {
            let file = event.target.files[0];
            let base64image = '';
            if (file.size > 3048770) {
                alert('image must not be greater than 3048770 bytes');
            } else {
                let reader = new FileReader();
                reader.onload = (event) => {
                    base64image = event.target.result;
                    this.sendDataToServer(
                        base64image,
                        this.image.main.directory,
                        this.$parent.productData.image_url,
                        'main',
                        this.$parent.productData.product_code,
                    );
                };
                reader.readAsDataURL(file);
            }
        },

        uploadThumbImage(event) {
            let file = event.target.files[0];
            let base64image = '';
            if (file.size > 3048770) {
                alert('image must not be greater than 3048770 bytes');
            } else {
                let reader = new FileReader();
                reader.onload = (event) => {
                    base64image = event.target.result;
                    this.sendDataToServer(
                        base64image,
                        this.image.thumb.directory,
                        this.$parent.productData.thumbnail,
                        'thumb',
                        this.$parent.productData.product_code,
                    );
                };
                reader.readAsDataURL(file);
            }
        },

        uploadAdditionalMedia(event) {
            let file = event.target.files[0];
            let base64image = '';
            if (file.size > 3048770) {
                alert('image must not be greater than 3048770 bytes');
            } else {
                let reader = new FileReader();
                reader.onload = (event) => {
                    base64image = event.target.result;
                    this.sendDataToServer(
                        base64image,
                        this.image.additional.directory,
                        this.$parent.productData.additional_image_urls,
                        'additional',
                        this.$parent.productData.product_code,
                    );
                };
                reader.readAsDataURL(file);
            }
        },

        browseMainImage(event) {
            event.preventDefault();
        },

        browseThumbImage(event) {
            event.preventDefault();
        },

        browseAdditionalMedia(event) {
            event.preventDefault();
        },

        slugify(name) {
            if (!_.isEmpty(this.$parent.productData.product_classification)) {
                return name.replace(/[^A-Z0-9]/gi, '_').toLowerCase();
            }
        },

        getImageBrowseModal() {
            setTimeout(() => {
                let modal = document.querySelector('[data-target="#filemanagerModal"]');
                modal?.click();
                let modalDismisses = document.querySelectorAll('[data-dismiss="modal"]');
                let modalShadeDefault = document.querySelector('.modal-backdrop.show');
                modalShadeDefault ? modalShadeDefault.remove() : null;

                let modalShade = document.createElement('div');
                modalShade.classList.add('modal-backdrop', 'show');

                this.$parent.modalShade = modalShade.outerHTML;

                this.$store.state.fm.left.search = '';
                modalDismisses.forEach((modalDismiss) => {
                    modalDismiss.addEventListener('click', () => {
                        this.$store.dispatch('fm/resetState');
                        this.$store.dispatch('fm/initializeApp');
                        this.$store.state.search = '';
                        this.$parent.modalShade = '';
                    });
                });

                this.$parent.modalBody = document.querySelector('#filemanagerModal .modal-body').innerHTML;

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

        isYouTubeLink(url) {
            var youtubePattern = /^https?:\/\/(?:www\.)?youtube\.com\/embed\/([a-zA-Z0-9_-]+)$/;

            return youtubePattern.test(url);
        },

        getYouTubeThumbnail(url) {
            if (this.isYouTubeLink(url)) {
                var videoId = url.match(/\/embed\/([a-zA-Z0-9_-]+)/)[1];

                return `https://img.youtube.com/vi/${videoId}/default.jpg`;
            }
        },
    },
    watch: {
        '$parent.productData.product_image.additional': {
            handler() {
                this.ensureAdditionalArray();
            },
        },
        '$store.state.fm.left.selected.files': {
            handler(files) {
                if (files.length) {
                    const self = this;

                    if (self.canMultiple) {
                        if (!Array.isArray(self.$parent.selectedFiles)) {
                            self.$parent.selectedFiles = this.ensureAdditionalArray();
                        }

                        let filesPath = files.filter((file) => {
                            return ['jpg', 'jpeg', 'png', 'mp4', 'avi', 'mkv'].includes(
                                self.getFileExtension(file.toLowerCase()),
                            );
                        });

                        if (filesPath) {
                            filesPath.map((filePath) => {
                                let image = self.all_disks[self.$store.state.fm.left.selectedDisk].url
                                    ? self.all_disks[self.$store.state.fm.left.selectedDisk].url + '/' + filePath
                                    : '/' + filePath;
                                if (self.$parent.selectedFiles.indexOf(image) === -1)
                                    self.$parent.selectedFiles.push(image);
                            });
                        }
                    } else {
                        let filePath = files.find((file) => {
                            return ['jpg', 'jpeg', 'png', 'mp4', 'avi', 'mkv'].includes(
                                self.getFileExtension(file.toLowerCase()),
                            );
                        });

                        if (filePath) {
                            self.$parent.selectedFiles = self.all_disks[self.$store.state.fm.left.selectedDisk].url
                                ? self.all_disks[self.$store.state.fm.left.selectedDisk].url + '/' + filePath
                                : '/' + filePath;
                        }
                    }
                    self.getFileAddedMessage();
                }
            },
        },
    },
};
</script>

<style scoped>
.media-section-label {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 12px;
}

.media-info {
    position: relative;
    display: inline-flex;
    align-items: center;
    color: #6c757d;
    cursor: help;
    font-size: 15px;
    font-weight: 400;
    line-height: 1;
}

.media-info:hover,
.media-info:focus {
    color: #42ba96;
    outline: none;
}

.media-info-tip {
    position: absolute;
    top: calc(100% + 8px);
    left: 0;
    z-index: 20;
    width: min(300px, 70vw);
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

.media-info:hover .media-info-tip,
.media-info:focus .media-info-tip {
    opacity: 1;
    visibility: visible;
}

.media-row {
    display: flex;
    flex-wrap: nowrap;
    align-items: center;
    gap: 16px;
    width: 100%;
}

.media-path-col {
    flex: 1 1 auto;
    min-width: 0;
}

.media-additional-path {
    width: 100%;
    max-width: 100%;
}

.media-preview-col {
    flex: 0 0 auto;
    margin-left: auto;
}

.media-path-group {
    flex-wrap: nowrap;
    width: 100%;
}

.media-path-group .form-control {
    min-width: 0;
    width: 1%;
}

.media-upload-addon {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
}

.media-preview-box,
.media-thumb-card {
    display: flex;
    align-items: center;
    gap: 8px;
}

.media-thumb-frame {
    position: relative;
    display: inline-flex;
    line-height: 0;
}

.media-preview-image,
.media-gallery-image {
    height: 96px;
    width: auto;
    max-width: 160px;
    object-fit: cover;
}

.media-delete-btn {
    position: absolute;
    top: -7px;
    right: -7px;
    z-index: 2;
    width: 22px;
    height: 22px;
    line-height: 1;
    font-weight: 900;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
}

.media-empty {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 96px;
    padding: 12px 16px;
    border: 1px dashed #ced4da;
    border-radius: 4px;
    color: #6c757d;
    font-size: 13px;
    background: #f8f9fa;
}

.media-empty-compact {
    width: 180px;
    min-width: 180px;
    padding: 8px 12px;
    text-align: center;
}

.media-gallery-item {
    display: inline-flex;
    margin: 0 12px 12px 0;
    min-width: 0;
    vertical-align: top;
}

::v-deep .sortable-list {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-start;
}

::v-deep .sortable-item.media-gallery-item {
    display: inline-flex;
    overflow: visible;
    width: auto;
    margin: 0 12px 12px 0;
}

.media-thumb-card {
    position: relative;
    padding: 8px;
    overflow: visible;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    background: #fff;
}

.media-video-tile {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 4px;
    height: 96px;
    width: 140px;
    padding: 8px;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    background: #f8f9fa;
    color: #495057;
    font-size: 11px;
    text-align: center;
    word-break: break-all;
}

.media-video-tile i {
    font-size: 22px;
}

.cursor-pointer {
    cursor: pointer;
}

@media (max-width: 991.98px) {
    .media-row {
        flex-wrap: wrap;
        flex-direction: column;
        align-items: stretch;
    }

    .media-preview-col {
        margin-left: 0;
    }
}
</style>
