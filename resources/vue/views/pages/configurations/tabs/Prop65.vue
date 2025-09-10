<template>
    <div role="tabpanel" class="tab-pane active" id="tab_basic-info">
        <fieldset>
            <div class="d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
                <legend>
                    <i class="la la-exclamation-triangle mr-2"></i>
                    Prop65 Message
                </legend>
                
            </div>

            <div class="form-group">
                <label>Prop 65 Title</label>
                <input type="text" name="prop65_title"
                       placeholder="Prop 65 Title"
                       v-model="coreConfigurationData.prop65_title" class="form-control"
                       :class="{ 'is-invalid': $parent.validationErrors.prop65_title }">
            </div>

            <div class="form-group">
                <label>Prop 65 Message</label>
                <textarea class="form-control" type="text" id="prop65_message" name="prop65_message"
                            v-model="coreConfigurationData.prop65_message"
                            placeholder="Prop 65 Message"></textarea>
            </div>

            <div class="form-group">
                <label>
                    Warning Icon
                    <span class="text-danger">*</span>
                </label>
                <div class="controls">
                    <div class="input-group">
                        <input type="text" name="prop65_icon" v-model="coreConfigurationData.prop65_icon"
                                id="prop65_icon" class="form-control">

                        <span class="input-group-append">
                        <button type="button" class="btn btn-light btn-sm popup_selector" data-toggle="modal"
                                data-target="#widget-attributes-modal"
                                @click="prepareModal(); processImagesByType(); canMultiple = false;">
                            <i class="la la-cloud-upload"></i> Browse
                        </button>
                        <button type="button" class="btn btn-light btn-sm"
                                @click="deleteImage()"><i class="la la-eraser"></i> Clear</button>
                    </span>
                    </div>
                </div>
                <label class="d-block mt-3">Preview</label>
                <div class="img-preview-wrapper border p-2 rounded">
                    <img :src="coreConfigurationData.prop65_icon" class="rounded d-block mx-auto img-fluid"
                            alt="Header image" height="150">
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
                            Set icon for prop65 <strong> </strong>
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

        <div class="form-group">
            <input type="checkbox" name="prop65_status"
                    id="prop65_status"
                    v-model="coreConfigurationData.prop65_status">
            <label for="prop65_status">Enable Warning Message</label>
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
import _ from 'lodash'
import {PrismEditor} from 'vue-prism-editor'

export default {
    name: "Prop65",
    mixins: [allDisksMixin],

    data() {
        return {
            coreConfigurationData: {
                tab: "prop65",
                prop65_message: this.$parent.coreConfigurationData.prop65.prop65_message,
                prop65_title: this.$parent.coreConfigurationData.prop65.prop65_title,
                prop65_icon: this.$parent.coreConfigurationData.prop65.prop65_icon,
                prop65_status: this.$parent.coreConfigurationData.prop65.prop65_status
            }
        }
    },
    methods:{
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
            this.selectedFiles = this.coreConfigurationData.prop65_icon;
        },

        prepareModal() {
            setTimeout(() => {
                let modalShade = document.querySelector('.modal-backdrop.fade.show')
                modalShade ? modalShade.remove() : null
                this.modalShade = modalShade.outerHTML;
                this.modalBody = document.querySelector('#widget-attributes-modal .modal-body').innerHTML
            }, 10)
        },

        getFileAddedMessage() {
            let noty = {
                type: 'success',
                text: 'File path added!',
            }

            new Noty(noty).show()
        },

        getFileExtension(file) {
            const regexp = /\.([0-9a-z]+)(?:[\?#]|$)/i
            const extension = file.match(regexp)
            return extension && extension[1]
        },

        deleteImage() {
            this.$swal({
                title: 'Remove this Image?',
                showCancelButton: true,
                confirmButtonColor: '#ff6b81',
                cancelButtonColor: '#399E7F',
                confirmButtonText: 'Remove'

            }).then((result) => {
                if (result.isConfirmed) {
                    this.coreConfigurationData.prop65_icon = ""
                }
            })
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
                    self.coreConfigurationData.prop65_icon = self.$parent.selectedFiles;
                    self.getFileAddedMessage()
                }
            }
        }
    }
}
</script>
