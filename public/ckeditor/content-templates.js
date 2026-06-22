/*
 * CKEditor content templates (2 default + 2 custom).
 * Preview images are published with the backend package (all clients).
 */
(function () {
    var imagesBase = window.__CKEDITOR_TEMPLATE_IMAGES_BASE
        || '/vendor/backend/ckeditor/plugins/templates/templates/images/';

    if (!imagesBase.endsWith('/')) {
        imagesBase += '/';
    }

    var placeholderSrc = imagesBase + 'placeholder.png';

    CKEDITOR.addTemplates('default', {
        imagesPath: imagesBase,

        templates: [
            {
                title: 'Image and Title',
                image: 'template1.gif',
                description: 'One main image with a title and text that surround the image.',
                html:
                    '<h3>' +
                    '<img src="' + placeholderSrc + '" alt="" style="margin-right: 10px" height="100" width="100" align="left" />' +
                    'Type the title here' +
                    '</h3>' +
                    '<p>Type the text here</p>'
            },
            {
                title: 'Strange Template',
                image: 'template2.gif',
                description: 'A template that defines two columns, each one with a title, and some text.',
                html:
                    '<table cellspacing="0" cellpadding="0" style="width:100%" border="0">' +
                    '<tr>' +
                    '<td style="width:50%"><h3>Title 1</h3></td>' +
                    '<td></td>' +
                    '<td style="width:50%"><h3>Title 2</h3></td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Text 1</td>' +
                    '<td></td>' +
                    '<td>Text 2</td>' +
                    '</tr>' +
                    '</table>' +
                    '<p>More text goes here.</p>'
            },
            {
                title: 'Zigzag Image and Text',
                image: 'zigzag.gif',
                description: 'Alternating rows: text and image, then image and text.',
                html:
                    '<table style="width:100%; border-collapse:collapse;" cellpadding="10" border="0">' +
                    '<tr>' +
                    '<td style="width:50%; vertical-align:top;">' +
                    '<h3>Title</h3>' +
                    '<p>Type your text here...</p>' +
                    '</td>' +
                    '<td style="width:50%; vertical-align:top;">' +
                    '<img src="' + placeholderSrc + '" alt="" style="max-width:100%; height:auto;" />' +
                    '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td style="width:50%; vertical-align:top;">' +
                    '<img src="' + placeholderSrc + '" alt="" style="max-width:100%; height:auto;" />' +
                    '</td>' +
                    '<td style="width:50%; vertical-align:top;">' +
                    '<h3>Title</h3>' +
                    '<p>Type your text here...</p>' +
                    '</td>' +
                    '</tr>' +
                    '</table>'
            },
            {
                title: 'Three Column Features',
                image: '3column.gif',
                description: 'Three equal columns with a title, icon or image, and text.',
                html:
                    '<table style="width:100%; border-collapse:collapse;" cellpadding="10" border="0">' +
                    '<tr>' +
                    '<td style="width:33%; vertical-align:top; text-align:center;">' +
                    '<h3>Title</h3>' +
                    '<img src="' + placeholderSrc + '" alt="" style="max-width:80px; height:auto;" />' +
                    '<p>Type your text here...</p>' +
                    '<p>Type your text here...</p>' +
                    '</td>' +
                    '<td style="width:33%; vertical-align:top; text-align:center;">' +
                    '<h3>Title</h3>' +
                    '<img src="' + placeholderSrc + '" alt="" style="max-width:80px; height:auto;" />' +
                    '<p>Type your text here...</p>' +
                    '<p>Type your text here...</p>' +
                    '</td>' +
                    '<td style="width:33%; vertical-align:top; text-align:center;">' +
                    '<h3>Title</h3>' +
                    '<img src="' + placeholderSrc + '" alt="" style="max-width:80px; height:auto;" />' +
                    '<p>Type your text here...</p>' +
                    '<p>Type your text here...</p>' +
                    '</td>' +
                    '</tr>' +
                    '</table>'
            }
        ]
    });
})();
