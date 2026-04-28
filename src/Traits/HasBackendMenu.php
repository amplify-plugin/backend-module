<?php

namespace Amplify\System\Backend\Traits;

use Amplify\System\Backend\Menus\Sidebar;
use Illuminate\Contracts\Container\BindingResolutionException;

trait HasBackendMenu
{
    /**
     * @throws BindingResolutionException
     */
    private function registerMenus(): void
    {
        /**
         * @var Sidebar $sidebar
         */
        $sidebar = $this->app->make('sidebar');

        $sidebar->item('Dashboard')
            ->icon('la la-home')
            ->url(backpack_url('dashboard'));

        $sidebar->group('Catalog')
            ->icon('la la-clipboard')
            ->canAny()
            ->items(function ($catalog) {
                $catalog->item('Catalogs')
                    ->icon('la la-tree')
                    ->url(backpack_url('catalog'));

                $catalog->item('Categories')
                    ->icon('la la-list-alt')
                    ->url(backpack_url('category'));

                $catalog->item('Classifications')
                    ->icon('la la-medkit')
                    ->url(backpack_url('classification'));

                $catalog->item('Products')
                    ->icon('la la-dropbox')
                    ->url(backpack_url('product'));

                $catalog->item('Attributes')
                    ->icon('la la-bolt')
                    ->url(backpack_url('attribute'));

                $catalog->item('Options')
                    ->icon('la la-tasks')
                    ->url(backpack_url('option'));

                $catalog->item('Document Types')
                    ->icon('la la-file-excel')
                    ->url(backpack_url('document-type'));

                $catalog->item('Brands')
                    ->icon('la la-image')
                    ->url(backpack_url('brand'));

                $catalog->item('Manufacturers')
                    ->icon('las la-warehouse')
                    ->can('manufacturer.list')
                    ->url(backpack_url('manufacturer'));

                $catalog->item('Custom Part Numbers')
                    ->icon('la la-question')
                    ->url(backpack_url('custom-part-number'));

                $catalog->item('Relationship Types')
                    ->icon('la la-question')
                    ->url(backpack_url('relationship-type'));

                $catalog->item('Product Relations')
                    ->icon('la la-question')
                    ->url(backpack_url('product-relation'));

                $catalog->item('Bulk Image Update')
                    ->icon('la la-upload')
                    ->url(backpack_url('products/bulk-image-update'));
            });

        $sidebar->group('Customers')
            ->icon('las la-users')
            ->items(function ($customers) {
                $customers->item('Industry Classifications')
                ->icon('las la-industry')
                ->url(backpack_url('industry-classification'));

                $customers->item('Account Titles')
                ->icon('las la-file')
                ->url(backpack_url('account-title'));

                $customers->item('Customers')
                ->icon('las la-building')
                ->url(backpack_url('customer'));

                $customers->item('Registration Requests')
                ->icon('la la-file-archive-o')
                ->url(backpack_url('customer-registration'));

                $customers->item('Contacts')
                ->icon('la la-users')
                ->url(backpack_url('contact'));

                $customers->item('Account Requests')
                ->icon('la la-user-plus')
                ->url(backpack_url('contact-registration'));


                $customers->item('Customer Groups')
                ->icon('las la-users')
                ->url(backpack_url('customer-group'));

                $customers->item('Customer Roles')
                ->icon('las la-id-card')
                ->url(backpack_url('customer-role'));

                $customers->item('Customer Permissions')
                ->icon('las la-user-slash')
                ->url(backpack_url('customer-permission'));

                $customers->item('Customer Address')
                ->icon('la la-address-book')
                ->url(backpack_url('customer-address'));
            });

        $sidebar->group('Utilities')
            ->icon('las la-tools')
            ->canAny('data-transformation.list', 'import-definition.list', 'import-job.list', 'icecat-definition.list',
                'icecat-transformation.list', 'export.list', 'scheduled-job.list', 'backup.list')
            ->items(function ($utilities) {
                $utilities->item('Data Transformations')
                    ->icon('las la-exchange-alt')
                    ->can('data-transformation.list')
                    ->url(backpack_url('data-transformation'));

                $utilities->item('Import Definitions')
                    ->icon('las la-upload')
                    ->can('import-definition.list')
                    ->url(backpack_url('import-definition'));

                $utilities->item('Import Jobs')
                    ->icon('la la-file-import')
                    ->can('import-job.list')
                    ->url(backpack_url('import-job'));

                $utilities->item('Exports')
                    ->icon('las la-file-export')
                    ->can('export.list')
                    ->url(backpack_url('export'));

                $utilities->item('Scheduled Jobs')
                    ->icon('lar la-clock')
                    ->can('scheduled-job.list')
                    ->url(backpack_url('scheduled-job'));

                $utilities->item('Backups')
                    ->icon('la la-hdd-o')
                    ->can('backup.list')
                    ->url(backpack_url('backup'));

                $utilities->item('Queue Jobs')
                    ->icon('las la-layer-group')
                    ->if(fn() => config('amplify.schedule.logger_enabled'))
                    ->url(backpack_url('job'));

                $utilities->item('Failed Jobs')
                    ->icon('las la-exclamation-triangle')
                    ->can('failed-job.list')
                    ->url(backpack_url('failed-job'));

                $utilities->item('Server Info')
                    ->icon('la la-gears')
                    ->can('server-info')
                    ->url(backpack_url('server-info'));
            });

        $sidebar->group('Orders')
            ->icon('las la-shopping-cart')
            ->canAny('order.list', 'quote.list', 'invoice.list', 'payment.list', 'customer-list.list', 'order-rule.list',
                'customer-order-rule.list', 'customer-order-rule-track.list')
            ->items(function ($orders) {
                $orders->item('Orders')
                    ->icon('las la-shopping-bag')
                    ->can('order.list')
                    ->url(backpack_url('order'));

                $orders->item('Draft Orders')
                    ->icon('las la-cart-arrow-down')
                    ->can('draft-order.list')
                    ->url(backpack_url('draft-order'));

                $orders->item('Quotes')
                    ->icon('las la-quote-right')
                    ->can('quote.list')
                    ->url(backpack_url('quote'));

                $orders->item('Invoices')
                    ->icon('las la-file-invoice-dollar')
                    ->can('invoice.list')
                    ->url(backpack_url('invoice'));

                $orders->item('Favorites')
                    ->icon('las la-file-contract')
                    ->can('customer-list.list')
                    ->url(backpack_url('customer-list'));
            });

        $sidebar->group('Locations')
            ->icon('la la-location-arrow')
            ->canAny('warehouse.list', 'store.list', 'country.list', 'state.list')
            ->items(function ($locations) {
                $locations->item('Warehouses')
                    ->icon('la la-home')
                    ->can('warehouse.list')
                    ->url(backpack_url('warehouse'));

                $locations->item('Countries')
                    ->icon('la la-map')
                    ->can('country.list')
                    ->url(backpack_url('country'));

                $locations->item('States')
                    ->icon('la la-map-pin')
                    ->can('state.list')
                    ->url(backpack_url('state'));
            });

        $sidebar->group('CMS')
            ->icon('las la-toolbox')
            ->canAny('template.list', 'menu-group.list', 'content.list', 'content-category.list', 'page.list', 'banner.list',
                'banner-zone.list', 'footer.list', 'faq-category.list', 'faq.list', 'script-manager.list', 'robots-text.list', 'custom-style.list')
            ->items(function ($cms) {
                $cms->item('Templates')
                    ->icon('lar la-clipboard')
                    ->can('template.list')
                    ->url(backpack_url('template'));

                $cms->item('Menus')
                    ->icon('la la-list')
                    ->can('menu-group.list')
                    ->url(backpack_url('menu-group'));

                $cms->group('Content Manager')
                    ->icon('la la-pencil')
                    ->canAny('content.list', 'content-category.list')
                    ->items(function ($content) {
                        $content->item('Content Categories')
                            ->icon('la la-icons')
                            ->can('content-category.list')
                            ->url(backpack_url('content-category'));

                        $content->item('Content Items')
                            ->icon('las la-edit')
                            ->can('content.list')
                            ->url(backpack_url('content'));
                    });

                $cms->item('Pages')
                    ->icon('las la-book')
                    ->can('page.list')
                    ->url(backpack_url('page'));

                $cms->item('Custom Styles')
                    ->icon('la la-css3')
                    ->can('custom-style.list')
                    ->url(backpack_url('custom-style'));

                $cms->group('Banners')
                    ->icon('las la-file-powerpoint')
                    ->canAny('banner.list', 'banner-zone.list')
                    ->items(function ($banners) {
                        $banners->item('Banner Zone')
                            ->icon('las la-file-image')
                            ->can('banner-zone.list')
                            ->url(backpack_url('banner-zone'));

                        $banners->item('Banner Item')
                            ->icon('las la-images')
                            ->can('banner.list')
                            ->url(backpack_url('banner'));

                    });

                $cms->item('Footers')
                    ->icon('las la-sort-down')
                    ->can('footer.list')
                    ->url(backpack_url('footer'));

                $cms->item('FAQ categories')
                    ->icon('las la-comments')
                    ->can('faq-category.list')
                    ->url(backpack_url('faq-category'));

                $cms->item('FAQs')
                    ->icon('lar la-question-circle')
                    ->can('faq.list')
                    ->url(backpack_url('faq'));

                $cms->item('Scripts')
                    ->icon('las la-scroll')
                    ->can('script-manager.list')
                    ->url(backpack_url('script-manager'));

                $cms->item('Google Analytics')
                    ->icon('las la-chart-bar')
                    ->can('script-manager.list')
                    ->url(backpack_url('google-analytic'));

                $cms->item('Robots Text')
                    ->icon('la la-robot')
                    ->can('robots-text.list')
                    ->url(backpack_url('robots-text'));

                $cms->item('Sitemap')
                    ->icon('la la-sitemap')
                    ->can('sitemap.list')
                    ->url(backpack_url('sitemap'));

                $cms->item('Localization')
                    ->icon('las la-globe')
                    ->can('localization.list')
                    ->url(backpack_url('localization'));
            });

        $sidebar->group('Ticketing')
            ->icon('las la-ticket-alt')
            ->canAny('ticket.list', 'ticket-department.list')
            ->items(function ($ticketing) {
                $ticketing->item('Tickets')
                    ->icon('las la-ticket-alt')
                    ->can('ticket.list')
                    ->url(backpack_url('ticket'));

                $ticketing->item('Ticket Department')
                    ->icon('las la-ticket-alt')
                    ->can('ticket-department.list')
                    ->url(backpack_url('ticket-department'));
            });

        $sidebar->group('Form Builder')
            ->icon('la la-file-invoice')
            ->canAny('form.list', 'form-response.list')
            ->items(function ($forms) {
                $forms->item('Forms')
                    ->icon('las la-list')
                    ->can('form.list')
                    ->url(backpack_url('form'));

                $forms->item('Form Responses')
                    ->icon('las la-chart-area')
                    ->can('form-response.list')
                    ->url(backpack_url('form-response'));
            });

        $sidebar->group('Marketing')
            ->icon('las la-chalkboard')
            ->canAny('campaign.list', 'landing-page.list', 'merchandising-zone.list', 'email.list', 'subscriber.list')
            ->items(function ($marketing) {
                $marketing->item('Campaigns')
                    ->icon('las la-bullhorn')
                    ->can('campaign.list')
                    ->url(backpack_url('campaign'));

                $marketing->item('Merchandising Zones')
                    ->icon('las la-landmark')
                    ->can('merchandising-zone.list')
                    ->url(backpack_url('merchandising-zone'));

                $marketing->item('Subscribers')
                    ->icon('las la-user-friends')
                    ->can('subscriber.list')
                    ->url(backpack_url('subscriber'));
            });

        $sidebar->group('Settings')
            ->icon('la la-cog')
            ->items(function ($settings) {
                $settings->item('Configuration')
                    ->icon('las la-sliders-h')
                    ->url(backpack_url('system-config'));

                $settings->group('Shipping')
                    ->icon('las la-shipping-fast')
                    ->items(function ($shipping) use ($settings) {
                        $shipping->item('Shipping Options')
                            ->icon('la la-ship')
                            ->url(backpack_url('shipping'));

                        $shipping->item('Threshold Ranges')
                            ->icon('las la-sliders-h')
                            ->url(backpack_url('threshold-range'));
                    });

                $settings->item('CMS')
                    ->icon('la la-file-contract')
                    ->url(backpack_url('cms-setting'));

                $settings->item('Security')
                    ->icon('la la-shield')
                    ->url(backpack_url('security-setting'));

                $settings->item('Order')
                    ->icon('la la-shopping-cart')
                    ->url(backpack_url('order-setting'));

                $settings->item('Invoice')
                    ->icon('la la-file')
                    ->url(backpack_url('invoice-setting'));

                $settings->item('SEO')
                    ->icon('lab la-searchengin')
                    ->url(backpack_url('seo-setting'));

                $settings->item('Prop65')
                    ->icon('la la-exclamation-triangle')
                    ->url(backpack_url('prop65-setting'));

                $settings->item('Google API')
                    ->icon('la la-google')
                    ->url(backpack_url('google-setting'));

                $settings->item('Amplify API')
                    ->icon('la la-android')
                    ->url(backpack_url('api-setting'));
            });

        $sidebar->group('Notification')
            ->icon('lar la-bell')
            ->canAny('trigger.list', 'event-template.list', 'event-action.list')
            ->items(function ($notification) {
                $notification->item('Trigger')
                    ->icon('las la-pause')
                    ->can('trigger.list')
                    ->url(backpack_url('trigger'));

                $notification->item('Templates')
                    ->icon('las la-file')
                    ->can('event-template.list')
                    ->url(backpack_url('event-template'));

                $notification->item('Notifications')
                    ->icon('las la-share')
                    ->can('event-action.list')
                    ->url(backpack_url('event-action'));
            });

        $sidebar->group('Authorization')
            ->icon('la la-users')
            ->canAny('user.list', 'role.list', 'permission.list', 'audit.list', 'contact-login.list')
            ->items(function ($auth) {
                $auth->item('Users')
                    ->icon('la la-user')
                    ->can('user.list')
                    ->url(backpack_url('user'));

                $auth->item('Roles')
                    ->icon('la la-id-badge')
                    ->can('role.list')
                    ->url(backpack_url('role'));

                $auth->item('Activity Logs')
                    ->icon('la la-angry')
                    ->can('audit.list')
                    ->url(backpack_url('audit'));

                $auth->item('Contact logins')
                    ->icon('las la-sign-in-alt')
                    ->can('contact-login.list')
                    ->url(backpack_url('contact-login'));
            });

        $sidebar->item('Messages')
            ->icon('la la-comments')
            ->can('message.list')
            ->url(backpack_url('message'));

        $sidebar->item('File Manager')
            ->icon('la la-files-o')
            ->can('file-manager.list')
            ->url(backpack_url('filemanager'));

        $sidebar->item('Catalog Synchronization')
            ->icon('la la-sync')
            ->can('product-sync.list')
            ->if(fn() => !config('amplify.schedule.commands.product_sync.auto_update_enabled'))
            ->url(backpack_url('product-sync'));
    }
}