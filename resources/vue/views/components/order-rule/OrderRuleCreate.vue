<template>
  <div id="settingEmailCreate" class="animated fadeIn">
    <form method="post" @submit.prevent>
      <div class="card">
        <div class="card-body">
          <div class="row"> 
            <div class="form-group col">
              <label> Name <span class="required-custom">*</span>
              </label>
              <input type="text" name="name" class="form-control" placeholder="Enter customer rule name" :disabled="disabled" v-model="customer_order_rule.name">
            </div>
            <div class="form-group d-none">
              <label for="customer">Customer <span class="required-custom">*</span>
              </label>
              <multiselect :options="customerList" v-model="customer" :disabled="true" placeholder="Select a customer" track-by="id" label="customer_name"></multiselect>
            </div>
            <div class="form-group col">
              <label for="customer">Order Rule <span class="required-custom">*</span>
              </label>
              <multiselect v-model="order_rule" :options="orderRules" :multiple="false" :disabled="disabled" :searchable="true" :close-on-select="true" :clear-on-select="false" placeholder="Select a customer order rule" track-by="id" label="name" @input="ruleChange"></multiselect>
            </div>
          </div>
            <div class="form-group">
              <input type="checkbox" name="customer_order_rule.enabled" :disabled="disabled"
                    v-model="customer_order_rule.enabled">
              <label for="payment_logger">Enable Rule</label>
            </div>
        </div>
      </div>


      <template v-if="rule_value_format.length > 0">
        <div class="card">

          <div class="card-header p-2">
            <h5 class="card-title mb-0">Order Rule Values</h5>
          </div>
          <div class="card-body">
            <table id="crudTable" class="bg-white table table-striped table-hover nowrap rounded shadow-xs border-xs mt-2 dataTable dtr-inline" cellspacing="0" aria-describedby="crudTable_info" role="grid">
              <thead>
                <tr role="row">
                  <th>#</th>
                  <th>Shipping</th>
                  <template v-for="(ruleForminput, index) in ruleForminputs">
                    <th>{{ ruleForminput.label }}</th>
                  </template>
                  <th>Approver</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                <tr class="odd" v-for="(ruleForms, index) in rule_value_format" :key="index">
                  <td class="dtr-control">
                    <span> {{ index+1 }} </span>
                  </td>
                  <td>
                    <multiselect :options="ruleForms.shipping_list" :disabled="disabled" :multiple="false" :searchable="true" 
                      v-model="ruleForms.shipping_address" :close-on-select="true" 
                      :clear-on-select="false" placeholder="Select Shipping" 
                      track-by="ShipToName" label="ShipToName"></multiselect>
                  </td>

                  <template v-for="(formFormat, secIndex) in ruleForms.form">
                    <td :key="secIndex">
                      <input :type="formFormat.type ?? 'text'" class="form-control" :disabled="disabled" :placeholder="formFormat.label" v-model="formFormat.value">
                    </td>
                  </template>
                  <td>
                      <multiselect :options="ruleForms.approvers_list" :disabled="disabled" :multiple="true" :searchable="true"
                          :close-on-select="true" :clear-on-select="false" placeholder="Select Approvers"
                          track-by="id" label="name" v-model="ruleForms.approvers">
                      </multiselect>
                  </td>
                  <td>
                      <button class="btn btn-danger" data-style="zoom-in" :disabled="disabled"
                        v-if="rule_value_format.length > 1"
                        @click.prevent="rule_value_format.splice(index, 1)">
                          <span class="ladda-label">
                              <i class="fa fa-minus"></i>
                          </span>
                      </button>
                      
                      <button class="btn btn-success" data-style="zoom-in" :disabled="disabled"
                        v-if="rule_value_format.length == index + 1"
                        @click="addRuleForm()">
                          <span class="ladda-label">
                              <i class="fa fa-plus"></i>
                          </span>
                      </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div> 
      </template>


      <div v-if="!disabled" id="saveActions" class="form-group">
        <input type="hidden" name="save_action" value="save_and_back" v-model="actionType">
        <div class="btn-group" role="group">
          <button type="button" class="btn btn-success" @click="saveData()">
            <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp; <span>Save</span>
          </button>
        </div>
      </div>

    </form>
  </div>
</template>

<script>
import _ from "lodash";
import Multiselect from 'vue-multiselect';
import Form from '../../../utilities/Form'
import axios from 'axios'
  export default {
      name: "OrderRuleCreate",
      components: {
          Multiselect
      },
      props: [
        'path','is_edit_able','type', 'method', 'order_rules', 'customer_order_rule_data', 'customer_list', 'save_action'
       ],
      data() {
          return {
              ruleValueRemove: false,
              customerOrderRulesDataForUpdate: [],

              customer: null,
              order_rule: null,
              disabled:false,

              customer_order_rule: {
                  name: null,
                  customer_id: null,
                  order_rule_id: null,
                  enabled: false,
                  description: null,
                  value: [],
              },

              contact_list: [],
              customerList: JSON.parse(this.customer_list),
              orderRules: JSON.parse(this.order_rules),
              actionType: 'save_and_back',
              saveAction: "",
              backUrl: '/admin/customer-order-rule',

              rule_value_format: [],
              approvers_list: [],
              ruleForminputs: [],
              ruleFormApprovers: [],
              ruleFormShipping: [],

          }
      },
      methods:{ 

        saveData() {
 
          this.customer_order_rule.value = this.formattingValues();  
          if(this.customer_order_rule.value.length == 0){
            ShowNotification('error', 'Order Rule', "Order rule can't be empty !!");
            return;
          }
          axios.post('/order-rule', this.customer_order_rule)
          .then(response => {
      
            ShowNotification('success', 'Order Rule', response.data.message);
            window.location.href = "/"+this.path;
          })
          .catch((err) => { 

            ShowNotification('error', 'Order Rule', err.response.data.message);
              
          });
      },

        ruleChange(newRule) { 
          this.customer_order_rule.order_rule_id = newRule.id;
          this.order_rule = newRule;
          this.rule_value_format = [];
          this.addRuleForm();
        },

        addRuleForm() {
            if (this.customer != null && this.order_rule != null) {
                axios.post('/fetch-order-rule', { id: this.customer_order_rule?.id ?? "", rule_id: this.customer_order_rule.order_rule_id, customer_id: this.customer_order_rule.customer_id })
                    .then(res => {
                      if(res.data.rule_message){
                        ShowNotification('error', 'Order Rule', res.data.rule_message);
                      }else{
                        this.ruleForminputs = res.data?.form ?? [];
                        this.ruleFormApprovers = res.data?.approvers ?? [];
                        this.ruleFormShipping = res.data?.ship_address ?? [];
                        this.rule_value_format.push({ form: this.ruleForminputs, approvers_list: this.ruleFormApprovers,shipping_list: this.ruleFormShipping, approvers: [] });
                      }
                    })
                    .catch(error => {
                        console.log(error);
                    });
            } else {
                new Noty({
                    type: "error",
                    text: "Please select customer and rule"
                }).show();
            }
        }, 

        formattingValues() {
        
          let values = [];
          this.rule_value_format.forEach(item => {
              let approverIds = []
              let formData = {};
              item.approvers.forEach(approver => {
                  approverIds.push(approver.id);
              });

              let { form } = item;
             form.forEach(field => {
                  let name = field.name;
                  let value = field.value;
                  formData[name] = value;
             });
             formData['shipping_address'] =  item.shipping_address?.ShipToName ?? "";
             formData['approvers'] = approverIds; 
            values.push(formData)

          }); 
          return values;
      },

      getCustomer(customerId) {
          let customerList = JSON.parse(this.customer_list);
          return customerList.filter((customer, index) => {
              return customer.id == customerId;
          })[0];
      },
      getRule(ruleId) {
          let orderRuleData = JSON.parse(this.order_rules);
          return orderRuleData.filter((item, index) => {
              return item.id == ruleId;
          })[0];
      },

      
    },
    mounted() {
      if (this.customerList.length > 0) {
        let customer = this.customerList[0];
        this.customer = [customer]; 
        this.customer_order_rule.customer_id = customer.id; 
        this.order_rule = null;
        this.rule_value_format = [];
      }

      if (this.is_edit_able) {
        if(this.type == 'view'){
          this.disabled = true;
        }

        let customerOrderRuleData = JSON.parse(this.customer_order_rule_data) 
        let ruleData = customerOrderRuleData.value; 
      
        this.customer_order_rule = customerOrderRuleData; 
        this.customer = this.getCustomer(customerOrderRuleData.customer_id);
        this.isRuleDisabled = false;
        this.order_rule = this.getRule(customerOrderRuleData.order_rule_id);
        this.customerOrderRulesDataForUpdate = customerOrderRuleData.value; 
        axios.post('/fetch-order-rule', { id: customerOrderRuleData.id, rule_id: this.customer_order_rule.order_rule_id, customer_id: this.customer_order_rule.customer_id })
          .then(res => {
              let ruleFormApprovers = res.data?.approvers ?? [];
              let ruleForminputs = res.data?.form ?? [];
              let ruleFormShipping = res.data?.ship_address ?? [];
              this.ruleForminputs = ruleForminputs;
              this.ruleFormApprovers = ruleFormApprovers;
            
              ruleData.forEach(obj=>{
                
                let formInput = ruleForminputs; 
                let approvers = obj.approvers;
                let defaultApprovers = [];
                approvers.forEach(approver=>{
                  let matchApprover = ruleFormApprovers.find(obj => obj.id === approver);
                  if(matchApprover.id){
                    defaultApprovers.push(matchApprover);
                  }
                }); 

                let defaultShipping = ruleFormShipping.find(shipObj => shipObj.ShipToName === obj.shipping_address);
                
                let updateData = formInput.map(formInput => {
                  let searchKey = formInput.name;
                  if (searchKey in obj) {
                    return { ...formInput, value: obj[searchKey]};
                  }
                  return formInput
                });
                this.rule_value_format.push({ form: updateData, approvers_list: this.ruleFormApprovers,shipping_list:ruleFormShipping, shipping_address: defaultShipping, approvers: defaultApprovers });
              })
          })
          .catch(error => {
              console.log(error);
          });
        }
    },
    created() {
    }
      
  }
</script>

<style scoped> 

</style>