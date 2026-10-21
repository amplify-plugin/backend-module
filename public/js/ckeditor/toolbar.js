/**
 * Shared CKEditor toolbar + plugin allow-list (admin default).
 */
export const CKEDITOR_EXTRA_PLUGINS = 'templates,div,iframe,showblocks,smiley,font';

export const CKEDITOR_SHARED_CONFIG = {
    extraPlugins: CKEDITOR_EXTRA_PLUGINS,
    format_tags: 'p;h1;h2;h3;pre',
    removeDialogTabs: 'image:advanced;link:advanced',
    toolbar: [
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
        { name: 'tools', items: ['Maximize'] },
    ],
};
