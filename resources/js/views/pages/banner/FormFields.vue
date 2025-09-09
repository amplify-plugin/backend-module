<template>
    <div>
        <div class="form-group col-sm-12">
            <div v-if="$parent.banner.errors.any()" class="alert alert-danger pb-0">
                <ul class="list-unstyled">
                    <div v-for="(error, index) in $parent.banner.errors" :key="index">
                        <li v-for="(message, index) in error" :key="index">
                            <i class="la la-info-circle"></i>
                            {{ message[0] }}
                        </li>
                    </div>
                </ul>
            </div>
        </div>

        <!-- text input -->
        <div class="form-group col-sm-12 required">
            <label>
                Name
            </label>

            <input type="text" name="name" v-model="$parent.banner.name" placeholder="Enter name" class="form-control"
                   :class="{ 'is-invalid': $parent.validationErrors?.name}"/>
            <small class="text-danger mt-3" v-if="$parent.validationErrors?.name">
                {{ $parent.validationErrors?.name[0] }}
            </small>
        </div>

        <div class="form-group col-sm-12 required">
            <label>
                Description
            </label>

            <textarea name="desc" v-model="$parent.banner.desc" placeholder="Enter description" class="form-control"
                      :class="{ 'is-invalid': $parent.validationErrors?.desc }"></textarea>
            <small class="text-danger mt-3" v-if="$parent.validationErrors?.desc">
                {{ $parent.validationErrors?.desc[0] }}
            </small>
        </div>

        <div class="form-group col-sm-12 required">
            <label>
                Code
            </label>

            <input type="text" name="code" v-model="$parent.banner.code" placeholder="Enter Code" class="form-control"
                   :class="{ 'is-invalid': $parent.validationErrors?.code }"/>
            <small class="text-danger mt-3" v-if="$parent.validationErrors?.code">
                {{ $parent.validationErrors?.code[0] }}
            </small>
        </div>

        <div class="form-group col-sm-12 required">
            <label>
                Value Type
            </label>

            <select name="value_type" class="form-control" v-model="$parent.banner.type">
                <option value="html">HTML</option>
                <option value="image">Image</option>
                <option value="video">Video</option>
            </select>

            <small class="text-danger mt-3" v-if="$parent.banner.errors.has('value_type')">
                {{ $parent.banner.errors.get("value_type") }}
            </small>

        </div>

        <!-- If type is html -->
        <div v-if="$parent.banner.type == 'html'">
            <div class="form-group col-sm-12 required">
                <label>
                    HTML Code
                </label>

                <prism-editor class="my-editor height-300 language-xml-doc" v-model="$parent.banner.content"
                              :highlight="highlighter" :line-numbers="true"
                              :readonly="$parent.method === 'get'"></prism-editor>

                <small v-if="$parent.validationErrors?.content" class="text-danger mt-3">
                    {{ $parent.validationErrors?.content[0] }}
                </small>
            </div>
        </div>

        <!-- If type is video -->
        <div v-if="$parent.banner.type == 'video'">
            <div class="form-group col-sm-12 required">
                <label>
                    Video URL
                </label>

                <input name="video_link" v-model="$parent.banner.video_link" placeholder="Enter video link"
                       class="form-control"
                       :class="{'is-invalid': $parent.banner.errors.has('video_link')}"
                       @keypress="$parent.banner.errors.clear('video_link')"/>
                <small v-if="$parent.validationErrors?.video_link" class="text-danger mt-3">
                    {{ $parent.validationErrors?.video_link[0] }}
                </small>
            </div>
        </div>

        <!-- If type is image -->
        <div v-if="$parent.banner.type == 'image'">

            <div class="form-group col-sm-12 required" element="div" style="">
                <label>
                    Image
                </label>
                <div class="controls">
                    <div class="input-group">
                        <input type="text" name="image_path" v-model="$parent.banner.image_path" id="image_path"
                               class="form-control" :class="{'is-invalid': $parent.banner.errors.has('image_path')}"
                               @keypress="$parent.banner.errors.clear('image_path')">

                        <span class="input-group-append">
              <button type="button" class="btn btn-light btn-sm popup_selector" data-toggle="modal"
                      data-target="#widget-attributes-modal"
                      @click="prepareModal(); processImagesByType(); canMultiple = false;">
                <i class="la la-cloud-upload"></i> Browse
              </button>
              <button type="button" class="btn btn-light btn-sm" @click="deleteImage()"><i
                  class="la la-eraser"></i> Clear</button>
            </span>
                    </div>
                    <small v-if="$parent.validationErrors?.image_path" class="text-danger mt-3">
                        {{ $parent.validationErrors?.image_path[0] }}
                    </small>
                </div>
            </div>

            <div class="form-group col-sm-12 required" element="div" style="">
                <label>
                    Image Text
                </label>
                <div class="controls">
                    <div class="input-group">
                        <input type="text" name="image_text" placeholder="Enter Image Text"
                               v-model="$parent.banner.image_text"
                               id="image_text" class="form-control"
                               :class="{'is-invalid': $parent.banner.errors.has('image_text')}"
                               @keypress="$parent.banner.errors.clear('image_text')">
                    </div>
                    <small v-if="$parent.validationErrors?.image_text" class="text-danger mt-3">
                        {{ $parent.validationErrors?.image_text[0] }}
                    </small>
                </div>
            </div>

            <div class="form-group col-sm-12 required" style="">
                <label>
                    Image Text Link
                </label>
                <div class="controls">
                    <div class="input-group">
                        <input type="text" name="image_text_link" placeholder="Enter Text Link"
                               v-model="$parent.banner.image_text_link" id="image_text_link" class="form-control"
                               :class="{'is-invalid': $parent.banner.errors.has('image_text_link')}"
                               @keypress="$parent.banner.errors.clear('image_text_link')">
                    </div>
                    <small v-if="$parent.validationErrors?.image_text_link" class="text-danger mt-3">
                        {{ $parent.validationErrors?.image_text_link[0] }}
                    </small>
                </div>
            </div>
        </div>

        <div class="modal fade" id="widget-attributes-modal" tabIndex="0" role="dialog"
             aria-labelledby="widget-attributes-modal-dialog-label" data-backdrop="static" data-keyboard="false"
             aria-modal="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="attribute-inline-create-dialog-label">
                            Set image for banner <strong> </strong>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" @click="modalShade = '';"
                                aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body bg-light">

                        <!-- Default box -->
                        <div class="card" style="margin-bottom: 0!important;">
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
            this.selectedFiles = this.$parent.banner.image_path;
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
                    this.$parent.banner.image_path = '';
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
                    self.$parent.banner.image_path = self.$parent.selectedFiles;
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
    min-height: 350px;
}
</style>
