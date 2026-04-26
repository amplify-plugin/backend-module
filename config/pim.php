<?php

return [
    'auto_publish' => false,
    'required_fields' => true,
    'use_classifications' => true,
    'categorization_required' => true,
    'use_product_specific_detail_page' => true,
    'use_minimum_order_quantity' => false,
    'use_product_code_unique_check' => true,
    'mandatory_fields' => [],

    // @see product/create/tabs/BasicInfo.vue for usage
    'mandatory_field_labels' => [
        'product_name' => 'Product Name',
        'product_code' => 'Product Code',
        'short_description' => 'Short Description',
        'description' => 'Description',
        'categories' => 'Categories',
        'product_classification_id' => 'Product Classification',
    ],

    'pim_db_enabled' => env('DB_PIM_ENABLED', false),
    'document_type' => null,
    'default_status' => 'published',
    'product_statuses' => [
        'incomplete' => 'Incomplete',
        'draft' => 'Draft',
        'published' => 'Published',
        'archived' => 'Archived',
    ],
    'unit_of_measurements' => [
        ['code' => 'ea', 'label' => 'Each', 'quantity' => 1],
    ],
    'product_images' => [
        // staging images are here (relative to disk root)
        'scanning_folder' => env('AMPLIFY_PRODUCT_IMAGE_SCANNING_FOLDER'),

        // both staging and output will use this disk (your uploads disk)
        'disk' => env('AMPLIFY_PRODUCT_IMAGE_DISK', 'uploads'),

        // output base folder inside uploads disk
        'output_base_folder' => env('AMPLIFY_PRODUCT_IMAGE_OUTPUT_BASE', 'image/product'),

        // which product field to match with file code
        'product_code_column' => env('AMPLIFY_PRODUCT_IMAGE_PRODUCT_CODE_COLUMN', 'product_code'),

        // file extensions allowed
        'allowed_ext' => ['jpg', 'jpeg', 'png', 'webp', 'gif'],

        // queue / chunk settings
        'scan_file_chunk' => (int) env('AMPLIFY_PRODUCT_IMAGE_SCAN_FILE_CHUNK', 2000),
        'code_chunk' => (int) env('AMPLIFY_PRODUCT_IMAGE_CODE_CHUNK', 500),
    ],
];
