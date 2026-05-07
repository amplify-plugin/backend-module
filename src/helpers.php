<?php

use Amplify\System\Backend\Models\Category;

if (!function_exists('eaDefaultCategories')) {
    function eaDefaultCategories($requestFromModule): array
    {
        $categories = Category::query()
            ->whereNull('parent_id')
            ->withCount('products')
            ->get();

        return $categories->map(function ($category) {
            return [
                'ids' => $category->id,
                'name' => $category->category_name,
                'nodeString' => $category->category_code,
                'productCount' => $category->products_count,
            ];
        })->toArray();
    }
}

if (!function_exists('backend_permissions')) {
    function backend_permissions(): array
    {
        return [
            //Catalog
            'catalog' => 'l,c,u,d',
            'category' => 'l,c,u,d,ro',
            'classification' => 'l,c,u,d,ro',
            'product' => 'l,c,u,d,remove-sku,publish,unpublish,add-image-to-products',
            'attribute' => 'l,c,u,d',
            'option' => 'l,c,u,d',
            'document-type' => 'l,c,u,d',
            'brand' => 'l,c,u,d',
            'manufacturer' => 'l,c,u,d',
            'custom-part-number' => 'l,c,u,d',
            'relationship-type' => 'l,c,u,d',
            'product-relation' => 'l,c,u,d',

            //Customer
            'industry-classification' => 'l,c,u,d',
            'account-title' => 'l,c,u,d',
            'customer' => 'l,c,u,d,erp-bulk-sync',
            'contact' => 'l,c,u,d,impersonate,bulkErpSync',
            'account-request' => 'l,u,d',
            'customer-group' => 'l,c,u,d',
            'customer-role' => 'l,c,u,d',
            'customer-address' => 'l,c,u,d',
            'registration-request' => 'l,u,d',

            //Utilities
            'data-transformation' => 'l,c,u,d',
            'import-definition' => 'l,c,u,d',
            'import-job' => 'l,c,u,d',
            'export' => 'l,c,u,d',
//        'scheduled-job' => 'l,c,u,d',
            'backup' => 'l,c,d,download',

            //IceCat
            'icecat-definition' => 'l,c,u,d',
            'icecat-transformation' => 'l,c,u,d',

            //Orders
            'order' => 'l,u,d',
            'draft-order' => 'l,c,u,d',
            'quote' => 'l,c,u,d',
            'invoice' => 'l,c,u,d',
            'order-list' => 'l,c,u,d',

            //Location
            'country' => 'l,c,u,d',
            'state' => 'l,c,u,d',
            'warehouse' => 'l,c,u,d',

            //CMS
            'template' => 'l,c,u,d',
            'menu' => 'l,c,u,d',
            'menu-item' => 'l,c,u,d',
            'mega-menu' => 'l,c,u,d',
            'content-category' => 'l,c,u,d',
            'content' => 'l,c,u,d',
            'page' => 'l,c,u,d',
            'custom-style' => 'l,u',
            'banner-item' => 'l,c,u,d',
            'banner-zone' => 'l,c,u,d',
            'footer' => 'l,c,u,d',
            'faq-category' => 'l,c,u,d',
            'faq' => 'l,c,u,d',
            'script' => 'l,c,u,d',
            'robot-text' => 'l,u',
            'sitemap' => 'l,c,u,d',
            'localization' => 'l,c,u,d',

            //Help Desk
            'ticket' => 'l,c,u,d',
            'ticket-department' => 'l,c,u,d',

            //Form Builder
            'form' => 'l,c,u,d',
            'form-response' => 'l,c,u,d',

            //Marketing
            'campaign' => 'l,c,u,d',
            'merchandising-zone' => 'l,c,u,d',
            'subscriber' => 'l,c,u,d',

            //Settings
            'system-configuration' => 'l',
            'shipping-option' => 'l,c,u,d',
            'threshold-range' => 'l,c,u,d',
            'cms-setting' => 'l,u',
            'security-setting' => 'l,u',
            'order-setting' => 'l,u',
            'invoice-setting' => 'l,u',
            'seo-setting' => 'l,u',
            'prop65-setting' => 'l,u',
            'google-api-setting' => 'l,u',
            'api-setting' => 'l,u',

            //Notification
            'trigger' => 'l,u',
            'notification' => 'l,c,u,d',
            'event-template' => 'l,c,u,d',

            //Authorization
            'user' => 'l,c,u,d',
            'role' => 'l,c,u,d',
            'activity-log' => 'l,s,d',
            'contact-login' => 'l,c,u,d',

            //Message
            'message' => 'l,c,u',
            //File Manager
            'file-manager' => 'l',

            //Catalog Synchronization
            'synchronization' => 'l,u,d,process',

            //Event
            'event' => 'l,c,u,d',
            'event-type' => 'l,c,u,d',


            //OLD Permission Unused
            /*            'system-config' => 'u,cache-clear',
                        'category-product' => 'l,c,u,d',
                        'siteconfig' => 'l,c,u,d',
                        'query-category' => 'l,c,u,d',
                        'saved-query' => 'l,c,u,d',
                        'saved-report' => 'l,c,u,d',
                        'dynamic-report' => 'l',
                        'attribute-value' => 'l,c,u,d',
                        'payment' => 'l,c,u,d',
                        'widget' => 'l,c,u,d',

                        'tax' => 'l,c,u,d',
                        'store' => 'l,c,u,d',
                        'site-pricing' => 'l,c,u,d',
                        'language' => 'l,c,u,d',
                        'tag' => 'l,c,u,d',
                        'order-rule' => 'l,c,u,d',
                        'customer-order-rule' => 'l,c,u,d',
                        'customer-order-rule-track' => 'l,c,u,d',
                        'company' => 'l,c,u,d',
                        'custom-product' => 'l,c,u,d',
                        'email' => 'l,c,u,d',
                        'env-variable' => 'l,c,u,d',
                        'event-recipent' => 'l,c,u,d',
                        'event-variable' => 'l,c,u,d',
                        'list-item' => 'l,c,u,d',
                        'model-code' => 'l,c,u,d',
                        'my-report' => 'l,c,u,d',
                        'new-report' => 'l,c,u,d',
                        'notice' => 'l,c,u,d',
                        'product-classification' => 'l,c,u,d',
                        'report' => 'l,c,u,d',
                        'search' => 'l,c,u,d',
                        'site' => 'l,c,u,d',
                        'site-only' => 'l,c,u,d',
                        'standard-report' => 'l,c,u,d',
            */
        ];
    }
}
