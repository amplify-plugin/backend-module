<template>
    <form method="post" @submit.prevent>
        <div class="card">
            <div class="card-body">

                <div class="form-group">
                    <label for="quicklist_contact_id">
                        Contact
                        <span class="text-danger">*</span>
                    </label>
                    <select class="form-control custom-select"
                            :class="{'is-invalid' : validationErrors.hasOwnProperty('contact_id')}"
                            id="quicklist_contact_id"
                            v-model="quickListModel.contact_id">
                        <option v-for="(contact, index) in contactList"
                                :key="index"
                                :selected="contact.id == quickListModel.contact_id"
                                :value="contact.id">
                            {{ contact.name }}
                        </option>
                    </select>
                    <p class="text-danger"
                       v-if="validationErrors.hasOwnProperty('contact_id')">
                        {{ validationErrors.contact_id[0] }}
                    </p>
                </div>

                <div class="form-group">
                    <label for="quicklist_name">
                        Name
                        <span class="text-danger">*</span>
                    </label>
                    <input class="form-control"
                           :class="{'is-invalid' : validationErrors.hasOwnProperty('name')}"
                           type="text" id="quicklist_name" v-model="quickListModel.name"/>
                    <p class="text-danger"
                       v-if="validationErrors.hasOwnProperty('name')">
                        {{ validationErrors.name[0] }}
                    </p>
                </div>

                <div class="form-group">
                    <label for="quicklist_desc">Description</label>
                    <textarea class="form-control"
                              :class="{'is-invalid' : validationErrors.hasOwnProperty('description')}"
                              id="quicklist_desc" type="number"
                              v-model="quickListModel.description"></textarea>
                    <p class="text-danger"
                       v-if="validationErrors.hasOwnProperty('description')">
                        {{ validationErrors.description[0] }}
                    </p>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold d-block">Items</label>
                    <section v-for="(item, key) in quickListModel.order_list_items" :key="key"
                             class="border rounded bg-secondary pl-4 pr-3 py-2 my-2">
                        <div class="row text-center">
                            <div class="col-md-8 px-2">
                                <div class="form-group" style="margin-bottom: 0 !important;">
                                    <label class="font-weight-bold">Product<span class="text-danger">*</span></label>
                                    <multiselect
                                        v-model="item.product_id"
                                        :options="productList"
                                        :multiple="false"
                                        :searchable="true"
                                        :internalSearch="false"
                                        :close-on-select="true"
                                        trackBy="id"
                                        label="product_name"
                                        :options-limit="300"
                                        placeholder="Type product name, code, id"
                                        @search-change="fetchAvailableProducts"
                                        @input="clearProductsList">
                                        <template slot="singleLabel"
                                                  slot-scope="props">
                                            <span class="option__desc">
                                                <span class="option__title">{{
                                                        props.option.product_code
                                                    }} - {{ props.option.local_product_name ?? '' }}</span>
                                            </span>
                                        </template>
                                        <template slot="option" slot-scope="props">
                                            <div class="d-flex gap-2">
                                                <img class="option__image img-thumbnail"
                                                     style="height: 50px; width: auto; object-fit: contain"
                                                     :src="props.option.product_image"
                                                     :alt="props.option.local_product_name ?? 'N/A'">
                                                <div class="option__desc">
                                                <span class="option__title text-truncate">
                                                    <b>{{
                                                            props.option.product_code
                                                        }}</b> - {{ props.option.local_product_name ?? 'N/A' }}
                                            </span>
                                                    <span class="d-block option__small pt-2">
                                                   {{ props.option.local_short_description ?? 'N/A' }}
                                                </span>
                                                </div>
                                            </div>
                                        </template>
                                    </multiselect>
                                </div>
                            </div>

                            <div class="col-md-2 px-2 col-6">
                                <div class="form-group" style="margin-bottom: 0 !important;">
                                    <label class="font-weight-bold"
                                           :class="{'is-invalid' : validationErrors.hasOwnProperty(`order_list_items.${key}.qty`)}"
                                           :for="'quantity'+key">Quantity<span
                                        class="text-danger">*</span></label>
                                    <input class="form-control" :id="'quantity'+key" v-model="item.qty"/>
                                </div>
                            </div>

                            <div class="col-md-2 col-6">
                                <div class="form-group" style="margin-bottom: 0 !important;">
                                    <label class="font-weight-bold d-block">Action</label>
                                    <button @click="removeItemFromItem(key)"
                                            class="btn mt-md-0 mt-0 btn-sm px-2 btn-outline-danger"
                                    ><i class="icon-cross"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="text-danger mt-1"
                                   v-if="validationErrors.hasOwnProperty(`order_list_items.${key}.product_id`)">
                                    {{ validationErrors[`order_list_items.${key}.product_id`][0] ?? '' }}
                                </p>
                                <p class="text-danger mt-1"
                                   v-if="validationErrors.hasOwnProperty(`order_list_items.${key}.qty`)">
                                    {{ validationErrors[`order_list_items.${key}.qty`][0] ?? '' }}
                                </p>
                            </div>
                        </div>
                    </section>
                    <button class="btn-outline-primary btn btn-sm text-capitalize"
                            @click="addNewProduct">
                        + Add Item
                    </button>
                </div>
            </div>
            <div id="saveActions" class="card-footer bg-transparent">
                <input type="hidden" name="save_action" value="save_and_back" v-model="actionType">
                <div class="btn-group" role="group">
                    <button type="button" :class="{'btn btn-success': true, 'rounded': true}"
                            @click="actionType=saveAction.active.value; saveData(saveAction.active.value)">
                        <i class="pe-7s-diskette" role="presentation" aria-hidden="true"></i> &nbsp;
                        <span>{{ saveAction.active?.label ?? '' }}</span>
                    </button>
                    <div :class="{'btn-group' : true, 'mt-0': true,  'd-none': true}" role="group">
                        <button id="bpSaveButtonsGroup" type="button"
                                class="btn btn-success dropdown-toggle"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span :class="{'caret': true, 'd-none': true}"></span>
                            <span :class="{'sr-only': true, 'd-none': true}">▼</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="bpSaveButtonsGroup">
                            <template v-for="(option, k, index) in saveAction.options">
                                <button class="dropdown-item" type="button" :key="'actionType-' + index"
                                        @click="saveData(k)">
                                    {{ option }}
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
                <a :href="backUrl" class="btn btn-default">
                    <i class="icon-cross"></i>Cancel</a>
            </div>
        </div>
    </form>
</template>

<script>
import Multiselect from 'vue-multiselect';
import axios from 'axios';

export default {
    name: "CustomerQuickListUpdate",
    components: {Multiselect},
    props: ['quicklist', 'save_action', 'contact_list', 'axios_url', 'back_url', 'product_list', 'method'],
    data() {
        return {
            validationErrors: {},
            contactList: JSON.parse(this.contact_list),
            productList: JSON.parse(this.product_list),
            quickListModel: JSON.parse(this.quicklist),
            axiosUrl: this.axios_url,
            backUrl: this.back_url,
            saveAction: JSON.parse(this.save_action),
            actionType: 'save_and_back',
        }
    },
    created() {

        if (typeof this.quickListModel.order_list_items == 'undefined' || this.quickListModel.order_list_items.length < 0) {

            this.quickListModel.order_list_items = [];

            this.addNewProduct();
        }

        if (this.productList.length === 0) {

            this.productList = [{
                id: null,
                product_code: '',
                local_product_name: '',
                local_short_description: '',
                product_image: ''
            }];
        }
    },
    mounted() {
        for (const orderItem in (this.quickListModel.order_list_items ?? [])) {
            this.quickListModel.order_list_items[orderItem].product_id = this.searchProductPrefill(this.quickListModel.order_list_items[orderItem].product_id);
        }
    },
    methods: {

        searchProductPrefill(product_id) {
            let product = null;
            for (let productList of this.productList) {
                if (productList.id == product_id) {
                    product = productList;
                    break;
                }
            }

            if (!product) {
                product = {
                    id: product_id,
                    product_code: 'N/A',
                    local_product_name: 'Product may be removed',
                    local_short_description: 'Product description not available.',
                    product_image: this.$root.config.fallback_image ?? './img/No-Image-Placeholder-min.png'
                };
            }

            return product;
        },

        addNewProduct() {
            this.quickListModel.order_list_items.push({
                product_id: null,
                qty: 0
            });
        },

        fetchAvailableProducts(query) {
            axios.get(`/fetch-products?q=${query}`)
                .then(response => {
                    this.productList = response.data;
                })
                .catch((err) => {
                    this.clearProductsList();
                });
        },

        clearProductsList() {
            this.productList = []
        },

        removeItemFromItem(index) {
            this.quickListModel.order_list_items.splice(index, 1);
        },

        saveData(actionType) {
            this.actionType = actionType;
            this.quickListModel._save_action = actionType;
            let payload = this.quickListModel;

            for (const orderListItemsKey in payload.order_list_items) {
                payload.order_list_items[orderListItemsKey].product_id = payload.order_list_items[orderListItemsKey].product_id.id;
                delete payload.order_list_items[orderListItemsKey].id
                delete payload.order_list_items[orderListItemsKey].list_id
                delete payload.order_list_items[orderListItemsKey].created_at
                delete payload.order_list_items[orderListItemsKey].updated_at
            }

            axios[this.method](`${this.axios_url}`, this.quickListModel, {
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                ShowNotification('success', 'Quick List', response.data.message);
                setTimeout(function () {
                    window.location.href = response.data.redirect_url;
                }, 2000);
            })
                .catch((err) => {
                    this.validationErrors = err.response.data.errors;
                    ShowNotification('error', 'Quick List', err.response.data.message);
                });
        }
    },
};
</script>
