<template>
    <div role="tabpanel" class="tab-pane active" id="tab_media">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <div class="card mb-3">
                        <div class="card-body">
                            <strong class="mb-3 d-block" :class="{ 'text-danger': $parent.validationErrors.main }"
                                >Main Image</strong
                            >
                            <div class="d-flex justify-content-between">
                                <div class="w-one-third m-auto">
                                    <input
                                        placeholder="upload path"
                                        type="text"
                                        class="form-control"
                                        :class="{ 'is-invalid': $parent.validationErrors.main }"
                                        v-model="$parent.productData.product_image.main"
                                    />
                                    <small v-if="$parent.validationErrors.main" class="text-danger mt-3">{{
                                        $parent.validationErrors.main[0]
                                    }}</small>
                                </div>
                                <div class="w-one-third text-center px-3 m-auto">
                                    <div class="btn-group">
                                        <label
                                            class="btn btn-light btn-sm btn-file py-2 mb-0 cursor-pointer"
                                            title="select file"
                                            for="main-image-browse"
                                        >
                                            <i class="la la-hand-pointer"></i>{{ titles.choose_file }}
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
                                        <label
                                            class="btn btn-light btn-sm btn-file py-2 mb-0 cursor-pointer border-left"
                                            title="select file"
                                            for="main-image"
                                        >
                                            <i class="la la-cloud-upload-alt"></i>{{ titles.upload_file }}
                                            <input
                                                id="main-image"
                                                type="file"
                                                class="form-control d-none file_design"
                                                title="select file"
                                                @change="uploadMainImage"
                                            />
                                        </label>
                                        <button
                                            class="d-none btn btn-light btn-sm"
                                            data-handle="remove"
                                            v-if="$parent.productData.product_image.main && false"
                                            @click="deleteImage('main', $parent.productData.product_image.main)"
                                            type="button"
                                        >
                                            <i class="la la-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="image w-one-third text-center">
                                    <div class="row justify-content-center">
                                        <div v-if="this.uploading.main" class="col-md-12">
                                            <ProgressBar></ProgressBar>
                                        </div>
                                        <div v-else>
                                            <button
                                                v-if="$parent.productData.product_image.main"
                                                class="btn btn-sm bg-danger rounded-circle p-1 position-absolute e-0 cursor-pointer"
                                                data-handle="remove"
                                                style="width: 22px; height: 22px; line-height: 1"
                                                @click="deleteImage('main', $parent.productData.product_image.main)"
                                            >
                                                <i class="la la-times"></i>
                                            </button>
                                            <img
                                                @error="$root.getDefaultImage"
                                                class="img-thumbnail"
                                                style="height: 79px"
                                                :src="`${$parent.productData.product_image.main}`"
                                                alt=""
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="card mb-3">
                        <div class="card-body">
                            <strong class="mb-3 d-block" :class="{ 'text-danger': $parent.validationErrors.thumbnail }"
                                >Thumbnail</strong
                            >
                            <div class="d-flex justify-content-between">
                                <div class="mr-3 w-one-third m-auto">
                                    <input
                                        placeholder="upload path"
                                        type="text"
                                        class="form-control"
                                        :class="{ 'is-invalid': $parent.validationErrors.thumbnail }"
                                        v-model="$parent.productData.product_image.thumbnail"
                                    />
                                    <small v-if="$parent.validationErrors.thumbnail" class="text-danger mt-3">{{
                                        $parent.validationErrors.thumbnail[0]
                                    }}</small>
                                </div>
                                <div class="w-one-third text-center px-3 m-auto">
                                    <div class="btn-group">
                                        <label
                                            class="btn btn-light btn-sm btn-file py-2 mb-0 cursor-pointer border-right"
                                            for="thumb-image-browse"
                                        >
                                            <i class="la la-hand-pointer"></i>{{ titles.choose_file }}
                                            <input
                                                id="thumb-image-browse"
                                                type="text"
                                                class="form-control d-none file_design"
                                                title="select file"
                                                @click="
                                                    processImagesByType('thumbnail');
                                                    getImageBrowseModal();
                                                    canMultiple = false;
                                                    browseThumbImage($event);
                                                "
                                            />
                                        </label>
                                        <label
                                            class="btn btn-light btn-sm btn-file py-2 mb-0 cursor-pointer border-left"
                                            title="select file"
                                            for="thumb-image"
                                        >
                                            <i class="la la-cloud-upload-alt"></i>{{ titles.upload_file }}
                                            <input
                                                id="thumb-image"
                                                type="file"
                                                class="form-control d-none file_design"
                                                title="select file"
                                                @change="uploadThumbImage"
                                            />
                                        </label>
                                        <button
                                            class="d-none btn btn-light btn-sm"
                                            data-handle="remove"
                                            v-if="$parent.productData.product_image.thumbnail && false"
                                            @click="
                                                deleteImage('thumbnail', $parent.productData.product_image.thumbnail)
                                            "
                                            type="button"
                                        >
                                            <i class="la la-times"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="image w-one-third text-center">
                                    <div class="row justify-content-center">
                                        <div v-if="this.uploading.thumb" class="col-md-12">
                                            <ProgressBar></ProgressBar>
                                        </div>
                                        <div v-else>
                                            <button
                                                v-if="$parent.productData.product_image.thumbnail"
                                                class="btn btn-sm bg-danger rounded-circle p-1 position-absolute e-0 cursor-pointer"
                                                data-handle="remove"
                                                style="width: 22px; height: 22px; line-height: 1"
                                                @click="
                                                    deleteImage(
                                                        'thumbnail',
                                                        $parent.productData.product_image.thumbnail,
                                                    )
                                                "
                                            >
                                                <i class="la la-times"></i>
                                            </button>
                                            <img
                                                @error="$root.getDefaultImage"
                                                class="img-thumbnail"
                                                style="height: 79px"
                                                :src="`${$parent.productData.product_image.thumbnail ? $parent.productData.product_image.thumbnail : placeholder}`"
                                                alt=""
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="card mb-3">
                        <div class="card-body">
                            <strong
                                class="mb-3 d-block"
                                :class="{ 'text-danger': $parent.validationErrors.additional }"
                            >
                                Additional Media
                            </strong>
                            <div class="d-flex justify-content-between">
                                <div class="mr-0 w-one-third my-auto">
                                    <input
                                        placeholder="upload path"
                                        type="text"
                                        class="form-control"
                                        :class="{ 'is-invalid': $parent.validationErrors.additional }"
                                        readonly="readonly"
                                        v-model="$parent.productData.product_image.additional"
                                    />
                                    <small v-if="$parent.validationErrors.additional" class="text-danger mt-3">{{
                                        $parent.validationErrors.additional[0]
                                    }}</small>
                                </div>

                                <div class="w-one-third text-center px-3 my-auto">
                                    <div class="btn-group">
                                        <label
                                            class="btn btn-light btn-sm btn-file py-2 mb-0 cursor-pointer border-right"
                                            title="select file"
                                            for="additional-image-browse"
                                        >
                                            <i class="la la-hand-pointer"></i>{{ titles.choose_file }}
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
                                        <label
                                            class="btn btn-light btn-sm btn-file py-2 mb-0 cursor-pointer border-left"
                                            title="select file"
                                            for="additional-image"
                                        >
                                            <i class="la la-cloud-upload-alt"></i>{{ titles.upload_file }}
                                            <input
                                                id="additional-image"
                                                type="file"
                                                class="form-control d-none file_design"
                                                title="select file"
                                                @change="uploadAdditionalMedia"
                                            />
                                        </label>
                                        <button
                                            class="btn btn-light btn-sm d-none"
                                            data-handle="remove"
                                            v-if="$parent.productData.product_image.additional && false"
                                            @click="
                                                deleteImage('additional', $parent.productData.product_image.additional)
                                            "
                                            type="button"
                                        >
                                            <i class="la la-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="image w-one-third text-center">
                                    <div class="row justify-content-center">
                                        <div v-if="this.uploading.additional" class="col-md-12">
                                            <ProgressBar></ProgressBar>
                                        </div>
                                        <div
                                            v-else-if="
                                                $parent.productData.product_image.additional &&
                                                $parent.productData.product_image.additional.length > 0
                                            "
                                            v-for="(additional, index) in $parent.productData.product_image.additional"
                                            class="position-relative mx-2 my-1"
                                        >
                                            <button
                                                class="btn btn-sm bg-danger rounded-circle p-1 position-absolute e-0 cursor-pointer"
                                                @click="deleteAdditionalMedia(index)"
                                                style="width: 22px; height: 22px; line-height: 1"
                                            >
                                                <i class="la la-times"></i>
                                            </button>
                                            <img
                                                v-if="isYouTubeLink(additional)"
                                                class="img-thumbnail"
                                                style="height: 79px"
                                                :src="getYouTubeThumbnail(additional)"
                                                :alt="index"
                                                loading="lazy"
                                            />
                                            <img
                                                v-else
                                                @error="$root.getDefaultImage"
                                                class="img-thumbnail"
                                                style="height: 79px"
                                                :src="`${additional ? additional : placeholder}`"
                                                :alt="index"
                                                loading="lazy"
                                            />
                                        </div>
                                        <div v-else>
                                            <img
                                                @error="$root.getDefaultImage"
                                                class="img-thumbnail"
                                                style="height: 79px"
                                                :src="`${placeholder}`"
                                                alt="No image found"
                                                loading="lazy"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Button to Open file manager Modal -->
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

export default {
    name: 'Media',
    mixins: [allDisksMixin],
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
                choose_file: ' Choose File',
            },
            canMultiple: false,
            domLoaded: false,
            type: 'main',
        };
    },
    mounted() {
        this.$parent.checkIfProductCode();
        let type_name = this.$parent.productData.product_type;

        this.image.main.directory = `uploads/images/product/${type_name}/main`;
        this.image.thumb.directory = `uploads/images/product/${type_name}/thumbnail`;
        this.image.additional.directory = `uploads/images/product/${type_name}/additional`;

        this.$parent.getDynamicCurrentPreviousTabIds();
    },
    methods: {
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
            this.$parent.selectedFiles =
                this.$parent.productData.product_image[this.type] ?? (this.type === 'additional' ? [] : null);
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
                //icon              : 'warning',
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
                //icon              : 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff6b81',
                cancelButtonColor: '#399E7F',
                confirmButtonText: 'Remove',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$parent.productData.product_image.additional.splice(index, 1);

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
                        if (_.isArray(this.$parent.productData.product_image.additional)) {
                            this.$parent.productData.product_image.additional.push(imgLink);
                        } else {
                            this.$parent.productData.product_image.additional = [imgLink];
                        }
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

        isYouTubeLink(url) {
            // Regular expression pattern to match YouTube embed URLs
            var youtubePattern = /^https?:\/\/(?:www\.)?youtube\.com\/embed\/([a-zA-Z0-9_-]+)$/;

            // Test the URL against the pattern
            return youtubePattern.test(url);
        },

        getYouTubeThumbnail(url) {
            if (this.isYouTubeLink(url)) {
                // Extract video ID from the YouTube embed URL
                var videoId = url.match(/\/embed\/([a-zA-Z0-9_-]+)/)[1];

                // Return the URL for the default YouTube thumbnail
                return `https://img.youtube.com/vi/${videoId}/default.jpg`;
            }
        },
    },
    watch: {
        '$store.state.fm.left.selected.files': {
            handler(files) {
                if (files.length) {
                    const self = this;

                    if (self.canMultiple) {
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
.w-one-third {
    width: 33.33%;
}

.cursor-pointer {
    cursor: pointer;
}

.e-0 {
    right: 0;
}

.right-custom {
    right: 7rem;
}
</style>
