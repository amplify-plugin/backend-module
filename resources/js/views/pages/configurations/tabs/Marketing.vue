<template>
    <div role="tabpanel" class="tab-pane active" id="tab_basic-info">
        <fieldset>
            <div class="d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
                <legend>
                    <i class="la la-ad mr-2"></i>
                    Marketing Configuration
                </legend>
                <div class="d-md-none custom-sidebar-ar" @click="$parent.toggleSidebar()">
                    <div class="menu-icon-ar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="#1b2a4e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-menu">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </div>
                    <div class="close-icon-ar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Free shipping threshold amount</label>
                <input type="number" name="free_ship_threshold" placeholder="Enter amount in default currency"
                       v-model="coreConfigurationData.free_ship_threshold" class="form-control"
                       :class="{ 'is-invalid': $parent.validationErrors.free_ship_threshold }">
                <small v-if="$parent.validationErrors.free_ship_threshold" class="text-danger mt-3">
                    {{ $parent.validationErrors.free_ship_threshold[0] }}
                </small>
                <small class="text-muted">If left empty, feature will be disabled</small>
            </div>

            <div class="form-group">
                <label>
                    Checkout Page Shipping Amount Replacement
                    <span class="text-danger">*</span>
                </label>
                <input type="text" name="checkout_threshold_replace"
                       placeholder="Enter replacement when amount over close"
                       required
                       v-model="coreConfigurationData.checkout_threshold_replace" class="form-control"
                       :class="{ 'is-invalid': $parent.validationErrors.checkout_threshold_replace }">
                <small v-if="$parent.validationErrors.checkout_threshold_replace" class="text-danger mt-3">
                    {{ $parent.validationErrors.checkout_threshold_replace[0] }}
                </small>
            </div>

            <div class="form-group">
                <label>
                    Discount Percent to Flat value Min Limit
                    <span class="text-danger">*</span>
                </label>
                <input type="text" name="discount_percent_to_flat_min_limit"
                       placeholder="Enter discount Percent to Flat value Min Limit"
                       required
                       v-model="coreConfigurationData.discount_percent_to_flat_min_limit" class="form-control"
                       :class="{ 'is-invalid': $parent.validationErrors.discount_percent_to_flat_min_limit }">
                <small v-if="$parent.validationErrors.discount_percent_to_flat_min_limit" class="text-danger mt-3">
                    {{ $parent.validationErrors.discount_percent_to_flat_min_limit[0] }}
                </small>
            </div>

            <div class="form-group">
                <label class="lead">Social Media Links</label>

                <section>
                    <div class="card bg-light card-body">
                        <div class="form-group">
                            <label>Facebook</label>
                            <input v-model="coreConfigurationData.social_media_links.facebook" class="form-control" />
                        </div>

                        <div class="form-group">
                            <label>Twitter</label>
                            <input v-model="coreConfigurationData.social_media_links.twitter" class="form-control" />
                        </div>

                        <div class="form-group">
                            <label>Instagram</label>
                            <input v-model="coreConfigurationData.social_media_links.instagram" class="form-control" />
                        </div>

                        <div class="form-group">
                            <label>Google Plus</label>
                            <input v-model="coreConfigurationData.social_media_links.googleplus" class="form-control" />
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <label>
                                    <input v-model="coreConfigurationData.social_media_share" type="checkbox" class="form-check-input" />
                                    Is Social Media Share Enabled?
                                </label>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="form-group">
                <label class="lead">Free Shipping Message</label>

                <section class="repeater" v-for="(message, index) in coreConfigurationData.free_ship_messages"
                         :key="index">
                    <div class="card bg-light card-body">
                        <div class="form-group">
                            <label :for="`free-ship-message-text-${index}`">Message #{{ index + 1 }}</label>
                            <textarea
                                placeholder="Enter free shipping message"
                                :id="`free-ship-message-text-${index}`"
                                v-model="message.text"
                                class="form-control"
                                rows="3"
                            ></textarea>
                            <small class="text-muted">The limit amount threshold placeholder __limit__</small>
                        </div>
                        <div class="form-group">
                            <label :for="`free-ship-message-text-${index}`">Message for Zero Amount #{{ index + 1 }}</label>
                            <textarea
                                placeholder="Enter free shipping message"
                                :id="`free-ship-message-text-${index}`"
                                v-model="message.zero_amount_message"
                                class="form-control"
                                rows="3"
                            ></textarea>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <div class="controls">
                                <div class="input-group">
                                    <input type="text" v-model="message.image" class="form-control">
                                    <span class="input-group-append">
                                                        <button type="button"
                                                                class="btn btn-info btn-sm popup_selector"
                                                                data-toggle="modal"
                                                                data-target="#widget-attributes-modal"
                                                                @click="prepareModal(index); canMultiple = false;">
                                                            <i class="la la-cloud-upload"></i> Browse
                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-warning btn-sm"
                                                                @click="deleteImage(index)"><i
                                                            class="la la-eraser"></i> Clear</button>
                                                    </span>
                                </div>
                            </div>
                            <div class="img-preview-wrapper border p-2 rounded" style="height: 150px;">
                                <img :src="message.image"
                                     class="rounded d-block mx-auto img-fluid"
                                     alt="Image"
                                     style="height: 100%;"
                                >
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger" v-show="index" @click="removeMessageCard(index)">
                            Remove
                        </button>
                    </div>
                </section>
                <a href="javascript:void(0)" class="btn btn-outline-primary" @click="addNewMessageCard">Add new item</a>
            </div>
        </fieldset>


        <div class="modal fade" id="widget-attributes-modal" tabIndex="0" role="dialog"
             aria-labelledby="widget-attributes-modal-dialog-label" data-backdrop="static" data-keyboard="false"
             aria-modal="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="attribute-inline-create-dialog-label">
                            Set image for Invoice Configuration <strong> </strong>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" @click="modalShade = '';"
                                aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body bg-light">

                        <!-- Default box -->
                        <div class="card" style="margin-bottom: 0rem!important;">
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="modalShade = '';"
                                aria-label="Close" id="cancelWidgetAttributesModalBtn">Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="saveActions" class="form-group">
            <button @click="$parent.saveCoreConfigInfo(coreConfigurationData)" type="button" class="btn btn-success">
                <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                <span data-value="save_and_edit"> Save</span>
            </button>

            <button @click="$parent.saveAndAction()" type="button" class="btn btn-default">
                <span class="la la-ban"></span> Cancel
            </button>
        </div>
    </div>
</template>

<script>
import allDisksMixin from '../../../../allDisks.mixin';

export default {
    name: "Marketing",
    mixins: [allDisksMixin],
    data() {
        return {
            modalShade: "",
            modalBody: "",
            canMultiple: false,
            selectedFiles: "",
            coreConfigurationData: {
                tab: "marketing",
                social_media_share: this.$parent.coreConfigurationData.marketing.social_media_share ?? null,
                social_media_links: this.$parent.coreConfigurationData.marketing.social_media_links ?? null,
                free_ship_threshold: this.$parent.coreConfigurationData.marketing.free_ship_threshold ?? null,
                checkout_threshold_replace: this.$parent.coreConfigurationData.marketing.checkout_threshold_replace ?? 'Free Shipping',
                discount_percent_to_flat_min_limit: this.$parent.coreConfigurationData.marketing.discount_percent_to_flat_min_limit ?? 0,
                free_ship_messages: this.$parent.coreConfigurationData.marketing.free_ship_messages ?? [
                    {text: "", zero_amount_message: "", image: ""}
                ]
            }
        }
    },
    methods: {
        addNewMessageCard() {
            this.coreConfigurationData.free_ship_messages.push({text: "", zero_amount_message: "", image: ""});
        },

        prepareModal(indexOfAttributes) {
            this.indexOfAttributes = indexOfAttributes;
            this.selectedFiles = this.coreConfigurationData.free_ship_messages.image;

            setTimeout(() => {
                let modalShade = document.querySelector('.modal-backdrop.fade.show')
                modalShade ? modalShade.remove() : null
                this.modalShade = modalShade.outerHTML;
                this.modalBody = document.querySelector('#widget-attributes-modal .modal-body').innerHTML
            }, 10)
        },

        removeMessageCard(index, length = 1) {
            let path = this.coreConfigurationData.free_ship_messages.splice(index, length)
            let noty = {
                type: 'success',
                text: `Message #${index} removed successfully.`,
            }
            new Noty(noty).show()
        },

        deleteImage(index) {
            this.$swal({
                title: 'Remove this Image?',
                showCancelButton: true,
                confirmButtonColor: '#ff6b81',
                cancelButtonColor: '#399E7F',
                confirmButtonText: 'Remove'

            }).then((result) => {
                if (result.isConfirmed) {
                    this.coreConfigurationData.free_ship_messages[index].image = '';
                }
            })
        },

        getFileExtension(file) {
            const regexp = /\.([0-9a-z]+)(?:[\?#]|$)/i
            const extension = file.match(regexp)
            return extension && extension[1]
        },

        getFileAddedMessage() {
            let noty = {
                type: 'success',
                text: 'File path added!',
            }

            new Noty(noty).show()
        },

    },

    watch: {
        '$store.state.fm.left.selected.files': {
            handler(files) {
                if (files.length) {
                    const self = this

                    if (self.canMultiple) {
                        let filesPath = files.filter(file => {
                            return ['jpg', 'jpeg', 'png'].includes(self.getFileExtension(file.toLowerCase()))
                        })

                        if (filesPath) {
                            self.selectedFiles = filesPath.map(filePath => {
                                return self.all_disks[self.$store.state.fm.left.selectedDisk].url ? self.all_disks[self.$store.state.fm.left.selectedDisk].url + "/" + filePath : "/" + filePath;
                            })
                        }
                    } else {
                        let filePath = files.find(file => {
                            return ['jpg', 'jpeg', 'png'].includes(self.getFileExtension(file.toLowerCase()))
                        })

                        if (filePath) {
                            self.selectedFiles = self.all_disks[self.$store.state.fm.left.selectedDisk].url ? self.all_disks[self.$store.state.fm.left.selectedDisk].url + "/" + filePath : "/" + filePath;
                        }
                    }

                    self.coreConfigurationData.free_ship_messages[this.indexOfAttributes].image = self.selectedFiles;

                    self.getFileAddedMessage()
                }
            }
        }
    }
}
</script>
