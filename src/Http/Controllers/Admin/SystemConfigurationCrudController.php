<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Models\Country;
use Amplify\System\Backend\Models\DocumentType;
use Amplify\System\Backend\Models\Product;
use Amplify\System\Backend\Models\SystemConfiguration;
use Amplify\System\Cms\Models\MenuGroup;
use Amplify\System\Cms\Models\Page;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

/**
 * Class SystemConfigurationCrudController
 *
 * @property-read CrudPanel $crud
 */
class SystemConfigurationCrudController extends BackpackCustomCrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\Pro\Http\Controllers\Operations\BulkDeleteOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function setup()
    {
        CRUD::setModel(\Amplify\System\Backend\Models\SystemConfiguration::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/system-configuration');
        CRUD::setEntityNameStrings('system-configuration', 'system configurations');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     *
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addFilter(
            [
                'name' => 'name',
                'type' => 'dropdown',
                'label' => 'Name',
            ],
            function () {
                $options = [];
                foreach (array_keys(config('amplify')) as $tab) {
                    $options[$tab] = ucfirst($tab);
                }

                unset($options['constant'], $options['widget'],
                    $options['sftp'], $options['debug'],
                    $options['client_code'], $options['suppress_exception']);

                ksort($options);

                return $options;
            },

            function ($value) {
                $this->crud->addClause('where', 'name', '=', $value);
            }
        );

        CRUD::column('id')->type('number')->thousands_sep('');
        CRUD::column('name')->type('custom_html')->value(function ($systemConfig) {
            return ucwords($systemConfig->name);
        });
        CRUD::column('type')->type('select_from_array')->options(SystemConfiguration::VALUE_TYPES);
        CRUD::column('option')->type('textarea');
        CRUD::column('value');
        CRUD::column('updated_at');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     *
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::field('name');

        CRUD::addField([
            'name' => 'type',
            'label' => 'Type',
            'type' => 'select_from_array',
            'options' => SystemConfiguration::VALUE_TYPES,
        ]);

        CRUD::field('option');

        CRUD::field('value');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     *
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    /**
     * @deprecated not used my frontend
     */
    public function getERPDetails(Request $request)
    {
        $erp_name = $request->event_name;
        $config = config('amplify.erp.configurations');

        return (isset($config[$erp_name])) ? response()->json($config[$erp_name]) : response()->json(['error' => "ERP configuration ({$erp_name}) missing"]);
    }

    /**
     * @return Application|Factory|\Illuminate\Contracts\View\View
     *
     * @throws \Exception
     */
    public function showConfig()
    {
        $this->crud->setHeading('System Configuration', 'edit');
        $this->crud->setUpdateContentClass('col-md-12');

        $this->data['title'] = 'System Configuration';
        $this->data['currencies'] = \Amplify\System\Helpers\UtilityHelper::currencyDropdown();
        $this->data['coreConfigurationData'] = config('amplify') ?? [];
        $this->data['hierarchies'] = getModelNames(app_path('Models').'/*.php') ?? [];
        $this->data['countries'] = Country::select('name', 'id')->orderBy('name')->get();
        $this->data['product_indexes'] = (new Product)->getTableColumns() ?? [];
        $this->data['mail_configuration_data'] = config('mail');
        $this->data['pageTypes'] = Page::getConfigurableTypes();
        $this->data['menuGroups'] = MenuGroup::select('name', 'short_code')->get()->toArray();
        $this->data['catalogs'] = \Amplify\System\Backend\Models\Category::select('category_name', 'id')
            ->whereNull('parent_id')
            ->get()
            ->map(function ($item) {
                $item->name = $item->category_name;

                return $item;
            })->toArray();

        $this->data['documentTypes'] = DocumentType::select('name', 'id', 'media_type')->orderBy('name')->get();
        $this->data['availableLocales'] = [];

        if (config('amplify.client_code') == 'ACT') {
            $dds_import_path = config('amplify.icu.uploads_directory').'/files';
            $dds_filename_prefix = config('amplify.icu.filename_prefix');
            $dds_files = glob("$dds_import_path/$dds_filename_prefix*.json");

            $dates = array_map(function ($path) {
                $creationTimestamp = filemtime($path);

                return date('Y-m-d', $creationTimestamp);
            }, $dds_files);

            $unique_dates = array_unique($dates);

            sort($unique_dates);

            $this->data['dds_dates'] = array_values($unique_dates);
        }

        foreach (config('backpack.crud.locales', []) as $local => $language) {
            $this->data['availableLocales'][] = [
                'value' => $local,
                'name' => $language,
            ];
        }

        foreach (config('amplify.constant.date_time_formats') as $date) {
            $this->data['date_time_formats'][$date] = date($date, strtotime('2023-12-27 15:45:10'));
        }

        foreach (config('amplify.constant.date_formats') as $date) {
            $this->data['date_formats'][$date] = date($date, strtotime('2023-12-27 15:45:10'));
        }

        return view('backend::pages.configurations.create', array_merge(['crud' => $this->crud], $this->data));
    }

    /**
     * @return array|string[]|void
     */
    public function updateConfig(Request $request)
    {
        $data = [];
        if ($tab = $request->input('tab')) {
            if ($tab == SystemConfiguration::BASIC_TAB) {
                $data = $this->basicTabFormat($request);
            } elseif ($tab == SystemConfiguration::PIM_TAB) {
                $data = $this->pimTabFormat($request);
            } elseif ($tab == SystemConfiguration::REPORT_TAB) {
                $data = $this->reportTabFormat($request);
            } elseif ($tab == SystemConfiguration::SAYT_TAB) {
                $data = $this->saytTabFormat($request);
            } elseif ($tab == SystemConfiguration::ICECAT_TAB) {
                $data = $this->icecatTabFormat($request);
            } elseif ($tab == SystemConfiguration::GOOGLE_TAB) {
                $data = $this->googleTabFormat($request);
            } elseif ($tab == SystemConfiguration::FRONTEND_TAB) {
                $data = $this->frontendTabFormat($request);
            } elseif ($tab == SystemConfiguration::PAYMENT_TAB) {
                $data = $this->paymentTabFormat($request);
            } elseif ($tab == SystemConfiguration::ERP_TAB) {
                $data = $this->erpTabFormat($request);
            } elseif ($tab == SystemConfiguration::INVOICE_TAB) {
                $data = $this->invoiceTabFormat($request);
            } elseif ($tab == SystemConfiguration::SCHEDULE_TAB) {
                $data = $this->scheduleTabFormat($request);
            } elseif ($tab == SystemConfiguration::CMS_TAB) {
                $data = $this->cmsTabFormat($request);
            } elseif ($tab == SystemConfiguration::MARKETING_TAB) {
                $data = $this->marketingTabFormat($request);
            } elseif ($tab == SystemConfiguration::AMPLIFY_API_TAB) {
                $data = $this->amplifyAPITabFormat($request);
            } elseif ($tab == SystemConfiguration::ORDER_TAB) {
                $data = $this->orderTabFormat($request);
            } elseif ($tab == SystemConfiguration::PROP65_TAB) {
                $data = $this->prop65TabFormat($request);
            } elseif ($tab == SystemConfiguration::SECURITY_TAB) {
                $data = $this->securityTabFormat($request);
            } elseif ($tab == SystemConfiguration::DEVELOPER_TAB) {
                $data = $this->developerTabFormat($request);
            } elseif ($tab == SystemConfiguration::DDS_TAB) {
                $delay = 0;
                if (! empty($request->schedule_time)) {
                    $request->merge([
                        'schedule_time' => Carbon::parse($request->schedule_time)->format(getDefaultDateTimeFormat()),
                    ]);

                    $delay = Carbon::now()->diffInSeconds($request->schedule_time);
                }

                $options = implode(' ', array_map(fn ($date) => "--date=\"{$date}\"", $request->input('dates')));

                Artisan::call('app:incremental-catalog-update '.$options.' --delay='.$delay);

                return [
                    'status' => 'success',
                    'message' => 'DDS data processed to import.',
                ];
            }

            $response = [];
            if (! empty($data)) {
                $response = $this->updateSystemConfiguration($tab, $data);
            }

            /* Remove easyAsk search configuration from session */
            Session::forget(['ezshop-config']);

            /* Set easyAsk search configuration at session */
            Session::put('ezshop-config', eaShopConfig());

            return $response;
        }
    }

    /**
     * @return mixed
     *
     * @deprecated unknown api call
     */
    public function fetchHierarchies()
    {
        return config('amplify.basic.hierarchies')->hierarchies;
    }

    public function getPageData()
    {
        $page_type_list = collect(Page::getConfigurableTypes())->map(function ($item) {
            return $item['code'];
        });

        $page_data = Page::getPages($page_type_list);

        return response()->json($page_data, HttpFoundationResponse::HTTP_OK);
    }

    private function basicTabFormat($request)
    {
        return [
            'global_currency' => $request->input('global_currency', 'USD'),
            'default_language' => $request->input('default_language', 'en'),
            'hierarchies' => $request->input('hierarchies', ['Category']),
            'countries' => $request->input('countries', []),
            'web_order_prefix' => $request->input('web_order_prefix', null),
            'nxt_available_web_order_number' => $request->input('nxt_available_web_order_number', null),
            'date_time_format' => $request->input('date_time_format', config('amplify.basic.date_time_format')),
            'date_format' => $request->input('date_format', config('amplify.basic.date_format')),
            'default_reorder_limit' => $request->input('default_reorder_limit', 10),
            'navbar_brand' => $request->input('navbar_brand', 'img/Amplify Logo 280 tagline.png'),
            'footer_image' => $request->input('footer_image', 'img/Powered by EasyAsk.png'),
            'length_options' => $request->input('length_options', '10,25,50,100,500'),
            'recaptcha_status' => $request->boolean('recaptcha_status', true),
            'recaptcha_type' => $request->input('recaptcha_type', 'math'),
            'color_scheme' => $request->input('color_scheme', 'purple'),
            'enable_quick_list' => $request->boolean('enable_quick_list', true),
            'enable_multi_customer_manage' => $request->boolean('enable_multi_customer_manage', false),
            'enable_guest_pricing' => $request->boolean('enable_guest_pricing', false),
            'contact_import_default_password' => $request->input('contact_import_default_password',
                config('amplify.basic.contact_import_default_password')),
        ];
    }

    private function pimTabFormat($request)
    {
        return [
            'auto_publish' => $request->boolean('auto_publish', false),
            'required_fields' => $request->boolean('required_fields', true),
            'use_classifications' => $request->boolean('use_classifications', true),
            'use_product_specific_detail_page' => $request->boolean('use_product_specific_detail_page', true),
            'categorization_required' => $request->boolean('categorization_required', true),
            'use_minimum_order_quantity' => $request->boolean('use_minimum_order_quantity', false),
            'mandatory_fields' => $request->input('mandatory_fields', []),
            'document_type' => $request->input('document_type'),
            'unit_of_measurements' => $request->input('unit_of_measurements', [['code' => 'ea', 'label' => 'Each']]),
        ];
    }

    private function reportTabFormat($request)
    {
        return [
            'protocol' => $request->input('protocol', 'http'),
            'host' => $request->input('host', 'demov16.easyaskondemand1.com/EasyAsk/apps/TranslateToResults.jsp'),
            'port' => $request->input('port', null),
            'business_query_dictionary' => $request->input('business_query_dictionary', 'query-amplify'),
        ];
    }

    private function saytTabFormat($request)
    {
        return [
            'sayt_product_id' => $request->input('sayt_product_id', 'Product_Id'),
            'sayt_product_image' => $request->input('sayt_product_image', 'Product_Image'),
            'sayt_product_name' => $request->input('sayt_product_name', 'Product_Name'),
            'sayt_product_code' => $request->input('sayt_product_code', 'Product_Code'),
            'sayt_product_price' => $request->input('sayt_product_price', 'Price'),
            'sayt_product_description' => $request->input('sayt_product_description', 'Short_Description'),
            'sayt_product_type' => $request->input('sayt_product_type', 'Type_Id'),
            'sayt_product_sizes' => $request->input('sayt_product_sizes', 'Sku_Sizes'),
            'product_search_by_id_prefix' => $request->input('product_search_by_id_prefix', 'Products.Product Id'),
            'use_product_restriction' => $request->boolean('use_product_restriction', true),
            'search_box_placeholder' => $request->input('search_box_placeholder', 'Search Product all'),
            'default_catalog' => $request->input('default_catalog'),
        ];
    }

    private function icecatTabFormat($request)
    {
        return [
            'icecat_username' => $request->input('icecat_username', null),
        ];
    }

    private function googleTabFormat($request)
    {
        return [
            // Google Map
            'google_map_api_key' => $request->input('google_map_api_key', null),

            // Google Analytics
            'google_analytics_id' => $request->input('google_analytics_id', null),
            'google_tag_manager_id' => $request->input('google_tag_manager_id', null),
            'google_analytics_url' => $request->input('google_analytics_url', null),
        ];
    }

    private function frontendTabFormat(Request $request)
    {
        $config = [];

        $inputs = $request->except(['excluded_page_types', 'tab', 'styles', 'scripts', 'fallback_image_path']);

        foreach ($inputs as $key => $value) {
            $config[$key] = $value;
        }

        return $config;
    }

    private function paymentTabFormat($request)
    {
        $payment_config['default'] = $request->input('payment_gateway', config('amplify.payment.default'));
        $payment_config['allow_credit_payments'] = $request->boolean('allow_credit_payments');
        $payment_config['allow_payments'] = $request->boolean('allow_payments');
        $payment_config['allow_bulk_invoice_payments'] = $request->boolean('allow_bulk_invoice_payments');

        $payment_config['gateways.'.$payment_config['default'].'.merchant_id'] = $request->input('merchant_id', null);
        $payment_config['gateways.'.$payment_config['default'].'.payment_url'] = $request->input('payment_url', null);
        $payment_config['gateways.'.$payment_config['default'].'.ach_payment_url'] = $request->input('ach_payment_url', null);
        $payment_config['gateways.'.$payment_config['default'].'.cenpos_encrypted_mid'] = $request->input('cenpos_encrypted_mid',
            null);
        $payment_config['gateways.'.$payment_config['default'].'.secret_key'] = $request->input('secret_key');

        return $payment_config;
    }

    private function erpTabFormat($request): array
    {
        $erp_config['default'] = $request->input('default_erp', config('amplify.erp.default'));
        $erp_config['auto_create_cash_customer'] = $request->boolean('auto_create_cash_customer', false);
        $erp_config['auto_create_contact'] = $request->boolean('auto_create_contact', false);
        $erp_config['use_amplify_shipping'] = $request->boolean('use_amplify_shipping', false);
        $erp_config['add_ship_will_call_option'] = $request->boolean('add_ship_will_call_option', false);
        $erp_config['configurations.'.$erp_config['default'].'.username'] = $request->input('username', null);
        $erp_config['configurations.'.$erp_config['default'].'.url'] = $request->input('url', null);
        $erp_config['configurations.'.$erp_config['default'].'.password'] = $request->input('password', null);
        $erp_config['configurations.'.$erp_config['default'].'.multiple_warehouse'] = $request->boolean('multiple_warehouse');
        $erp_config['configurations.'.$erp_config['default'].'.use_single_warehouse_cart'] = $request->boolean('use_single_warehouse_cart', false);
        $erp_config['configurations.'.$erp_config['default'].'.enabled'] = $request->boolean('enabled');
        $erp_config['configurations.'.$erp_config['default'].'.customer_id_field'] = $request->input('customer_id_field', 'customer_code');
        $erp_config['configurations.'.$erp_config['default'].'.token_url'] = $request->input('token_url', '');
        $erp_config['configurations.'.$erp_config['default'].'.client_id'] = $request->input('client_id', '');
        $erp_config['configurations.'.$erp_config['default'].'.client_secret'] = $request->input('client_secret', '');
        $erp_config['configurations.'.$erp_config['default'].'.company_number'] = $request->input('company_number', '1');
        $erp_config['configurations.'.$erp_config['default'].'.operator_init'] = $request->input('operator_init', 'sys');

        return $erp_config;
    }

    private function cmsTabFormat($request): array
    {
        return [
            'slogan' => $request->input('slogan', config('amplify.cms.slogan')),
            'default' => $request->input('default_cms', config('amplify.cms.default')),
            'logo_path' => $request->input('logo_path', config('amplify.cms.logo_path')),
            'favicon_path' => $request->input('favicon_path', config('amplify.cms.favicon_path')),
            'email' => $request->input('email', config('amplify.cms.email')),
            'phone' => $request->input('phone', config('amplify.cms.phone')),
            'header_content' => $request->input('header_content', null),
        ];
    }

    private function invoiceTabFormat($request): array
    {
        return [
            'header_content_type' => $request->input('header_content_type', null),
            'header_content' => $request->input('header_content', null),
            'header_image_path' => $request->input('header_image_path', null),
            'footer_content' => $request->input('footer_content', null),
            'footer_image_path' => $request->input('footer_image_path', null),
            'footer_content_type' => $request->input('footer_content_type', null),
        ];
    }

    private function scheduleTabFormat($request): array
    {
        $schedule_config['timezone'] = $request->input('timezone', 'UTC');
        $schedule_config['logger_enabled'] = $request->boolean('logger_enabled', false);
        $schedule_config['commands.'.$request->input('default_command').'.enabled'] = $request->boolean('enabled',
            false);
        $schedule_config['commands.'.$request->input('default_command').'.interval'] = $request->input('interval',
            'daily');
        $schedule_config['commands.'.$request->input('default_command').'.priority'] = $request->input('priority', 10);
        $schedule_config['commands.'.$request->input('default_command').'.variables'] = json_decode($request->input('variables',
            config('amplify.schedule.commands.'.$request->input('default_command').'.variables')), true);
        $schedule_config['commands.'.$request->input('default_command').'.time.minute'] = $request->input('time.minute',
            '0');
        $schedule_config['commands.'.$request->input('default_command').'.time.hour'] = $request->input('time.hour',
            '*');
        $schedule_config['commands.'.$request->input('default_command').'.time.day'] = $request->input('time.day', '*');
        $schedule_config['commands.'.$request->input('default_command').'.time.month'] = $request->input('time.month',
            '*');
        $schedule_config['commands.'.$request->input('default_command').'.time.weekday'] = $request->input('time.weekday',
            '*');
        $schedule_config['commands.'.$request->input('default_command').'.time.month'] = $request->input('time.month',
            '*');
        $schedule_config['commands.'.$request->input('default_command').'.time.weekday'] = $request->input('time.weekday',
            '*');
        $schedule_config['commands.'.$request->input('default_command').'.auto_update_enabled'] = $request->input('auto_update_enabled',
            false);

        return $schedule_config;
    }

    private function marketingTabFormat($request): array
    {
        return [
            'social_media_share' => $request->boolean('social_media_share'),
            'social_media_links' => $request->input('social_media_links'),
            'free_ship_threshold' => $request->input('free_ship_threshold'),
            'checkout_threshold_replace' => $request->input('checkout_threshold_replace'),
            'discount_percent_to_flat_min_limit' => $request->input('discount_percent_to_flat_min_limit'),
            'free_ship_messages' => $request->input('free_ship_messages'),
        ];
    }

    private function amplifyAPITabFormat($request): array
    {
        return [
            'contact_detail' => $request->boolean('contact_detail', false),
            'contact_id_key' => $request->input('contact_id_key', 'id'),
        ];
    }

    private function orderTabFormat($request): array
    {
        return [
            'order_rule_check' => $request->boolean('order_rule_check', false),
            'send_email_to_create_order_from_quote' => $request->boolean('send_email_to_create_order_from_quote', false),
            'use_pickup_enable_warehouses_as_shipping_methods' => $request->boolean('use_pickup_enable_warehouses_as_shipping_methods', false),
        ];
    }

    private function prop65TabFormat($request): array
    {
        return [
            'prop65_icon' => $request->input('prop65_icon', null),
            'prop65_title' => $request->input('prop65_title', null),
            'prop65_message' => $request->input('prop65_message', null),
            'prop65_status' => $request->input('prop65_status', true),
        ];
    }

    private function securityTabFormat($request): array
    {
        return [
            'force_password_reset_enabled' => $request->boolean('force_password_reset_enabled', false),
            'password_length' => $request->input('password_length', null),
            'cookie_title' => $request->input('cookie_title', null),
            'cookie_content' => $request->input('cookie_content', null),
            'skip_contact_approval' => $request->boolean('skip_contact_approval', false),
        ];
    }

    /**
     * @return array
     *               TODO: db transaction cause error need to solve this
     */
    private function updateSystemConfiguration(string $name, array $options): array
    {
        foreach ($options as $option => $value) {
            try {
                SystemConfiguration::setValue($name, $option, $value);
            } catch (\Throwable $exception) {
                Log::error($exception);

                return [
                    'status' => 'error',
                    'message' => $exception->getMessage(),
                ];
            }
        }

        if (\request('tab') == SystemConfiguration::SAYT_TAB) {
            if (class_exists(\Amplify\System\Sayt\Jobs\ReConfigSaytStore::class)) {
                \Amplify\System\Sayt\Jobs\ReConfigSaytStore::dispatch();
            }
        }

        cacheAll(true);

        return [
            'status' => 'success',
            'message' => ucfirst($name).' configuration updated successfully',
        ];
    }

    private function developerTabFormat(Request $request)
    {
        return [
            'log_search' => $request->boolean('log_search', false),
            'log_payment' => $request->boolean('log_payment', false),
            'log_erp_api' => $request->boolean('log_erp_api', false),
            'log_email' => $request->boolean('log_email', false),
            'bug_recipient' => filter_var_array($request->input('bug_recipient', []), FILTER_SANITIZE_EMAIL),
        ];
    }
}
