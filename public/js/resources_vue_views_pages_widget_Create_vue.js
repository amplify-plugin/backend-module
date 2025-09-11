(self["webpackChunkbackend"] = self["webpackChunkbackend"] || []).push([["resources_vue_views_pages_widget_Create_vue"],{

/***/ "./node_modules/@riophae/vue-treeselect/dist/vue-treeselect.cjs.js":
/*!*************************************************************************!*\
  !*** ./node_modules/@riophae/vue-treeselect/dist/vue-treeselect.cjs.js ***!
  \*************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

/*!
 * vue-treeselect v0.4.0 | (c) 2017-2019 Riophae Lee
 * Released under the MIT License.
 * https://vue-treeselect.js.org/
 */
module.exports =
/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __nested_webpack_require_317__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __nested_webpack_require_317__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__nested_webpack_require_317__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__nested_webpack_require_317__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__nested_webpack_require_317__.d = function(exports, name, getter) {
/******/ 		if(!__nested_webpack_require_317__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__nested_webpack_require_317__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__nested_webpack_require_317__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __nested_webpack_require_317__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__nested_webpack_require_317__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __nested_webpack_require_317__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__nested_webpack_require_317__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__nested_webpack_require_317__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__nested_webpack_require_317__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__nested_webpack_require_317__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __nested_webpack_require_317__(__nested_webpack_require_317__.s = 16);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

module.exports = __webpack_require__(/*! @babel/runtime/helpers/slicedToArray */ "./node_modules/@babel/runtime/helpers/slicedToArray.js");

/***/ }),
/* 1 */
/***/ (function(module, exports) {

module.exports = __webpack_require__(/*! @babel/runtime/helpers/toConsumableArray */ "./node_modules/@babel/runtime/helpers/toConsumableArray.js");

/***/ }),
/* 2 */
/***/ (function(module, exports) {

module.exports = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/defineProperty.js");

/***/ }),
/* 3 */
/***/ (function(module, exports) {

module.exports = __webpack_require__(/*! fuzzysearch */ "./node_modules/fuzzysearch/index.js");

/***/ }),
/* 4 */
/***/ (function(module, exports) {

module.exports = __webpack_require__(/*! lodash/noop */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/noop.js");

/***/ }),
/* 5 */
/***/ (function(module, exports) {

module.exports = __webpack_require__(/*! lodash/debounce */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/debounce.js");

/***/ }),
/* 6 */
/***/ (function(module, exports) {

module.exports = __webpack_require__(/*! watch-size */ "./node_modules/watch-size/index.es.mjs");

/***/ }),
/* 7 */
/***/ (function(module, exports) {

module.exports = __webpack_require__(/*! is-promise */ "./node_modules/is-promise/index.js");

/***/ }),
/* 8 */
/***/ (function(module, exports) {

module.exports = __webpack_require__(/*! lodash/once */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/once.js");

/***/ }),
/* 9 */
/***/ (function(module, exports) {

module.exports = __webpack_require__(/*! lodash/identity */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/identity.js");

/***/ }),
/* 10 */
/***/ (function(module, exports) {

module.exports = __webpack_require__(/*! lodash/constant */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/constant.js");

/***/ }),
/* 11 */
/***/ (function(module, exports) {

module.exports = __webpack_require__(/*! @babel/runtime/helpers/typeof */ "./node_modules/@babel/runtime/helpers/typeof.js");

/***/ }),
/* 12 */
/***/ (function(module, exports) {

module.exports = __webpack_require__(/*! lodash/last */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/last.js");

/***/ }),
/* 13 */
/***/ (function(module, exports) {

module.exports = __webpack_require__(/*! babel-helper-vue-jsx-merge-props */ "./node_modules/babel-helper-vue-jsx-merge-props/index.js");

/***/ }),
/* 14 */
/***/ (function(module, exports) {

module.exports = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");

/***/ }),
/* 15 */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ }),
/* 16 */
/***/ (function(module, __nested_webpack_exports__, __nested_webpack_require_5479__) {

"use strict";
__nested_webpack_require_5479__.r(__nested_webpack_exports__);

// EXTERNAL MODULE: external "@babel/runtime/helpers/slicedToArray"
var slicedToArray_ = __nested_webpack_require_5479__(0);
var slicedToArray_default = /*#__PURE__*/__nested_webpack_require_5479__.n(slicedToArray_);

// EXTERNAL MODULE: external "@babel/runtime/helpers/toConsumableArray"
var toConsumableArray_ = __nested_webpack_require_5479__(1);
var toConsumableArray_default = /*#__PURE__*/__nested_webpack_require_5479__.n(toConsumableArray_);

// EXTERNAL MODULE: external "@babel/runtime/helpers/defineProperty"
var defineProperty_ = __nested_webpack_require_5479__(2);
var defineProperty_default = /*#__PURE__*/__nested_webpack_require_5479__.n(defineProperty_);

// EXTERNAL MODULE: external "fuzzysearch"
var external_fuzzysearch_ = __nested_webpack_require_5479__(3);
var external_fuzzysearch_default = /*#__PURE__*/__nested_webpack_require_5479__.n(external_fuzzysearch_);

// EXTERNAL MODULE: external "lodash/noop"
var noop_ = __nested_webpack_require_5479__(4);
var noop_default = /*#__PURE__*/__nested_webpack_require_5479__.n(noop_);

// CONCATENATED MODULE: ./src/utils/noop.js

// CONCATENATED MODULE: ./src/utils/warning.js


var warning_warning =  false ? 0 : function warning(checker, complainer) {
  if (!checker()) {
    var _console;

    var message = ['[Vue-Treeselect Warning]'].concat(complainer());

    (_console = console).error.apply(_console, toConsumableArray_default()(message));
  }
};
// CONCATENATED MODULE: ./src/utils/onLeftClick.js
function onLeftClick(mouseDownHandler) {
  return function onMouseDown(evt) {
    if (evt.type === 'mousedown' && evt.button === 0) {
      for (var _len = arguments.length, args = new Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
        args[_key - 1] = arguments[_key];
      }

      mouseDownHandler.call.apply(mouseDownHandler, [this, evt].concat(args));
    }
  };
}
// CONCATENATED MODULE: ./src/utils/scrollIntoView.js
function scrollIntoView($scrollingEl, $focusedEl) {
  var scrollingReact = $scrollingEl.getBoundingClientRect();
  var focusedRect = $focusedEl.getBoundingClientRect();
  var overScroll = $focusedEl.offsetHeight / 3;

  if (focusedRect.bottom + overScroll > scrollingReact.bottom) {
    $scrollingEl.scrollTop = Math.min($focusedEl.offsetTop + $focusedEl.clientHeight - $scrollingEl.offsetHeight + overScroll, $scrollingEl.scrollHeight);
  } else if (focusedRect.top - overScroll < scrollingReact.top) {
    $scrollingEl.scrollTop = Math.max($focusedEl.offsetTop - overScroll, 0);
  }
}
// EXTERNAL MODULE: external "lodash/debounce"
var debounce_ = __nested_webpack_require_5479__(5);
var debounce_default = /*#__PURE__*/__nested_webpack_require_5479__.n(debounce_);

// CONCATENATED MODULE: ./src/utils/debounce.js

// EXTERNAL MODULE: external "watch-size"
var external_watch_size_ = __nested_webpack_require_5479__(6);
var external_watch_size_default = /*#__PURE__*/__nested_webpack_require_5479__.n(external_watch_size_);

// CONCATENATED MODULE: ./src/utils/removeFromArray.js
function removeFromArray(arr, elem) {
  var idx = arr.indexOf(elem);
  if (idx !== -1) arr.splice(idx, 1);
}
// CONCATENATED MODULE: ./src/utils/watchSize.js


var intervalId;
var registered = [];
var INTERVAL_DURATION = 100;

function run() {
  intervalId = setInterval(function () {
    registered.forEach(test);
  }, INTERVAL_DURATION);
}

function stop() {
  clearInterval(intervalId);
  intervalId = null;
}

function test(item) {
  var $el = item.$el,
      listener = item.listener,
      lastWidth = item.lastWidth,
      lastHeight = item.lastHeight;
  var width = $el.offsetWidth;
  var height = $el.offsetHeight;

  if (lastWidth !== width || lastHeight !== height) {
    item.lastWidth = width;
    item.lastHeight = height;
    listener({
      width: width,
      height: height
    });
  }
}

function watchSizeForIE9($el, listener) {
  var item = {
    $el: $el,
    listener: listener,
    lastWidth: null,
    lastHeight: null
  };

  var unwatch = function unwatch() {
    removeFromArray(registered, item);
    if (!registered.length) stop();
  };

  registered.push(item);
  test(item);
  run();
  return unwatch;
}

function watchSize($el, listener) {
  var isIE9 = document.documentMode === 9;
  var locked = true;

  var wrappedListener = function wrappedListener() {
    return locked || listener.apply(void 0, arguments);
  };

  var implementation = isIE9 ? watchSizeForIE9 : external_watch_size_default.a;
  var removeSizeWatcher = implementation($el, wrappedListener);
  locked = false;
  return removeSizeWatcher;
}
// CONCATENATED MODULE: ./src/utils/setupResizeAndScrollEventListeners.js
function findScrollParents($el) {
  var $scrollParents = [];
  var $parent = $el.parentNode;

  while ($parent && $parent.nodeName !== 'BODY' && $parent.nodeType === document.ELEMENT_NODE) {
    if (isScrollElment($parent)) $scrollParents.push($parent);
    $parent = $parent.parentNode;
  }

  $scrollParents.push(window);
  return $scrollParents;
}

function isScrollElment($el) {
  var _getComputedStyle = getComputedStyle($el),
      overflow = _getComputedStyle.overflow,
      overflowX = _getComputedStyle.overflowX,
      overflowY = _getComputedStyle.overflowY;

  return /(auto|scroll|overlay)/.test(overflow + overflowY + overflowX);
}

function setupResizeAndScrollEventListeners($el, listener) {
  var $scrollParents = findScrollParents($el);
  window.addEventListener('resize', listener, {
    passive: true
  });
  $scrollParents.forEach(function (scrollParent) {
    scrollParent.addEventListener('scroll', listener, {
      passive: true
    });
  });
  return function removeEventListeners() {
    window.removeEventListener('resize', listener, {
      passive: true
    });
    $scrollParents.forEach(function ($scrollParent) {
      $scrollParent.removeEventListener('scroll', listener, {
        passive: true
      });
    });
  };
}
// CONCATENATED MODULE: ./src/utils/isNaN.js
function isNaN_isNaN(x) {
  return x !== x;
}
// EXTERNAL MODULE: external "is-promise"
var external_is_promise_ = __nested_webpack_require_5479__(7);
var external_is_promise_default = /*#__PURE__*/__nested_webpack_require_5479__.n(external_is_promise_);

// CONCATENATED MODULE: ./src/utils/isPromise.js

// EXTERNAL MODULE: external "lodash/once"
var once_ = __nested_webpack_require_5479__(8);
var once_default = /*#__PURE__*/__nested_webpack_require_5479__.n(once_);

// CONCATENATED MODULE: ./src/utils/once.js

// EXTERNAL MODULE: external "lodash/identity"
var identity_ = __nested_webpack_require_5479__(9);
var identity_default = /*#__PURE__*/__nested_webpack_require_5479__.n(identity_);

// CONCATENATED MODULE: ./src/utils/identity.js

// EXTERNAL MODULE: external "lodash/constant"
var constant_ = __nested_webpack_require_5479__(10);
var constant_default = /*#__PURE__*/__nested_webpack_require_5479__.n(constant_);

// CONCATENATED MODULE: ./src/utils/constant.js

// CONCATENATED MODULE: ./src/utils/createMap.js
var createMap = function createMap() {
  return Object.create(null);
};
// EXTERNAL MODULE: external "@babel/runtime/helpers/typeof"
var typeof_ = __nested_webpack_require_5479__(11);
var typeof_default = /*#__PURE__*/__nested_webpack_require_5479__.n(typeof_);

// CONCATENATED MODULE: ./src/utils/deepExtend.js


function isPlainObject(value) {
  if (value == null || typeof_default()(value) !== 'object') return false;
  return Object.getPrototypeOf(value) === Object.prototype;
}

function copy(obj, key, value) {
  if (isPlainObject(value)) {
    obj[key] || (obj[key] = {});
    deepExtend(obj[key], value);
  } else {
    obj[key] = value;
  }
}

function deepExtend(target, source) {
  if (isPlainObject(source)) {
    var keys = Object.keys(source);

    for (var i = 0, len = keys.length; i < len; i++) {
      copy(target, keys[i], source[keys[i]]);
    }
  }

  return target;
}
// EXTERNAL MODULE: external "lodash/last"
var last_ = __nested_webpack_require_5479__(12);
var last_default = /*#__PURE__*/__nested_webpack_require_5479__.n(last_);

// CONCATENATED MODULE: ./src/utils/last.js

// CONCATENATED MODULE: ./src/utils/includes.js
function includes(arrOrStr, elem) {
  return arrOrStr.indexOf(elem) !== -1;
}
// CONCATENATED MODULE: ./src/utils/find.js
function find(arr, predicate, ctx) {
  for (var i = 0, len = arr.length; i < len; i++) {
    if (predicate.call(ctx, arr[i], i, arr)) return arr[i];
  }

  return undefined;
}
// CONCATENATED MODULE: ./src/utils/quickDiff.js
function quickDiff(arrA, arrB) {
  if (arrA.length !== arrB.length) return true;

  for (var i = 0; i < arrA.length; i++) {
    if (arrA[i] !== arrB[i]) return true;
  }

  return false;
}
// CONCATENATED MODULE: ./src/utils/index.js



















// CONCATENATED MODULE: ./src/constants.js
var NO_PARENT_NODE = null;
var UNCHECKED = 0;
var INDETERMINATE = 1;
var CHECKED = 2;
var ALL_CHILDREN = 'ALL_CHILDREN';
var ALL_DESCENDANTS = 'ALL_DESCENDANTS';
var LEAF_CHILDREN = 'LEAF_CHILDREN';
var LEAF_DESCENDANTS = 'LEAF_DESCENDANTS';
var LOAD_ROOT_OPTIONS = 'LOAD_ROOT_OPTIONS';
var LOAD_CHILDREN_OPTIONS = 'LOAD_CHILDREN_OPTIONS';
var ASYNC_SEARCH = 'ASYNC_SEARCH';
var ALL = 'ALL';
var BRANCH_PRIORITY = 'BRANCH_PRIORITY';
var LEAF_PRIORITY = 'LEAF_PRIORITY';
var ALL_WITH_INDETERMINATE = 'ALL_WITH_INDETERMINATE';
var ORDER_SELECTED = 'ORDER_SELECTED';
var LEVEL = 'LEVEL';
var INDEX = 'INDEX';
var KEY_CODES = {
  BACKSPACE: 8,
  ENTER: 13,
  ESCAPE: 27,
  END: 35,
  HOME: 36,
  ARROW_LEFT: 37,
  ARROW_UP: 38,
  ARROW_RIGHT: 39,
  ARROW_DOWN: 40,
  DELETE: 46
};
var INPUT_DEBOUNCE_DELAY =  false ? 0 : 200;
var MIN_INPUT_WIDTH = 5;
var MENU_BUFFER = 40;
// CONCATENATED MODULE: ./src/mixins/treeselectMixin.js




function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { defineProperty_default()(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }





function sortValueByIndex(a, b) {
  var i = 0;

  do {
    if (a.level < i) return -1;
    if (b.level < i) return 1;
    if (a.index[i] !== b.index[i]) return a.index[i] - b.index[i];
    i++;
  } while (true);
}

function sortValueByLevel(a, b) {
  return a.level === b.level ? sortValueByIndex(a, b) : a.level - b.level;
}

function createAsyncOptionsStates() {
  return {
    isLoaded: false,
    isLoading: false,
    loadingError: ''
  };
}

function stringifyOptionPropValue(value) {
  if (typeof value === 'string') return value;
  if (typeof value === 'number' && !isNaN_isNaN(value)) return value + '';
  return '';
}

function match(enableFuzzyMatch, needle, haystack) {
  return enableFuzzyMatch ? external_fuzzysearch_default()(needle, haystack) : includes(haystack, needle);
}

function getErrorMessage(err) {
  return err.message || String(err);
}

var instanceId = 0;
/* harmony default export */ var treeselectMixin = ({
  provide: function provide() {
    return {
      instance: this
    };
  },
  props: {
    allowClearingDisabled: {
      type: Boolean,
      default: false
    },
    allowSelectingDisabledDescendants: {
      type: Boolean,
      default: false
    },
    alwaysOpen: {
      type: Boolean,
      default: false
    },
    appendToBody: {
      type: Boolean,
      default: false
    },
    async: {
      type: Boolean,
      default: false
    },
    autoFocus: {
      type: Boolean,
      default: false
    },
    autoLoadRootOptions: {
      type: Boolean,
      default: true
    },
    autoDeselectAncestors: {
      type: Boolean,
      default: false
    },
    autoDeselectDescendants: {
      type: Boolean,
      default: false
    },
    autoSelectAncestors: {
      type: Boolean,
      default: false
    },
    autoSelectDescendants: {
      type: Boolean,
      default: false
    },
    backspaceRemoves: {
      type: Boolean,
      default: true
    },
    beforeClearAll: {
      type: Function,
      default: constant_default()(true)
    },
    branchNodesFirst: {
      type: Boolean,
      default: false
    },
    cacheOptions: {
      type: Boolean,
      default: true
    },
    clearable: {
      type: Boolean,
      default: true
    },
    clearAllText: {
      type: String,
      default: 'Clear all'
    },
    clearOnSelect: {
      type: Boolean,
      default: false
    },
    clearValueText: {
      type: String,
      default: 'Clear value'
    },
    closeOnSelect: {
      type: Boolean,
      default: true
    },
    defaultExpandLevel: {
      type: Number,
      default: 0
    },
    defaultOptions: {
      default: false
    },
    deleteRemoves: {
      type: Boolean,
      default: true
    },
    delimiter: {
      type: String,
      default: ','
    },
    flattenSearchResults: {
      type: Boolean,
      default: false
    },
    disableBranchNodes: {
      type: Boolean,
      default: false
    },
    disabled: {
      type: Boolean,
      default: false
    },
    disableFuzzyMatching: {
      type: Boolean,
      default: false
    },
    flat: {
      type: Boolean,
      default: false
    },
    instanceId: {
      default: function _default() {
        return "".concat(instanceId++, "$$");
      },
      type: [String, Number]
    },
    joinValues: {
      type: Boolean,
      default: false
    },
    limit: {
      type: Number,
      default: Infinity
    },
    limitText: {
      type: Function,
      default: function limitTextDefault(count) {
        return "and ".concat(count, " more");
      }
    },
    loadingText: {
      type: String,
      default: 'Loading...'
    },
    loadOptions: {
      type: Function
    },
    matchKeys: {
      type: Array,
      default: constant_default()(['label'])
    },
    maxHeight: {
      type: Number,
      default: 300
    },
    multiple: {
      type: Boolean,
      default: false
    },
    name: {
      type: String
    },
    noChildrenText: {
      type: String,
      default: 'No sub-options.'
    },
    noOptionsText: {
      type: String,
      default: 'No options available.'
    },
    noResultsText: {
      type: String,
      default: 'No results found...'
    },
    normalizer: {
      type: Function,
      default: identity_default.a
    },
    openDirection: {
      type: String,
      default: 'auto',
      validator: function validator(value) {
        var acceptableValues = ['auto', 'top', 'bottom', 'above', 'below'];
        return includes(acceptableValues, value);
      }
    },
    openOnClick: {
      type: Boolean,
      default: true
    },
    openOnFocus: {
      type: Boolean,
      default: false
    },
    options: {
      type: Array
    },
    placeholder: {
      type: String,
      default: 'Select...'
    },
    required: {
      type: Boolean,
      default: false
    },
    retryText: {
      type: String,
      default: 'Retry?'
    },
    retryTitle: {
      type: String,
      default: 'Click to retry'
    },
    searchable: {
      type: Boolean,
      default: true
    },
    searchNested: {
      type: Boolean,
      default: false
    },
    searchPromptText: {
      type: String,
      default: 'Type to search...'
    },
    showCount: {
      type: Boolean,
      default: false
    },
    showCountOf: {
      type: String,
      default: ALL_CHILDREN,
      validator: function validator(value) {
        var acceptableValues = [ALL_CHILDREN, ALL_DESCENDANTS, LEAF_CHILDREN, LEAF_DESCENDANTS];
        return includes(acceptableValues, value);
      }
    },
    showCountOnSearch: null,
    sortValueBy: {
      type: String,
      default: ORDER_SELECTED,
      validator: function validator(value) {
        var acceptableValues = [ORDER_SELECTED, LEVEL, INDEX];
        return includes(acceptableValues, value);
      }
    },
    tabIndex: {
      type: Number,
      default: 0
    },
    value: null,
    valueConsistsOf: {
      type: String,
      default: BRANCH_PRIORITY,
      validator: function validator(value) {
        var acceptableValues = [ALL, BRANCH_PRIORITY, LEAF_PRIORITY, ALL_WITH_INDETERMINATE];
        return includes(acceptableValues, value);
      }
    },
    valueFormat: {
      type: String,
      default: 'id'
    },
    zIndex: {
      type: [Number, String],
      default: 999
    }
  },
  data: function data() {
    return {
      trigger: {
        isFocused: false,
        searchQuery: ''
      },
      menu: {
        isOpen: false,
        current: null,
        lastScrollPosition: 0,
        placement: 'bottom'
      },
      forest: {
        normalizedOptions: [],
        nodeMap: createMap(),
        checkedStateMap: createMap(),
        selectedNodeIds: this.extractCheckedNodeIdsFromValue(),
        selectedNodeMap: createMap()
      },
      rootOptionsStates: createAsyncOptionsStates(),
      localSearch: {
        active: false,
        noResults: true,
        countMap: createMap()
      },
      remoteSearch: createMap()
    };
  },
  computed: {
    selectedNodes: function selectedNodes() {
      return this.forest.selectedNodeIds.map(this.getNode);
    },
    internalValue: function internalValue() {
      var _this = this;

      var internalValue;

      if (this.single || this.flat || this.disableBranchNodes || this.valueConsistsOf === ALL) {
        internalValue = this.forest.selectedNodeIds.slice();
      } else if (this.valueConsistsOf === BRANCH_PRIORITY) {
        internalValue = this.forest.selectedNodeIds.filter(function (id) {
          var node = _this.getNode(id);

          if (node.isRootNode) return true;
          return !_this.isSelected(node.parentNode);
        });
      } else if (this.valueConsistsOf === LEAF_PRIORITY) {
        internalValue = this.forest.selectedNodeIds.filter(function (id) {
          var node = _this.getNode(id);

          if (node.isLeaf) return true;
          return node.children.length === 0;
        });
      } else if (this.valueConsistsOf === ALL_WITH_INDETERMINATE) {
        var _internalValue;

        var indeterminateNodeIds = [];
        internalValue = this.forest.selectedNodeIds.slice();
        this.selectedNodes.forEach(function (selectedNode) {
          selectedNode.ancestors.forEach(function (ancestor) {
            if (includes(indeterminateNodeIds, ancestor.id)) return;
            if (includes(internalValue, ancestor.id)) return;
            indeterminateNodeIds.push(ancestor.id);
          });
        });

        (_internalValue = internalValue).push.apply(_internalValue, indeterminateNodeIds);
      }

      if (this.sortValueBy === LEVEL) {
        internalValue.sort(function (a, b) {
          return sortValueByLevel(_this.getNode(a), _this.getNode(b));
        });
      } else if (this.sortValueBy === INDEX) {
        internalValue.sort(function (a, b) {
          return sortValueByIndex(_this.getNode(a), _this.getNode(b));
        });
      }

      return internalValue;
    },
    hasValue: function hasValue() {
      return this.internalValue.length > 0;
    },
    single: function single() {
      return !this.multiple;
    },
    visibleOptionIds: function visibleOptionIds() {
      var _this2 = this;

      var visibleOptionIds = [];
      this.traverseAllNodesByIndex(function (node) {
        if (!_this2.localSearch.active || _this2.shouldOptionBeIncludedInSearchResult(node)) {
          visibleOptionIds.push(node.id);
        }

        if (node.isBranch && !_this2.shouldExpand(node)) {
          return false;
        }
      });
      return visibleOptionIds;
    },
    hasVisibleOptions: function hasVisibleOptions() {
      return this.visibleOptionIds.length !== 0;
    },
    showCountOnSearchComputed: function showCountOnSearchComputed() {
      return typeof this.showCountOnSearch === 'boolean' ? this.showCountOnSearch : this.showCount;
    },
    hasBranchNodes: function hasBranchNodes() {
      return this.forest.normalizedOptions.some(function (rootNode) {
        return rootNode.isBranch;
      });
    },
    shouldFlattenOptions: function shouldFlattenOptions() {
      return this.localSearch.active && this.flattenSearchResults;
    }
  },
  watch: {
    alwaysOpen: function alwaysOpen(newValue) {
      if (newValue) this.openMenu();else this.closeMenu();
    },
    branchNodesFirst: function branchNodesFirst() {
      this.initialize();
    },
    disabled: function disabled(newValue) {
      if (newValue && this.menu.isOpen) this.closeMenu();else if (!newValue && !this.menu.isOpen && this.alwaysOpen) this.openMenu();
    },
    flat: function flat() {
      this.initialize();
    },
    internalValue: function internalValue(newValue, oldValue) {
      var hasChanged = quickDiff(newValue, oldValue);
      if (hasChanged) this.$emit('input', this.getValue(), this.getInstanceId());
    },
    matchKeys: function matchKeys() {
      this.initialize();
    },
    multiple: function multiple(newValue) {
      if (newValue) this.buildForestState();
    },
    options: {
      handler: function handler() {
        if (this.async) return;
        this.initialize();
        this.rootOptionsStates.isLoaded = Array.isArray(this.options);
      },
      deep: true,
      immediate: true
    },
    'trigger.searchQuery': function triggerSearchQuery() {
      if (this.async) {
        this.handleRemoteSearch();
      } else {
        this.handleLocalSearch();
      }

      this.$emit('search-change', this.trigger.searchQuery, this.getInstanceId());
    },
    value: function value() {
      var nodeIdsFromValue = this.extractCheckedNodeIdsFromValue();
      var hasChanged = quickDiff(nodeIdsFromValue, this.internalValue);
      if (hasChanged) this.fixSelectedNodeIds(nodeIdsFromValue);
    }
  },
  methods: {
    verifyProps: function verifyProps() {
      var _this3 = this;

      warning_warning(function () {
        return _this3.async ? _this3.searchable : true;
      }, function () {
        return 'For async search mode, the value of "searchable" prop must be true.';
      });

      if (this.options == null && !this.loadOptions) {
        warning_warning(function () {
          return false;
        }, function () {
          return 'Are you meant to dynamically load options? You need to use "loadOptions" prop.';
        });
      }

      if (this.flat) {
        warning_warning(function () {
          return _this3.multiple;
        }, function () {
          return 'You are using flat mode. But you forgot to add "multiple=true"?';
        });
      }

      if (!this.flat) {
        var propNames = ['autoSelectAncestors', 'autoSelectDescendants', 'autoDeselectAncestors', 'autoDeselectDescendants'];
        propNames.forEach(function (propName) {
          warning_warning(function () {
            return !_this3[propName];
          }, function () {
            return "\"".concat(propName, "\" only applies to flat mode.");
          });
        });
      }
    },
    resetFlags: function resetFlags() {
      this._blurOnSelect = false;
    },
    initialize: function initialize() {
      var options = this.async ? this.getRemoteSearchEntry().options : this.options;

      if (Array.isArray(options)) {
        var prevNodeMap = this.forest.nodeMap;
        this.forest.nodeMap = createMap();
        this.keepDataOfSelectedNodes(prevNodeMap);
        this.forest.normalizedOptions = this.normalize(NO_PARENT_NODE, options, prevNodeMap);
        this.fixSelectedNodeIds(this.internalValue);
      } else {
        this.forest.normalizedOptions = [];
      }
    },
    getInstanceId: function getInstanceId() {
      return this.instanceId == null ? this.id : this.instanceId;
    },
    getValue: function getValue() {
      var _this4 = this;

      if (this.valueFormat === 'id') {
        return this.multiple ? this.internalValue.slice() : this.internalValue[0];
      }

      var rawNodes = this.internalValue.map(function (id) {
        return _this4.getNode(id).raw;
      });
      return this.multiple ? rawNodes : rawNodes[0];
    },
    getNode: function getNode(nodeId) {
      warning_warning(function () {
        return nodeId != null;
      }, function () {
        return "Invalid node id: ".concat(nodeId);
      });
      if (nodeId == null) return null;
      return nodeId in this.forest.nodeMap ? this.forest.nodeMap[nodeId] : this.createFallbackNode(nodeId);
    },
    createFallbackNode: function createFallbackNode(id) {
      var raw = this.extractNodeFromValue(id);
      var label = this.enhancedNormalizer(raw).label || "".concat(id, " (unknown)");
      var fallbackNode = {
        id: id,
        label: label,
        ancestors: [],
        parentNode: NO_PARENT_NODE,
        isFallbackNode: true,
        isRootNode: true,
        isLeaf: true,
        isBranch: false,
        isDisabled: false,
        isNew: false,
        index: [-1],
        level: 0,
        raw: raw
      };
      return this.$set(this.forest.nodeMap, id, fallbackNode);
    },
    extractCheckedNodeIdsFromValue: function extractCheckedNodeIdsFromValue() {
      var _this5 = this;

      if (this.value == null) return [];

      if (this.valueFormat === 'id') {
        return this.multiple ? this.value.slice() : [this.value];
      }

      return (this.multiple ? this.value : [this.value]).map(function (node) {
        return _this5.enhancedNormalizer(node);
      }).map(function (node) {
        return node.id;
      });
    },
    extractNodeFromValue: function extractNodeFromValue(id) {
      var _this6 = this;

      var defaultNode = {
        id: id
      };

      if (this.valueFormat === 'id') {
        return defaultNode;
      }

      var valueArray = this.multiple ? Array.isArray(this.value) ? this.value : [] : this.value ? [this.value] : [];
      var matched = find(valueArray, function (node) {
        return node && _this6.enhancedNormalizer(node).id === id;
      });
      return matched || defaultNode;
    },
    fixSelectedNodeIds: function fixSelectedNodeIds(nodeIdListOfPrevValue) {
      var _this7 = this;

      var nextSelectedNodeIds = [];

      if (this.single || this.flat || this.disableBranchNodes || this.valueConsistsOf === ALL) {
        nextSelectedNodeIds = nodeIdListOfPrevValue;
      } else if (this.valueConsistsOf === BRANCH_PRIORITY) {
        nodeIdListOfPrevValue.forEach(function (nodeId) {
          nextSelectedNodeIds.push(nodeId);

          var node = _this7.getNode(nodeId);

          if (node.isBranch) _this7.traverseDescendantsBFS(node, function (descendant) {
            nextSelectedNodeIds.push(descendant.id);
          });
        });
      } else if (this.valueConsistsOf === LEAF_PRIORITY) {
        var map = createMap();
        var queue = nodeIdListOfPrevValue.slice();

        while (queue.length) {
          var nodeId = queue.shift();
          var node = this.getNode(nodeId);
          nextSelectedNodeIds.push(nodeId);
          if (node.isRootNode) continue;
          if (!(node.parentNode.id in map)) map[node.parentNode.id] = node.parentNode.children.length;
          if (--map[node.parentNode.id] === 0) queue.push(node.parentNode.id);
        }
      } else if (this.valueConsistsOf === ALL_WITH_INDETERMINATE) {
        var _map = createMap();

        var _queue = nodeIdListOfPrevValue.filter(function (nodeId) {
          var node = _this7.getNode(nodeId);

          return node.isLeaf || node.children.length === 0;
        });

        while (_queue.length) {
          var _nodeId = _queue.shift();

          var _node = this.getNode(_nodeId);

          nextSelectedNodeIds.push(_nodeId);
          if (_node.isRootNode) continue;
          if (!(_node.parentNode.id in _map)) _map[_node.parentNode.id] = _node.parentNode.children.length;
          if (--_map[_node.parentNode.id] === 0) _queue.push(_node.parentNode.id);
        }
      }

      var hasChanged = quickDiff(this.forest.selectedNodeIds, nextSelectedNodeIds);
      if (hasChanged) this.forest.selectedNodeIds = nextSelectedNodeIds;
      this.buildForestState();
    },
    keepDataOfSelectedNodes: function keepDataOfSelectedNodes(prevNodeMap) {
      var _this8 = this;

      this.forest.selectedNodeIds.forEach(function (id) {
        if (!prevNodeMap[id]) return;

        var node = _objectSpread({}, prevNodeMap[id], {
          isFallbackNode: true
        });

        _this8.$set(_this8.forest.nodeMap, id, node);
      });
    },
    isSelected: function isSelected(node) {
      return this.forest.selectedNodeMap[node.id] === true;
    },
    traverseDescendantsBFS: function traverseDescendantsBFS(parentNode, callback) {
      if (!parentNode.isBranch) return;
      var queue = parentNode.children.slice();

      while (queue.length) {
        var currNode = queue[0];
        if (currNode.isBranch) queue.push.apply(queue, toConsumableArray_default()(currNode.children));
        callback(currNode);
        queue.shift();
      }
    },
    traverseDescendantsDFS: function traverseDescendantsDFS(parentNode, callback) {
      var _this9 = this;

      if (!parentNode.isBranch) return;
      parentNode.children.forEach(function (child) {
        _this9.traverseDescendantsDFS(child, callback);

        callback(child);
      });
    },
    traverseAllNodesDFS: function traverseAllNodesDFS(callback) {
      var _this10 = this;

      this.forest.normalizedOptions.forEach(function (rootNode) {
        _this10.traverseDescendantsDFS(rootNode, callback);

        callback(rootNode);
      });
    },
    traverseAllNodesByIndex: function traverseAllNodesByIndex(callback) {
      var walk = function walk(parentNode) {
        parentNode.children.forEach(function (child) {
          if (callback(child) !== false && child.isBranch) {
            walk(child);
          }
        });
      };

      walk({
        children: this.forest.normalizedOptions
      });
    },
    toggleClickOutsideEvent: function toggleClickOutsideEvent(enabled) {
      if (enabled) {
        document.addEventListener('mousedown', this.handleClickOutside, false);
      } else {
        document.removeEventListener('mousedown', this.handleClickOutside, false);
      }
    },
    getValueContainer: function getValueContainer() {
      return this.$refs.control.$refs['value-container'];
    },
    getInput: function getInput() {
      return this.getValueContainer().$refs.input;
    },
    focusInput: function focusInput() {
      this.getInput().focus();
    },
    blurInput: function blurInput() {
      this.getInput().blur();
    },
    handleMouseDown: onLeftClick(function handleMouseDown(evt) {
      evt.preventDefault();
      evt.stopPropagation();
      if (this.disabled) return;
      var isClickedOnValueContainer = this.getValueContainer().$el.contains(evt.target);

      if (isClickedOnValueContainer && !this.menu.isOpen && (this.openOnClick || this.trigger.isFocused)) {
        this.openMenu();
      }

      if (this._blurOnSelect) {
        this.blurInput();
      } else {
        this.focusInput();
      }

      this.resetFlags();
    }),
    handleClickOutside: function handleClickOutside(evt) {
      if (this.$refs.wrapper && !this.$refs.wrapper.contains(evt.target)) {
        this.blurInput();
        this.closeMenu();
      }
    },
    handleLocalSearch: function handleLocalSearch() {
      var _this11 = this;

      var searchQuery = this.trigger.searchQuery;

      var done = function done() {
        return _this11.resetHighlightedOptionWhenNecessary(true);
      };

      if (!searchQuery) {
        this.localSearch.active = false;
        return done();
      }

      this.localSearch.active = true;
      this.localSearch.noResults = true;
      this.traverseAllNodesDFS(function (node) {
        if (node.isBranch) {
          var _this11$$set;

          node.isExpandedOnSearch = false;
          node.showAllChildrenOnSearch = false;
          node.isMatched = false;
          node.hasMatchedDescendants = false;

          _this11.$set(_this11.localSearch.countMap, node.id, (_this11$$set = {}, defineProperty_default()(_this11$$set, ALL_CHILDREN, 0), defineProperty_default()(_this11$$set, ALL_DESCENDANTS, 0), defineProperty_default()(_this11$$set, LEAF_CHILDREN, 0), defineProperty_default()(_this11$$set, LEAF_DESCENDANTS, 0), _this11$$set));
        }
      });
      var lowerCasedSearchQuery = searchQuery.trim().toLocaleLowerCase();
      var splitSearchQuery = lowerCasedSearchQuery.replace(/\s+/g, ' ').split(' ');
      this.traverseAllNodesDFS(function (node) {
        if (_this11.searchNested && splitSearchQuery.length > 1) {
          node.isMatched = splitSearchQuery.every(function (filterValue) {
            return match(false, filterValue, node.nestedSearchLabel);
          });
        } else {
          node.isMatched = _this11.matchKeys.some(function (matchKey) {
            return match(!_this11.disableFuzzyMatching, lowerCasedSearchQuery, node.lowerCased[matchKey]);
          });
        }

        if (node.isMatched) {
          _this11.localSearch.noResults = false;
          node.ancestors.forEach(function (ancestor) {
            return _this11.localSearch.countMap[ancestor.id][ALL_DESCENDANTS]++;
          });
          if (node.isLeaf) node.ancestors.forEach(function (ancestor) {
            return _this11.localSearch.countMap[ancestor.id][LEAF_DESCENDANTS]++;
          });

          if (node.parentNode !== NO_PARENT_NODE) {
            _this11.localSearch.countMap[node.parentNode.id][ALL_CHILDREN] += 1;
            if (node.isLeaf) _this11.localSearch.countMap[node.parentNode.id][LEAF_CHILDREN] += 1;
          }
        }

        if ((node.isMatched || node.isBranch && node.isExpandedOnSearch) && node.parentNode !== NO_PARENT_NODE) {
          node.parentNode.isExpandedOnSearch = true;
          node.parentNode.hasMatchedDescendants = true;
        }
      });
      done();
    },
    handleRemoteSearch: function handleRemoteSearch() {
      var _this12 = this;

      var searchQuery = this.trigger.searchQuery;
      var entry = this.getRemoteSearchEntry();

      var done = function done() {
        _this12.initialize();

        _this12.resetHighlightedOptionWhenNecessary(true);
      };

      if ((searchQuery === '' || this.cacheOptions) && entry.isLoaded) {
        return done();
      }

      this.callLoadOptionsProp({
        action: ASYNC_SEARCH,
        args: {
          searchQuery: searchQuery
        },
        isPending: function isPending() {
          return entry.isLoading;
        },
        start: function start() {
          entry.isLoading = true;
          entry.isLoaded = false;
          entry.loadingError = '';
        },
        succeed: function succeed(options) {
          entry.isLoaded = true;
          entry.options = options;
          if (_this12.trigger.searchQuery === searchQuery) done();
        },
        fail: function fail(err) {
          entry.loadingError = getErrorMessage(err);
        },
        end: function end() {
          entry.isLoading = false;
        }
      });
    },
    getRemoteSearchEntry: function getRemoteSearchEntry() {
      var _this13 = this;

      var searchQuery = this.trigger.searchQuery;

      var entry = this.remoteSearch[searchQuery] || _objectSpread({}, createAsyncOptionsStates(), {
        options: []
      });

      this.$watch(function () {
        return entry.options;
      }, function () {
        if (_this13.trigger.searchQuery === searchQuery) _this13.initialize();
      }, {
        deep: true
      });

      if (searchQuery === '') {
        if (Array.isArray(this.defaultOptions)) {
          entry.options = this.defaultOptions;
          entry.isLoaded = true;
          return entry;
        } else if (this.defaultOptions !== true) {
          entry.isLoaded = true;
          return entry;
        }
      }

      if (!this.remoteSearch[searchQuery]) {
        this.$set(this.remoteSearch, searchQuery, entry);
      }

      return entry;
    },
    shouldExpand: function shouldExpand(node) {
      return this.localSearch.active ? node.isExpandedOnSearch : node.isExpanded;
    },
    shouldOptionBeIncludedInSearchResult: function shouldOptionBeIncludedInSearchResult(node) {
      if (node.isMatched) return true;
      if (node.isBranch && node.hasMatchedDescendants && !this.flattenSearchResults) return true;
      if (!node.isRootNode && node.parentNode.showAllChildrenOnSearch) return true;
      return false;
    },
    shouldShowOptionInMenu: function shouldShowOptionInMenu(node) {
      if (this.localSearch.active && !this.shouldOptionBeIncludedInSearchResult(node)) {
        return false;
      }

      return true;
    },
    getControl: function getControl() {
      return this.$refs.control.$el;
    },
    getMenu: function getMenu() {
      var ref = this.appendToBody ? this.$refs.portal.portalTarget : this;
      var $menu = ref.$refs.menu.$refs.menu;
      return $menu && $menu.nodeName !== '#comment' ? $menu : null;
    },
    setCurrentHighlightedOption: function setCurrentHighlightedOption(node) {
      var _this14 = this;

      var scroll = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;
      var prev = this.menu.current;

      if (prev != null && prev in this.forest.nodeMap) {
        this.forest.nodeMap[prev].isHighlighted = false;
      }

      this.menu.current = node.id;
      node.isHighlighted = true;

      if (this.menu.isOpen && scroll) {
        var scrollToOption = function scrollToOption() {
          var $menu = _this14.getMenu();

          var $option = $menu.querySelector(".vue-treeselect__option[data-id=\"".concat(node.id, "\"]"));
          if ($option) scrollIntoView($menu, $option);
        };

        if (this.getMenu()) {
          scrollToOption();
        } else {
          this.$nextTick(scrollToOption);
        }
      }
    },
    resetHighlightedOptionWhenNecessary: function resetHighlightedOptionWhenNecessary() {
      var forceReset = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
      var current = this.menu.current;

      if (forceReset || current == null || !(current in this.forest.nodeMap) || !this.shouldShowOptionInMenu(this.getNode(current))) {
        this.highlightFirstOption();
      }
    },
    highlightFirstOption: function highlightFirstOption() {
      if (!this.hasVisibleOptions) return;
      var first = this.visibleOptionIds[0];
      this.setCurrentHighlightedOption(this.getNode(first));
    },
    highlightPrevOption: function highlightPrevOption() {
      if (!this.hasVisibleOptions) return;
      var prev = this.visibleOptionIds.indexOf(this.menu.current) - 1;
      if (prev === -1) return this.highlightLastOption();
      this.setCurrentHighlightedOption(this.getNode(this.visibleOptionIds[prev]));
    },
    highlightNextOption: function highlightNextOption() {
      if (!this.hasVisibleOptions) return;
      var next = this.visibleOptionIds.indexOf(this.menu.current) + 1;
      if (next === this.visibleOptionIds.length) return this.highlightFirstOption();
      this.setCurrentHighlightedOption(this.getNode(this.visibleOptionIds[next]));
    },
    highlightLastOption: function highlightLastOption() {
      if (!this.hasVisibleOptions) return;
      var last = last_default()(this.visibleOptionIds);
      this.setCurrentHighlightedOption(this.getNode(last));
    },
    resetSearchQuery: function resetSearchQuery() {
      this.trigger.searchQuery = '';
    },
    closeMenu: function closeMenu() {
      if (!this.menu.isOpen || !this.disabled && this.alwaysOpen) return;
      this.saveMenuScrollPosition();
      this.menu.isOpen = false;
      this.toggleClickOutsideEvent(false);
      this.resetSearchQuery();
      this.$emit('close', this.getValue(), this.getInstanceId());
    },
    openMenu: function openMenu() {
      if (this.disabled || this.menu.isOpen) return;
      this.menu.isOpen = true;
      this.$nextTick(this.resetHighlightedOptionWhenNecessary);
      this.$nextTick(this.restoreMenuScrollPosition);
      if (!this.options && !this.async) this.loadRootOptions();
      this.toggleClickOutsideEvent(true);
      this.$emit('open', this.getInstanceId());
    },
    toggleMenu: function toggleMenu() {
      if (this.menu.isOpen) {
        this.closeMenu();
      } else {
        this.openMenu();
      }
    },
    toggleExpanded: function toggleExpanded(node) {
      var nextState;

      if (this.localSearch.active) {
        nextState = node.isExpandedOnSearch = !node.isExpandedOnSearch;
        if (nextState) node.showAllChildrenOnSearch = true;
      } else {
        nextState = node.isExpanded = !node.isExpanded;
      }

      if (nextState && !node.childrenStates.isLoaded) {
        this.loadChildrenOptions(node);
      }
    },
    buildForestState: function buildForestState() {
      var _this15 = this;

      var selectedNodeMap = createMap();
      this.forest.selectedNodeIds.forEach(function (selectedNodeId) {
        selectedNodeMap[selectedNodeId] = true;
      });
      this.forest.selectedNodeMap = selectedNodeMap;
      var checkedStateMap = createMap();

      if (this.multiple) {
        this.traverseAllNodesByIndex(function (node) {
          checkedStateMap[node.id] = UNCHECKED;
        });
        this.selectedNodes.forEach(function (selectedNode) {
          checkedStateMap[selectedNode.id] = CHECKED;

          if (!_this15.flat && !_this15.disableBranchNodes) {
            selectedNode.ancestors.forEach(function (ancestorNode) {
              if (!_this15.isSelected(ancestorNode)) {
                checkedStateMap[ancestorNode.id] = INDETERMINATE;
              }
            });
          }
        });
      }

      this.forest.checkedStateMap = checkedStateMap;
    },
    enhancedNormalizer: function enhancedNormalizer(raw) {
      return _objectSpread({}, raw, {}, this.normalizer(raw, this.getInstanceId()));
    },
    normalize: function normalize(parentNode, nodes, prevNodeMap) {
      var _this16 = this;

      var normalizedOptions = nodes.map(function (node) {
        return [_this16.enhancedNormalizer(node), node];
      }).map(function (_ref, index) {
        var _ref2 = slicedToArray_default()(_ref, 2),
            node = _ref2[0],
            raw = _ref2[1];

        _this16.checkDuplication(node);

        _this16.verifyNodeShape(node);

        var id = node.id,
            label = node.label,
            children = node.children,
            isDefaultExpanded = node.isDefaultExpanded;
        var isRootNode = parentNode === NO_PARENT_NODE;
        var level = isRootNode ? 0 : parentNode.level + 1;
        var isBranch = Array.isArray(children) || children === null;
        var isLeaf = !isBranch;
        var isDisabled = !!node.isDisabled || !_this16.flat && !isRootNode && parentNode.isDisabled;
        var isNew = !!node.isNew;

        var lowerCased = _this16.matchKeys.reduce(function (prev, key) {
          return _objectSpread({}, prev, defineProperty_default()({}, key, stringifyOptionPropValue(node[key]).toLocaleLowerCase()));
        }, {});

        var nestedSearchLabel = isRootNode ? lowerCased.label : parentNode.nestedSearchLabel + ' ' + lowerCased.label;

        var normalized = _this16.$set(_this16.forest.nodeMap, id, createMap());

        _this16.$set(normalized, 'id', id);

        _this16.$set(normalized, 'label', label);

        _this16.$set(normalized, 'level', level);

        _this16.$set(normalized, 'ancestors', isRootNode ? [] : [parentNode].concat(parentNode.ancestors));

        _this16.$set(normalized, 'index', (isRootNode ? [] : parentNode.index).concat(index));

        _this16.$set(normalized, 'parentNode', parentNode);

        _this16.$set(normalized, 'lowerCased', lowerCased);

        _this16.$set(normalized, 'nestedSearchLabel', nestedSearchLabel);

        _this16.$set(normalized, 'isDisabled', isDisabled);

        _this16.$set(normalized, 'isNew', isNew);

        _this16.$set(normalized, 'isMatched', false);

        _this16.$set(normalized, 'isHighlighted', false);

        _this16.$set(normalized, 'isBranch', isBranch);

        _this16.$set(normalized, 'isLeaf', isLeaf);

        _this16.$set(normalized, 'isRootNode', isRootNode);

        _this16.$set(normalized, 'raw', raw);

        if (isBranch) {
          var _this16$$set;

          var isLoaded = Array.isArray(children);

          _this16.$set(normalized, 'childrenStates', _objectSpread({}, createAsyncOptionsStates(), {
            isLoaded: isLoaded
          }));

          _this16.$set(normalized, 'isExpanded', typeof isDefaultExpanded === 'boolean' ? isDefaultExpanded : level < _this16.defaultExpandLevel);

          _this16.$set(normalized, 'hasMatchedDescendants', false);

          _this16.$set(normalized, 'hasDisabledDescendants', false);

          _this16.$set(normalized, 'isExpandedOnSearch', false);

          _this16.$set(normalized, 'showAllChildrenOnSearch', false);

          _this16.$set(normalized, 'count', (_this16$$set = {}, defineProperty_default()(_this16$$set, ALL_CHILDREN, 0), defineProperty_default()(_this16$$set, ALL_DESCENDANTS, 0), defineProperty_default()(_this16$$set, LEAF_CHILDREN, 0), defineProperty_default()(_this16$$set, LEAF_DESCENDANTS, 0), _this16$$set));

          _this16.$set(normalized, 'children', isLoaded ? _this16.normalize(normalized, children, prevNodeMap) : []);

          if (isDefaultExpanded === true) normalized.ancestors.forEach(function (ancestor) {
            ancestor.isExpanded = true;
          });

          if (!isLoaded && typeof _this16.loadOptions !== 'function') {
            warning_warning(function () {
              return false;
            }, function () {
              return 'Unloaded branch node detected. "loadOptions" prop is required to load its children.';
            });
          } else if (!isLoaded && normalized.isExpanded) {
            _this16.loadChildrenOptions(normalized);
          }
        }

        normalized.ancestors.forEach(function (ancestor) {
          return ancestor.count[ALL_DESCENDANTS]++;
        });
        if (isLeaf) normalized.ancestors.forEach(function (ancestor) {
          return ancestor.count[LEAF_DESCENDANTS]++;
        });

        if (!isRootNode) {
          parentNode.count[ALL_CHILDREN] += 1;
          if (isLeaf) parentNode.count[LEAF_CHILDREN] += 1;
          if (isDisabled) parentNode.hasDisabledDescendants = true;
        }

        if (prevNodeMap && prevNodeMap[id]) {
          var prev = prevNodeMap[id];
          normalized.isMatched = prev.isMatched;
          normalized.showAllChildrenOnSearch = prev.showAllChildrenOnSearch;
          normalized.isHighlighted = prev.isHighlighted;

          if (prev.isBranch && normalized.isBranch) {
            normalized.isExpanded = prev.isExpanded;
            normalized.isExpandedOnSearch = prev.isExpandedOnSearch;

            if (prev.childrenStates.isLoaded && !normalized.childrenStates.isLoaded) {
              normalized.isExpanded = false;
            } else {
              normalized.childrenStates = _objectSpread({}, prev.childrenStates);
            }
          }
        }

        return normalized;
      });

      if (this.branchNodesFirst) {
        var branchNodes = normalizedOptions.filter(function (option) {
          return option.isBranch;
        });
        var leafNodes = normalizedOptions.filter(function (option) {
          return option.isLeaf;
        });
        normalizedOptions = branchNodes.concat(leafNodes);
      }

      return normalizedOptions;
    },
    loadRootOptions: function loadRootOptions() {
      var _this17 = this;

      this.callLoadOptionsProp({
        action: LOAD_ROOT_OPTIONS,
        isPending: function isPending() {
          return _this17.rootOptionsStates.isLoading;
        },
        start: function start() {
          _this17.rootOptionsStates.isLoading = true;
          _this17.rootOptionsStates.loadingError = '';
        },
        succeed: function succeed() {
          _this17.rootOptionsStates.isLoaded = true;

          _this17.$nextTick(function () {
            _this17.resetHighlightedOptionWhenNecessary(true);
          });
        },
        fail: function fail(err) {
          _this17.rootOptionsStates.loadingError = getErrorMessage(err);
        },
        end: function end() {
          _this17.rootOptionsStates.isLoading = false;
        }
      });
    },
    loadChildrenOptions: function loadChildrenOptions(parentNode) {
      var _this18 = this;

      var id = parentNode.id,
          raw = parentNode.raw;
      this.callLoadOptionsProp({
        action: LOAD_CHILDREN_OPTIONS,
        args: {
          parentNode: raw
        },
        isPending: function isPending() {
          return _this18.getNode(id).childrenStates.isLoading;
        },
        start: function start() {
          _this18.getNode(id).childrenStates.isLoading = true;
          _this18.getNode(id).childrenStates.loadingError = '';
        },
        succeed: function succeed() {
          _this18.getNode(id).childrenStates.isLoaded = true;
        },
        fail: function fail(err) {
          _this18.getNode(id).childrenStates.loadingError = getErrorMessage(err);
        },
        end: function end() {
          _this18.getNode(id).childrenStates.isLoading = false;
        }
      });
    },
    callLoadOptionsProp: function callLoadOptionsProp(_ref3) {
      var action = _ref3.action,
          args = _ref3.args,
          isPending = _ref3.isPending,
          start = _ref3.start,
          succeed = _ref3.succeed,
          fail = _ref3.fail,
          end = _ref3.end;

      if (!this.loadOptions || isPending()) {
        return;
      }

      start();
      var callback = once_default()(function (err, result) {
        if (err) {
          fail(err);
        } else {
          succeed(result);
        }

        end();
      });
      var result = this.loadOptions(_objectSpread({
        id: this.getInstanceId(),
        instanceId: this.getInstanceId(),
        action: action
      }, args, {
        callback: callback
      }));

      if (external_is_promise_default()(result)) {
        result.then(function () {
          callback();
        }, function (err) {
          callback(err);
        }).catch(function (err) {
          console.error(err);
        });
      }
    },
    checkDuplication: function checkDuplication(node) {
      var _this19 = this;

      warning_warning(function () {
        return !(node.id in _this19.forest.nodeMap && !_this19.forest.nodeMap[node.id].isFallbackNode);
      }, function () {
        return "Detected duplicate presence of node id ".concat(JSON.stringify(node.id), ". ") + "Their labels are \"".concat(_this19.forest.nodeMap[node.id].label, "\" and \"").concat(node.label, "\" respectively.");
      });
    },
    verifyNodeShape: function verifyNodeShape(node) {
      warning_warning(function () {
        return !(node.children === undefined && node.isBranch === true);
      }, function () {
        return 'Are you meant to declare an unloaded branch node? ' + '`isBranch: true` is no longer supported, please use `children: null` instead.';
      });
    },
    select: function select(node) {
      if (this.disabled || node.isDisabled) {
        return;
      }

      if (this.single) {
        this.clear();
      }

      var nextState = this.multiple && !this.flat ? this.forest.checkedStateMap[node.id] === UNCHECKED : !this.isSelected(node);

      if (nextState) {
        this._selectNode(node);
      } else {
        this._deselectNode(node);
      }

      this.buildForestState();

      if (nextState) {
        this.$emit('select', node.raw, this.getInstanceId());
      } else {
        this.$emit('deselect', node.raw, this.getInstanceId());
      }

      if (this.localSearch.active && nextState && (this.single || this.clearOnSelect)) {
        this.resetSearchQuery();
      }

      if (this.single && this.closeOnSelect) {
        this.closeMenu();

        if (this.searchable) {
          this._blurOnSelect = true;
        }
      }
    },
    clear: function clear() {
      var _this20 = this;

      if (this.hasValue) {
        if (this.single || this.allowClearingDisabled) {
          this.forest.selectedNodeIds = [];
        } else {
            this.forest.selectedNodeIds = this.forest.selectedNodeIds.filter(function (nodeId) {
              return _this20.getNode(nodeId).isDisabled;
            });
          }

        this.buildForestState();
      }
    },
    _selectNode: function _selectNode(node) {
      var _this21 = this;

      if (this.single || this.disableBranchNodes) {
        return this.addValue(node);
      }

      if (this.flat) {
        this.addValue(node);

        if (this.autoSelectAncestors) {
          node.ancestors.forEach(function (ancestor) {
            if (!_this21.isSelected(ancestor) && !ancestor.isDisabled) _this21.addValue(ancestor);
          });
        } else if (this.autoSelectDescendants) {
          this.traverseDescendantsBFS(node, function (descendant) {
            if (!_this21.isSelected(descendant) && !descendant.isDisabled) _this21.addValue(descendant);
          });
        }

        return;
      }

      var isFullyChecked = node.isLeaf || !node.hasDisabledDescendants || this.allowSelectingDisabledDescendants;

      if (isFullyChecked) {
        this.addValue(node);
      }

      if (node.isBranch) {
        this.traverseDescendantsBFS(node, function (descendant) {
          if (!descendant.isDisabled || _this21.allowSelectingDisabledDescendants) {
            _this21.addValue(descendant);
          }
        });
      }

      if (isFullyChecked) {
        var curr = node;

        while ((curr = curr.parentNode) !== NO_PARENT_NODE) {
          if (curr.children.every(this.isSelected)) this.addValue(curr);else break;
        }
      }
    },
    _deselectNode: function _deselectNode(node) {
      var _this22 = this;

      if (this.disableBranchNodes) {
        return this.removeValue(node);
      }

      if (this.flat) {
        this.removeValue(node);

        if (this.autoDeselectAncestors) {
          node.ancestors.forEach(function (ancestor) {
            if (_this22.isSelected(ancestor) && !ancestor.isDisabled) _this22.removeValue(ancestor);
          });
        } else if (this.autoDeselectDescendants) {
          this.traverseDescendantsBFS(node, function (descendant) {
            if (_this22.isSelected(descendant) && !descendant.isDisabled) _this22.removeValue(descendant);
          });
        }

        return;
      }

      var hasUncheckedSomeDescendants = false;

      if (node.isBranch) {
        this.traverseDescendantsDFS(node, function (descendant) {
          if (!descendant.isDisabled || _this22.allowSelectingDisabledDescendants) {
            _this22.removeValue(descendant);

            hasUncheckedSomeDescendants = true;
          }
        });
      }

      if (node.isLeaf || hasUncheckedSomeDescendants || node.children.length === 0) {
        this.removeValue(node);
        var curr = node;

        while ((curr = curr.parentNode) !== NO_PARENT_NODE) {
          if (this.isSelected(curr)) this.removeValue(curr);else break;
        }
      }
    },
    addValue: function addValue(node) {
      this.forest.selectedNodeIds.push(node.id);
      this.forest.selectedNodeMap[node.id] = true;
    },
    removeValue: function removeValue(node) {
      removeFromArray(this.forest.selectedNodeIds, node.id);
      delete this.forest.selectedNodeMap[node.id];
    },
    removeLastValue: function removeLastValue() {
      if (!this.hasValue) return;
      if (this.single) return this.clear();
      var lastValue = last_default()(this.internalValue);
      var lastSelectedNode = this.getNode(lastValue);
      this.select(lastSelectedNode);
    },
    saveMenuScrollPosition: function saveMenuScrollPosition() {
      var $menu = this.getMenu();
      if ($menu) this.menu.lastScrollPosition = $menu.scrollTop;
    },
    restoreMenuScrollPosition: function restoreMenuScrollPosition() {
      var $menu = this.getMenu();
      if ($menu) $menu.scrollTop = this.menu.lastScrollPosition;
    }
  },
  created: function created() {
    this.verifyProps();
    this.resetFlags();
  },
  mounted: function mounted() {
    if (this.autoFocus) this.focusInput();
    if (!this.options && !this.async && this.autoLoadRootOptions) this.loadRootOptions();
    if (this.alwaysOpen) this.openMenu();
    if (this.async && this.defaultOptions) this.handleRemoteSearch();
  },
  destroyed: function destroyed() {
    this.toggleClickOutsideEvent(false);
  }
});
// CONCATENATED MODULE: ./node_modules/cache-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./src/components/HiddenFields.vue?vue&type=script&lang=js&


function stringifyValue(value) {
  if (typeof value === 'string') return value;
  if (value != null && !isNaN_isNaN(value)) return JSON.stringify(value);
  return '';
}

/* harmony default export */ var HiddenFieldsvue_type_script_lang_js_ = ({
  name: 'vue-treeselect--hidden-fields',
  inject: ['instance'],
  functional: true,
  render: function render(_, context) {
    var h = arguments[0];
    var instance = context.injections.instance;
    if (!instance.name || instance.disabled || !instance.hasValue) return null;
    var stringifiedValues = instance.internalValue.map(stringifyValue);
    if (instance.multiple && instance.joinValues) stringifiedValues = [stringifiedValues.join(instance.delimiter)];
    return stringifiedValues.map(function (stringifiedValue, i) {
      return h("input", {
        attrs: {
          type: "hidden",
          name: instance.name
        },
        domProps: {
          "value": stringifiedValue
        },
        key: 'hidden-field-' + i
      });
    });
  }
});
// CONCATENATED MODULE: ./src/components/HiddenFields.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_HiddenFieldsvue_type_script_lang_js_ = (HiddenFieldsvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/runtime/componentNormalizer.js
/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file (except for modules).
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

function normalizeComponent (
  scriptExports,
  render,
  staticRenderFns,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier, /* server only */
  shadowMode /* vue-cli only */
) {
  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (render) {
    options.render = render
    options.staticRenderFns = staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = 'data-v-' + scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = shadowMode
      ? function () { injectStyles.call(this, this.$root.$options.shadowRoot) }
      : injectStyles
  }

  if (hook) {
    if (options.functional) {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      var originalRender = options.render
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return originalRender(h, context)
      }
    } else {
      // inject component registration as beforeCreate hook
      var existing = options.beforeCreate
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    }
  }

  return {
    exports: scriptExports,
    options: options
  }
}

// CONCATENATED MODULE: ./src/components/HiddenFields.vue
var HiddenFields_render, staticRenderFns




/* normalize component */

var component = normalizeComponent(
  components_HiddenFieldsvue_type_script_lang_js_,
  HiddenFields_render,
  staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "src/components/HiddenFields.vue"
/* harmony default export */ var HiddenFields = (component.exports);
// EXTERNAL MODULE: external "babel-helper-vue-jsx-merge-props"
var external_babel_helper_vue_jsx_merge_props_ = __nested_webpack_require_5479__(13);
var external_babel_helper_vue_jsx_merge_props_default = /*#__PURE__*/__nested_webpack_require_5479__.n(external_babel_helper_vue_jsx_merge_props_);

// CONCATENATED MODULE: ./node_modules/cache-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./src/components/Input.vue?vue&type=script&lang=js&



var keysThatRequireMenuBeingOpen = [KEY_CODES.ENTER, KEY_CODES.END, KEY_CODES.HOME, KEY_CODES.ARROW_LEFT, KEY_CODES.ARROW_UP, KEY_CODES.ARROW_RIGHT, KEY_CODES.ARROW_DOWN];
/* harmony default export */ var Inputvue_type_script_lang_js_ = ({
  name: 'vue-treeselect--input',
  inject: ['instance'],
  data: function data() {
    return {
      inputWidth: MIN_INPUT_WIDTH,
      value: ''
    };
  },
  computed: {
    needAutoSize: function needAutoSize() {
      var instance = this.instance;
      return instance.searchable && !instance.disabled && instance.multiple;
    },
    inputStyle: function inputStyle() {
      return {
        width: this.needAutoSize ? "".concat(this.inputWidth, "px") : null
      };
    }
  },
  watch: {
    'instance.trigger.searchQuery': function instanceTriggerSearchQuery(newValue) {
      this.value = newValue;
    },
    value: function value() {
      if (this.needAutoSize) this.$nextTick(this.updateInputWidth);
    }
  },
  created: function created() {
    this.debouncedCallback = debounce_default()(this.updateSearchQuery, INPUT_DEBOUNCE_DELAY, {
      leading: true,
      trailing: true
    });
  },
  methods: {
    clear: function clear() {
      this.onInput({
        target: {
          value: ''
        }
      });
    },
    focus: function focus() {
      var instance = this.instance;

      if (!instance.disabled) {
        this.$refs.input && this.$refs.input.focus();
      }
    },
    blur: function blur() {
      this.$refs.input && this.$refs.input.blur();
    },
    onFocus: function onFocus() {
      var instance = this.instance;
      instance.trigger.isFocused = true;
      if (instance.openOnFocus) instance.openMenu();
    },
    onBlur: function onBlur() {
      var instance = this.instance;
      var menu = instance.getMenu();

      if (menu && document.activeElement === menu) {
        return this.focus();
      }

      instance.trigger.isFocused = false;
      instance.closeMenu();
    },
    onInput: function onInput(evt) {
      var value = evt.target.value;
      this.value = value;

      if (value) {
        this.debouncedCallback();
      } else {
        this.debouncedCallback.cancel();
        this.updateSearchQuery();
      }
    },
    onKeyDown: function onKeyDown(evt) {
      var instance = this.instance;
      var key = 'which' in evt ? evt.which : evt.keyCode;
      if (evt.ctrlKey || evt.shiftKey || evt.altKey || evt.metaKey) return;

      if (!instance.menu.isOpen && includes(keysThatRequireMenuBeingOpen, key)) {
        evt.preventDefault();
        return instance.openMenu();
      }

      switch (key) {
        case KEY_CODES.BACKSPACE:
          {
            if (instance.backspaceRemoves && !this.value.length) {
              instance.removeLastValue();
            }

            break;
          }

        case KEY_CODES.ENTER:
          {
            evt.preventDefault();
            if (instance.menu.current === null) return;
            var current = instance.getNode(instance.menu.current);
            if (current.isBranch && instance.disableBranchNodes) return;
            instance.select(current);
            break;
          }

        case KEY_CODES.ESCAPE:
          {
            if (this.value.length) {
              this.clear();
            } else if (instance.menu.isOpen) {
              instance.closeMenu();
            }

            break;
          }

        case KEY_CODES.END:
          {
            evt.preventDefault();
            instance.highlightLastOption();
            break;
          }

        case KEY_CODES.HOME:
          {
            evt.preventDefault();
            instance.highlightFirstOption();
            break;
          }

        case KEY_CODES.ARROW_LEFT:
          {
            var _current = instance.getNode(instance.menu.current);

            if (_current.isBranch && instance.shouldExpand(_current)) {
              evt.preventDefault();
              instance.toggleExpanded(_current);
            } else if (!_current.isRootNode && (_current.isLeaf || _current.isBranch && !instance.shouldExpand(_current))) {
              evt.preventDefault();
              instance.setCurrentHighlightedOption(_current.parentNode);
            }

            break;
          }

        case KEY_CODES.ARROW_UP:
          {
            evt.preventDefault();
            instance.highlightPrevOption();
            break;
          }

        case KEY_CODES.ARROW_RIGHT:
          {
            var _current2 = instance.getNode(instance.menu.current);

            if (_current2.isBranch && !instance.shouldExpand(_current2)) {
              evt.preventDefault();
              instance.toggleExpanded(_current2);
            }

            break;
          }

        case KEY_CODES.ARROW_DOWN:
          {
            evt.preventDefault();
            instance.highlightNextOption();
            break;
          }

        case KEY_CODES.DELETE:
          {
            if (instance.deleteRemoves && !this.value.length) {
              instance.removeLastValue();
            }

            break;
          }

        default:
          {
            instance.openMenu();
          }
      }
    },
    onMouseDown: function onMouseDown(evt) {
      if (this.value.length) {
        evt.stopPropagation();
      }
    },
    renderInputContainer: function renderInputContainer() {
      var h = this.$createElement;
      var instance = this.instance;
      var props = {};
      var children = [];

      if (instance.searchable && !instance.disabled) {
        children.push(this.renderInput());
        if (this.needAutoSize) children.push(this.renderSizer());
      }

      if (!instance.searchable) {
        deepExtend(props, {
          on: {
            focus: this.onFocus,
            blur: this.onBlur,
            keydown: this.onKeyDown
          },
          ref: 'input'
        });
      }

      if (!instance.searchable && !instance.disabled) {
        deepExtend(props, {
          attrs: {
            tabIndex: instance.tabIndex
          }
        });
      }

      return h("div", external_babel_helper_vue_jsx_merge_props_default()([{
        "class": "vue-treeselect__input-container"
      }, props]), [children]);
    },
    renderInput: function renderInput() {
      var h = this.$createElement;
      var instance = this.instance;
      return h("input", {
        ref: "input",
        "class": "vue-treeselect__input",
        attrs: {
          type: "text",
          autocomplete: "off",
          tabIndex: instance.tabIndex,
          required: instance.required && !instance.hasValue
        },
        domProps: {
          "value": this.value
        },
        style: this.inputStyle,
        on: {
          "focus": this.onFocus,
          "input": this.onInput,
          "blur": this.onBlur,
          "keydown": this.onKeyDown,
          "mousedown": this.onMouseDown
        }
      });
    },
    renderSizer: function renderSizer() {
      var h = this.$createElement;
      return h("div", {
        ref: "sizer",
        "class": "vue-treeselect__sizer"
      }, [this.value]);
    },
    updateInputWidth: function updateInputWidth() {
      this.inputWidth = Math.max(MIN_INPUT_WIDTH, this.$refs.sizer.scrollWidth + 15);
    },
    updateSearchQuery: function updateSearchQuery() {
      var instance = this.instance;
      instance.trigger.searchQuery = this.value;
    }
  },
  render: function render() {
    return this.renderInputContainer();
  }
});
// CONCATENATED MODULE: ./src/components/Input.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_Inputvue_type_script_lang_js_ = (Inputvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./src/components/Input.vue
var Input_render, Input_staticRenderFns




/* normalize component */

var Input_component = normalizeComponent(
  components_Inputvue_type_script_lang_js_,
  Input_render,
  Input_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var Input_api; }
Input_component.options.__file = "src/components/Input.vue"
/* harmony default export */ var Input = (Input_component.exports);
// CONCATENATED MODULE: ./node_modules/cache-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./src/components/Placeholder.vue?vue&type=script&lang=js&
/* harmony default export */ var Placeholdervue_type_script_lang_js_ = ({
  name: 'vue-treeselect--placeholder',
  inject: ['instance'],
  render: function render() {
    var h = arguments[0];
    var instance = this.instance;
    var placeholderClass = {
      'vue-treeselect__placeholder': true,
      'vue-treeselect-helper-zoom-effect-off': true,
      'vue-treeselect-helper-hide': instance.hasValue || instance.trigger.searchQuery
    };
    return h("div", {
      "class": placeholderClass
    }, [instance.placeholder]);
  }
});
// CONCATENATED MODULE: ./src/components/Placeholder.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_Placeholdervue_type_script_lang_js_ = (Placeholdervue_type_script_lang_js_); 
// CONCATENATED MODULE: ./src/components/Placeholder.vue
var Placeholder_render, Placeholder_staticRenderFns




/* normalize component */

var Placeholder_component = normalizeComponent(
  components_Placeholdervue_type_script_lang_js_,
  Placeholder_render,
  Placeholder_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var Placeholder_api; }
Placeholder_component.options.__file = "src/components/Placeholder.vue"
/* harmony default export */ var Placeholder = (Placeholder_component.exports);
// CONCATENATED MODULE: ./node_modules/cache-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./src/components/SingleValue.vue?vue&type=script&lang=js&


/* harmony default export */ var SingleValuevue_type_script_lang_js_ = ({
  name: 'vue-treeselect--single-value',
  inject: ['instance'],
  methods: {
    renderSingleValueLabel: function renderSingleValueLabel() {
      var instance = this.instance;
      var node = instance.selectedNodes[0];
      var customValueLabelRenderer = instance.$scopedSlots['value-label'];
      return customValueLabelRenderer ? customValueLabelRenderer({
        node: node
      }) : node.label;
    }
  },
  render: function render() {
    var h = arguments[0];
    var instance = this.instance,
        renderValueContainer = this.$parent.renderValueContainer;
    var shouldShowValue = instance.hasValue && !instance.trigger.searchQuery;
    return renderValueContainer([shouldShowValue && h("div", {
      "class": "vue-treeselect__single-value"
    }, [this.renderSingleValueLabel()]), h(Placeholder), h(Input, {
      ref: "input"
    })]);
  }
});
// CONCATENATED MODULE: ./src/components/SingleValue.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_SingleValuevue_type_script_lang_js_ = (SingleValuevue_type_script_lang_js_); 
// CONCATENATED MODULE: ./src/components/SingleValue.vue
var SingleValue_render, SingleValue_staticRenderFns




/* normalize component */

var SingleValue_component = normalizeComponent(
  components_SingleValuevue_type_script_lang_js_,
  SingleValue_render,
  SingleValue_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var SingleValue_api; }
SingleValue_component.options.__file = "src/components/SingleValue.vue"
/* harmony default export */ var SingleValue = (SingleValue_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/cache-loader/dist/cjs.js!./node_modules/vue-loader/lib??vue-loader-options!./src/components/icons/Delete.vue?vue&type=template&id=364b6320&
var Deletevue_type_template_id_364b6320_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "svg",
    {
      attrs: {
        xmlns: "http://www.w3.org/2000/svg",
        viewBox: "0 0 348.333 348.333"
      }
    },
    [
      _c("path", {
        attrs: {
          d:
            "M336.559 68.611L231.016 174.165l105.543 105.549c15.699 15.705 15.699 41.145 0 56.85-7.844 7.844-18.128 11.769-28.407 11.769-10.296 0-20.581-3.919-28.419-11.769L174.167 231.003 68.609 336.563c-7.843 7.844-18.128 11.769-28.416 11.769-10.285 0-20.563-3.919-28.413-11.769-15.699-15.698-15.699-41.139 0-56.85l105.54-105.549L11.774 68.611c-15.699-15.699-15.699-41.145 0-56.844 15.696-15.687 41.127-15.687 56.829 0l105.563 105.554L279.721 11.767c15.705-15.687 41.139-15.687 56.832 0 15.705 15.699 15.705 41.145.006 56.844z"
        }
      })
    ]
  )
}
var Deletevue_type_template_id_364b6320_staticRenderFns = []
Deletevue_type_template_id_364b6320_render._withStripped = true


// CONCATENATED MODULE: ./src/components/icons/Delete.vue?vue&type=template&id=364b6320&

// CONCATENATED MODULE: ./node_modules/cache-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./src/components/icons/Delete.vue?vue&type=script&lang=js&
/* harmony default export */ var Deletevue_type_script_lang_js_ = ({
  name: 'vue-treeselect--x'
});
// CONCATENATED MODULE: ./src/components/icons/Delete.vue?vue&type=script&lang=js&
 /* harmony default export */ var icons_Deletevue_type_script_lang_js_ = (Deletevue_type_script_lang_js_); 
// CONCATENATED MODULE: ./src/components/icons/Delete.vue





/* normalize component */

var Delete_component = normalizeComponent(
  icons_Deletevue_type_script_lang_js_,
  Deletevue_type_template_id_364b6320_render,
  Deletevue_type_template_id_364b6320_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var Delete_api; }
Delete_component.options.__file = "src/components/icons/Delete.vue"
/* harmony default export */ var Delete = (Delete_component.exports);
// CONCATENATED MODULE: ./node_modules/cache-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./src/components/MultiValueItem.vue?vue&type=script&lang=js&


/* harmony default export */ var MultiValueItemvue_type_script_lang_js_ = ({
  name: 'vue-treeselect--multi-value-item',
  inject: ['instance'],
  props: {
    node: {
      type: Object,
      required: true
    }
  },
  methods: {
    handleMouseDown: onLeftClick(function handleMouseDown() {
      var instance = this.instance,
          node = this.node;
      instance.select(node);
    })
  },
  render: function render() {
    var h = arguments[0];
    var instance = this.instance,
        node = this.node;
    var itemClass = {
      'vue-treeselect__multi-value-item': true,
      'vue-treeselect__multi-value-item-disabled': node.isDisabled,
      'vue-treeselect__multi-value-item-new': node.isNew
    };
    var customValueLabelRenderer = instance.$scopedSlots['value-label'];
    var labelRenderer = customValueLabelRenderer ? customValueLabelRenderer({
      node: node
    }) : node.label;
    return h("div", {
      "class": "vue-treeselect__multi-value-item-container"
    }, [h("div", {
      "class": itemClass,
      on: {
        "mousedown": this.handleMouseDown
      }
    }, [h("span", {
      "class": "vue-treeselect__multi-value-label"
    }, [labelRenderer]), h("span", {
      "class": "vue-treeselect__icon vue-treeselect__value-remove"
    }, [h(Delete)])])]);
  }
});
// CONCATENATED MODULE: ./src/components/MultiValueItem.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_MultiValueItemvue_type_script_lang_js_ = (MultiValueItemvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./src/components/MultiValueItem.vue
var MultiValueItem_render, MultiValueItem_staticRenderFns




/* normalize component */

var MultiValueItem_component = normalizeComponent(
  components_MultiValueItemvue_type_script_lang_js_,
  MultiValueItem_render,
  MultiValueItem_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var MultiValueItem_api; }
MultiValueItem_component.options.__file = "src/components/MultiValueItem.vue"
/* harmony default export */ var MultiValueItem = (MultiValueItem_component.exports);
// CONCATENATED MODULE: ./node_modules/cache-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./src/components/MultiValue.vue?vue&type=script&lang=js&




/* harmony default export */ var MultiValuevue_type_script_lang_js_ = ({
  name: 'vue-treeselect--multi-value',
  inject: ['instance'],
  methods: {
    renderMultiValueItems: function renderMultiValueItems() {
      var h = this.$createElement;
      var instance = this.instance;
      return instance.internalValue.slice(0, instance.limit).map(instance.getNode).map(function (node) {
        return h(MultiValueItem, {
          key: "multi-value-item-".concat(node.id),
          attrs: {
            node: node
          }
        });
      });
    },
    renderExceedLimitTip: function renderExceedLimitTip() {
      var h = this.$createElement;
      var instance = this.instance;
      var count = instance.internalValue.length - instance.limit;
      if (count <= 0) return null;
      return h("div", {
        "class": "vue-treeselect__limit-tip vue-treeselect-helper-zoom-effect-off",
        key: "exceed-limit-tip"
      }, [h("span", {
        "class": "vue-treeselect__limit-tip-text"
      }, [instance.limitText(count)])]);
    }
  },
  render: function render() {
    var h = arguments[0];
    var renderValueContainer = this.$parent.renderValueContainer;
    var transitionGroupProps = {
      props: {
        tag: 'div',
        name: 'vue-treeselect__multi-value-item--transition',
        appear: true
      }
    };
    return renderValueContainer(h("transition-group", external_babel_helper_vue_jsx_merge_props_default()([{
      "class": "vue-treeselect__multi-value"
    }, transitionGroupProps]), [this.renderMultiValueItems(), this.renderExceedLimitTip(), h(Placeholder, {
      key: "placeholder"
    }), h(Input, {
      ref: "input",
      key: "input"
    })]));
  }
});
// CONCATENATED MODULE: ./src/components/MultiValue.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_MultiValuevue_type_script_lang_js_ = (MultiValuevue_type_script_lang_js_); 
// CONCATENATED MODULE: ./src/components/MultiValue.vue
var MultiValue_render, MultiValue_staticRenderFns




/* normalize component */

var MultiValue_component = normalizeComponent(
  components_MultiValuevue_type_script_lang_js_,
  MultiValue_render,
  MultiValue_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var MultiValue_api; }
MultiValue_component.options.__file = "src/components/MultiValue.vue"
/* harmony default export */ var MultiValue = (MultiValue_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/cache-loader/dist/cjs.js!./node_modules/vue-loader/lib??vue-loader-options!./src/components/icons/Arrow.vue?vue&type=template&id=11186cd4&
var Arrowvue_type_template_id_11186cd4_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "svg",
    {
      attrs: {
        xmlns: "http://www.w3.org/2000/svg",
        viewBox: "0 0 292.362 292.362"
      }
    },
    [
      _c("path", {
        attrs: {
          d:
            "M286.935 69.377c-3.614-3.617-7.898-5.424-12.848-5.424H18.274c-4.952 0-9.233 1.807-12.85 5.424C1.807 72.998 0 77.279 0 82.228c0 4.948 1.807 9.229 5.424 12.847l127.907 127.907c3.621 3.617 7.902 5.428 12.85 5.428s9.233-1.811 12.847-5.428L286.935 95.074c3.613-3.617 5.427-7.898 5.427-12.847 0-4.948-1.814-9.229-5.427-12.85z"
        }
      })
    ]
  )
}
var Arrowvue_type_template_id_11186cd4_staticRenderFns = []
Arrowvue_type_template_id_11186cd4_render._withStripped = true


// CONCATENATED MODULE: ./src/components/icons/Arrow.vue?vue&type=template&id=11186cd4&

// CONCATENATED MODULE: ./node_modules/cache-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./src/components/icons/Arrow.vue?vue&type=script&lang=js&
/* harmony default export */ var Arrowvue_type_script_lang_js_ = ({
  name: 'vue-treeselect--arrow'
});
// CONCATENATED MODULE: ./src/components/icons/Arrow.vue?vue&type=script&lang=js&
 /* harmony default export */ var icons_Arrowvue_type_script_lang_js_ = (Arrowvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./src/components/icons/Arrow.vue





/* normalize component */

var Arrow_component = normalizeComponent(
  icons_Arrowvue_type_script_lang_js_,
  Arrowvue_type_template_id_11186cd4_render,
  Arrowvue_type_template_id_11186cd4_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var Arrow_api; }
Arrow_component.options.__file = "src/components/icons/Arrow.vue"
/* harmony default export */ var Arrow = (Arrow_component.exports);
// CONCATENATED MODULE: ./node_modules/cache-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./src/components/Control.vue?vue&type=script&lang=js&





/* harmony default export */ var Controlvue_type_script_lang_js_ = ({
  name: 'vue-treeselect--control',
  inject: ['instance'],
  computed: {
    shouldShowX: function shouldShowX() {
      var instance = this.instance;
      return instance.clearable && !instance.disabled && instance.hasValue && (this.hasUndisabledValue || instance.allowClearingDisabled);
    },
    shouldShowArrow: function shouldShowArrow() {
      var instance = this.instance;
      if (!instance.alwaysOpen) return true;
      return !instance.menu.isOpen;
    },
    hasUndisabledValue: function hasUndisabledValue() {
      var instance = this.instance;
      return instance.hasValue && instance.internalValue.some(function (id) {
        return !instance.getNode(id).isDisabled;
      });
    }
  },
  methods: {
    renderX: function renderX() {
      var h = this.$createElement;
      var instance = this.instance;
      var title = instance.multiple ? instance.clearAllText : instance.clearValueText;
      if (!this.shouldShowX) return null;
      return h("div", {
        "class": "vue-treeselect__x-container",
        attrs: {
          title: title
        },
        on: {
          "mousedown": this.handleMouseDownOnX
        }
      }, [h(Delete, {
        "class": "vue-treeselect__x"
      })]);
    },
    renderArrow: function renderArrow() {
      var h = this.$createElement;
      var instance = this.instance;
      var arrowClass = {
        'vue-treeselect__control-arrow': true,
        'vue-treeselect__control-arrow--rotated': instance.menu.isOpen
      };
      if (!this.shouldShowArrow) return null;
      return h("div", {
        "class": "vue-treeselect__control-arrow-container",
        on: {
          "mousedown": this.handleMouseDownOnArrow
        }
      }, [h(Arrow, {
        "class": arrowClass
      })]);
    },
    handleMouseDownOnX: onLeftClick(function handleMouseDownOnX(evt) {
      evt.stopPropagation();
      evt.preventDefault();
      var instance = this.instance;
      var result = instance.beforeClearAll();

      var handler = function handler(shouldClear) {
        if (shouldClear) instance.clear();
      };

      if (external_is_promise_default()(result)) {
        result.then(handler);
      } else {
        setTimeout(function () {
          return handler(result);
        }, 0);
      }
    }),
    handleMouseDownOnArrow: onLeftClick(function handleMouseDownOnArrow(evt) {
      evt.preventDefault();
      evt.stopPropagation();
      var instance = this.instance;
      instance.focusInput();
      instance.toggleMenu();
    }),
    renderValueContainer: function renderValueContainer(children) {
      var h = this.$createElement;
      return h("div", {
        "class": "vue-treeselect__value-container"
      }, [children]);
    }
  },
  render: function render() {
    var h = arguments[0];
    var instance = this.instance;
    var ValueContainer = instance.single ? SingleValue : MultiValue;
    return h("div", {
      "class": "vue-treeselect__control",
      on: {
        "mousedown": instance.handleMouseDown
      }
    }, [h(ValueContainer, {
      ref: "value-container"
    }), this.renderX(), this.renderArrow()]);
  }
});
// CONCATENATED MODULE: ./src/components/Control.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_Controlvue_type_script_lang_js_ = (Controlvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./src/components/Control.vue
var Control_render, Control_staticRenderFns




/* normalize component */

var Control_component = normalizeComponent(
  components_Controlvue_type_script_lang_js_,
  Control_render,
  Control_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var Control_api; }
Control_component.options.__file = "src/components/Control.vue"
/* harmony default export */ var Control = (Control_component.exports);
// CONCATENATED MODULE: ./node_modules/cache-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./src/components/Tip.vue?vue&type=script&lang=js&
/* harmony default export */ var Tipvue_type_script_lang_js_ = ({
  name: 'vue-treeselect--tip',
  functional: true,
  props: {
    type: {
      type: String,
      required: true
    },
    icon: {
      type: String,
      required: true
    }
  },
  render: function render(_, context) {
    var h = arguments[0];
    var props = context.props,
        children = context.children;
    return h("div", {
      "class": "vue-treeselect__tip vue-treeselect__".concat(props.type, "-tip")
    }, [h("div", {
      "class": "vue-treeselect__icon-container"
    }, [h("span", {
      "class": "vue-treeselect__icon-".concat(props.icon)
    })]), h("span", {
      "class": "vue-treeselect__tip-text vue-treeselect__".concat(props.type, "-tip-text")
    }, [children])]);
  }
});
// CONCATENATED MODULE: ./src/components/Tip.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_Tipvue_type_script_lang_js_ = (Tipvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./src/components/Tip.vue
var Tip_render, Tip_staticRenderFns




/* normalize component */

var Tip_component = normalizeComponent(
  components_Tipvue_type_script_lang_js_,
  Tip_render,
  Tip_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var Tip_api; }
Tip_component.options.__file = "src/components/Tip.vue"
/* harmony default export */ var Tip = (Tip_component.exports);
// CONCATENATED MODULE: ./node_modules/cache-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./src/components/Option.vue?vue&type=script&lang=js&





var arrowPlaceholder, checkMark, minusMark;
var Option = {
  name: 'vue-treeselect--option',
  inject: ['instance'],
  props: {
    node: {
      type: Object,
      required: true
    }
  },
  computed: {
    shouldExpand: function shouldExpand() {
      var instance = this.instance,
          node = this.node;
      return node.isBranch && instance.shouldExpand(node);
    },
    shouldShow: function shouldShow() {
      var instance = this.instance,
          node = this.node;
      return instance.shouldShowOptionInMenu(node);
    }
  },
  methods: {
    renderOption: function renderOption() {
      var h = this.$createElement;
      var instance = this.instance,
          node = this.node;
      var optionClass = {
        'vue-treeselect__option': true,
        'vue-treeselect__option--disabled': node.isDisabled,
        'vue-treeselect__option--selected': instance.isSelected(node),
        'vue-treeselect__option--highlight': node.isHighlighted,
        'vue-treeselect__option--matched': instance.localSearch.active && node.isMatched,
        'vue-treeselect__option--hide': !this.shouldShow
      };
      return h("div", {
        "class": optionClass,
        on: {
          "mouseenter": this.handleMouseEnterOption
        },
        attrs: {
          "data-id": node.id
        }
      }, [this.renderArrow(), this.renderLabelContainer([this.renderCheckboxContainer([this.renderCheckbox()]), this.renderLabel()])]);
    },
    renderSubOptionsList: function renderSubOptionsList() {
      var h = this.$createElement;
      if (!this.shouldExpand) return null;
      return h("div", {
        "class": "vue-treeselect__list"
      }, [this.renderSubOptions(), this.renderNoChildrenTip(), this.renderLoadingChildrenTip(), this.renderLoadingChildrenErrorTip()]);
    },
    renderArrow: function renderArrow() {
      var h = this.$createElement;
      var instance = this.instance,
          node = this.node;
      if (instance.shouldFlattenOptions && this.shouldShow) return null;

      if (node.isBranch) {
        var transitionProps = {
          props: {
            name: 'vue-treeselect__option-arrow--prepare',
            appear: true
          }
        };
        var arrowClass = {
          'vue-treeselect__option-arrow': true,
          'vue-treeselect__option-arrow--rotated': this.shouldExpand
        };
        return h("div", {
          "class": "vue-treeselect__option-arrow-container",
          on: {
            "mousedown": this.handleMouseDownOnArrow
          }
        }, [h("transition", transitionProps, [h(Arrow, {
          "class": arrowClass
        })])]);
      }

      if (instance.hasBranchNodes) {
        if (!arrowPlaceholder) arrowPlaceholder = h("div", {
          "class": "vue-treeselect__option-arrow-placeholder"
        }, ["\xA0"]);
        return arrowPlaceholder;
      }

      return null;
    },
    renderLabelContainer: function renderLabelContainer(children) {
      var h = this.$createElement;
      return h("div", {
        "class": "vue-treeselect__label-container",
        on: {
          "mousedown": this.handleMouseDownOnLabelContainer
        }
      }, [children]);
    },
    renderCheckboxContainer: function renderCheckboxContainer(children) {
      var h = this.$createElement;
      var instance = this.instance,
          node = this.node;
      if (instance.single) return null;
      if (instance.disableBranchNodes && node.isBranch) return null;
      return h("div", {
        "class": "vue-treeselect__checkbox-container"
      }, [children]);
    },
    renderCheckbox: function renderCheckbox() {
      var h = this.$createElement;
      var instance = this.instance,
          node = this.node;
      var checkedState = instance.forest.checkedStateMap[node.id];
      var checkboxClass = {
        'vue-treeselect__checkbox': true,
        'vue-treeselect__checkbox--checked': checkedState === CHECKED,
        'vue-treeselect__checkbox--indeterminate': checkedState === INDETERMINATE,
        'vue-treeselect__checkbox--unchecked': checkedState === UNCHECKED,
        'vue-treeselect__checkbox--disabled': node.isDisabled
      };
      if (!checkMark) checkMark = h("span", {
        "class": "vue-treeselect__check-mark"
      });
      if (!minusMark) minusMark = h("span", {
        "class": "vue-treeselect__minus-mark"
      });
      return h("span", {
        "class": checkboxClass
      }, [checkMark, minusMark]);
    },
    renderLabel: function renderLabel() {
      var h = this.$createElement;
      var instance = this.instance,
          node = this.node;
      var shouldShowCount = node.isBranch && (instance.localSearch.active ? instance.showCountOnSearchComputed : instance.showCount);
      var count = shouldShowCount ? instance.localSearch.active ? instance.localSearch.countMap[node.id][instance.showCountOf] : node.count[instance.showCountOf] : NaN;
      var labelClassName = 'vue-treeselect__label';
      var countClassName = 'vue-treeselect__count';
      var customLabelRenderer = instance.$scopedSlots['option-label'];
      if (customLabelRenderer) return customLabelRenderer({
        node: node,
        shouldShowCount: shouldShowCount,
        count: count,
        labelClassName: labelClassName,
        countClassName: countClassName
      });
      return h("label", {
        "class": labelClassName
      }, [node.label, shouldShowCount && h("span", {
        "class": countClassName
      }, ["(", count, ")"])]);
    },
    renderSubOptions: function renderSubOptions() {
      var h = this.$createElement;
      var node = this.node;
      if (!node.childrenStates.isLoaded) return null;
      return node.children.map(function (childNode) {
        return h(Option, {
          attrs: {
            node: childNode
          },
          key: childNode.id
        });
      });
    },
    renderNoChildrenTip: function renderNoChildrenTip() {
      var h = this.$createElement;
      var instance = this.instance,
          node = this.node;
      if (!node.childrenStates.isLoaded || node.children.length) return null;
      return h(Tip, {
        attrs: {
          type: "no-children",
          icon: "warning"
        }
      }, [instance.noChildrenText]);
    },
    renderLoadingChildrenTip: function renderLoadingChildrenTip() {
      var h = this.$createElement;
      var instance = this.instance,
          node = this.node;
      if (!node.childrenStates.isLoading) return null;
      return h(Tip, {
        attrs: {
          type: "loading",
          icon: "loader"
        }
      }, [instance.loadingText]);
    },
    renderLoadingChildrenErrorTip: function renderLoadingChildrenErrorTip() {
      var h = this.$createElement;
      var instance = this.instance,
          node = this.node;
      if (!node.childrenStates.loadingError) return null;
      return h(Tip, {
        attrs: {
          type: "error",
          icon: "error"
        }
      }, [node.childrenStates.loadingError, h("a", {
        "class": "vue-treeselect__retry",
        attrs: {
          title: instance.retryTitle
        },
        on: {
          "mousedown": this.handleMouseDownOnRetry
        }
      }, [instance.retryText])]);
    },
    handleMouseEnterOption: function handleMouseEnterOption(evt) {
      var instance = this.instance,
          node = this.node;
      if (evt.target !== evt.currentTarget) return;
      instance.setCurrentHighlightedOption(node, false);
    },
    handleMouseDownOnArrow: onLeftClick(function handleMouseDownOnOptionArrow() {
      var instance = this.instance,
          node = this.node;
      instance.toggleExpanded(node);
    }),
    handleMouseDownOnLabelContainer: onLeftClick(function handleMouseDownOnLabelContainer() {
      var instance = this.instance,
          node = this.node;

      if (node.isBranch && instance.disableBranchNodes) {
        instance.toggleExpanded(node);
      } else {
        instance.select(node);
      }
    }),
    handleMouseDownOnRetry: onLeftClick(function handleMouseDownOnRetry() {
      var instance = this.instance,
          node = this.node;
      instance.loadChildrenOptions(node);
    })
  },
  render: function render() {
    var h = arguments[0];
    var node = this.node;
    var indentLevel = this.instance.shouldFlattenOptions ? 0 : node.level;

    var listItemClass = defineProperty_default()({
      'vue-treeselect__list-item': true
    }, "vue-treeselect__indent-level-".concat(indentLevel), true);

    var transitionProps = {
      props: {
        name: 'vue-treeselect__list--transition'
      }
    };
    return h("div", {
      "class": listItemClass
    }, [this.renderOption(), node.isBranch && h("transition", transitionProps, [this.renderSubOptionsList()])]);
  }
};
/* harmony default export */ var Optionvue_type_script_lang_js_ = (Option);
// CONCATENATED MODULE: ./src/components/Option.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_Optionvue_type_script_lang_js_ = (Optionvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./src/components/Option.vue
var Option_render, Option_staticRenderFns




/* normalize component */

var Option_component = normalizeComponent(
  components_Optionvue_type_script_lang_js_,
  Option_render,
  Option_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var Option_api; }
Option_component.options.__file = "src/components/Option.vue"
/* harmony default export */ var components_Option = (Option_component.exports);
// CONCATENATED MODULE: ./node_modules/cache-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./src/components/Menu.vue?vue&type=script&lang=js&




var directionMap = {
  top: 'top',
  bottom: 'bottom',
  above: 'top',
  below: 'bottom'
};
/* harmony default export */ var Menuvue_type_script_lang_js_ = ({
  name: 'vue-treeselect--menu',
  inject: ['instance'],
  computed: {
    menuStyle: function menuStyle() {
      var instance = this.instance;
      return {
        maxHeight: instance.maxHeight + 'px'
      };
    },
    menuContainerStyle: function menuContainerStyle() {
      var instance = this.instance;
      return {
        zIndex: instance.appendToBody ? null : instance.zIndex
      };
    }
  },
  watch: {
    'instance.menu.isOpen': function instanceMenuIsOpen(newValue) {
      if (newValue) {
        this.$nextTick(this.onMenuOpen);
      } else {
        this.onMenuClose();
      }
    }
  },
  created: function created() {
    this.menuSizeWatcher = null;
    this.menuResizeAndScrollEventListeners = null;
  },
  mounted: function mounted() {
    var instance = this.instance;
    if (instance.menu.isOpen) this.$nextTick(this.onMenuOpen);
  },
  destroyed: function destroyed() {
    this.onMenuClose();
  },
  methods: {
    renderMenu: function renderMenu() {
      var h = this.$createElement;
      var instance = this.instance;
      if (!instance.menu.isOpen) return null;
      return h("div", {
        ref: "menu",
        "class": "vue-treeselect__menu",
        on: {
          "mousedown": instance.handleMouseDown
        },
        style: this.menuStyle
      }, [this.renderBeforeList(), instance.async ? this.renderAsyncSearchMenuInner() : instance.localSearch.active ? this.renderLocalSearchMenuInner() : this.renderNormalMenuInner(), this.renderAfterList()]);
    },
    renderBeforeList: function renderBeforeList() {
      var instance = this.instance;
      var beforeListRenderer = instance.$scopedSlots['before-list'];
      return beforeListRenderer ? beforeListRenderer() : null;
    },
    renderAfterList: function renderAfterList() {
      var instance = this.instance;
      var afterListRenderer = instance.$scopedSlots['after-list'];
      return afterListRenderer ? afterListRenderer() : null;
    },
    renderNormalMenuInner: function renderNormalMenuInner() {
      var instance = this.instance;

      if (instance.rootOptionsStates.isLoading) {
        return this.renderLoadingOptionsTip();
      } else if (instance.rootOptionsStates.loadingError) {
        return this.renderLoadingRootOptionsErrorTip();
      } else if (instance.rootOptionsStates.isLoaded && instance.forest.normalizedOptions.length === 0) {
        return this.renderNoAvailableOptionsTip();
      } else {
        return this.renderOptionList();
      }
    },
    renderLocalSearchMenuInner: function renderLocalSearchMenuInner() {
      var instance = this.instance;

      if (instance.rootOptionsStates.isLoading) {
        return this.renderLoadingOptionsTip();
      } else if (instance.rootOptionsStates.loadingError) {
        return this.renderLoadingRootOptionsErrorTip();
      } else if (instance.rootOptionsStates.isLoaded && instance.forest.normalizedOptions.length === 0) {
        return this.renderNoAvailableOptionsTip();
      } else if (instance.localSearch.noResults) {
        return this.renderNoResultsTip();
      } else {
        return this.renderOptionList();
      }
    },
    renderAsyncSearchMenuInner: function renderAsyncSearchMenuInner() {
      var instance = this.instance;
      var entry = instance.getRemoteSearchEntry();
      var shouldShowSearchPromptTip = instance.trigger.searchQuery === '' && !instance.defaultOptions;
      var shouldShowNoResultsTip = shouldShowSearchPromptTip ? false : entry.isLoaded && entry.options.length === 0;

      if (shouldShowSearchPromptTip) {
        return this.renderSearchPromptTip();
      } else if (entry.isLoading) {
        return this.renderLoadingOptionsTip();
      } else if (entry.loadingError) {
        return this.renderAsyncSearchLoadingErrorTip();
      } else if (shouldShowNoResultsTip) {
        return this.renderNoResultsTip();
      } else {
        return this.renderOptionList();
      }
    },
    renderOptionList: function renderOptionList() {
      var h = this.$createElement;
      var instance = this.instance;
      return h("div", {
        "class": "vue-treeselect__list"
      }, [instance.forest.normalizedOptions.map(function (rootNode) {
        return h(components_Option, {
          attrs: {
            node: rootNode
          },
          key: rootNode.id
        });
      })]);
    },
    renderSearchPromptTip: function renderSearchPromptTip() {
      var h = this.$createElement;
      var instance = this.instance;
      return h(Tip, {
        attrs: {
          type: "search-prompt",
          icon: "warning"
        }
      }, [instance.searchPromptText]);
    },
    renderLoadingOptionsTip: function renderLoadingOptionsTip() {
      var h = this.$createElement;
      var instance = this.instance;
      return h(Tip, {
        attrs: {
          type: "loading",
          icon: "loader"
        }
      }, [instance.loadingText]);
    },
    renderLoadingRootOptionsErrorTip: function renderLoadingRootOptionsErrorTip() {
      var h = this.$createElement;
      var instance = this.instance;
      return h(Tip, {
        attrs: {
          type: "error",
          icon: "error"
        }
      }, [instance.rootOptionsStates.loadingError, h("a", {
        "class": "vue-treeselect__retry",
        on: {
          "click": instance.loadRootOptions
        },
        attrs: {
          title: instance.retryTitle
        }
      }, [instance.retryText])]);
    },
    renderAsyncSearchLoadingErrorTip: function renderAsyncSearchLoadingErrorTip() {
      var h = this.$createElement;
      var instance = this.instance;
      var entry = instance.getRemoteSearchEntry();
      return h(Tip, {
        attrs: {
          type: "error",
          icon: "error"
        }
      }, [entry.loadingError, h("a", {
        "class": "vue-treeselect__retry",
        on: {
          "click": instance.handleRemoteSearch
        },
        attrs: {
          title: instance.retryTitle
        }
      }, [instance.retryText])]);
    },
    renderNoAvailableOptionsTip: function renderNoAvailableOptionsTip() {
      var h = this.$createElement;
      var instance = this.instance;
      return h(Tip, {
        attrs: {
          type: "no-options",
          icon: "warning"
        }
      }, [instance.noOptionsText]);
    },
    renderNoResultsTip: function renderNoResultsTip() {
      var h = this.$createElement;
      var instance = this.instance;
      return h(Tip, {
        attrs: {
          type: "no-results",
          icon: "warning"
        }
      }, [instance.noResultsText]);
    },
    onMenuOpen: function onMenuOpen() {
      this.adjustMenuOpenDirection();
      this.setupMenuSizeWatcher();
      this.setupMenuResizeAndScrollEventListeners();
    },
    onMenuClose: function onMenuClose() {
      this.removeMenuSizeWatcher();
      this.removeMenuResizeAndScrollEventListeners();
    },
    adjustMenuOpenDirection: function adjustMenuOpenDirection() {
      var instance = this.instance;
      if (!instance.menu.isOpen) return;
      var $menu = instance.getMenu();
      var $control = instance.getControl();
      var menuRect = $menu.getBoundingClientRect();
      var controlRect = $control.getBoundingClientRect();
      var menuHeight = menuRect.height;
      var viewportHeight = window.innerHeight;
      var spaceAbove = controlRect.top;
      var spaceBelow = window.innerHeight - controlRect.bottom;
      var isControlInViewport = controlRect.top >= 0 && controlRect.top <= viewportHeight || controlRect.top < 0 && controlRect.bottom > 0;
      var hasEnoughSpaceBelow = spaceBelow > menuHeight + MENU_BUFFER;
      var hasEnoughSpaceAbove = spaceAbove > menuHeight + MENU_BUFFER;

      if (!isControlInViewport) {
        instance.closeMenu();
      } else if (instance.openDirection !== 'auto') {
        instance.menu.placement = directionMap[instance.openDirection];
      } else if (hasEnoughSpaceBelow || !hasEnoughSpaceAbove) {
        instance.menu.placement = 'bottom';
      } else {
        instance.menu.placement = 'top';
      }
    },
    setupMenuSizeWatcher: function setupMenuSizeWatcher() {
      var instance = this.instance;
      var $menu = instance.getMenu();
      if (this.menuSizeWatcher) return;
      this.menuSizeWatcher = {
        remove: watchSize($menu, this.adjustMenuOpenDirection)
      };
    },
    setupMenuResizeAndScrollEventListeners: function setupMenuResizeAndScrollEventListeners() {
      var instance = this.instance;
      var $control = instance.getControl();
      if (this.menuResizeAndScrollEventListeners) return;
      this.menuResizeAndScrollEventListeners = {
        remove: setupResizeAndScrollEventListeners($control, this.adjustMenuOpenDirection)
      };
    },
    removeMenuSizeWatcher: function removeMenuSizeWatcher() {
      if (!this.menuSizeWatcher) return;
      this.menuSizeWatcher.remove();
      this.menuSizeWatcher = null;
    },
    removeMenuResizeAndScrollEventListeners: function removeMenuResizeAndScrollEventListeners() {
      if (!this.menuResizeAndScrollEventListeners) return;
      this.menuResizeAndScrollEventListeners.remove();
      this.menuResizeAndScrollEventListeners = null;
    }
  },
  render: function render() {
    var h = arguments[0];
    return h("div", {
      ref: "menu-container",
      "class": "vue-treeselect__menu-container",
      style: this.menuContainerStyle
    }, [h("transition", {
      attrs: {
        name: "vue-treeselect__menu--transition"
      }
    }, [this.renderMenu()])]);
  }
});
// CONCATENATED MODULE: ./src/components/Menu.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_Menuvue_type_script_lang_js_ = (Menuvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./src/components/Menu.vue
var Menu_render, Menu_staticRenderFns




/* normalize component */

var Menu_component = normalizeComponent(
  components_Menuvue_type_script_lang_js_,
  Menu_render,
  Menu_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var Menu_api; }
Menu_component.options.__file = "src/components/Menu.vue"
/* harmony default export */ var Menu = (Menu_component.exports);
// EXTERNAL MODULE: external "vue"
var external_vue_ = __nested_webpack_require_5479__(14);
var external_vue_default = /*#__PURE__*/__nested_webpack_require_5479__.n(external_vue_);

// CONCATENATED MODULE: ./node_modules/cache-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./src/components/MenuPortal.vue?vue&type=script&lang=js&


function MenuPortalvue_type_script_lang_js_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function MenuPortalvue_type_script_lang_js_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { MenuPortalvue_type_script_lang_js_ownKeys(source, true).forEach(function (key) { defineProperty_default()(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { MenuPortalvue_type_script_lang_js_ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }




var PortalTarget = {
  name: 'vue-treeselect--portal-target',
  inject: ['instance'],
  watch: {
    'instance.menu.isOpen': function instanceMenuIsOpen(newValue) {
      if (newValue) {
        this.setupHandlers();
      } else {
        this.removeHandlers();
      }
    },
    'instance.menu.placement': function instanceMenuPlacement() {
      this.updateMenuContainerOffset();
    }
  },
  created: function created() {
    this.controlResizeAndScrollEventListeners = null;
    this.controlSizeWatcher = null;
  },
  mounted: function mounted() {
    var instance = this.instance;
    if (instance.menu.isOpen) this.setupHandlers();
  },
  methods: {
    setupHandlers: function setupHandlers() {
      this.updateWidth();
      this.updateMenuContainerOffset();
      this.setupControlResizeAndScrollEventListeners();
      this.setupControlSizeWatcher();
    },
    removeHandlers: function removeHandlers() {
      this.removeControlResizeAndScrollEventListeners();
      this.removeControlSizeWatcher();
    },
    setupControlResizeAndScrollEventListeners: function setupControlResizeAndScrollEventListeners() {
      var instance = this.instance;
      var $control = instance.getControl();
      if (this.controlResizeAndScrollEventListeners) return;
      this.controlResizeAndScrollEventListeners = {
        remove: setupResizeAndScrollEventListeners($control, this.updateMenuContainerOffset)
      };
    },
    setupControlSizeWatcher: function setupControlSizeWatcher() {
      var _this = this;

      var instance = this.instance;
      var $control = instance.getControl();
      if (this.controlSizeWatcher) return;
      this.controlSizeWatcher = {
        remove: watchSize($control, function () {
          _this.updateWidth();

          _this.updateMenuContainerOffset();
        })
      };
    },
    removeControlResizeAndScrollEventListeners: function removeControlResizeAndScrollEventListeners() {
      if (!this.controlResizeAndScrollEventListeners) return;
      this.controlResizeAndScrollEventListeners.remove();
      this.controlResizeAndScrollEventListeners = null;
    },
    removeControlSizeWatcher: function removeControlSizeWatcher() {
      if (!this.controlSizeWatcher) return;
      this.controlSizeWatcher.remove();
      this.controlSizeWatcher = null;
    },
    updateWidth: function updateWidth() {
      var instance = this.instance;
      var $portalTarget = this.$el;
      var $control = instance.getControl();
      var controlRect = $control.getBoundingClientRect();
      $portalTarget.style.width = controlRect.width + 'px';
    },
    updateMenuContainerOffset: function updateMenuContainerOffset() {
      var instance = this.instance;
      var $control = instance.getControl();
      var $portalTarget = this.$el;
      var controlRect = $control.getBoundingClientRect();
      var portalTargetRect = $portalTarget.getBoundingClientRect();
      var offsetY = instance.menu.placement === 'bottom' ? controlRect.height : 0;
      var left = Math.round(controlRect.left - portalTargetRect.left) + 'px';
      var top = Math.round(controlRect.top - portalTargetRect.top + offsetY) + 'px';
      var menuContainerStyle = this.$refs.menu.$refs['menu-container'].style;
      var transformVariations = ['transform', 'webkitTransform', 'MozTransform', 'msTransform'];
      var transform = find(transformVariations, function (t) {
        return t in document.body.style;
      });
      menuContainerStyle[transform] = "translate(".concat(left, ", ").concat(top, ")");
    }
  },
  render: function render() {
    var h = arguments[0];
    var instance = this.instance;
    var portalTargetClass = ['vue-treeselect__portal-target', instance.wrapperClass];
    var portalTargetStyle = {
      zIndex: instance.zIndex
    };
    return h("div", {
      "class": portalTargetClass,
      style: portalTargetStyle,
      attrs: {
        "data-instance-id": instance.getInstanceId()
      }
    }, [h(Menu, {
      ref: "menu"
    })]);
  },
  destroyed: function destroyed() {
    this.removeHandlers();
  }
};
var placeholder;
/* harmony default export */ var MenuPortalvue_type_script_lang_js_ = ({
  name: 'vue-treeselect--menu-portal',
  created: function created() {
    this.portalTarget = null;
  },
  mounted: function mounted() {
    this.setup();
  },
  destroyed: function destroyed() {
    this.teardown();
  },
  methods: {
    setup: function setup() {
      var el = document.createElement('div');
      document.body.appendChild(el);
      this.portalTarget = new external_vue_default.a(MenuPortalvue_type_script_lang_js_objectSpread({
        el: el,
        parent: this
      }, PortalTarget));
    },
    teardown: function teardown() {
      document.body.removeChild(this.portalTarget.$el);
      this.portalTarget.$el.innerHTML = '';
      this.portalTarget.$destroy();
      this.portalTarget = null;
    }
  },
  render: function render() {
    var h = arguments[0];
    if (!placeholder) placeholder = h("div", {
      "class": "vue-treeselect__menu-placeholder"
    });
    return placeholder;
  }
});
// CONCATENATED MODULE: ./src/components/MenuPortal.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_MenuPortalvue_type_script_lang_js_ = (MenuPortalvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./src/components/MenuPortal.vue
var MenuPortal_render, MenuPortal_staticRenderFns




/* normalize component */

var MenuPortal_component = normalizeComponent(
  components_MenuPortalvue_type_script_lang_js_,
  MenuPortal_render,
  MenuPortal_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var MenuPortal_api; }
MenuPortal_component.options.__file = "src/components/MenuPortal.vue"
/* harmony default export */ var MenuPortal = (MenuPortal_component.exports);
// CONCATENATED MODULE: ./node_modules/cache-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./src/components/Treeselect.vue?vue&type=script&lang=js&





/* harmony default export */ var Treeselectvue_type_script_lang_js_ = ({
  name: 'vue-treeselect',
  mixins: [treeselectMixin],
  computed: {
    wrapperClass: function wrapperClass() {
      return {
        'vue-treeselect': true,
        'vue-treeselect--single': this.single,
        'vue-treeselect--multi': this.multiple,
        'vue-treeselect--searchable': this.searchable,
        'vue-treeselect--disabled': this.disabled,
        'vue-treeselect--focused': this.trigger.isFocused,
        'vue-treeselect--has-value': this.hasValue,
        'vue-treeselect--open': this.menu.isOpen,
        'vue-treeselect--open-above': this.menu.placement === 'top',
        'vue-treeselect--open-below': this.menu.placement === 'bottom',
        'vue-treeselect--branch-nodes-disabled': this.disableBranchNodes,
        'vue-treeselect--append-to-body': this.appendToBody
      };
    }
  },
  render: function render() {
    var h = arguments[0];
    return h("div", {
      ref: "wrapper",
      "class": this.wrapperClass
    }, [h(HiddenFields), h(Control, {
      ref: "control"
    }), this.appendToBody ? h(MenuPortal, {
      ref: "portal"
    }) : h(Menu, {
      ref: "menu"
    })]);
  }
});
// CONCATENATED MODULE: ./src/components/Treeselect.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_Treeselectvue_type_script_lang_js_ = (Treeselectvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./src/components/Treeselect.vue
var Treeselect_render, Treeselect_staticRenderFns




/* normalize component */

var Treeselect_component = normalizeComponent(
  components_Treeselectvue_type_script_lang_js_,
  Treeselect_render,
  Treeselect_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var Treeselect_api; }
Treeselect_component.options.__file = "src/components/Treeselect.vue"
/* harmony default export */ var Treeselect = (Treeselect_component.exports);
// EXTERNAL MODULE: ./src/style.less
var style = __nested_webpack_require_5479__(15);

// CONCATENATED MODULE: ./src/index.js
/* harmony export (binding) */ __nested_webpack_require_5479__.d(__nested_webpack_exports__, "VERSION", function() { return VERSION; });
/* concated harmony reexport Treeselect */__nested_webpack_require_5479__.d(__nested_webpack_exports__, "Treeselect", function() { return Treeselect; });
/* concated harmony reexport treeselectMixin */__nested_webpack_require_5479__.d(__nested_webpack_exports__, "treeselectMixin", function() { return treeselectMixin; });
/* concated harmony reexport LOAD_ROOT_OPTIONS */__nested_webpack_require_5479__.d(__nested_webpack_exports__, "LOAD_ROOT_OPTIONS", function() { return LOAD_ROOT_OPTIONS; });
/* concated harmony reexport LOAD_CHILDREN_OPTIONS */__nested_webpack_require_5479__.d(__nested_webpack_exports__, "LOAD_CHILDREN_OPTIONS", function() { return LOAD_CHILDREN_OPTIONS; });
/* concated harmony reexport ASYNC_SEARCH */__nested_webpack_require_5479__.d(__nested_webpack_exports__, "ASYNC_SEARCH", function() { return ASYNC_SEARCH; });



/* harmony default export */ var src = __nested_webpack_exports__["default"] = (Treeselect);


var VERSION = "0.4.0";

/***/ })
/******/ ]);
//# sourceMappingURL=vue-treeselect.cjs.js.map

/***/ }),

/***/ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/_Symbol.js":
/*!*****************************************************************************!*\
  !*** ./node_modules/@riophae/vue-treeselect/node_modules/lodash/_Symbol.js ***!
  \*****************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var root = __webpack_require__(/*! ./_root */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/_root.js");

/** Built-in value references. */
var Symbol = root.Symbol;

module.exports = Symbol;


/***/ }),

/***/ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/_baseGetTag.js":
/*!*********************************************************************************!*\
  !*** ./node_modules/@riophae/vue-treeselect/node_modules/lodash/_baseGetTag.js ***!
  \*********************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var Symbol = __webpack_require__(/*! ./_Symbol */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/_Symbol.js"),
    getRawTag = __webpack_require__(/*! ./_getRawTag */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/_getRawTag.js"),
    objectToString = __webpack_require__(/*! ./_objectToString */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/_objectToString.js");

/** `Object#toString` result references. */
var nullTag = '[object Null]',
    undefinedTag = '[object Undefined]';

/** Built-in value references. */
var symToStringTag = Symbol ? Symbol.toStringTag : undefined;

/**
 * The base implementation of `getTag` without fallbacks for buggy environments.
 *
 * @private
 * @param {*} value The value to query.
 * @returns {string} Returns the `toStringTag`.
 */
function baseGetTag(value) {
  if (value == null) {
    return value === undefined ? undefinedTag : nullTag;
  }
  return (symToStringTag && symToStringTag in Object(value))
    ? getRawTag(value)
    : objectToString(value);
}

module.exports = baseGetTag;


/***/ }),

/***/ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/_baseTrim.js":
/*!*******************************************************************************!*\
  !*** ./node_modules/@riophae/vue-treeselect/node_modules/lodash/_baseTrim.js ***!
  \*******************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var trimmedEndIndex = __webpack_require__(/*! ./_trimmedEndIndex */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/_trimmedEndIndex.js");

/** Used to match leading whitespace. */
var reTrimStart = /^\s+/;

/**
 * The base implementation of `_.trim`.
 *
 * @private
 * @param {string} string The string to trim.
 * @returns {string} Returns the trimmed string.
 */
function baseTrim(string) {
  return string
    ? string.slice(0, trimmedEndIndex(string) + 1).replace(reTrimStart, '')
    : string;
}

module.exports = baseTrim;


/***/ }),

/***/ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/_freeGlobal.js":
/*!*********************************************************************************!*\
  !*** ./node_modules/@riophae/vue-treeselect/node_modules/lodash/_freeGlobal.js ***!
  \*********************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

/** Detect free variable `global` from Node.js. */
var freeGlobal = typeof __webpack_require__.g == 'object' && __webpack_require__.g && __webpack_require__.g.Object === Object && __webpack_require__.g;

module.exports = freeGlobal;


/***/ }),

/***/ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/_getRawTag.js":
/*!********************************************************************************!*\
  !*** ./node_modules/@riophae/vue-treeselect/node_modules/lodash/_getRawTag.js ***!
  \********************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var Symbol = __webpack_require__(/*! ./_Symbol */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/_Symbol.js");

/** Used for built-in method references. */
var objectProto = Object.prototype;

/** Used to check objects for own properties. */
var hasOwnProperty = objectProto.hasOwnProperty;

/**
 * Used to resolve the
 * [`toStringTag`](http://ecma-international.org/ecma-262/7.0/#sec-object.prototype.tostring)
 * of values.
 */
var nativeObjectToString = objectProto.toString;

/** Built-in value references. */
var symToStringTag = Symbol ? Symbol.toStringTag : undefined;

/**
 * A specialized version of `baseGetTag` which ignores `Symbol.toStringTag` values.
 *
 * @private
 * @param {*} value The value to query.
 * @returns {string} Returns the raw `toStringTag`.
 */
function getRawTag(value) {
  var isOwn = hasOwnProperty.call(value, symToStringTag),
      tag = value[symToStringTag];

  try {
    value[symToStringTag] = undefined;
    var unmasked = true;
  } catch (e) {}

  var result = nativeObjectToString.call(value);
  if (unmasked) {
    if (isOwn) {
      value[symToStringTag] = tag;
    } else {
      delete value[symToStringTag];
    }
  }
  return result;
}

module.exports = getRawTag;


/***/ }),

/***/ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/_objectToString.js":
/*!*************************************************************************************!*\
  !*** ./node_modules/@riophae/vue-treeselect/node_modules/lodash/_objectToString.js ***!
  \*************************************************************************************/
/***/ ((module) => {

/** Used for built-in method references. */
var objectProto = Object.prototype;

/**
 * Used to resolve the
 * [`toStringTag`](http://ecma-international.org/ecma-262/7.0/#sec-object.prototype.tostring)
 * of values.
 */
var nativeObjectToString = objectProto.toString;

/**
 * Converts `value` to a string using `Object.prototype.toString`.
 *
 * @private
 * @param {*} value The value to convert.
 * @returns {string} Returns the converted string.
 */
function objectToString(value) {
  return nativeObjectToString.call(value);
}

module.exports = objectToString;


/***/ }),

/***/ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/_root.js":
/*!***************************************************************************!*\
  !*** ./node_modules/@riophae/vue-treeselect/node_modules/lodash/_root.js ***!
  \***************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var freeGlobal = __webpack_require__(/*! ./_freeGlobal */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/_freeGlobal.js");

/** Detect free variable `self`. */
var freeSelf = typeof self == 'object' && self && self.Object === Object && self;

/** Used as a reference to the global object. */
var root = freeGlobal || freeSelf || Function('return this')();

module.exports = root;


/***/ }),

/***/ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/_trimmedEndIndex.js":
/*!**************************************************************************************!*\
  !*** ./node_modules/@riophae/vue-treeselect/node_modules/lodash/_trimmedEndIndex.js ***!
  \**************************************************************************************/
/***/ ((module) => {

/** Used to match a single whitespace character. */
var reWhitespace = /\s/;

/**
 * Used by `_.trim` and `_.trimEnd` to get the index of the last non-whitespace
 * character of `string`.
 *
 * @private
 * @param {string} string The string to inspect.
 * @returns {number} Returns the index of the last non-whitespace character.
 */
function trimmedEndIndex(string) {
  var index = string.length;

  while (index-- && reWhitespace.test(string.charAt(index))) {}
  return index;
}

module.exports = trimmedEndIndex;


/***/ }),

/***/ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/before.js":
/*!****************************************************************************!*\
  !*** ./node_modules/@riophae/vue-treeselect/node_modules/lodash/before.js ***!
  \****************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var toInteger = __webpack_require__(/*! ./toInteger */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/toInteger.js");

/** Error message constants. */
var FUNC_ERROR_TEXT = 'Expected a function';

/**
 * Creates a function that invokes `func`, with the `this` binding and arguments
 * of the created function, while it's called less than `n` times. Subsequent
 * calls to the created function return the result of the last `func` invocation.
 *
 * @static
 * @memberOf _
 * @since 3.0.0
 * @category Function
 * @param {number} n The number of calls at which `func` is no longer invoked.
 * @param {Function} func The function to restrict.
 * @returns {Function} Returns the new restricted function.
 * @example
 *
 * jQuery(element).on('click', _.before(5, addContactToList));
 * // => Allows adding up to 4 contacts to the list.
 */
function before(n, func) {
  var result;
  if (typeof func != 'function') {
    throw new TypeError(FUNC_ERROR_TEXT);
  }
  n = toInteger(n);
  return function() {
    if (--n > 0) {
      result = func.apply(this, arguments);
    }
    if (n <= 1) {
      func = undefined;
    }
    return result;
  };
}

module.exports = before;


/***/ }),

/***/ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/constant.js":
/*!******************************************************************************!*\
  !*** ./node_modules/@riophae/vue-treeselect/node_modules/lodash/constant.js ***!
  \******************************************************************************/
/***/ ((module) => {

/**
 * Creates a function that returns `value`.
 *
 * @static
 * @memberOf _
 * @since 2.4.0
 * @category Util
 * @param {*} value The value to return from the new function.
 * @returns {Function} Returns the new constant function.
 * @example
 *
 * var objects = _.times(2, _.constant({ 'a': 1 }));
 *
 * console.log(objects);
 * // => [{ 'a': 1 }, { 'a': 1 }]
 *
 * console.log(objects[0] === objects[1]);
 * // => true
 */
function constant(value) {
  return function() {
    return value;
  };
}

module.exports = constant;


/***/ }),

/***/ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/debounce.js":
/*!******************************************************************************!*\
  !*** ./node_modules/@riophae/vue-treeselect/node_modules/lodash/debounce.js ***!
  \******************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var isObject = __webpack_require__(/*! ./isObject */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/isObject.js"),
    now = __webpack_require__(/*! ./now */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/now.js"),
    toNumber = __webpack_require__(/*! ./toNumber */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/toNumber.js");

/** Error message constants. */
var FUNC_ERROR_TEXT = 'Expected a function';

/* Built-in method references for those with the same name as other `lodash` methods. */
var nativeMax = Math.max,
    nativeMin = Math.min;

/**
 * Creates a debounced function that delays invoking `func` until after `wait`
 * milliseconds have elapsed since the last time the debounced function was
 * invoked. The debounced function comes with a `cancel` method to cancel
 * delayed `func` invocations and a `flush` method to immediately invoke them.
 * Provide `options` to indicate whether `func` should be invoked on the
 * leading and/or trailing edge of the `wait` timeout. The `func` is invoked
 * with the last arguments provided to the debounced function. Subsequent
 * calls to the debounced function return the result of the last `func`
 * invocation.
 *
 * **Note:** If `leading` and `trailing` options are `true`, `func` is
 * invoked on the trailing edge of the timeout only if the debounced function
 * is invoked more than once during the `wait` timeout.
 *
 * If `wait` is `0` and `leading` is `false`, `func` invocation is deferred
 * until to the next tick, similar to `setTimeout` with a timeout of `0`.
 *
 * See [David Corbacho's article](https://css-tricks.com/debouncing-throttling-explained-examples/)
 * for details over the differences between `_.debounce` and `_.throttle`.
 *
 * @static
 * @memberOf _
 * @since 0.1.0
 * @category Function
 * @param {Function} func The function to debounce.
 * @param {number} [wait=0] The number of milliseconds to delay.
 * @param {Object} [options={}] The options object.
 * @param {boolean} [options.leading=false]
 *  Specify invoking on the leading edge of the timeout.
 * @param {number} [options.maxWait]
 *  The maximum time `func` is allowed to be delayed before it's invoked.
 * @param {boolean} [options.trailing=true]
 *  Specify invoking on the trailing edge of the timeout.
 * @returns {Function} Returns the new debounced function.
 * @example
 *
 * // Avoid costly calculations while the window size is in flux.
 * jQuery(window).on('resize', _.debounce(calculateLayout, 150));
 *
 * // Invoke `sendMail` when clicked, debouncing subsequent calls.
 * jQuery(element).on('click', _.debounce(sendMail, 300, {
 *   'leading': true,
 *   'trailing': false
 * }));
 *
 * // Ensure `batchLog` is invoked once after 1 second of debounced calls.
 * var debounced = _.debounce(batchLog, 250, { 'maxWait': 1000 });
 * var source = new EventSource('/stream');
 * jQuery(source).on('message', debounced);
 *
 * // Cancel the trailing debounced invocation.
 * jQuery(window).on('popstate', debounced.cancel);
 */
function debounce(func, wait, options) {
  var lastArgs,
      lastThis,
      maxWait,
      result,
      timerId,
      lastCallTime,
      lastInvokeTime = 0,
      leading = false,
      maxing = false,
      trailing = true;

  if (typeof func != 'function') {
    throw new TypeError(FUNC_ERROR_TEXT);
  }
  wait = toNumber(wait) || 0;
  if (isObject(options)) {
    leading = !!options.leading;
    maxing = 'maxWait' in options;
    maxWait = maxing ? nativeMax(toNumber(options.maxWait) || 0, wait) : maxWait;
    trailing = 'trailing' in options ? !!options.trailing : trailing;
  }

  function invokeFunc(time) {
    var args = lastArgs,
        thisArg = lastThis;

    lastArgs = lastThis = undefined;
    lastInvokeTime = time;
    result = func.apply(thisArg, args);
    return result;
  }

  function leadingEdge(time) {
    // Reset any `maxWait` timer.
    lastInvokeTime = time;
    // Start the timer for the trailing edge.
    timerId = setTimeout(timerExpired, wait);
    // Invoke the leading edge.
    return leading ? invokeFunc(time) : result;
  }

  function remainingWait(time) {
    var timeSinceLastCall = time - lastCallTime,
        timeSinceLastInvoke = time - lastInvokeTime,
        timeWaiting = wait - timeSinceLastCall;

    return maxing
      ? nativeMin(timeWaiting, maxWait - timeSinceLastInvoke)
      : timeWaiting;
  }

  function shouldInvoke(time) {
    var timeSinceLastCall = time - lastCallTime,
        timeSinceLastInvoke = time - lastInvokeTime;

    // Either this is the first call, activity has stopped and we're at the
    // trailing edge, the system time has gone backwards and we're treating
    // it as the trailing edge, or we've hit the `maxWait` limit.
    return (lastCallTime === undefined || (timeSinceLastCall >= wait) ||
      (timeSinceLastCall < 0) || (maxing && timeSinceLastInvoke >= maxWait));
  }

  function timerExpired() {
    var time = now();
    if (shouldInvoke(time)) {
      return trailingEdge(time);
    }
    // Restart the timer.
    timerId = setTimeout(timerExpired, remainingWait(time));
  }

  function trailingEdge(time) {
    timerId = undefined;

    // Only invoke if we have `lastArgs` which means `func` has been
    // debounced at least once.
    if (trailing && lastArgs) {
      return invokeFunc(time);
    }
    lastArgs = lastThis = undefined;
    return result;
  }

  function cancel() {
    if (timerId !== undefined) {
      clearTimeout(timerId);
    }
    lastInvokeTime = 0;
    lastArgs = lastCallTime = lastThis = timerId = undefined;
  }

  function flush() {
    return timerId === undefined ? result : trailingEdge(now());
  }

  function debounced() {
    var time = now(),
        isInvoking = shouldInvoke(time);

    lastArgs = arguments;
    lastThis = this;
    lastCallTime = time;

    if (isInvoking) {
      if (timerId === undefined) {
        return leadingEdge(lastCallTime);
      }
      if (maxing) {
        // Handle invocations in a tight loop.
        clearTimeout(timerId);
        timerId = setTimeout(timerExpired, wait);
        return invokeFunc(lastCallTime);
      }
    }
    if (timerId === undefined) {
      timerId = setTimeout(timerExpired, wait);
    }
    return result;
  }
  debounced.cancel = cancel;
  debounced.flush = flush;
  return debounced;
}

module.exports = debounce;


/***/ }),

/***/ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/identity.js":
/*!******************************************************************************!*\
  !*** ./node_modules/@riophae/vue-treeselect/node_modules/lodash/identity.js ***!
  \******************************************************************************/
/***/ ((module) => {

/**
 * This method returns the first argument it receives.
 *
 * @static
 * @since 0.1.0
 * @memberOf _
 * @category Util
 * @param {*} value Any value.
 * @returns {*} Returns `value`.
 * @example
 *
 * var object = { 'a': 1 };
 *
 * console.log(_.identity(object) === object);
 * // => true
 */
function identity(value) {
  return value;
}

module.exports = identity;


/***/ }),

/***/ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/isObject.js":
/*!******************************************************************************!*\
  !*** ./node_modules/@riophae/vue-treeselect/node_modules/lodash/isObject.js ***!
  \******************************************************************************/
/***/ ((module) => {

/**
 * Checks if `value` is the
 * [language type](http://www.ecma-international.org/ecma-262/7.0/#sec-ecmascript-language-types)
 * of `Object`. (e.g. arrays, functions, objects, regexes, `new Number(0)`, and `new String('')`)
 *
 * @static
 * @memberOf _
 * @since 0.1.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is an object, else `false`.
 * @example
 *
 * _.isObject({});
 * // => true
 *
 * _.isObject([1, 2, 3]);
 * // => true
 *
 * _.isObject(_.noop);
 * // => true
 *
 * _.isObject(null);
 * // => false
 */
function isObject(value) {
  var type = typeof value;
  return value != null && (type == 'object' || type == 'function');
}

module.exports = isObject;


/***/ }),

/***/ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/isObjectLike.js":
/*!**********************************************************************************!*\
  !*** ./node_modules/@riophae/vue-treeselect/node_modules/lodash/isObjectLike.js ***!
  \**********************************************************************************/
/***/ ((module) => {

/**
 * Checks if `value` is object-like. A value is object-like if it's not `null`
 * and has a `typeof` result of "object".
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is object-like, else `false`.
 * @example
 *
 * _.isObjectLike({});
 * // => true
 *
 * _.isObjectLike([1, 2, 3]);
 * // => true
 *
 * _.isObjectLike(_.noop);
 * // => false
 *
 * _.isObjectLike(null);
 * // => false
 */
function isObjectLike(value) {
  return value != null && typeof value == 'object';
}

module.exports = isObjectLike;


/***/ }),

/***/ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/isSymbol.js":
/*!******************************************************************************!*\
  !*** ./node_modules/@riophae/vue-treeselect/node_modules/lodash/isSymbol.js ***!
  \******************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var baseGetTag = __webpack_require__(/*! ./_baseGetTag */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/_baseGetTag.js"),
    isObjectLike = __webpack_require__(/*! ./isObjectLike */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/isObjectLike.js");

/** `Object#toString` result references. */
var symbolTag = '[object Symbol]';

/**
 * Checks if `value` is classified as a `Symbol` primitive or object.
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a symbol, else `false`.
 * @example
 *
 * _.isSymbol(Symbol.iterator);
 * // => true
 *
 * _.isSymbol('abc');
 * // => false
 */
function isSymbol(value) {
  return typeof value == 'symbol' ||
    (isObjectLike(value) && baseGetTag(value) == symbolTag);
}

module.exports = isSymbol;


/***/ }),

/***/ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/last.js":
/*!**************************************************************************!*\
  !*** ./node_modules/@riophae/vue-treeselect/node_modules/lodash/last.js ***!
  \**************************************************************************/
/***/ ((module) => {

/**
 * Gets the last element of `array`.
 *
 * @static
 * @memberOf _
 * @since 0.1.0
 * @category Array
 * @param {Array} array The array to query.
 * @returns {*} Returns the last element of `array`.
 * @example
 *
 * _.last([1, 2, 3]);
 * // => 3
 */
function last(array) {
  var length = array == null ? 0 : array.length;
  return length ? array[length - 1] : undefined;
}

module.exports = last;


/***/ }),

/***/ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/noop.js":
/*!**************************************************************************!*\
  !*** ./node_modules/@riophae/vue-treeselect/node_modules/lodash/noop.js ***!
  \**************************************************************************/
/***/ ((module) => {

/**
 * This method returns `undefined`.
 *
 * @static
 * @memberOf _
 * @since 2.3.0
 * @category Util
 * @example
 *
 * _.times(2, _.noop);
 * // => [undefined, undefined]
 */
function noop() {
  // No operation performed.
}

module.exports = noop;


/***/ }),

/***/ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/now.js":
/*!*************************************************************************!*\
  !*** ./node_modules/@riophae/vue-treeselect/node_modules/lodash/now.js ***!
  \*************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var root = __webpack_require__(/*! ./_root */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/_root.js");

/**
 * Gets the timestamp of the number of milliseconds that have elapsed since
 * the Unix epoch (1 January 1970 00:00:00 UTC).
 *
 * @static
 * @memberOf _
 * @since 2.4.0
 * @category Date
 * @returns {number} Returns the timestamp.
 * @example
 *
 * _.defer(function(stamp) {
 *   console.log(_.now() - stamp);
 * }, _.now());
 * // => Logs the number of milliseconds it took for the deferred invocation.
 */
var now = function() {
  return root.Date.now();
};

module.exports = now;


/***/ }),

/***/ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/once.js":
/*!**************************************************************************!*\
  !*** ./node_modules/@riophae/vue-treeselect/node_modules/lodash/once.js ***!
  \**************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var before = __webpack_require__(/*! ./before */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/before.js");

/**
 * Creates a function that is restricted to invoking `func` once. Repeat calls
 * to the function return the value of the first invocation. The `func` is
 * invoked with the `this` binding and arguments of the created function.
 *
 * @static
 * @memberOf _
 * @since 0.1.0
 * @category Function
 * @param {Function} func The function to restrict.
 * @returns {Function} Returns the new restricted function.
 * @example
 *
 * var initialize = _.once(createApplication);
 * initialize();
 * initialize();
 * // => `createApplication` is invoked once
 */
function once(func) {
  return before(2, func);
}

module.exports = once;


/***/ }),

/***/ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/toFinite.js":
/*!******************************************************************************!*\
  !*** ./node_modules/@riophae/vue-treeselect/node_modules/lodash/toFinite.js ***!
  \******************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var toNumber = __webpack_require__(/*! ./toNumber */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/toNumber.js");

/** Used as references for various `Number` constants. */
var INFINITY = 1 / 0,
    MAX_INTEGER = 1.7976931348623157e+308;

/**
 * Converts `value` to a finite number.
 *
 * @static
 * @memberOf _
 * @since 4.12.0
 * @category Lang
 * @param {*} value The value to convert.
 * @returns {number} Returns the converted number.
 * @example
 *
 * _.toFinite(3.2);
 * // => 3.2
 *
 * _.toFinite(Number.MIN_VALUE);
 * // => 5e-324
 *
 * _.toFinite(Infinity);
 * // => 1.7976931348623157e+308
 *
 * _.toFinite('3.2');
 * // => 3.2
 */
function toFinite(value) {
  if (!value) {
    return value === 0 ? value : 0;
  }
  value = toNumber(value);
  if (value === INFINITY || value === -INFINITY) {
    var sign = (value < 0 ? -1 : 1);
    return sign * MAX_INTEGER;
  }
  return value === value ? value : 0;
}

module.exports = toFinite;


/***/ }),

/***/ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/toInteger.js":
/*!*******************************************************************************!*\
  !*** ./node_modules/@riophae/vue-treeselect/node_modules/lodash/toInteger.js ***!
  \*******************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var toFinite = __webpack_require__(/*! ./toFinite */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/toFinite.js");

/**
 * Converts `value` to an integer.
 *
 * **Note:** This method is loosely based on
 * [`ToInteger`](http://www.ecma-international.org/ecma-262/7.0/#sec-tointeger).
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to convert.
 * @returns {number} Returns the converted integer.
 * @example
 *
 * _.toInteger(3.2);
 * // => 3
 *
 * _.toInteger(Number.MIN_VALUE);
 * // => 0
 *
 * _.toInteger(Infinity);
 * // => 1.7976931348623157e+308
 *
 * _.toInteger('3.2');
 * // => 3
 */
function toInteger(value) {
  var result = toFinite(value),
      remainder = result % 1;

  return result === result ? (remainder ? result - remainder : result) : 0;
}

module.exports = toInteger;


/***/ }),

/***/ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/toNumber.js":
/*!******************************************************************************!*\
  !*** ./node_modules/@riophae/vue-treeselect/node_modules/lodash/toNumber.js ***!
  \******************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var baseTrim = __webpack_require__(/*! ./_baseTrim */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/_baseTrim.js"),
    isObject = __webpack_require__(/*! ./isObject */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/isObject.js"),
    isSymbol = __webpack_require__(/*! ./isSymbol */ "./node_modules/@riophae/vue-treeselect/node_modules/lodash/isSymbol.js");

/** Used as references for various `Number` constants. */
var NAN = 0 / 0;

/** Used to detect bad signed hexadecimal string values. */
var reIsBadHex = /^[-+]0x[0-9a-f]+$/i;

/** Used to detect binary string values. */
var reIsBinary = /^0b[01]+$/i;

/** Used to detect octal string values. */
var reIsOctal = /^0o[0-7]+$/i;

/** Built-in method references without a dependency on `root`. */
var freeParseInt = parseInt;

/**
 * Converts `value` to a number.
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to process.
 * @returns {number} Returns the number.
 * @example
 *
 * _.toNumber(3.2);
 * // => 3.2
 *
 * _.toNumber(Number.MIN_VALUE);
 * // => 5e-324
 *
 * _.toNumber(Infinity);
 * // => Infinity
 *
 * _.toNumber('3.2');
 * // => 3.2
 */
function toNumber(value) {
  if (typeof value == 'number') {
    return value;
  }
  if (isSymbol(value)) {
    return NAN;
  }
  if (isObject(value)) {
    var other = typeof value.valueOf == 'function' ? value.valueOf() : value;
    value = isObject(other) ? (other + '') : other;
  }
  if (typeof value != 'string') {
    return value === 0 ? value : +value;
  }
  value = baseTrim(value);
  var isBinary = reIsBinary.test(value);
  return (isBinary || reIsOctal.test(value))
    ? freeParseInt(value.slice(2), isBinary ? 2 : 8)
    : (reIsBadHex.test(value) ? NAN : +value);
}

module.exports = toNumber;


/***/ }),

/***/ "./node_modules/babel-helper-vue-jsx-merge-props/index.js":
/*!****************************************************************!*\
  !*** ./node_modules/babel-helper-vue-jsx-merge-props/index.js ***!
  \****************************************************************/
/***/ ((module) => {

var nestRE = /^(attrs|props|on|nativeOn|class|style|hook)$/

module.exports = function mergeJSXProps (objs) {
  return objs.reduce(function (a, b) {
    var aa, bb, key, nestedKey, temp
    for (key in b) {
      aa = a[key]
      bb = b[key]
      if (aa && nestRE.test(key)) {
        // normalize class
        if (key === 'class') {
          if (typeof aa === 'string') {
            temp = aa
            a[key] = aa = {}
            aa[temp] = true
          }
          if (typeof bb === 'string') {
            temp = bb
            b[key] = bb = {}
            bb[temp] = true
          }
        }
        if (key === 'on' || key === 'nativeOn' || key === 'hook') {
          // merge functions
          for (nestedKey in bb) {
            aa[nestedKey] = mergeFn(aa[nestedKey], bb[nestedKey])
          }
        } else if (Array.isArray(aa)) {
          a[key] = aa.concat(bb)
        } else if (Array.isArray(bb)) {
          a[key] = [aa].concat(bb)
        } else {
          for (nestedKey in bb) {
            aa[nestedKey] = bb[nestedKey]
          }
        }
      } else {
        a[key] = b[key]
      }
    }
    return a
  }, {})
}

function mergeFn (a, b) {
  return function () {
    a && a.apply(this, arguments)
    b && b.apply(this, arguments)
  }
}


/***/ }),

/***/ "./node_modules/fuzzysearch/index.js":
/*!*******************************************!*\
  !*** ./node_modules/fuzzysearch/index.js ***!
  \*******************************************/
/***/ ((module) => {

"use strict";


function fuzzysearch (needle, haystack) {
  var tlen = haystack.length;
  var qlen = needle.length;
  if (qlen > tlen) {
    return false;
  }
  if (qlen === tlen) {
    return needle === haystack;
  }
  outer: for (var i = 0, j = 0; i < qlen; i++) {
    var nch = needle.charCodeAt(i);
    while (j < tlen) {
      if (haystack.charCodeAt(j++) === nch) {
        continue outer;
      }
    }
    return false;
  }
  return true;
}

module.exports = fuzzysearch;


/***/ }),

/***/ "./node_modules/is-promise/index.js":
/*!******************************************!*\
  !*** ./node_modules/is-promise/index.js ***!
  \******************************************/
/***/ ((module) => {

module.exports = isPromise;
module.exports["default"] = isPromise;

function isPromise(obj) {
  return !!obj && (typeof obj === 'object' || typeof obj === 'function') && typeof obj.then === 'function';
}


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/widget/Create.vue?vue&type=script&lang=js":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/widget/Create.vue?vue&type=script&lang=js ***!
  \**********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _riophae_vue_treeselect__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @riophae/vue-treeselect */ "./node_modules/@riophae/vue-treeselect/dist/vue-treeselect.cjs.js");
/* harmony import */ var _riophae_vue_treeselect__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_riophae_vue_treeselect__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-multiselect */ "./node_modules/vue-multiselect/dist/vue-multiselect.min.js");
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_multiselect__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var vue_prism_editor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-prism-editor */ "./node_modules/vue-prism-editor/dist/prismeditor.esm.js");
/* harmony import */ var vue_prism_editor_dist_prismeditor_min_css__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! vue-prism-editor/dist/prismeditor.min.css */ "./node_modules/vue-prism-editor/dist/prismeditor.min.css");
/* harmony import */ var prismjs_components_prism_core__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! prismjs/components/prism-core */ "./node_modules/prismjs/components/prism-core.js");
/* harmony import */ var prismjs_components_prism_core__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(prismjs_components_prism_core__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var prismjs_components_prism_clike__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! prismjs/components/prism-clike */ "./node_modules/prismjs/components/prism-clike.js");
/* harmony import */ var prismjs_components_prism_clike__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(prismjs_components_prism_clike__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var prismjs_components_prism_javascript__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! prismjs/components/prism-javascript */ "./node_modules/prismjs/components/prism-javascript.js");
/* harmony import */ var prismjs_components_prism_javascript__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(prismjs_components_prism_javascript__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var prismjs_themes_prism_okaidia_min_css__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! prismjs/themes/prism-okaidia.min.css */ "./node_modules/prismjs/themes/prism-okaidia.min.css");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(e, r, t) { return (r = _toPropertyKey(r)) in e ? Object.defineProperty(e, r, { value: t, enumerable: !0, configurable: !0, writable: !0 }) : e[r] = t, e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }



 // import the styles somewhere

// import highlighting library (you can use any library you want just return html string)



 // import syntax highlighting styles

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "WidgetCreate",
  components: {
    Multiselect: (vue_multiselect__WEBPACK_IMPORTED_MODULE_1___default()),
    Treeselect: (_riophae_vue_treeselect__WEBPACK_IMPORTED_MODULE_0___default()),
    PrismEditor: vue_prism_editor__WEBPACK_IMPORTED_MODULE_2__.PrismEditor
  },
  props: ['url', 'axios_url', 'query_string', 'method', 'widget_data', 'all_templates', 'all_placements', 'all_page_types', 'all_tags', 'save_action'],
  data: function data() {
    return {
      validationErrors: {},
      backUrl: '/admin/widget',
      widget: {
        name: null,
        model: null,
        data: null,
        placement: null,
        page_types: null,
        tags: [],
        blade: null,
        template_id: null,
        code: null,
        description: null
      },
      allPlacements: JSON.parse(this.all_placements),
      allTemplates: JSON.parse(this.all_templates),
      allPageTypes: JSON.parse(this.all_page_types),
      allTags: JSON.parse(this.all_tags),
      saveAction: JSON.parse(this.save_action),
      actionType: 'save_and_back'
    };
  },
  created: function created() {
    if (this.method === 'put') {
      this.initEdit();
    }
  },
  methods: {
    initEdit: function initEdit() {
      var widgetData = JSON.parse(this.widget_data);
      this.widget = {
        id: widgetData.id,
        name: widgetData.name,
        model: widgetData.model,
        data: widgetData.data,
        placement: widgetData.placement,
        page_types: !_.isNull(widgetData.page_types) ? JSON.parse(widgetData.page_types) : null,
        tags: Array.isArray(widgetData.tags) && widgetData.tags.length ? widgetData.tags : [],
        blade: widgetData.blade,
        template_id: widgetData.template_id,
        code: widgetData.code,
        description: widgetData.description
      };
    },
    highlighter: function highlighter(code) {
      return (0,prismjs_components_prism_core__WEBPACK_IMPORTED_MODULE_4__.highlight)(code, prismjs_components_prism_core__WEBPACK_IMPORTED_MODULE_4__.languages.js); //returns html
    },
    saveData: function saveData(actionType) {
      var _this = this;
      this.validationErrors = {};
      var params = _objectSpread({}, this.widget);
      params.tags = params.tags.map(function (tag) {
        return {
          tag_id: tag.id
        };
      });
      params._save_action = actionType;
      params.page_types = _.isNull(this.widget.page_types) || this.widget.page_types === undefined ? null : this.widget.page_types.length > 0 ? JSON.stringify(this.widget.page_types) : null;
      axios[this.method]("".concat(this.axios_url), params).then(function (response) {
        window.location.href = "/" + response.data.redirect_url;
      })["catch"](function (err) {
        _this.validationErrors = err.response.data.errors;
        new Noty({
          type: "error",
          text: err.response.data.message
        }).show();
        console.error(err);
      });
    },
    removeError: function removeError(key) {
      var errorsObject = this.validationErrors;
      var errorExist = errorsObject[key];
      if (errorExist) {
        delete errorsObject[key];
      }
      //for re-render parent component
      if (Object.keys(errorsObject).length <= 0) {
        this.validationErrors = "";
      }
      this.validationErrors = errorsObject;
    }
  }
});

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/widget/Create.vue?vue&type=template&id=0e34964a&scoped=true":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/widget/Create.vue?vue&type=template&id=0e34964a&scoped=true ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "animated fadeIn",
    attrs: {
      id: "widgetCreate"
    }
  }, [_c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-md-8 bold-labels"
  }, [_c("form", {
    attrs: {
      method: "post",
      action: _vm.backUrl
    }
  }, [_c("div", {
    staticClass: "card"
  }, [_c("div", {
    staticClass: "card-body row"
  }, [_c("div", {
    staticClass: "form-group col-sm-12",
    "class": {
      "text-danger": _vm.validationErrors.name
    }
  }, [_vm._m(0), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.widget.name,
      expression: "widget.name"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.validationErrors.name
    },
    attrs: {
      type: "text",
      name: "name"
    },
    domProps: {
      value: _vm.widget.name
    },
    on: {
      input: [function ($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.widget, "name", $event.target.value);
      }, function ($event) {
        return _vm.removeError("name");
      }]
    }
  }), _vm._v(" "), _vm.validationErrors.name ? _c("small", {
    staticClass: "text-danger mt-3"
  }, [_vm._v(_vm._s(_vm.validationErrors.name[0]))]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group col-sm-12",
    "class": {
      "text-danger": _vm.validationErrors.model
    }
  }, [_c("label", [_vm._v(" Model ")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.widget.model,
      expression: "widget.model"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.validationErrors.model
    },
    attrs: {
      type: "text",
      name: "model"
    },
    domProps: {
      value: _vm.widget.model
    },
    on: {
      input: [function ($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.widget, "model", $event.target.value);
      }, function ($event) {
        return _vm.removeError("model");
      }]
    }
  }), _vm._v(" "), _vm.validationErrors.model ? _c("small", {
    staticClass: "text-danger mt-3"
  }, [_vm._v(_vm._s(_vm.validationErrors.model[0]))]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group col-sm-12",
    "class": {
      "text-danger": _vm.validationErrors.data
    }
  }, [_c("label", [_vm._v(" Data ")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.widget.data,
      expression: "widget.data"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.validationErrors.data
    },
    attrs: {
      type: "text",
      name: "data"
    },
    domProps: {
      value: _vm.widget.data
    },
    on: {
      input: [function ($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.widget, "data", $event.target.value);
      }, function ($event) {
        return _vm.removeError("data");
      }]
    }
  }), _vm._v(" "), _vm.validationErrors.data ? _c("small", {
    staticClass: "text-danger mt-3"
  }, [_vm._v(_vm._s(_vm.validationErrors.data[0]))]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group col-sm-12",
    "class": {
      "text-danger": _vm.validationErrors.placement
    }
  }, [_vm._m(1), _vm._v(" "), _c("treeselect", {
    "class": {
      "is-invalid": _vm.validationErrors.placement
    },
    attrs: {
      multiple: false,
      name: "placement",
      placeholder: "Pick an placement",
      options: _vm.allPlacements
    },
    on: {
      select: function select($event) {
        return _vm.removeError("placement");
      }
    },
    model: {
      value: _vm.widget.placement,
      callback: function callback($$v) {
        _vm.$set(_vm.widget, "placement", $$v);
      },
      expression: "widget.placement"
    }
  }), _vm._v(" "), _vm.validationErrors.placement ? _c("small", {
    staticClass: "text-danger mt-3"
  }, [_vm._v(_vm._s(_vm.validationErrors.placement[0]))]) : _vm._e()], 1), _vm._v(" "), _vm.widget.placement === "page" ? _c("div", {
    staticClass: "form-group col-sm-12",
    "class": {
      "text-danger": _vm.validationErrors.page_types
    }
  }, [_vm._m(2), _vm._v(" "), _c("treeselect", {
    "class": {
      "is-invalid": _vm.validationErrors.page_types
    },
    attrs: {
      name: "page_types",
      placeholder: "Pick some page types",
      options: _vm.allPageTypes,
      multiple: true
    },
    on: {
      select: function select($event) {
        return _vm.removeError("page_types");
      }
    },
    model: {
      value: _vm.widget.page_types,
      callback: function callback($$v) {
        _vm.$set(_vm.widget, "page_types", $$v);
      },
      expression: "widget.page_types"
    }
  }), _vm._v(" "), _vm.validationErrors.page_types ? _c("small", {
    staticClass: "text-danger mt-3"
  }, [_vm._v(_vm._s(_vm.validationErrors.page_types[0]))]) : _vm._e()], 1) : _vm._e(), _vm._v(" "), _c("div", {
    staticClass: "form-group col-sm-12",
    "class": {
      "text-danger": _vm.validationErrors.tags
    }
  }, [_vm._m(3), _vm._v(" "), _c("multiselect", {
    "class": {
      "is-invalid": _vm.validationErrors.tags
    },
    attrs: {
      name: "tags",
      label: "name",
      "track-by": "id",
      placeholder: "Pick some tags",
      options: _vm.allTags,
      multiple: true
    },
    on: {
      select: function select($event) {
        return _vm.removeError("tags");
      }
    },
    model: {
      value: _vm.widget.tags,
      callback: function callback($$v) {
        _vm.$set(_vm.widget, "tags", $$v);
      },
      expression: "widget.tags"
    }
  }), _vm._v(" "), _vm.validationErrors.tags ? _c("small", {
    staticClass: "text-danger mt-3"
  }, [_vm._v(_vm._s(_vm.validationErrors.tags[0]))]) : _vm._e()], 1), _vm._v(" "), _c("div", {
    staticClass: "form-group col-sm-12",
    "class": {
      "text-danger": _vm.validationErrors.blade
    }
  }, [_vm._m(4), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.widget.blade,
      expression: "widget.blade"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.validationErrors.blade
    },
    attrs: {
      type: "text",
      name: "blade"
    },
    domProps: {
      value: _vm.widget.blade
    },
    on: {
      input: [function ($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.widget, "blade", $event.target.value);
      }, function ($event) {
        return _vm.removeError("blade");
      }]
    }
  }), _vm._v(" "), _vm.validationErrors.blade ? _c("small", {
    staticClass: "text-danger mt-3"
  }, [_vm._v(_vm._s(_vm.validationErrors.blade[0]))]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group col-sm-12",
    "class": {
      "text-danger": _vm.validationErrors.template_id
    }
  }, [_vm._m(5), _vm._v(" "), _c("treeselect", {
    "class": {
      "is-invalid": _vm.validationErrors.template_id
    },
    attrs: {
      multiple: false,
      name: "placement",
      placeholder: "Pick a template",
      options: _vm.allTemplates
    },
    on: {
      select: function select($event) {
        return _vm.removeError("template_id");
      }
    },
    model: {
      value: _vm.widget.template_id,
      callback: function callback($$v) {
        _vm.$set(_vm.widget, "template_id", $$v);
      },
      expression: "widget.template_id"
    }
  }), _vm._v(" "), _vm.validationErrors.template_id ? _c("small", {
    staticClass: "text-danger mt-3"
  }, [_vm._v(_vm._s(_vm.validationErrors.template_id[0]))]) : _vm._e()], 1), _vm._v(" "), _c("div", {
    staticClass: "form-group col-sm-12",
    "class": {
      "text-danger": _vm.validationErrors.description
    }
  }, [_vm._m(6), _vm._v(" "), _c("textarea", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.widget.description,
      expression: "widget.description"
    }],
    staticClass: "form-control",
    "class": {
      "is-invalid": _vm.validationErrors.description
    },
    attrs: {
      rows: "3"
    },
    domProps: {
      value: _vm.widget.description
    },
    on: {
      input: [function ($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.widget, "description", $event.target.value);
      }, function ($event) {
        return _vm.removeError("description");
      }]
    }
  }), _vm._v(" "), _vm.validationErrors.description ? _c("small", {
    staticClass: "text-danger mt-3"
  }, [_vm._v(_vm._s(_vm.validationErrors.description[0]))]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group col-sm-12 required"
  }, [_c("label", {
    "class": {
      "error-color": _vm.validationErrors.code
    }
  }, [_vm._v("\n                                Code\n                                "), _c("span", {
    staticClass: "text-danger font-weight-bold"
  }, [_vm._v("*")])]), _vm._v(" "), _c("prism-editor", {
    staticClass: "my-editor language-xml-doc",
    attrs: {
      highlight: _vm.highlighter,
      "line-numbers": true,
      readonly: _vm.$parent.method === "get"
    },
    model: {
      value: _vm.widget.code,
      callback: function callback($$v) {
        _vm.$set(_vm.widget, "code", $$v);
      },
      expression: "widget.code"
    }
  }), _vm._v(" "), _vm.validationErrors.code ? _c("small", {
    staticClass: "text-danger mt-3"
  }, [_vm._v("\n                                " + _vm._s(_vm.validationErrors.code[0]) + "\n                            ")]) : _vm._e()], 1)])]), _vm._v(" "), _c("div", {
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
    staticClass: "btn btn-success",
    attrs: {
      type: "button"
    },
    on: {
      click: function click($event) {
        return _vm.saveData(_vm.saveAction.active.value);
      }
    }
  }, [_c("span", {
    staticClass: "la la-save",
    attrs: {
      role: "presentation",
      "aria-hidden": "true"
    }
  }), _vm._v("  \n                            "), _c("span", [_vm._v(_vm._s(_vm.saveAction.active.label))])]), _vm._v(" "), _c("div", {
    staticClass: "btn-group",
    attrs: {
      role: "group"
    }
  }, [_vm._m(7), _vm._v(" "), _c("div", {
    staticClass: "dropdown-menu",
    attrs: {
      "aria-labelledby": "bpSaveButtonsGroup"
    }
  }, [_vm._l(_vm.saveAction.options, function (option, k, index) {
    return [_c("button", {
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
    }, [_vm._v("\n                                        " + _vm._s(option) + "\n                                    ")])];
  })], 2)])]), _vm._v(" "), _c("a", {
    staticClass: "btn btn-default",
    attrs: {
      href: _vm.backUrl
    }
  }, [_c("span", {
    staticClass: "la la-ban"
  }), _vm._v("  Cancel")])])])])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", [_vm._v(" Name "), _c("span", {
    staticClass: "text-danger font-weight-bold"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "d-flex justify-content-between"
  }, [_c("label", [_vm._v("Placement "), _c("span", {
    staticClass: "text-danger font-weight-bold"
  }, [_vm._v("*")])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "d-flex justify-content-between"
  }, [_c("label", [_vm._v("Page Types "), _c("span", {
    staticClass: "text-danger font-weight-bold"
  }, [_vm._v("*")])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "d-flex justify-content-between"
  }, [_c("label", [_vm._v("Tags")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", [_vm._v(" Blade "), _c("span", {
    staticClass: "text-danger font-weight-bold"
  }, [_vm._v("*")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "d-flex justify-content-between"
  }, [_c("label", [_vm._v("Template")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "d-flex justify-content-between"
  }, [_c("label", [_vm._v("Description")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("button", {
    staticClass: "btn btn-success dropdown-toggle",
    attrs: {
      id: "bpSaveButtonsGroup",
      type: "button",
      "data-toggle": "dropdown",
      "aria-haspopup": "true",
      "aria-expanded": "false"
    }
  }, [_c("span", {
    staticClass: "caret"
  }), _c("span", {
    staticClass: "sr-only"
  }, [_vm._v("▼")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/prismjs/themes/prism-okaidia.min.css":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/prismjs/themes/prism-okaidia.min.css ***!
  \*********************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../laravel-mix/node_modules/css-loader/dist/runtime/api.js */ "./node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "code[class*=language-],pre[class*=language-]{color:#f8f8f2;background:0 0;text-shadow:0 1px rgba(0,0,0,.3);font-family:Consolas,Monaco,'Andale Mono','Ubuntu Mono',monospace;font-size:1em;text-align:left;white-space:pre;word-spacing:normal;word-break:normal;word-wrap:normal;line-height:1.5;-moz-tab-size:4;-o-tab-size:4;tab-size:4;-webkit-hyphens:none;hyphens:none}pre[class*=language-]{padding:1em;margin:.5em 0;overflow:auto;border-radius:.3em}:not(pre)>code[class*=language-],pre[class*=language-]{background:#272822}:not(pre)>code[class*=language-]{padding:.1em;border-radius:.3em;white-space:normal}.token.cdata,.token.comment,.token.doctype,.token.prolog{color:#8292a2}.token.punctuation{color:#f8f8f2}.token.namespace{opacity:.7}.token.constant,.token.deleted,.token.property,.token.symbol,.token.tag{color:#f92672}.token.boolean,.token.number{color:#ae81ff}.token.attr-name,.token.builtin,.token.char,.token.inserted,.token.selector,.token.string{color:#a6e22e}.language-css .token.string,.style .token.string,.token.entity,.token.operator,.token.url,.token.variable{color:#f8f8f2}.token.atrule,.token.attr-value,.token.class-name,.token.function{color:#e6db74}.token.keyword{color:#66d9ef}.token.important,.token.regex{color:#fd971f}.token.bold,.token.important{font-weight:700}.token.italic{font-style:italic}.token.entity{cursor:help}", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-prism-editor/dist/prismeditor.min.css":
/*!**************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-prism-editor/dist/prismeditor.min.css ***!
  \**************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../laravel-mix/node_modules/css-loader/dist/runtime/api.js */ "./node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, ".prism-editor-wrapper{width:100%;height:100%;display:flex;align-items:flex-start;overflow:auto;-o-tab-size:1.5em;tab-size:1.5em;-moz-tab-size:1.5em}@media (-ms-high-contrast:active),(-ms-high-contrast:none){.prism-editor-wrapper .prism-editor__textarea{color:transparent!important}.prism-editor-wrapper .prism-editor__textarea::-moz-selection{background-color:#accef7!important;color:transparent!important}.prism-editor-wrapper .prism-editor__textarea::selection{background-color:#accef7!important;color:transparent!important}}.prism-editor-wrapper .prism-editor__container{position:relative;text-align:left;box-sizing:border-box;padding:0;overflow:hidden;width:100%}.prism-editor-wrapper .prism-editor__line-numbers{height:100%;overflow:hidden;flex-shrink:0;padding-top:4px;margin-top:0;margin-right:10px}.prism-editor-wrapper .prism-editor__line-number{text-align:right;white-space:nowrap}.prism-editor-wrapper .prism-editor__textarea{position:absolute;top:0;left:0;height:100%;width:100%;resize:none;color:inherit;overflow:hidden;-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;-webkit-text-fill-color:transparent}.prism-editor-wrapper .prism-editor__editor,.prism-editor-wrapper .prism-editor__textarea{margin:0;border:0;background:none;box-sizing:inherit;display:inherit;font-family:inherit;font-size:inherit;font-style:inherit;font-variant-ligatures:inherit;font-weight:inherit;letter-spacing:inherit;line-height:inherit;-moz-tab-size:inherit;-o-tab-size:inherit;tab-size:inherit;text-indent:inherit;text-rendering:inherit;text-transform:inherit;white-space:pre-wrap;word-wrap:keep-all;overflow-wrap:break-word;padding:0}.prism-editor-wrapper .prism-editor__textarea--empty{-webkit-text-fill-color:inherit!important}.prism-editor-wrapper .prism-editor__editor{position:relative;pointer-events:none}", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/prismjs/themes/prism-okaidia.min.css":
/*!***********************************************************!*\
  !*** ./node_modules/prismjs/themes/prism-okaidia.min.css ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_prism_okaidia_min_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./prism-okaidia.min.css */ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/prismjs/themes/prism-okaidia.min.css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_prism_okaidia_min_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_prism_okaidia_min_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/vue-prism-editor/dist/prismeditor.min.css":
/*!****************************************************************!*\
  !*** ./node_modules/vue-prism-editor/dist/prismeditor.min.css ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_prismeditor_min_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./prismeditor.min.css */ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/laravel-mix/node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-prism-editor/dist/prismeditor.min.css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_prismeditor_min_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_laravel_mix_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_prismeditor_min_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/prismjs/components/prism-clike.js":
/*!********************************************************!*\
  !*** ./node_modules/prismjs/components/prism-clike.js ***!
  \********************************************************/
/***/ (() => {

Prism.languages.clike = {
	'comment': [
		{
			pattern: /(^|[^\\])\/\*[\s\S]*?(?:\*\/|$)/,
			lookbehind: true,
			greedy: true
		},
		{
			pattern: /(^|[^\\:])\/\/.*/,
			lookbehind: true,
			greedy: true
		}
	],
	'string': {
		pattern: /(["'])(?:\\(?:\r\n|[\s\S])|(?!\1)[^\\\r\n])*\1/,
		greedy: true
	},
	'class-name': {
		pattern: /(\b(?:class|extends|implements|instanceof|interface|new|trait)\s+|\bcatch\s+\()[\w.\\]+/i,
		lookbehind: true,
		inside: {
			'punctuation': /[.\\]/
		}
	},
	'keyword': /\b(?:break|catch|continue|do|else|finally|for|function|if|in|instanceof|new|null|return|throw|try|while)\b/,
	'boolean': /\b(?:false|true)\b/,
	'function': /\b\w+(?=\()/,
	'number': /\b0x[\da-f]+\b|(?:\b\d+(?:\.\d*)?|\B\.\d+)(?:e[+-]?\d+)?/i,
	'operator': /[<>]=?|[!=]=?=?|--?|\+\+?|&&?|\|\|?|[?*/~^%]/,
	'punctuation': /[{}[\];(),.:]/
};


/***/ }),

/***/ "./node_modules/prismjs/components/prism-core.js":
/*!*******************************************************!*\
  !*** ./node_modules/prismjs/components/prism-core.js ***!
  \*******************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

/// <reference lib="WebWorker"/>

var _self = (typeof window !== 'undefined')
	? window   // if in browser
	: (
		(typeof WorkerGlobalScope !== 'undefined' && self instanceof WorkerGlobalScope)
			? self // if in worker
			: {}   // if in node js
	);

/**
 * Prism: Lightweight, robust, elegant syntax highlighting
 *
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author Lea Verou <https://lea.verou.me>
 * @namespace
 * @public
 */
var Prism = (function (_self) {

	// Private helper vars
	var lang = /(?:^|\s)lang(?:uage)?-([\w-]+)(?=\s|$)/i;
	var uniqueId = 0;

	// The grammar object for plaintext
	var plainTextGrammar = {};


	var _ = {
		/**
		 * By default, Prism will attempt to highlight all code elements (by calling {@link Prism.highlightAll}) on the
		 * current page after the page finished loading. This might be a problem if e.g. you wanted to asynchronously load
		 * additional languages or plugins yourself.
		 *
		 * By setting this value to `true`, Prism will not automatically highlight all code elements on the page.
		 *
		 * You obviously have to change this value before the automatic highlighting started. To do this, you can add an
		 * empty Prism object into the global scope before loading the Prism script like this:
		 *
		 * ```js
		 * window.Prism = window.Prism || {};
		 * Prism.manual = true;
		 * // add a new <script> to load Prism's script
		 * ```
		 *
		 * @default false
		 * @type {boolean}
		 * @memberof Prism
		 * @public
		 */
		manual: _self.Prism && _self.Prism.manual,
		/**
		 * By default, if Prism is in a web worker, it assumes that it is in a worker it created itself, so it uses
		 * `addEventListener` to communicate with its parent instance. However, if you're using Prism manually in your
		 * own worker, you don't want it to do this.
		 *
		 * By setting this value to `true`, Prism will not add its own listeners to the worker.
		 *
		 * You obviously have to change this value before Prism executes. To do this, you can add an
		 * empty Prism object into the global scope before loading the Prism script like this:
		 *
		 * ```js
		 * window.Prism = window.Prism || {};
		 * Prism.disableWorkerMessageHandler = true;
		 * // Load Prism's script
		 * ```
		 *
		 * @default false
		 * @type {boolean}
		 * @memberof Prism
		 * @public
		 */
		disableWorkerMessageHandler: _self.Prism && _self.Prism.disableWorkerMessageHandler,

		/**
		 * A namespace for utility methods.
		 *
		 * All function in this namespace that are not explicitly marked as _public_ are for __internal use only__ and may
		 * change or disappear at any time.
		 *
		 * @namespace
		 * @memberof Prism
		 */
		util: {
			encode: function encode(tokens) {
				if (tokens instanceof Token) {
					return new Token(tokens.type, encode(tokens.content), tokens.alias);
				} else if (Array.isArray(tokens)) {
					return tokens.map(encode);
				} else {
					return tokens.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/\u00a0/g, ' ');
				}
			},

			/**
			 * Returns the name of the type of the given value.
			 *
			 * @param {any} o
			 * @returns {string}
			 * @example
			 * type(null)      === 'Null'
			 * type(undefined) === 'Undefined'
			 * type(123)       === 'Number'
			 * type('foo')     === 'String'
			 * type(true)      === 'Boolean'
			 * type([1, 2])    === 'Array'
			 * type({})        === 'Object'
			 * type(String)    === 'Function'
			 * type(/abc+/)    === 'RegExp'
			 */
			type: function (o) {
				return Object.prototype.toString.call(o).slice(8, -1);
			},

			/**
			 * Returns a unique number for the given object. Later calls will still return the same number.
			 *
			 * @param {Object} obj
			 * @returns {number}
			 */
			objId: function (obj) {
				if (!obj['__id']) {
					Object.defineProperty(obj, '__id', { value: ++uniqueId });
				}
				return obj['__id'];
			},

			/**
			 * Creates a deep clone of the given object.
			 *
			 * The main intended use of this function is to clone language definitions.
			 *
			 * @param {T} o
			 * @param {Record<number, any>} [visited]
			 * @returns {T}
			 * @template T
			 */
			clone: function deepClone(o, visited) {
				visited = visited || {};

				var clone; var id;
				switch (_.util.type(o)) {
					case 'Object':
						id = _.util.objId(o);
						if (visited[id]) {
							return visited[id];
						}
						clone = /** @type {Record<string, any>} */ ({});
						visited[id] = clone;

						for (var key in o) {
							if (o.hasOwnProperty(key)) {
								clone[key] = deepClone(o[key], visited);
							}
						}

						return /** @type {any} */ (clone);

					case 'Array':
						id = _.util.objId(o);
						if (visited[id]) {
							return visited[id];
						}
						clone = [];
						visited[id] = clone;

						(/** @type {Array} */(/** @type {any} */(o))).forEach(function (v, i) {
							clone[i] = deepClone(v, visited);
						});

						return /** @type {any} */ (clone);

					default:
						return o;
				}
			},

			/**
			 * Returns the Prism language of the given element set by a `language-xxxx` or `lang-xxxx` class.
			 *
			 * If no language is set for the element or the element is `null` or `undefined`, `none` will be returned.
			 *
			 * @param {Element} element
			 * @returns {string}
			 */
			getLanguage: function (element) {
				while (element) {
					var m = lang.exec(element.className);
					if (m) {
						return m[1].toLowerCase();
					}
					element = element.parentElement;
				}
				return 'none';
			},

			/**
			 * Sets the Prism `language-xxxx` class of the given element.
			 *
			 * @param {Element} element
			 * @param {string} language
			 * @returns {void}
			 */
			setLanguage: function (element, language) {
				// remove all `language-xxxx` classes
				// (this might leave behind a leading space)
				element.className = element.className.replace(RegExp(lang, 'gi'), '');

				// add the new `language-xxxx` class
				// (using `classList` will automatically clean up spaces for us)
				element.classList.add('language-' + language);
			},

			/**
			 * Returns the script element that is currently executing.
			 *
			 * This does __not__ work for line script element.
			 *
			 * @returns {HTMLScriptElement | null}
			 */
			currentScript: function () {
				if (typeof document === 'undefined') {
					return null;
				}
				if ('currentScript' in document && 1 < 2 /* hack to trip TS' flow analysis */) {
					return /** @type {any} */ (document.currentScript);
				}

				// IE11 workaround
				// we'll get the src of the current script by parsing IE11's error stack trace
				// this will not work for inline scripts

				try {
					throw new Error();
				} catch (err) {
					// Get file src url from stack. Specifically works with the format of stack traces in IE.
					// A stack will look like this:
					//
					// Error
					//    at _.util.currentScript (http://localhost/components/prism-core.js:119:5)
					//    at Global code (http://localhost/components/prism-core.js:606:1)

					var src = (/at [^(\r\n]*\((.*):[^:]+:[^:]+\)$/i.exec(err.stack) || [])[1];
					if (src) {
						var scripts = document.getElementsByTagName('script');
						for (var i in scripts) {
							if (scripts[i].src == src) {
								return scripts[i];
							}
						}
					}
					return null;
				}
			},

			/**
			 * Returns whether a given class is active for `element`.
			 *
			 * The class can be activated if `element` or one of its ancestors has the given class and it can be deactivated
			 * if `element` or one of its ancestors has the negated version of the given class. The _negated version_ of the
			 * given class is just the given class with a `no-` prefix.
			 *
			 * Whether the class is active is determined by the closest ancestor of `element` (where `element` itself is
			 * closest ancestor) that has the given class or the negated version of it. If neither `element` nor any of its
			 * ancestors have the given class or the negated version of it, then the default activation will be returned.
			 *
			 * In the paradoxical situation where the closest ancestor contains __both__ the given class and the negated
			 * version of it, the class is considered active.
			 *
			 * @param {Element} element
			 * @param {string} className
			 * @param {boolean} [defaultActivation=false]
			 * @returns {boolean}
			 */
			isActive: function (element, className, defaultActivation) {
				var no = 'no-' + className;

				while (element) {
					var classList = element.classList;
					if (classList.contains(className)) {
						return true;
					}
					if (classList.contains(no)) {
						return false;
					}
					element = element.parentElement;
				}
				return !!defaultActivation;
			}
		},

		/**
		 * This namespace contains all currently loaded languages and the some helper functions to create and modify languages.
		 *
		 * @namespace
		 * @memberof Prism
		 * @public
		 */
		languages: {
			/**
			 * The grammar for plain, unformatted text.
			 */
			plain: plainTextGrammar,
			plaintext: plainTextGrammar,
			text: plainTextGrammar,
			txt: plainTextGrammar,

			/**
			 * Creates a deep copy of the language with the given id and appends the given tokens.
			 *
			 * If a token in `redef` also appears in the copied language, then the existing token in the copied language
			 * will be overwritten at its original position.
			 *
			 * ## Best practices
			 *
			 * Since the position of overwriting tokens (token in `redef` that overwrite tokens in the copied language)
			 * doesn't matter, they can technically be in any order. However, this can be confusing to others that trying to
			 * understand the language definition because, normally, the order of tokens matters in Prism grammars.
			 *
			 * Therefore, it is encouraged to order overwriting tokens according to the positions of the overwritten tokens.
			 * Furthermore, all non-overwriting tokens should be placed after the overwriting ones.
			 *
			 * @param {string} id The id of the language to extend. This has to be a key in `Prism.languages`.
			 * @param {Grammar} redef The new tokens to append.
			 * @returns {Grammar} The new language created.
			 * @public
			 * @example
			 * Prism.languages['css-with-colors'] = Prism.languages.extend('css', {
			 *     // Prism.languages.css already has a 'comment' token, so this token will overwrite CSS' 'comment' token
			 *     // at its original position
			 *     'comment': { ... },
			 *     // CSS doesn't have a 'color' token, so this token will be appended
			 *     'color': /\b(?:red|green|blue)\b/
			 * });
			 */
			extend: function (id, redef) {
				var lang = _.util.clone(_.languages[id]);

				for (var key in redef) {
					lang[key] = redef[key];
				}

				return lang;
			},

			/**
			 * Inserts tokens _before_ another token in a language definition or any other grammar.
			 *
			 * ## Usage
			 *
			 * This helper method makes it easy to modify existing languages. For example, the CSS language definition
			 * not only defines CSS highlighting for CSS documents, but also needs to define highlighting for CSS embedded
			 * in HTML through `<style>` elements. To do this, it needs to modify `Prism.languages.markup` and add the
			 * appropriate tokens. However, `Prism.languages.markup` is a regular JavaScript object literal, so if you do
			 * this:
			 *
			 * ```js
			 * Prism.languages.markup.style = {
			 *     // token
			 * };
			 * ```
			 *
			 * then the `style` token will be added (and processed) at the end. `insertBefore` allows you to insert tokens
			 * before existing tokens. For the CSS example above, you would use it like this:
			 *
			 * ```js
			 * Prism.languages.insertBefore('markup', 'cdata', {
			 *     'style': {
			 *         // token
			 *     }
			 * });
			 * ```
			 *
			 * ## Special cases
			 *
			 * If the grammars of `inside` and `insert` have tokens with the same name, the tokens in `inside`'s grammar
			 * will be ignored.
			 *
			 * This behavior can be used to insert tokens after `before`:
			 *
			 * ```js
			 * Prism.languages.insertBefore('markup', 'comment', {
			 *     'comment': Prism.languages.markup.comment,
			 *     // tokens after 'comment'
			 * });
			 * ```
			 *
			 * ## Limitations
			 *
			 * The main problem `insertBefore` has to solve is iteration order. Since ES2015, the iteration order for object
			 * properties is guaranteed to be the insertion order (except for integer keys) but some browsers behave
			 * differently when keys are deleted and re-inserted. So `insertBefore` can't be implemented by temporarily
			 * deleting properties which is necessary to insert at arbitrary positions.
			 *
			 * To solve this problem, `insertBefore` doesn't actually insert the given tokens into the target object.
			 * Instead, it will create a new object and replace all references to the target object with the new one. This
			 * can be done without temporarily deleting properties, so the iteration order is well-defined.
			 *
			 * However, only references that can be reached from `Prism.languages` or `insert` will be replaced. I.e. if
			 * you hold the target object in a variable, then the value of the variable will not change.
			 *
			 * ```js
			 * var oldMarkup = Prism.languages.markup;
			 * var newMarkup = Prism.languages.insertBefore('markup', 'comment', { ... });
			 *
			 * assert(oldMarkup !== Prism.languages.markup);
			 * assert(newMarkup === Prism.languages.markup);
			 * ```
			 *
			 * @param {string} inside The property of `root` (e.g. a language id in `Prism.languages`) that contains the
			 * object to be modified.
			 * @param {string} before The key to insert before.
			 * @param {Grammar} insert An object containing the key-value pairs to be inserted.
			 * @param {Object<string, any>} [root] The object containing `inside`, i.e. the object that contains the
			 * object to be modified.
			 *
			 * Defaults to `Prism.languages`.
			 * @returns {Grammar} The new grammar object.
			 * @public
			 */
			insertBefore: function (inside, before, insert, root) {
				root = root || /** @type {any} */ (_.languages);
				var grammar = root[inside];
				/** @type {Grammar} */
				var ret = {};

				for (var token in grammar) {
					if (grammar.hasOwnProperty(token)) {

						if (token == before) {
							for (var newToken in insert) {
								if (insert.hasOwnProperty(newToken)) {
									ret[newToken] = insert[newToken];
								}
							}
						}

						// Do not insert token which also occur in insert. See #1525
						if (!insert.hasOwnProperty(token)) {
							ret[token] = grammar[token];
						}
					}
				}

				var old = root[inside];
				root[inside] = ret;

				// Update references in other language definitions
				_.languages.DFS(_.languages, function (key, value) {
					if (value === old && key != inside) {
						this[key] = ret;
					}
				});

				return ret;
			},

			// Traverse a language definition with Depth First Search
			DFS: function DFS(o, callback, type, visited) {
				visited = visited || {};

				var objId = _.util.objId;

				for (var i in o) {
					if (o.hasOwnProperty(i)) {
						callback.call(o, i, o[i], type || i);

						var property = o[i];
						var propertyType = _.util.type(property);

						if (propertyType === 'Object' && !visited[objId(property)]) {
							visited[objId(property)] = true;
							DFS(property, callback, null, visited);
						} else if (propertyType === 'Array' && !visited[objId(property)]) {
							visited[objId(property)] = true;
							DFS(property, callback, i, visited);
						}
					}
				}
			}
		},

		plugins: {},

		/**
		 * This is the most high-level function in Prism’s API.
		 * It fetches all the elements that have a `.language-xxxx` class and then calls {@link Prism.highlightElement} on
		 * each one of them.
		 *
		 * This is equivalent to `Prism.highlightAllUnder(document, async, callback)`.
		 *
		 * @param {boolean} [async=false] Same as in {@link Prism.highlightAllUnder}.
		 * @param {HighlightCallback} [callback] Same as in {@link Prism.highlightAllUnder}.
		 * @memberof Prism
		 * @public
		 */
		highlightAll: function (async, callback) {
			_.highlightAllUnder(document, async, callback);
		},

		/**
		 * Fetches all the descendants of `container` that have a `.language-xxxx` class and then calls
		 * {@link Prism.highlightElement} on each one of them.
		 *
		 * The following hooks will be run:
		 * 1. `before-highlightall`
		 * 2. `before-all-elements-highlight`
		 * 3. All hooks of {@link Prism.highlightElement} for each element.
		 *
		 * @param {ParentNode} container The root element, whose descendants that have a `.language-xxxx` class will be highlighted.
		 * @param {boolean} [async=false] Whether each element is to be highlighted asynchronously using Web Workers.
		 * @param {HighlightCallback} [callback] An optional callback to be invoked on each element after its highlighting is done.
		 * @memberof Prism
		 * @public
		 */
		highlightAllUnder: function (container, async, callback) {
			var env = {
				callback: callback,
				container: container,
				selector: 'code[class*="language-"], [class*="language-"] code, code[class*="lang-"], [class*="lang-"] code'
			};

			_.hooks.run('before-highlightall', env);

			env.elements = Array.prototype.slice.apply(env.container.querySelectorAll(env.selector));

			_.hooks.run('before-all-elements-highlight', env);

			for (var i = 0, element; (element = env.elements[i++]);) {
				_.highlightElement(element, async === true, env.callback);
			}
		},

		/**
		 * Highlights the code inside a single element.
		 *
		 * The following hooks will be run:
		 * 1. `before-sanity-check`
		 * 2. `before-highlight`
		 * 3. All hooks of {@link Prism.highlight}. These hooks will be run by an asynchronous worker if `async` is `true`.
		 * 4. `before-insert`
		 * 5. `after-highlight`
		 * 6. `complete`
		 *
		 * Some the above hooks will be skipped if the element doesn't contain any text or there is no grammar loaded for
		 * the element's language.
		 *
		 * @param {Element} element The element containing the code.
		 * It must have a class of `language-xxxx` to be processed, where `xxxx` is a valid language identifier.
		 * @param {boolean} [async=false] Whether the element is to be highlighted asynchronously using Web Workers
		 * to improve performance and avoid blocking the UI when highlighting very large chunks of code. This option is
		 * [disabled by default](https://prismjs.com/faq.html#why-is-asynchronous-highlighting-disabled-by-default).
		 *
		 * Note: All language definitions required to highlight the code must be included in the main `prism.js` file for
		 * asynchronous highlighting to work. You can build your own bundle on the
		 * [Download page](https://prismjs.com/download.html).
		 * @param {HighlightCallback} [callback] An optional callback to be invoked after the highlighting is done.
		 * Mostly useful when `async` is `true`, since in that case, the highlighting is done asynchronously.
		 * @memberof Prism
		 * @public
		 */
		highlightElement: function (element, async, callback) {
			// Find language
			var language = _.util.getLanguage(element);
			var grammar = _.languages[language];

			// Set language on the element, if not present
			_.util.setLanguage(element, language);

			// Set language on the parent, for styling
			var parent = element.parentElement;
			if (parent && parent.nodeName.toLowerCase() === 'pre') {
				_.util.setLanguage(parent, language);
			}

			var code = element.textContent;

			var env = {
				element: element,
				language: language,
				grammar: grammar,
				code: code
			};

			function insertHighlightedCode(highlightedCode) {
				env.highlightedCode = highlightedCode;

				_.hooks.run('before-insert', env);

				env.element.innerHTML = env.highlightedCode;

				_.hooks.run('after-highlight', env);
				_.hooks.run('complete', env);
				callback && callback.call(env.element);
			}

			_.hooks.run('before-sanity-check', env);

			// plugins may change/add the parent/element
			parent = env.element.parentElement;
			if (parent && parent.nodeName.toLowerCase() === 'pre' && !parent.hasAttribute('tabindex')) {
				parent.setAttribute('tabindex', '0');
			}

			if (!env.code) {
				_.hooks.run('complete', env);
				callback && callback.call(env.element);
				return;
			}

			_.hooks.run('before-highlight', env);

			if (!env.grammar) {
				insertHighlightedCode(_.util.encode(env.code));
				return;
			}

			if (async && _self.Worker) {
				var worker = new Worker(_.filename);

				worker.onmessage = function (evt) {
					insertHighlightedCode(evt.data);
				};

				worker.postMessage(JSON.stringify({
					language: env.language,
					code: env.code,
					immediateClose: true
				}));
			} else {
				insertHighlightedCode(_.highlight(env.code, env.grammar, env.language));
			}
		},

		/**
		 * Low-level function, only use if you know what you’re doing. It accepts a string of text as input
		 * and the language definitions to use, and returns a string with the HTML produced.
		 *
		 * The following hooks will be run:
		 * 1. `before-tokenize`
		 * 2. `after-tokenize`
		 * 3. `wrap`: On each {@link Token}.
		 *
		 * @param {string} text A string with the code to be highlighted.
		 * @param {Grammar} grammar An object containing the tokens to use.
		 *
		 * Usually a language definition like `Prism.languages.markup`.
		 * @param {string} language The name of the language definition passed to `grammar`.
		 * @returns {string} The highlighted HTML.
		 * @memberof Prism
		 * @public
		 * @example
		 * Prism.highlight('var foo = true;', Prism.languages.javascript, 'javascript');
		 */
		highlight: function (text, grammar, language) {
			var env = {
				code: text,
				grammar: grammar,
				language: language
			};
			_.hooks.run('before-tokenize', env);
			if (!env.grammar) {
				throw new Error('The language "' + env.language + '" has no grammar.');
			}
			env.tokens = _.tokenize(env.code, env.grammar);
			_.hooks.run('after-tokenize', env);
			return Token.stringify(_.util.encode(env.tokens), env.language);
		},

		/**
		 * This is the heart of Prism, and the most low-level function you can use. It accepts a string of text as input
		 * and the language definitions to use, and returns an array with the tokenized code.
		 *
		 * When the language definition includes nested tokens, the function is called recursively on each of these tokens.
		 *
		 * This method could be useful in other contexts as well, as a very crude parser.
		 *
		 * @param {string} text A string with the code to be highlighted.
		 * @param {Grammar} grammar An object containing the tokens to use.
		 *
		 * Usually a language definition like `Prism.languages.markup`.
		 * @returns {TokenStream} An array of strings and tokens, a token stream.
		 * @memberof Prism
		 * @public
		 * @example
		 * let code = `var foo = 0;`;
		 * let tokens = Prism.tokenize(code, Prism.languages.javascript);
		 * tokens.forEach(token => {
		 *     if (token instanceof Prism.Token && token.type === 'number') {
		 *         console.log(`Found numeric literal: ${token.content}`);
		 *     }
		 * });
		 */
		tokenize: function (text, grammar) {
			var rest = grammar.rest;
			if (rest) {
				for (var token in rest) {
					grammar[token] = rest[token];
				}

				delete grammar.rest;
			}

			var tokenList = new LinkedList();
			addAfter(tokenList, tokenList.head, text);

			matchGrammar(text, tokenList, grammar, tokenList.head, 0);

			return toArray(tokenList);
		},

		/**
		 * @namespace
		 * @memberof Prism
		 * @public
		 */
		hooks: {
			all: {},

			/**
			 * Adds the given callback to the list of callbacks for the given hook.
			 *
			 * The callback will be invoked when the hook it is registered for is run.
			 * Hooks are usually directly run by a highlight function but you can also run hooks yourself.
			 *
			 * One callback function can be registered to multiple hooks and the same hook multiple times.
			 *
			 * @param {string} name The name of the hook.
			 * @param {HookCallback} callback The callback function which is given environment variables.
			 * @public
			 */
			add: function (name, callback) {
				var hooks = _.hooks.all;

				hooks[name] = hooks[name] || [];

				hooks[name].push(callback);
			},

			/**
			 * Runs a hook invoking all registered callbacks with the given environment variables.
			 *
			 * Callbacks will be invoked synchronously and in the order in which they were registered.
			 *
			 * @param {string} name The name of the hook.
			 * @param {Object<string, any>} env The environment variables of the hook passed to all callbacks registered.
			 * @public
			 */
			run: function (name, env) {
				var callbacks = _.hooks.all[name];

				if (!callbacks || !callbacks.length) {
					return;
				}

				for (var i = 0, callback; (callback = callbacks[i++]);) {
					callback(env);
				}
			}
		},

		Token: Token
	};
	_self.Prism = _;


	// Typescript note:
	// The following can be used to import the Token type in JSDoc:
	//
	//   @typedef {InstanceType<import("./prism-core")["Token"]>} Token

	/**
	 * Creates a new token.
	 *
	 * @param {string} type See {@link Token#type type}
	 * @param {string | TokenStream} content See {@link Token#content content}
	 * @param {string|string[]} [alias] The alias(es) of the token.
	 * @param {string} [matchedStr=""] A copy of the full string this token was created from.
	 * @class
	 * @global
	 * @public
	 */
	function Token(type, content, alias, matchedStr) {
		/**
		 * The type of the token.
		 *
		 * This is usually the key of a pattern in a {@link Grammar}.
		 *
		 * @type {string}
		 * @see GrammarToken
		 * @public
		 */
		this.type = type;
		/**
		 * The strings or tokens contained by this token.
		 *
		 * This will be a token stream if the pattern matched also defined an `inside` grammar.
		 *
		 * @type {string | TokenStream}
		 * @public
		 */
		this.content = content;
		/**
		 * The alias(es) of the token.
		 *
		 * @type {string|string[]}
		 * @see GrammarToken
		 * @public
		 */
		this.alias = alias;
		// Copy of the full string this token was created from
		this.length = (matchedStr || '').length | 0;
	}

	/**
	 * A token stream is an array of strings and {@link Token Token} objects.
	 *
	 * Token streams have to fulfill a few properties that are assumed by most functions (mostly internal ones) that process
	 * them.
	 *
	 * 1. No adjacent strings.
	 * 2. No empty strings.
	 *
	 *    The only exception here is the token stream that only contains the empty string and nothing else.
	 *
	 * @typedef {Array<string | Token>} TokenStream
	 * @global
	 * @public
	 */

	/**
	 * Converts the given token or token stream to an HTML representation.
	 *
	 * The following hooks will be run:
	 * 1. `wrap`: On each {@link Token}.
	 *
	 * @param {string | Token | TokenStream} o The token or token stream to be converted.
	 * @param {string} language The name of current language.
	 * @returns {string} The HTML representation of the token or token stream.
	 * @memberof Token
	 * @static
	 */
	Token.stringify = function stringify(o, language) {
		if (typeof o == 'string') {
			return o;
		}
		if (Array.isArray(o)) {
			var s = '';
			o.forEach(function (e) {
				s += stringify(e, language);
			});
			return s;
		}

		var env = {
			type: o.type,
			content: stringify(o.content, language),
			tag: 'span',
			classes: ['token', o.type],
			attributes: {},
			language: language
		};

		var aliases = o.alias;
		if (aliases) {
			if (Array.isArray(aliases)) {
				Array.prototype.push.apply(env.classes, aliases);
			} else {
				env.classes.push(aliases);
			}
		}

		_.hooks.run('wrap', env);

		var attributes = '';
		for (var name in env.attributes) {
			attributes += ' ' + name + '="' + (env.attributes[name] || '').replace(/"/g, '&quot;') + '"';
		}

		return '<' + env.tag + ' class="' + env.classes.join(' ') + '"' + attributes + '>' + env.content + '</' + env.tag + '>';
	};

	/**
	 * @param {RegExp} pattern
	 * @param {number} pos
	 * @param {string} text
	 * @param {boolean} lookbehind
	 * @returns {RegExpExecArray | null}
	 */
	function matchPattern(pattern, pos, text, lookbehind) {
		pattern.lastIndex = pos;
		var match = pattern.exec(text);
		if (match && lookbehind && match[1]) {
			// change the match to remove the text matched by the Prism lookbehind group
			var lookbehindLength = match[1].length;
			match.index += lookbehindLength;
			match[0] = match[0].slice(lookbehindLength);
		}
		return match;
	}

	/**
	 * @param {string} text
	 * @param {LinkedList<string | Token>} tokenList
	 * @param {any} grammar
	 * @param {LinkedListNode<string | Token>} startNode
	 * @param {number} startPos
	 * @param {RematchOptions} [rematch]
	 * @returns {void}
	 * @private
	 *
	 * @typedef RematchOptions
	 * @property {string} cause
	 * @property {number} reach
	 */
	function matchGrammar(text, tokenList, grammar, startNode, startPos, rematch) {
		for (var token in grammar) {
			if (!grammar.hasOwnProperty(token) || !grammar[token]) {
				continue;
			}

			var patterns = grammar[token];
			patterns = Array.isArray(patterns) ? patterns : [patterns];

			for (var j = 0; j < patterns.length; ++j) {
				if (rematch && rematch.cause == token + ',' + j) {
					return;
				}

				var patternObj = patterns[j];
				var inside = patternObj.inside;
				var lookbehind = !!patternObj.lookbehind;
				var greedy = !!patternObj.greedy;
				var alias = patternObj.alias;

				if (greedy && !patternObj.pattern.global) {
					// Without the global flag, lastIndex won't work
					var flags = patternObj.pattern.toString().match(/[imsuy]*$/)[0];
					patternObj.pattern = RegExp(patternObj.pattern.source, flags + 'g');
				}

				/** @type {RegExp} */
				var pattern = patternObj.pattern || patternObj;

				for ( // iterate the token list and keep track of the current token/string position
					var currentNode = startNode.next, pos = startPos;
					currentNode !== tokenList.tail;
					pos += currentNode.value.length, currentNode = currentNode.next
				) {

					if (rematch && pos >= rematch.reach) {
						break;
					}

					var str = currentNode.value;

					if (tokenList.length > text.length) {
						// Something went terribly wrong, ABORT, ABORT!
						return;
					}

					if (str instanceof Token) {
						continue;
					}

					var removeCount = 1; // this is the to parameter of removeBetween
					var match;

					if (greedy) {
						match = matchPattern(pattern, pos, text, lookbehind);
						if (!match || match.index >= text.length) {
							break;
						}

						var from = match.index;
						var to = match.index + match[0].length;
						var p = pos;

						// find the node that contains the match
						p += currentNode.value.length;
						while (from >= p) {
							currentNode = currentNode.next;
							p += currentNode.value.length;
						}
						// adjust pos (and p)
						p -= currentNode.value.length;
						pos = p;

						// the current node is a Token, then the match starts inside another Token, which is invalid
						if (currentNode.value instanceof Token) {
							continue;
						}

						// find the last node which is affected by this match
						for (
							var k = currentNode;
							k !== tokenList.tail && (p < to || typeof k.value === 'string');
							k = k.next
						) {
							removeCount++;
							p += k.value.length;
						}
						removeCount--;

						// replace with the new match
						str = text.slice(pos, p);
						match.index -= pos;
					} else {
						match = matchPattern(pattern, 0, str, lookbehind);
						if (!match) {
							continue;
						}
					}

					// eslint-disable-next-line no-redeclare
					var from = match.index;
					var matchStr = match[0];
					var before = str.slice(0, from);
					var after = str.slice(from + matchStr.length);

					var reach = pos + str.length;
					if (rematch && reach > rematch.reach) {
						rematch.reach = reach;
					}

					var removeFrom = currentNode.prev;

					if (before) {
						removeFrom = addAfter(tokenList, removeFrom, before);
						pos += before.length;
					}

					removeRange(tokenList, removeFrom, removeCount);

					var wrapped = new Token(token, inside ? _.tokenize(matchStr, inside) : matchStr, alias, matchStr);
					currentNode = addAfter(tokenList, removeFrom, wrapped);

					if (after) {
						addAfter(tokenList, currentNode, after);
					}

					if (removeCount > 1) {
						// at least one Token object was removed, so we have to do some rematching
						// this can only happen if the current pattern is greedy

						/** @type {RematchOptions} */
						var nestedRematch = {
							cause: token + ',' + j,
							reach: reach
						};
						matchGrammar(text, tokenList, grammar, currentNode.prev, pos, nestedRematch);

						// the reach might have been extended because of the rematching
						if (rematch && nestedRematch.reach > rematch.reach) {
							rematch.reach = nestedRematch.reach;
						}
					}
				}
			}
		}
	}

	/**
	 * @typedef LinkedListNode
	 * @property {T} value
	 * @property {LinkedListNode<T> | null} prev The previous node.
	 * @property {LinkedListNode<T> | null} next The next node.
	 * @template T
	 * @private
	 */

	/**
	 * @template T
	 * @private
	 */
	function LinkedList() {
		/** @type {LinkedListNode<T>} */
		var head = { value: null, prev: null, next: null };
		/** @type {LinkedListNode<T>} */
		var tail = { value: null, prev: head, next: null };
		head.next = tail;

		/** @type {LinkedListNode<T>} */
		this.head = head;
		/** @type {LinkedListNode<T>} */
		this.tail = tail;
		this.length = 0;
	}

	/**
	 * Adds a new node with the given value to the list.
	 *
	 * @param {LinkedList<T>} list
	 * @param {LinkedListNode<T>} node
	 * @param {T} value
	 * @returns {LinkedListNode<T>} The added node.
	 * @template T
	 */
	function addAfter(list, node, value) {
		// assumes that node != list.tail && values.length >= 0
		var next = node.next;

		var newNode = { value: value, prev: node, next: next };
		node.next = newNode;
		next.prev = newNode;
		list.length++;

		return newNode;
	}
	/**
	 * Removes `count` nodes after the given node. The given node will not be removed.
	 *
	 * @param {LinkedList<T>} list
	 * @param {LinkedListNode<T>} node
	 * @param {number} count
	 * @template T
	 */
	function removeRange(list, node, count) {
		var next = node.next;
		for (var i = 0; i < count && next !== list.tail; i++) {
			next = next.next;
		}
		node.next = next;
		next.prev = node;
		list.length -= i;
	}
	/**
	 * @param {LinkedList<T>} list
	 * @returns {T[]}
	 * @template T
	 */
	function toArray(list) {
		var array = [];
		var node = list.head.next;
		while (node !== list.tail) {
			array.push(node.value);
			node = node.next;
		}
		return array;
	}


	if (!_self.document) {
		if (!_self.addEventListener) {
			// in Node.js
			return _;
		}

		if (!_.disableWorkerMessageHandler) {
			// In worker
			_self.addEventListener('message', function (evt) {
				var message = JSON.parse(evt.data);
				var lang = message.language;
				var code = message.code;
				var immediateClose = message.immediateClose;

				_self.postMessage(_.highlight(code, _.languages[lang], lang));
				if (immediateClose) {
					_self.close();
				}
			}, false);
		}

		return _;
	}

	// Get current script and highlight
	var script = _.util.currentScript();

	if (script) {
		_.filename = script.src;

		if (script.hasAttribute('data-manual')) {
			_.manual = true;
		}
	}

	function highlightAutomaticallyCallback() {
		if (!_.manual) {
			_.highlightAll();
		}
	}

	if (!_.manual) {
		// If the document state is "loading", then we'll use DOMContentLoaded.
		// If the document state is "interactive" and the prism.js script is deferred, then we'll also use the
		// DOMContentLoaded event because there might be some plugins or languages which have also been deferred and they
		// might take longer one animation frame to execute which can create a race condition where only some plugins have
		// been loaded when Prism.highlightAll() is executed, depending on how fast resources are loaded.
		// See https://github.com/PrismJS/prism/issues/2102
		var readyState = document.readyState;
		if (readyState === 'loading' || readyState === 'interactive' && script && script.defer) {
			document.addEventListener('DOMContentLoaded', highlightAutomaticallyCallback);
		} else {
			if (window.requestAnimationFrame) {
				window.requestAnimationFrame(highlightAutomaticallyCallback);
			} else {
				window.setTimeout(highlightAutomaticallyCallback, 16);
			}
		}
	}

	return _;

}(_self));

if ( true && module.exports) {
	module.exports = Prism;
}

// hack for components to work correctly in node.js
if (typeof __webpack_require__.g !== 'undefined') {
	__webpack_require__.g.Prism = Prism;
}

// some additional documentation/types

/**
 * The expansion of a simple `RegExp` literal to support additional properties.
 *
 * @typedef GrammarToken
 * @property {RegExp} pattern The regular expression of the token.
 * @property {boolean} [lookbehind=false] If `true`, then the first capturing group of `pattern` will (effectively)
 * behave as a lookbehind group meaning that the captured text will not be part of the matched text of the new token.
 * @property {boolean} [greedy=false] Whether the token is greedy.
 * @property {string|string[]} [alias] An optional alias or list of aliases.
 * @property {Grammar} [inside] The nested grammar of this token.
 *
 * The `inside` grammar will be used to tokenize the text value of each token of this kind.
 *
 * This can be used to make nested and even recursive language definitions.
 *
 * Note: This can cause infinite recursion. Be careful when you embed different languages or even the same language into
 * each another.
 * @global
 * @public
 */

/**
 * @typedef Grammar
 * @type {Object<string, RegExp | GrammarToken | Array<RegExp | GrammarToken>>}
 * @property {Grammar} [rest] An optional grammar object that will be appended to this grammar.
 * @global
 * @public
 */

/**
 * A function which will invoked after an element was successfully highlighted.
 *
 * @callback HighlightCallback
 * @param {Element} element The element successfully highlighted.
 * @returns {void}
 * @global
 * @public
 */

/**
 * @callback HookCallback
 * @param {Object<string, any>} env The environment variables of the hook.
 * @returns {void}
 * @global
 * @public
 */


/***/ }),

/***/ "./node_modules/prismjs/components/prism-javascript.js":
/*!*************************************************************!*\
  !*** ./node_modules/prismjs/components/prism-javascript.js ***!
  \*************************************************************/
/***/ (() => {

Prism.languages.javascript = Prism.languages.extend('clike', {
	'class-name': [
		Prism.languages.clike['class-name'],
		{
			pattern: /(^|[^$\w\xA0-\uFFFF])(?!\s)[_$A-Z\xA0-\uFFFF](?:(?!\s)[$\w\xA0-\uFFFF])*(?=\.(?:constructor|prototype))/,
			lookbehind: true
		}
	],
	'keyword': [
		{
			pattern: /((?:^|\})\s*)catch\b/,
			lookbehind: true
		},
		{
			pattern: /(^|[^.]|\.\.\.\s*)\b(?:as|assert(?=\s*\{)|async(?=\s*(?:function\b|\(|[$\w\xA0-\uFFFF]|$))|await|break|case|class|const|continue|debugger|default|delete|do|else|enum|export|extends|finally(?=\s*(?:\{|$))|for|from(?=\s*(?:['"]|$))|function|(?:get|set)(?=\s*(?:[#\[$\w\xA0-\uFFFF]|$))|if|implements|import|in|instanceof|interface|let|new|null|of|package|private|protected|public|return|static|super|switch|this|throw|try|typeof|undefined|var|void|while|with|yield)\b/,
			lookbehind: true
		},
	],
	// Allow for all non-ASCII characters (See http://stackoverflow.com/a/2008444)
	'function': /#?(?!\s)[_$a-zA-Z\xA0-\uFFFF](?:(?!\s)[$\w\xA0-\uFFFF])*(?=\s*(?:\.\s*(?:apply|bind|call)\s*)?\()/,
	'number': {
		pattern: RegExp(
			/(^|[^\w$])/.source +
			'(?:' +
			(
				// constant
				/NaN|Infinity/.source +
				'|' +
				// binary integer
				/0[bB][01]+(?:_[01]+)*n?/.source +
				'|' +
				// octal integer
				/0[oO][0-7]+(?:_[0-7]+)*n?/.source +
				'|' +
				// hexadecimal integer
				/0[xX][\dA-Fa-f]+(?:_[\dA-Fa-f]+)*n?/.source +
				'|' +
				// decimal bigint
				/\d+(?:_\d+)*n/.source +
				'|' +
				// decimal number (integer or float) but no bigint
				/(?:\d+(?:_\d+)*(?:\.(?:\d+(?:_\d+)*)?)?|\.\d+(?:_\d+)*)(?:[Ee][+-]?\d+(?:_\d+)*)?/.source
			) +
			')' +
			/(?![\w$])/.source
		),
		lookbehind: true
	},
	'operator': /--|\+\+|\*\*=?|=>|&&=?|\|\|=?|[!=]==|<<=?|>>>?=?|[-+*/%&|^!=<>]=?|\.{3}|\?\?=?|\?\.?|[~:]/
});

Prism.languages.javascript['class-name'][0].pattern = /(\b(?:class|extends|implements|instanceof|interface|new)\s+)[\w.\\]+/;

Prism.languages.insertBefore('javascript', 'keyword', {
	'regex': {
		pattern: RegExp(
			// lookbehind
			// eslint-disable-next-line regexp/no-dupe-characters-character-class
			/((?:^|[^$\w\xA0-\uFFFF."'\])\s]|\b(?:return|yield))\s*)/.source +
			// Regex pattern:
			// There are 2 regex patterns here. The RegExp set notation proposal added support for nested character
			// classes if the `v` flag is present. Unfortunately, nested CCs are both context-free and incompatible
			// with the only syntax, so we have to define 2 different regex patterns.
			/\//.source +
			'(?:' +
			/(?:\[(?:[^\]\\\r\n]|\\.)*\]|\\.|[^/\\\[\r\n])+\/[dgimyus]{0,7}/.source +
			'|' +
			// `v` flag syntax. This supports 3 levels of nested character classes.
			/(?:\[(?:[^[\]\\\r\n]|\\.|\[(?:[^[\]\\\r\n]|\\.|\[(?:[^[\]\\\r\n]|\\.)*\])*\])*\]|\\.|[^/\\\[\r\n])+\/[dgimyus]{0,7}v[dgimyus]{0,7}/.source +
			')' +
			// lookahead
			/(?=(?:\s|\/\*(?:[^*]|\*(?!\/))*\*\/)*(?:$|[\r\n,.;:})\]]|\/\/))/.source
		),
		lookbehind: true,
		greedy: true,
		inside: {
			'regex-source': {
				pattern: /^(\/)[\s\S]+(?=\/[a-z]*$)/,
				lookbehind: true,
				alias: 'language-regex',
				inside: Prism.languages.regex
			},
			'regex-delimiter': /^\/|\/$/,
			'regex-flags': /^[a-z]+$/,
		}
	},
	// This must be declared before keyword because we use "function" inside the look-forward
	'function-variable': {
		pattern: /#?(?!\s)[_$a-zA-Z\xA0-\uFFFF](?:(?!\s)[$\w\xA0-\uFFFF])*(?=\s*[=:]\s*(?:async\s*)?(?:\bfunction\b|(?:\((?:[^()]|\([^()]*\))*\)|(?!\s)[_$a-zA-Z\xA0-\uFFFF](?:(?!\s)[$\w\xA0-\uFFFF])*)\s*=>))/,
		alias: 'function'
	},
	'parameter': [
		{
			pattern: /(function(?:\s+(?!\s)[_$a-zA-Z\xA0-\uFFFF](?:(?!\s)[$\w\xA0-\uFFFF])*)?\s*\(\s*)(?!\s)(?:[^()\s]|\s+(?![\s)])|\([^()]*\))+(?=\s*\))/,
			lookbehind: true,
			inside: Prism.languages.javascript
		},
		{
			pattern: /(^|[^$\w\xA0-\uFFFF])(?!\s)[_$a-z\xA0-\uFFFF](?:(?!\s)[$\w\xA0-\uFFFF])*(?=\s*=>)/i,
			lookbehind: true,
			inside: Prism.languages.javascript
		},
		{
			pattern: /(\(\s*)(?!\s)(?:[^()\s]|\s+(?![\s)])|\([^()]*\))+(?=\s*\)\s*=>)/,
			lookbehind: true,
			inside: Prism.languages.javascript
		},
		{
			pattern: /((?:\b|\s|^)(?!(?:as|async|await|break|case|catch|class|const|continue|debugger|default|delete|do|else|enum|export|extends|finally|for|from|function|get|if|implements|import|in|instanceof|interface|let|new|null|of|package|private|protected|public|return|set|static|super|switch|this|throw|try|typeof|undefined|var|void|while|with|yield)(?![$\w\xA0-\uFFFF]))(?:(?!\s)[_$a-zA-Z\xA0-\uFFFF](?:(?!\s)[$\w\xA0-\uFFFF])*\s*)\(\s*|\]\s*\(\s*)(?!\s)(?:[^()\s]|\s+(?![\s)])|\([^()]*\))+(?=\s*\)\s*\{)/,
			lookbehind: true,
			inside: Prism.languages.javascript
		}
	],
	'constant': /\b[A-Z](?:[A-Z_]|\dx?)*\b/
});

Prism.languages.insertBefore('javascript', 'string', {
	'hashbang': {
		pattern: /^#!.*/,
		greedy: true,
		alias: 'comment'
	},
	'template-string': {
		pattern: /`(?:\\[\s\S]|\$\{(?:[^{}]|\{(?:[^{}]|\{[^}]*\})*\})+\}|(?!\$\{)[^\\`])*`/,
		greedy: true,
		inside: {
			'template-punctuation': {
				pattern: /^`|`$/,
				alias: 'string'
			},
			'interpolation': {
				pattern: /((?:^|[^\\])(?:\\{2})*)\$\{(?:[^{}]|\{(?:[^{}]|\{[^}]*\})*\})+\}/,
				lookbehind: true,
				inside: {
					'interpolation-punctuation': {
						pattern: /^\$\{|\}$/,
						alias: 'punctuation'
					},
					rest: Prism.languages.javascript
				}
			},
			'string': /[\s\S]+/
		}
	},
	'string-property': {
		pattern: /((?:^|[,{])[ \t]*)(["'])(?:\\(?:\r\n|[\s\S])|(?!\2)[^\\\r\n])*\2(?=\s*:)/m,
		lookbehind: true,
		greedy: true,
		alias: 'property'
	}
});

Prism.languages.insertBefore('javascript', 'operator', {
	'literal-property': {
		pattern: /((?:^|[,{])[ \t]*)(?!\s)[_$a-zA-Z\xA0-\uFFFF](?:(?!\s)[$\w\xA0-\uFFFF])*(?=\s*:)/m,
		lookbehind: true,
		alias: 'property'
	},
});

if (Prism.languages.markup) {
	Prism.languages.markup.tag.addInlined('script', 'javascript');

	// add attribute support for all DOM events.
	// https://developer.mozilla.org/en-US/docs/Web/Events#Standard_events
	Prism.languages.markup.tag.addAttribute(
		/on(?:abort|blur|change|click|composition(?:end|start|update)|dblclick|error|focus(?:in|out)?|key(?:down|up)|load|mouse(?:down|enter|leave|move|out|over|up)|reset|resize|scroll|select|slotchange|submit|unload|wheel)/.source,
		'javascript'
	);
}

Prism.languages.js = Prism.languages.javascript;


/***/ }),

/***/ "./resources/vue/views/pages/widget/Create.vue":
/*!*****************************************************!*\
  !*** ./resources/vue/views/pages/widget/Create.vue ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Create_vue_vue_type_template_id_0e34964a_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Create.vue?vue&type=template&id=0e34964a&scoped=true */ "./resources/vue/views/pages/widget/Create.vue?vue&type=template&id=0e34964a&scoped=true");
/* harmony import */ var _Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Create.vue?vue&type=script&lang=js */ "./resources/vue/views/pages/widget/Create.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Create_vue_vue_type_template_id_0e34964a_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render,
  _Create_vue_vue_type_template_id_0e34964a_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "0e34964a",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/vue/views/pages/widget/Create.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/vue/views/pages/widget/Create.vue?vue&type=script&lang=js":
/*!*****************************************************************************!*\
  !*** ./resources/vue/views/pages/widget/Create.vue?vue&type=script&lang=js ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Create.vue?vue&type=script&lang=js */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/widget/Create.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/vue/views/pages/widget/Create.vue?vue&type=template&id=0e34964a&scoped=true":
/*!***********************************************************************************************!*\
  !*** ./resources/vue/views/pages/widget/Create.vue?vue&type=template&id=0e34964a&scoped=true ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_template_id_0e34964a_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_template_id_0e34964a_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_template_id_0e34964a_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Create.vue?vue&type=template&id=0e34964a&scoped=true */ "./node_modules/laravel-mix/node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/vue/views/pages/widget/Create.vue?vue&type=template&id=0e34964a&scoped=true");


/***/ }),

/***/ "./node_modules/vue-prism-editor/dist/prismeditor.esm.js":
/*!***************************************************************!*\
  !*** ./node_modules/vue-prism-editor/dist/prismeditor.esm.js ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   PrismEditor: () => (/* binding */ PrismEditor)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");


function _extends() {
  _extends = Object.assign || function (target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];

      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }

    return target;
  };

  return _extends.apply(this, arguments);
}

var KEYCODE_ENTER = 13;
var KEYCODE_TAB = 9;
var KEYCODE_BACKSPACE = 8;
var KEYCODE_Y = 89;
var KEYCODE_Z = 90;
var KEYCODE_M = 77;
var KEYCODE_PARENS = 57;
var KEYCODE_BRACKETS = 219;
var KEYCODE_QUOTE = 222;
var KEYCODE_BACK_QUOTE = 192;
var KEYCODE_ESCAPE = 27;
var HISTORY_LIMIT = 100;
var HISTORY_TIME_GAP = 3000;
var isWindows = typeof window !== 'undefined' && navigator && /*#__PURE__*/ /Win/i.test(navigator.platform);
var isMacLike = typeof window !== 'undefined' && navigator && /*#__PURE__*/ /(Mac|iPhone|iPod|iPad)/i.test(navigator.platform);
var PrismEditor = /*#__PURE__*/vue__WEBPACK_IMPORTED_MODULE_0__["default"].extend({
  props: {
    lineNumbers: {
      type: Boolean,
      "default": false
    },
    autoStyleLineNumbers: {
      type: Boolean,
      "default": true
    },
    readonly: {
      type: Boolean,
      "default": false
    },
    value: {
      type: String,
      "default": ''
    },
    highlight: {
      type: Function,
      required: true
    },
    tabSize: {
      type: Number,
      "default": 2
    },
    insertSpaces: {
      type: Boolean,
      "default": true
    },
    ignoreTabKey: {
      type: Boolean,
      "default": false
    },
    placeholder: {
      type: String,
      "default": ''
    }
  },
  data: function data() {
    return {
      capture: true,
      history: {
        stack: [],
        offset: -1
      },
      lineNumbersHeight: '20px',
      codeData: ''
    };
  },
  watch: {
    value: {
      immediate: true,
      handler: function handler(newVal) {
        if (!newVal) {
          this.codeData = '';
        } else {
          this.codeData = newVal;
        }
      }
    },
    content: {
      immediate: true,
      handler: function handler() {
        var _this = this;

        if (this.lineNumbers) {
          this.$nextTick(function () {
            _this.setLineNumbersHeight();
          });
        }
      }
    },
    lineNumbers: function lineNumbers() {
      var _this2 = this;

      this.$nextTick(function () {
        _this2.styleLineNumbers();

        _this2.setLineNumbersHeight();
      });
    }
  },
  computed: {
    isEmpty: function isEmpty() {
      return this.codeData.length === 0;
    },
    content: function content() {
      var result = this.highlight(this.codeData) + '<br />'; // todo: VNode support?

      return result;
    },
    lineNumbersCount: function lineNumbersCount() {
      var totalLines = this.codeData.split(/\r\n|\n/).length;
      return totalLines;
    }
  },
  mounted: function mounted() {
    this._recordCurrentState();

    this.styleLineNumbers();
  },
  methods: {
    setLineNumbersHeight: function setLineNumbersHeight() {
      this.lineNumbersHeight = getComputedStyle(this.$refs.pre).height;
    },
    styleLineNumbers: function styleLineNumbers() {
      if (!this.lineNumbers || !this.autoStyleLineNumbers) return;
      var $editor = this.$refs.pre;
      var $lineNumbers = this.$el.querySelector('.prism-editor__line-numbers');
      var editorStyles = window.getComputedStyle($editor);
      this.$nextTick(function () {
        var btlr = 'border-top-left-radius';
        var bblr = 'border-bottom-left-radius';
        if (!$lineNumbers) return;
        $lineNumbers.style[btlr] = editorStyles[btlr];
        $lineNumbers.style[bblr] = editorStyles[bblr];
        $editor.style[btlr] = '0';
        $editor.style[bblr] = '0';
        var stylesList = ['background-color', 'margin-top', 'padding-top', 'font-family', 'font-size', 'line-height'];
        stylesList.forEach(function (style) {
          $lineNumbers.style[style] = editorStyles[style];
        });
        $lineNumbers.style['margin-bottom'] = '-' + editorStyles['padding-top'];
      });
    },
    _recordCurrentState: function _recordCurrentState() {
      var input = this.$refs.textarea;
      if (!input) return; // Save current state of the input

      var value = input.value,
          selectionStart = input.selectionStart,
          selectionEnd = input.selectionEnd;

      this._recordChange({
        value: value,
        selectionStart: selectionStart,
        selectionEnd: selectionEnd
      });
    },
    _getLines: function _getLines(text, position) {
      return text.substring(0, position).split('\n');
    },
    _applyEdits: function _applyEdits(record) {
      // Save last selection state
      var input = this.$refs.textarea;
      var last = this.history.stack[this.history.offset];

      if (last && input) {
        this.history.stack[this.history.offset] = _extends({}, last, {
          selectionStart: input.selectionStart,
          selectionEnd: input.selectionEnd
        });
      } // Save the changes


      this._recordChange(record);

      this._updateInput(record);
    },
    _recordChange: function _recordChange(record, overwrite) {
      if (overwrite === void 0) {
        overwrite = false;
      }

      var _this$history = this.history,
          stack = _this$history.stack,
          offset = _this$history.offset;

      if (stack.length && offset > -1) {
        // When something updates, drop the redo operations
        this.history.stack = stack.slice(0, offset + 1); // Limit the number of operations to 100

        var count = this.history.stack.length;

        if (count > HISTORY_LIMIT) {
          var extras = count - HISTORY_LIMIT;
          this.history.stack = stack.slice(extras, count);
          this.history.offset = Math.max(this.history.offset - extras, 0);
        }
      }

      var timestamp = Date.now();

      if (overwrite) {
        var last = this.history.stack[this.history.offset];

        if (last && timestamp - last.timestamp < HISTORY_TIME_GAP) {
          var _this$_getLines$pop, _this$_getLines$pop2;

          // A previous entry exists and was in short interval
          // Match the last word in the line
          var re = /[^a-z0-9]([a-z0-9]+)$/i; // Get the previous line

          var previous = (_this$_getLines$pop = this._getLines(last.value, last.selectionStart).pop()) === null || _this$_getLines$pop === void 0 ? void 0 : _this$_getLines$pop.match(re); // Get the current line

          var current = (_this$_getLines$pop2 = this._getLines(record.value, record.selectionStart).pop()) === null || _this$_getLines$pop2 === void 0 ? void 0 : _this$_getLines$pop2.match(re);

          if (previous && current && current[1].startsWith(previous[1])) {
            // The last word of the previous line and current line match
            // Overwrite previous entry so that undo will remove whole word
            this.history.stack[this.history.offset] = _extends({}, record, {
              timestamp: timestamp
            });
            return;
          }
        }
      } // Add the new operation to the stack


      this.history.stack.push(_extends({}, record, {
        timestamp: timestamp
      }));
      this.history.offset++;
    },
    _updateInput: function _updateInput(record) {
      var input = this.$refs.textarea;
      if (!input) return; // Update values and selection state

      input.value = record.value;
      input.selectionStart = record.selectionStart;
      input.selectionEnd = record.selectionEnd;
      this.$emit('input', record.value); // this.props.onValueChange(record.value);
    },
    handleChange: function handleChange(e) {
      var _e$target = e.target,
          value = _e$target.value,
          selectionStart = _e$target.selectionStart,
          selectionEnd = _e$target.selectionEnd;

      this._recordChange({
        value: value,
        selectionStart: selectionStart,
        selectionEnd: selectionEnd
      }, true);

      this.$emit('input', value); // this.props.onValueChange(value);
    },
    _undoEdit: function _undoEdit() {
      var _this$history2 = this.history,
          stack = _this$history2.stack,
          offset = _this$history2.offset; // Get the previous edit

      var record = stack[offset - 1];

      if (record) {
        // Apply the changes and update the offset
        this._updateInput(record);

        this.history.offset = Math.max(offset - 1, 0);
      }
    },
    _redoEdit: function _redoEdit() {
      var _this$history3 = this.history,
          stack = _this$history3.stack,
          offset = _this$history3.offset; // Get the next edit

      var record = stack[offset + 1];

      if (record) {
        // Apply the changes and update the offset
        this._updateInput(record);

        this.history.offset = Math.min(offset + 1, stack.length - 1);
      }
    },
    handleKeyDown: function handleKeyDown(e) {
      // console.log(navigator.platform);
      var tabSize = this.tabSize,
          insertSpaces = this.insertSpaces,
          ignoreTabKey = this.ignoreTabKey;

      if (this.$listeners.keydown) {
        // onKeyDown(e);
        this.$emit('keydown', e);

        if (e.defaultPrevented) {
          return;
        }
      }

      if (e.keyCode === KEYCODE_ESCAPE) {
        e.target.blur();
        this.$emit('blur', e);
      }

      var _e$target2 = e.target,
          value = _e$target2.value,
          selectionStart = _e$target2.selectionStart,
          selectionEnd = _e$target2.selectionEnd;
      var tabCharacter = (insertSpaces ? ' ' : '\t').repeat(tabSize);

      if (e.keyCode === KEYCODE_TAB && !ignoreTabKey && this.capture) {
        // Prevent focus change
        e.preventDefault();

        if (e.shiftKey) {
          // Unindent selected lines
          var linesBeforeCaret = this._getLines(value, selectionStart);

          var startLine = linesBeforeCaret.length - 1;
          var endLine = this._getLines(value, selectionEnd).length - 1;
          var nextValue = value.split('\n').map(function (line, i) {
            if (i >= startLine && i <= endLine && line.startsWith(tabCharacter)) {
              return line.substring(tabCharacter.length);
            }

            return line;
          }).join('\n');

          if (value !== nextValue) {
            var startLineText = linesBeforeCaret[startLine];

            this._applyEdits({
              value: nextValue,
              // Move the start cursor if first line in selection was modified
              // It was modified only if it started with a tab
              selectionStart: startLineText.startsWith(tabCharacter) ? selectionStart - tabCharacter.length : selectionStart,
              // Move the end cursor by total number of characters removed
              selectionEnd: selectionEnd - (value.length - nextValue.length)
            });
          }
        } else if (selectionStart !== selectionEnd) {
          // Indent selected lines
          var _linesBeforeCaret = this._getLines(value, selectionStart);

          var _startLine = _linesBeforeCaret.length - 1;

          var _endLine = this._getLines(value, selectionEnd).length - 1;

          var _startLineText = _linesBeforeCaret[_startLine];

          this._applyEdits({
            value: value.split('\n').map(function (line, i) {
              if (i >= _startLine && i <= _endLine) {
                return tabCharacter + line;
              }

              return line;
            }).join('\n'),
            // Move the start cursor by number of characters added in first line of selection
            // Don't move it if it there was no text before cursor
            selectionStart: /\S/.test(_startLineText) ? selectionStart + tabCharacter.length : selectionStart,
            // Move the end cursor by total number of characters added
            selectionEnd: selectionEnd + tabCharacter.length * (_endLine - _startLine + 1)
          });
        } else {
          var updatedSelection = selectionStart + tabCharacter.length;

          this._applyEdits({
            // Insert tab character at caret
            value: value.substring(0, selectionStart) + tabCharacter + value.substring(selectionEnd),
            // Update caret position
            selectionStart: updatedSelection,
            selectionEnd: updatedSelection
          });
        }
      } else if (e.keyCode === KEYCODE_BACKSPACE) {
        var hasSelection = selectionStart !== selectionEnd;
        var textBeforeCaret = value.substring(0, selectionStart);

        if (textBeforeCaret.endsWith(tabCharacter) && !hasSelection) {
          // Prevent default delete behaviour
          e.preventDefault();

          var _updatedSelection = selectionStart - tabCharacter.length;

          this._applyEdits({
            // Remove tab character at caret
            value: value.substring(0, selectionStart - tabCharacter.length) + value.substring(selectionEnd),
            // Update caret position
            selectionStart: _updatedSelection,
            selectionEnd: _updatedSelection
          });
        }
      } else if (e.keyCode === KEYCODE_ENTER) {
        // Ignore selections
        if (selectionStart === selectionEnd) {
          // Get the current line
          var line = this._getLines(value, selectionStart).pop();

          var matches = line === null || line === void 0 ? void 0 : line.match(/^\s+/);

          if (matches && matches[0]) {
            e.preventDefault(); // Preserve indentation on inserting a new line

            var indent = '\n' + matches[0];

            var _updatedSelection2 = selectionStart + indent.length;

            this._applyEdits({
              // Insert indentation character at caret
              value: value.substring(0, selectionStart) + indent + value.substring(selectionEnd),
              // Update caret position
              selectionStart: _updatedSelection2,
              selectionEnd: _updatedSelection2
            });
          }
        }
      } else if (e.keyCode === KEYCODE_PARENS || e.keyCode === KEYCODE_BRACKETS || e.keyCode === KEYCODE_QUOTE || e.keyCode === KEYCODE_BACK_QUOTE) {
        var chars;

        if (e.keyCode === KEYCODE_PARENS && e.shiftKey) {
          chars = ['(', ')'];
        } else if (e.keyCode === KEYCODE_BRACKETS) {
          if (e.shiftKey) {
            chars = ['{', '}'];
          } else {
            chars = ['[', ']'];
          }
        } else if (e.keyCode === KEYCODE_QUOTE) {
          if (e.shiftKey) {
            chars = ['"', '"'];
          } else {
            chars = ["'", "'"];
          }
        } else if (e.keyCode === KEYCODE_BACK_QUOTE && !e.shiftKey) {
          chars = ['`', '`'];
        } // console.log(isMacLike, "navigator" in global && /(Mac|iPhone|iPod|iPad)/i.test(navigator.platform));
        // If text is selected, wrap them in the characters


        if (selectionStart !== selectionEnd && chars) {
          e.preventDefault();

          this._applyEdits({
            value: value.substring(0, selectionStart) + chars[0] + value.substring(selectionStart, selectionEnd) + chars[1] + value.substring(selectionEnd),
            // Update caret position
            selectionStart: selectionStart,
            selectionEnd: selectionEnd + 2
          });
        }
      } else if ((isMacLike ? // Trigger undo with ⌘+Z on Mac
      e.metaKey && e.keyCode === KEYCODE_Z : // Trigger undo with Ctrl+Z on other platforms
      e.ctrlKey && e.keyCode === KEYCODE_Z) && !e.shiftKey && !e.altKey) {
        e.preventDefault();

        this._undoEdit();
      } else if ((isMacLike ? // Trigger redo with ⌘+Shift+Z on Mac
      e.metaKey && e.keyCode === KEYCODE_Z && e.shiftKey : isWindows ? // Trigger redo with Ctrl+Y on Windows
      e.ctrlKey && e.keyCode === KEYCODE_Y : // Trigger redo with Ctrl+Shift+Z on other platforms
      e.ctrlKey && e.keyCode === KEYCODE_Z && e.shiftKey) && !e.altKey) {
        e.preventDefault();

        this._redoEdit();
      } else if (e.keyCode === KEYCODE_M && e.ctrlKey && (isMacLike ? e.shiftKey : true)) {
        e.preventDefault(); // Toggle capturing tab key so users can focus away

        this.capture = !this.capture;
      }
    }
  },
  render: function render(h) {
    var _this3 = this;

    var lineNumberWidthCalculator = h('div', {
      attrs: {
        "class": 'prism-editor__line-width-calc',
        style: 'height: 0px; visibility: hidden; pointer-events: none;'
      }
    }, '999');
    var lineNumbers = h('div', {
      staticClass: 'prism-editor__line-numbers',
      style: {
        'min-height': this.lineNumbersHeight
      },
      attrs: {
        'aria-hidden': 'true'
      }
    }, [lineNumberWidthCalculator, Array.from(Array(this.lineNumbersCount).keys()).map(function (_, index) {
      return h('div', {
        attrs: {
          "class": 'prism-editor__line-number token comment'
        }
      }, "" + ++index);
    })]);
    var textarea = h('textarea', {
      ref: 'textarea',
      on: {
        input: this.handleChange,
        keydown: this.handleKeyDown,
        click: function click($event) {
          _this3.$emit('click', $event);
        },
        keyup: function keyup($event) {
          _this3.$emit('keyup', $event);
        },
        focus: function focus($event) {
          _this3.$emit('focus', $event);
        },
        blur: function blur($event) {
          _this3.$emit('blur', $event);
        }
      },
      staticClass: 'prism-editor__textarea',
      "class": {
        'prism-editor__textarea--empty': this.isEmpty
      },
      attrs: {
        spellCheck: 'false',
        autocapitalize: 'off',
        autocomplete: 'off',
        autocorrect: 'off',
        'data-gramm': 'false',
        placeholder: this.placeholder,
        'data-testid': 'textarea',
        readonly: this.readonly
      },
      domProps: {
        value: this.codeData
      }
    });
    var preview = h('pre', {
      ref: 'pre',
      staticClass: 'prism-editor__editor',
      attrs: {
        'data-testid': 'preview'
      },
      domProps: {
        innerHTML: this.content
      }
    });
    var editorContainer = h('div', {
      staticClass: 'prism-editor__container'
    }, [textarea, preview]);
    return h('div', {
      staticClass: 'prism-editor-wrapper'
    }, [this.lineNumbers && lineNumbers, editorContainer]);
  }
});


//# sourceMappingURL=prismeditor.esm.js.map


/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/arrayLikeToArray.js":
/*!*****************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/arrayLikeToArray.js ***!
  \*****************************************************************/
/***/ ((module) => {

function _arrayLikeToArray(r, a) {
  (null == a || a > r.length) && (a = r.length);
  for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e];
  return n;
}
module.exports = _arrayLikeToArray, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/arrayWithHoles.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/arrayWithHoles.js ***!
  \***************************************************************/
/***/ ((module) => {

function _arrayWithHoles(r) {
  if (Array.isArray(r)) return r;
}
module.exports = _arrayWithHoles, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/arrayWithoutHoles.js":
/*!******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/arrayWithoutHoles.js ***!
  \******************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var arrayLikeToArray = __webpack_require__(/*! ./arrayLikeToArray.js */ "./node_modules/@babel/runtime/helpers/arrayLikeToArray.js");
function _arrayWithoutHoles(r) {
  if (Array.isArray(r)) return arrayLikeToArray(r);
}
module.exports = _arrayWithoutHoles, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/defineProperty.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/defineProperty.js ***!
  \***************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var toPropertyKey = __webpack_require__(/*! ./toPropertyKey.js */ "./node_modules/@babel/runtime/helpers/toPropertyKey.js");
function _defineProperty(e, r, t) {
  return (r = toPropertyKey(r)) in e ? Object.defineProperty(e, r, {
    value: t,
    enumerable: !0,
    configurable: !0,
    writable: !0
  }) : e[r] = t, e;
}
module.exports = _defineProperty, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/iterableToArray.js":
/*!****************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/iterableToArray.js ***!
  \****************************************************************/
/***/ ((module) => {

function _iterableToArray(r) {
  if ("undefined" != typeof Symbol && null != r[Symbol.iterator] || null != r["@@iterator"]) return Array.from(r);
}
module.exports = _iterableToArray, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/iterableToArrayLimit.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/iterableToArrayLimit.js ***!
  \*********************************************************************/
/***/ ((module) => {

function _iterableToArrayLimit(r, l) {
  var t = null == r ? null : "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"];
  if (null != t) {
    var e,
      n,
      i,
      u,
      a = [],
      f = !0,
      o = !1;
    try {
      if (i = (t = t.call(r)).next, 0 === l) {
        if (Object(t) !== t) return;
        f = !1;
      } else for (; !(f = (e = i.call(t)).done) && (a.push(e.value), a.length !== l); f = !0);
    } catch (r) {
      o = !0, n = r;
    } finally {
      try {
        if (!f && null != t["return"] && (u = t["return"](), Object(u) !== u)) return;
      } finally {
        if (o) throw n;
      }
    }
    return a;
  }
}
module.exports = _iterableToArrayLimit, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/nonIterableRest.js":
/*!****************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/nonIterableRest.js ***!
  \****************************************************************/
/***/ ((module) => {

function _nonIterableRest() {
  throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}
module.exports = _nonIterableRest, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/nonIterableSpread.js":
/*!******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/nonIterableSpread.js ***!
  \******************************************************************/
/***/ ((module) => {

function _nonIterableSpread() {
  throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}
module.exports = _nonIterableSpread, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/slicedToArray.js":
/*!**************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/slicedToArray.js ***!
  \**************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var arrayWithHoles = __webpack_require__(/*! ./arrayWithHoles.js */ "./node_modules/@babel/runtime/helpers/arrayWithHoles.js");
var iterableToArrayLimit = __webpack_require__(/*! ./iterableToArrayLimit.js */ "./node_modules/@babel/runtime/helpers/iterableToArrayLimit.js");
var unsupportedIterableToArray = __webpack_require__(/*! ./unsupportedIterableToArray.js */ "./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js");
var nonIterableRest = __webpack_require__(/*! ./nonIterableRest.js */ "./node_modules/@babel/runtime/helpers/nonIterableRest.js");
function _slicedToArray(r, e) {
  return arrayWithHoles(r) || iterableToArrayLimit(r, e) || unsupportedIterableToArray(r, e) || nonIterableRest();
}
module.exports = _slicedToArray, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/toConsumableArray.js":
/*!******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/toConsumableArray.js ***!
  \******************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var arrayWithoutHoles = __webpack_require__(/*! ./arrayWithoutHoles.js */ "./node_modules/@babel/runtime/helpers/arrayWithoutHoles.js");
var iterableToArray = __webpack_require__(/*! ./iterableToArray.js */ "./node_modules/@babel/runtime/helpers/iterableToArray.js");
var unsupportedIterableToArray = __webpack_require__(/*! ./unsupportedIterableToArray.js */ "./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js");
var nonIterableSpread = __webpack_require__(/*! ./nonIterableSpread.js */ "./node_modules/@babel/runtime/helpers/nonIterableSpread.js");
function _toConsumableArray(r) {
  return arrayWithoutHoles(r) || iterableToArray(r) || unsupportedIterableToArray(r) || nonIterableSpread();
}
module.exports = _toConsumableArray, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/toPrimitive.js":
/*!************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/toPrimitive.js ***!
  \************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var _typeof = (__webpack_require__(/*! ./typeof.js */ "./node_modules/@babel/runtime/helpers/typeof.js")["default"]);
function toPrimitive(t, r) {
  if ("object" != _typeof(t) || !t) return t;
  var e = t[Symbol.toPrimitive];
  if (void 0 !== e) {
    var i = e.call(t, r || "default");
    if ("object" != _typeof(i)) return i;
    throw new TypeError("@@toPrimitive must return a primitive value.");
  }
  return ("string" === r ? String : Number)(t);
}
module.exports = toPrimitive, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/toPropertyKey.js":
/*!**************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/toPropertyKey.js ***!
  \**************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var _typeof = (__webpack_require__(/*! ./typeof.js */ "./node_modules/@babel/runtime/helpers/typeof.js")["default"]);
var toPrimitive = __webpack_require__(/*! ./toPrimitive.js */ "./node_modules/@babel/runtime/helpers/toPrimitive.js");
function toPropertyKey(t) {
  var i = toPrimitive(t, "string");
  return "symbol" == _typeof(i) ? i : i + "";
}
module.exports = toPropertyKey, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/typeof.js":
/*!*******************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/typeof.js ***!
  \*******************************************************/
/***/ ((module) => {

function _typeof(o) {
  "@babel/helpers - typeof";

  return module.exports = _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) {
    return typeof o;
  } : function (o) {
    return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o;
  }, module.exports.__esModule = true, module.exports["default"] = module.exports, _typeof(o);
}
module.exports = _typeof, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js":
/*!***************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js ***!
  \***************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var arrayLikeToArray = __webpack_require__(/*! ./arrayLikeToArray.js */ "./node_modules/@babel/runtime/helpers/arrayLikeToArray.js");
function _unsupportedIterableToArray(r, a) {
  if (r) {
    if ("string" == typeof r) return arrayLikeToArray(r, a);
    var t = {}.toString.call(r).slice(8, -1);
    return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? arrayLikeToArray(r, a) : void 0;
  }
}
module.exports = _unsupportedIterableToArray, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/watch-size/index.es.mjs":
/*!**********************************************!*\
  !*** ./node_modules/watch-size/index.es.mjs ***!
  \**********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
var index = (function (element, listener) {
	var expand = document.createElement('_');
	var shrink = expand.appendChild(document.createElement('_'));
	var expandChild = expand.appendChild(document.createElement('_'));
	var shrinkChild = shrink.appendChild(document.createElement('_'));

	var lastWidth = void 0,
	    lastHeight = void 0;

	shrink.style.cssText = expand.style.cssText = 'height:100%;left:0;opacity:0;overflow:hidden;pointer-events:none;position:absolute;top:0;transition:0s;width:100%;z-index:-1';
	shrinkChild.style.cssText = expandChild.style.cssText = 'display:block;height:100%;transition:0s;width:100%';
	shrinkChild.style.width = shrinkChild.style.height = '200%';

	element.appendChild(expand);

	test();

	return stop;

	function test() {
		unbind();

		var width = element.offsetWidth;
		var height = element.offsetHeight;

		if (width !== lastWidth || height !== lastHeight) {
			lastWidth = width;
			lastHeight = height;

			expandChild.style.width = width * 2 + 'px';
			expandChild.style.height = height * 2 + 'px';

			expand.scrollLeft = expand.scrollWidth;
			expand.scrollTop = expand.scrollHeight;
			shrink.scrollLeft = shrink.scrollWidth;
			shrink.scrollTop = shrink.scrollHeight;

			listener({ width: width, height: height });
		}

		shrink.addEventListener('scroll', test);
		expand.addEventListener('scroll', test);
	}

	function unbind() {
		shrink.removeEventListener('scroll', test);
		expand.removeEventListener('scroll', test);
	}

	function stop() {
		unbind();

		element.removeChild(expand);
	}
});

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (index);


/***/ })

}]);