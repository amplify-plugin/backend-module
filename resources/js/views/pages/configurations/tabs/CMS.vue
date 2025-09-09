<template>
    <div role="tabpanel" class="tab-pane active" id="tab_basic-info">
        <fieldset>
            <div class="d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
                <legend>
                    <i class="la la-wordpress mr-2"></i>
                    Content Management System
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
            <div class="form-row">
                <div class="form-group col-sm-12">
                    <label>Topbar Tagline</label>
                    <input type="text" name="slogan" placeholder="Enter Website Top bar Tagline"
                           v-model="cmsConfigurationData.slogan" class="form-control"
                           :class="{ 'is-invalid': $parent.validationErrors.slogan }">
                    <small v-if="$parent.validationErrors.slogan" class="text-danger mt-3">{{
                            $parent.validationErrors.slogan[0]
                        }}</small>
                </div>

                <div class="form-group col-sm-12">
                    <label>Email</label>
                    <input type="text" name="email" placeholder="Enter Email"
                           v-model="cmsConfigurationData.email" class="form-control"
                           :class="{ 'is-invalid': $parent.validationErrors.email }">
                    <small v-if="$parent.validationErrors.email" class="text-danger mt-3">{{
                            $parent.validationErrors.email[0]
                        }}</small>
                </div>

                <div class="form-group col-sm-12">

                    <div>
                        <label>Phone</label>
                        <input type="text" name="phone" placeholder="Enter phone"
                               v-model="cmsConfigurationData.phone" class="form-control"
                               :class="{ 'is-invalid': $parent.validationErrors.phone }">
                        <small v-if="$parent.validationErrors.phone" class="text-danger mt-3">{{
                                $parent.validationErrors.phone[0]
                            }}</small>
                    </div>
                </div>

                <div class="form-group col-sm-12 required">
                    <label>Brand Logo</label>
                    <div class="controls">
                        <div class="input-group">
                            <input type="text" name="logo_path" v-model="cmsConfigurationData.logo_path"
                                   id="logo_path" class="form-control">

                            <span class="input-group-append">
                            <button type="button" class="btn btn-light btn-sm popup_selector" data-toggle="modal"
                                    data-target="#widget-attributes-modal"
                                    @click="prepareModal('logo_path'); processImagesByType(); canMultiple = false;">
                                <i class="la la-cloud-upload"></i> Browse
                            </button>
                            <button type="button" class="btn btn-light btn-sm clear_elfinder_picker"
                                    @click="deleteImage('logo_path')"><i class="la la-eraser"></i> Clear</button>
                        </span>
                        </div>
                    </div>
                    <label class="d-block mt-3">Preview</label>
                    <div class="img-preview-wrapper border p-2">
                        <img :src="cmsConfigurationData.logo_path" class="rounded d-block mx-auto" alt="Header image"
                             height="150">
                    </div>
                </div>
                <div class="form-group col-sm-12 required">
                    <label>Favicon Logo<i class="la la-info-circle" title="Icon that will display on bookmark and browser tab"></i></label>
                    <div class="controls">
                        <div class="input-group">
                            <input type="text" name="favicon_path" v-model="cmsConfigurationData.favicon_path"
                                   id="favicon_path" class="form-control">

                            <span class="input-group-append">
                            <button type="button" class="btn btn-light btn-sm popup_selector" data-toggle="modal"
                                    data-target="#widget-attributes-modal"
                                    @click="prepareModal('favicon_path'); processImagesByType(); canMultiple = false;">
                                <i class="la la-cloud-upload"></i> Browse
                            </button>
                            <button type="button" class="btn btn-light btn-sm clear_elfinder_picker"
                                    @click="deleteImage('favicon_path')"><i class="la la-eraser"></i> Clear</button>
                        </span>
                        </div>
                    </div>
                    <label class="d-block mt-3">Preview</label>
                    <div class="img-preview-wrapper border p-2">
                        <img :src="cmsConfigurationData.favicon_path" class="rounded d-block mx-auto" alt="Header image"
                             height="150">
                    </div>
                </div>
            </div>

            <!-- if header message html -->
            <div class="form-group">
                <label>
                    Header Message
                </label>

                <ckeditor
                    v-model="cmsConfigurationData.header_content"
                    :class="{ 'is-invalid': cmsConfigurationData.header_content }"
                ></ckeditor>

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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                @click="modalShade = '';"
                                aria-label="Close" id="cancelWidgetAttributesModalBtn">Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="saveActions" class="form-group">

            <button @click="$parent.saveCoreConfigInfo(cmsConfigurationData)" type="button" class="btn btn-success">
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
    name: "CMS",
    mixins: [allDisksMixin],
    data() {
        return {
            cmsConfigurationData: {
                tab: 'cms',
                email: this.$parent.coreConfigurationData.cms.email ?? '',
                phone: this.$parent.coreConfigurationData.cms.phone ?? '',
                logo_path: this.$parent.coreConfigurationData.cms.logo_path ?? '',
                favicon_path: this.$parent.coreConfigurationData.cms.favicon_path ?? '',
                sologan: this.$parent.coreConfigurationData.cms.sologan ?? '',
                header_content: this.$parent.coreConfigurationData.cms.header_content ?? '',
            },
            cms: [],
            activeModelFor: '',
        }
    },

    methods: {
        updateCMSInfo(event) {
            this.setValue(event.target.value, this.$parent.coreConfigurationData.cms.templates);
        },

        setValue(cms, configurations) {
            for (const [key, value] of Object.entries(configurations)) {
                if (key === cms) {
                    this.cmsConfigurationData.favicon_path = value.favicon_path ?? "";
                    this.cmsConfigurationData.logo_path = value.logo_path ?? "";
                    this.cmsConfigurationData.email = value.email ?? "";
                    this.cmsConfigurationData.phone = value.phone ?? "";
                    this.cmsConfigurationData.slogan = value.slogan ?? "";
                    this.cmsConfigurationData.header_content = value.header_content ?? "";
                }
            }
        },

        // File Manager methods
        prepareModal(type) {
            setTimeout(() => {
                let modalShade = document.querySelector('.modal-backdrop.fade.show')
                modalShade ? modalShade.remove() : null
                this.modalShade = modalShade.outerHTML;
                this.activeModelFor = type;
                this.modalBody = document.querySelector('#widget-attributes-modal .modal-body').innerHTML
            }, 10)
        },

        removeSelectedFiles(index, length = 1) {
            let path = this.selectedFiles.splice(index, length)
            let noty = {
                type: 'success',
                text: `File (${path}) removed!`,
            }
            new Noty(noty).show()
        },

        browseMainImage(event) {
            // console.log('browseMainImage:', event);
            event.preventDefault()
        },

        processImagesByType(indexOfAttributes = 0) {
            this.indexOfAttributes = indexOfAttributes;
            this.selectedFiles = this.cmsConfigurationData[this.activeModelFor];
        },

        getFileAddedMessage() {
            let noty = {
                type: 'success',
                text: 'File path added!',
            }

            new Noty(noty).show()
        },

        deleteImage(field) {
            this.$swal({
                title: 'Remove this Image?',
                //icon              : 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff6b81',
                cancelButtonColor: '#399E7F',
                confirmButtonText: 'Remove'

            }).then((result) => {
                if (result.isConfirmed) {
                    this.cmsConfigurationData[field] = ''
                }
            })
        },

        getFileExtension(file) {
            const regexp = /\.([0-9a-z]+)(?:[\?#]|$)/i
            const extension = file.match(regexp)
            return extension && extension[1]
        },
    },

    watch: {
        '$store.state.fm.left.selected.files': {
            handler(files) {
                // console.log('watch files in CMS', files);
                if (files.length) {
                    const self = this
                    // console.log('0 files in CMS', files);

                    if (self.canMultiple) {
                        let filesPath = files.filter(file => {
                            return ['jpg', 'jpeg', 'png'].includes(self.getFileExtension(file.toLowerCase()))
                        })

                        if (filesPath) {
                            self.$parent.selectedFiles = filesPath.map(filePath => {
                                return self.all_disks[self.$store.state.fm.left.selectedDisk].url ? self.all_disks[self.$store.state.fm.left.selectedDisk].url + "/" + filePath : "/" + filePath;
                            })
                        }
                    } else {
                        let filePath = files.find(file => {
                            return ['jpg', 'jpeg', 'png'].includes(self.getFileExtension(file.toLowerCase()))
                        })

                        if (filePath) {
                            self.$parent.selectedFiles = self.all_disks[self.$store.state.fm.left.selectedDisk].url ? self.all_disks[self.$store.state.fm.left.selectedDisk].url + "/" + filePath : "/" + filePath;
                        }
                    }
                    self.cmsConfigurationData[this.activeModelFor] = self.$parent.selectedFiles;
                    self.getFileAddedMessage()
                }
            }
        }
    }
}
</script>
