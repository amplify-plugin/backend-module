<template>
    <div role="tabpanel" class="tab-pane active" id="tab_basic-info">
        <fieldset>
            <div class="d-flex justify-content-between border-bottom pb-0 mb-3 mt-n3">
                <legend>
                    <i class="la la-file mr-2"></i>
                    Basic Information
                </legend>
                <div class="d-md-none custom-sidebar-ar" @click="$parent.toggleSidebar()">
                    <div class="menu-icon-ar">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#1b2a4e"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-menu"
                        >
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </div>
                    <div class="close-icon-ar">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="red"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-x"
                        >
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Global Currency</label>
                <div>
                    <select class="form-control custom-select" v-model="coreConfigurationData.global_currency">
                        <option :value="code" v-for="(currency, code) in $parent.allCurrencies" :key="code">
                            {{ currency }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Default Language</label>
                <div>
                    <select
                        class="form-control custom-select"
                        v-model="coreConfigurationData.default_language"
                        :class="{ 'is-invalid': $parent.validationErrors.default_language }"
                    >
                        <option
                            v-for="(language, index) in $parent.availableLocales"
                            :value="language.value"
                            :key="index"
                            :selected="coreConfigurationData.default_language === language.value"
                        >
                            {{ language.name }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Countries</label>
                <div>
                    <multiselect
                        v-model="coreConfigurationData.countries"
                        :options="$parent.countriesData"
                        :multiple="true"
                        :close-on-select="true"
                        :clear-on-select="false"
                        label="name"
                        track-by="id"
                    ></multiselect>
                    <small v-if="$parent.validationErrors.countries" class="text-danger mt-3">
                        {{ $parent.validationErrors.countries[0] }}
                    </small>
                </div>
            </div>

            <div class="form-group">
                <label>Hierarchies</label>
                <div>
                    <multiselect
                        v-model="coreConfigurationData.hierarchies"
                        :options="$parent.hierarchiesData"
                        :multiple="true"
                        :close-on-select="false"
                        :clear-on-select="false"
                        :preserve-search="true"
                        :hide-selected="true"
                    >
                        <template slot="selection">
                            <span class="multiselect__single" v-if="$parent.validationErrors.sku_default_attributes">
                                {{ $parent.validationErrors.sku_default_attributes[0] }}
                            </span>
                        </template>
                    </multiselect>
                    <small v-if="$parent.validationErrors.sku_default_attributes" class="text-danger mt-3">{{
                            $parent.validationErrors.sku_default_attributes[0]
                        }}</small>
                </div>
            </div>

            <div class="form-group">
                <label>Web Order Prefix</label>
                <input
                    type="text"
                    name="web_order_prefix"
                    placeholder="Enter Web Order Prefix "
                    v-model="coreConfigurationData.web_order_prefix"
                    class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.web_order_prefix }"
                />
                <small v-if="$parent.validationErrors.web_order_prefix" class="text-danger mt-3">{{
                        $parent.validationErrors.web_order_prefix[0]
                    }}</small>
            </div>

            <div class="form-group">
                <label>Nxt available web order number</label>
                <input
                    type="text"
                    name="nxt_available_web_order_number"
                    placeholder="Enter Next Available Web Order Number"
                    v-model="coreConfigurationData.nxt_available_web_order_number"
                    class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.nxt_available_web_order_number }"
                />
                <small v-if="$parent.validationErrors.nxt_available_web_order_number" class="text-danger mt-3">{{
                        $parent.validationErrors.nxt_available_web_order_number[0]
                    }}</small>
            </div>

            <div class="form-group">
                <label>Contact Import Default Password</label>
                <input
                    :type="passwordType"
                    name="contact_import_default_password"
                    placeholder="Enter Contact Default Password"
                    v-model="coreConfigurationData.contact_import_default_password"
                    class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.contact_import_default_password }"
                    min="8"
                />
                <i
                    @click="togglePasswordShow"
                    :class="{
                        'eye-position las la-eye-slash': showPassword,
                        'eye-position las la-eye': !showPassword,
                    }"
                ></i>
                <small v-if="$parent.validationErrors.contact_import_default_password" class="text-danger mt-3">{{
                        $parent.validationErrors.contact_import_default_password[0]
                    }}</small>
            </div>

            <div class="form-group">
                <label>Date Time Format</label>
                <select
                    name="date_time_format"
                    class="form-control custom-select"
                    v-model="coreConfigurationData.date_time_format"
                >
                    <option
                        :value="index"
                        v-for="(date_time_example, index) in $parent.dateTimes"
                        :key="index"
                        :selected="index === coreConfigurationData.date_time_format"
                    >
                        {{ date_time_example }}
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label>Date Format</label>
                <select
                    name="date_format"
                    class="form-control custom-select"
                    v-model="coreConfigurationData.date_format"
                >
                    <option
                        :value="index"
                        v-for="(date_example, index) in $parent.dates"
                        :key="index"
                        :selected="index === coreConfigurationData.date_format"
                    >
                        {{ date_example }}
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label>Default Reorder Limit</label>
                <input
                    type="number"
                    name="default_reorder_limit"
                    placeholder="Enter product limit"
                    v-model="coreConfigurationData.default_reorder_limit"
                    class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.default_reorder_limit }"
                />
                <small v-if="$parent.validationErrors.default_reorder_limit" class="text-danger mt-3">{{
                        $parent.validationErrors.default_reorder_limit[0]
                    }}</small>
            </div>
            <div class="form-group required" style="">
                <label>Navbar Brand</label>
                <div class="controls">
                    <div class="input-group">
                        <input type="text" name="navbar_image_path" v-model="coreConfigurationData.navbar_brand"
                               id="navbar_image_path" class="form-control"
                               @keypress="coreConfigurationData.errors.clear('navbar_image_path')" readonly>

                        <span class="input-group-append">
                                    <button type="button" class="btn btn-light btn-sm popup_selector"
                                            data-toggle="modal"
                                            data-target="#widget-attributes-modal"
                                            @click="prepareModal('navbar'); processImagesByType(); canMultiple = false;">
                                        <i class="la la-cloud-upload"></i> Browse
                                    </button>
                                    <button type="button" class="btn btn-light btn-sm clear_elfinder_picker"
                                            @click="deleteImage('navbar')"><i class="la la-eraser"></i> Clear</button>
                                </span>
                    </div>
                </div>
            </div>

            <!--            <div class="form-group required" style="">-->
            <!--                <label>Footer Image</label>-->
            <!--                <div class="controls">-->
            <!--                    <div class="input-group">-->
            <!--                        <input type="text" name="footer_image_path" v-model="coreConfigurationData.footer_image"-->
            <!--                               id="footer_path" class="form-control"-->
            <!--                               @keypress="coreConfigurationData.errors.clear('footer_image_path')" readonly>-->

            <!--                        <span class="input-group-append">-->
            <!--                        <button type="button" class="btn btn-light btn-sm popup_selector" data-toggle="modal"-->
            <!--                                data-target="#widget-attributes-modal"-->
            <!--                                @click="prepareModal('footer'); processImagesByType(); canMultiple = false;">-->
            <!--                            <i class="la la-cloud-upload"></i> Browse-->
            <!--                        </button>-->
            <!--                        <button type="button" class="btn btn-light btn-sm clear_elfinder_picker"-->
            <!--                                @click="deleteImage('footer')"><i class="la la-eraser"></i> Clear</button>-->
            <!--                    </span>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            -->
            <div class="form-group">
                <label>Pagination Length Options</label>
                <input
                    type="text"
                    name="length_options"
                    placeholder="Enter Values in comma-seperated"
                    v-model="coreConfigurationData.length_options"
                    class="form-control"
                    :class="{ 'is-invalid': $parent.validationErrors.length_options }"
                />
                <small v-if="$parent.validationErrors.length_options" class="text-danger mt-3">{{
                        $parent.validationErrors.length_options[0]
                    }}</small>
            </div>

            <!-- Backend Theme -->
            <div class="form-group">
                <label>Admin Color Scheme</label>
                <multiselect
                    v-model="currentTheme"
                    :options="themes"
                    track-by="code"
                    label="label"
                    :clear-on-select="false"
                    :preserve-search="true"
                >
                    <template slot="option" slot-scope="props">
                        <span class="font-weight-bold d-flex justify-content-start align-items-center">
                            <i :class="props.option.code"></i>
                            {{ props.option.label }}
                        </span>
                    </template>
                    <template slot="singleLabel" slot-scope="{ option }">
                        <span class="font-weight-bold d-flex justify-content-start align-items-center">
                            <i :class="option.code"></i>
                            {{ option.label }}
                        </span>
                    </template>
                </multiselect>
                <small v-if="$parent.validationErrors.color_scheme" class="text-danger mt-3">{{
                        $parent.validationErrors.color_scheme[0]
                    }}</small>
            </div>

            <div class="form-group">
                <label>Use Recaptcha</label><br/>
                <input
                    type="radio"
                    name="recaptcha_status"
                    :value="false"
                    v-model="coreConfigurationData.recaptcha_status"
                    :class="{ 'is-invalid': $parent.validationErrors.recaptcha_status }"
                />
                <span class="mr-2">No</span>
                <input
                    type="radio"
                    name="recaptcha_status"
                    :value="true"
                    v-model="coreConfigurationData.recaptcha_status"
                    :class="{ 'is-invalid': $parent.validationErrors.recaptcha_status }"
                />
                <span class="mr-2">Yes</span>
                <small v-if="$parent.validationErrors.recaptcha_status" class="text-danger mt-3">{{
                        $parent.validationErrors.recaptcha_status[0]
                    }}</small>
            </div>

            <div class="form-group" v-if="coreConfigurationData.recaptcha_status">
                <div>
                    <label>Recaptcha Type</label><br/>

                    <select
                        name="erps"
                        class="form-control custom-select"
                        :class="{ 'is-invalid': $parent.validationErrors.erps }"
                        v-model="coreConfigurationData.recaptcha_type"
                    >
                        <option
                            :value="recpatcha.value"
                            v-for="(recpatcha, index) in recaptchaTypes"
                            :key="index"
                            :selected="recpatcha.value == coreConfigurationData.recaptcha_type ? true : false"
                        >
                            {{ recpatcha.title }}
                        </option>
                    </select>

                    <small v-if="$parent.validationErrors.recaptcha_type" class="text-danger mt-3">{{
                            $parent.validationErrors.recaptcha_type[0]
                        }}</small>
                </div>
                <div class="mt-3" v-if="recaptchaImage">
                    <label> Preview: </label>&nbsp;
                    <span v-html="recaptchaImage"> </span>
                </div>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input
                        type="checkbox"
                        name="enable_quick_list"
                        id="enable_quick_list"
                        v-model="coreConfigurationData.enable_quick_list"
                        :class="{ 'is-invalid': $parent.validationErrors.enable_quick_list, 'form-check-input': true }"
                    />
                    <label for="enable_quick_list">Allow quick list option in favorites.</label>
                    <small v-if="$parent.validationErrors.enable_quick_list" class="text-danger mt-3">{{
                            $parent.validationErrors.enable_quick_list[0]
                        }}</small>
                </div>
                <small class="text-muted d-block"
                >If enabled the on favourites a new option will appear named "Quick List"</small
                >
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input
                        type="checkbox"
                        name="enable_multi_customer_manage"
                        id="enable_multi_customer_manage"
                        v-model="coreConfigurationData.enable_multi_customer_manage"
                        :class="{
                            'is-invalid': $parent.validationErrors.enable_multi_customer_manage,
                            'form-check-input': true,
                        }"
                    />
                    <label for="enable_multi_customer_manage">Allow contacts to manage multiple Customer(s).</label>
                    <small v-if="$parent.validationErrors.enable_multi_customer_manage" class="text-danger mt-3">{{
                            $parent.validationErrors.enable_multi_customer_manage[0]
                        }}</small>
                </div>
                <small class="text-muted d-block"
                >If enabled then contacts will be able to swap their designated customer(s)</small
                >
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input
                        type="checkbox"
                        name="enable_guest_pricing"
                        id="enable_guest_pricing"
                        v-model="coreConfigurationData.enable_guest_pricing"
                        :class="{
                            'is-invalid': $parent.validationErrors.enable_guest_pricing,
                            'form-check-input': true,
                        }"
                    />
                    <label for="enable_guest_pricing">Allow Guest Customer Pricing.</label>
                    <small v-if="$parent.validationErrors.enable_guest_pricing" class="text-danger mt-3">{{
                            $parent.validationErrors.enable_guest_pricing[0]
                        }}</small>
                </div>
                <small class="text-muted d-block"
                >If enabled then users will be able to see product price and availability.</small
                >
            </div>

            <div id="saveActions" class="form-group">
                <input type="hidden" name="save_action" v-model="$parent.actionType"/>

                <button
                    @click="
                        $parent.actionType = 'save_and_edit';
                        $parent.saveCoreConfigInfo(coreConfigurationData);
                    "
                    type="button"
                    class="btn btn-success"
                >
                    <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                    <span data-value="save_and_edit"> Save</span>
                </button>

                <button @click="saveAndAction('cancel')" type="button" class="btn btn-default">
                    <span class="la la-ban"></span> Cancel
                </button>
            </div>
        </fieldset>
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
                            Set image for {{ msg }} <strong> </strong>
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
import Multiselect from 'vue-multiselect';
import Treeselect from '@riophae/vue-treeselect';
import allDisksMixin from '../../../../allDisks.mixin';
import '@riophae/vue-treeselect/dist/vue-treeselect.css';

export default {
    name: 'Basic',
    mixins: [allDisksMixin],
    components: {Multiselect, Treeselect},

    data() {
        return {
            imageType: '',
            msg: '',
            recaptchaImage: '',
            recaptchaTypes: [
                {
                    title: 'Math',
                    value: 'math',
                },
                {
                    title: 'Flat',
                    value: 'flat',
                },
                {
                    title: 'Small',
                    value: 'mini',
                },
                {
                    title: 'Inverse',
                    value: 'inverse',
                },
            ],
            themes: [
                {
                    label: 'Blue',
                    code: 'blue',
                },
                {
                    label: 'Orange',
                    code: 'orange',
                },
                {
                    label: 'Purple',
                    code: 'purple',
                },
            ],
            currentTheme: {},
            coreConfigurationData: {
                tab: 'basic',
                global_currency: this.$parent.coreConfigurationData.basic.global_currency,
                default_language: this.$parent.coreConfigurationData.basic.default_language,
                countries: this.$parent.coreConfigurationData.basic.countries,
                hierarchies: this.$parent.coreConfigurationData.basic.hierarchies,
                web_order_prefix: this.$parent.coreConfigurationData.basic.web_order_prefix,
                nxt_available_web_order_number: this.$parent.coreConfigurationData.basic.nxt_available_web_order_number,
                date_time_format: this.$parent.coreConfigurationData.basic.date_time_format,
                date_format: this.$parent.coreConfigurationData.basic.date_format,
                default_reorder_limit: this.$parent.coreConfigurationData.basic.default_reorder_limit,
                navbar_brand: this.$parent.coreConfigurationData.basic.navbar_brand,
                length_options: this.$parent.coreConfigurationData.basic.length_options,
                color_scheme: this.$parent.coreConfigurationData.basic.color_scheme,
                recaptcha_status: this.$parent.coreConfigurationData.basic.recaptcha_status,
                recaptcha_type: this.$parent.coreConfigurationData.basic.recaptcha_type,
                enable_quick_list: this.$parent.coreConfigurationData.basic.enable_quick_list,
                enable_multi_customer_manage: this.$parent.coreConfigurationData.basic.enable_multi_customer_manage,
                enable_guest_pricing: this.$parent.coreConfigurationData.basic.enable_guest_pricing,
                enable_erp_customer_create: this.$parent.coreConfigurationData.basic.enable_erp_customer_create,
                enable_erp_contact_create: this.$parent.coreConfigurationData.basic.enable_erp_contact_create,
                contact_import_default_password:
                this.$parent.coreConfigurationData.basic.contact_import_default_password,
            },
            showPassword: false,
            passwordType: 'password',
        };
    },
    mounted: function () {
        this.lodRecaptcha(this.coreConfigurationData.recaptcha_type);
        for (let theme of this.themes) {
            if (this.coreConfigurationData.color_scheme == theme.code) {
                this.currentTheme = theme;
                break;
            }
        }
    },
    methods: {
        prepareModal(type) {
            this.msg = type === 'navbar' ? 'Navbar' : 'Footer';
            this.imageType = type === 'navbar' ? 'navbar' : 'footer';

            setTimeout(() => {
                let modalShade = document.querySelector('.modal-backdrop.fade.show');
                modalShade ? modalShade.remove() : null;
                this.modalShade = modalShade?.outerHTML;
                this.modalBody = document.querySelector('#widget-attributes-modal .modal-body').innerHTML;
            }, 10);
        },
        removeSelectedFiles(index, length = 1) {
            let path = this.selectedFiles.splice(index, length);
            let noty = {
                type: 'success',
                text: `File (${path}) removed!`,
            };
            new Noty(noty).show();
        },

        browseMainImage(event) {
            event.preventDefault();
        },

        processImagesByType(indexOfAttributes = 0) {
            this.indexOfAttributes = indexOfAttributes;
            this.selectedFiles = this.coreConfigurationData.navbar_brand;
        },

        getFileExtension(file) {
            const regexp = /\.([0-9a-z]+)(?:[?#]|$)/i;
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

        deleteImage(type) {
            this.$swal({
                title: 'Remove this Image?',
                //icon              : 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff6b81',
                cancelButtonColor: '#399E7F',
                confirmButtonText: 'Remove',
            }).then((result) => {
                if (result.isConfirmed) {
                    if (type === 'navbar') {
                        this.coreConfigurationData.navbar_brand = '';
                    } else {
                        this.coreConfigurationData.footer_image = '';
                    }
                }
            });
        },

        lodRecaptcha(captchaType = null) {
            axios
                .get('/admin/reload-captcha?recaptcha_type=' + captchaType, {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                })
                .then((response) => {
                    this.recaptchaImage = response.data.captcha;
                })
                .catch((err) => {
                    new Noty({
                        type: 'error',
                        text: err.response.data.message,
                    }).show();
                });
        },
        togglePasswordShow() {
            this.showPassword = !this.showPassword;
            this.passwordType = this.showPassword ? 'text' : 'password';
        },
    },

    watch: {
        currentTheme: function (option) {
            this.coreConfigurationData.color_scheme = option.code;
        },

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

                    if (this.imageType === 'navbar') {
                        self.coreConfigurationData.navbar_brand = self.$parent.selectedFiles;
                    } else if (this.imageType === 'footer') {
                        self.coreConfigurationData.footer_image = self.$parent.selectedFiles;
                    }

                    self.getFileAddedMessage();
                }
            },
        },

        'coreConfigurationData.recaptcha_type': function (newVal, oldVal) {
            this.lodRecaptcha(newVal);
        },
    },
};
</script>

<style>
.vue-treeselect .vue-treeselect__control,
.multiselect .multiselect__tags {
    height: 38px !important;
    border-radius: 4px !important;
    border: 1px solid rgba(0, 40, 100, 0.12) !important;
}

.vue-treeselect.is-invalid {
    border: 1px solid red;
    border-radius: 5px;
}

.multiselect .multiselect__tags {
    padding-top: 8px !important;
}

.required-custom {
    color: #ff0000;
}

.cke_contents {
    min-height: 300px !important;
}

.orange {
    width: 1rem;
    height: 1rem;
    border-radius: 50%;
    margin-right: 0.5rem;
    background-color: orange;
    color: white;
}

.blue {
    width: 1rem;
    height: 1rem;
    border-radius: 50%;
    margin-right: 0.5rem;
    background-color: blue;
    color: white;
}

.purple {
    width: 1rem;
    height: 1rem;
    border-radius: 50%;
    margin-right: 0.5rem;
    background-color: purple;
    color: black;
}

/* Style the select box */
#colors {
    padding: 5px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 150px;
}
</style>
