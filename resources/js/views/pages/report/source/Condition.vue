<template>
    <section class="repeater">
        <div class="card bg-light card-body" v-for="(reportCondition, key) in $parent.$parent.report.reportConditions" :key="key">
            <div class="row">
                <div class="form-group col-2">
                    <!-- <label>Where Type</label>
                    <select class="form-control" v-model="condition.where_type" readonly>
                        <option value="">Select Type</option>
                        <option v-for="(type, key) in $parent.whereTypes" :value="key" :key="key">{{ type }}</option>
                    </select> -->
                    <input type="hidden" v-model="reportCondition.group_type">
                    <h4>{{ reportCondition.group_type_name }}</h4>
                </div>
                <div class="form-group col-8">
                    <div class="card bg-light card-body" v-for="(condition, index) in reportCondition.conditionLists" :key="index">
                        <div class="row">
                            <div class="form-group col-4">
                                <label>Where Column</label>
                                <select class="form-control" v-model="condition.column_name">
                                    <option value="">Select Column</option>
                                    <option v-for="(column, key) in $parent.$parent.columns" :value="key" :key="key">{{ column }}</option>
                                </select>
                            </div>
                            <div class="form-group col-3">
                                <label>Operator</label>
                                <select class="form-control" v-model="condition.operator">
                                    <option value="">Select operator</option>
                                    <option v-for="(operator, key) in operators.filter(operator => operator.accessBy.includes(condition.column_name))" :value="operator.value" :key="key">{{ operator.label }}</option>
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label :for="`value`">Condition Value</label>
                                <select :id="`value-${index}`" class="form-control" v-model="condition.value">
                                    <option value="">Select value</option>
                                    <option v-for="(value, key) in values.filter(value => value.accessBy.includes(condition.column_name))" :value="value.value" :key="key">{{ value.label }}</option>

                                </select>
                            </div>
                            <button type="button" class="btn btn-danger" style="height: 35px;" @click="removeSingleConditionCard(key)"> X </button>
                        </div>
                    </div>
                </div>

                <a href="javascript:void(0)" class="btn btn-outline-primary" style="height: 35px;" @click="addNewConditionCard(key)"> + </a>

                <button type="button" class="btn btn-danger" style="height: 35px;" @click="removeConditionCard(index)">X</button>
            </div>
        </div>
    </section>
</template>
<script>
export default {
    name : "Condition",
    data() {
        return {

            // columns: { 'order_type': "Order Type", 'order_status': "Order Status", 'approval_status': "Approval Status", 'shipping_method': "Shipping Method", 'total_amount': "Total Amount", 'created_at': 'Created At' },
            operators: [
                {
                    label: 'Equal',
                    value: '=',
                    accessBy: ['order_type', 'order_status', 'approval_status', 'customer_id', 'shipping_method', 'total_amount', 'created_at','status', 'selling_price', 'msrp', 'is_new', 'published_at', 'created_at']
                    // accessBy: ['order_type', 'order_status', 'approval_status', 'customer_id', 'shipping_method', 'total_amount', 'created_at','status', 'selling_price', 'msrp', 'is_new', 'published_at', 'created_at']
                },
                {
                    label: 'Not Equal',
                    value: '!=',
                    accessBy: ['created_at']
                },
                {
                    label: 'Greater Than',
                    value: '>',
                    accessBy: ['total_amount','selling_price', 'msrp', 'created_at']
                },
                {
                    label: 'Less Than',
                    value: '<',
                    accessBy: ['total_amount','selling_price', 'msrp', 'created_at']
                },
                {
                    label: 'Greater Than Equal',
                    value: '>=',
                    accessBy: ['total_amount','selling_price', 'msrp', 'created_at']
                },
                {
                    label: 'Less Than Equal',
                    value: '<=',
                    accessBy: ['total_amount','selling_price', 'msrp', 'created_at']
                },
            ],
            values: [
            // order_type start
                {
                    label: 'Order',
                    value: '0',
                    accessBy: ['order_type']
                },
                {
                    label: 'RFQ',
                    value: '1',
                    accessBy: ['order_type']
                },
            // order_type end

            // order status start
                {
                    label: 'Pending',
                    value: 'Pending',
                    accessBy: ['order_status']
                },
                {
                    label: 'Approved',
                    value: 'Approved',
                    accessBy: ['order_status']
                },
                {
                    label: 'Complete',
                    value: 'Complete',
                    accessBy: ['order_status']
                },
                {
                    label: 'Submitted',
                    value: 'Submitted',
                    accessBy: ['order_status']
                },
                {
                    label: 'Rejected',
                    value: 'Rejected',
                    accessBy: ['order_status']
                },
                {
                    label: 'Processing',
                    value: 'Processing',
                    accessBy: ['order_status']
                },
                {
                    label: 'Draft',
                    value: 'Draft',
                    accessBy: ['order_status']
                },
                {
                    label: 'Payment Pending',
                    value: 'Payment Pending',
                    accessBy: ['order_status']
                },
            // order status  end
            // approval_status start
                {
                    label: 'Pending',
                    value: 'pending',
                    accessBy: ['approval_status']
                },
                {
                    label: 'Approved',
                    value: 'approved',
                    accessBy: ['approval_status']
                },
            // approval_status end
            // shipping_method start
                {
                    label: 'WILL CALL',
                    value: 'WILL CALL',
                    accessBy: ['shipping_method']
                },
                {
                    label: 'Flat Rate',
                    value: 'Flat Rate',
                    accessBy: ['shipping_method']
                },
                {
                    label: 'Pickup From Store',
                    value: 'Pickup From Store',
                    accessBy: ['shipping_method']
                },
            // shipping_method end
            // total_amount start
                {
                    label: '100',
                    value: '100',
                    accessBy: ['total_amount']
                },
                {
                    label: '200',
                    value: '200',
                    accessBy: ['total_amount']
                },
                {
                    label: '300',
                    value: '300',
                    accessBy: ['total_amount']
                },
                {
                    label: '500',
                    value: '500',
                    accessBy: ['total_amount']
                },
                {
                    label: '1000',
                    value: '1000',
                    accessBy: ['total_amount']
                },

            // total_amount end
            // created_at start
                {
                    label: 'Today',
                    value: 'today',
                    accessBy: ['created_at']
                },
                {
                    label: 'Yesterday',
                    value: 'yesterday',
                    accessBy: ['created_at']
                },
                {
                    label: 'Last 7 Days',
                    value: 'last_7_days',
                    accessBy: ['created_at']
                },
                {
                    label: 'Last 30 Days',
                    value: 'last_30_days',
                    accessBy: ['created_at']
                },
                {
                    label: 'This Month',
                    value: 'this_month',
                    accessBy: ['created_at']
                },
                {
                    label: 'Last Month',
                    value: 'last_month',
                    accessBy: ['created_at']
                },
                {
                    label: 'Custom',
                    value: 'custom',
                    accessBy: ['created_at']
                },
            // created_at end



            // product start
            // status start
            {
                    label: 'Published',
                    value: 'published',
                    accessBy: ['status']
                },
                {
                    label: 'Incomplete',
                    value: 'incomplete',
                    accessBy: ['status']
                },
                {
                    label: 'Draft',
                    value: 'draft',
                    accessBy: ['status']
                },
                {
                    label: 'Archived',
                    value: 'archived',
                    accessBy: ['status']
                },
            // status end

            // selling_price start
            {
                    label: '100',
                    value: '100',
                    accessBy: ['selling_price']
                },
                {
                    label: '200',
                    value: '200',
                    accessBy: ['selling_price']
                },
                {
                    label: '300',
                    value: '300',
                    accessBy: ['selling_price']
                },
                {
                    label: '500',
                    value: '500',
                    accessBy: ['selling_price']
                },
                {
                    label: '1000',
                    value: '1000',
                    accessBy: ['selling_price']
                },

            // selling_price end

            // msrp start
            {
                    label: '100',
                    value: '100',
                    accessBy: ['msrp']
                },
                {
                    label: '200',
                    value: '200',
                    accessBy: ['msrp']
                },
                {
                    label: '300',
                    value: '300',
                    accessBy: ['msrp']
                },
                {
                    label: '500',
                    value: '500',
                    accessBy: ['msrp']
                },
                {
                    label: '1000',
                    value: '1000',
                    accessBy: ['msrp']
                },

            // msrp end

            // is_new start
            {
                    label: 'Yes',
                    value: '1',
                    accessBy: ['is_new']
                },
                {
                    label: 'No',
                    value: '0',
                    accessBy: ['is_new']
                },
            // is_new end

            // published_at start
                {
                    label: 'Today',
                    value: 'today',
                    accessBy: ['published_at']
                },
                {
                    label: 'Yesterday',
                    value: 'yesterday',
                    accessBy: ['published_at']
                },
                {
                    label: 'Last 7 Days',
                    value: 'last_7_days',
                    accessBy: ['published_at']
                },
                {
                    label: 'Last 30 Days',
                    value: 'last_30_days',
                    accessBy: ['published_at']
                },
                {
                    label: 'This Month',
                    value: 'this_month',
                    accessBy: ['published_at']
                },
                {
                    label: 'Last Month',
                    value: 'last_month',
                    accessBy: ['published_at']
                },
                {
                    label: 'Custom',
                    value: 'custom',
                    accessBy: ['published_at']
                },
            // published_at end

            ],
        }
    },
    methods: {
        addNewConditionCard(key) {
            this.$parent.$parent.report.reportConditions[key].conditionLists.push({
                column_name: "",
                operator: "",
                value: "",
            })
        },
        removeConditionCard(index, length = 1) {
            let path = this.$parent.$parent.report.reportConditions.splice(index, length)
        },
        removeSingleConditionCard(key, length = 1) {
            let path = this.$parent.$parent.report.reportConditions[key].conditionLists.splice(key, length)
        }
    }
};
</script>
