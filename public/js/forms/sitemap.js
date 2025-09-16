crud.field("sitemapTags").subfield('type').onChange(function (field) {
    crud.field("sitemapTags").subfield('location', field.rowNumber).show(field.value == 'image');
    crud.field("sitemapTags").subfield('title', field.rowNumber).show(field.value == 'video');
    crud.field("sitemapTags").subfield('description', field.rowNumber).show(field.value == 'video');
    crud.field("sitemapTags").subfield('thumbnail_loc', field.rowNumber).show(field.value == 'video');
    crud.field("sitemapTags").subfield('content_loc', field.rowNumber).show(field.value == 'video');
    crud.field("sitemapTags").subfield('player_loc', field.rowNumber).show(field.value == 'video');
    crud.field("sitemapTags").subfield('location', field.rowNumber).show(field.value == 'video');
}).change();
