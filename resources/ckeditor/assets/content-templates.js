/*
 * CKEditor content templates (2 default + 3 custom).
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
            },
            {
                title: 'Specs Upper Right',
                image: 'specs-upper-right.png',
                description: 'Product description with a specifications table floated to the upper right.',
                html:
                    '<div data-container="product-description">' +
                    '<div data-highlight="box" style="float: right; width: 48%; max-width: 420px; margin: 0 0 24px 28px; padding: 16px 18px; border: 1px solid #e2e8f0; background: #f8fafc; box-sizing: border-box;">' +
                    '<table style="width: 100%; border-collapse: collapse; font-family: inherit;">' +
                    '<thead>' +
                    '<tr style="border-bottom: 2px solid #cbd5e1;">' +
                    '<th style="text-align: left; padding: 8px 12px 8px 0; font-size: 0.9em; font-weight: 700; color: #0f172a;">Specification</th>' +
                    '<th style="text-align: right; padding: 8px 0 8px 12px; font-size: 0.9em; font-weight: 700; color: #0f172a;">Value</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>' +
                    '<tr style="border-bottom: 1px solid #e2e8f0;">' +
                    '<td style="text-align: left; padding: 10px 12px 10px 0; font-size: 0.85em; font-weight: 600; color: #334155;">Specification name</td>' +
                    '<td style="text-align: right; padding: 10px 0 10px 12px; font-size: 0.85em; color: #475569;">Value</td>' +
                    '</tr>' +
                    '<tr style="border-bottom: 1px solid #e2e8f0;">' +
                    '<td style="text-align: left; padding: 10px 12px 10px 0; font-size: 0.85em; font-weight: 600; color: #334155;">Specification name</td>' +
                    '<td style="text-align: right; padding: 10px 0 10px 12px; font-size: 0.85em; color: #475569;">Value</td>' +
                    '</tr>' +
                    '</tbody>' +
                    '</table>' +
                    '</div>' +

                    '<h2>Product Details</h2>' +
                    '<hr style="border: 0; border-top: 1px solid #e2e8f0; margin-bottom: 16px;" />' +
                    '<p><strong>Manufacturer:</strong> Manufacturer name <a href="#" target="_blank">About Us</a></p>' +
                    '<p><strong>Brand:</strong> Brand name <a href="#" target="_blank">Brand website</a></p>' +
                    '<p><strong>Model:</strong> Model number</p>' +
                    '<p><strong>Description:</strong> Brief product description.<br />' +
                    '<strong>Important note:</strong> Add any critical note or exclusion here.</p>' +
                    '<p><strong>Product Support:</strong> <a href="#" target="_blank">Support resources</a></p>' +
                    '<p><strong>Rebates:</strong> <a href="#" target="_blank">Available rebates</a></p>' +
                    '<p><strong>Warranty:</strong> Warranty overview <a href="#" target="_blank">Warranty claim or registration</a></p>' +
                    '<ul style="margin-top: 12px; padding-left: 20px;">' +
                    '<li style="margin-bottom: 8px;"><strong>Warranty tier 1:</strong> Coverage details</li>' +
                    '<li style="margin-bottom: 8px;"><strong>Warranty tier 2:</strong> Coverage details</li>' +
                    '</ul>' +
                    '<div style="clear: both;"></div>' +
                    '<h2 style="margin-top: 24px;">Marketing heading</h2>' +

                    '<hr style="border: 0; border-top: 1px solid #e2e8f0; margin-bottom: 16px;" />' +
                    '<p>Describe performance, craftsmanship, or application.</p>' +
                    '<h2 style="margin-top: 24px;">Marketing heading</h2>' +
                    '<hr style="border: 0; border-top: 1px solid #e2e8f0; margin-bottom: 16px;" />' +
                    '<p>Describe quality standards, construction materials, or longevity.</p>' +
                    '<h2 style="margin-top: 24px;">Features &amp; Benefits</h2>' +
                    '<hr style="border: 0; border-top: 1px solid #e2e8f0; margin-bottom: 16px;" />' +
                    '<ul style="padding-left: 20px; list-style-type: disc;">' +
                    '<li style="margin-bottom: 10px;"><strong>Feature title:</strong> Explain the benefit and why it matters.</li>' +
                    '<li style="margin-bottom: 10px;"><strong>Feature title:</strong> Explain the benefit and why it matters.</li>' +
                    '<li style="margin-bottom: 10px;"><strong>Feature title:</strong> Explain the benefit and why it matters.</li>' +
                    '</ul>' +
                    '<h2 style="margin-top: 24px;">Dimensions and Specifications</h2>' +
                    '<hr style="border: 0; border-top: 1px solid #e2e8f0; margin-bottom: 16px;" />' +
                    '<div style="display: flex; flex-direction: column; gap: 16px;">' +
                    '<a href="#" target="_blank">' +
                    '<img alt="Dimension diagram" src="' + placeholderSrc + '" style="max-width: 100%; height: auto;" />' +
                    '</a>' +
                    '<a href="#" target="_blank">' +
                    '<img alt="Dimension diagram" src="' + placeholderSrc + '" style="max-width: 100%; height: auto;" />' +
                    '</a>' +
                    '</div>' +
                    '</div>'
            }
        ]
    });
})();
