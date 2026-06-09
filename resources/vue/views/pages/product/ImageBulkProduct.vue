<template>
    <div class="row">
        <div :class="class_name">
            <!-- Default box -->
            <form method="post" @submit.prevent="" :action="backUrl" id="image-add-to-bulk-products">
                <div class="card">
                    <div class="card-body rounded">
                        <div class="form-group required">
                            <label>Product Image</label>
                            <div class="controls">
                                <div class="input-group">
                                    <input
                                        type="text"
                                        name="logo_path"
                                        v-model="productImage.image_path"
                                        id="logo_path"
                                        class="form-control"
                                        :class="{ 'border-danger': !!validationErrors.imagePath }"
                                    />

                                    <span class="input-group-append">
                                        <button
                                            form=""
                                            type="button"
                                            class="btn btn-light btn-sm popup_selector"
                                            :class="{ 'border-danger': !!validationErrors.imagePath }"
                                            data-toggle="modal"
                                            data-target="#widget-attributes-modal"
                                            @click="
                                                prepareModal('header');
                                                processImagesByType();
                                                canMultiple = false;
                                            "
                                        >
                                            <i class="la la-cloud-upload"></i> Browse
                                        </button>
                                        <button
                                            form=""
                                            type="button"
                                            class="btn btn-light btn-sm clear_elfinder_picker"
                                            :class="{ 'border-danger': !!validationErrors.imagePath }"
                                            @click="deleteImage()"
                                        >
                                            <i class="la la-eraser"></i> Clear
                                        </button>
                                    </span>
                                </div>
                                <small v-if="!!validationErrors.imagePath" class="text-danger">
                                    {{ validationErrors.imagePath }}
                                </small>
                            </div>
                            <label class="d-block">Preview</label>
                            <div class="img-preview-wrapper border p-2">
                                <img
                                    :src="
                                        productImage.image_path === ''
                                            ? $root.config.fallback_image
                                            : productImage.image_path
                                    "
                                    class="rounded d-block mx-auto"
                                    alt="Product image"
                                    height="150"
                                />
                            </div>
                        </div>
                        <!-- Product Search Input -->
                        <div class="form-group required">
                            <label>Search By Product Name/Code</label>
                            <div class="controls">
                                <div class="input-group w-25">
                                    <input
                                        type="text"
                                        name="search-key"
                                        v-model="productSearchKey"
                                        @keyup.enter="searchProduct"
                                        id="search-key"
                                        class="form-control"
                                        :disabled="isSearching"
                                        ref="searchKeyInput"
                                    />

                                    <span class="input-group-append">
                                        <button
                                            form=""
                                            type="button"
                                            class="btn btn-warning btn-sm"
                                            @click="searchProduct"
                                            :disabled="isSearching"
                                        >
                                            <template v-if="isSearching">
                                                <i class="la la-spinner la-pulse" /> Searching
                                            </template>
                                            <template v-else> <i class="la la-search"></i> Search </template>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!--            Products table            -->
                        <div
                            v-if="searchResults.length"
                            class="alert alert-info py-2 px-3"
                        >
                            Total Products Found:
                            <strong>{{ searchResults.length }}</strong>
                        </div>

                        <table
                            class="table table-bordered table-hover"
                            v-if="searchResults.length"
                        >
                            <thead>
                            <tr>
                                <th width="50">
                                    <input
                                        type="checkbox"
                                        :checked="searchResults.length && selectedProducts.length === searchResults.length"
                                        @change="toggleSelectAll"
                                    >
                                </th>
                                <th>Current Product Image</th>
                                <th>Product Code</th>
                                <th>Product Name</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr
                                v-for="product in searchResults"
                                :key="product.id"
                                @click="toggleProductSelection(product)"
                                style="cursor:pointer"
                                :class="{
                                    'table-primary': isSelected(product.id)
                                }"
                            >
                                <td
                                    class="text-center align-middle"
                                    @click.stop
                                >
                                    <input
                                        type="checkbox"
                                        :checked="isSelected(product.id)"
                                        @change="toggleProductSelection(product)"
                                    >
                                </td>

                                <td style="width: 200px; height: 80px" class="p-2">
                                    <img
                                        :src="productImagePath(product.product_image)"
                                        :alt="product.local_product_name"
                                        class="w-auto mr-2"
                                        style="height: 80px"
                                    />
                                </td>

                                <td>
                                    {{ product.product_code }}
                                </td>

                                <td>
                                    {{ product.local_product_name }}
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <!-- Product Ids Error Message -->
                        <div
                            class="alert alert-danger px-4 py-2"
                            v-if="!!validationErrors.productIds && selectedProducts.length === 0"
                        >
                            {{ validationErrors.productIds }}
                        </div>
                        <!-- submit button -->
                        <div v-if="selectedProducts.length" class="alert alert-success py-2 px-3">
                            Selected Products: <strong>{{ selectedProducts.length }}</strong>
                        </div>
                        <div id="saveActions" class="form-group">
                            <button
                                form="image-add-to-bulk-products"
                                @click="saveImageForSelectedProducts()"
                                type="button"
                                class="btn btn-success"
                            >
                                <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                                <span data-value="save_and_edit"> Save</span>
                            </button>

                            <button form="" @click="window.location.reload()" type="button" class="btn btn-default">
                                <span class="la la-ban"></span> Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- File Manager Modal -->
        <div
            class="modal fade"
            id="widget-attributes-modal"
            tabIndex="0"
            role="dialog"
            aria-labelledby="widget-attributes-modal-dialog-label"
            data-backdrop="static"
            data-keyboard="false"
            aria-modal="true"
        >
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="attribute-inline-create-dialog-label">
                            Set image for adding to multiple products <strong> </strong>
                        </h5>
                        <button
                            form=""
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
                        <div class="card" style="margin-bottom: 0 !important">
                            <div class="card-body">
                                <div class="col-12 mt-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <file-manager ref="fileManager"></file-manager>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            form=""
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                            @click="modalShade = ''"
                            aria-label="Close"
                            id="cancelWidgetAttributesModalBtn"
                        >
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import allDisksMixin from '../../../allDisks.mixin';
export default {
    name: 'ImageUpdateForBulkProduct',
    mixins: [allDisksMixin],
    props: ['class_name', 'axios_url'],
    components: {},
    data() {
        return {
            backUrl: '/admin/products/bulk-image-update',
            searchUrl: '/admin/product/fetch/product-by-name',
            validationErrors: {},
            actionType: 'save_and_edit',
            selectedFiles: [],
            modalShade: '',
            productSearchKey: '',
            productImage: {
                image_path: '',
            },
            searchResults: [],
            selectedProducts: [],
            isSearching: false,
        };
    },
    mounted() {},
    methods: {
        async saveImageForSelectedProducts() {
            const productIds = this.selectedProducts.map((product) => product.id);

            this.validationErrors = {};

            let productIdsError = false;
            let imagePathError = false;

            if (productIds.length === 0) {
                this.validationErrors.productIds = 'Please select at-least 1 product';
                productIdsError = true;
            }

            if (!this.productImage?.image_path || this.productImage.image_path === '') {
                this.validationErrors.imagePath = 'Image path cannot be empty';
                imagePathError = true;
            }

            if (productIdsError || imagePathError) {
                return;
            }

            getFullPageLoader();

            try {
                const chunkSize = 500;

                for (let i = 0; i < productIds.length; i += chunkSize) {
                    const productIdsChunk = productIds.slice(i, i + chunkSize);

                    await axios.post(this.axios_url, {
                        image_path: this.productImage.image_path,
                        product_ids: productIdsChunk,
                    });
                }

                new Noty({
                    type: 'success',
                    text: `Image updated for ${productIds.length} products`,
                }).show();

                this.selectedProducts = [];
                this.searchResults = [];
                this.productImage = {
                    image_path: '',
                };
                this.productSearchKey = '';
            } catch (err) {
                const errorMessage = err.response?.data
                    ? err.response.data.message
                    : 'Something went wrong please try again';

                new Noty({
                    type: 'error',
                    text: errorMessage,
                }).show();
            } finally {
                removeFullPageLoader();
            }
        },
        searchProduct() {
            const searchKey = this.productSearchKey.trim();
            if (searchKey && typeof searchKey === 'string' && searchKey.length > 0) {
                this.isSearching = true;
                axios
                    .post(this.searchUrl, {
                        search_key: searchKey,
                    })
                    .then((res) => {
                        if (res.data && res.data.length) {
                            this.searchResults = res.data;
                            this.selectedProducts = [];
                            return;
                        }

                        this.searchResults = [];
                        this.selectedProducts = [];
                    })
                    .catch((err) => {
                        const message = err.response.data
                            ? err.response.data.message
                            : 'Something went wrong try again';
                        new Noty({
                            type: 'error',
                            text: message,
                        }).show();
                    })
                    .finally(() => {
                        this.isSearching = false;
                        this.$nextTick(() => {
                            const el = this.$refs.searchKeyInput;
                            if (el && !el.disabled) el.focus();
                        });
                    });
            }
        },
        toggleProductSelection(product) {
            const index = this.selectedProducts.findIndex(
                (p) => p.id === product.id
            );

            if (index > -1) {
                this.selectedProducts.splice(index, 1);
            } else {
                this.selectedProducts.push(product);
            }
        },
        isSelected(productId) {
            return this.selectedProducts.some(
                (product) => product.id === productId
            );
        },
        toggleSelectAll() {
            if (this.selectedProducts.length === this.searchResults.length) {
                this.selectedProducts = [];
                return;
            }

            this.selectedProducts = [...this.searchResults];
        },

        productImagePath(image) {
            if (!!image?.main && image.main !== '') {
                return image.main;
            }

            return this.$root.config.fallback_image;
        },
        // File Manager methods
        prepareModal(type) {
            setTimeout(() => {
                let modalShade = document.querySelector('.modal-backdrop.fade.show');
                modalShade ? modalShade.remove() : null;
                this.modalShade = modalShade.outerHTML;
                this.activeModelFor = type;
                this.modalBody = document.querySelector('#widget-attributes-modal .modal-body').innerHTML;
            }, 10);
        },
        processImagesByType(indexOfAttributes = 0) {
            this.indexOfAttributes = indexOfAttributes;
            this.selectedFiles = this.productImage.image_path;
        },
        deleteImage() {
            this.$swal({
                title: 'Remove this Image?',
                //icon              : 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff6b81',
                cancelButtonColor: '#399E7F',
                confirmButtonText: 'Remove',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.productImage.image_path = '';
                }
            });
        },
        removeSelectedProduct(index) {
            this.selectedProducts.splice(index, 1);
        },
        removeSelectedFiles(index, length = 1) {
            let path = this.selectedFiles.splice(index, length);
            let noty = {
                type: 'success',
                text: `File (${path}) removed!`,
            };
            new Noty(noty).show();
        },
        getFileExtension(file) {
            const regexp = /\.([0-9a-z]+)(?:[\?#]|$)/i;
            const extension = file.match(regexp);
            return extension && extension[1];
        },
        getFileAddedMessage() {
            let noty = {
                type: 'success',
                text: 'File path added!',
            };

            new Noty(noty).show();
        },
    },

    watch: {
        '$store.state.fm.left.selected.files': {
            handler(files) {
                if (files.length) {
                    const self = this;

                    if (self.canMultiple) {
                        let filesPath = files.filter((file) => {
                            return ['jpg', 'jpeg', 'png'].includes(self.getFileExtension(file.toLowerCase()));
                        });

                        if (filesPath) {
                            self.$parent.selectedFiles = filesPath.map((filePath) => {
                                return self.all_disks[self.$store.state.fm.left.selectedDisk].url
                                    ? self.all_disks[self.$store.state.fm.left.selectedDisk].url + '/' + filePath
                                    : '/' + filePath;
                            });
                        }
                    } else {
                        let filePath = files.find((file) => {
                            return ['jpg', 'jpeg', 'png'].includes(self.getFileExtension(file.toLowerCase()));
                        });

                        if (filePath) {
                            self.$parent.selectedFiles = self.all_disks[self.$store.state.fm.left.selectedDisk].url
                                ? self.all_disks[self.$store.state.fm.left.selectedDisk].url + '/' + filePath
                                : '/' + filePath;
                        }
                    }
                    self.productImage.image_path = self.$parent.selectedFiles;
                    delete self.validationErrors.imagePath;
                    self.getFileAddedMessage();
                }
            },
        },
    },
};
</script>
