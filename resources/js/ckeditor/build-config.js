import { CKEDITOR_EXTRA_PLUGINS, CKEDITOR_SHARED_CONFIG } from './toolbar';

const PRESERVE_KEYS = [
    'height',
    'allowedContent',
    'disallowedContent',
    'extraAllowedContent',
    'protectedSource',
    'entities',
    'basicEntities',
    'entities_greek',
    'entities_latin',
    'autoParagraph',
    'fillEmptyBlocks',
    'iframe_attributes',
    'removePlugins',
];

function mergeExtraPlugins(extraPlugins, fallback) {
    const plugins = new Set(
        (extraPlugins ? extraPlugins.split(',') : [])
            .map((plugin) => plugin.trim())
            .filter(Boolean)
    );

    (fallback ? fallback.split(',') : [])
        .map((plugin) => plugin.trim())
        .filter(Boolean)
        .forEach((plugin) => plugins.add(plugin));

    CKEDITOR_EXTRA_PLUGINS.split(',').forEach((plugin) => plugins.add(plugin));

    return Array.from(plugins).join(',');
}

export function getCkeditorEditorUrl() {
    return window.__CKEDITOR_LOCAL_URL || '/packages/ckeditor/ckeditor.js';
}

export function getCkeditorTemplatesUrl() {
    return window.__CKEDITOR_TEMPLATES_URL || '/vendor/backend/ckeditor/content-templates.js';
}

export function getCkeditorProductDescriptionCssUrl() {
    return window.__CKEDITOR_PRODUCT_DESCRIPTION_CSS
        || '/vendor/backend/ckeditor/product-description.css';
}

function resolveContentsCss(userContentsCss) {
    const defaults = [];

    if (typeof CKEDITOR !== 'undefined' && typeof CKEDITOR.getUrl === 'function') {
        defaults.push(CKEDITOR.getUrl('contents.css'));
    } else {
        defaults.push('/packages/ckeditor/contents.css');
    }

    defaults.push(getCkeditorProductDescriptionCssUrl());

    if (userContentsCss == null) {
        return defaults;
    }

    const userList = Array.isArray(userContentsCss) ? userContentsCss : [userContentsCss];
    const merged = new Set([...userList.filter(Boolean), ...defaults]);

    return Array.from(merged);
}

/**
 * Build a plain CKEditor config object (no Vue reactivity).
 */
export function buildCkeditorConfig(userConfig = {}) {
    const config = JSON.parse(JSON.stringify(CKEDITOR_SHARED_CONFIG));

    config.extraPlugins = mergeExtraPlugins(userConfig.extraPlugins, CKEDITOR_SHARED_CONFIG.extraPlugins);
    config.templates_files = [getCkeditorTemplatesUrl()];
    config.contentsCss = resolveContentsCss(userConfig.contentsCss);
    config.customConfig = '';

    PRESERVE_KEYS.forEach((key) => {
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

export function mergeCkeditorConfigDefaults(existingDefault) {
    return function () {
        const base = typeof existingDefault === 'function'
            ? existingDefault.call(this)
            : (existingDefault || {});

        return buildCkeditorConfig(base);
    };
}

export function applyCkeditorDefaults(component) {
    if (!component || !component.props) {
        return;
    }

    if (component.props.editorUrl) {
        component.props.editorUrl.default = getCkeditorEditorUrl();
    }

    if (component.props.config) {
        component.props.config.default = mergeCkeditorConfigDefaults(
            component.props.config.default
        );
    } else {
        component.props.config = {
            type: Object,
            default: mergeCkeditorConfigDefaults(null),
        };
    }
}
