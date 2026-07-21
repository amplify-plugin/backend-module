@php
    $ckeditorEditorUrl = asset(config('amplify.backend.ckeditor.editor_url', 'packages/ckeditor/ckeditor.js'));
    $ckeditorTemplatesUrl = asset('vendor/backend/ckeditor/content-templates.js');
    $ckeditorTemplateImagesBase = asset('vendor/backend/ckeditor/plugins/templates/templates/images') . '/';
    $ckeditorProductDescriptionCss = asset('vendor/backend/ckeditor/product-description.css');
@endphp

<script>
    window.__CKEDITOR_LOCAL_URL = @json($ckeditorEditorUrl);
    window.__CKEDITOR_TEMPLATES_URL = @json($ckeditorTemplatesUrl);
    window.__CKEDITOR_TEMPLATE_IMAGES_BASE = @json($ckeditorTemplateImagesBase);
    window.__CKEDITOR_PRODUCT_DESCRIPTION_CSS = @json($ckeditorProductDescriptionCss);
</script>
<script src="{{ asset('vendor/backend/ckeditor/ckeditor-config.js') }}"></script>
<script src="{{ asset('vendor/backend/ckeditor/ckeditor-vue-patch.js') }}"></script>
