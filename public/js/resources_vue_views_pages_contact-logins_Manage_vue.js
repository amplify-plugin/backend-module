"use strict";
(self["webpackChunkbackend"] = self["webpackChunkbackend"] || []).push([["resources_vue_views_pages_contact-logins_Manage_vue"],{

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/contact-logins/Manage.vue?vue&type=script&lang=js":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/contact-logins/Manage.vue?vue&type=script&lang=js ***!
  \******************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-multiselect */ "./node_modules/vue-multiselect/dist/vue-multiselect.min.js");
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_multiselect__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "./node_modules/axios/lib/axios.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "ContactLoginManage",
  components: {
    Multiselect: (vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default())
  },
  props: ['contact', 'warehouses', 'permissions', 'save_action', 'axios_url', 'back_url'],
  data: function data() {
    return {
      validationErrors: {},
      contactModel: JSON.parse(this.contact),
      warehouseList: JSON.parse(this.warehouses),
      customerPermissionList: JSON.parse(this.permissions),
      customerRoleList: [],
      customerLoginsList: [],
      customerList: [],
      saveAction: JSON.parse(this.save_action),
      actionType: 'save_and_back'
    };
  },
  created: function created() {
    this.initEditLayout();
  },
  methods: {
    initEditLayout: function initEditLayout() {
      var _this = this;
      this.contactModel.contact_logins.map(function (item) {
        _this.customerLoginsList.push({
          contact_id: _this.contactModel.id,
          customer: item.customer,
          warehouse: _this.warehouseList.find(function (warehouse) {
            return warehouse.InternalId == item.warehouse_id;
          }),
          customer_address: item.customer_address,
          roles: _this.getInitialRolesById(item.roles, item.role_list),
          permissions: item.permissions.map(function (permission) {
            return String(permission);
          }),
          role_list: item.role_list
        });
      });
      if (this.customerLoginsList.length < 1) {
        this.addNewCustomer();
      }
    },
    getInitialRolesById: function getInitialRolesById(cur_roles, role_list) {
      var roles = [];
      cur_roles.map(function (role) {
        var role_item = role_list.find(function (item) {
          return item.id === role;
        });
        if (role_item) roles.push(role_item);
      });
      return roles;
    },
    addNewCustomer: function addNewCustomer() {
      this.customerLoginsList.push({
        contact_id: this.contactModel.id,
        customer: null,
        warehouse: null,
        customer_address: {},
        roles: [],
        permissions: [],
        role_list: []
      });
    },
    removeCustomer: function removeCustomer(index) {
      this.customerLoginsList.splice(index, 1);
    },
    changeCustomer: function changeCustomer(index) {
      var _this2 = this;
      return _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              _this2.customerLoginsList[index].warehouse = null;
              _this2.customerLoginsList[index].customer_address = {};
              _context.next = 4;
              return _this2.verifyAssignableContact(index);
            case 4:
              _this2.fetchRoles(index);
            case 5:
            case "end":
              return _context.stop();
          }
        }, _callee);
      }))();
    },
    fetchAssignableCustomers: function fetchAssignableCustomers(query) {
      var _this3 = this;
      var cus_exld = [];
      this.customerLoginsList.forEach(function (item) {
        var _item$customer;
        if (item.customer) cus_exld.push((_item$customer = item.customer) === null || _item$customer === void 0 ? void 0 : _item$customer.id);
      });
      axios__WEBPACK_IMPORTED_MODULE_1__["default"].post("/contact-logins/fetch-assignable-customer?q=".concat(query), {
        cus_exld: cus_exld
      }).then(function (response) {
        _this3.customerList = response.data.data;
      })["catch"](function (err) {
        _this3.clearCustomersList();
      });
    },
    verifyAssignableContact: function verifyAssignableContact(index) {
      var _this4 = this;
      return _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        var loginContact;
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              loginContact = _this4.customerLoginsList[index];
              if (!loginContact.customer) {
                _context2.next = 4;
                break;
              }
              _context2.next = 4;
              return axios__WEBPACK_IMPORTED_MODULE_1__["default"].post("/contact-logins/verify-assignable-contact", {
                contact_email: _this4.contactModel.email,
                customer_id: loginContact.customer.id
              }).then(function (response) {
                if (!response.data.status) {
                  loginContact.customer = null;
                  ShowNotification('error', 'Contact Logins', response.data.message);
                } else {
                  _this4.setDefaultValues(response.data, index);
                }
              })["catch"](function (err) {
                _this4.clearCustomersList();
              });
            case 4:
            case "end":
              return _context2.stop();
          }
        }, _callee2);
      }))();
    },
    fetchRoles: function fetchRoles(index) {
      var loginContact = this.customerLoginsList[index];
      if (loginContact.customer) {
        loginContact.role_list = [];
        axios__WEBPACK_IMPORTED_MODULE_1__["default"].post("/contact-logins/get-roles", {
          customer_id: loginContact.customer.id
        }).then(function (response) {
          loginContact.role_list = response.data;
        });
      }
    },
    setDefaultValues: function setDefaultValues(data, index) {
      var loginContact = this.customerLoginsList[index];
      loginContact.warehouse = this.warehouseList.find(function (warehouse) {
        return warehouse.InternalId == data.warehouse_id;
      });
      loginContact.customer_address = data.customer_address;
    },
    clearCustomersList: function clearCustomersList() {
      this.customerList = [];
    },
    changedByType: function changedByType(key, contactKey) {
      var is_checked = this.$refs[key + "-" + contactKey][0].checked;
      var permissions = this.customerLoginsList[contactKey].permissions;
      for (var id in this.customerPermissionList[key]) {
        var index_of_item = permissions.indexOf(id);
        if (is_checked) {
          if (index_of_item === -1) permissions.push(id);
        } else {
          if (index_of_item !== -1) permissions.splice(index_of_item, 1);
        }
      }
    },
    saveData: function saveData(actionType) {
      var _this5 = this;
      var customer_order_rule = {
        _save_action: actionType,
        login_customers: this.customerLoginsList.map(function (item) {
          var _item$customer2, _item$warehouse, _item$customer_addres;
          return {
            contact_id: item.contact_id,
            customer_id: (_item$customer2 = item.customer) === null || _item$customer2 === void 0 ? void 0 : _item$customer2.id,
            warehouse_id: (_item$warehouse = item.warehouse) === null || _item$warehouse === void 0 ? void 0 : _item$warehouse.InternalId,
            customer_address_id: (_item$customer_addres = item.customer_address) === null || _item$customer_addres === void 0 ? void 0 : _item$customer_addres.id,
            roles: item.roles.map(function (role) {
              return role.id;
            }),
            permissions: item.permissions
          };
        })
      };
      axios__WEBPACK_IMPORTED_MODULE_1__["default"].post("".concat(this.axios_url), customer_order_rule).then(function (response) {
        ShowNotification('success', 'Contact Login', response.data.message);
        window.location.href = _this5.back_url;
      })["catch"](function (err) {
        _this5.validationErrors = err.response.data.errors;
        ShowNotification('error', 'Contact Login', err.response.data.message);
      });
    },
    humanizeLabel: function humanizeLabel(label) {
      label = label.toString().replace(/([\-_])/g, ' ');
      return label[0].toUpperCase() + label.substring(1, label.length);
    }
  },
  watch: {
    customerLoginsList: {
      handler: function handler(loginList) {
        var _this6 = this;
        var per_list = this.customerPermissionList;
        loginList.map(function (login_item, key) {
          for (var per_name in per_list) {
            var is_active = true;
            for (var code in per_list[per_name]) {
              if (login_item.permissions.indexOf(code) === -1) {
                is_active = false;
                break;
              }
            }
            if (_this6.$refs[per_name + "-" + key]) {
              _this6.$refs[per_name + "-" + key][0].checked = is_active;
            }
          }
        });
      },
      deep: true
    }
  }
});

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/contact-logins/Manage.vue?vue&type=template&id=37834720&scoped=true":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/contact-logins/Manage.vue?vue&type=template&id=37834720&scoped=true ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm$contactModel$name, _vm$contactModel$emai, _vm$saveAction$active, _vm$saveAction$active2;
  var _vm = this,
    _c = _vm._self._c;
  return _c("form", {
    attrs: {
      method: "post"
    },
    on: {
      submit: function submit($event) {
        $event.preventDefault();
      }
    }
  }, [_c("div", {
    staticClass: "card"
  }, [_c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-md-6"
  }, [_c("div", {
    staticClass: "form-group"
  }, [_c("label", [_vm._v("\n                            Name\n                        ")]), _vm._v(" "), _c("p", {
    staticClass: "border rounded py-2 px-3"
  }, [_vm._v(_vm._s((_vm$contactModel$name = _vm.contactModel.name) !== null && _vm$contactModel$name !== void 0 ? _vm$contactModel$name : ""))])])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-6"
  }, [_c("div", {
    staticClass: "form-group"
  }, [_c("label", [_vm._v("\n                            Email\n                        ")]), _vm._v(" "), _c("p", {
    staticClass: "border rounded py-2 px-3"
  }, [_vm._v(_vm._s((_vm$contactModel$emai = _vm.contactModel.email) !== null && _vm$contactModel$emai !== void 0 ? _vm$contactModel$emai : ""))])])])]), _vm._v(" "), _c("label", {
    staticClass: "font-weight-bold d-block"
  }, [_vm._v("Assigned Customers")]), _vm._v(" "), _vm._l(_vm.customerLoginsList, function (loginContact, contactKey) {
    var _loginContact$custome, _loginContact$custome2, _loginContact$custome3, _loginContact$custome4;
    return _c("div", {
      key: contactKey,
      staticClass: "border rounded pl-4 pr-3 py-2 my-2 position-relative",
      style: {
        backgroundColor: _vm.contactModel.customer_id != ((_loginContact$custome = loginContact.customer) === null || _loginContact$custome === void 0 ? void 0 : _loginContact$custome.id) ? "#f5f5f5" : "rgb(111 178 230 / 31%)"
      }
    }, [_c("div", {
      staticClass: "row"
    }, [_c("div", {
      staticClass: "col-12"
    }, [_c("div", {
      staticClass: "form-group"
    }, [_vm._m(0, true), _vm._v(" "), _c("multiselect", {
      attrs: {
        options: _vm.customerList,
        multiple: false,
        searchable: true,
        internalSearch: false,
        "close-on-select": true,
        disabled: _vm.contactModel.customer_id == ((_loginContact$custome2 = loginContact.customer) === null || _loginContact$custome2 === void 0 ? void 0 : _loginContact$custome2.id),
        trackBy: "id",
        label: "customer_name",
        placeholder: "Type Customer name"
      },
      on: {
        "search-change": _vm.fetchAssignableCustomers,
        input: function input($event) {
          return _vm.changeCustomer(contactKey);
        }
      },
      model: {
        value: loginContact.customer,
        callback: function callback($$v) {
          _vm.$set(loginContact, "customer", $$v);
        },
        expression: "loginContact.customer"
      }
    })], 1)]), _vm._v(" "), _c("div", {
      staticClass: "col-md-6"
    }, [_c("div", {
      staticClass: "form-group"
    }, [_vm._m(1, true), _vm._v(" "), _c("multiselect", {
      attrs: {
        options: _vm.warehouseList,
        multiple: false,
        "close-on-select": true,
        "clear-on-select": false,
        disabled: true,
        placeholder: "Selct an default warehouse",
        "track-by": "InternalId",
        label: "WarehouseName"
      },
      model: {
        value: loginContact.warehouse,
        callback: function callback($$v) {
          _vm.$set(loginContact, "warehouse", $$v);
        },
        expression: "loginContact.warehouse"
      }
    })], 1)]), _vm._v(" "), _c("div", {
      staticClass: "col-md-6"
    }, [_c("div", {
      staticClass: "form-group"
    }, [_vm._m(2, true), _vm._v(" "), _c("input", {
      staticClass: "form-control",
      attrs: {
        disabled: true
      },
      domProps: {
        value: (_loginContact$custome3 = loginContact.customer_address) === null || _loginContact$custome3 === void 0 ? void 0 : _loginContact$custome3.address_code
      }
    })])]), _vm._v(" "), _c("div", {
      staticClass: "col-12"
    }, [_c("div", {
      staticClass: "form-group"
    }, [_c("label", {
      staticClass: "font-weight-bold"
    }, [_vm._v("Current Role(s)")]), _vm._v(" "), _c("multiselect", {
      attrs: {
        options: loginContact.role_list,
        multiple: true,
        "close-on-select": true,
        "clear-on-select": false,
        placeholder: "Selct an default ship to address",
        "track-by": "id",
        label: "name"
      },
      model: {
        value: loginContact.roles,
        callback: function callback($$v) {
          _vm.$set(loginContact, "roles", $$v);
        },
        expression: "loginContact.roles"
      }
    })], 1)]), _vm._v(" "), _c("div", {
      staticClass: "col-12"
    }, [_c("div", {
      staticClass: "form-group"
    }, [_vm._m(3, true), _vm._v(" "), _c("div", {
      staticClass: "row mr-1",
      staticStyle: {
        "max-height": "60vh",
        "overflow-y": "scroll"
      },
      attrs: {
        id: "checklist"
      }
    }, [_c("div", {
      staticClass: "col-12"
    }, _vm._l(_vm.customerPermissionList, function (permissionItems, key) {
      return _c("div", {
        key: key,
        staticClass: "card mb-2"
      }, [_c("div", {
        staticClass: "card-header py-2 px-3 bg-white"
      }, [_c("div", {
        staticClass: "d-flex justify-content-between"
      }, [_c("div", {
        staticClass: "form-check"
      }, [_c("label", {
        staticClass: "form-check-label font-weight-bold mb-0"
      }, [_c("input", {
        ref: key + "-" + contactKey,
        refInFor: true,
        staticClass: "form-check-input pmsn-title",
        attrs: {
          type: "checkbox"
        },
        on: {
          change: function change($event) {
            return _vm.changedByType(key, contactKey);
          }
        }
      }), _vm._v("\n                                                        " + _vm._s(_vm.humanizeLabel(key)) + "\n                                                    ")])]), _vm._v(" "), _c("a", {
        staticClass: "text-dark collapsed text-decoration-none",
        attrs: {
          href: "javascript:void(0);",
          "data-toggle": "collapse",
          "data-target": "#collapse-".concat(key),
          "aria-expanded": "false",
          "aria-controls": "collapse-".concat(key)
        }
      }, [_c("i", {
        staticClass: "pe-7s-angle-down",
        staticStyle: {
          "font-weight": "600",
          "font-size": "1.2rem"
        }
      })])]), _vm._v(" "), _c("div", {
        staticClass: "collapse",
        attrs: {
          id: "collapse-".concat(key)
        }
      }, [_c("div", {
        staticClass: "card-body row px-0 py-2"
      }, _vm._l(permissionItems, function (permission, index) {
        return _c("div", {
          key: index,
          staticClass: "col-lg-3 col-md-4 col-sm-6 col-xs-12 my-1"
        }, [_c("div", {
          staticClass: "form-check"
        }, [_c("label", {
          staticClass: "form-check-label"
        }, [_c("input", {
          directives: [{
            name: "model",
            rawName: "v-model",
            value: loginContact.permissions,
            expression: "loginContact.permissions"
          }],
          staticClass: "pmsn form-check-input address",
          "class": key,
          attrs: {
            type: "checkbox"
          },
          domProps: {
            value: index,
            checked: Array.isArray(loginContact.permissions) ? _vm._i(loginContact.permissions, index) > -1 : loginContact.permissions
          },
          on: {
            change: function change($event) {
              var $$a = loginContact.permissions,
                $$el = $event.target,
                $$c = $$el.checked ? true : false;
              if (Array.isArray($$a)) {
                var $$v = index,
                  $$i = _vm._i($$a, $$v);
                if ($$el.checked) {
                  $$i < 0 && _vm.$set(loginContact, "permissions", $$a.concat([$$v]));
                } else {
                  $$i > -1 && _vm.$set(loginContact, "permissions", $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
                }
              } else {
                _vm.$set(loginContact, "permissions", $$c);
              }
            }
          }
        }), _vm._v("\n                                                                " + _vm._s(permission.label) + "\n                                                            ")])])]);
      }), 0)])])]);
    }), 0)])])])]), _vm._v(" "), _c("button", {
      directives: [{
        name: "show",
        rawName: "v-show",
        value: _vm.contactModel.customer_id != ((_loginContact$custome4 = loginContact.customer) === null || _loginContact$custome4 === void 0 ? void 0 : _loginContact$custome4.id),
        expression: "contactModel.customer_id != loginContact.customer?.id"
      }],
      staticClass: "btn btn-default rounded-circle p-0 m-0 border font-weight-bold",
      staticStyle: {
        position: "absolute",
        width: "40px",
        height: "40px",
        left: "-20px",
        top: "75px",
        "z-index": "10"
      },
      on: {
        click: function click($event) {
          return _vm.removeCustomer(contactKey);
        }
      }
    }, [_vm._v("x\n                ")])]);
  }), _vm._v(" "), _c("button", {
    staticClass: "btn-outline-primary btn btn-sm text-capitalize",
    on: {
      click: _vm.addNewCustomer
    }
  }, [_vm._v("\n                + Add Customer\n            ")])], 2)]), _vm._v(" "), _c("div", {
    staticClass: "form-group",
    attrs: {
      id: "saveActions"
    }
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.actionType,
      expression: "actionType"
    }],
    attrs: {
      type: "hidden",
      name: "save_action",
      value: "save_and_back"
    },
    domProps: {
      value: _vm.actionType
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.actionType = $event.target.value;
      }
    }
  }), _vm._v(" "), _c("div", {
    staticClass: "btn-group",
    attrs: {
      role: "group"
    }
  }, [_c("button", {
    "class": {
      "btn btn-success": true,
      rounded: true
    },
    attrs: {
      type: "button"
    },
    on: {
      click: function click($event) {
        _vm.actionType = _vm.saveAction.active.value;
        _vm.saveData(_vm.saveAction.active.value);
      }
    }
  }, [_c("span", {
    staticClass: "la la-save",
    attrs: {
      role: "presentation",
      "aria-hidden": "true"
    }
  }), _vm._v("  \n                "), _c("span", [_vm._v(_vm._s((_vm$saveAction$active = (_vm$saveAction$active2 = _vm.saveAction.active) === null || _vm$saveAction$active2 === void 0 ? void 0 : _vm$saveAction$active2.label) !== null && _vm$saveAction$active !== void 0 ? _vm$saveAction$active : ""))])]), _vm._v(" "), _c("div", {
    "class": {
      "btn-group": true,
      "mt-0": true,
      "d-none": true
    },
    attrs: {
      role: "group"
    }
  }, [_c("button", {
    staticClass: "btn btn-success dropdown-toggle",
    attrs: {
      id: "bpSaveButtonsGroup",
      type: "button",
      "data-toggle": "dropdown",
      "aria-haspopup": "true",
      "aria-expanded": "false"
    }
  }, [_c("span", {
    "class": {
      caret: true,
      "d-none": true
    }
  }), _vm._v(" "), _c("span", {
    "class": {
      "sr-only": true,
      "d-none": true
    }
  }, [_vm._v("▼")])]), _vm._v(" "), _c("div", {
    staticClass: "dropdown-menu",
    attrs: {
      "aria-labelledby": "bpSaveButtonsGroup"
    }
  }, _vm._l(_vm.saveAction.options, function (option, k, index) {
    return _c("button", {
      key: "actionType-" + index,
      staticClass: "dropdown-item",
      attrs: {
        type: "button"
      },
      on: {
        click: function click($event) {
          return _vm.saveData(k);
        }
      }
    }, [_vm._v("\n                        " + _vm._s(option) + "\n                    ")]);
  }), 0)])]), _vm._v(" "), _c("a", {
    staticClass: "btn btn-default",
    attrs: {
      href: _vm.back_url
    }
  }, [_c("span", {
    staticClass: "la la-ban"
  }), _vm._v("  Cancel ")])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    staticClass: "font-weight-bold"
  }, [_vm._v("Customer"), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    staticClass: "font-weight-bold"
  }, [_vm._v("Warehouse"), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    staticClass: "font-weight-bold"
  }, [_vm._v("Default ShipTo"), _c("span", {
    staticClass: "text-danger"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "d-flex justify-content-between"
  }, [_c("label", {
    staticClass: "font-weight-bold"
  }, [_vm._v("Permissions")]), _vm._v(" "), _c("a", {
    staticClass: "my-2 font-weight-bold collapsed text-decoration-none",
    attrs: {
      href: "javascript:void(0);",
      type: "button",
      "data-toggle": "collapse",
      "data-target": ".collapse",
      "aria-expanded": "false"
    }
  }, [_c("span", {
    attrs: {
      "data-toggle": "tooltip",
      "data-placement": "top",
      title: "Expand/Collapse"
    }
  }, [_c("i", {
    staticClass: "pe-7s-angle-down",
    staticStyle: {
      "font-weight": "600",
      "font-size": "1.5rem"
    }
  }), _vm._v(" "), _c("i", {
    staticClass: "pe-7s-angle-up",
    staticStyle: {
      "font-weight": "600",
      "font-size": "1.5rem"
    }
  })])])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/vue/views/pages/contact-logins/Manage.vue":
/*!*************************************************************!*\
  !*** ./resources/vue/views/pages/contact-logins/Manage.vue ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Manage_vue_vue_type_template_id_37834720_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Manage.vue?vue&type=template&id=37834720&scoped=true */ "./resources/vue/views/pages/contact-logins/Manage.vue?vue&type=template&id=37834720&scoped=true");
/* harmony import */ var _Manage_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Manage.vue?vue&type=script&lang=js */ "./resources/vue/views/pages/contact-logins/Manage.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Manage_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Manage_vue_vue_type_template_id_37834720_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render,
  _Manage_vue_vue_type_template_id_37834720_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "37834720",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/vue/views/pages/contact-logins/Manage.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/vue/views/pages/contact-logins/Manage.vue?vue&type=script&lang=js":
/*!*************************************************************************************!*\
  !*** ./resources/vue/views/pages/contact-logins/Manage.vue?vue&type=script&lang=js ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Manage_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Manage.vue?vue&type=script&lang=js */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/contact-logins/Manage.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Manage_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/vue/views/pages/contact-logins/Manage.vue?vue&type=template&id=37834720&scoped=true":
/*!*******************************************************************************************************!*\
  !*** ./resources/vue/views/pages/contact-logins/Manage.vue?vue&type=template&id=37834720&scoped=true ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Manage_vue_vue_type_template_id_37834720_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Manage_vue_vue_type_template_id_37834720_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Manage_vue_vue_type_template_id_37834720_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Manage.vue?vue&type=template&id=37834720&scoped=true */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/contact-logins/Manage.vue?vue&type=template&id=37834720&scoped=true");


/***/ })

}]);