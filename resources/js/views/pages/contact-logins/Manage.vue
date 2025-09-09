<template>
    <form method="post" @submit.prevent>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>
                                Name
                            </label>
                            <p class="border rounded py-2 px-3">{{contactModel.name ?? '' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>
                                Email
                            </label>
                            <p class="border rounded py-2 px-3">{{contactModel.email ?? '' }}</p>
                        </div>
                    </div>
                </div>
                <label class="font-weight-bold d-block">Assigned Customers</label>
                <div v-for="(loginContact, contactKey) in customerLoginsList" :key="contactKey"
                     class="border rounded pl-4 pr-3 py-2 my-2 position-relative"
                     :style="{backgroundColor: (contactModel.customer_id != loginContact.customer?.id) ? '#f5f5f5' : 'rgb(111 178 230 / 31%)'}">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Customer<span class="text-danger">*</span></label>

                                <multiselect
                                    v-model="loginContact.customer"
                                    :options="customerList"
                                    :multiple="false"
                                    :searchable="true"
                                    :internalSearch="false"
                                    :close-on-select="true"
                                    :disabled="contactModel.customer_id == loginContact.customer?.id"
                                    trackBy="id"
                                    label="customer_name"
                                    placeholder="Type Customer name"
                                    @search-change="fetchAssignableCustomers"
                                    @input="changeCustomer(contactKey)"
                                />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Warehouse<span class="text-danger">*</span></label>
                                <multiselect
                                    v-model="loginContact.warehouse"
                                    :options="warehouseList"
                                    :multiple="false"
                                    :close-on-select="true"
                                    :clear-on-select="false"
                                    :disabled="true"
                                    placeholder="Selct an default warehouse"
                                    track-by="InternalId"
                                    label="WarehouseName"
                                />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Default ShipTo<span class="text-danger">*</span></label>
                                <input
                                    class="form-control"
                                    :value="loginContact.customer_address?.address_code"
                                    :disabled="true"
                                />
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Current Role(s)</label>
                                <multiselect
                                    v-model="loginContact.roles"
                                    :options="loginContact.role_list"
                                    :multiple="true"
                                    :close-on-select="true"
                                    :clear-on-select="false"
                                    placeholder="Selct an default ship to address"
                                    track-by="id"
                                    label="name"
                                />
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <div class="d-flex justify-content-between">
                                    <label class="font-weight-bold">Permissions</label>

                                    <a href="javascript:void(0);"
                                       class="my-2 font-weight-bold collapsed text-decoration-none"
                                       type="button" data-toggle="collapse" data-target=".collapse"
                                       aria-expanded="false">
                                            <span data-toggle="tooltip" data-placement="top" title="Expand/Collapse">
                                                <i class="pe-7s-angle-down"
                                                   style="font-weight: 600; font-size: 1.5rem"></i>
                                                <i class="pe-7s-angle-up"
                                                   style="font-weight: 600; font-size: 1.5rem"></i>
                                            </span>
                                    </a>
                                </div>

                                <div class="row mr-1" id="checklist" style="max-height: 60vh; overflow-y: scroll">
                                    <div class="col-12">
                                        <div class="card mb-2" v-for="(permissionItems, key) in customerPermissionList"
                                             :key="key">
                                            <div class="card-header py-2 px-3 bg-white">
                                                <div class="d-flex justify-content-between">
                                                    <div class="form-check">
                                                        <label class="form-check-label font-weight-bold mb-0">
                                                            <input type="checkbox" class="form-check-input pmsn-title"
                                                                   :ref="key+'-'+contactKey"
                                                                   @change="changedByType(key, contactKey)"/>
                                                            {{ humanizeLabel(key) }}
                                                        </label>
                                                    </div>

                                                    <a
                                                        href="javascript:void(0);"
                                                        class="text-dark collapsed text-decoration-none"
                                                        data-toggle="collapse" :data-target="`#collapse-${key}`"
                                                        aria-expanded="false" :aria-controls="`collapse-${key}`"
                                                    ><i class="pe-7s-angle-down"
                                                        style="font-weight: 600; font-size: 1.2rem"></i></a>
                                                </div>

                                                <div class="collapse" :id="`collapse-${key}`">
                                                    <div class="card-body row px-0 py-2">

                                                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 my-1"
                                                             v-for="(permission, index) in permissionItems"
                                                             :key="index">
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox"
                                                                           class="pmsn form-check-input address"
                                                                           v-model="loginContact.permissions"
                                                                           :value="index" :class="key"/>
                                                                    {{ permission.label }}
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-default rounded-circle p-0 m-0 border font-weight-bold"
                            v-show="contactModel.customer_id != loginContact.customer?.id"
                            style=" position: absolute;
                                width: 40px;
                                height: 40px;
                                left: -20px;
                                top: 75px;
                                z-index: 10;"
                            @click="removeCustomer(contactKey)">x
                    </button>
                </div>
                <button class="btn-outline-primary btn btn-sm text-capitalize" @click="addNewCustomer">
                    + Add Customer
                </button>
            </div>
        </div>

        <div id="saveActions" class="form-group">
            <input type="hidden" name="save_action" value="save_and_back" v-model="actionType">
            <div class="btn-group" role="group">
                <button type="button" :class="{'btn btn-success': true, 'rounded': true}"
                        @click="actionType=saveAction.active.value; saveData(saveAction.active.value)">
                    <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
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
                        <button class="dropdown-item" type="button" v-for="(option, k, index) in saveAction.options"
                                :key="'actionType-' + index"
                                @click="saveData(k)">
                            {{ option }}
                        </button>
                    </div>
                </div>
            </div>
            <a :href="back_url" class="btn btn-default">
                <span class="la la-ban"></span> &nbsp;Cancel </a>
        </div>
    </form>
</template>

<script>
import Multiselect from 'vue-multiselect';
import axios from 'axios';

export default {
    name: "ContactLoginManage",
    components: {Multiselect},
    props: ['contact', 'warehouses', 'permissions', 'save_action', 'axios_url', 'back_url'],
    data() {
        return {
            validationErrors: {},
            contactModel: JSON.parse(this.contact),
            warehouseList: JSON.parse(this.warehouses),
            customerPermissionList: JSON.parse(this.permissions),
            customerRoleList: [],
            customerLoginsList: [],
            customerList: [],
            saveAction: JSON.parse(this.save_action),
            actionType: 'save_and_back',
        }
    },
    created() {

        this.initEditLayout();
    },
    methods: {
        initEditLayout() {
            this.contactModel.contact_logins.map(item => {
                this.customerLoginsList.push({
                    contact_id: this.contactModel.id,
                    customer: item.customer,
                    warehouse: this.warehouseList.find(warehouse => warehouse.InternalId == item.warehouse_id),
                    customer_address: item.customer_address,
                    roles: this.getInitialRolesById(item.roles, item.role_list),
                    permissions: item.permissions.map(permission => String(permission)),
                    role_list: item.role_list,
                });
            })

            if (this.customerLoginsList.length < 1) {
                this.addNewCustomer();
            }
        },
        getInitialRolesById(cur_roles, role_list) {
            let roles = [];

            cur_roles.map(role => {
                let role_item = role_list.find(item => item.id === role);

                if (role_item)
                    roles.push(role_item);
            })

            return roles;
        },
        addNewCustomer() {
            this.customerLoginsList.push({
                contact_id: this.contactModel.id,
                customer: null,
                warehouse: null,
                customer_address: {},
                roles: [],
                permissions: [],
                role_list: [],
            });
        },
        removeCustomer(index) {
            this.customerLoginsList.splice(index, 1);
        },
        async changeCustomer(index) {
            this.customerLoginsList[index].warehouse = null;
            this.customerLoginsList[index].customer_address = {};

            await this.verifyAssignableContact(index);
            this.fetchRoles(index);
        },
        fetchAssignableCustomers(query) {
            let cus_exld = [];
            this.customerLoginsList.forEach(item => {
                if (item.customer)
                    cus_exld.push(item.customer?.id);
            });

            axios.post(`/contact-logins/fetch-assignable-customer?q=${query}`, {
                cus_exld: cus_exld
            })
                .then(response => {
                    this.customerList = response.data.data;
                })
                .catch((err) => {
                    this.clearCustomersList();
                });
        },
        async verifyAssignableContact(index) {
            let loginContact = this.customerLoginsList[index];

            if (loginContact.customer) {
                await axios.post(`/contact-logins/verify-assignable-contact`, {
                    contact_email: this.contactModel.email,
                    customer_id: loginContact.customer.id,
                })
                    .then(response => {
                        if (!response.data.status) {
                            loginContact.customer = null;
                            ShowNotification('error', 'Contact Logins', response.data.message);
                        } else {
                            this.setDefaultValues(response.data, index);
                        }
                    })
                    .catch((err) => {
                        this.clearCustomersList();
                    });
            }
        },
        fetchRoles(index) {
            let loginContact = this.customerLoginsList[index];

            if (loginContact.customer) {
                loginContact.role_list = [];

                axios.post(`/contact-logins/get-roles`, {
                    customer_id: loginContact.customer.id
                })
                    .then(response => {
                        loginContact.role_list = response.data;
                    })
            }
        },
        setDefaultValues(data, index) {
            let loginContact = this.customerLoginsList[index];

            loginContact.warehouse = this.warehouseList.find(warehouse => warehouse.InternalId == data.warehouse_id);
            loginContact.customer_address = data.customer_address;
        },
        clearCustomersList() {
            this.customerList = []
        },
        changedByType(key, contactKey) {
            let is_checked = this.$refs[key + "-" + contactKey][0].checked;
            let permissions = this.customerLoginsList[contactKey].permissions;

            for (const id in this.customerPermissionList[key]) {
                let index_of_item = permissions.indexOf(id);

                if (is_checked) {
                    if (index_of_item === -1)
                        permissions.push(id);
                } else {
                    if (index_of_item !== -1)
                        permissions.splice(index_of_item, 1);
                }

            }
        },
        saveData(actionType) {
            let customer_order_rule = {
                _save_action: actionType,
                login_customers: this.customerLoginsList.map(item => {
                    return {
                        contact_id: item.contact_id,
                        customer_id: item.customer?.id,
                        warehouse_id: item.warehouse?.InternalId,
                        customer_address_id: item.customer_address?.id,
                        roles: item.roles.map(role => role.id),
                        permissions: item.permissions,
                    };
                })
            };

            axios.post(`${this.axios_url}`, customer_order_rule)
                .then(response => {
                    ShowNotification('success', 'Contact Login', response.data.message);
                    window.location.href = this.back_url;
                })
                .catch((err) => {
                    this.validationErrors = err.response.data.errors;
                    ShowNotification('error', 'Contact Login', err.response.data.message);
                });
        },
        humanizeLabel(label) {
            label = label.toString().replace(/([\-_])/g, ' ');
            return (label[0].toUpperCase()) + label.substring(1, label.length);
        }
    },

    watch: {
        customerLoginsList: {
            handler(loginList) {
                const per_list = this.customerPermissionList;

                loginList.map((login_item, key) => {
                    for (const per_name in per_list) {
                        let is_active = true;

                        for (const code in per_list[per_name]) {
                            if (login_item.permissions.indexOf(code) === -1) {
                                is_active = false
                                break;
                            }
                        }

                        if (this.$refs[per_name + "-" + key]) {
                            this.$refs[per_name + "-" + key][0].checked = is_active;
                        }
                    }
                });
            },
            deep: true
        }
    },
};
</script>

<style scoped></style>
