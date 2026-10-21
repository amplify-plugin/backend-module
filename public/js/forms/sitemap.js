crud.field("sitemapTags").subfield('type').onChange(function (field) {
    crud.field("sitemapTags").subfield('thumbnail_loc', field.rowNumber).show(field.value == 'video');
    crud.field("sitemapTags").subfield('content_loc', field.rowNumber).show(field.value == 'video');
    crud.field("sitemapTags").subfield('player_loc', field.rowNumber).show(field.value == 'video');
    crud.field("sitemapTags").subfield('location', field.rowNumber).show(field.value == 'video');
}).change();

function formatFileNameFromUrl(url) {
    try {
        const cleanUrl = url.split('?')[0].split('#')[0];
        const fileName = cleanUrl.substring(cleanUrl.lastIndexOf('/') + 1);
        const nameWithoutExt = fileName.replace(/\.[^/.]+$/, '');

        return nameWithoutExt
            .replace(/[^a-zA-Z0-9-]+/g, ' ')
            .toLowerCase()
            .split(' ')
            .filter(Boolean)
            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
            .join(' ');

    }
    catch (error) {
        return '';
    }
}
