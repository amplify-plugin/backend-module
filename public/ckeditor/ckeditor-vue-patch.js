/**
 * Patches ckeditor4-vue before the admin bundle registers the component.
 * Requires vendor/backend/ckeditor/ckeditor-config.js (buildCkeditorConfig).
 */
(function () {
    var localEditorUrl = window.__CKEDITOR_LOCAL_URL || '/packages/ckeditor/ckeditor.js';

    function patchCkeditorDefinition(definition) {
        if (!definition || !definition.props) {
            return;
        }

        if (definition.props.editorUrl) {
            definition.props.editorUrl.default = localEditorUrl;
        }

        if (definition.methods && definition.methods.prepareConfig) {
            var originalPrepareConfig = definition.methods.prepareConfig;

            definition.methods.prepareConfig = function () {
                var config = originalPrepareConfig.call(this);

                return window.buildCkeditorConfig
                    ? window.buildCkeditorConfig(config)
                    : config;
            };
        }
    }

    function patchVueComponent(Vue) {
        if (!Vue || !Vue.component || Vue.component._ckeditorPatched) {
            return false;
        }

        var registerComponent = Vue.component;

        Vue.component = function (id, definition) {
            if (id === 'ckeditor') {
                patchCkeditorDefinition(definition);
            }

            return registerComponent.apply(this, arguments);
        };

        Vue.component._ckeditorPatched = true;

        return true;
    }

    function patchExistingCkeditorComponent(Vue) {
        if (!Vue || !Vue.options || !Vue.options.components || !Vue.options.components.ckeditor) {
            return false;
        }

        patchCkeditorDefinition(Vue.options.components.ckeditor.options);

        return true;
    }

    function tryPatch() {
        if (window.Vue) {
            patchVueComponent(window.Vue);
            patchExistingCkeditorComponent(window.Vue);
        }
    }

    var currentVue = window.Vue;

    Object.defineProperty(window, 'Vue', {
        configurable: true,
        enumerable: true,
        get: function () {
            return currentVue;
        },
        set: function (vue) {
            currentVue = vue;
            patchVueComponent(vue);
        },
    });

    if (currentVue) {
        window.Vue = currentVue;
    }

    var observer = new MutationObserver(function () {
        tryPatch();
    });

    observer.observe(document.documentElement, { childList: true, subtree: true });
    tryPatch();
})();
