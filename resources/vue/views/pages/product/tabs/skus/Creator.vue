<template>
    <div class="row mt-3">
        <!-- text input -->
        <div v-if="loader" class="text-center w-100" style="height: 250px">
            <div class="loader">Loading...</div>
        </div>

        <div v-else class="form-group col-sm-12 mb-0">
            <div class="card mb-3">
                <div class="card-body row" :key="$parent.reRenderCreatorBlock">

                    <div class="form-group col-sm-12" :class="{'text-danger': $parent.validationErrors.sku_id}">
                        <label>
                            SKU Product Id
                            <span class="text-danger font-weight-bold">*</span>
                        </label>
                        <div class="input-group mb-2">
                            <input @input="$parent.removeError('sku_id')" type="text" name="sku_id"
                                   :disabled="true" v-model="$parent.productData.id" class="form-control"
                                   :class="{'is-invalid': $parent.validationErrors.sku_id}">
                        </div>

                        <small v-if="$parent.validationErrors.sku_id"
                               class="text-danger mt-3">{{ $parent.validationErrors.sku_id[0] }}</small>
                    </div>

                    <div class="form-group col-sm-12" :class="{'text-danger': $parent.validationErrors.product_name}">
                        <label>
                            SKU Name
                            <span class="text-danger font-weight-bold">*</span>
                        </label>
                        <i class="las la-info-circle pull-right" style="margin-top: 3px;"
                           title="Minimum product name length is 5 characters and Maximum product name length is 255 characters"></i>
                        <i class="la la-flag-checkered pull-right" style="margin-top: 3px;"
                           title="This field is translatable."></i>
                        <input @input="$parent.removeError('product_name')" type="text" name="product_name"
                               :disabled="$parent.disableFields"
                               v-model="$parent.productData.local_product_name"
                               class="form-control" :class="{'is-invalid': $parent.validationErrors.product_name}">
                        <small v-if="$parent.validationErrors.product_name"
                               class="text-danger mt-3">{{ $parent.validationErrors.product_name[0] }}</small>
                    </div>

                    <div class="form-group col-sm-12" :class="{'text-danger': $parent.validationErrors.product_type}">
                        <label>
                            SKU Type
                            <span class="text-danger font-weight-bold">*</span>
                        </label>
                        <input type="text" name="product_type" disabled
                               v-model="$parent.productData.product_type" class="form-control"
                               :class="{'is-invalid': $parent.validationErrors.product_type}">
                    </div>

                    <div class="form-group col-sm-12" :class="{'text-danger': $parent.validationErrors.product_code}">
                        <label>
                            SKU Code
                            <span class="text-danger font-weight-bold">*</span>
                        </label>
                        <i class="las la-info-circle pull-right" style="margin-top: 3px;"
                           title="Minimum product code length is 5 characters and Maximum product code length is 20 characters"></i>
                        <input @input="$parent.removeError('product_code')" type="text" name="product_code"
                               :disabled="$parent.disableFields"
                               v-model="$parent.productData.product_code" class="form-control"
                               :class="{'is-invalid': $parent.validationErrors.product_code}">
                        <small v-if="$parent.validationErrors.product_code"
                               class="text-danger mt-3">{{ $parent.validationErrors.product_code[0] }}</small>
                    </div>

                    <div class="form-group col-sm-12" :class="{'text-danger': $parent.validationErrors.attributes}">
                        <div class="d-flex justify-content-between">
                            <label>SKU Attributes</label>
                            <button v-if="$parent.creatorTitle !== 'View'" class="btn btn-sm btn-link"
                                    type="button"
                                    data-toggle="modal"
                                    data-target="#inline-create-attribute"
                                    @click="$refs.inlineCreate.getModal()">
                                + Add
                            </button>
                        </div>
                        <multiselect :class="{'is-invalid': $parent.validationErrors.attributes}"
                                     v-model="$parent.selectedAttributeOptions"
                                     :options="$parent.allAttributes"
                                     :multiple="true"
                                     :close-on-select="false"
                                     :clear-on-select="false"
                                     :preserve-search="false"
                                     :hide-selected="true"
                                     placeholder="Pick some"
                                     label="local_name"
                                     track-by="local_name"
                                     @input="$parent.handleChangesOnAttributeOptions()"
                                     v-if="$parent.creatorTitle !== 'View'"
                                     :disabled="$parent.disableFields">
                            <template slot="selection" slot-scope="{ values, search, isOpen }"><span
                                class="multiselect__single"
                                v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span>
                            </template>
                        </multiselect>

                        <!--                        <div class="card mb-3 mt-3" v-for="(attribute, index) in $parent.selectedAttributeOptions"-->
                        <!--                             :class="{'red-border': attribute.errors}">-->
                        <!--                            <div class="card-body">-->
                        <!--                                <div v-if="attribute.errors &&  attribute.errors.message"-->
                        <!--                                     class="alert alert-danger">{{ attribute.errors.message }}-->
                        <!--                                </div>-->
                        <!--                                <label class="mb-3 d-flex justify-content-between">-->
                        <!--                                    <span>-->
                        <!--                                        <strong> {{ attribute.local_name }} </strong>-->
                        <!--                                    </span>-->
                        <!--                                </label>-->
                        <!--                                <div class="d-flex">-->
                        <!--                                    <div class="form-group col-sm-12 p-0">-->
                        <!--                                        <label>Attribute Value</label>-->
                        <!--                                        <i class="la la-flag-checkered pull-right"-->
                        <!--                                           style="margin-top: 3px;"-->
                        <!--                                           title="This field is translatable."></i>-->
                        <!--                                        <input type="text" class="form-control" :disabled="$parent.disableFields"-->
                        <!--                                               v-model="attribute.attribute_value"-->
                        <!--                                        >-->
                        <!--                                    </div>-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                        </div>-->

                        <div class="card mb-3 mt-3">
                            <div class="card-body">
                                <table class="table table-default table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-nowrap">Attribute Name</th>
                                        <th scope="col" class="text-nowrap">Attribute Value</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr
                                        v-if="$parent.selectedAttributeOptions"
                                        v-for="(attribute, index) in $parent.selectedAttributeOptions"
                                        :key="index"
                                    >
                                        <td style="vertical-align: middle">
                                            {{ attribute.local_name }}
                                        </td>

                                        <td>
                                            <input type="text" class="form-control" :disabled="$parent.disableFields"
                                                   v-model="attribute.attribute_value"
                                            >
                                        </td>
                                        <span v-if="attribute.errors &&  attribute.errors.message"
                                              class="alert alert-danger">{{ attribute.errors.message }}
                                        </span>
                                    </tr>
                                    <tr v-if="!$parent.selectedAttributeOptions">
                                        <td class="text-center w-100" colspan="100%">
                                            No attributes found.
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th scope="col" class="text-nowrap">Attribute Name</th>
                                        <th scope="col" class="text-nowrap">Attribute Value</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>

                    <div class="form-group col-sm-12" :class="{'text-danger': $parent.validationErrors.description}">
                        <label>
                            SKU Description
                        </label>
                        <i class="la la-flag-checkered pull-right" style="margin-top: 3px;"
                           title="This field is translatable."></i>
                        <ckeditor v-model="$parent.productData.local_description" :read-only="$parent.disableFields"
                                  :class="{'is-invalid': $parent.validationErrors.description}"></ckeditor>
                        <small v-if="$parent.validationErrors.description"
                               class="text-danger mt-3">{{ $parent.validationErrors.description[0] }}</small>
                    </div>

                    <div class="form-group col-sm-12"
                         :class="{'text-danger': $parent.validationErrors.sku_part_number}">
                        <label>
                            SKU Part Number
                        </label>
                        <input type="text" name="sku_part_number"
                               v-model="$parent.productData.sku_part_number" class="form-control"
                               :disabled="$parent.disableFields"
                               :class="{'is-invalid': $parent.validationErrors.sku_part_number}">
                        <small v-if="$parent.validationErrors.sku_part_number"
                               class="text-danger mt-3">{{ $parent.validationErrors.sku_part_number[0] }}</small>
                    </div>

                    <div class="form-group col-sm-12" :class="{'text-danger': $parent.validationErrors.main}">
                        <label>
                            SKU Image
                        </label>
                        <div class="row" :key="reRenderImageBlock">
                            <div class="col-md-6" style="margin-left: 0!important;">
                                <div class="input-group">
                                    <input placeholder="upload path" type="text" class="form-control"
                                           :disabled="$parent.disableFields"
                                           :class="{'is-invalid': $parent.validationErrors.main}"
                                           v-model="$parent.productData.product_image.main">
                                    <small v-if="$parent.validationErrors.main"
                                           class="text-danger mt-3">{{ $parent.validationErrors.main[0] }}</small>
                                    <div class="input-append">
                                        <div v-if="$parent.creatorTitle !== 'View'"
                                             class="w-one-third text-center m-auto"
                                             style="margin-left: 0!important;">
                                            <div class="btn-group">
                                                <label class="btn btn-light btn-sm btn-file py-2 mb-0 cursor-pointer"
                                                       title="select file"
                                                       for="mainImage">
                                                    Choose File
                                                    <input id="mainImage" type="text"
                                                           class="form-control d-none file_design"
                                                           title="select file"
                                                           @click="processImagesByType(); getImageBrowseModal();">
                                                    <!-- <input id="mainImage" type="file" class="form-control d-none file_design"
                                                           @change="uploadMainImage"> -->
                                                </label>
                                                <button class="btn btn-light btn-sm"
                                                        data-handle="remove"
                                                        v-if="$parent.productData.product_image.main"
                                                        @click="deleteImage('main', $parent.productData.product_image.main)"
                                                        type="button">
                                                    <i class="la la-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="image col-md-6 p-2">
                                <div v-if="this.uploading.main">
                                    <ProgressBar></ProgressBar>
                                </div>
                                <div v-else class="w-100 text-md-end text-center">
                                    <img class="img-thumbnail"
                                         @error="$root.getDefaultImage"
                                         style="height: 79px;"
                                         :src="`${$parent.productData.product_image.main}`"
                                         alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-sm-12" :class="{'text-danger': $parent.validationErrors.selling_price}">
                        <label>
                            Price
                        </label>
                        <input type="number" name="price" v-model="$parent.productData.selling_price"
                               :disabled="$parent.disableFields"
                               class="form-control" step=".01"
                               :class="{'is-invalid': $parent.validationErrors.selling_price}">
                        <small v-if="$parent.validationErrors.selling_price"
                               class="text-danger mt-3">{{ $parent.validationErrors.selling_price[0] }}</small>
                    </div>

                    <div v-if="$parent.$parent.useMinimumOrderQuantity" class="form-group col-sm-12" :class="{'text-danger': $parent.validationErrors.min_order_qty}">
                        <label>
                            Min Order Quantity
                        </label>
                        <input type="number" name="min_order_qty" v-model="$parent.productData.min_order_qty"
                               :disabled="$parent.disableFields"
                               class="form-control"
                               :class="{'is-invalid': $parent.validationErrors.min_order_qty}">
                        <small v-if="$parent.validationErrors.min_order_qty"
                               class="text-danger mt-3">{{ $parent.validationErrors.min_order_qty[0] }}</small>
                    </div>

                    <div v-if="$parent.$parent.useMinimumOrderQuantity" class="form-group col-sm-12" :class="{'text-danger': $parent.validationErrors.qty_interval}">
                        <label>
                            Quantity Interval
                        </label>
                        <input type="number" name="min_order_qty" v-model="$parent.productData.qty_interval"
                               :disabled="$parent.disableFields"
                               class="form-control"
                               :class="{'is-invalid': $parent.validationErrors.qty_interval}">
                        <small v-if="$parent.validationErrors.qty_interval"
                               class="text-danger mt-3">{{ $parent.validationErrors.qty_interval[0] }}</small>
                    </div>

                    <div class="form-group col-sm-12">
                        <label>Manufacturer</label>
                        <div>
                            <treeselect
                                :multiple="false"
                                name="manufacturer_id"
                                placeholder="Select a manufacturer"
                                :options="$parent.$parent.manufacturers"
                                :disabled="$parent.disableFields"
                                v-model="$parent.productData.manufacturer_id"
                            />
                        </div>
                    </div>

                    <div class="form-group col-sm-12 mt-3 mb-0">
                        <div v-if="$parent.creatorTitle === 'Create'">
                            <button type="button" class="btn btn-primary"
                                    @click="$parent.saveSKUData('save')">

                                <i class="la la-save"></i>&nbsp;
                                Save
                            </button>

                            <button type="button" class="btn btn-success"
                                    @click="$parent.saveSKUData('clone')">

                                <i class="lar la-copy"></i>&nbsp;
                                Save and clone
                            </button>

                            <button type="button" class="btn btn-default"
                                    @click="$parent.isActionFromProductList ? $parent.returnToProductList()
                                     :  $parent.optionType = 'selector';
                                    $parent.resetCreateBlock();">

                                <i class="las la-undo"></i>&nbsp;
                                Reset and back
                            </button>
                        </div>

                        <div v-else-if="$parent.creatorTitle === 'Edit'">
                            <button type="button" class="btn btn-primary" @click="$parent.saveSKUData('update')">
                                <i class="la la-save"></i>&nbsp;
                                Update
                            </button>

                            <button type="button" class="btn btn-default"
                                    @click="$parent.isActionFromProductList ? $parent.returnToProductList()
                                     :  $parent.creatorTitle = 'Create';
                                    $parent.optionType = 'selector';
                                    $parent.resetCreateBlock();">

                                <i class="la la-ban"></i>&nbsp;
                                Cancel
                            </button>
                        </div>

                        <div v-else-if="$parent.creatorTitle === 'View'">
                            <button type="button" class="btn btn-danger"
                                    @click="$parent.removeSKUProductFromList($parent.productForViewAction.id)">

                                <i class='lar la-trash-alt'></i>
                                Remove
                            </button>

                            <button type="button" class="btn btn-primary"
                                    @click="$parent.editSKUProduct($parent.productForViewAction)">

                                <i class="lar la-edit"></i>
                                Edit
                            </button>

                            <button type="button" class="btn btn-success"
                                    @click="$parent.cloneSKUProduct($parent.productForViewAction)">

                                <i class="lar la-copy"></i>
                                Clone
                            </button>

                            <button type="button" class="btn btn-default"
                                    @click="$parent.isActionFromProductList ? $parent.returnToProductList()
                                     :  $parent.creatorTitle = 'Create';
                                    $parent.optionType = 'selector';
                                    $parent.disableFields = false;
                                    $parent.resetCreateBlock();">

                                <i class="las la-undo"></i>&nbsp;
                                Back
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <InlineCreate
            ref="inlineCreate"
            axios_url="/admin/attribute/inline/create"
            :locale="$parent.locale"
            :show="$parent.showInline"
        ></InlineCreate>

        <button type="button" class="btn btn-primary d-none" data-toggle="modal"
                data-target="#filemanagerModal">
            Open Filemanager
        </button>
    </div>
</template>

<script>
import allDisksMixin from '../../../../../allDisks.mixin';
import $ from "jquery";
import Multiselect  from "vue-multiselect";
import Treeselect from '@riophae/vue-treeselect';
import '@riophae/vue-treeselect/dist/vue-treeselect.css';
import InlineCreate from "../../../attribute/InlineCreate";


export default {

    name: "Creator",
    mixins: [allDisksMixin],

    data() {
        return {
            loader            : false,
            reRenderImageBlock: 0,
            uploading         : {
                main: false,
            },
            allAttributes     : []
        }
    },

    components: {
        Multiselect, Treeselect, InlineCreate
    },

    mounted() {
        this.allAttributes = this.$parent.allAttributes;
    },

    methods: {
        processImagesByType(type = 'main') {
            this.$parent.type = type;
            this.$parent.$parent.selectedFiles = this.$parent.productData.product_image.main ?? null;
        },

        getImageBrowseModal() {
            console.log('getImageBrowseModal')
            setTimeout(() => {
                let modal = document.querySelector('[data-target="#filemanagerModal"]');
                modal?.click();

                let modalDismisses    = document.querySelectorAll('[data-dismiss="modal"]');
                let modalShadeDefault = document.querySelector(".modal-backdrop.show");
                modalShadeDefault ? modalShadeDefault.remove() : null;

                let modalShade = document.createElement('div');
                modalShade.classList.add('modal-backdrop', 'show');

                this.$parent.modalShade = modalShade.outerHTML;

                modalDismisses.forEach(modalDismiss => {
                    modalDismiss.addEventListener('click', () => {
                        this.$store.dispatch('fm/resetState');
                        this.$store.dispatch('fm/initializeApp');
                        this.$parent.modalShade = '';
                    })
                });

                this.$parent.modalBody = document.querySelector("#filemanagerModal .modal-body").innerHTML;

                // Initiate draggable
                setTimeout(() => {
                    $('.modal-dialog').draggable({
                        handle: ".modal-moveable"
                    });
                }, 1000)
            }, 100);
        },
        browseMainImage(event) {
            console.log('browseMainImage')
            event.preventDefault();
        },

        deleteImage(type, url) {
            new Noty({
                type: "success",
                text: this.$parent.productData.product_image.main + ' deleted successfully'
            }).show();

            this.$parent.productData.product_image.main = "";
        },

        getFileExtension(file) {
            const regexp = /\.([0-9a-z]+)(?:[\?#]|$)/i;
            const extension = file.match(regexp);
            return extension && extension[1];
        },
        getFileAddedMessage() {
            let noty = {
                type: "success",
                text: "File path added!",
            };

            new Noty(noty).show();
        },
    },

    watch: {
        allAttributes: {
            handler() {
                this.$parent.allAttributes = this.allAttributes;
            }
        },
        "$store.state.fm.left.selected.files": {
            handler (files){
                if (files.length) {
                    const self = this;


                    let filePath = files.find(file => {
                        return ['jpg', 'jpeg', 'png', 'mp4', 'avi', 'mkv'].includes(self.getFileExtension(file.toLowerCase()));
                    });

                    if (filePath) {
                        this.$parent.$parent.selectedFiles = self.all_disks[self.$store.state.fm.left.selectedDisk].url? self.all_disks[self.$store.state.fm.left.selectedDisk].url + "/" + filePath : "/" + filePath;
                    }

                    self.getFileAddedMessage();
                }
            }
        },
        "$parent.$parent.selectedFiles": function (newVal, oldVal) {
            this.$parent.productData.product_image.main = newVal;
        }
    },
}
</script>

<style scoped>
.required-custom {
    color: #ff0000;
}
</style>
