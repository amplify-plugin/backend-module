/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/ckeditor/build-config.js":
/*!***********************************************!*\
  !*** ./resources/js/ckeditor/build-config.js ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   applyCkeditorDefaults: () => (/* binding */ applyCkeditorDefaults),
/* harmony export */   buildCkeditorConfig: () => (/* binding */ buildCkeditorConfig),
/* harmony export */   getCkeditorEditorUrl: () => (/* binding */ getCkeditorEditorUrl),
/* harmony export */   getCkeditorProductDescriptionCssUrl: () => (/* binding */ getCkeditorProductDescriptionCssUrl),
/* harmony export */   getCkeditorTemplatesUrl: () => (/* binding */ getCkeditorTemplatesUrl),
/* harmony export */   mergeCkeditorConfigDefaults: () => (/* binding */ mergeCkeditorConfigDefaults)
/* harmony export */ });
/* harmony import */ var _toolbar__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./toolbar */ "./resources/js/ckeditor/toolbar.js");
function _toConsumableArray(r) { return _arrayWithoutHoles(r) || _iterableToArray(r) || _unsupportedIterableToArray(r) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _iterableToArray(r) { if ("undefined" != typeof Symbol && null != r[Symbol.iterator] || null != r["@@iterator"]) return Array.from(r); }
function _arrayWithoutHoles(r) { if (Array.isArray(r)) return _arrayLikeToArray(r); }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }

var PRESERVE_KEYS = ['height', 'allowedContent', 'disallowedContent', 'extraAllowedContent', 'protectedSource', 'entities', 'basicEntities', 'entities_greek', 'entities_latin', 'autoParagraph', 'fillEmptyBlocks', 'iframe_attributes', 'removePlugins'];
function mergeExtraPlugins(extraPlugins, fallback) {
  var plugins = new Set((extraPlugins ? extraPlugins.split(',') : []).map(function (plugin) {
    return plugin.trim();
  }).filter(Boolean));
  (fallback ? fallback.split(',') : []).map(function (plugin) {
    return plugin.trim();
  }).filter(Boolean).forEach(function (plugin) {
    return plugins.add(plugin);
  });
  _toolbar__WEBPACK_IMPORTED_MODULE_0__.CKEDITOR_EXTRA_PLUGINS.split(',').forEach(function (plugin) {
    return plugins.add(plugin);
  });
  return Array.from(plugins).join(',');
}
function getCkeditorEditorUrl() {
  return window.__CKEDITOR_LOCAL_URL || '/packages/ckeditor/ckeditor.js';
}
function getCkeditorTemplatesUrl() {
  return window.__CKEDITOR_TEMPLATES_URL || '/vendor/backend/ckeditor/content-templates.js';
}
function getCkeditorProductDescriptionCssUrl() {
  return window.__CKEDITOR_PRODUCT_DESCRIPTION_CSS || '/vendor/backend/ckeditor/product-description.css';
}
function resolveContentsCss(userContentsCss) {
  var defaults = [];
  if (typeof CKEDITOR !== 'undefined' && typeof CKEDITOR.getUrl === 'function') {
    defaults.push(CKEDITOR.getUrl('contents.css'));
  } else {
    defaults.push('/packages/ckeditor/contents.css');
  }
  defaults.push(getCkeditorProductDescriptionCssUrl());
  if (userContentsCss == null) {
    return defaults;
  }
  var userList = Array.isArray(userContentsCss) ? userContentsCss : [userContentsCss];
  var merged = new Set([].concat(_toConsumableArray(userList.filter(Boolean)), defaults));
  return Array.from(merged);
}

/**
 * Build a plain CKEditor config object (no Vue reactivity).
 */
function buildCkeditorConfig() {
  var userConfig = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
  var config = JSON.parse(JSON.stringify(_toolbar__WEBPACK_IMPORTED_MODULE_0__.CKEDITOR_SHARED_CONFIG));
  config.extraPlugins = mergeExtraPlugins(userConfig.extraPlugins, _toolbar__WEBPACK_IMPORTED_MODULE_0__.CKEDITOR_SHARED_CONFIG.extraPlugins);
  config.templates_files = [getCkeditorTemplatesUrl()];
  config.contentsCss = resolveContentsCss(userConfig.contentsCss);
  config.customConfig = '';
  PRESERVE_KEYS.forEach(function (key) {
    if (userConfig[key] != null) {
      config[key] = userConfig[key];
    }
  });
  if (userConfig.readOnly != null) {
    config.readOnly = userConfig.readOnly;
  }
  if (userConfig.on) {
    config.on = userConfig.on;
  }
  delete config.toolbarGroups;
  return config;
}
function mergeCkeditorConfigDefaults(existingDefault) {
  return function () {
    var base = typeof existingDefault === 'function' ? existingDefault.call(this) : existingDefault || {};
    return buildCkeditorConfig(base);
  };
}
function applyCkeditorDefaults(component) {
  if (!component || !component.props) {
    return;
  }
  if (component.props.editorUrl) {
    component.props.editorUrl["default"] = getCkeditorEditorUrl();
  }
  if (component.props.config) {
    component.props.config["default"] = mergeCkeditorConfigDefaults(component.props.config["default"]);
  } else {
    component.props.config = {
      type: Object,
      "default": mergeCkeditorConfigDefaults(null)
    };
  }
}

/***/ }),

/***/ "./resources/js/ckeditor/toolbar.js":
/*!******************************************!*\
  !*** ./resources/js/ckeditor/toolbar.js ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   CKEDITOR_EXTRA_PLUGINS: () => (/* binding */ CKEDITOR_EXTRA_PLUGINS),
/* harmony export */   CKEDITOR_SHARED_CONFIG: () => (/* binding */ CKEDITOR_SHARED_CONFIG)
/* harmony export */ });
/**
 * Shared CKEditor toolbar + plugin allow-list (admin default).
 */
var CKEDITOR_EXTRA_PLUGINS = 'templates,div,iframe,showblocks,smiley,font';
var CKEDITOR_SHARED_CONFIG = {
  extraPlugins: CKEDITOR_EXTRA_PLUGINS,
  format_tags: 'p;h1;h2;h3;pre',
  removeDialogTabs: 'image:advanced;link:advanced',
  toolbar: [{
    name: 'document',
    items: ['Source', 'Templates']
  }, {
    name: 'clipboard',
    items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord']
  }, {
    name: 'undo',
    items: ['Undo', 'Redo']
  }, {
    name: 'editing',
    items: ['Find', 'Replace']
  }, '/', {
    name: 'basicstyles',
    items: ['Bold', 'Italic', 'Strike', 'RemoveFormat']
  }, {
    name: 'paragraph',
    items: ['NumberedList', 'BulletedList', 'Outdent', 'Indent']
  }, {
    name: 'blocks',
    items: ['Blockquote', 'CreateDiv']
  }, {
    name: 'align',
    items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
  }, {
    name: 'links',
    items: ['Link', 'Unlink', 'Anchor']
  }, {
    name: 'insert',
    items: ['Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'Iframe', 'ShowBlocks']
  }, '/', {
    name: 'styles',
    items: ['Styles', 'Format', 'Font', 'FontSize']
  }, {
    name: 'colors',
    items: ['TextColor', 'BGColor']
  }, {
    name: 'tools',
    items: ['Maximize']
  }]
};

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!***************************************************!*\
  !*** ./resources/js/ckeditor/ckeditor-browser.js ***!
  \***************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _toolbar__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./toolbar */ "./resources/js/ckeditor/toolbar.js");
/* harmony import */ var _build_config__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./build-config */ "./resources/js/ckeditor/build-config.js");
/**
 * Browser bundle: exposes CKEditor config helpers for blade-loaded scripts.
 */


window.__CKEDITOR_SHARED_CONFIG = _toolbar__WEBPACK_IMPORTED_MODULE_0__.CKEDITOR_SHARED_CONFIG;
window.buildCkeditorConfig = _build_config__WEBPACK_IMPORTED_MODULE_1__.buildCkeditorConfig;
})();

/******/ })()
;