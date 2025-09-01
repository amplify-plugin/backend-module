<?php

namespace Amplify\System\Backend\Seeders;

use Amplify\System\Cms\Models\Footer;
use Amplify\System\Cms\Models\Page;
use App\Models\Navigation;
use App\Models\Template;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('pages')->truncate();
        DB::table('navigations')->truncate();
        DB::table('footers')->truncate();
        DB::table('templates')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $templates = [
            ['id' => '1', 'name' => 'Template 1', 'slug' => 'template-1', 'component_folder' => 'template-1', 'asset_folder' => 'layout-1', 'is_active' => '1', 'is_new' => '0', 'is_updated' => '0', 'created_at' => '2022-03-14 06:30:41', 'updated_at' => '2022-03-15 10:13:52', 'deleted_at' => null],
            ['id' => '2', 'name' => 'Template 2', 'slug' => 'template-2', 'component_folder' => 'template-2', 'asset_folder' => 'layout-2', 'is_active' => '0', 'is_new' => '1', 'is_updated' => '0', 'created_at' => '2022-03-14 06:30:41', 'updated_at' => '2022-03-15 10:13:52', 'deleted_at' => null],
            ['id' => '3', 'name' => 'Template 3', 'slug' => 'template-3', 'component_folder' => 'template-3', 'asset_folder' => 'layout-3', 'is_active' => '0', 'is_new' => '0', 'is_updated' => '0', 'created_at' => '2022-08-29 11:58:57', 'updated_at' => '2022-09-01 13:44:15', 'deleted_at' => null],
            ['id' => '4', 'name' => 'Template 4', 'slug' => 'template-4', 'component_folder' => 'template-4', 'asset_folder' => 'layout-4', 'is_active' => '0', 'is_new' => '0', 'is_updated' => '0', 'created_at' => '2022-08-29 11:58:57', 'updated_at' => '2022-09-01 13:44:15', 'deleted_at' => null],
        ];

        $navigations = [
            ['id' => '1', 'menu_group_id' => '1', 'mobile_menu_id' => '6', 'name' => 'Header 1', 'layout' => 'layout-1', 'top_bar' => '1', 'content' => '{"search":true}', 'cms_config_logo' => 'template-1-logo', 'template_id' => '1', 'is_enabled' => '1', 'is_new' => '0', 'is_updated' => '1', 'created_at' => '2022-03-04 13:33:07', 'updated_at' => '2022-06-09 14:11:00'],
            ['id' => '2', 'menu_group_id' => '2', 'mobile_menu_id' => null, 'name' => 'Header 2', 'layout' => 'layout-1', 'top_bar' => '1', 'content' => '{"search":true}', 'cms_config_logo' => 'template-2-logo', 'template_id' => '2', 'is_enabled' => '1', 'is_new' => '0', 'is_updated' => '1', 'created_at' => '2022-06-10 09:31:39', 'updated_at' => '2022-06-10 14:15:55'],
            ['id' => '3', 'menu_group_id' => '5', 'mobile_menu_id' => '6', 'name' => 'Header 3', 'layout' => 'layout-1', 'top_bar' => '1', 'content' => '{"search":true}', 'cms_config_logo' => 'template-1-logo', 'template_id' => '3', 'is_enabled' => '1', 'is_new' => '1', 'is_updated' => '0', 'created_at' => '2022-09-01 13:57:30', 'updated_at' => '2022-09-01 13:57:30'],
        ];

        $pages = [
            ['id' => '35', 'template_id' => '1', 'name' => 'Home', 'slug' => 'home', 'page_type' => 'home', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <div class=\'mt-n5 d-block\'>
          </div>
          <banner_slider delay=\'5000\'>
            <banner_slider_item
                  title=\'HOME AUDIO VIDEO PRODUCTS\'
                  description=\'QUALITY PRODUCTS FROM THE MOST RESPECTED BRANDS IN THE INDUSTRY\'
                  button_title=\'SHOP NOW\'
                  button_link=\'/shop?ea_server_products=Home-Products\'
                  alt=\'\'
                  alignment_left=\'false\'
                  src=\'https://mountainwest.s3.amazonaws.com/images/banners/home-products-banner.jpg\'>
            </banner_slider_item>


            <banner_slider_item
                  title=\'CAR AUDIO AND TECHNOLOGY PRODUCTS\'
                  description=\'A COMPREHENSIVE SELECTION OF CAR AUDIO AND SECURITY PRODUCTS\'
                  button_title=\'SHOP NOW\'
                  button_link=\'/shop?ea_server_products=Car-Products\'
                  alt=\'\'
                  src=\'https://mountainwest.s3.amazonaws.com/images/banners/car-audio-banner.jpg\'>
            </banner_slider_item>
            <banner_slider_item
                  title=\'SECURITY PRODUCTS\'
                  description=\'FROM RING TO ALARM.COM AND QOLSYS - EVERYTHING YOU NEED TO SECURE YOUR HOME AND BUSINESS\'
                  button_title=\'SHOP NOW\'
                  button_link=\'/shop?ea_server_products=Security-Products\'
                  alt=\'\'
                  alignment_left=\'false\'
                  src=\'https://mountainwest.s3.amazonaws.com/images/banners/security-banner.jpg\'>
            </banner_slider_item>
          </banner_slider>

          <merch_products_medium_slider
              title=\'New Arrivals\'
              merchandising_zone=\'3\'
              products_limit=\'3\'
              show_cart_btn=\'true\'
              show_price=\'true\'
              show_top_discount_badge=\'false\'
              show_customer_list=\'false\'>
          </merch_products_medium_slider>


          <merch_products_medium_slider
              title=\'Featured Products\'
              merchandising_zone=\'2\'
              products_limit=\'20\'
              show_cart_btn=\'true\'
              show_price=\'true\'
              show_top_discount_badge=\'false\'
              show_customer_list=\'true\'>
          </merch_products_medium_slider>
          <merch_products_medium_slider
              title=\'Best Sellers\'
              merchandising_zone=\'1\'
              products_limit=\'5\'
              show_cart_btn=\'true\'
              show_price=\'true\'
              show_top_discount_badge=\'false\'
              show_customer_list=\'false\'>
          </merch_products_medium_slider>


          <section class="container padding-bottom-2x">
              <div class="row">
                <merch_products_small_3
                  merchandising_zone="1"
                    title=\'Best SELLERS\'
                    products_limit=\'3\'
                    show_price=\'true\'
                ></merch_products_small_3>
                <merch_products_small_3
                  merchandising_zone="3"
                    title=\'New Arrivals\'
                    products_limit=\'3\'
                    show_price=\'true\'
                ></merch_products_small_3>
                <merch_products_small_3
                  merchandising_zone="4"
                    title=\'Employees Choice\'
                    products_limit=\'3\'
                    show_price=\'true\'
                ></merch_products_small_3>

              </div>
          </section>

          <manufacturer_slider
              title=\'Featured Manufacturers\'
              limit=\'12\'
              name=\'false\'
              featured=\'true\'>
          </manufacturer_slider>


          <services_blade>
              <services_items
                  image_url=\'uploads/services/02.png\'
                  image_alt_text=\'Fast Service\'
                  title=\'Fast, Efficient Service\'
                  subtitle=\'So you can get moving!\'>
              </services_items>
              <services_items
                  image_url=\'uploads/services/03.png\'
                  image_alt_text=\'Support\'
                  title=\'Order Support\'
                  subtitle=\'During hours of operation\'>
              </services_items>
             <services_items
                  image_url=\'uploads/services/04.png\'
                  image_alt_text=\'Payment\'
                  title=\'Secure Online Payment\'
                  subtitle=\'We possess SSL / Secure Certificate\'>
              </services_items>
          </services_blade>

          </content>', 'middleware' => '[]', 'is_new' => '0', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-08-29 18:13:20', 'updated_at' => '2023-06-12 11:12:38', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '36', 'template_id' => '1', 'name' => 'Store', 'slug' => 'store', 'page_type' => 'shop', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
              <single_product_breadcrumb
                  is_extend_parent=\'true\'
                  pageTitle=\'Shop\'>
              </single_product_breadcrumb>
              <div class="container padding-bottom-2x mb-2">
                  <div class="row">
                      <!-- Sidebar-->
                      <div class="col-lg-3">
                               <ea_category_sidebar is_extend_parent="true">
                               </ea_category_sidebar>
                      </div>
                      <!-- Categories-->
                      <div class="col-lg-9">
                          <banner_widget
                             is_extend_parent="true"
                              zone=\'shop-top\'
                              code=\'\'>
                          </banner_widget>
                          <product_filter></product_filter>
                          <easyask_product_list_table
                               is_extend_parent="true"
                              paginate_per_page="5"
                              default_seo_path="Cabinet"
                              show_filter_bar="true"
                              show_cart_btn="true"
                              show_price="true"
                              show_top_discount_badge="true"
                              show_customer_list=\'true\'
                              amount_symbol="$">
                          </easyask_product_list_table>
                      </div>
                  </div>
              </div>
          </content>', 'middleware' => '[]', 'is_new' => '0', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-06 18:53:48', 'updated_at' => '2023-06-12 11:16:00', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '37', 'template_id' => '1', 'name' => 'Product Details', 'slug' => 'product-details', 'page_type' => 'single_product', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
              <single_product_breadcrumb
                  is_extend_parent=\'true\'
                  pageTitle=\'Product Details\'/>
             <single_product_body
                  is_extend_parent=\'true\'
                  show_customer_list=\'true\'
                  show_sku_table=\'true\'>
            </single_product_body>
          </content>', 'middleware' => '[]', 'is_new' => '0', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-06 18:57:56', 'updated_at' => '2023-06-12 11:17:48', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '38', 'template_id' => '1', 'name' => 'Order Details 3', 'slug' => 'order-details-3', 'page_type' => 'order_details', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <div class="container padding-bottom-3x mb-2">
              <div class="row">
               <t1_customer_dashboard_sidenav
                    short_code="customer-dashboard-sidebar">
                </t1_customer_dashboard_sidenav>

                <t1_customer_profile_order_list_items_widget
                  is_extend_parent="true"
                    is_quotation=\'false\'>
                </t1_customer_profile_order_list_items_widget>

             </div>
            </div>
          </content>', 'middleware' => '["customers"]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-06 18:59:06', 'updated_at' => '2022-09-21 17:36:29', 'deleted_at' => '2022-09-21 17:36:29', 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => ''],
            ['id' => '39', 'template_id' => '1', 'name' => 'Quotation Details 3', 'slug' => 'quotation-details-3', 'page_type' => 'quotation_details', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <div class="container padding-bottom-3x mb-2">
              <div class="row">
               <t1_customer_dashboard_sidenav
                    short_code="customer-dashboard-sidebar">
                </t1_customer_dashboard_sidenav>

                <t1_customer_profile_order_list_items_widget
                  is_extend_parent="true"
                    is_quotation=\'true\'>
                </t1_customer_profile_order_list_items_widget>

             </div>
            </div>
          </content>', 'middleware' => '["customers"]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-06 19:00:26', 'updated_at' => '2022-09-21 17:36:24', 'deleted_at' => '2022-09-21 17:36:24', 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => ''],
            ['id' => '40', 'template_id' => '1', 'name' => 'Customer List Details 3', 'slug' => 'customer-list-details-3', 'page_type' => 'customer_list_items', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
            <div class="container padding-bottom-3x mb-2">
              <div class="row">
                <t1_customer_dashboard_sidenav
                    short_code=\'customer-dashboard-sidebar\'>
                </t1_customer_dashboard_sidenav>

                <t1_order_list_items_widget
                  is_extend_parent="true"
                >
                </t1_order_list_items_widget>
              </div>
            </div>
          </content>', 'middleware' => '[]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-06 19:02:11', 'updated_at' => '2022-09-21 17:36:22', 'deleted_at' => '2022-09-21 17:36:22', 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => ''],
            ['id' => '41', 'template_id' => '1', 'name' => 'Orders 3', 'slug' => 'orders-3', 'page_type' => 'order', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <div class="container padding-bottom-3x mb-2">
              <div class="row">
               <t1_customer_dashboard_sidenav
                    short_code="customer-dashboard-sidebar">
                </t1_customer_dashboard_sidenav>

               <t1_customer_profile_order_list_widget
                 is_extend_parent="true"
                  is_quotation=\'false\'>
              </t1_customer_profile_order_list_widget>
             </div>
            </div>
          </content>', 'middleware' => '["customers"]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-06 19:39:23', 'updated_at' => '2022-09-21 17:36:19', 'deleted_at' => '2022-09-21 17:36:19', 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => ''],
            ['id' => '42', 'template_id' => '1', 'name' => 'Quotations 3', 'slug' => 'quotations-3', 'page_type' => 'quotation', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <div class="container padding-bottom-3x mb-2">
              <div class="row">
               <t1_customer_dashboard_sidenav
                    short_code="customer-dashboard-sidebar">
                </t1_customer_dashboard_sidenav>

               <t1_customer_profile_order_list_widget
                 is_extend_parent="true"
                  is_quotation=\'true\'>
              </t1_customer_profile_order_list_widget>
             </div>
            </div>
          </content>', 'middleware' => '["customers"]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-06 19:40:12', 'updated_at' => '2022-09-21 17:36:16', 'deleted_at' => '2022-09-21 17:36:16', 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => ''],
            ['id' => '43', 'template_id' => '1', 'name' => 'Customer List 3', 'slug' => 'customer-list-3', 'page_type' => 'customer_list', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
            <div class="container padding-bottom-3x mb-2">
              <div class="row">
                <t1_customer_dashboard_sidenav
                    short_code="customer-dashboard-sidebar">
                </t1_customer_dashboard_sidenav>

                <t1_order_list_widget
                  is_extend_parent="true"
                >
                </t1_order_list_widget>
              </div>
            </div>
          </content>', 'middleware' => '["customers"]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-06 19:41:08', 'updated_at' => '2022-09-21 17:36:12', 'deleted_at' => '2022-09-21 17:36:12', 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => ''],
            ['id' => '44', 'template_id' => '1', 'name' => 'Message', 'slug' => 'message', 'page_type' => 'messenger', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <single_product_breadcrumb
                  is_extend_parent=\'true\'
                  pageTitle=\'Message\'>
            </single_product_breadcrumb>
          <div class="container padding-bottom-3x mb-2">
            <div class="row">
            <div class="col-lg-3">
                <customer_dashboard_sidenav
                    short_code="customer-dashboard-sidebar-mw">
                </customer_dashboard_sidenav>
                </div>
                <div class="col-lg-9">
              <messenger
                is_extend_parent="true">
              </messenger>
              </div>
           </div>
          </div>
          </content>', 'middleware' => '["customers"]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:21:40', 'updated_at' => '2023-06-12 11:50:35', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '45', 'template_id' => '1', 'name' => 'Customer Dashboard', 'slug' => 'customer-dashboard', 'page_type' => 'customer_dashboard', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <single_product_breadcrumb
                  is_extend_parent=\'true\'
                  pageTitle=\'Customer Dashboard\'>
            </single_product_breadcrumb>
          <div class="container padding-bottom-3x mb-2">
              <div class="row">
          <div class="col-lg-3">
                <customer_dashboard_sidenav
                    short_code="customer-dashboard-sidebar-mw">
                </customer_dashboard_sidenav>
                </div>
                <div class="col-lg-9">
                <customer_dashboard
                  is_extend_parent="true">
                </customer_dashboard>
                </div>
             </div>
            </div>
          </content>', 'middleware' => '[]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:23:08', 'updated_at' => '2023-06-12 11:51:53', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '46', 'template_id' => '1', 'name' => 'Content', 'slug' => 'content', 'page_type' => 'content', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
            <content_full title="Content">
            </content_full>
          </content>', 'middleware' => '[]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:24:40', 'updated_at' => '2022-09-21 13:24:40', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => ''],
            ['id' => '47', 'template_id' => '1', 'name' => 'Create New Address', 'slug' => 'create-new-address', 'page_type' => 'static_page', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <div class="container padding-bottom-3x mb-2">
              <div class="row">
              <div class="col-lg-3">
                <customer_dashboard_sidenav
                    short_code="customer-dashboard-sidebar-mw">
                </customer_dashboard_sidenav>
                </div>
                <div class="col-lg-9">
                <address_create_widget>
                </address_create_widget>
                </div>
              </div>
            </div>
          </content>', 'middleware' => '["customers"]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:25:54', 'updated_at' => '2023-06-12 12:09:29', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '48', 'template_id' => '1', 'name' => 'Addresses', 'slug' => 'addresses', 'page_type' => 'static_page', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <single_product_breadcrumb
                  is_extend_parent=\'true\'
                  pageTitle=\'Addresses\'>
            </single_product_breadcrumb>
          <div class="container padding-bottom-3x mb-2">
              <div class="row"><div class="col-lg-3">
                <customer_dashboard_sidenav
                    short_code="customer-dashboard-sidebar-mw">
                </customer_dashboard_sidenav>
                </div>
                <div class="col-lg-9">
                <address_widget>
                </address_widget>
                </div>
              </div>
            </div>
          </content>', 'middleware' => '[]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:26:40', 'updated_at' => '2023-06-12 12:10:06', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '49', 'template_id' => '1', 'name' => 'Quotation Details', 'slug' => 'quotation-details', 'page_type' => 'quotation_details', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <single_product_breadcrumb
                  is_extend_parent=\'true\'
                  pageTitle=\'Quotation Details\'>
            </single_product_breadcrumb>
          <div class="container padding-bottom-3x mb-2">
              <div class="row">
          <div class="col-lg-3">
                <customer_dashboard_sidenav
                    short_code="customer-dashboard-sidebar-mw">
                </customer_dashboard_sidenav>
                </div>
                <div class="col-lg-9">
                <customer_profile_order_list_items_widget
                  is_extend_parent="true"
                    is_quotation=\'true\'>
                </customer_profile_order_list_items_widget>
          </div>
             </div>
            </div>
          </content>', 'middleware' => '["customers"]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:28:06', 'updated_at' => '2023-06-12 12:10:58', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '50', 'template_id' => '1', 'name' => 'Quotations', 'slug' => 'quotations', 'page_type' => 'quotation', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <single_product_breadcrumb
                  is_extend_parent=\'true\'
                  pageTitle=\'Quotations\'>
            </single_product_breadcrumb>
          <div class="container padding-bottom-3x mb-2">
              <div class="row">
              <div class="col-lg-3">
                <customer_dashboard_sidenav
                    short_code="customer-dashboard-sidebar-mw">
                </customer_dashboard_sidenav>
                </div>
                <div class="col-lg-9">
               <customer_profile_order_list_widget
                 is_extend_parent="true"
                  is_quotation=\'true\'>
              </customer_profile_order_list_widget>
              </div>
             </div>
            </div>
          </content>', 'middleware' => '["customers"]', 'is_new' => '0', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:28:46', 'updated_at' => '2023-06-12 12:11:38', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '51', 'template_id' => '1', 'name' => 'Order Details', 'slug' => 'order-details', 'page_type' => 'order_details', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <single_product_breadcrumb
                  is_extend_parent=\'true\'
                  pageTitle=\'Order Details\'>
            </single_product_breadcrumb>
          <div class="container padding-bottom-3x mb-2">
              <div class="row">
              <div class="col-lg-3">
                <customer_dashboard_sidenav
                    short_code="customer-dashboard-sidebar-mw">
                </customer_dashboard_sidenav>
                </div>
                <div class="col-lg-9">
                <customer_profile_order_list_items_widget
                  is_extend_parent="true"
                    is_quotation=\'false\'>
                </customer_profile_order_list_items_widget>
                </div>
             </div>
            </div>
          </content>', 'middleware' => '["customers"]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:29:46', 'updated_at' => '2023-06-12 12:12:58', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '52', 'template_id' => '1', 'name' => 'Contacts', 'slug' => 'contacts', 'page_type' => 'static_page', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <single_product_breadcrumb
                  is_extend_parent=\'true\'
                  pageTitle=\'Contacts\'>
            </single_product_breadcrumb>
          <div class="container padding-bottom-3x mb-2">
              <div class="row">
          <div class="col-lg-3">
                <customer_dashboard_sidenav
                    short_code="customer-dashboard-sidebar-mw">
                </customer_dashboard_sidenav>
                </div>
                <div class="col-lg-9">
                <contact_list></contact_list>
                </div>
              </div>
            </div>
          </content>', 'middleware' => '["customers"]', 'is_new' => '0', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:32:36', 'updated_at' => '2023-06-12 12:13:44', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '53', 'template_id' => '1', 'name' => 'Orders', 'slug' => 'orders', 'page_type' => 'order', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
              <single_product_breadcrumb
                  is_extend_parent=\'true\'
                  pageTitle=\'Orders\'>
            </single_product_breadcrumb>
          <div class="container padding-bottom-3x mb-2">
              <div class="row">
              <div class="col-lg-3">
                <customer_dashboard_sidenav
                    short_code="customer-dashboard-sidebar-mw">
                </customer_dashboard_sidenav>
                </div>
                <div class="col-lg-9">
               <customer_profile_order_list_widget
                 is_extend_parent="true"
                  is_quotation=\'false\'>
              </customer_profile_order_list_widget>
              </div>
             </div>
            </div>
          </content>', 'middleware' => '["customers"]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:33:39', 'updated_at' => '2023-06-12 12:14:22', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '54', 'template_id' => '1', 'name' => 'Customer List Details', 'slug' => 'customer-list-details', 'page_type' => 'customer_list_items', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <single_product_breadcrumb
                  is_extend_parent=\'true\'
                  pageTitle=\'Customer List Details\'>
            </single_product_breadcrumb>
          <div class="container padding-bottom-3x mb-2">
              <div class="row">
          <div class="col-lg-3">
                <customer_dashboard_sidenav
                    short_code="customer-dashboard-sidebar-mw">
                </customer_dashboard_sidenav>
                </div>
                <div class="col-lg-9">
                <order_list_items_widget
                  is_extend_parent="true"
                >
                </order_list_items_widget>
                </div>
              </div>
            </div>
          </content>', 'middleware' => '[]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:34:45', 'updated_at' => '2023-06-12 12:15:14', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '55', 'template_id' => '1', 'name' => 'Customer List', 'slug' => 'customer-list', 'page_type' => 'customer_list', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <single_product_breadcrumb
                  is_extend_parent=\'true\'
                  pageTitle=\'Customer List\'>
            </single_product_breadcrumb>
          <div class="container padding-bottom-3x mb-2">
              <div class="row">
          <div class="col-lg-3">
                <customer_dashboard_sidenav
                    short_code="customer-dashboard-sidebar-mw">
                </customer_dashboard_sidenav>
                </div>
                <div class="col-lg-9">
                <order_list_widget
                  is_extend_parent="true"
                >
                </order_list_widget>
                </div>
              </div>
            </div>
          </content>', 'middleware' => '["customers"]', 'is_new' => '0', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:35:33', 'updated_at' => '2023-06-12 12:15:55', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '56', 'template_id' => '1', 'name' => 'Customer Order', 'slug' => 'customer-order', 'page_type' => 'cart_page', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <customer_order_widget
          is_extend_parent="true"
          >
          </customer_order_widget>

          </content>', 'middleware' => '["customers"]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:37:12', 'updated_at' => '2023-06-12 12:16:26', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '57', 'template_id' => '1', 'name' => 'Customer Profile', 'slug' => 'customer-profile', 'page_type' => 'static_page', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
                <single_product_breadcrumb
                    is_extend_parent=\'true\'
                    pageTitle=\'My Profile\'>
              </single_product_breadcrumb>
          <div class="container padding-bottom-3x mb-2">
              <div class="row">
              <div class="col-lg-3">
                <customer_dashboard_sidenav
                    short_code="customer-dashboard-sidebar-mw">
                </customer_dashboard_sidenav>
                </div>
                <div class="col-lg-9">
                <customer_profile_widget>
                </customer_profile_widget>
                </div>
              </div>
            </div>
          </content>', 'middleware' => '["customers"]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:37:54', 'updated_at' => '2023-06-12 12:17:30', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '58', 'template_id' => '1', 'name' => 'Cart', 'slug' => 'cart', 'page_type' => 'static_page', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <cart_full></cart_full>
          </content>', 'middleware' => '[]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:38:54', 'updated_at' => '2022-09-21 13:38:54', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => ''],
            ['id' => '59', 'template_id' => '1', 'name' => 'Customer Registration', 'slug' => 'registration', 'page_type' => 'customer_registration_page', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
            <registration_widget>
            </registration_widget>
          </content>', 'middleware' => '[]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:39:48', 'updated_at' => '2023-06-12 12:18:42', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '60', 'template_id' => '1', 'name' => 'Customer Login', 'slug' => 'login', 'page_type' => 'customer_login_page', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <login_widget>
            </login_widget>
          </content>', 'middleware' => '[]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:40:30', 'updated_at' => '2023-06-12 12:19:09', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '61', 'template_id' => '1', 'name' => 'Quick Order', 'slug' => 'quick-order', 'page_type' => 'quick_order', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
              <single_product_breadcrumb
                  is_extend_parent=\'true\'
                  pageTitle=\'Quick Order\'>
              </single_product_breadcrumb>
          <quick_order>
            </quick_order>
          </content>', 'middleware' => '["customers"]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:41:04', 'updated_at' => '2023-06-12 12:19:37', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '62', 'template_id' => '1', 'name' => 'FAQ', 'slug' => 'faq', 'page_type' => 'faq', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <faq_full
                title=\'FAQ\'>
            </faq_full>
          </content>', 'middleware' => '[]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:41:46', 'updated_at' => '2022-09-21 13:41:46', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => ''],
            ['id' => '63', 'template_id' => '1', 'name' => 'Store 2', 'slug' => 'store-2', 'page_type' => 'shop', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <div class="container padding-bottom-2x mb-2">
                  <div class="row">
                      <!-- Sidebar-->
                      <div class="col-lg-3">
                          <aside class="sidebar sidebar-offcanvas">
                               <t1_ea_category_sidebar is_extend_parent="true">
                               </t1_ea_category_sidebar>
                                 <t2_product_attributes is_extend_parent="true">
                               </t2_product_attributes>
                          </aside>
                      </div>
                      <!-- Categories-->
                      <div class="col-lg-9">
                          <product_filter></product_filter>
                          <t1_easyask_product_list_table
                               is_extend_parent="true"
                              paginate_per_page="5"
                              default_seo_path="Cabinet"
                              show_filter_bar="true"
                              show_cart_btn="true"
                              show_price="true"
                              show_top_discount_badge="true"
                              show_whish_list="true"
                              amount_symbol="$">
                          </t1_easyask_product_list_table>
                      </div>
                  </div>
              </div>
          </content>', 'middleware' => '[]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:42:36', 'updated_at' => '2022-09-21 17:26:34', 'deleted_at' => '2022-09-21 17:26:34', 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => ''],
            ['id' => '64', 'template_id' => '1', 'name' => 'Home Page', 'slug' => 'home-page', 'page_type' => 'home', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <!-- <t1_featured_products
              is_extend_parent="true"
              heading=\'Featured Products\'
              products_limit=\'10\'
              show_cart_btn=\'true\'
              show_price=\'true\'
              show_top_discount_badge=\'false\'
              show_wish_list=\'false\'>
          </t1_featured_products> -->

          <t1_merch_products_medium_slider
              title=\'Featured Products\'
              merchandising_zone=\'2\'
              products_limit=\'5\'
              show_cart_btn=\'true\'
              show_price=\'true\'
              show_top_discount_badge=\'false\'
              show_wish_list=\'false\'>
          </t1_merch_products_medium_slider>

          <!-- <t1_home_products
              is_extend_parent="true"
              products_limit=\'3\'
              show_price=\'true\'>
              <home_products
                  title=\'Top Sellers\'>
              </home_products>
              <home_products
                  title=\'New Arrivals\'>
              </home_products>
              <home_products
                  title=\'Best Rated\'>
              </home_products>
          </t1_home_products> -->

          <section class="container padding-bottom-2x">
              <div class="row">
                <t1_merch_products_small_3
                  merchandising_zone="1"
                    title=\'Best SELLERS\'
                    products_limit=\'3\'
                    show_price=\'true\'
                ></t1_merch_products_small_3>
                <t1_merch_products_small_3
                  merchandising_zone="3"
                    title=\'New Arrivals\'
                    products_limit=\'3\'
                    show_price=\'true\'
                ></t1_merch_products_small_3>
                <t1_merch_products_small_3
                  merchandising_zone="4"
                    title=\'Managers Choice\'
                    products_limit=\'3\'
                    show_price=\'true\'
                ></t1_merch_products_small_3>
              </div>
          </section>

          <t1_manufacturer_slider
              title=\'Manufacturers\'
              limit=\'12\'>
          </t1_manufacturer_slider>

          <!-- <t1_popular_brands
              heading=\'Popular Brands\'>
              <brand_images
                  image_url=\'uploads/brands/01.png\'
                  image_alt_text=\'Addidas\'>
              </brand_images>
              <brand_images
                  image_url=\'uploads/brands/02.png\'
                  image_alt_text=\'Brooks\'>
              </brand_images>
              <brand_images
                  image_url=\'uploads/brands/03.png\'
                  image_alt_text=\'V\'>
              </brand_images>
              <brand_images
                  image_url=\'uploads/brands/04.png\'
                  image_alt_text=\'Nike\'>
              </brand_images>
              <brand_images
                  image_url=\'uploads/brands/05.png\'
                  image_alt_text=\'Puma\'>
              </brand_images>
              <brand_images
                  image_url=\'uploads/brands/06.png\'
                  image_alt_text=\'New Balance\'>
              </brand_images>
              <brand_images
                  image_url=\'uploads/brands/07.png\'
                  image_alt_text=\'Dior\'>
              </brand_images>
          </t1_popular_brands> -->

          <t1_services>
              <!-- <services
                  image_url=\'uploads/services/01.png\'
                  image_alt_text=\'Shipping\'
                  title=\'Free Worldwide Shipping\'
                  subtitle=\'Free shipping for all orders over $100\'>
              </services> -->
              <services
                  image_url=\'uploads/services/02.png\'
                  image_alt_text=\'Money Back\'
                  title=\'Money Back Guarantee\'
                  subtitle=\'We return money within 30 days\'>
              </services>
              <services
                  image_url=\'uploads/services/03.png\'
                  image_alt_text=\'Support\'
                  title=\'24/7 Customer Support\'
                  subtitle=\'Friendly 24/7 customer support\'>
              </services>
              <services
                  image_url=\'uploads/services/04.png\'
                  image_alt_text=\'Payment\'
                  title=\'Secure Online Payment\'
                  subtitle=\'We posess SSL / Secure Certificate\'>
              </services>
          </t1_services>
          </content>', 'middleware' => '[]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:43:50', 'updated_at' => '2022-09-21 17:27:28', 'deleted_at' => '2022-09-21 17:27:28', 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => ''],
            ['id' => '65', 'template_id' => '1', 'name' => 'Product Details', 'slug' => 'product-details-1', 'page_type' => 'single_product', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <t1_single_product_breadcrumb is_extend_parent="true">
              </t1_single_product_breadcrumb>
             <t1_single_product_body
                  is_extend_parent=\'true\'
                  show_sku_table=\'true\'>
            </t1_single_product_body>
          </content>', 'middleware' => '[]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:44:34', 'updated_at' => '2022-09-21 17:27:14', 'deleted_at' => '2022-09-21 17:27:14', 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => ''],
            ['id' => '66', 'template_id' => '1', 'name' => 'Store', 'slug' => 'store-1', 'page_type' => 'shop', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <div class="container padding-bottom-2x mb-2">
                  <div class="row">
                      <!-- Sidebar-->
                      <div class="col-lg-3">
                          <aside class="sidebar sidebar-offcanvas">
                               <t1_ea_category_sidebar is_extend_parent="true">
                               </t1_ea_category_sidebar>
                                 <t2_product_attributes is_extend_parent="true">
                               </t2_product_attributes>
                          </aside>
                      </div>
                      <!-- Categories-->
                      <div class="col-lg-9">
                          <product_filter></product_filter>
                          <t1_easyask_product_centralized
                              is_extend_parent="true"
                              paginate_per_page="5"
                              default_seo_path="Cabinet"
                              show_filter_bar="true"
                              show_cart_btn="true"
                              show_price="true"
                              show_top_discount_badge="true"
                              show_whish_list="true"
                              amount_symbol="$"
                              >
                            </t1_easyask_product_centralized>
                      </div>
                  </div>
              </div>
          </content>', 'middleware' => '[]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:45:24', 'updated_at' => '2022-09-21 17:26:44', 'deleted_at' => '2022-09-21 17:26:44', 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => ''],
            ['id' => '67', 'template_id' => '1', 'name' => 'Single Product', 'slug' => 'single-product', 'page_type' => 'single_product', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <div class="container padding-bottom-2x mb-2">
                              <div class="row">
                                  <div class="col-md-6">
                                      <single_product_images is_extend_parent="true"></single_product_images>
                                  </div>
                                  <div class="col-md-6">
                                      <single_product_info
                                          is_extend_parent="true"
                                          share_links="true"
                                          whishlist="true"
                                          add_to_cart="true"
                                      >
                                      </single_product_info>
                                  </div>
                              </div>
                              <single_product_tabs is_extend_parent="true">
                              </single_product_tabs>
                          </div>
          </content>', 'middleware' => '[]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:46:06', 'updated_at' => '2023-06-12 12:21:38', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '68', 'template_id' => '1', 'name' => 'Contact Us', 'slug' => 'contact-us', 'page_type' => 'contact', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
             <single_product_breadcrumb is_extend_parent="true" pageTitle="Contact Us" />
             <div class="row">
                <div class="col" />
                <div class="col-8">
                   <image alt="Some of our staff!" src="https://mountainwest.s3.amazonaws.com/images/Staff/staff-collage.jpg" />
                   <content_details title="false" content="2" />
                </div>
                <div class="col" />
             </div>
             <div class="row">
              <div class="col-2" />
               <div class="col-8 text-center">
                   <p />
                   <h3>Utah</h3>
                   <div class="row">
                       <div class="col-6">
                          <content_details title="false" content="4" />
                       </div>
                       <div class="col-4" style="height:600px">
                         <google_map_widget address="Mountain West Distributors, 2889 South 900 West, Salt Lake City, UT 84119" is_extend_parent="true" />
                       </div>
                   </div>
                   <div class="row">
                    <div class="col-2" />
                   <div class="col-8 text-center">
                   <h3>Our Utah Staff</h3>
                   </div>
                   </div>
                  <div class="row">
                     <div class="col">
                     <image
              alt=\'\'
              src=\'https://mountainwest.s3.amazonaws.com/images/Staff/Utah/Robin Aitken.jpg\'>
          </image>
          <content_details
              title=\'true\'
              content=\'9\'>
          </content_details>

                     </div>
                      <div class="col">
                      <image
              alt=\'\'
              src=\'https://mountainwest.s3.amazonaws.com/images/Staff/Utah/Robin Aitken.jpg\'>
          </image>
          <content_details
              title=\'true\'
              content=\'9\'>
          </content_details>

                     </div>
                      <div class="col">
                      <image
              alt=\'\'
              src=\'https://mountainwest.s3.amazonaws.com/images/Staff/Utah/Robin Aitken.jpg\'>
          </image>
          <content_details
              title=\'true\'
              content=\'9\'>
          </content_details>

                     </div>
                      <div class="col">
                      <image
              alt=\'\'
              src=\'https://mountainwest.s3.amazonaws.com/images/Staff/Utah/Robin Aitken.jpg\'>
          </image>
          <content_details
              title=\'true\'
              content=\'9\'>
          </content_details>

                     </div>
                      <div class="col">
                      <image
              alt=\'\'
              src=\'https://mountainwest.s3.amazonaws.com/images/Staff/Utah/Robin Aitken.jpg\'>
          </image>
          <content_details
              title=\'true\'
              content=\'9\'>
          </content_details>

                     </div>
                   </div>


                   <div class="row">
                     <div class="col">
                     <image
              alt=\'\'
              src=\'https://mountainwest.s3.amazonaws.com/images/Staff/Utah/Robin Aitken.jpg\'>
          </image>
          <content_details
              title=\'true\'
              content=\'9\'>
          </content_details>

                     </div>
                      <div class="col">
                      <image
              alt=\'\'
              src=\'https://mountainwest.s3.amazonaws.com/images/Staff/Utah/Robin Aitken.jpg\'>
          </image>
          <content_details
              title=\'true\'
              content=\'9\'>
          </content_details>

                     </div>
                      <div class="col">
                      <image
              alt=\'\'
              src=\'https://mountainwest.s3.amazonaws.com/images/Staff/Utah/Robin Aitken.jpg\'>
          </image>
          <content_details
              title=\'true\'
              content=\'9\'>
          </content_details>

                     </div>
                      <div class="col">
                      <image
              alt=\'\'
              src=\'https://mountainwest.s3.amazonaws.com/images/Staff/Utah/Robin Aitken.jpg\'>
          </image>
          <content_details
              title=\'true\'
              content=\'9\'>
          </content_details>

                     </div>
                      <div class="col">
                      <image
              alt=\'\'
              src=\'https://mountainwest.s3.amazonaws.com/images/Staff/Utah/Robin Aitken.jpg\'>
          </image>
          <content_details
              title=\'true\'
              content=\'9\'>
          </content_details>

                     </div>
                   </div>


                 </div>
              </div>
          </content>', 'middleware' => '[]', 'is_new' => '0', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:47:17', 'updated_at' => '2023-06-12 12:24:23', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => 'https://mountainwest.s3.amazonaws.com/images/Staff/Utah/Robin Aitken.jpg'],
            ['id' => '71', 'template_id' => '1', 'name' => 'Shop Category', 'slug' => 'shop-category', 'page_type' => 'shop_category', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <div class="container padding-bottom-2x mb-2">
                  <div class="row">
                      <!-- Categories-->
                      <div class="col-lg-12">
                          <category_list
                              is_extend_parent="true"
                              item_count="all">
                          </category_list>
                      </div>
                  </div>
              </div>
          </content>', 'middleware' => '[]', 'is_new' => '0', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:50:46', 'updated_at' => '2023-06-12 12:25:22', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '72', 'template_id' => '1', 'name' => 'Shop by Brand', 'slug' => 'shop-by-brand', 'page_type' => 'static_page', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
              <single_product_breadcrumb
                  is_extend_parent=\'true\'
                  pageTitle=\'Shop By Brand\'>
              </single_product_breadcrumb>
            <div class="container padding-bottom-3x mb-2">
              <div class="row">
                <shop_by_brand>
                </shop_by_brand>
              </div>
            </div>
          </content>', 'middleware' => '[]', 'is_new' => '0', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-10-11 21:03:29', 'updated_at' => '2023-06-12 12:25:54', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '74', 'template_id' => '1', 'name' => 'About Us', 'slug' => 'about-us', 'page_type' => 'static_page', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0" encoding="UTF-8"?>
          <content>
             <single_product_breadcrumb is_extend_parent="true" pageTitle="About Us" />
             <div class="row">
                <div class="col" />
                <div class="col-8">
                   <image alt="Some of our staff!" src="https://mountainwest.s3.amazonaws.com/images/Staff/staff-collage.jpg" />
                   <content_details title="false" content="2" />
                </div>
                <div class="col" />
             </div>
             <div class="row">
                <div class="col-2" />
                <div class="col-8 text-center">
                   <p />
                   <h3>Our Locations</h3>
                   <div class="row">
                      <div class="col">
                         <p>Utah</p>
                         <google_map_widget address="Mountain West Distributors, 2889 South 900 West, Salt Lake City, UT 84119" is_extend_parent="true" />
                         <content_details title="false" content="4" />
                      </div>
                      <div class="col">
                         <p>Arizona</p>
                         <google_map_widget address="Mountain West Distributors, 9160 E Del Camino Dr #B-2, Scottsdale, AZ 85258" is_extend_parent="true" />
                         <content_details title="false" content="5" />
                      </div>
                      <div class="col">
                         <p>Colorado</p>
                         <google_map_widget address="Mountain West Distributors, 700 W Mississippi Ave #A1, Denver, CO 80223" is_extend_parent="true" />
                         <content_details title="false" content="6" />
                      </div>
                      <div class="col">
                         <p>Oregon</p>
                         <google_map_widget address="Mountain West Distributors, 8150 SW Nimbus Ave, Beaverton, OR 97008" is_extend_parent="true" />
                         <content_details title="false" content="7" />
                      </div>
                      <div class="col">
                         <p>Washington</p>
                         <google_map_widget address="Mountain West Distributors, 1824 130th ave NE, Suite 3, Bellevue, WA 98005" is_extend_parent="true" />
                         <content_details title="false" content="8" />
                      </div>
                   </div>
                </div>
                <div class="col-2" />
             </div>
          </content>', 'middleware' => '[]', 'is_new' => '0', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-10-31 19:50:30', 'updated_at' => '2023-06-12 12:28:00', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => 'https://mountainwest.s3.amazonaws.com/images/Staff/staff-collage.jpg'],
            ['id' => '75', 'template_id' => '1', 'name' => 'Account Summary', 'slug' => 'account-summary', 'page_type' => 'static_page', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <single_product_breadcrumb
                  is_extend_parent=\'true\'
                  pageTitle=\'Account Summary\'>
            </single_product_breadcrumb>
          <div class="container padding-bottom-3x mb-2">
              <div class="row">
             <div class="col-lg-3">
                <customer_dashboard_sidenav
                    short_code="customer-dashboard-sidebar-mw">
                </customer_dashboard_sidenav>
                </div>
                <div class="col-lg-9">
                <customer_account_summary>
                </customer_account_summary>
                </div>
             </div>
            </div>
          </content>', 'middleware' => '["customers"]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-11-21 21:22:26', 'updated_at' => '2023-06-12 12:28:43', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '76', 'template_id' => '1', 'name' => 'Invoice Summary', 'slug' => 'invoice-summary', 'page_type' => 'messenger', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <single_product_breadcrumb
                  is_extend_parent=\'true\'
                  pageTitle=\'Invoice Summary\'>
            </single_product_breadcrumb>

          <div class="container padding-bottom-3x mb-2">
              <div class="row">
          <div class="col-lg-3">
                <customer_dashboard_sidenav
                    short_code="customer-dashboard-sidebar-mw">
                </customer_dashboard_sidenav>
                </div>
                <div class="col-lg-9">
                <customer_invoice_summary>
                </customer_invoice_summary>
                </div>

             </div>
            </div>
          </content>', 'middleware' => '["customers"]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-11-21 21:22:58', 'updated_at' => '2023-06-12 12:29:40', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '77', 'template_id' => '1', 'name' => 'Invoice Details', 'slug' => 'invoice-details', 'page_type' => 'invoice-details', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <single_product_breadcrumb
                  is_extend_parent=\'true\'
                  pageTitle=\'Invoice Details\'>
            </single_product_breadcrumb>
          <div class="container padding-bottom-3x mb-2">
              <div class="row">
          <div class="col-lg-3">
                <customer_dashboard_sidenav
                    short_code="customer-dashboard-sidebar-mw">
                </customer_dashboard_sidenav>
                </div>
                <div class="col-lg-9">
                <customer_invoice_details
                    is_extend_parent=\'true\'>
                </customer_invoice_details>
                </div>

             </div>
            </div>
          </content>', 'middleware' => '["customers"]', 'is_new' => '0', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-11-28 18:30:52', 'updated_at' => '2023-06-12 12:30:47', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '78', 'template_id' => '1', 'name' => 'Tickets', 'slug' => 'tickets', 'page_type' => 'open-ticket', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
                <single_product_breadcrumb
                    is_extend_parent=\'true\'
                    pageTitle=\'Create Ticket\'>
              </single_product_breadcrumb>
          <div class="container padding-bottom-3x mb-2">
              <div class="row">
              <div class="col-md-3">
                  <customer_dashboard_sidenav
                      short_code="customer-dashboard-sidebar-mw">
                  </customer_dashboard_sidenav>
                </div>
                <div class="col-md-9">
                <ticket_widget
                is_extend_parent=\'true\'>
                </ticket_widget>
                </div>
             </div>
            </div>
          </content>', 'middleware' => '["customers"]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2023-01-12 21:03:04', 'updated_at' => '2023-06-12 12:32:13', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '79', 'template_id' => '1', 'name' => 'Tickets List', 'slug' => 'tickets-list', 'page_type' => 'tickets-list', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
                <single_product_breadcrumb
                    is_extend_parent=\'true\'
                    pageTitle=\'Tickets List\'>
              </single_product_breadcrumb>
          <div class="container padding-bottom-3x mb-2">
              <div class="row">
              <div class="col-md-3">
                  <customer_dashboard_sidenav
                      short_code="customer-dashboard-sidebar-mw">
                  </customer_dashboard_sidenav>
                </div>
                <div class="col-md-9">
                <ticket_list_widget
                is_extend_parent=\'true\'>
                </ticket_list_widget>
                </div>
             </div>
            </div>
          </content>', 'middleware' => '["customers"]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2023-01-12 21:03:38', 'updated_at' => '2023-06-12 12:32:53', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '80', 'template_id' => '1', 'name' => 'Ticket Details', 'slug' => 'ticket-details', 'page_type' => 'ticket-details', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <div class="container padding-bottom-3x mb-2">
              <div class="row">
                  <div class="col-md-3">
                  <customer_dashboard_sidenav
                      short_code="customer-dashboard-sidebar-mw">
                  </customer_dashboard_sidenav>
                </div>
                <div class="col-md-9">
                <ticket_details
                is_extend_parent=\'true\'>
                </ticket_details>
                </div>
             </div>
            </div>
          </content>', 'middleware' => '["customers"]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2023-01-12 21:04:16', 'updated_at' => '2023-06-12 12:33:20', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '84', 'template_id' => '1', 'name' => 'test-zubayer', 'slug' => 'test-zubayer', 'page_type' => 'shop', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <div class="row">
          <div class="col-2">


              </div>
              <div class="col-2">
               <category_sidebar>

              <sub_category
                  level=\'2\'>
              </sub_category>
          </category_sidebar>

              </div>
              <div class="col-6">
             <t1_easyask_product_centralized
              paginate_per_page=\'10\'
              default_seo_path=\'Security-Products/Cameras/Brand:Alarm.com\'
              show_filter_bar=\'true\'
              show_cart_btn=\'true\'
              show_price=\'true\'
              show_top_discount_badge=\'false\'
              show_customer_list=\'false\'
              amount_symbol=\'$\'
              slider_form_ids=\'["ea_range_slider","ea_height_slider"]\'
              filter_form_ids=\'[{"type":"brand_filter","id":"home_page_brands_7788"},{"type":"category_filter","id":"home_page_category_1645"}]\'>
          </t1_easyask_product_centralized>

              </div>
              <div class="col">

              </div>
          </div>

          </content>', 'middleware' => '[]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2023-01-20 17:43:00', 'updated_at' => '2023-01-25 18:53:37', 'deleted_at' => '2023-01-25 18:53:37', 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '85', 'template_id' => '1', 'name' => 'Force Password Reset', 'slug' => 'force-redirect-page', 'page_type' => 'force-redirect-page', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
            <force_reset_widget>
            </force_reset_widget>
          </content>', 'middleware' => '[]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2023-01-23 22:29:31', 'updated_at' => '2023-06-12 12:33:41', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '86', 'template_id' => '1', 'name' => 'Form Builder Test', 'slug' => 'form-builder-test', 'page_type' => 'static_page', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <div class="container-fluid">
          <div class="row d-flex justify-content-center">
          <div class="col-md-6 col-sm-12">
          <form_builder
              action_url=\'http://184.72.223.26/form-validation-test\'
              allowed_reset=\'false\'
              form_fields=\'[{"type":"rText","label":"Name","name":"name","required":true,"inline":true,"default":""},{"type":"rEmail","label":"Email Address","name":"email","required":"","inline":true,"default":""},{"type":"rTel","label":"Phone","name":"phone","required":true,"inline":"","default":""},{"type":"rTextarea","label":"Message","name":"message","required":"","inline":"","default":""}]\'>
          </form_builder>

          </div>
          </div>
          </div>
          </content>', 'middleware' => '[]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2023-01-24 18:16:48', 'updated_at' => '2023-06-12 12:34:07', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '96', 'template_id' => '1', 'name' => 'Infor demo landing 1', 'slug' => 'infor-demo-landing-1', 'page_type' => 'static_page', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
            <div class="container">
              <div class="row">
                <div class="col-2"></div>
                <div class="col-8">
                    <div class="mb-2">
          <image
              alt=\'\'
              src=\'https://mountainwest.s3.amazonaws.com/images/banners/home-products-banner.jpg\'>
          </image>

                    </div>
          <easyask_product_centralized
              paginate_per_page=\'10\'
              default_seo_path=\'Home-Products/Projectors/Brand:Sony\'
              show_filter_bar=\'false\'
              show_cart_btn=\'true\'
              show_price=\'false\'
              show_top_discount_badge=\'false\'
              show_customer_list=\'false\'
              amount_symbol=\'$\'
              slider_form_ids=\'["ea_range_slider","ea_height_slider"]\'
              filter_form_ids=\'[{"type":"brand_filter","id":"home_page_brands_7788"},{"type":"category_filter","id":"home_page_category_1645"}]\'>
          </easyask_product_centralized>

                </div>
              </div>
            </div>
          </content>', 'middleware' => '[]', 'is_new' => '0', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2023-01-25 20:31:41', 'updated_at' => '2023-06-12 12:34:54', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => 'https://mountainwest.s3.amazonaws.com/images/banners/home-products-banner.jpg'],
            ['id' => '97', 'template_id' => '1', 'name' => 'Infor form demo', 'slug' => 'infor-form-demo', 'page_type' => 'static_page', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <div class="container-fluid">
              <div class="row">
                  <div class="col-md-3"></div>
                  <div class="col-md-6 col-sm-12">
                    <div class="mb-2">
          <image
              alt=\'\'
              src=\'https://mountainwest.s3.amazonaws.com/images/banners/sign-up-banner.png\'>
          </image>

                    </div>
          <form_builder
              action_url=\'http://184.72.223.26/form-test\'
              allowed_reset=\'true\'
              form_fields=\'[{"label":"Name ","name":"name","is_required":"true","default":""},{"label":"Email address","name":"email","is_required":"true","default":""},{"label":"Company","name":"company","is_required":"","default":""},{"label":"Phone","name":"phone","is_required":"","default":""}]\'>
          </form_builder>

                  </div>
              </div>
          </div>
          </content>', 'middleware' => '[]', 'is_new' => '0', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2023-01-25 20:35:31', 'updated_at' => '2023-06-12 12:35:49', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => 'https://mountainwest.s3.amazonaws.com/images/banners/sign-up-banner.png'],
            ['id' => '98', 'template_id' => '1', 'name' => 'campaign 1', 'slug' => 'campaign-1', 'page_type' => 'static_page', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
            <div class="container">
              <div class="row">
                <div class="col-2"></div>
                <div class="col-8">
                    <div class="mb-2">
          <image
              alt=\'\'
              src=\'https://mountainwest.s3.amazonaws.com/images/banners/home-products-banner.jpg\'>
          </image>

                    </div>
          <easyask_product_centralized
              paginate_per_page=\'10\'
              default_seo_path=\'Home-Products/Projectors/Brand:Sony\'
              show_filter_bar=\'false\'
              show_cart_btn=\'true\'
              show_price=\'false\'
              show_top_discount_badge=\'false\'
              show_customer_list=\'false\'
              amount_symbol=\'$\'
              slider_form_ids=\'["ea_range_slider","ea_height_slider"]\'
              filter_form_ids=\'[{"type":"brand_filter","id":"home_page_brands_7788"},{"type":"category_filter","id":"home_page_category_1645"}]\'>
          </easyask_product_centralized>

                </div>
              </div>
            </div>
          </content>', 'middleware' => '[]', 'is_new' => '0', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2023-01-26 23:31:31', 'updated_at' => '2023-06-12 12:36:28', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => 'https://mountainwest.s3.amazonaws.com/images/banners/home-products-banner.jpg'],
            ['id' => '99', 'template_id' => '1', 'name' => 'jesin', 'slug' => 'jesin', 'page_type' => 'faq', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>

          </content>', 'middleware' => '["customers"]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2023-03-09 15:39:15', 'updated_at' => '2023-03-09 15:40:47', 'deleted_at' => '2023-03-09 15:40:47', 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '100', 'template_id' => '1', 'name' => 'Draft Orders', 'slug' => 'drafts', 'page_type' => 'draft-order', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <div class="container padding-bottom-3x mb-2">
              <div class="row">
              <div class="col-lg-3">
                <customer_dashboard_sidenav
                    short_code="customer-dashboard-sidebar-mw">
                </customer_dashboard_sidenav>
                </div>
                <div class="col-lg-9">
               <customer_profile_draft_order_list_widget
                 is_extend_parent="true"
                  is_draft_order=\'true\'>
              </customer_profile_draft_order_list_widget>
              </div>
             </div>
            </div>
          </content>', 'middleware' => '["customers"]', 'is_new' => '0', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:28:46', 'updated_at' => '2023-06-12 12:37:06', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '101', 'template_id' => '1', 'name' => 'Draft Order Details', 'slug' => 'draft-order-details', 'page_type' => 'draft-order-details', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>
          <div class="container padding-bottom-3x mb-2">
              <div class="row">
               <div class="col-lg-3">
                <customer_dashboard_sidenav
                    short_code="customer-dashboard-sidebar-mw">
                </customer_dashboard_sidenav>
                </div>
                <div class="col-lg-9">
               <customer_profile_draft_order_list_items_widget
                  is_extend_parent="true"
                    is_draft_order=\'true\'>
                </customer_profile_draft_order_list_items_widget>
              </div>
             </div>
            </div>
          </content>', 'middleware' => '["customers"]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2022-09-21 13:28:06', 'updated_at' => '2023-06-12 12:38:12', 'deleted_at' => null, 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
            ['id' => '102', 'template_id' => '1', 'name' => 'test contact us', 'slug' => 'test-contact-us', 'page_type' => 'static_page', 'paramModel' => null, 'modelFindColumn' => null, 'content' => '<?xml version="1.0"?>
          <content>


          </content>', 'middleware' => '[]', 'is_new' => '1', 'default_page' => '0', 'is_updated' => '0', 'created_at' => '2023-05-02 17:55:50', 'updated_at' => '2023-06-12 12:38:55', 'deleted_at' => '2023-06-12 12:38:55', 'meta_description' => null, 'meta_key' => null, 'title' => null, 'meta_image_path' => null],
        ];

        $footers = [
            ['name' => 'Footer', 'layout' => 'layout-1', 'content' => '{"copyright":"<t1_footer_copyright\\n\\tcopyright_text=\'© 2022 Amplify. All rights reserved.\'>\\n</t1_footer_copyright>","links":"<div class=\\"row\\">\\n\\t<t1_footer_contact_informations\\n\\t\\theading=\'Get In Touch With Us\'\\n\\t\\tphone_text=\'Phone: 00 33 169 7720\'\\n\\t\\ttime_one_title=\'Monday-Friday:\'\\n\\t\\ttime_one=\'9.00 am - 8.00 pm\'\\n\\t\\ttime_two_title=\'Saturday:\'\\n\\t\\ttime_two=\'10.00 am - 6.00 pm\'\\n\\t\\temail=\'support@unishop.com\'>\\n\\t\\t<social_icon_links\\n\\t\\t\\thref=\'#\'\\n\\t\\t\\ticon=\'socicon-facebook\'>\\n\\t\\t</social_icon_links>\\n\\t\\t<social_icon_links\\n\\t\\t\\thref=\'#\'\\n\\t\\t\\ticon=\'socicon-twitter\'>\\n\\t\\t</social_icon_links>\\n\\t\\t<social_icon_links\\n\\t\\t\\thref=\'#\'\\n\\t\\t\\ticon=\'socicon-instagram\'>\\n\\t\\t</social_icon_links>\\n\\t\\t<social_icon_links\\n\\t\\t\\thref=\'#\'\\n\\t\\t\\ticon=\'socicon-googleplus\'>\\n\\t\\t</social_icon_links>\\n\\t</t1_footer_contact_informations>\\n\\n\\t<t1_footer_app_links\\n\\t\\theading=\'OUR MOBILE APP\'>\\n\\t\\t<app_links\\n\\t\\t\\ttitle=\'App Store\'\\n\\t\\t\\tsubtitle=\'Download on the\'\\n\\t\\t\\thref=\'#\'\\n\\t\\t\\ticon=\'apple-button\'>\\n\\t\\t</app_links>\\n\\t\\t<app_links\\n\\t\\t\\ttitle=\'Google Play\'\\n\\t\\t\\tsubtitle=\'Download on the\'\\n\\t\\t\\thref=\'#\'\\n\\t\\t\\ticon=\'google-button\'>\\n\\t\\t</app_links>\\n\\t\\t<app_links\\n\\t\\t\\ttitle=\'Windows Store\'\\n\\t\\t\\tsubtitle=\'Download on the\'\\n\\t\\t\\thref=\'#\'\\n\\t\\t\\ticon=\'windows-button\'>\\n\\t\\t</app_links>\\n\\t</t1_footer_app_links>\\n\\n\\t<t1_footer_general_links\\n\\theading=\'ABOUT US\'>\\n\\t\\t<links\\n\\t\\t\\thref=\'#\'\\n\\t\\t\\ttext=\'Careers\'>\\n\\t\\t</links>\\n\\t\\t<links\\n\\t\\t\\thref=\'#\'\\n\\t\\t\\ttext=\'About Unishop\'>\\n\\t\\t</links>\\n\\t\\t<links\\n\\t\\t\\thref=\'#\'\\n\\t\\t\\ttext=\'Our Story\'>\\n\\t\\t</links>\\n\\t\\t<links\\n\\t\\t\\thref=\'#\'\\n\\t\\t\\ttext=\'Services\'>\\n\\t\\t</links>\\n\\t\\t<links\\n\\t\\t\\thref=\'#\'\\n\\t\\t\\ttext=\'Our Blog\'>\\n\\t\\t</links>\\n\\t</t1_footer_general_links>\\n\\n\\t<t1_footer_general_links\\n\\theading=\'Account &amp; Shipping Info\'>\\n\\t\\t<links\\n\\t\\t\\thref=\'#\'\\n\\t\\t\\ttext=\'Your Account\'>\\n\\t\\t</links>\\n\\t\\t<links\\n\\t\\t\\thref=\'#\'\\n\\t\\t\\ttext=\'Shipping Rates &amp; Policies\'>\\n\\t\\t</links>\\n\\t\\t<links\\n\\t\\t\\thref=\'#\'\\n\\t\\t\\ttext=\'Refunds &amp; Replacements\'>\\n\\t\\t</links>\\n\\t\\t<links\\n\\t\\t\\thref=\'#\'\\n\\t\\t\\ttext=\'Taxes\'>\\n\\t\\t</links>\\n\\t\\t<links\\n\\t\\t\\thref=\'#\'\\n\\t\\t\\ttext=\'Delivery Info\'>\\n\\t\\t</links>\\n\\t\\t<links\\n\\t\\t\\thref=\'#\'\\n\\t\\t\\ttext=\'Affiliate Program\'>\\n\\t\\t</links>\\n\\t</t1_footer_general_links>\\n</div>","payment_and_subscription":"<div class=\\"row\\">\\n  <t1_footer_payment\\n  \\timage=\'/uploads/images/payment_methods.png\'\\n  \\timage_alt_text=\'Payment Methods\'>\\n  </t1_footer_payment>\\n\\n  <t1_footer_subscription\\n  \\tform_action_url=\'/subscribe\'\\n  \\tinput_placeholder=\'Your e-mail\'\\n  \\tinput_field_name=\'email\'\\n  \\tinput_placeholder_icon=\'icon-mail\'\\n  \\tsubmit_button_icon=\'icon-check\'\\n  \\tsubscription_description=\'Subscribe to our Newsletter to receive early discount offers, latest news, sales and promo information.\'>\\n  </t1_footer_subscription>\\n</div>"}', 'template_id' => '1', 'is_enabled' => '1', 'is_new' => '0', 'is_updated' => '1', 'created_at' => '2022-04-04 06:24:16', 'updated_at' => '2022-04-05 05:28:01'],
            ['name' => 'Footer', 'layout' => 'layout-1', 'content' => '{"address":"<t2_footer_top\\n    left_icon=\\"fa-phone-volume\\"\\n    left_text=\\"CUSTOMER SERVICE &lt;br&gt; NEW YORK: 1-800-3783650 &lt;br&gt; NEW ENGLAND: 1-800-3783650 &lt;br&gt;\\"\\n    right_icon=\\"fa-location-dot\\"\\n    right_text=\\"RIVERHEAD BUILDING SUPPLY &lt;br&gt; HAS 19 LOCATION THROUGHOUT &lt;br&gt; LONG ISLAND AND NEW ENGLAND\\"\\n>\\n</t2_footer_top>","links":"<div class=\\"row\\">\\n   <t2_footer_general_links heading=\\"Products\\">\\n            <link href=\\"#\\" text=\\"Link One\\"></link>\\n            <link href=\\"#\\" text=\\"Link Two\\"></link>\\n            <link href=\\"#\\" text=\\"Link Three\\"></link>\\n    </t2_footer_general_links>\\n\\n     <t2_footer_general_links heading=\\"Categories\\">\\n            <link href=\\"#\\" text=\\"Link One\\"></link>\\n            <link href=\\"#\\" text=\\"Link Two\\"></link>\\n            <link href=\\"#\\" text=\\"Link Three\\"></link>\\n    </t2_footer_general_links>\\n    \\n    <t2_footer_general_links heading=\\"Lorem\\">\\n            <link href=\\"#\\" text=\\"Link One\\"></link>\\n            <link href=\\"#\\" text=\\"Link Two\\"></link>\\n            <link href=\\"#\\" text=\\"Link Three\\"></link>\\n    </t2_footer_general_links>\\n     <t2_footer_general_links heading=\\"Ipsum\\">\\n            <link href=\\"#\\" text=\\"Link One\\"></link>\\n            <link href=\\"#\\" text=\\"Link Two\\"></link>\\n            <link href=\\"#\\" text=\\"Link Three\\"></link>\\n    </t2_footer_general_links>\\n    \\n     <t2_footer_general_links heading=\\"Others\\">\\n            <link href=\\"#\\" text=\\"Link One\\"></link>\\n            <link href=\\"#\\" text=\\"Link Two\\"></link>\\n            <link href=\\"#\\" text=\\"Link Three\\"></link>\\n    </t2_footer_general_links>\\n    \\n    <t2_footer_icon_links heading=\\"Socials\\">\\n            <icon_link href=\\"#\\" icon=\\"fa-facebook\\"></icon_link>\\n            <icon_link href=\\"#\\" icon=\\"fa-twitter\\"></icon_link>\\n            <icon_link href=\\"#\\" icon=\\"fa-instagram\\"></icon_link>\\n            <icon_link href=\\"#\\" icon=\\"fa-linkedin-in\\"></icon_link>\\n            <icon_link href=\\"#\\" icon=\\"fa-dropbox\\"></icon_link>\\n            <icon_link href=\\"#\\" icon=\\"fa-youtube\\"></icon_link>\\n    </t2_footer_icon_links>\\n\\n\\n</div>\\n","copyright":"<t2_footer_copyright left_text=\\"Copyright Amplify All Right Reserved\\">\\n    <single_link href=\\"#\\" link_text=\\"Hello World\\"></single_link>\\n    <single_link href=\\"#\\" link_text=\\"Hello World 2\\"></single_link>\\n    <single_link href=\\"#\\" link_text=\\"Hello World 3\\"></single_link>\\n</t2_footer_copyright>"}', 'template_id' => '2', 'is_enabled' => '1', 'is_new' => '0', 'is_updated' => '1', 'created_at' => '2022-03-25 10:40:31', 'updated_at' => '2022-03-28 10:25:12'],
            ['name' => 'Footer', 'layout' => 'layout-1', 'content' => '{"addresses":"<t3_addresses\\n\\taddresses=\'[{\\"state\\":\\"UTAH\\",\\"phone_number\\":\\"801.487.5694\\",\\"location_part_1\\":\\"2889 South 900 West\\",\\"location_part_2\\":\\"Salt Lake City, UT 84119\\"},{\\"state\\":\\"UTAH\\",\\"phone_number\\":\\"801.487.5694\\",\\"location_part_1\\":\\"2889 South 900 West\\",\\"location_part_2\\":\\"Salt Lake City, UT 84119\\"},{\\"state\\":\\"UTAH\\",\\"phone_number\\":\\"801.487.5694\\",\\"location_part_1\\":\\"2889 South 900 West\\",\\"location_part_2\\":\\"Salt Lake City, UT 84119\\"},{\\"state\\":\\"UTAH\\",\\"phone_number\\":\\"801.487.5694\\",\\"location_part_1\\":\\"2889 South 900 West\\",\\"location_part_2\\":\\"Salt Lake City, UT 84119\\"},{\\"state\\":\\"UTAH\\",\\"phone_number\\":\\"801.487.5694\\",\\"location_part_1\\":\\"2889 South 900 West\\",\\"location_part_2\\":\\"Salt Lake City, UT 84119\\"}]\'\\n>\\n</t3_addresses>\\n","companies":"<t3_companies>\\n  <image\\n  \\talt=\'\'\\n  \\tsrc=\'/frontend/layout-3/images/footer/1.png\'\\n  \\tclass=\'w-100\'>\\n  </image>\\n  <image\\n  \\talt=\'\'\\n  \\tsrc=\'/frontend/layout-3/images/footer/2.png\'\\n  \\tclass=\'w-100\'>\\n  </image>\\n  <image\\n  \\talt=\'\'\\n  \\tsrc=\'/frontend/layout-3/images/footer/3.png\'\\n  \\tclass=\'w-100\'>\\n  </image>\\n  <image\\n  \\talt=\'\'\\n  \\tsrc=\'/frontend/layout-3/images/footer/4.png\'\\n  \\tclass=\'w-100\'>\\n  </image>\\n</t3_companies>\\n","social_links":"<t3_social_links>\\n    <a href=\\"\\" class=\\"icon rounded mr-3 p-2 d-flex align-items-center justify-content-center\\">\\n        <image src=\'/frontend/layout-3/images/footer/twitter.png\' alt=\\"social-icon\\" class=\\"w-100 h-100\\"></image>\\n    </a>\\n    <a href=\\"\\" class=\\"icon rounded mr-3 p-2 d-flex align-items-center justify-content-center\\">\\n      <image src=\'/frontend/layout-3/images/footer/fb.png\' alt=\\"social-icon\\" class=\\"w-100 h-100\\"></image>\\n    </a>\\n    <a href=\\"\\" class=\\"icon rounded mr-3 p-2 d-flex align-items-center justify-content-center\\">\\n        <image src=\'/frontend/layout-3/images/footer/in.png\' alt=\\"social-icon\\" class=\\"w-100 h-100\\"></image>\\n    </a>\\n    <a href=\\"\\" class=\\"icon rounded mr-3 p-2 d-flex align-items-center justify-content-center\\">\\n        <image src=\'/frontend/layout-3/images/footer/ins.png\' alt=\\"social-icon\\" class=\\"w-100 h-100\\"></image>\\n    </a>\\n</t3_social_links>\\n"}', 'template_id' => '3', 'is_enabled' => '1', 'is_new' => '0', 'is_updated' => '1', 'created_at' => '2022-08-30 16:05:57', 'updated_at' => '2022-09-01 11:19:39'],
        ];

        $this->command->info('Page seeder started!');

        Template::insert($templates);
        $this->call(MenuSeeder::class);
        $this->call(WidgetSeeder::class);
        Navigation::insert($navigations);
        Page::insert($pages);
        Footer::insert($footers);

        /* Default Page Seed */
        //        $home = Page::create([
        //            'name' => 'Home',
        //            'slug' => 'home',
        //            'default_page' => 1,
        //            'content' => 'home page'
        //        ]);
        //        $shop = Page::create([
        //            'name' => 'Shop',
        //            'slug' => 'shop',
        //            'default_page' => 1,
        //            'content' => 'shop page'
        //        ]);

        $this->command->info('Page seeder completed!');
    }
}
