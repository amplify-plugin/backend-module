<template>
    <div role="tabpanel" class="tab-pane active"
         id="tab_basic-info">
        <div class="row">
            <!-- load the view from type and view_namespace attribute if set -->

            <!-- hidden input -->
            <div class="hidden">
                <input type="hidden" name="basic-info" value="" class="form-control">
            </div>

            <!-- text input -->
            <div class="form-group col-sm-12"
                 :class="{'text-danger': $parent.validationErrors.group_code}">
                <label>
                    Group Code
                    <span class="text-danger font-weight-bold">*</span>
                </label>
                <input @input="$parent.removeError('group_code')" type="text" name="group_code"
                       v-model="$parent.customer_group.group_code"
                       class="form-control" :class="{'is-invalid': $parent.validationErrors.group_code}">
                <small v-if="$parent.validationErrors.group_code"
                       class="text-danger mt-3">{{ $parent.validationErrors.group_code[0] }}</small>
            </div>

            <!-- text input -->
            <div class="form-group col-sm-12"
                 :class="{'text-danger': $parent.validationErrors.group_name}">
                <label>
                    Group Name
                    <span class="text-danger font-weight-bold">*</span>
                </label>
                <input @input="$parent.removeError('group_name')" type="text" name="group_name"
                       v-model="$parent.customer_group.group_name"
                       class="form-control" :class="{'is-invalid': $parent.validationErrors.group_name}">
                <small v-if="$parent.validationErrors.group_name"
                       class="text-danger mt-3">{{ $parent.validationErrors.group_name[0] }}</small>
            </div>

            <div class="form-group col-sm-12"
                 :class="{'text-danger': $parent.validationErrors.group_pricing_type}">
                <label>
                    Group Pricing Type
                    <span class="text-danger font-weight-bold">*</span>
                </label>

                <div class="form-check" v-for="(name, value) in $parent.group_types">
                    <input class="form-check-input" type="radio" name="group_pricing_type" :value="value"
                           :id="`group_types-${value}`"
                           v-model="$parent.customer_group.group_pricing_type">
                    <label class="form-check-label cursor-pointer font-weight-normal" :for="`group_types-${value}`">
                        {{ name }}
                    </label>
                </div>

                <small v-if="$parent.validationErrors.group_pricing_type"
                       class="text-danger mt-3">{{ $parent.validationErrors.group_pricing_type[0] }}</small>
            </div>

            <div class="form-group col-sm-12"
                 :class="{'text-danger': $parent.validationErrors.users}">
                <label>
                    Assigned Users
                </label>

                <multiselect
                    v-model="$parent.customer_group.users"
                    :options="$parent.availableUsers"
                    :multiple="true"
                    :close-on-select="false"
                    :clear-on-select="false"
                    :hide-selected="true"
                    placeholder="Select users"
                    track-by="id"
                    label="name"
                >
                    <template #option="{ option }">
                        <div class="d-flex flex-column">
                            <span>{{ option.name }}</span>
                            <small class="text-muted">{{ option.email }}</small>
                        </div>
                    </template>
                    <template #singleLabel="{ option }">
                        <span>{{ option.name }}</span>
                    </template>
                </multiselect>

                <small v-if="$parent.validationErrors.users"
                       class="text-danger mt-3">{{ $parent.validationErrors.users[0] }}</small>
            </div>

            <div v-if="$parent.customer_group.group_pricing_type === 'rules-based-pricing'" class="col-sm-12">
                <label class="form-check-label">
                    Pricing Rules
                </label>
                <div class="card mb-3 mt-3">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-lg-2">
                                <div class="checkbox my-0 my-lg-2">
                                    <input id="flat_discount" type="checkbox"
                                           v-model="$parent.rules_based_pricing.flat_discount">
                                    <label for="flat_discount" class="form-check-label font-weight-normal">
                                        Flat Discount
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-10">
                                <div :class="{'flat-disabled' : !$parent.rules_based_pricing.flat_discount}"
                                     class="p-3">
                                    <div
                                        v-for="(flat_discount,index) in $parent.rules_based_pricing.flat_discount_pricing_rules"
                                        :key="index">
                                        <div class="row align-items-center mb-2">
                                            <div class="col-md-3">
                                                <div class="d-flex">
                                                    <p class="mr-2 my-auto text-nowrap"
                                                       :class="{'text-danger': flatDiscountError(index)}">Discount
                                                        % </p>
                                                    <div>
                                                        <div class="input-group"
                                                             :class="{'border border-danger': flatDiscountError(index)}">
                                                            <input v-model="flat_discount.discount"
                                                                   @input="validateDiscount($event,index,'flat_discount')"
                                                                   @click="$parent.removeError(flatDiscountError(index,true))"
                                                                   type="number" class="form-control border-light"
                                                                   placeholder="Enter discount"
                                                                   aria-label="Recipient's username"
                                                                   aria-describedby="basic-addon2">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"
                                                                      id="basic-addon2">%</span>
                                                            </div>
                                                        </div>
                                                        <small v-if="flatDiscountError(index)"
                                                               class="text-danger mt-3"> Discount field is
                                                            required.</small>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-lg-9 d-flex">
                                                <p class="mr-2 my-auto text-nowrap"
                                                   :class="{'text-danger': flatDiscountCategoriesError(index)}">
                                                    Categories : </p>
                                                <div class="w-100">
                                                    <multiselect
                                                        v-model="flat_discount.categories"
                                                        :options="$parent.flat_categories"
                                                        :class="{'is-invalid': flatDiscountCategoriesError(index)}"
                                                        :multiple="true"
                                                        :close-on-select="false"
                                                        :clear-on-select="false"
                                                        @select="reduceCategory($event,'flat_discount');$parent.removeError(flatDiscountCategoriesError(index,true))"
                                                        @remove="reAddCategory($event,'flat_discount')"
                                                        :hide-selected="true"
                                                        placeholder="Select some categories"
                                                        track-by="id"
                                                        label="label"
                                                    >
                                                    </multiselect>
                                                    <small v-if="flatDiscountCategoriesError(index)"
                                                           class="text-danger mt-3"> Categories field is
                                                        required.</small>
                                                </div>

                                                <button
                                                    :style="`visibility: ${$parent.rules_based_pricing.flat_discount_pricing_rules.length > 1 ? 'unset': 'hidden'}`"
                                                    class="btn btn-sm btn-link text-danger text-nowrap ml-2 border-danger"
                                                    type="button"
                                                    @click="$parent.deleteFlatRow(index)">
                                                    &times; Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-link border-primary"
                                            type="button"
                                            @click="$parent.addRow()">
                                        + Add Discount Level
                                    </button>
                                </div>

                            </div>
                        </div>
                        <hr>
                        <div class="mb-3 row">
                            <div class="col-lg-2">
                                <div class="checkbox my-0 my-lg-2">
                                    <input id="volume_discount" type="checkbox"
                                           v-model="$parent.rules_based_pricing.volume_discount">
                                    <label for="volume_discount" class="form-check-label font-weight-normal">
                                        Volume Discount
                                    </label>
                                </div>

                                <div class="checkbox my-0 my-lg-2 ml-3"
                                     v-if="$parent.rules_based_pricing.volume_discount">
                                    <input id="volume_discount_additive" type="checkbox"
                                           v-model="$parent.rules_based_pricing.volume_discount_additive">
                                    <label for="volume_discount_additive" class="form-check-label font-weight-normal">
                                        Discount Additive ?
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-10">
                                <div
                                    v-for="(volume_discount,volume_index) in $parent.rules_based_pricing.volume_discount_pricing_rules"
                                    :key="volume_index">
                                    <div class="row align-items-center mb-3">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-2">
                                                    <p class="mr-2 my-auto text-nowrap">Categories : </p>
                                                </div>
                                                <div class="col-10">

                                                    <div class="row">
                                                        <div class="col-lg-12 d-flex">
                                                            <div class="w-100">
                                                                <multiselect
                                                                    v-model="volume_discount.categories"
                                                                    :options="$parent.volume_categories"
                                                                    :multiple="true"
                                                                    :close-on-select="false"
                                                                    :clear-on-select="false"
                                                                    :hide-selected="true"
                                                                    placeholder="Select some categories"
                                                                    :class="{'is-invalid': volumeDiscountCategoriesError(volume_index)}"
                                                                    track-by="id"
                                                                    @select="reduceCategory($event,'volume_discount');$parent.removeError(volumeDiscountCategoriesError(volume_index,true))"
                                                                    @remove="reAddCategory($event,'volume_discount')"
                                                                    label="label"
                                                                >
                                                                </multiselect>
                                                                <small
                                                                    v-if="volumeDiscountCategoriesError(volume_index)"
                                                                    class="text-danger">Categories field is
                                                                    required</small>
                                                            </div>


                                                            <button
                                                                :style="`visibility: ${$parent.rules_based_pricing.volume_discount_pricing_rules.length > 1 ? 'unset': 'hidden'}`"
                                                                class="btn btn-sm btn-link text-danger border-danger text-nowrap ml-2"
                                                                type="button"
                                                                @click="$parent.deleteVolumeRow(volume_index)">
                                                                &times; Delete
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="mt-3 tableFixHead rounded border"
                                                                 :class="{'border border-danger': volumeDiscountsError(volume_index)}">
                                                                <table
                                                                    class="table table-default table-sm m-0 table-striped"
                                                                >
                                                                    <thead class="bg-light">
                                                                    <tr>
                                                                        <th>Min Units</th>
                                                                        <th>Max Units</th>
                                                                        <th>Discount (%)</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr v-for="(discount,indexInner) in volume_discount.discounts"
                                                                        :key="indexInner">
                                                                        <td>
                                                                            <div v-if="discount.editable">
                                                                                <input @keypress.enter.prevent
                                                                                       :class="{'is-invalid': discount.min_error}"
                                                                                       type="number"
                                                                                       class="form-control"
                                                                                       placeholder="Enter Min"
                                                                                       v-model="discount.min">
                                                                                <small
                                                                                    v-if="typeof  discount.min_error !== 'undefined'  && discount.min_error"
                                                                                    class="text-danger">{{
                                                                                        discount.min_error
                                                                                    }}</small>
                                                                            </div>

                                                                            <span v-else>{{ discount.min }}</span>
                                                                        </td>
                                                                        <td>
                                                                            <div v-if="discount.editable">
                                                                                <input @keypress.enter.prevent
                                                                                       :class="{'is-invalid': discount.max_error}"
                                                                                       type="number"
                                                                                       class="form-control"
                                                                                       placeholder="Enter Max"
                                                                                       v-model="discount.max">
                                                                                <small
                                                                                    v-if="typeof  discount.max_error !== 'undefined'  && discount.max_error"
                                                                                    class="text-danger">{{
                                                                                        discount.max_error
                                                                                    }}</small>
                                                                            </div>
                                                                            <span v-else>{{ discount.max }}</span>
                                                                        </td>
                                                                        <td>
                                                                            <div v-if="discount.editable">
                                                                                <input @keypress.enter.prevent
                                                                                       :class="{'is-invalid': discount.discount_error}"
                                                                                       type="number"
                                                                                       class="form-control"
                                                                                       placeholder="Enter Discount"
                                                                                       v-model="discount.discount"
                                                                                       @input="validateDiscount($event,volume_index,'volume_discount_editable',indexInner)"
                                                                                >
                                                                                <small
                                                                                    v-if="typeof  discount.discount_error !== 'undefined'  && discount.discount_error"
                                                                                    class="text-danger">{{
                                                                                        discount.discount_error
                                                                                    }}</small>
                                                                            </div>
                                                                            <span
                                                                                v-else>{{ discount.discount }} %</span>
                                                                        </td>
                                                                        <td>
                                                                            <button
                                                                                @click="assignVolumeValueToTemp(discount,volume_index,indexInner);"
                                                                                v-if="!discount.editable"
                                                                                type="button"
                                                                                class="btn btn-warning btn-sm"><i
                                                                                class="lar la-edit"></i></button>
                                                                            <a v-if="!discount.editable"
                                                                               @click.prevent="$parent.removevolume_discount_indexRow(volume_index,indexInner)"
                                                                               class="btn btn-danger btn-sm" href=""><i
                                                                                class="lar la-trash-alt"></i></a>
                                                                            <button v-if="discount.editable"
                                                                                    @click="$parent.updateVolumeValue(volume_index,indexInner)"
                                                                                    type="button"
                                                                                    class="btn btn-primary btn-sm"><i
                                                                                class="las la-save"></i> Update
                                                                            </button>

                                                                            <button
                                                                                @click="restoreVolumeValueFromTemp(volume_index,indexInner);"
                                                                                v-if="discount.editable" type="button"
                                                                                class="btn btn-light btn-sm"><i
                                                                                class="las la-ban"></i> Cancel
                                                                            </button>
                                                                        </td>
                                                                    </tr>

                                                                    <tr :key="`discount_${$parent.re_render_volume}`">
                                                                        <td><input @keypress.enter.prevent type="number"
                                                                                   :class="{'is-invalid': typeof  $parent.VolumeBasedError[volume_index] !== 'undefined' && $parent.VolumeBasedError[volume_index].volume_min}"
                                                                                   class="form-control"
                                                                                   placeholder="Enter min units"
                                                                                   @input="$parent.removeError(volumeDiscountsError(volume_index,true));removeVolumeBasedError(volume_index,'volume_min')"
                                                                                   v-model="$parent.volume_discount_index[volume_index].min">
                                                                            <small
                                                                                v-if="typeof  $parent.VolumeBasedError[volume_index] !== 'undefined' && $parent.VolumeBasedError[volume_index].volume_min"
                                                                                class="text-danger">{{
                                                                                    $parent.VolumeBasedError[volume_index].volume_min
                                                                                }}</small>
                                                                        </td>

                                                                        <td><input @keypress.enter.prevent type="number"
                                                                                   :class="{'is-invalid': typeof  $parent.VolumeBasedError[volume_index] !== 'undefined' &&  $parent.VolumeBasedError[volume_index].volume_max}"
                                                                                   placeholder="Enter max units"
                                                                                   class="form-control"
                                                                                   @input="$parent.removeError(volumeDiscountsError(volume_index,true));removeVolumeBasedError(volume_index,'volume_max')"
                                                                                   v-model="$parent.volume_discount_index[volume_index].max">
                                                                            <small
                                                                                v-if="typeof  $parent.VolumeBasedError[volume_index] !== 'undefined' && $parent.VolumeBasedError[volume_index].volume_max"
                                                                                class="text-danger">{{
                                                                                    $parent.VolumeBasedError[volume_index].volume_max
                                                                                }}</small>
                                                                        </td>
                                                                        <td><input @keypress.enter.prevent type="number"
                                                                                   @input="validateDiscount($event,volume_index,'volume_discount');
                                                                                   $parent.removeError(volumeDiscountsError(volume_index,true));removeVolumeBasedError(volume_index,'volume_discount')"
                                                                                   :class="{'is-invalid': typeof  $parent.VolumeBasedError[volume_index] !== 'undefined' &&  $parent.VolumeBasedError[volume_index].volume_discount}"
                                                                                   class="form-control"
                                                                                   placeholder="Enter discount"
                                                                                   v-model="$parent.volume_discount_index[volume_index].discount">
                                                                            <small
                                                                                v-if="typeof  $parent.VolumeBasedError[volume_index] !== 'undefined' && $parent.VolumeBasedError[volume_index].volume_discount"
                                                                                class="text-danger">{{
                                                                                    $parent.VolumeBasedError[volume_index].volume_discount
                                                                                }}</small>
                                                                        </td>
                                                                        <td class="v-middle">
                                                                            <button
                                                                                @click="$parent.saveVolumeValueDiscount(volume_index)"
                                                                                type="button"
                                                                                class="btn btn-success btn-sm"><i
                                                                                class="las la-save"></i> Save
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                                <small v-if="volumeDiscountsError(volume_index)"
                                                                       class="text-danger pl-3">Min Max Discount all
                                                                    field are required</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-link border-primary"
                                        type="button"
                                        @click="$parent.addVolumeRow()">
                                    + Add
                                </button>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3 row">
                            <div class="col-lg-2">
                                <div class="checkbox my-0 my-lg-2">
                                    <input id="order_value_discount" type="checkbox"
                                           v-model="$parent.rules_based_pricing.order_value_discount">
                                    <label for="order_value_discount" class="form-check-label font-weight-normal">
                                        Order Value Discount
                                    </label>
                                </div>

                                <div class="checkbox my-0 my-lg-2 ml-3"
                                     v-if="$parent.rules_based_pricing.order_value_discount">
                                    <input id="order_value_discount_additive" type="checkbox"
                                           v-model="$parent.rules_based_pricing.order_value_discount_additive">
                                    <label for="order_value_discount_additive"
                                           class="form-check-label font-weight-normal">
                                        Discount Additive ?
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-10">
                                <div>
                                    <div class="row align-items-center">
                                        <div class="col-lg-12">
                                            <div
                                                class="table-wrapper position-relative mt-3 tableFixHead rounded border"
                                                :class="{'border border-danger' : orderValueDiscountsError()}">
                                                <table
                                                    class="table table-default table-sm m-0 table-striped">
                                                    <thead class="bg-light">
                                                    <tr>
                                                        <th>Order Value Upto</th>
                                                        <th>Discount (%)</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="(pricing_rules,o_index) in $parent.rules_based_pricing.order_value_discount_pricing_rules"
                                                        :key="`order_value_${o_index}_${$parent.re_render_order_value}`">
                                                        <td>
                                                            <div v-if="pricing_rules.editable">
                                                                <input @keypress.enter.prevent
                                                                       type="number" class="form-control"
                                                                       placeholder="Enter order value upto"
                                                                       :class="{'is-invalid':  pricing_rules.order_upto_error}"
                                                                       v-model="pricing_rules.order_value_upto">
                                                                <small
                                                                    v-if="typeof  pricing_rules.order_upto_error !== 'undefined'  && pricing_rules.order_upto_error"
                                                                    class="text-danger">{{
                                                                        pricing_rules.order_upto_error
                                                                    }}</small>
                                                            </div>

                                                            <span
                                                                v-else>{{ pricing_rules.order_value_upto }}</span></td>
                                                        <td>
                                                            <div v-if="pricing_rules.editable">
                                                                <input @keypress.enter.prevent
                                                                       v-model="pricing_rules.discount"
                                                                       :class="{'is-invalid':  pricing_rules.discount_error}"
                                                                       @input="validateDiscount($event,o_index,'order_value_discount')"
                                                                       type="number" class="form-control"
                                                                       placeholder="Enter discount">
                                                                <small
                                                                    v-if="typeof  pricing_rules.discount_error !== 'undefined'  && pricing_rules.discount_error"
                                                                    class="text-danger">{{
                                                                        pricing_rules.discount_error
                                                                    }}</small>
                                                            </div>
                                                            <span
                                                                v-else>{{ pricing_rules.discount }} %</span></td>
                                                        <td>
                                                            <button v-if="!pricing_rules.editable"
                                                                    @click="assignOrderValueToTemp(o_index)"
                                                                    class="btn btn-warning btn-sm"><i
                                                                class="lar la-edit"></i></button>
                                                            <a v-if="!pricing_rules.editable"
                                                               @click.prevent="$parent.removeOrderValueUptoRow(o_index) "
                                                               class="btn btn-danger btn-sm" href=""><i
                                                                class="lar la-trash-alt"></i></a>
                                                            <button @click="$parent.updateOrderValue(o_index)"
                                                                    v-if="pricing_rules.editable" type="button"
                                                                    class="btn btn-primary btn-sm"><i
                                                                class="las la-save"></i> Update
                                                            </button>
                                                            <button
                                                                @click="restoreOrderValueFromTemp(o_index);pricing_rules.editable = false;"
                                                                v-if="pricing_rules.editable" type="button"
                                                                class="btn btn-light btn-sm"><i
                                                                class="las la-ban"></i> Cancel
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr v-if="!$parent.OrderValueDiscount.editable">
                                                        <td><input @keypress.enter.prevent type="number"
                                                                   class="form-control"
                                                                   :class="{'is-invalid': $parent.orderBasedError.order_upto}"
                                                                   @input="$parent.removeError(orderValueDiscountsError(true));removeOrderBasedError('order_upto')"
                                                                   placeholder="Enter order value upto"
                                                                   v-model="$parent.OrderValueDiscount.order_value_upto">
                                                            <small v-if="$parent.orderBasedError.order_upto"
                                                                   class="text-danger">{{
                                                                    $parent.orderBasedError.order_upto
                                                                }}</small>
                                                        </td>
                                                        <td><input v-model="$parent.OrderValueDiscount.discount"
                                                                   @keypress.enter.prevent type="number"
                                                                   class="form-control" placeholder="Enter discount"
                                                                   @input="$parent.removeError(orderValueDiscountsError(true));removeOrderBasedError('order_discount')"
                                                                   :class="{'is-invalid': $parent.orderBasedError.order_discount}">
                                                            <small v-if="$parent.orderBasedError.order_discount"
                                                                   class="text-danger">{{
                                                                    $parent.orderBasedError.order_discount
                                                                }}</small>
                                                        </td>
                                                        <td class="v-middle">
                                                            <button @click="$parent.saveOrderValueDiscount()"
                                                                    type="button" class="btn btn-success btn-sm"><i
                                                                class="las la-save"></i> Save
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <small class="text-danger ml-3" v-if="orderValueDiscountsError()">Order
                                                    value discount is required</small>
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
</template>

<script>
import Multiselect from "vue-multiselect";
import _           from "lodash";

export default {
    name      : "BasicInfo",
    components: {
        Multiselect
    },
    data() {
        return {
            test: [],
        }
    },
    methods: {
        assignVolumeValueToTemp(volumeDiscountData, index, indexInner) {
            this.$parent.rules_based_pricing.volume_discount_pricing_rules.forEach(ele => {
                ele.discounts.map(ele => {
                    return ele.editable = false;
                })
            })
            console.log(this.$parent.rules_based_pricing.volume_discount_pricing_rules[index].discounts[indexInner]);
            this.$parent.tempVolumeDiscount                                                                      = _.cloneDeep(volumeDiscountData);
            this.$parent.rules_based_pricing.volume_discount_pricing_rules[index].discounts[indexInner].editable = true;
            this.$parent.re_render_volume++;
        },

        restoreVolumeValueFromTemp(index, indexInner) {
            this.$parent.rules_based_pricing.volume_discount_pricing_rules[index].discounts[indexInner]
                = _.cloneDeep(this.$parent.tempVolumeDiscount);
            //this.$parent.rules_based_pricing.order_value_discount_pricing_rules[index].editable = false;
            this.$parent.re_render_volume++;
        },

        assignOrderValueToTemp(index) {
            this.$parent.rules_based_pricing.order_value_discount_pricing_rules.map(ele => {
                return ele.editable = false;
            })
            this.$parent.tempOrderValueDiscount
                                                                                                = _.cloneDeep(this.$parent.rules_based_pricing.order_value_discount_pricing_rules[index]);
            this.$parent.rules_based_pricing.order_value_discount_pricing_rules[index].editable = true;
            this.$parent.re_render_order_value++;
        },

        restoreOrderValueFromTemp(index) {
            this.$parent.rules_based_pricing.order_value_discount_pricing_rules[index]
                = _.cloneDeep(this.$parent.tempOrderValueDiscount);
            //this.$parent.rules_based_pricing.order_value_discount_pricing_rules[index].editable = false;
            this.$parent.re_render_order_value++;
        },

        reduceCategory(event, module) {
            let dataSource = [];
            module === 'flat_discount' ? dataSource = this.$parent.flat_categories : dataSource
                = this.$parent.volume_categories;
            let selectedCategory = event;
            let filteredData     = dataSource.filter(ele => {
                return ele.id != selectedCategory.id;
            });
            if (module === 'flat_discount') {
                filteredData                 = _.orderBy(filteredData, 'label', 'asc');
                this.$parent.flat_categories = filteredData;
            } else if (module === 'volume_discount') {
                filteredData                   = _.orderBy(filteredData, 'label', 'asc');
                this.$parent.volume_categories = filteredData;
            }
        },

        reAddCategory(event, module) {
            let dataSource = [];
            module === 'flat_discount' ? dataSource = this.$parent.flat_categories : dataSource
                = this.$parent.volume_categories;
            let found = dataSource.find(ele => {
                return ele.id == event.id;
            })
            if (!found) {
                if (module === 'flat_discount') {
                    let tempCategories = this.$parent.flat_categories;
                    tempCategories.push(event);
                    tempCategories               = _.orderBy(tempCategories, 'label', 'asc');
                    this.$parent.flat_categories = tempCategories;
                } else if (module === 'volume_discount') {
                    let tempCategories = this.$parent.volume_categories;
                    tempCategories.push(event);
                    tempCategories                 = _.orderBy(tempCategories, 'label', 'asc');
                    this.$parent.volume_categories = tempCategories;
                }
            }
        },

        validateDiscount(event, index, module, indexInner = "") {
            let discount = parseFloat(event.target.value);
            if (discount > 100 || discount < 0) {
                var str_discount = discount.toString();
                str_discount     = discount < 0 ? 0 : str_discount.slice(0, -1);
                if (module === 'order_value_discount') {
                    this.$parent.rules_based_pricing.order_value_discount_pricing_rules[index].discount = str_discount;
                } else if (module === 'volume_discount') {
                    this.$parent.volume_discount_index[index].discount = str_discount;
                    this.$parent.re_render_volume++;
                } else if (module == 'volume_discount_editable') {
                    this.$parent.rules_based_pricing.volume_discount_pricing_rules[index].discounts[indexInner].discount
                        = str_discount;
                } else if (module == 'flat_discount') {
                    this.$parent.rules_based_pricing.flat_discount_pricing_rules[index].discount = str_discount;
                }
                new Noty({
                    type: "warning",
                    text: 'Discount length between 0 to 100'
                }).show();
                event.preventDefault();
            }
        },

        flatDiscountError(index, get_key = false) {
            let field = `pricing_rules.flat_discount_pricing_rules.${index}.discount`;
            if (get_key) {
                return field;
            }
            return _.has(this.$parent.validationErrors, field);
        },

        flatDiscountCategoriesError(index, get_key = false) {
            let field = `pricing_rules.flat_discount_pricing_rules.${index}.categories`;
            if (get_key) {
                return field;
            }
            return _.has(this.$parent.validationErrors, field);
        },

        volumeDiscountsError(index, get_key = false) {
            let field = `pricing_rules.volume_discount_pricing_rules.${index}.discounts`;
            if (get_key) {
                return field;
            }
            return _.has(this.$parent.validationErrors, field);
        },

        volumeDiscountCategoriesError(index, get_key = false) {
            let field = `pricing_rules.volume_discount_pricing_rules.${index}.categories`;
            if (get_key) {
                return field;
            }
            return _.has(this.$parent.validationErrors, field);
        },

        orderValueDiscountsError(get_key = false) {
            let field = `pricing_rules.order_value_discount_pricing_rules`;
            if (get_key) {
                return field;
            }
            return _.has(this.$parent.validationErrors, field);
        },

        removeOrderBasedError(key) {
            let errorsObject = this.$parent.orderBasedError;
            let errorExist   = errorsObject[key];
            if (errorExist) {
                delete errorsObject[key];
            }
        },

        removeVolumeBasedError(index, key) {
            let errorsObject = this.$parent.VolumeBasedError[index];
            if (errorsObject) {
                let errorExist = errorsObject[key];
                if (errorExist) {
                    delete errorsObject[key];
                }
            }
        }
    },
    watch  : {
        "$parent.rules_based_pricing.order_value_discount": function (newVal, oldVal) {
            if (newVal !== oldVal) {
                this.$parent.rules_based_pricing.order_value_discount_additive = false;
            }
        },
        "$parent.OrderValueDiscount.discount"             : function (newVal, oldVal) {
            if (newVal !== oldVal) {
                if (newVal > 100 || newVal < 0) {
                    new Noty({
                        type: "warning",
                        text: 'Discount length between 0 to 100'
                    }).show();
                    this.$parent.OrderValueDiscount.discount = oldVal;
                }
            }
        },
        "$parent.rules_based_pricing.volume_discount"     : function (newVal, oldVal) {
            if (newVal !== oldVal) {
                this.$parent.rules_based_pricing.volume_discount_additive = false;
            }
        },
    }
}
</script>

<style scoped>
.right-float {
    position: absolute;
    top: 6px;
    right: 20px;
}

.v-middle {
    vertical-align: middle;
}

.flat-disabled::after {
    content: "";
    display: block;
    position: absolute;
    width: 100%;
    height: 100%;
    background: #f1f4f875;
    z-index: 2;
    left: 0;
    top: 0;
    border-radius: 5px;
}
</style>
