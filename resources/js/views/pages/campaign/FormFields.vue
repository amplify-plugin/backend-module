<template>
    <div class="tab-container mb-2">
        <div class="nav-tabs-custom" id="form_tabs">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="nav-item">
                    <a href="#tab_basic"
                       aria-controls="tab_basic" role="tab" tab_name="basic" data-toggle="tab"
                       class="nav-link active" aria-selected="true">
                        Basic
                    </a>
                </li>
                <li role="presentation" class="nav-item">
                    <a href="#tab_product" aria-controls="tab_product" role="tab" tab_name="product" data-toggle="tab"
                       class="nav-link" aria-selected="false">
                        Products
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade show active"
                     id="tab_basic" aria-labelledby="tab_basic">
                    <div class="row">
                        <div class="form-group  col-sm-12 required">
                            <label>
                                Campaign Name
                            </label>
                            <input type="text" name="name" v-model="$parent.campaign.name"
                                   placeholder="Enter Campaign Name"
                                   class="form-control" :class="{ 'is-invalid': $parent.validationErrors?.name }"
                                   @keyup="slugify"/>
                            <small class="text-danger mt-3" v-if="$parent.validationErrors?.name">
                                {{ $parent.validationErrors?.name[0] }}
                            </small>
                        </div>

                        <div class="form-group  col-sm-12 required">
                            <label>
                                Campaign Slug
                            </label>
                            <input type="text" name="slug" v-model="$parent.campaign.slug"
                                   placeholder="Enter Campaign Slug"
                                   class="form-control" :class="{ 'is-invalid': $parent.validationErrors?.slug }"/>
                            <small class="text-danger mt-3" v-if="$parent.validationErrors?.slug">
                                {{ $parent.validationErrors?.slug[0] }}
                            </small>
                        </div>

                        <div class="form-group  col-sm-12 required">
                            <label>
                                Campaign Code
                            </label>
                            <input type="text" name="code" v-model="$parent.campaign.code"
                                   placeholder="Enter Campaign Code"
                                   class="form-control" :class="{ 'is-invalid': $parent.validationErrors?.code }"/>
                            <small class="text-danger mt-3" v-if="$parent.validationErrors?.code">
                                {{ $parent.validationErrors?.code[0] }}
                            </small>
                        </div>

                        <div class="form-group  col-sm-12 required">
                            <label>
                                Campaign Page
                            </label>
                            <select name="page_id" v-model="$parent.campaign.page_id" class="form-control"
                                    :class="{ 'is-invalid': $parent.validationErrors?.page_id }">
                                <option v-for="page in $parent.pages" :key="page.id" :value="page.id">{{
                                        page.name
                                    }}
                                </option>
                            </select>
                            <small class="text-danger mt-3" v-if="$parent.validationErrors?.page_id">
                                {{ $parent.validationErrors?.page_id[0] }}
                            </small>
                        </div>

                        <div class="form-group  col-sm-12 required">
                            <label>
                                Campaign Banner
                            </label>
                            <select name="banner_zone_id" v-model="$parent.campaign.banner_zone_id" class="form-control"
                                    :class="{ 'is-invalid': $parent.validationErrors?.banner_zone_id }">
                                <option v-for="banner_zone in $parent.banner_zones" :key="banner_zone.id"
                                        :value="banner_zone.id">{{ banner_zone.name }}
                                </option>
                            </select>
                            <small class="text-danger mt-3" v-if="$parent.validationErrors?.banner_zone_id">
                                {{ $parent.validationErrors?.banner_zone_id[0] }}
                            </small>
                        </div>

                        <div class="form-group col-sm-12">
                            <label>
                                Description
                            </label>
                            <textarea name="desc" v-model="$parent.campaign.description" placeholder="Enter name"
                                      class="form-control"
                                      :class="{ 'is-invalid': $parent.validationErrors?.description }"
                                      rows="3"></textarea>
                            <small class="text-danger mt-3" v-if="$parent.validationErrors?.description">
                                {{ $parent.validationErrors?.description[0] }}
                            </small>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="form-group col-sm-6 required">
                                    <label>
                                        Start Date
                                    </label>
                                    <input type="datetime-local" name="start_date" v-model="$parent.campaign.start_date"
                                           class="form-control"
                                           :class="{ 'is-invalid': $parent.validationErrors?.start_date }"/>
                                    <small class="text-danger mt-3" v-if="$parent.validationErrors?.start_date">
                                        {{ $parent.validationErrors?.start_date[0] }}
                                    </small>
                                </div>

                                <div class="form-group col-sm-6 required">
                                    <label>
                                        End Date
                                    </label>
                                    <input type="datetime-local" name="end_date" v-model="$parent.campaign.end_date"
                                           class="form-control"
                                           :class="{ 'is-invalid': $parent.validationErrors?.end_date }"/>
                                    <small class="text-danger mt-3" v-if="$parent.validationErrors?.end_date">
                                        {{ $parent.validationErrors?.end_date[0] }}
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check required mb-3">
                                <input class="form-check-input" v-model="$parent.campaign.status" type="checkbox"
                                       id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Enabled?
                                </label>
                                <small class="text-danger mt-3" v-if="$parent.validationErrors?.status">
                                    {{ $parent.validationErrors?.status[0] }}
                                </small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check required mb-3">
                                <input class="form-check-input" v-model="$parent.campaign.login_required" type="checkbox"
                                       id="defaultCheck2">
                                <label class="form-check-label" for="defaultCheck2">
                                    Ask Contact to login for see detail.
                                </label>
                            </div>
                            <small class="text-danger mt-3" v-if="$parent.validationErrors?.login_required">
                                {{ $parent.validationErrors?.login_required[0] }}
                            </small>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab_product">
                    <ProductModule ref="productModule"/>
                </div>
            </div>
        </div>
        <div class="modal fade" id="file-manager-modal" tabIndex="0" role="dialog"
             aria-labelledby="file-manager-modal-dialog-label" data-backdrop="static"
             data-keyboard="false"
             aria-modal="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="attribute-inline-create-dialog-label">
                            Set banner image <strong> </strong>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal"
                                @click="modalShade = '';"
                                aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body bg-light">
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
    </div>
</template>

<script>
import ProductModule from './ProductModule.vue';
import allDisksMixin from '../../../allDisks.mixin';

export default {
    name: "FormFields",
    mixins: [allDisksMixin],
    components: {ProductModule},
    data() {
        return {
            selectedFiles: "",
        }
    },
    methods: {
        slugify() {
            if (this.$parent.campaign.name) {
                this.$parent.campaign.slug = this.$parent.campaign.name.replace(/[^A-Z0-9]/ig, "-").toLowerCase();
            }
        },
        prepareModal(type) {
            setTimeout(() => {
                let modalShade = document.querySelector('.modal-backdrop.fade.show');
                modalShade ? modalShade.remove() : null;
                this.modalShade = modalShade.outerHTML;
                this.activeModelFor = type;
                this.modalBody = document.querySelector('#file-manager-modal .modal-body').innerHTML;
            }, 10);
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
                    this.$parent.campaign.banner = ''
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

                    let filePath = files.find(file => {
                        return ['jpg', 'jpeg', 'png'].includes(self.getFileExtension(file.toLowerCase()))
                    })

                    if (filePath) {
                        self.$parent.campaign.banner = self.all_disks[self.$store.state.fm.left.selectedDisk].url ? self.all_disks[self.$store.state.fm.left.selectedDisk].url + "/" + filePath : "/" + filePath;
                        self.getFileAddedMessage();
                    }
                }
            }
        }
    }
};
</script>

<style>
.product-attribute {
    height: 50vh;
    overflow-y: auto;
}

#searchModalRight {
    height: 54vh;
    overflow-y: auto;
}
</style>
