<template>
    <div role="tabpanel" class="tab-pane active" id="tab_basic-info">
        <fieldset>
            <div class="d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
                <legend>
                    <i class="la la-file-invoice mr-2"></i>
                    Invoice Configuration
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
                <label>
                    Header Type
                    <span class="text-danger">*</span>
                </label>
                <select name="header_content_type" class="form-control custom-select"
                        v-model="invoiceConfiguration.header_content_type"
                        required>
                    <option value="html">HTML</option>
                    <option value="image">Image</option>
                </select>
            </div>

            <!-- If header type is html -->
            <div v-if="invoiceConfiguration.header_content_type == 'html'">
                <div class="form-group">
                    <label>
                        Header Content
                        <span class="text-danger">*</span>
                    </label>
                    <ckeditor v-model="invoiceConfiguration.header_content"
                              :class="{ 'is-invalid': invoiceConfiguration.header_content }"></ckeditor>
                </div>
            </div>

            <!-- If header type is image -->
            <div v-if="invoiceConfiguration.header_content_type == 'image'">
                <div class="form-group">
                    <label>
                        Header Image
                        <span class="text-danger">*</span>
                    </label>
                    <div class="controls">
                        <div class="input-group">
                            <input type="text" name="header_image_path" v-model="invoiceConfiguration.header_image_path"
                                   id="header_image_path" class="form-control">

                            <span class="input-group-append">
                            <button type="button" class="btn btn-light btn-sm popup_selector" data-toggle="modal"
                                    data-target="#widget-attributes-modal"
                                    @click="prepareModal('header'); processImagesByType(); canMultiple = false;">
                                <i class="la la-cloud-upload"></i> Browse
                            </button>
                            <button type="button" class="btn btn-light btn-sm"
                                    @click="deleteImage('header')"><i class="la la-eraser"></i> Clear</button>
                        </span>
                        </div>
                    </div>
                    <label class="d-block mt-3">Preview</label>
                    <div class="img-preview-wrapper border p-2 rounded">
                        <img :src="invoiceConfiguration.header_image_path" class="rounded d-block mx-auto img-fluid"
                             alt="Header image" height="150">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>
                    Footer Type
                    <span class="text-danger">*</span>
                </label>

                <select name="footer_content_type" class="form-control custom-select"
                        v-model="invoiceConfiguration.footer_content_type"
                        required>
                    <option value="html">HTML</option>
                    <option value="image">Image</option>
                </select>
            </div>

            <!-- if footer type is html -->
            <div v-if="invoiceConfiguration.footer_content_type == 'html'">
                <div class="form-group">
                    <label>
                        Footer Content
                        <span class="text-danger">*</span>
                    </label>

                    <ckeditor v-model="invoiceConfiguration.footer_content"
                              :class="{ 'is-invalid': invoiceConfiguration.footer_content }"></ckeditor>

                </div>
            </div>

            <!-- if footer type is image -->
            <div v-if="invoiceConfiguration.footer_content_type == 'image'">
                <div class="form-group">
                    <label>
                        Footer Image
                        <span class="text-danger">*</span>
                    </label>
                    <div class="controls">
                        <div class="input-group">
                            <input type="text" name="header_image_path" v-model="invoiceConfiguration.footer_image_path"
                                   id="footer_image_path" class="form-control">
                            <span class="input-group-append">
                  <button type="button" class="btn btn-light btn-sm popup_selector" data-toggle="modal"
                          data-target="#widget-attributes-modal"
                          @click="prepareModal('footer'); processImagesByType(); canMultiple = false;">
                      <i class="la la-cloud-upload"></i> Browse
                  </button>
                  <button type="button" class="btn btn-light btn-sm clear"
                          @click="deleteImage('footer')"><i class="la la-eraser"></i> Clear</button>
              </span>
                        </div>
                    </div>
                    <!--  img preview-->

                    <label class="d-block mt-3">Preview</label>
                    <div class="img-preview-wrapper border p-2 rounded">
                        <img :src="invoiceConfiguration.footer_image_path" class="rounded d-block mx-auto img-fluid"
                             alt="Footer image" height="150">
                    </div>
                </div>
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

            <button @click="$parent.saveCoreConfigInfo(invoiceConfiguration)" type="button" class="btn btn-success">
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
import _ from 'lodash'
import {PrismEditor} from 'vue-prism-editor'

// import highlighting library (you can use any library you want just return html string)
import {highlight, languages} from 'prismjs/components/prism-core'
import 'prismjs/components/prism-clike'
import 'prismjs/components/prism-javascript'
import 'prismjs/themes/prism-okaidia.min.css' // import syntax highlighting styles

export default {
    name: 'Invoice',
    mixins: [allDisksMixin],
    components: {PrismEditor},

    data() {
        return {
            invoiceConfiguration: {
                tab: 'invoice',
                header_content_type: this.$parent.coreConfigurationData.invoice.header_content_type,
                footer_content_type: this.$parent.coreConfigurationData.invoice.footer_content_type,
                header_content: this.$parent.coreConfigurationData.invoice.header_content,
                header_image_path: this.$parent.coreConfigurationData.invoice.header_image_path,
                footer_image_path: this.$parent.coreConfigurationData.invoice.footer_image_path,
                footer_content: this.$parent.coreConfigurationData.invoice.footer_content,
            },
            validationErrors: {},
            configurationDetails: {},
            activeModelFor: '',
        }
    },

    created() {
        /*
        axios.get('/admin/get-invoice-configuration')
          .then(res => {
              console.log(res?.data);
              this.configurationDetails = {
                  tab : 'invoice',
                  ...res?.data
              }

              this.initEdit();
          })
          .catch((err) => {
              console.error(err);
              new Noty({
                  type: "error",
                  text: 'Something went wrong!',
              }).show();
          });

       console.log("core config", this.configurationDetails);
       */
    },

    methods: {

        capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1)
        },

        removeError(key) {
            let errorsObject = this.validationErrors
            let errorExist = errorsObject[key]
            if (errorExist) {
                delete errorsObject[key]
            }
            //remove classfication error in sepecial causes
            if (errorsObject['product_classifications']) {
                delete errorsObject['product_classifications']
            }
            //for re-render parent component
            if (Object.keys(errorsObject).length <= 0) {
                this.validationErrors = ''
            }
            this.validationErrors = errorsObject
        },

        initEdit() {

            this.invoiceConfiguration = {
                tab: 'invoice',
                header_content_type: this.$parent.coreConfigurationData.invoice.header_content_type,
                footer_content_type: this.$parent.coreConfigurationData.invoice.footer_content_type,
                header_content: this.$parent.coreConfigurationData.invoice.header_content,
                header_image_path: this.$parent.coreConfigurationData.invoice.header_image_path,
                footer_content: this.$parent.coreConfigurationData.invoice.footer_content,
            }
        },

        highlighter(code) {
            return highlight(code, languages.js) //returns html
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
            event.preventDefault()
        },

        processImagesByType(indexOfAttributes = 0) {
            this.indexOfAttributes = indexOfAttributes;
            // invoiceConfiguration.footer_content_type == 'image'
            this.selectedFiles = this.activeModelFor === 'header' ? this.invoiceConfiguration.header_image_path : this.invoiceConfiguration.footer_image_path;
        },

        getFileAddedMessage() {
            let noty = {
                type: 'success',
                text: 'File path added!',
            }

            new Noty(noty).show()
        },

        deleteImage(type = 'header') {
            this.$swal({
                title: 'Remove this Image?',
                //icon              : 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff6b81',
                cancelButtonColor: '#399E7F',
                confirmButtonText: 'Remove'

            }).then((result) => {
                if (result.isConfirmed) {
                    if (type === 'header') {
                        this.invoiceConfiguration.header_image_path = ''
                    } else {
                        this.invoiceConfiguration.footer_image_path = ''
                    }
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
                if (files.length) {
                    const self = this

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
                    if (this.activeModelFor === 'header') {
                        self.invoiceConfiguration.header_image_path = self.$parent.selectedFiles;
                    } else {
                        self.invoiceConfiguration.footer_image_path = self.$parent.selectedFiles;
                    }

                    self.getFileAddedMessage()
                }
            }
        }
    }
}
</script>

<style>

.modal-backdrop.show {
    opacity: 0;
}
.img-preview-wrapper img {
    max-height: 180px;
}
</style>
