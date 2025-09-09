<template>
    <div class="row">
        <div class="col-12">
            <!-- Default box -->
            <div class="card">
                <div class="card-body">
                    <!-- load the view from the application if it exists, otherwise load the one in the package -->
                    <FormFields ref="formFields" />
                </div>
            </div>

            <div id="saveActions" class="form-group">
                <input type="hidden" name="save_action" value="save_and_back">
                <div class="btn-group" role="group">
                    <button type="submit" class="btn btn-success">
                        <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                        <span @click="actionType=saveAction.active.value; saveData()">{{ saveAction.active.label }}</span>
                    </button>
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span><span class="sr-only">▼</span></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                            <template v-for="(option, index) in saveAction.options">
                                <button class="dropdown-item" @click="actionType=index; saveData()">{{ option }}</button>
                            </template>

                        </div>
                    </div>
                </div>
                <a :href="backUrl" class="btn btn-default"><span class="la la-ban"></span> &nbsp;Cancel</a>
            </div>
        </div>
    </div>
</template>

<script>
import FormFields       from "./FormFields";

export default {
    name      : "ReportCreate",
    components: {FormFields},
    props     : [
        'entry','url', 'method', 'axios_url', 'save_action'
    ],
    data() {
        return {
            report_types    : ['pie', 'column', 'line', 'bar', 'table'],
            sources         : { 'customer_orders': 'Order', 'products':'Product'},
            title           : "",
            datasource      : "",
            type            : "",
            count_type      : "",
            sum_by          : "",
            take_range      : "",
            columns         : {},
            source_types    : [],
            countTypes      : {},
            sumBys          : {},
            report : {
                reportConditions: [{
                    group_type      : "",
                    conditionLists  : [{
                        column_name : "",
                        operator    : "",
                        value       : "",
                    }],
                }],
                _save_action    : ''
            },
            backUrl         : '/admin/report',
            newUrl          : '/admin/report/create',
            actionType      : 'save_and_back',
            saveAction      : JSON.parse(this.save_action),
        }
    },

    created() {
        if (this.method === 'put') {
            this.initEdit()
        }
    },

    methods: {
        initEdit() {
            const entry = JSON.parse(this.entry);
            // this.report = entry;
            this.report.title = entry.title;
            this.report.type = entry.type;
            this.report.datasource = entry.datasource;
            if (entry.datasource === 'customer_orders') {
                this.source_types = {'order_type': "Order Type", 'order_status': "Order Status", 'approval_status': "Approval Status", 'shipping_method': "Shipping Method"}
                this.countTypes = { 'count': "Count", 'sum': "Sum"};
            } else if (entry.datasource === 'products') {
                this.source_types = {'status': "Status", 'is_new': "Is New", 'top_product': "Top Product By Sales"};
                this.countTypes = { 'count': "Count", 'sum': "Sum"};
            }
            if (entry.source_type === 'top_product') {


                console.log('here');
                this.countTypes = { 'count': "Count"};
                $(".dataParPageDiv").show();
            }else if(entry.source_type === 'order_type'){
                console.log('here');
                // this.report.reportConditions = [

                //     {
                //         group_type_name: "Order",
                //         group_type: 0,
                //         conditionLists: [{
                //             column_name: "",
                //             operator: "",
                //             value: "",
                //         }],
                //     },
                //     {
                //         group_type_name: "RFQ",
                //         group_type: 1,
                //         conditionLists: [{
                //             column_name: "",
                //             operator: "",
                //             value: "",
                //         }],
                //     }
                // ];
            }
            this.report.source_type = entry.source_type;
            this.report.count_type = entry.count_type;
            this.report.sum_by = entry.sum_by;
            this.report.take_range = entry.take_range;


            // console.log(entry.report_conditions);
            // this.report.reportConditions = entry.report_conditions;

        },

        saveData() {
            this.report._save_action = this.actionType;
            this.$refs.formFields.validationErrors = "";
            let params                             = _.cloneDeep(this.report);
            axios[this.method](this.axios_url, params)
                .then(response => {
                    new Noty({
                        type: "success",
                        text: 'Saved successfully',
                    }).show();
                    this.$refs.formFields.validationErrors = "";
                    window.location.href = "/admin/report";

                })
                .catch((err) => {
                    this.$refs.formFields.validationErrors = err.response.data.errors;
                    new Noty({
                        type: "error",
                        text: err.response.data.message,
                    }).show();
                    console.error(err);
                });
        }
    }
}
</script>

<style scoped>

</style>
