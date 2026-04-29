<template>
    <div>
        <div class="form-group">
            <label :class="{'error-color': $parent.validationErrors.code}">
                Code
            </label>
            <input @input="removeError('code');" type="text"
                   name="name"
                   v-model="$parent.slider.code"
                   placeholder="Enter unique code"
                   class="form-control" :class="{'is-invalid': $parent.validationErrors.code}"
            >
            <small v-if="$parent.validationErrors.code" class="text-danger mt-3">{{
                    $parent.validationErrors.code[0]
                }}</small>
        </div>

        <div class="form-group">
            <label :class="{'error-color': $parent.validationErrors.banner_zone_id}">
                Banner Zone
                <span class="text-danger font-weight-bold">*</span>
            </label>

            <select name="banner_zone_id"
                    @change="removeError('banner_zone_id');"
                    v-model="$parent.slider.banner_zone_id"
                    class="form-control custom-select" :class="{'is-invalid': $parent.validationErrors.banner_zone_id}">
                <option v-for="(name, index) of $parent.bannerZoneArray"
                        :key="index"
                        :selected="$parent.slider.banner_zone_id == index"
                        :value="index">
                    {{ name }}
                </option>
            </select>
            <small v-if="$parent.validationErrors.banner_zone_id"
                   class="text-danger mt-3">{{
                    $parent.validationErrors.banner_zone_id[0]
                }}</small>
        </div>

        <div class="form-group">
            <label :class="{'error-color': $parent.validationErrors.name}">
                Heading
            </label>
            <input @input="removeError('name');" type="text"
                   name="name"
                   v-model="$parent.slider.name"
                   placeholder="Enter name"
                   class="form-control" :class="{'is-invalid': $parent.validationErrors.name}"
            >
            <small v-if="$parent.validationErrors.name" class="text-danger mt-3">{{
                    $parent.validationErrors.name[0]
                }}</small>
        </div>

        <div class="form-group d-none">
            <label>
                Foreground Type
            </label>

            <select name="foreground_type" class="form-control" v-model="$parent.slider.foreground_type">
                <option value="image">Image</option>
                <option value="video">Video</option>
            </select>
        </div>

        <div class="form-group required">
            <label>
                Background Type
            </label>

            <select name="background_type" class="form-control" v-model="$parent.slider.background_type">
                <option value="image">Image</option>
                <option value="video">Video</option>
            </select>
        </div>

        <div class="form-group" :class="{'text-danger': $parent.validationErrors.background_image}">
            <label>
                Background
            </label>
            <div class="controls">
                <div class="input-group">
                    <input type="text" name="background_image"
                           :value="$parent.slider.background_image"
                           id="background_image" class="form-control"
                           @keypress="$parent.slider.errors.clear('background_image')">
                    <span class="input-group-append">
                        <button type="button"
                                class="btn btn-light btn-sm popup_selector"
                                :class="{'is-invalid' : $parent.validationErrors?.background_image ?? false}"
                                data-toggle="modal"
                                data-target="#widget-attributes-modal"
                                @click="canMultiple = false; prepareModal(); processImagesByType('background_image'); imageType = 'background_image'">
                            <i class="la la-cloud-upload"></i> Browse
                        </button>
                        <button type="button" class="btn btn-light btn-sm clear_elfinder_picker"
                                @click="deleteImage(); imageType = 'background_image'"><i class="la la-eraser"></i> Clear</button>
                    </span>
                </div>
                <small v-if="$parent.validationErrors.background_image" class="text-danger mt-3">
                    {{ $parent.validationErrors.background_image[0] }}
                </small>
            </div>
        </div>

        <div class="form-group" :class="{'text-danger': $parent.validationErrors.image}">
            <label>
                Foreground
            </label>
            <div class="controls">
                <div class="input-group">
                    <input type="text" name="image" :value="$parent.slider.image" id="image" class="form-control"
                           @keypress="$parent.slider.errors.clear('image')">

                    <span class="input-group-append">
                        <button type="button"
                                class="btn btn-light btn-sm popup_selector"
                                :class="{'is-invalid' : $parent.validationErrors?.image ?? false}"
                                data-toggle="modal"
                                data-target="#widget-attributes-modal"
                                @click="prepareModal(); processImagesByType(); canMultiple = false; imageType = null">
                            <i class="la la-cloud-upload"></i> Browse
                        </button>
                        <button type="button" class="btn btn-light btn-sm clear_elfinder_picker"
                                @click="deleteImage(); imageType = null"><i class="la la-eraser"></i> Clear</button>
                    </span>
                </div>
                <small v-if="$parent.validationErrors.image" class="text-danger mt-3">
                    {{ $parent.validationErrors.image[0] }}
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
                            Set Image
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
                                @click="modalShade = '';" aria-label="Close" id="cancelWidgetAttributesModalBtn">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="checkbox my-0 my-lg-2">
                <input id="has_heading" type="checkbox" v-model="$parent.slider.has_heading">
                <label for="has_heading" class="form-check-label font-weight-normal"> Display Heading </label>
            </div>
        </div>

        <div class="form-group">
            <div class="checkbox my-0 my-lg-2">
                <input id="has_content" type="checkbox" v-model="$parent.slider.has_content">
                <label for="has_content" class="form-check-label font-weight-normal"> Display Content </label>
            </div>
        </div>

        <div v-if="$parent.slider.has_content" class="form-group"
             :class="{'text-danger': $parent.validationErrors.content}">
            <label>Content </label>
            <i class="la la-flag-checkered pull-right" style="margin-top: 3px;"
               title="This field is translatable."></i>
            <ckeditor v-model="$parent.slider.content"
                      :class="{'is-invalid': $parent.validationErrors.content}"
            ></ckeditor>
            <small v-if="$parent.validationErrors.content"
                   class="text-danger mt-3">{{ $parent.validationErrors.content }}</small>
        </div>

        <div class="form-group">
            <div class="checkbox my-0 my-lg-2">
                <input id="has_button" type="checkbox" v-model="$parent.slider.has_button">
                <label for="has_button" class="form-check-label font-weight-normal"> Display Link Button </label>
            </div>
        </div>

        <div v-if="$parent.slider.has_button">
            <div class="form-group">
                <label :class="{'error-color': $parent.validationErrors.button_title}">
                    Button Title
                </label>
                <input @input="removeError('button_title');" type="text"
                       name="button_title"
                       v-model="$parent.slider.button_title"
                       placeholder="Enter Title"
                       class="form-control" :class="{'is-invalid': $parent.validationErrors.button_title}"
                >
                <small v-if="$parent.validationErrors.button_title" class="text-danger mt-3">{{
                        $parent.validationErrors.button_title[0]
                    }}</small>
            </div>

            <div class="form-group">
                <label>Button Style</label>
                <select v-model="$parent.slider.button_style"
                        name="button_style"
                        class="form-control">
                    <option v-for="buttonClass in buttonClasses"
                            :value="buttonClass.value"
                            :key="buttonClass.value"
                            :style="{'background':buttonClass.color, 'color': 'white'}"
                    >
                        {{ buttonClass.name }}
                    </option>
                </select>
            </div>

            <div class="form-group">
                <div class="checkbox my-0 my-lg-2">
                    <input id="open_new_tab" type="checkbox" v-model="$parent.slider.open_new_tab">
                    <label for="open_new_tab" class="form-check-label font-weight-normal"> Open Link In New Tab </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label> Slider Link </label>
            <input @input="removeError('button_link');" type="url"
                   name="button_link"
                   v-model="$parent.slider.button_link"
                   placeholder="Enter Link"
                   class="form-control"
            >
        </div>
        <div class="form-group">
            <label> Slider Ratio </label>
            <template v-for="ratio in sliderRatio">
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="radio"
                        :id="ratio.value"
                        :value="ratio.value"

                        v-model="$parent.slider.slider_ratio"
                    >
                    <label class="form-check-label" :for="ratio.value">
                        {{ ratio.name }}
                    </label>
                </div>
            </template>
        </div>

        <div class="form-group">
            <label>Text/Image Position</label>
            <template v-for="alignment in alignments">
                <div class="form-check mb-2" v-if="alignment.value !== 'center'">
                    <input
                        class="form-check-input"
                        type="radio"
                        :id="'image-text-' + alignment.value"
                        :value="alignment.value"
                        v-model="$parent.slider.alignment"
                    >
                    <label class="form-check-label" :for="'image-text-' + alignment.value">
                        <img class="mr-2" :src="alignment.image" alt="icon-image" width="80"/>{{ alignment.name }}
                    </label>
                </div>
            </template>
        </div>

        <div class="form-group">
            <label> Text Alignment </label>
            <template v-for="alignment in alignments">
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="radio"
                        :id="'text-' + alignment.value"
                        :value="alignment.value"
                        v-model="$parent.slider.text_alignment"
                    >
                    <label class="form-check-label" :for="'text-' + alignment.value">
                        <i :class="alignment.icon" class="mr-2"></i>{{ alignment.name }}
                    </label>
                </div>
            </template>
        </div>

        <div class="form-group">
            <label> Image Alignment </label>
            <template v-for="alignment in alignments">
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="radio"
                        :id="'image-' + alignment.value"
                        :value="alignment.value"
                        v-model="$parent.slider.image_alignment"
                    >
                    <label class="form-check-label" :for="'image-' + alignment.value">
                        <i :class="alignment.icon" class="mr-2"></i>{{ alignment.name }}
                    </label>
                </div>
            </template>
        </div>

        <div class="form-group">
            <div class="checkbox my-0 my-lg-2">
                <input id="slider_enabled" type="checkbox" v-model="$parent.slider.enabled">
                <label for="slider_enabled" class="form-check-label font-weight-normal">Enabled</label>
            </div>
        </div>
    </div>
</template>

<script>
import allDisksMixin from '../../../allDisks.mixin';
import {white} from "tailwindcss/colors";


export default {
    name: "FormFields",
    mixins: [allDisksMixin],

    data() {
        return {
            buttonClasses: [
                {
                    name: "Primary",
                    value: "primary",
                    color: "",
                },
                {
                    name: "Secondary",
                    value: "secondary",
                    color: "",
                },
                {
                    name: "Success",
                    value: "success",
                    color: "",
                },
                {
                    name: "Info",
                    value: "info",
                    color: "",
                },
                {
                    name: "Warning",
                    value: "warning",
                    color: "",
                },
                {
                    name: "Danger",
                    value: "danger",
                    color: "",
                },
            ],
            sliderRatio: [
                {
                    name: "30% - 70%",
                    value: 3
                },
                {
                    name: "40% - 60%",
                    value: 4
                },
                {
                    name: "50% - 50%",
                    value: 6
                },
                {
                    name: "60% - 40%",
                    value: 8
                },
                {
                    name: "70% - 30%",
                    value: 9
                },
            ],
            alignments: [
                {
                    name: "Left",
                    value: "left",
                    icon: "la la-align-left",
                    image: '/vendor/backend/img/img-right.png'
                },
                {
                    name: "Center",
                    value: "center",
                    icon: "la la-align-center",
                    image: null

                },
                {
                    name: "Right",
                    value: "right",
                    icon: "la la-align-right",
                    image: '/vendor/backend/img/img-left.png'

                },
            ],
            imageType: null,
            canMultiple: false
        }
    },
    mounted() {
        var templateOptions = {};

        this.$parent.templateColors.forEach(function (option) {
            templateOptions[option.name] = option.value;
        })

        this.buttonClasses.forEach(function (button, index) {
            if (templateOptions.hasOwnProperty(button.value + '_color')) {
                button['color'] = templateOptions[button.value + '_color'];
            }
        })
    },
    methods: {
        white() {
            return white
        },
        removeError(key) {
            let errorsObject = this.$parent.validationErrors;
            let errorExist = errorsObject[key];
            if (errorExist) {
                delete errorsObject[key];
            }
            //for re-render parent component
            if (Object.keys(errorsObject).length <= 0) {
                this.$parent.validationErrors = "";
            }
            this.$parent.validationErrors = errorsObject;
        },

        prepareModal() {
            setTimeout(() => {
                let modalShade = document.querySelector(".modal-backdrop.fade.show");
                modalShade ? modalShade.remove() : null;
                this.modalShade = modalShade.outerHTML
                this.modalBody = document.querySelector("#widget-attributes-modal .modal-body").innerHTML
            }, 10);
        },

        processImagesByType(indexOfAttributes = 0) {
            this.indexOfAttributes = indexOfAttributes;
            if (this.imageType != 'background_image') {
                this.selectedFiles = this.$parent.slider.image;
            } else {
                this.selectedFiles = this.$parent.slider.background_image;
            }
        },

        uploadImage(event) {
            let file = event.target.files[0];
            if (file.size > 3048770) {
                alert('Media file must not be greater than 3048770 bytes')
            } else {
                let reader = new FileReader();
                reader.onload = event => {
                    this.$parent.slider.image = event.target.result;
                }
                reader.readAsDataURL(file);
            }
        },

        getFileAddedMessage() {

            let noty = {
                type: "success",
                text: "File path added!",
            };

            new Noty(noty).show();
        },

        deleteImage() {
            this.$swal({
                title: 'Remove this Image?',
                //icon              : 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff6b81',
                cancelButtonColor: '#399E7F',
                confirmButtonText: 'Remove'

            }).then((result) => {
                if (result.isConfirmed) {
                    if (this.imageType === "background_image") {
                        this.$parent.slider.background_image = '';
                    } else {
                        this.$parent.slider.image = '';
                    }
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
                    const asset_base_url = self.all_disks[self.$store.state.fm.left.selectedDisk].hasOwnProperty('url') ?
                        self.all_disks[self.$store.state.fm.left.selectedDisk].url + "/" : "/";

                    if (self.canMultiple) {
                        let filesPath = files.filter(file => {
                            return ['jpg', 'jpeg', 'png', 'mp4'].includes(self.getFileExtension(file.toLowerCase()));
                        });

                        if (filesPath) {
                            self.$parent.selectedFiles = filesPath.map(filePath => {
                                return asset_base_url + filePath;
                            })
                        }
                    }

                    else {
                        let filePath = files.find(file => {
                            return ['jpg', 'jpeg', 'png', 'mp4'].includes(self.getFileExtension(file.toLowerCase()));
                        });

                        if (filePath) {
                            self.$parent.selectedFiles = asset_base_url + filePath;
                        }
                    }

                    if (this.imageType === "background_image") {
                        self.$parent.slider.background_image = self.$parent.selectedFiles;
                    } else {
                        self.$parent.slider.image = self.$parent.selectedFiles;
                    }

                    console.log(self.$parent.slider, asset_base_url);

                    self.getFileAddedMessage();
                }
            }
        }
    }

}
</script>

<style scoped>
.error-color {
    color: red;
}

.required-custom {
    color: #ff0000;
}

.cke_contents {
    min-height: 300px !important;
}

.my-editor {
    background: #2d2d2d;
    color: #ccc !important;
    font-family: Consolas, Menlo, Courier, monospace;
    font-size: 14px;
    line-height: 1.5;
    padding: 5px;
    border-radius: 4px !important;
    min-height: 350px !important;
}

</style>