/**
 * @license Copyright (c) 2003-2022, CKSource Holding sp. z o.o. All rights reserved.
 * CKEditor global config for editors that load config.js (non-Vue / legacy).
 * Toolbar defaults are defined in packages/backend/resources/js/ckeditor/toolbar.js
 */
CKEDITOR.editorConfig = function (config) {
    if (window.__CKEDITOR_SHARED_CONFIG) {
        CKEDITOR.tools.extend(config, window.__CKEDITOR_SHARED_CONFIG, true);
    }

    config.extraPlugins = config.extraPlugins || 'templates,div,iframe,showblocks,smiley,font';

    config.templates_files = [
        window.__CKEDITOR_TEMPLATES_URL || '/vendor/backend/ckeditor/content-templates.js'
    ];

    config.customConfig = '';

    if (!config.toolbar) {
        config.toolbar = [
            { name: 'document', items: ['Source', 'Templates'] },
            { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord'] },
            { name: 'undo', items: ['Undo', 'Redo'] },
            { name: 'editing', items: ['Find', 'Replace'] },
            '/',
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Strike', 'RemoveFormat'] },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList', 'Outdent', 'Indent'] },
            { name: 'blocks', items: ['Blockquote', 'CreateDiv'] },
            { name: 'align', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
            { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
            { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'Iframe', 'ShowBlocks'] },
            '/',
            { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
            { name: 'colors', items: ['TextColor', 'BGColor'] },
            { name: 'tools', items: ['Maximize'] }
        ];
    }

    config.format_tags = config.format_tags || 'p;h1;h2;h3;pre';
    config.removeDialogTabs = config.removeDialogTabs || 'image:advanced;link:advanced';
};
