<template>
    <div role="tabpanel" class="tab-pane active" id="tab_basic-info">
        <div class="row">
            <!-- load the view from type and view_namespace attribute if set -->

            <!-- hidden input -->
            <div class="hidden">
                <input type="hidden" name="basic-info" value="" class="form-control" />
            </div>

            <!-- text input -->
            <div class="form-group col-sm-12" :class="{ 'text-danger': $parent.validationErrors.category_name }">
                <label>
                    Category Name
                    <span class="text-danger font-weight-bold">*</span>
                </label>
                <i
                    class="la la-flag-checkered pull-right"
                    style="margin-top: 3px"
                    title="This field is translatable."
                ></i>
                <input
                    @input="
                        removeError('category_name');
                        $parent.convertNameToSlug($parent.category.category_name);
                    "
                    type="text"
                    name="category_name"
                    v-model="$parent.category.category_name"
                    placeholder="Enter category name"
                    class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.category_name }"
                />
                <small v-if="$parent.validationErrors.category_name" class="text-danger mt-3">{{
                    $parent.validationErrors.category_name[0]
                }}</small>
            </div>

            <!-- text input -->
            <div class="form-group col-sm-12" :class="{ 'text-danger': $parent.validationErrors.description }">
                <label>
                    Category Description
                </label>
                <i
                    class="la la-flag-checkered pull-right"
                    style="margin-top: 3px"
                    title="This field is translatable."
                ></i>
                <textarea
                    type="text"
                    name="description"
                    v-model="$parent.category.description"
                    placeholder="Enter category description"
                    class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.description }"
                ></textarea>
                <small v-if="$parent.validationErrors.description" class="text-danger mt-3">{{
                    $parent.validationErrors.description[0]
                }}</small>
            </div>

            <!-- text input -->
            <div class="form-group col-sm-12" :class="{ 'text-danger': $parent.validationErrors.category_slug }">
                <label>
                    Category Slug
                    <span class="text-danger font-weight-bold">*</span>
                </label>
                <input
                    @input="removeError('category_slug')"
                    type="text"
                    name="category_slug"
                    v-model="$parent.category.category_slug"
                    placeholder="Enter category slug"
                    class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.category_slug }"
                />
                <small v-if="$parent.validationErrors.category_slug" class="text-danger mt-3">{{
                    $parent.validationErrors.category_slug[0]
                }}</small>
            </div>

            <!-- text input -->
            <div class="form-group col-sm-12" :class="{ 'text-danger': $parent.validationErrors.category_code }">
                <label>
                    Category Code
                    <span class="text-danger font-weight-bold">*</span>
                </label>
                <input
                    @input="removeError('category_code')"
                    type="text"
                    name="category_code"
                    placeholder="Enter category code"
                    v-model="$parent.category.category_code"
                    class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.category_code }"
                />
                <small v-if="$parent.validationErrors.category_code" class="text-danger mt-3">{{
                    $parent.validationErrors.category_code[0]
                }}</small>
            </div>

            <!-- text input -->
            <div class="form-group col-sm-12" :class="{ 'text-danger': $parent.validationErrors.pim_category_id }">
                <label>
                    PIM Category
                    <span class="text-danger font-weight-bold" v-if="$parent.pim_category_id_required === true">*</span>
                </label>
                <input
                    @input="removeError('pim_category_id')"
                    type="text"
                    name="pim_category_id"
                    v-model="$parent.category.pim_category_id"
                    placeholder="Enter PIM Category"
                    :required="$parent.pim_category_id_required"
                    class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.pim_category_id }"
                />
                <small v-if="$parent.validationErrors.pim_category_id" class="text-danger mt-3">
                    {{ $parent.validationErrors.pim_category_id[0] }}</small
                >
            </div>


            <!--            &lt;!&ndash; text input &ndash;&gt;-->
            <!--            <div class="form-group col-sm-12" :class="{ 'text-danger': $parent.validationErrors.template }">-->
            <!--                <label> Template </label>-->
            <!--                <input-->
            <!--                    @input="removeError('template')"-->
            <!--                    type="text"-->
            <!--                    name="template"-->
            <!--                    v-model="$parent.category.template"-->
            <!--                    placeholder="Enter template name"-->
            <!--                    class="form-control"-->
            <!--                    :class="{ 'is-invalid': $parent.validationErrors.template }"-->
            <!--                />-->
            <!--                <small v-if="$parent.validationErrors.template" class="text-danger mt-3">{{-->
            <!--                    $parent.validationErrors.template[0]-->
            <!--                }}</small>-->
            <!--            </div>-->

            <div class="form-group col-sm-12 required" :class="{ 'text-danger': $parent.validationErrors.image }">
                <label> Image </label>
                <div class="controls">
                    <div class="input-group">
                        <input
                            type="text"
                            name="image"
                            v-model="$parent.category.image"
                            id="image"
                            class="form-control"
                            @keypress="$parent.category.errors.clear('image')"
                        />

                        <span class="input-group-append">
                            <button
                                type="button"
                                class="btn btn-light btn-sm popup_selector"
                                data-toggle="modal"
                                data-target="#widget-attributes-modal"
                                @click="
                                    prepareModal();
                                    processImagesByType();
                                    canMultiple = false;
                                "
                            >
                                <i class="la la-cloud-upload"></i> Browse
                            </button>
                            <button
                                type="button"
                                class="btn btn-light btn-sm clear_elfinder_picker"
                                @click="deleteImage()"
                            >
                                <i class="la la-eraser"></i> Clear
                            </button>
                        </span>
                    </div>
                    <small v-if="$parent.validationErrors.image" class="text-danger mt-3">
                        {{ $parent.validationErrors.image[0] }}
                    </small>
                </div>
            </div>

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
                                Set image for category <strong> </strong>
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
                            <div class="card" style="margin-bottom: 0rem !important">
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

            <!-- checkbox field -->
            <div class="form-group col-sm-12">
                <div class="checkbox">
                    <input id="searchable" type="checkbox" v-model="$parent.category.is_top_nav" />
                    <label for="searchable" class="form-check-label font-weight-normal">Is Top Nav</label>
                </div>
            </div>
            <div class="form-group col-sm-12">
                <div class="checkbox">
                    <input id="featured" type="checkbox" v-model="$parent.category.featured" />
                    <label for="featured" class="form-check-label font-weight-normal">Is Featured</label>
                </div>
            </div>
            <div class="form-group col-sm-12">
                <div class="checkbox">
                    <input id="featured" type="checkbox" v-model="$parent.category.enabled" />
                    <label for="featured" class="form-check-label font-weight-normal">Enabled?</label>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import allDisksMixin from '../../../../allDisks.mixin';

export default {
    name: 'BasicInfo',
    mixins: [allDisksMixin],

    methods: {
        removeError(key) {
            let errorsObject = this.$parent.validationErrors;
            let errorExist = errorsObject[key];
            if (errorExist) {
                delete errorsObject[key];
            }
            //for re-render parent component
            if (Object.keys(errorsObject).length <= 0) {
                this.$parent.validationErrors = '';
            }
            this.$parent.validationErrors = errorsObject;
        },

        prepareModal() {
            setTimeout(() => {
                let modalShade = document.querySelector('.modal-backdrop.fade.show');
                modalShade ? modalShade.remove() : null;
                this.modalShade = modalShade.outerHTML;
                this.modalBody = document.querySelector('#widget-attributes-modal .modal-body').innerHTML;
            }, 10);
        },

        processImagesByType(indexOfAttributes = 0) {
            this.indexOfAttributes = indexOfAttributes;
            this.selectedFiles = this.$parent.category.image;
        },

        uploadImage(event) {
            let file = event.target.files[0];
            if (file.size > 3048770) {
                alert('image must not be greater than 3048770 bytes');
            } else {
                let reader = new FileReader();
                reader.onload = (event) => {
                    this.$parent.category.image = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        },

        getFileAddedMessage() {
            let noty = {
                type: 'success',
                text: 'File path added!',
            };

            new Noty(noty).show();
        },

        deleteImage(indexOfAttributes = 0) {
            this.$swal({
                title: 'Remove this Image?',
                //icon              : 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff6b81',
                cancelButtonColor: '#399E7F',
                confirmButtonText: 'Remove',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$parent.category.image = '';
                }
            });
        },

        getFileExtension(file) {
            const regexp = /\.([0-9a-z]+)(?:[\?#]|$)/i;
            const extension = file.match(regexp);
            return extension && extension[1];
        },
    },
    watch: {
        '$store.state.fm.left.selected.files': {
            handler(files) {
                if (files.length) {
                    const self = this;
                    const asset_base_url = self.all_disks[self.$store.state.fm.left.selectedDisk].hasOwnProperty('url')
                        ? self.all_disks[self.$store.state.fm.left.selectedDisk].url + '/'
                        : '/';

                    if (self.canMultiple) {
                        let filesPath = files.filter((file) => {
                            return ['jpg', 'jpeg', 'png'].includes(self.getFileExtension(file.toLowerCase()));
                        });

                        if (filesPath) {
                            self.$parent.selectedFiles = filesPath.map((filePath) => {
                                return asset_base_url + filePath;
                            });
                        }
                    } else {
                        let filePath = files.find((file) => {
                            return ['jpg', 'jpeg', 'png'].includes(self.getFileExtension(file.toLowerCase()));
                        });

                        if (filePath) {
                            self.$parent.selectedFiles = asset_base_url + filePath;
                        }
                    }
                    self.$parent.category.image = self.$parent.selectedFiles;
                    self.getFileAddedMessage();
                }
            },
        },
    },
};
</script>

<style scoped></style>
