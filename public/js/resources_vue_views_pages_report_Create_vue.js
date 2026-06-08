"use strict";
(self["webpackChunkbackend"] = self["webpackChunkbackend"] || []).push([["resources_vue_views_pages_report_Create_vue"],{

/***/ "../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/report/Create.vue?vue&type=script&lang=js":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/report/Create.vue?vue&type=script&lang=js ***!
  \******************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _FormFields__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./FormFields */ "./resources/vue/views/pages/report/FormFields.vue");

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "ReportCreate",
  components: {
    FormFields: _FormFields__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  props: ['entry', 'url', 'method', 'axios_url', 'save_action'],
  data: function data() {
    return {
      report_types: ['pie', 'column', 'line', 'bar', 'table'],
      sources: {
        'customer_orders': 'Order',
        'products': 'Product'
      },
      title: "",
      datasource: "",
      type: "",
      count_type: "",
      sum_by: "",
      take_range: "",
      columns: {},
      source_types: [],
      countTypes: {},
      sumBys: {},
      report: {
        reportConditions: [{
          group_type: "",
          conditionLists: [{
            column_name: "",
            operator: "",
            value: ""
          }]
        }],
        _save_action: ''
      },
      backUrl: '/admin/report',
      newUrl: '/admin/report/create',
      actionType: 'save_and_back',
      saveAction: JSON.parse(this.save_action)
    };
  },
  created: function created() {
    if (this.method === 'put') {
      this.initEdit();
    }
  },
  methods: {
    initEdit: function initEdit() {
      var entry = JSON.parse(this.entry);
      // this.report = entry;
      this.report.title = entry.title;
      this.report.type = entry.type;
      this.report.datasource = entry.datasource;
      if (entry.datasource === 'customer_orders') {
        this.source_types = {
          'order_type': "Order Type",
          'order_status': "Order Status",
          'approval_status': "Approval Status",
          'shipping_method': "Shipping Method"
        };
        this.countTypes = {
          'count': "Count",
          'sum': "Sum"
        };
      } else if (entry.datasource === 'products') {
        this.source_types = {
          'status': "Status",
          'is_new': "Is New",
          'top_product': "Top Product By Sales"
        };
        this.countTypes = {
          'count': "Count",
          'sum': "Sum"
        };
      }
      if (entry.source_type === 'top_product') {
        console.log('here');
        this.countTypes = {
          'count': "Count"
        };
        $(".dataParPageDiv").show();
      } else if (entry.source_type === 'order_type') {
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
    saveData: function saveData() {
      var _this = this;
      this.report._save_action = this.actionType;
      this.$refs.formFields.validationErrors = "";
      var params = _.cloneDeep(this.report);
      axios[this.method](this.axios_url, params).then(function (response) {
        new Noty({
          type: "success",
          text: 'Saved successfully'
        }).show();
        _this.$refs.formFields.validationErrors = "";
        window.location.href = "/admin/report";
      })["catch"](function (err) {
        _this.$refs.formFields.validationErrors = err.response.data.errors;
        new Noty({
          type: "error",
          text: err.response.data.message
        }).show();
        console.error(err);
      });
    }
  }
});

/***/ }),

/***/ "../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/report/FormFields.vue?vue&type=script&lang=js":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/report/FormFields.vue?vue&type=script&lang=js ***!
  \**********************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! lodash */ "../../node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _source_Condition_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./source/Condition.vue */ "./resources/vue/views/pages/report/source/Condition.vue");


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "FormFields",
  props: [],
  data: function data() {
    return {
      validationErrors: "",
      currentSource: "",
      whereTypes: []
    };
  },
  mounted: function mounted() {
    $(".sumByDiv").hide();
    $(".dataParPageDiv").hide();
  },
  components: {},
  methods: {
    capitalizeFirstLetter: function capitalizeFirstLetter(string) {
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
    changeSource: function changeSource() {
      if (this.$parent.report.datasource === 'customer_orders') {
        this.$parent.source_types = {
          'order_type': "Order Type",
          'order_status': "Order Status",
          'approval_status': "Approval Status",
          'shipping_method': "Shipping Method"
        };
        this.currentSource = "";
        this.$parent.sumBys = {
          'total_net_price': "Total Net Price",
          'total_amount': "Total Amount"
        };
        this.$parent.countTypes = {
          'count': "Count",
          'sum': "Sum"
        };
      } else if (this.$parent.report.datasource === 'products') {
        this.$parent.source_types = {
          'status': "Status",
          'is_new': "Is New",
          'top_product': "Top Product By Sales"
        };
        this.$parent.sumBys = {
          'selling_price': "Selling Price"
        };
        this.$parent.countTypes = {
          'count': "Count",
          'sum': "Sum"
        };
        this.currentSource = "";
      } else {
        this.$parent.source_types = [];
        this.currentSource = "";
      }
    },
    changeCountType: function changeCountType() {
      console.log(this.$parent.report.count_type);
      if (this.$parent.report.count_type === "sum") {
        $(".sumByDiv").show();
      } else {
        $(".sumByDiv").hide();
      }
    },
    changeSourceType: function changeSourceType() {
      console.log(this.$parent.report.source_type);
      if (this.$parent.report.source_type === 'top_product') {
        this.$parent.countTypes = {
          'count': "Count"
        };
        $(".dataParPageDiv").show();
      } else {
        this.$parent.countTypes = {
          'count': "Count",
          'sum': "Sum"
        };
        $(".dataParPageDiv").hide();
      }
      if (this.$parent.report.source_type === 'order_type') {
        this.$parent.report.reportConditions = [{
          group_type_name: "Order",
          group_type: 0,
          conditionLists: [{
            column_name: "",
            operator: "",
            value: ""
          }]
        }, {
          group_type_name: "RFQ",
          group_type: 1,
          conditionLists: [{
            column_name: "",
            operator: "",
            value: ""
          }]
        }];
        // this.whereTypes = {'Order': "Order",'RFQ': "RFQ"},
        this.$parent.columns = {
          'order_status': "Order Status",
          'approval_status': "Approval Status",
          'shipping_method': "Shipping Method",
          'total_amount': "Total Amount"
        };
        this.currentSource = _source_Condition_vue__WEBPACK_IMPORTED_MODULE_1__["default"];
      } else if (this.$parent.report.source_type === 'order_status') {
        this.$parent.report.reportConditions = [{
          group_type_name: "Pending",
          group_type: "Pending",
          conditionLists: [{
            column_name: "",
            operator: "",
            value: ""
          }]
        }, {
          group_type_name: "Approved",
          group_type: "Approved",
          conditionLists: [{
            column_name: "",
            operator: "",
            value: ""
          }]
        }, {
          group_type_name: "Complete",
          group_type: "Complete",
          conditionLists: [{
            column_name: "",
            operator: "",
            value: ""
          }]
        }, {
          group_type_name: "Submitted",
          group_type: "Submitted",
          conditionLists: [{
            column_name: "",
            operator: "",
            value: ""
          }]
        }, {
          group_type_name: "Rejected",
          group_type: "Rejected",
          conditionLists: [{
            column_name: "",
            operator: "",
            value: ""
          }]
        }, {
          group_type_name: "Processing",
          group_type: "Processing",
          conditionLists: [{
            column_name: "",
            operator: "",
            value: ""
          }]
        }, {
          group_type_name: "Draft",
          group_type: "Draft",
          conditionLists: [{
            column_name: "",
            operator: "",
            value: ""
          }]
        }, {
          group_type_name: "Payment Pending",
          group_type: "Payment Pending",
          conditionLists: [{
            column_name: "",
            operator: "",
            value: ""
          }]
        }];

        // this.whereTypes = {'Pending': "Pending",'Approved': "Approved",'Complete': "Complete",'Submitted': "Submitted",'Rejected': "Rejected",'Processing': "Processing",'Draft': "Draft",'Payment Pending': "Payment Pending"};
        this.currentSource = _source_Condition_vue__WEBPACK_IMPORTED_MODULE_1__["default"];
        this.$parent.columns = {
          'order_type': "Order Type",
          'approval_status': "Approval Status",
          'shipping_method': "Shipping Method",
          'total_amount': "Total Amount"
        };
      } else if (this.$parent.report.source_type === 'approval_status') {
        // this.whereTypes = {'pending': "Pending",'approved': "Approved"};
        this.$parent.report.reportConditions = [{
          group_type_name: "Pending",
          group_type: "pending",
          conditionLists: [{
            column_name: "",
            operator: "",
            value: ""
          }]
        }, {
          group_type_name: "Approved",
          group_type: "approved",
          conditionLists: [{
            column_name: "",
            operator: "",
            value: ""
          }]
        }];
        this.currentSource = _source_Condition_vue__WEBPACK_IMPORTED_MODULE_1__["default"];
        this.$parent.columns = {
          'order_type': "Order Type",
          'order_status': "Order Status",
          'shipping_method': "Shipping Method",
          'total_amount': "Total Amount"
        };
      } else if (this.$parent.report.source_type === 'shipping_method') {
        // this.whereTypes = {'WILL CALL': "WILL CALL",'NEXT DAY': "NEXT DAY",'DELIVERY': "DELIVERY",'UPS': "UPS"};
        this.$parent.report.reportConditions = [{
          group_type_name: "WILL CALL",
          group_type: "WILL CALL",
          conditionLists: [{
            column_name: "",
            operator: "",
            value: ""
          }]
        }, {
          group_type_name: "NEXT DAY",
          group_type: "NEXT DAY",
          conditionLists: [{
            column_name: "",
            operator: "",
            value: ""
          }]
        }, {
          group_type_name: "DELIVERY",
          group_type: "DELIVERY",
          conditionLists: [{
            column_name: "",
            operator: "",
            value: ""
          }]
        }, {
          group_type_name: "UPS",
          group_type: "UPS",
          conditionLists: [{
            column_name: "",
            operator: "",
            value: ""
          }]
        }];
        this.currentSource = _source_Condition_vue__WEBPACK_IMPORTED_MODULE_1__["default"];
        this.$parent.columns = {
          'order_type': "Order Type",
          'order_status': "Order Status",
          'approval_status': "Approval Status",
          'total_amount': "Total Amount"
        };
      } else if (this.$parent.report.source_type === 'status') {
        // this.whereTypes = {'published': "Published",'incomplete': "Incomplete",'draft': "Draft",'archived': "Archived"};
        this.$parent.report.reportConditions = [{
          group_type_name: "Published",
          group_type: "published",
          conditionLists: [{
            column_name: "",
            operator: "",
            value: ""
          }]
        }, {
          group_type_name: "Incomplete",
          group_type: "incomplete",
          conditionLists: [{
            column_name: "",
            operator: "",
            value: ""
          }]
        }, {
          group_type_name: "Draft",
          group_type: "draft",
          conditionLists: [{
            column_name: "",
            operator: "",
            value: ""
          }]
        }, {
          group_type_name: "Archived",
          group_type: "archived",
          conditionLists: [{
            column_name: "",
            operator: "",
            value: ""
          }]
        }];
        this.currentSource = _source_Condition_vue__WEBPACK_IMPORTED_MODULE_1__["default"];
        this.$parent.columns = {
          'selling_price': "Selling Price",
          'msrp': "MSRP",
          'is_new': "Is New"
        };
      } else if (this.$parent.report.source_type === 'is_new') {
        // this.whereTypes = {'Yes': "Yes",'No': "No"};
        this.$parent.report.reportConditions = [{
          group_type_name: "Yes",
          group_type: 1,
          conditionLists: [{
            column_name: "",
            operator: "",
            value: ""
          }]
        }, {
          group_type_name: "No",
          group_type: 0,
          conditionLists: [{
            column_name: "",
            operator: "",
            value: ""
          }]
        }];
        this.currentSource = _source_Condition_vue__WEBPACK_IMPORTED_MODULE_1__["default"];
        this.$parent.columns = {
          'status': "Status",
          'selling_price': "Selling Price",
          'msrp': "MSRP"
        };
        // this.$parent.columns ={ 'status': "Status", 'selling_price': "Selling Price", 'msrp': "MSRP",'published_at': "Published At", 'created_at': 'Created At' };
      } else {
        this.currentSource = "";
      }
    }
  }
});

/***/ }),

/***/ "../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/report/source/Condition.vue?vue&type=script&lang=js":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/report/source/Condition.vue?vue&type=script&lang=js ***!
  \****************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "Condition",
  data: function data() {
    return {
      // columns: { 'order_type': "Order Type", 'order_status': "Order Status", 'approval_status': "Approval Status", 'shipping_method': "Shipping Method", 'total_amount': "Total Amount", 'created_at': 'Created At' },
      operators: [{
        label: 'Equal',
        value: '=',
        accessBy: ['order_type', 'order_status', 'approval_status', 'customer_id', 'shipping_method', 'total_amount', 'created_at', 'status', 'selling_price', 'msrp', 'is_new', 'published_at', 'created_at']
        // accessBy: ['order_type', 'order_status', 'approval_status', 'customer_id', 'shipping_method', 'total_amount', 'created_at','status', 'selling_price', 'msrp', 'is_new', 'published_at', 'created_at']
      }, {
        label: 'Not Equal',
        value: '!=',
        accessBy: ['created_at']
      }, {
        label: 'Greater Than',
        value: '>',
        accessBy: ['total_amount', 'selling_price', 'msrp', 'created_at']
      }, {
        label: 'Less Than',
        value: '<',
        accessBy: ['total_amount', 'selling_price', 'msrp', 'created_at']
      }, {
        label: 'Greater Than Equal',
        value: '>=',
        accessBy: ['total_amount', 'selling_price', 'msrp', 'created_at']
      }, {
        label: 'Less Than Equal',
        value: '<=',
        accessBy: ['total_amount', 'selling_price', 'msrp', 'created_at']
      }],
      values: [
      // order_type start
      {
        label: 'Order',
        value: '0',
        accessBy: ['order_type']
      }, {
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
      }, {
        label: 'Approved',
        value: 'Approved',
        accessBy: ['order_status']
      }, {
        label: 'Complete',
        value: 'Complete',
        accessBy: ['order_status']
      }, {
        label: 'Submitted',
        value: 'Submitted',
        accessBy: ['order_status']
      }, {
        label: 'Rejected',
        value: 'Rejected',
        accessBy: ['order_status']
      }, {
        label: 'Processing',
        value: 'Processing',
        accessBy: ['order_status']
      }, {
        label: 'Draft',
        value: 'Draft',
        accessBy: ['order_status']
      }, {
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
      }, {
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
      }, {
        label: 'Flat Rate',
        value: 'Flat Rate',
        accessBy: ['shipping_method']
      }, {
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
      }, {
        label: '200',
        value: '200',
        accessBy: ['total_amount']
      }, {
        label: '300',
        value: '300',
        accessBy: ['total_amount']
      }, {
        label: '500',
        value: '500',
        accessBy: ['total_amount']
      }, {
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
      }, {
        label: 'Yesterday',
        value: 'yesterday',
        accessBy: ['created_at']
      }, {
        label: 'Last 7 Days',
        value: 'last_7_days',
        accessBy: ['created_at']
      }, {
        label: 'Last 30 Days',
        value: 'last_30_days',
        accessBy: ['created_at']
      }, {
        label: 'This Month',
        value: 'this_month',
        accessBy: ['created_at']
      }, {
        label: 'Last Month',
        value: 'last_month',
        accessBy: ['created_at']
      }, {
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
      }, {
        label: 'Incomplete',
        value: 'incomplete',
        accessBy: ['status']
      }, {
        label: 'Draft',
        value: 'draft',
        accessBy: ['status']
      }, {
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
      }, {
        label: '200',
        value: '200',
        accessBy: ['selling_price']
      }, {
        label: '300',
        value: '300',
        accessBy: ['selling_price']
      }, {
        label: '500',
        value: '500',
        accessBy: ['selling_price']
      }, {
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
      }, {
        label: '200',
        value: '200',
        accessBy: ['msrp']
      }, {
        label: '300',
        value: '300',
        accessBy: ['msrp']
      }, {
        label: '500',
        value: '500',
        accessBy: ['msrp']
      }, {
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
      }, {
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
      }, {
        label: 'Yesterday',
        value: 'yesterday',
        accessBy: ['published_at']
      }, {
        label: 'Last 7 Days',
        value: 'last_7_days',
        accessBy: ['published_at']
      }, {
        label: 'Last 30 Days',
        value: 'last_30_days',
        accessBy: ['published_at']
      }, {
        label: 'This Month',
        value: 'this_month',
        accessBy: ['published_at']
      }, {
        label: 'Last Month',
        value: 'last_month',
        accessBy: ['published_at']
      }, {
        label: 'Custom',
        value: 'custom',
        accessBy: ['published_at']
      }
      // published_at end
      ]
    };
  },
  methods: {
    addNewConditionCard: function addNewConditionCard(key) {
      this.$parent.$parent.report.reportConditions[key].conditionLists.push({
        column_name: "",
        operator: "",
        value: ""
      });
    },
    removeConditionCard: function removeConditionCard(index) {
      var length = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 1;
      var path = this.$parent.$parent.report.reportConditions.splice(index, length);
    },
    removeSingleConditionCard: function removeSingleConditionCard(key) {
      var length = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 1;
      var path = this.$parent.$parent.report.reportConditions[key].conditionLists.splice(key, length);
    }
  }
});

/***/ }),

/***/ "../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/report/Create.vue?vue&type=template&id=567a655a&scoped=true":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/report/Create.vue?vue&type=template&id=567a655a&scoped=true ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c('div', {
    staticClass: "row"
  }, [_c('div', {
    staticClass: "col-12"
  }, [_c('div', {
    staticClass: "card"
  }, [_c('div', {
    staticClass: "card-body"
  }, [_c('FormFields', {
    ref: "formFields"
  })], 1)]), _vm._v(" "), _c('div', {
    staticClass: "form-group",
    attrs: {
      "id": "saveActions"
    }
  }, [_c('input', {
    attrs: {
      "type": "hidden",
      "name": "save_action",
      "value": "save_and_back"
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "btn-group",
    attrs: {
      "role": "group"
    }
  }, [_c('button', {
    staticClass: "btn btn-success",
    attrs: {
      "type": "submit"
    }
  }, [_c('span', {
    staticClass: "la la-save",
    attrs: {
      "role": "presentation",
      "aria-hidden": "true"
    }
  }), _vm._v("  \n                    "), _c('span', {
    on: {
      "click": function click($event) {
        _vm.actionType = _vm.saveAction.active.value;
        _vm.saveData();
      }
    }
  }, [_vm._v(_vm._s(_vm.saveAction.active.label))])]), _vm._v(" "), _c('div', {
    staticClass: "btn-group",
    attrs: {
      "role": "group"
    }
  }, [_vm._m(0), _vm._v(" "), _c('div', {
    staticClass: "dropdown-menu",
    attrs: {
      "aria-labelledby": "btnGroupDrop1"
    }
  }, [_vm._l(_vm.saveAction.options, function (option, index) {
    return [_c('button', {
      staticClass: "dropdown-item",
      on: {
        "click": function click($event) {
          _vm.actionType = index;
          _vm.saveData();
        }
      }
    }, [_vm._v(_vm._s(option))])];
  })], 2)])]), _vm._v(" "), _c('a', {
    staticClass: "btn btn-default",
    attrs: {
      "href": _vm.backUrl
    }
  }, [_c('span', {
    staticClass: "la la-ban"
  }), _vm._v("  Cancel")])])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c('button', {
    staticClass: "btn btn-success dropdown-toggle",
    attrs: {
      "id": "btnGroupDrop1",
      "type": "button",
      "data-toggle": "dropdown",
      "aria-haspopup": "true",
      "aria-expanded": "false"
    }
  }, [_c('span', {
    staticClass: "caret"
  }), _c('span', {
    staticClass: "sr-only"
  }, [_vm._v("▼")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/report/FormFields.vue?vue&type=template&id=32c4e50a":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/report/FormFields.vue?vue&type=template&id=32c4e50a ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c('div', {
    staticClass: "row"
  }, [_c('div', {
    staticClass: "form-group col-6 required"
  }, [_vm._m(0), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.report.title,
      expression: "$parent.report.title"
    }],
    staticClass: "form-control",
    "class": {
      'is-invalid': _vm.validationErrors.title
    },
    attrs: {
      "type": "text",
      "name": "title"
    },
    domProps: {
      "value": _vm.$parent.report.title
    },
    on: {
      "input": function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.$parent.report, "title", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.validationErrors.title ? _c('small', {
    staticClass: "text-danger mt-3"
  }, [_vm._v(_vm._s(_vm.validationErrors.title[0]))]) : _vm._e()]), _vm._v(" "), _c('div', {
    staticClass: "form-group col-6 required"
  }, [_vm._m(1), _vm._v(" "), _c('select', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.report.type,
      expression: "$parent.report.type"
    }],
    staticClass: "form-control",
    "class": {
      'is-invalid': _vm.validationErrors.type
    },
    attrs: {
      "name": "type"
    },
    on: {
      "change": function change($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.$set(_vm.$parent.report, "type", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }
    }
  }, [_c('option', {
    attrs: {
      "value": ""
    }
  }, [_vm._v("Select Chart Type")]), _vm._v(" "), _vm._l(_vm.$parent.report_types, function (report_type, index) {
    return _c('option', {
      key: index,
      domProps: {
        "value": report_type
      }
    }, [_vm._v(_vm._s(_vm.capitalizeFirstLetter(report_type)))]);
  })], 2), _vm._v(" "), _vm.validationErrors.type ? _c('small', {
    staticClass: "text-danger mt-3"
  }, [_vm._v(_vm._s(_vm.validationErrors.type[0]))]) : _vm._e()]), _vm._v(" "), _c('div', {
    staticClass: "form-group col-6 required"
  }, [_c('label', [_vm._v("Prefix")]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.report.prefix,
      expression: "$parent.report.prefix"
    }],
    staticClass: "form-control",
    "class": {
      'is-invalid': _vm.validationErrors.prefix
    },
    attrs: {
      "type": "text",
      "name": "prefix"
    },
    domProps: {
      "value": _vm.$parent.report.prefix
    },
    on: {
      "input": function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.$parent.report, "prefix", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.validationErrors.prefix ? _c('small', {
    staticClass: "text-danger mt-3"
  }, [_vm._v(_vm._s(_vm.validationErrors.prefix[0]))]) : _vm._e()]), _vm._v(" "), _c('div', {
    staticClass: "form-group col-6 required"
  }, [_c('label', [_vm._v("Suffix")]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.report.suffix,
      expression: "$parent.report.suffix"
    }],
    staticClass: "form-control",
    "class": {
      'is-invalid': _vm.validationErrors.suffix
    },
    attrs: {
      "type": "text",
      "name": "suffix"
    },
    domProps: {
      "value": _vm.$parent.report.suffix
    },
    on: {
      "input": function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.$parent.report, "suffix", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.validationErrors.suffix ? _c('small', {
    staticClass: "text-danger mt-3"
  }, [_vm._v(_vm._s(_vm.validationErrors.suffix[0]))]) : _vm._e()]), _vm._v(" "), _c('div', {
    staticClass: "form-group col-3 required"
  }, [_vm._m(2), _vm._v(" "), _c('select', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.report.datasource,
      expression: "$parent.report.datasource"
    }],
    staticClass: "form-control",
    "class": {
      'is-invalid': _vm.validationErrors.datasource
    },
    attrs: {
      "name": "datasource"
    },
    on: {
      "change": [function ($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.$set(_vm.$parent.report, "datasource", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }, function ($event) {
        return _vm.changeSource();
      }]
    }
  }, [_c('option', {
    attrs: {
      "value": ""
    }
  }, [_vm._v("Select Source")]), _vm._v(" "), _vm._l(_vm.$parent.sources, function (source, index) {
    return _c('option', {
      key: index,
      domProps: {
        "value": index
      }
    }, [_vm._v(_vm._s(source))]);
  })], 2), _vm._v(" "), _vm.validationErrors.datasource ? _c('small', {
    staticClass: "text-danger mt-3"
  }, [_vm._v(_vm._s(_vm.validationErrors.datasource[0]))]) : _vm._e()]), _vm._v(" "), _c('div', {
    staticClass: "form-group col-3 required"
  }, [_vm._m(3), _vm._v(" "), _c('select', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.report.source_type,
      expression: "$parent.report.source_type"
    }],
    staticClass: "form-control",
    "class": {
      'is-invalid': _vm.validationErrors.source_type
    },
    attrs: {
      "name": "source_type"
    },
    on: {
      "change": [function ($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.$set(_vm.$parent.report, "source_type", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }, function ($event) {
        return _vm.changeSourceType();
      }]
    }
  }, [_c('option', {
    attrs: {
      "value": ""
    }
  }, [_vm._v("Select Group Type")]), _vm._v(" "), _vm._l(_vm.$parent.source_types, function (source_type, index) {
    return _c('option', {
      key: index,
      domProps: {
        "value": index
      }
    }, [_vm._v(_vm._s(_vm.capitalizeFirstLetter(source_type)))]);
  })], 2), _vm._v(" "), _vm.validationErrors.source_type ? _c('small', {
    staticClass: "text-danger mt-3"
  }, [_vm._v(_vm._s(_vm.validationErrors.source_type[0]))]) : _vm._e()]), _vm._v(" "), _c('div', {
    staticClass: "form-group col-12"
  }, [_c('label', {
    staticClass: "lead"
  }, [_vm._v("Conditions")]), _vm._v(" "), _c(_vm.currentSource, {
    tag: "component"
  })], 1), _vm._v(" "), _c('div', {
    staticClass: "form-group col-3"
  }, [_vm._m(4), _vm._v(" "), _c('select', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.report.count_type,
      expression: "$parent.report.count_type"
    }],
    staticClass: "form-control",
    "class": {
      'is-invalid': _vm.validationErrors.count_type
    },
    attrs: {
      "name": "count_type",
      "id": "count_type"
    },
    on: {
      "change": [function ($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.$set(_vm.$parent.report, "count_type", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }, function ($event) {
        return _vm.changeCountType();
      }]
    }
  }, [_c('option', {
    attrs: {
      "value": ""
    }
  }, [_vm._v("Select Aggregate")]), _vm._v(" "), _vm._l(_vm.$parent.countTypes, function (count_type, index) {
    return _c('option', {
      key: index,
      domProps: {
        "value": index
      }
    }, [_vm._v(_vm._s(count_type))]);
  })], 2), _vm._v(" "), _vm.validationErrors.count_type ? _c('small', {
    staticClass: "text-danger mt-3"
  }, [_vm._v(_vm._s(_vm.validationErrors.count_type[0]))]) : _vm._e()]), _vm._v(" "), _c('div', {
    staticClass: "form-group col-3 sumByDiv"
  }, [_vm._m(5), _vm._v(" "), _c('select', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.report.sum_by,
      expression: "$parent.report.sum_by"
    }],
    staticClass: "form-control",
    "class": {
      'is-invalid': _vm.validationErrors.sum_by
    },
    attrs: {
      "name": "sum_by",
      "id": "sum_by"
    },
    on: {
      "change": function change($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.$set(_vm.$parent.report, "sum_by", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }
    }
  }, [_c('option', {
    attrs: {
      "value": ""
    }
  }, [_vm._v("Select Sum By")]), _vm._v(" "), _vm._l(_vm.$parent.sumBys, function (sum_by, index) {
    return _c('option', {
      key: index,
      domProps: {
        "value": index
      }
    }, [_vm._v(_vm._s(sum_by))]);
  })], 2), _vm._v(" "), _vm.validationErrors.sum_by ? _c('small', {
    staticClass: "text-danger mt-3"
  }, [_vm._v(_vm._s(_vm.validationErrors.sum_by[0]))]) : _vm._e()]), _vm._v(" "), _c('div', {
    staticClass: "form-group col-2 dataParPageDiv"
  }, [_vm._m(6), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.$parent.report.take_range,
      expression: "$parent.report.take_range"
    }],
    staticClass: "form-control",
    "class": {
      'is-invalid': _vm.validationErrors.take_range
    },
    attrs: {
      "type": "number",
      "name": "take_range"
    },
    domProps: {
      "value": _vm.$parent.report.take_range
    },
    on: {
      "input": function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.$parent.report, "take_range", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.validationErrors.take_range ? _c('small', {
    staticClass: "text-danger mt-3"
  }, [_vm._v(_vm._s(_vm.validationErrors.take_range[0]))]) : _vm._e()])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c('label', [_vm._v("Title\n            "), _c('span', {
    staticClass: "text-danger font-weight-bold"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c('label', [_vm._v("Chart Type\n            "), _c('span', {
    staticClass: "text-danger font-weight-bold"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c('label', [_vm._v("Source\n            "), _c('span', {
    staticClass: "text-danger font-weight-bold"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c('label', [_vm._v("Group Type\n            "), _c('span', {
    staticClass: "text-danger font-weight-bold"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c('label', [_vm._v("Aggregate "), _c('span', {
    staticClass: "text-danger font-weight-bold"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c('label', [_vm._v("Sum By "), _c('span', {
    staticClass: "text-danger font-weight-bold"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c('label', [_vm._v("Take Range "), _c('span', {
    staticClass: "text-danger font-weight-bold"
  }, [_vm._v("*")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/report/source/Condition.vue?vue&type=template&id=78612745":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/report/source/Condition.vue?vue&type=template&id=78612745 ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c('section', {
    staticClass: "repeater"
  }, _vm._l(_vm.$parent.$parent.report.reportConditions, function (reportCondition, key) {
    return _c('div', {
      key: key,
      staticClass: "card bg-light card-body"
    }, [_c('div', {
      staticClass: "row"
    }, [_c('div', {
      staticClass: "form-group col-2"
    }, [_c('input', {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: reportCondition.group_type,
        expression: "reportCondition.group_type"
      }],
      attrs: {
        "type": "hidden"
      },
      domProps: {
        "value": reportCondition.group_type
      },
      on: {
        "input": function input($event) {
          if ($event.target.composing) return;
          _vm.$set(reportCondition, "group_type", $event.target.value);
        }
      }
    }), _vm._v(" "), _c('h4', [_vm._v(_vm._s(reportCondition.group_type_name))])]), _vm._v(" "), _c('div', {
      staticClass: "form-group col-8"
    }, _vm._l(reportCondition.conditionLists, function (condition, index) {
      return _c('div', {
        key: index,
        staticClass: "card bg-light card-body"
      }, [_c('div', {
        staticClass: "row"
      }, [_c('div', {
        staticClass: "form-group col-4"
      }, [_c('label', [_vm._v("Where Column")]), _vm._v(" "), _c('select', {
        directives: [{
          name: "model",
          rawName: "v-model",
          value: condition.column_name,
          expression: "condition.column_name"
        }],
        staticClass: "form-control",
        on: {
          "change": function change($event) {
            var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
              return o.selected;
            }).map(function (o) {
              var val = "_value" in o ? o._value : o.value;
              return val;
            });
            _vm.$set(condition, "column_name", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
          }
        }
      }, [_c('option', {
        attrs: {
          "value": ""
        }
      }, [_vm._v("Select Column")]), _vm._v(" "), _vm._l(_vm.$parent.$parent.columns, function (column, key) {
        return _c('option', {
          key: key,
          domProps: {
            "value": key
          }
        }, [_vm._v(_vm._s(column))]);
      })], 2)]), _vm._v(" "), _c('div', {
        staticClass: "form-group col-3"
      }, [_c('label', [_vm._v("Operator")]), _vm._v(" "), _c('select', {
        directives: [{
          name: "model",
          rawName: "v-model",
          value: condition.operator,
          expression: "condition.operator"
        }],
        staticClass: "form-control",
        on: {
          "change": function change($event) {
            var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
              return o.selected;
            }).map(function (o) {
              var val = "_value" in o ? o._value : o.value;
              return val;
            });
            _vm.$set(condition, "operator", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
          }
        }
      }, [_c('option', {
        attrs: {
          "value": ""
        }
      }, [_vm._v("Select operator")]), _vm._v(" "), _vm._l(_vm.operators.filter(function (operator) {
        return operator.accessBy.includes(condition.column_name);
      }), function (operator, key) {
        return _c('option', {
          key: key,
          domProps: {
            "value": operator.value
          }
        }, [_vm._v(_vm._s(operator.label))]);
      })], 2)]), _vm._v(" "), _c('div', {
        staticClass: "form-group col-4"
      }, [_c('label', {
        attrs: {
          "for": "value"
        }
      }, [_vm._v("Condition Value")]), _vm._v(" "), _c('select', {
        directives: [{
          name: "model",
          rawName: "v-model",
          value: condition.value,
          expression: "condition.value"
        }],
        staticClass: "form-control",
        attrs: {
          "id": "value-".concat(index)
        },
        on: {
          "change": function change($event) {
            var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
              return o.selected;
            }).map(function (o) {
              var val = "_value" in o ? o._value : o.value;
              return val;
            });
            _vm.$set(condition, "value", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
          }
        }
      }, [_c('option', {
        attrs: {
          "value": ""
        }
      }, [_vm._v("Select value")]), _vm._v(" "), _vm._l(_vm.values.filter(function (value) {
        return value.accessBy.includes(condition.column_name);
      }), function (value, key) {
        return _c('option', {
          key: key,
          domProps: {
            "value": value.value
          }
        }, [_vm._v(_vm._s(value.label))]);
      })], 2)]), _vm._v(" "), _c('button', {
        staticClass: "btn btn-danger",
        staticStyle: {
          "height": "35px"
        },
        attrs: {
          "type": "button"
        },
        on: {
          "click": function click($event) {
            return _vm.removeSingleConditionCard(key);
          }
        }
      }, [_vm._v(" X ")])])]);
    }), 0), _vm._v(" "), _c('a', {
      staticClass: "btn btn-outline-primary",
      staticStyle: {
        "height": "35px"
      },
      attrs: {
        "href": "javascript:void(0)"
      },
      on: {
        "click": function click($event) {
          return _vm.addNewConditionCard(key);
        }
      }
    }, [_vm._v(" + ")]), _vm._v(" "), _c('button', {
      staticClass: "btn btn-danger",
      staticStyle: {
        "height": "35px"
      },
      attrs: {
        "type": "button"
      },
      on: {
        "click": function click($event) {
          return _vm.removeConditionCard(_vm.index);
        }
      }
    }, [_vm._v("X")])])]);
  }), 0);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/vue/views/pages/report/Create.vue":
/*!*****************************************************!*\
  !*** ./resources/vue/views/pages/report/Create.vue ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Create_vue_vue_type_template_id_567a655a_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Create.vue?vue&type=template&id=567a655a&scoped=true */ "./resources/vue/views/pages/report/Create.vue?vue&type=template&id=567a655a&scoped=true");
/* harmony import */ var _Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Create.vue?vue&type=script&lang=js */ "./resources/vue/views/pages/report/Create.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "../../node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Create_vue_vue_type_template_id_567a655a_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render,
  _Create_vue_vue_type_template_id_567a655a_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "567a655a",
  null
  
)

/* hot reload */
if (false) // removed by dead control flow
{ var api; }
component.options.__file = "resources/vue/views/pages/report/Create.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/vue/views/pages/report/Create.vue?vue&type=script&lang=js":
/*!*****************************************************************************!*\
  !*** ./resources/vue/views/pages/report/Create.vue?vue&type=script&lang=js ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Create.vue?vue&type=script&lang=js */ "../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/report/Create.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/vue/views/pages/report/Create.vue?vue&type=template&id=567a655a&scoped=true":
/*!***********************************************************************************************!*\
  !*** ./resources/vue/views/pages/report/Create.vue?vue&type=template&id=567a655a&scoped=true ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_template_id_567a655a_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_template_id_567a655a_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_template_id_567a655a_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Create.vue?vue&type=template&id=567a655a&scoped=true */ "../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/report/Create.vue?vue&type=template&id=567a655a&scoped=true");


/***/ }),

/***/ "./resources/vue/views/pages/report/FormFields.vue":
/*!*********************************************************!*\
  !*** ./resources/vue/views/pages/report/FormFields.vue ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _FormFields_vue_vue_type_template_id_32c4e50a__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./FormFields.vue?vue&type=template&id=32c4e50a */ "./resources/vue/views/pages/report/FormFields.vue?vue&type=template&id=32c4e50a");
/* harmony import */ var _FormFields_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./FormFields.vue?vue&type=script&lang=js */ "./resources/vue/views/pages/report/FormFields.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "../../node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _FormFields_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _FormFields_vue_vue_type_template_id_32c4e50a__WEBPACK_IMPORTED_MODULE_0__.render,
  _FormFields_vue_vue_type_template_id_32c4e50a__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) // removed by dead control flow
{ var api; }
component.options.__file = "resources/vue/views/pages/report/FormFields.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/vue/views/pages/report/FormFields.vue?vue&type=script&lang=js":
/*!*********************************************************************************!*\
  !*** ./resources/vue/views/pages/report/FormFields.vue?vue&type=script&lang=js ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FormFields_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormFields.vue?vue&type=script&lang=js */ "../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/report/FormFields.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FormFields_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/vue/views/pages/report/FormFields.vue?vue&type=template&id=32c4e50a":
/*!***************************************************************************************!*\
  !*** ./resources/vue/views/pages/report/FormFields.vue?vue&type=template&id=32c4e50a ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FormFields_vue_vue_type_template_id_32c4e50a__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FormFields_vue_vue_type_template_id_32c4e50a__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FormFields_vue_vue_type_template_id_32c4e50a__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormFields.vue?vue&type=template&id=32c4e50a */ "../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/report/FormFields.vue?vue&type=template&id=32c4e50a");


/***/ }),

/***/ "./resources/vue/views/pages/report/source/Condition.vue":
/*!***************************************************************!*\
  !*** ./resources/vue/views/pages/report/source/Condition.vue ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Condition_vue_vue_type_template_id_78612745__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Condition.vue?vue&type=template&id=78612745 */ "./resources/vue/views/pages/report/source/Condition.vue?vue&type=template&id=78612745");
/* harmony import */ var _Condition_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Condition.vue?vue&type=script&lang=js */ "./resources/vue/views/pages/report/source/Condition.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "../../node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Condition_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Condition_vue_vue_type_template_id_78612745__WEBPACK_IMPORTED_MODULE_0__.render,
  _Condition_vue_vue_type_template_id_78612745__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) // removed by dead control flow
{ var api; }
component.options.__file = "resources/vue/views/pages/report/source/Condition.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/vue/views/pages/report/source/Condition.vue?vue&type=script&lang=js":
/*!***************************************************************************************!*\
  !*** ./resources/vue/views/pages/report/source/Condition.vue?vue&type=script&lang=js ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Condition_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Condition.vue?vue&type=script&lang=js */ "../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/report/source/Condition.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Condition_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/vue/views/pages/report/source/Condition.vue?vue&type=template&id=78612745":
/*!*********************************************************************************************!*\
  !*** ./resources/vue/views/pages/report/source/Condition.vue?vue&type=template&id=78612745 ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Condition_vue_vue_type_template_id_78612745__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Condition_vue_vue_type_template_id_78612745__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Condition_vue_vue_type_template_id_78612745__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Condition.vue?vue&type=template&id=78612745 */ "../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/report/source/Condition.vue?vue&type=template&id=78612745");


/***/ })

}]);