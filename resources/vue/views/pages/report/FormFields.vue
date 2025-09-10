<template>
    <div class="row">
        <!-- Title  -->

        <div class="form-group col-6 required">
            <label>Title
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <input type="text" name="title" v-model="$parent.report.title" class="form-control"
                   :class="{'is-invalid': validationErrors.title}">

            <small v-if="validationErrors.title" class="text-danger mt-3">{{ validationErrors.title[0] }}</small>
        </div>

        <!-- Report Type  -->
        <div class="form-group col-6 required">
            <label>Chart Type
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <select name="type" v-model="$parent.report.type" class="form-control" :class="{'is-invalid': validationErrors.type}">
                <option value="" >Select Chart Type</option>
                <option :value="report_type" v-for="(report_type, index) in $parent.report_types" :key="index">{{ capitalizeFirstLetter(report_type) }}</option>
            </select>
            <small v-if="validationErrors.type"
                   class="text-danger mt-3">{{ validationErrors.type[0] }}</small>
        </div>

        <!-- Prefix  -->
        <div class="form-group col-6 required">
            <label>Prefix</label>
            <input type="text" name="prefix" v-model="$parent.report.prefix" class="form-control"
                   :class="{'is-invalid': validationErrors.prefix}">

            <small v-if="validationErrors.prefix" class="text-danger mt-3">{{ validationErrors.prefix[0] }}</small>
        </div>

        <!-- Suffix  -->
        <div class="form-group col-6 required">
            <label>Suffix</label>
            <input type="text" name="suffix" v-model="$parent.report.suffix" class="form-control"
                   :class="{'is-invalid': validationErrors.suffix}">

            <small v-if="validationErrors.suffix" class="text-danger mt-3">{{ validationErrors.suffix[0] }}</small>
        </div>

        <!-- Source  -->
        <div class="form-group col-3 required">
            <label>Source
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <select @change="changeSource()" name="datasource"
            v-model="$parent.report.datasource" class="form-control" :class="{'is-invalid': validationErrors.datasource}">
                <option value="" >Select Source</option>
                <option :value="index" v-for="(source, index) in $parent.sources" :key="index">{{ source }}</option>
            </select>
            <small v-if="validationErrors.datasource"
                   class="text-danger mt-3">{{ validationErrors.datasource[0] }}</small>
        </div>

        <!-- Source type  -->
        <div class="form-group col-3 required">
            <label>Group Type
                <span class="text-danger font-weight-bold">*</span>
            </label>
            <select @change="changeSourceType()" name="source_type" v-model="$parent.report.source_type" class="form-control" :class="{'is-invalid': validationErrors.source_type}">
                <option value="" >Select Group Type</option>
                <option :value="index" v-for="(source_type, index) in $parent.source_types" :key="index">{{ capitalizeFirstLetter(source_type) }}</option>
            </select>
            <small v-if="validationErrors.source_type"
                   class="text-danger mt-3">{{ validationErrors.source_type[0] }}</small>
        </div>

        <div class="form-group col-12">
            <label class="lead">Conditions</label>
            <component :is="currentSource"/>
        </div>

        <!-- Aggregate  -->
        <div class="form-group col-3">
            <label>Aggregate <span class="text-danger font-weight-bold">*</span></label>
            <select name="count_type" @change="changeCountType()" id="count_type" v-model="$parent.report.count_type" class="form-control" :class="{'is-invalid': validationErrors.count_type}">
                <option value="" >Select Aggregate</option>
                <option :value="index" v-for="(count_type, index) in $parent.countTypes" :key="index">{{ count_type }}</option>
            </select>
            <small v-if="validationErrors.count_type"
                   class="text-danger mt-3">{{ validationErrors.count_type[0] }}</small>
        </div>

        <div class="form-group col-3 sumByDiv">
            <label>Sum By <span class="text-danger font-weight-bold">*</span></label>
            <select name="sum_by" id="sum_by" v-model="$parent.report.sum_by" class="form-control" :class="{'is-invalid': validationErrors.sum_by}">
                <option value="" >Select Sum By</option>
                <option :value="index" v-for="(sum_by, index) in $parent.sumBys" :key="index">{{ sum_by }}</option>
            </select>
            <small v-if="validationErrors.sum_by"
                   class="text-danger mt-3">{{ validationErrors.sum_by[0] }}</small>
        </div>

        <div class="form-group col-2 dataParPageDiv">
            <label>Take Range <span class="text-danger font-weight-bold">*</span></label>
            <input type="number" name="take_range" v-model="$parent.report.take_range" class="form-control"
                   :class="{'is-invalid': validationErrors.take_range}">
            <small v-if="validationErrors.take_range" class="text-danger mt-3">{{ validationErrors.take_range[0] }}</small>
        </div>

    </div>
</template>

<script>
import _ from "lodash";
import Condition from './source/Condition.vue';

export default {
    name : "FormFields",
    props: [],
    data() {
        return {
            validationErrors: "",
            currentSource: "",
            whereTypes :[],

        }
    },
    mounted() {
        $(".sumByDiv").hide();
        $(".dataParPageDiv").hide();
    },
    components : {},
    methods : {
        capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        },
        // changeSource() {
        //     if(this.$parent.report.datasource === 'customer_orders')
        //         this.currentSource = Order;
        //     else if(this.$parent.report.datasource === 'products')
        //         this.currentSource = Product;
        //     else
        //         this.currentSource = "";
        // },
        changeSource() {
            if(this.$parent.report.datasource === 'customer_orders'){
                this.$parent.source_types = {'order_type': "Order Type", 'order_status': "Order Status", 'approval_status': "Approval Status", 'shipping_method': "Shipping Method"}
                this.currentSource = "";
                this.$parent.sumBys = { 'total_net_price': "Total Net Price", 'total_amount': "Total Amount"};
                this.$parent.countTypes = { 'count': "Count", 'sum': "Sum"};
            }else if(this.$parent.report.datasource === 'products'){
                this.$parent.source_types = {'status': "Status", 'is_new': "Is New", 'top_product': "Top Product By Sales"};
                this.$parent.sumBys = { 'selling_price': "Selling Price"};
                this.$parent.countTypes = { 'count': "Count", 'sum': "Sum"};
                this.currentSource = "";
            }else{
                    this.$parent.source_types = [];
                    this.currentSource = "";
            }
        },

        changeCountType(){
            console.log(this.$parent.report.count_type);
            if(this.$parent.report.count_type === "sum"){
                $(".sumByDiv").show();
            }else{
                $(".sumByDiv").hide();
            }
        },

        changeSourceType() {
            console.log(this.$parent.report.source_type);
            if (this.$parent.report.source_type === 'top_product') {
                this.$parent.countTypes = { 'count': "Count"};
                $(".dataParPageDiv").show();
            } else {
                this.$parent.countTypes = { 'count': "Count", 'sum': "Sum"};
                $(".dataParPageDiv").hide();
            }
            if(this.$parent.report.source_type === 'order_type'){
                this.$parent.report.reportConditions = [

                    {
                        group_type_name: "Order",
                        group_type: 0,
                        conditionLists: [{
                            column_name: "",
                            operator: "",
                            value: "",
                        }],
                    },
                    {
                        group_type_name: "RFQ",
                        group_type: 1,
                        conditionLists: [{
                            column_name: "",
                            operator: "",
                            value: "",
                        }],
                    }
                ];
                // this.whereTypes = {'Order': "Order",'RFQ': "RFQ"},
                this.$parent.columns = { 'order_status': "Order Status", 'approval_status': "Approval Status", 'shipping_method': "Shipping Method", 'total_amount': "Total Amount"};
                this.currentSource = Condition;
            }else if(this.$parent.report.source_type === 'order_status'){

                this.$parent.report.reportConditions = [

                    {
                        group_type_name:"Pending",
                        group_type: "Pending",
                        conditionLists: [{
                            column_name: "",
                            operator: "",
                            value: "",
                        }],
                    },
                    {
                        group_type_name:"Approved",
                        group_type: "Approved",
                        conditionLists: [{
                            column_name: "",
                            operator: "",
                            value: "",
                        }],
                    },
                    {
                        group_type_name:"Complete",
                        group_type: "Complete",
                        conditionLists: [{
                            column_name: "",
                            operator: "",
                            value: "",
                        }],
                    },
                    {
                        group_type_name:"Submitted",
                        group_type: "Submitted",
                        conditionLists: [{
                            column_name: "",
                            operator: "",
                            value: "",
                        }],
                    },
                    {
                        group_type_name:"Rejected",
                        group_type: "Rejected",
                        conditionLists: [{
                            column_name: "",
                            operator: "",
                            value: "",
                        }],
                    },
                    {
                        group_type_name:"Processing",
                        group_type: "Processing",
                        conditionLists: [{
                            column_name: "",
                            operator: "",
                            value: "",
                        }],
                    },
                    {
                        group_type_name:"Draft",
                        group_type: "Draft",
                        conditionLists: [{
                            column_name: "",
                            operator: "",
                            value: "",
                        }],
                    },
                    {
                        group_type_name:"Payment Pending",
                        group_type: "Payment Pending",
                        conditionLists: [{
                            column_name: "",
                            operator: "",
                            value: "",
                        }],
                    }
                ];

                // this.whereTypes = {'Pending': "Pending",'Approved': "Approved",'Complete': "Complete",'Submitted': "Submitted",'Rejected': "Rejected",'Processing': "Processing",'Draft': "Draft",'Payment Pending': "Payment Pending"};
                this.currentSource = Condition;
                this.$parent.columns = { 'order_type': "Order Type", 'approval_status': "Approval Status", 'shipping_method': "Shipping Method", 'total_amount': "Total Amount"};

            }else if(this.$parent.report.source_type === 'approval_status'){
                // this.whereTypes = {'pending': "Pending",'approved': "Approved"};
                this.$parent.report.reportConditions = [

                    {
                        group_type_name:"Pending",
                        group_type: "pending",
                        conditionLists: [{
                            column_name: "",
                            operator: "",
                            value: "",
                        }],
                    },
                    {
                        group_type_name:"Approved",
                        group_type: "approved",
                        conditionLists: [{
                            column_name: "",
                            operator: "",
                            value: "",
                        }],
                    }
                ];
                this.currentSource = Condition;
                this.$parent.columns = { 'order_type': "Order Type", 'order_status': "Order Status", 'shipping_method': "Shipping Method", 'total_amount': "Total Amount"};

            }else if(this.$parent.report.source_type === 'shipping_method'){
                // this.whereTypes = {'WILL CALL': "WILL CALL",'NEXT DAY': "NEXT DAY",'DELIVERY': "DELIVERY",'UPS': "UPS"};
                this.$parent.report.reportConditions = [

                    {
                        group_type_name:"WILL CALL",
                        group_type: "WILL CALL",
                        conditionLists: [{
                            column_name: "",
                            operator: "",
                            value: "",
                        }],
                    },
                    {
                        group_type_name:"NEXT DAY",
                        group_type: "NEXT DAY",
                        conditionLists: [{
                            column_name: "",
                            operator: "",
                            value: "",
                        }],
                    },
                    {
                        group_type_name:"DELIVERY",
                        group_type: "DELIVERY",
                        conditionLists: [{
                            column_name: "",
                            operator: "",
                            value: "",
                        }],
                    },
                    {
                        group_type_name:"UPS",
                        group_type: "UPS",
                        conditionLists: [{
                            column_name: "",
                            operator: "",
                            value: "",
                        }],
                    }
                ];
                this.currentSource = Condition;
                this.$parent.columns = { 'order_type': "Order Type", 'order_status': "Order Status", 'approval_status': "Approval Status", 'total_amount': "Total Amount"};


            }else if(this.$parent.report.source_type === 'status'){
                // this.whereTypes = {'published': "Published",'incomplete': "Incomplete",'draft': "Draft",'archived': "Archived"};
                this.$parent.report.reportConditions = [

                    {
                        group_type_name:"Published",
                        group_type: "published",
                        conditionLists: [{
                            column_name: "",
                            operator: "",
                            value: "",
                        }],
                    },
                    {
                        group_type_name:"Incomplete",
                        group_type: "incomplete",
                        conditionLists: [{
                            column_name: "",
                            operator: "",
                            value: "",
                        }],
                    },
                    {
                        group_type_name:"Draft",
                        group_type: "draft",
                        conditionLists: [{
                            column_name: "",
                            operator: "",
                            value: "",
                        }],
                    },
                    {
                        group_type_name:"Archived",
                        group_type: "archived",
                        conditionLists: [{
                            column_name: "",
                            operator: "",
                            value: "",
                        }],
                    }
                ];
                this.currentSource = Condition;
                this.$parent.columns ={ 'selling_price': "Selling Price", 'msrp': "MSRP", 'is_new': "Is New"};


            }else if(this.$parent.report.source_type === 'is_new'){
                // this.whereTypes = {'Yes': "Yes",'No': "No"};
                this.$parent.report.reportConditions = [

                    {
                        group_type_name:"Yes",
                        group_type: 1,
                        conditionLists: [{
                            column_name: "",
                            operator: "",
                            value: "",
                        }],
                    },
                    {
                        group_type_name:"No",
                        group_type: 0,
                        conditionLists: [{
                            column_name: "",
                            operator: "",
                            value: "",
                        }],
                    }
                ];
                this.currentSource = Condition;
                this.$parent.columns ={ 'status': "Status", 'selling_price': "Selling Price", 'msrp': "MSRP"};
                // this.$parent.columns ={ 'status': "Status", 'selling_price': "Selling Price", 'msrp': "MSRP",'published_at': "Published At", 'created_at': 'Created At' };

            }else{
                this.currentSource = "";
            }
        },
    },
}
</script>
