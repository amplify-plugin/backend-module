<template>
    <div>
        <div class="form-group col-sm-12">
            <div v-if="$parent.invoiceConfiguration.errors.any()" class="alert alert-danger pb-0">
                <ul class="list-unstyled">
                    <div v-for="(error, index) in $parent.invoiceConfiguration.errors" :key="index">
                        <li v-for="(message, index) in error" :key="index">
                            <i class="la la-info-circle"></i>
                            {{ message[0] }}
                        </li>
                    </div>
                </ul>
            </div>
        </div>

        <div class="form-group col-sm-12 required">
            <label>
                Header Type
                <span class="text-danger font-weight-bold">*</span>
            </label>

            <select name="header_content_type" class="form-control"
                    v-model="$parent.invoiceConfiguration.header_content_type" required>
                <option value="html">HTML</option>
                <option value="image">Image</option>
            </select>

            <small class="text-danger mt-3" v-if="$parent.invoiceConfiguration.errors.has('header_content_type')">
                {{ $parent.invoiceConfiguration.errors.get("header_content_type") }}
            </small>

        </div>

        <!-- If type is html -->
        <div v-if="$parent.invoiceConfiguration.header_content_type == 'html'">
            <div class="form-group col-sm-12 required">
                <label>
                    Header Content Text
                    <span class="text-danger font-weight-bold">*</span>
                </label>

                <prism-editor class="my-editor height-300 language-xml-doc"
                              v-model="$parent.invoiceConfiguration.header_content"
                              :highlight="highlighter" :line-numbers="true"
                              :readonly="$parent.method === 'get'"></prism-editor>

                <small v-if="$parent.invoiceConfiguration.errors.has('header_content')" class="text-danger mt-3">
                    {{ $parent.invoiceConfiguration.errors.get("header_content") }}
                </small>
            </div>
        </div>

        <!-- If type is image -->
        <div v-if="$parent.invoiceConfiguration.header_content_type == 'image'">

            <div class="form-group col-sm-12 required" element="div" style="">
                <label>
                    Header Image
                    <span class="text-danger font-weight-bold">*</span>
                </label>
                <div class="controls">
                    <div class="input-group">
                        <input type="text" name="header_image_path"
                               v-model="$parent.invoiceConfiguration.header_image_path" id="header_image_path"
                               class="form-control"
                               :class="{'is-invalid': $parent.invoiceConfiguration.errors.has('header_image_path')}"
                               @keypress="$parent.invoiceConfiguration.errors.clear('header_image_path')">

                        <span class="input-group-append">
                <button type="button" class="btn btn-light btn-sm popup_selector" data-toggle="modal"
                        data-target="#widget-attributes-modal"
                        @click="prepareModal(); processImagesByType(); canMultiple = false;">
                  <i class="la la-cloud-upload"></i> Browse
                </button>
                <button type="button" class="btn btn-light btn-sm clear_elfinder_picker" @click="deleteImage()"><i
                    class="la la-eraser"></i> Clear</button>
              </span>
                    </div>
                    <small v-if="$parent.invoiceConfiguration.errors.has('header_image_path')" class="text-danger mt-3">
                        {{ $parent.invoiceConfiguration.errors.get("header_image_path") }}
                    </small>
                </div>
            </div>

        </div>

        <!-- If type is html -->
        <div>
            <div class="form-group col-sm-12 required">
                <label>
                    Footer Content
                    <span class="text-danger font-weight-bold">*</span>
                </label>

                <ckeditor v-model="$parent.invoiceConfiguration.footer_content"
                          :class="{'is-invalid': $parent.invoiceConfiguration.footer_content}"></ckeditor>

                <small v-if="$parent.invoiceConfiguration.errors.has('footer_content')" class="text-danger mt-3">
                    {{ $parent.invoiceConfiguration.errors.get("footer_content") }}
                </small>
            </div>
        </div>

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

    </div>
</template>

<script>
import allDisksMixin from '../../../allDisks.mixin';
import _ from "lodash";
import {PrismEditor} from "vue-prism-editor";

// import highlighting library (you can use any library you want just return html string)
import {highlight, languages} from "prismjs/components/prism-core";
import "prismjs/components/prism-clike";
import "prismjs/components/prism-javascript";
import "prismjs/themes/prism-okaidia.min.css"; // import syntax highlighting styles

export default {
    name: "FormFields",
    mixins: [allDisksMixin],
    props: [],
    data() {
        return {
            validationErrors: "",
            selectedFiles: [],
            canMultiple: false,
        };
    },
    created() {
        //
    },
    components: {PrismEditor},
    methods: {
        changeURLType(e) {
            let urlType = e.target.value;
            if (urlType == "page") {
                this.$parent.menu.url = "";
                this.page = true;
            } else {
                this.page = false;
            }
        },
        highlighter(code) {
            return highlight(code, languages.js); //returns html
        },

        // File Manager methods
        prepareModal() {
            setTimeout(() => {
                let modalShade = document.querySelector(".modal-backdrop.fade.show");
                modalShade ? modalShade.remove() : null;
                this.modalShade = modalShade.outerHTML
                this.modalBody = document.querySelector("#widget-attributes-modal .modal-body").innerHTML
            }, 10);
        },
        removeSelectedFiles(index, length = 1) {
            let path = this.selectedFiles.splice(index, length);
            let noty = {
                type: 'success',
                text: `File (${path}) removed!`,
            };
            new Noty(noty).show()
        },

        browseMainImage(event) {
            event.preventDefault();
        },

        processImagesByType(indexOfAttributes = 0) {
            this.indexOfAttributes = indexOfAttributes;
            this.selectedFiles = this.$parent.invoiceConfiguration.header_image_path;
        },

        getFileAddedMessage() {
            let noty = {
                type: "success",
                text: "File path added!",
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
                confirmButtonText: 'Remove'

            }).then((result) => {
                if (result.isConfirmed) {
                    this.$parent.invoiceConfiguration.header_image_path = '';
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
        "$store.state.fm.left.selected.files": {
            handler(files) {
                if (files.length) {
                    const self = this;

                    if (self.canMultiple) {
                        let filesPath = files.filter(file => {
                            return ['jpg', 'jpeg', 'png'].includes(self.getFileExtension(file.toLowerCase()));
                        });

                        if (filesPath) {
                            self.$parent.selectedFiles = filesPath.map(filePath => {
                                return self.all_disks[self.$store.state.fm.left.selectedDisk].url ? self.all_disks[self.$store.state.fm.left.selectedDisk].url + "/" + filePath : "/" + filePath;
                            })
                        }
                    } else {
                        let filePath = files.find(file => {
                            return ['jpg', 'jpeg', 'png'].includes(self.getFileExtension(file.toLowerCase()));
                        });

                        if (filePath) {
                            self.$parent.selectedFiles = self.all_disks[self.$store.state.fm.left.selectedDisk].url ? self.all_disks[self.$store.state.fm.left.selectedDisk].url + "/" + filePath : "/" + filePath;
                        }
                    }
                    self.$parent.invoiceConfiguration.header_image_path = self.$parent.selectedFiles;
                    self.getFileAddedMessage();
                }
            }
        }
    }
};
</script>

<style lang="scss" scoped>
// required class
.my-editor {
    background: #2d2d2d;
    color: #ccc;
    font-family: Fira code, Fira Mono, Consolas, Menlo, Courier, monospace;
    font-size: 14px;
    line-height: 1.5;
    padding: 5px;
}

// optional
.prism-editor__textarea:focus {
    outline: none;
}

pre.prism-editor__editor {
    color: #ccc;
}

// not required:
.height-300 {
    height: 250px;
}

.prism-editor__editor {
    min-height: 250px;
}
</style>
