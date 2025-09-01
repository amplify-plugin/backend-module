<?php

namespace Amplify\System\Backend\Seeders;

use App\Models\Event;
use App\Models\EventRecipent;
use App\Models\EventVariable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Schema::hasTable('events') && Schema::hasTable('event_variables')) {
            Event::truncate();
            EventVariable::truncate();
            EventRecipent::truncate();

            $events = [
                [
                    'name' => 'Registration Request Received',
                    'code' => 'registration_request_received',
                    'enabled' => true,
                    'description' => 'Registration Request Received',
                    'eventVariables' => [
                        // Existing variables
                        new EventVariable(['name' => '__customer_name__', 'value' => '', 'description' => 'Name of the customer', 'for_admin' => false]),
                        new EventVariable(['name' => '__customer_code__', 'value' => '', 'description' => 'Customer Code of the customer', 'for_admin' => false]),
                        new EventVariable(['name' => '__email_address__', 'value' => '', 'description' => 'Email of the customer', 'for_admin' => false]),
                        new EventVariable(['name' => '__phone_no__', 'value' => '', 'description' => 'Phone Number of the customer', 'for_admin' => false]),
                        new EventVariable(['name' => '__industry_classification__', 'value' => '', 'description' => 'Industry Classification of the customer', 'for_admin' => false]),
                        new EventVariable(['name' => '__address_name__', 'value' => '', 'description' => 'Name of the address', 'for_admin' => false]),
                        new EventVariable(['name' => '__address_1__', 'value' => '', 'description' => 'Address Line 1', 'for_admin' => false]),
                        new EventVariable(['name' => '__country_code__', 'value' => '', 'description' => 'Country Code', 'for_admin' => false]),
                        new EventVariable(['name' => '__city__', 'value' => '', 'description' => 'City', 'for_admin' => false]),
                        new EventVariable(['name' => '__state__', 'value' => '', 'description' => 'State', 'for_admin' => false]),
                        new EventVariable(['name' => '__zip_code__', 'value' => '', 'description' => 'Zip Code', 'for_admin' => false]),
                        new EventVariable(['name' => '__customer_details_url_for_request_received__', 'value' => '', 'description' => '/admin/customer-registration/:id/show', 'for_admin' => true]),
                        new EventVariable(['name' => '__customer_details_url_for_request_accepted__', 'value' => '', 'description' => '/admin/customer/:id/show', 'for_admin' => true]),
                    ],
                    'eventRecipents' => [
                        new EventRecipent(['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator', 'enabled' => true]),
                        new EventRecipent(['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer', 'enabled' => true]),
                    ],
                ],
                [
                    'name' => 'Registration Request Accepted',
                    'code' => 'registration_request_accepted',
                    'enabled' => true,
                    'description' => 'Registration Request Accepted',
                    'eventVariables' => [
                        new EventVariable(['name' => '__customer_name__', 'value' => '', 'description' => 'Name of the customer', 'for_admin' => false]),
                        new EventVariable(['name' => '__customer_details_url_for_request_received__', 'value' => '', 'description' => '/admin/customer-registration/:id/show', 'for_admin' => true]),
                        new EventVariable(['name' => '__customer_details_url_for_request_accepted__', 'value' => '', 'description' => '/admin/customer/:id/show', 'for_admin' => true]),
                    ],
                    'eventRecipents' => [
                        new EventRecipent(['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator', 'enabled' => true]),
                        new EventRecipent(['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer', 'enabled' => true]),
                        new EventRecipent(['name' => 'Business_Contact', 'event_action_field' => 'is_get_customer_business_contact', 'description' => 'Customer Business Contact', 'enabled' => true]),
                        new EventRecipent(['name' => 'Contact', 'event_action_field' => 'is_get_contact', 'description' => 'Contact', 'enabled' => true]),
                    ],
                ],
                [
                    'name' => 'Order Received',
                    'code' => 'order_received',
                    'enabled' => true,
                    'description' => 'Order Received',
                    'eventVariables' => [
                        new EventVariable(['name' => '__customer_name__', 'value' => '', 'description' => 'Name of the customer', 'for_admin' => false]),
                        new EventVariable(['name' => '__contact_name__', 'value' => '', 'description' => 'Name of the contact', 'for_admin' => false]),
                        new EventVariable(['name' => '__logged_in_user_name__', 'value' => '', 'description' => 'Name of the logged in user', 'for_admin' => false]),
                        new EventVariable(['name' => '__web_order_number__', 'value' => '', 'description' => 'Web Order Number', 'for_admin' => false]),
                        new EventVariable(['name' => '__total_amount__', 'value' => '', 'description' => 'Order Total Amount', 'for_admin' => false]),
                        new EventVariable(['name' => '__notes__', 'value' => '', 'description' => 'Order Notes', 'for_admin' => false]),
                        new EventVariable(['name' => '__customer_order_details_url__', 'value' => '', 'description' => '/customer-profile-order-list-items?order_id=:id', 'for_admin' => false]),
                        new EventVariable(['name' => '__customer_quotation_details_url__', 'value' => '', 'description' => '/customer-profile-quotation-list-items?order_id=:id', 'for_admin' => false]),
                        new EventVariable(['name' => '__admin_order_details_url__', 'value' => '', 'description' => '/admin/order-line?order_line_id=:id', 'for_admin' => true]),
                    ],
                    'eventRecipents' => [
                        new EventRecipent(['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator', 'enabled' => true]),
                        new EventRecipent(['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer', 'enabled' => true]),
                        new EventRecipent(['name' => 'Business_Contact', 'event_action_field' => 'is_get_customer_business_contact', 'description' => 'Customer Business Contact', 'enabled' => true]),
                        new EventRecipent(['name' => 'Contact', 'event_action_field' => 'is_get_contact', 'description' => 'Contact', 'enabled' => true]),
                    ],
                ],
                [
                    'name' => 'Draft Order Received',
                    'code' => 'draft_received',
                    'enabled' => true,
                    'description' => 'Draft Order Received',
                    'eventVariables' => [
                        new EventVariable(['name' => '__customer_name__', 'value' => '', 'description' => 'Name of the customer', 'for_admin' => false]),
                        new EventVariable(['name' => '__contact_name__', 'value' => '', 'description' => 'Name of the contact', 'for_admin' => false]),
                        new EventVariable(['name' => '__logged_in_user_name__', 'value' => '', 'description' => 'Name of the logged in user', 'for_admin' => false]),
                        new EventVariable(['name' => '__web_order_number__', 'value' => '', 'description' => 'Web Order Number', 'for_admin' => false]),
                        new EventVariable(['name' => '__total_amount__', 'value' => '', 'description' => 'Order Total Amount', 'for_admin' => false]),
                        new EventVariable(['name' => '__notes__', 'value' => '', 'description' => 'Order Notes', 'for_admin' => false]),
                        new EventVariable(['name' => '__customer_order_details_url__', 'value' => '', 'description' => '/customer-profile-order-list-items?order_id=:id', 'for_admin' => false]),
                        new EventVariable(['name' => '__customer_quotation_details_url__', 'value' => '', 'description' => '/customer-profile-quotation-list-items?order_id=:id', 'for_admin' => false]),
                        new EventVariable(['name' => '__admin_order_details_url__', 'value' => '', 'description' => '/admin/order-line?order_line_id=:id', 'for_admin' => true]),
                    ],
                    'eventRecipents' => [
                        new EventRecipent(['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Admcontactinistrator', 'enabled' => true]),
                        new EventRecipent(['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer', 'enabled' => true]),
                        new EventRecipent(['name' => 'Business_Contact', 'event_action_field' => 'is_get_customer_business_contact', 'description' => 'Customer Business Contact', 'enabled' => true]),
                        new EventRecipent(['name' => 'Contact', 'event_action_field' => 'is_get_contact', 'description' => 'Contact', 'enabled' => true]),
                    ],
                ],
                [
                    'name' => 'Order Notes Updated',
                    'code' => 'order_notes_updated',
                    'enabled' => true,
                    'description' => 'Order Notes Updated',
                    'eventVariables' => [
                        new EventVariable(['name' => '__customer_name__', 'value' => '', 'description' => 'Name of the customer', 'for_admin' => false]),
                        new EventVariable(['name' => '__contact_name__', 'value' => '', 'description' => 'Name of the contact', 'for_admin' => false]),
                        new EventVariable(['name' => '__logged_in_user_name__', 'value' => '', 'description' => 'Name of the logged in user', 'for_admin' => false]),
                        new EventVariable(['name' => '__web_order_number__', 'value' => '', 'description' => 'Web Order Number', 'for_admin' => false]),
                        new EventVariable(['name' => '__total_amount__', 'value' => '', 'description' => 'Order Total Amount', 'for_admin' => false]),
                        new EventVariable(['name' => '__notes__', 'value' => '', 'description' => 'Order Notes', 'for_admin' => false]),
                        new EventVariable(['name' => '__customer_order_details_url__', 'value' => '', 'description' => '/customer-profile-order-list-items?order_id=:id', 'for_admin' => false]),
                        new EventVariable(['name' => '__customer_quotation_details_url__', 'value' => '', 'description' => '/customer-profile-quotation-list-items?order_id=:id', 'for_admin' => false]),
                        new EventVariable(['name' => '__admin_order_details_url__', 'value' => '', 'description' => '/admin/order-line?order_line_id=:id', 'for_admin' => true]),
                    ],
                    'eventRecipents' => [
                        new EventRecipent(['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator', 'enabled' => true]),
                        new EventRecipent(['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer', 'enabled' => true]),
                        new EventRecipent(['name' => 'Business_Contact', 'event_action_field' => 'is_get_customer_business_contact', 'description' => 'Customer Business Contact', 'enabled' => true]),
                        new EventRecipent(['name' => 'Contact', 'event_action_field' => 'is_get_contact', 'description' => 'Contact', 'enabled' => true]),
                    ],
                ],
                [
                    'name' => 'Quotation Received',
                    'code' => 'quotation_received',
                    'enabled' => true,
                    'description' => 'Quotation Received',
                    'eventVariables' => [
                        new EventVariable(['name' => '__customer_name__', 'value' => '', 'description' => 'Name of the customer', 'for_admin' => false]),
                        new EventVariable(['name' => '__contact_name__', 'value' => '', 'description' => 'Name of the contact', 'for_admin' => false]),
                        new EventVariable(['name' => '__logged_in_user_name__', 'value' => '', 'description' => 'Name of the logged in user', 'for_admin' => false]),
                        new EventVariable(['name' => '__web_order_number__', 'value' => '', 'description' => 'Web Order Number', 'for_admin' => false]),
                        new EventVariable(['name' => '__total_amount__', 'value' => '', 'description' => 'Order Total Amount', 'for_admin' => false]),
                        new EventVariable(['name' => '__notes__', 'value' => '', 'description' => 'Order Notes', 'for_admin' => false]),
                        new EventVariable(['name' => '__customer_order_details_url__', 'value' => '', 'description' => '/customer-profile-order-list-items?order_id=:id', 'for_admin' => false]),
                        new EventVariable(['name' => '__customer_quotation_details_url__', 'value' => '', 'description' => '/customer-profile-quotation-list-items?order_id=:id', 'for_admin' => false]),
                        new EventVariable(['name' => '__admin_order_details_url__', 'value' => '', 'description' => '/admin/order-line?order_line_id=:id', 'for_admin' => true]),
                    ],
                    'eventRecipents' => [
                        new EventRecipent(['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator', 'enabled' => true]),
                        new EventRecipent(['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer', 'enabled' => true]),
                        new EventRecipent(['name' => 'Business_Contact', 'event_action_field' => 'is_get_customer_business_contact', 'description' => 'Customer Business Contact', 'enabled' => true]),
                        new EventRecipent(['name' => 'Contact', 'event_action_field' => 'is_get_contact', 'description' => 'Contact', 'enabled' => true]),
                    ],
                ],
                [
                    'name' => 'Catalog Changed',
                    'code' => 'catalog_changed',
                    'enabled' => true,
                    'description' => 'Catalog Changed',
                    'eventVariables' => [
                    ],
                    'eventRecipents' => [
                        new EventRecipent(['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator', 'enabled' => true]),
                    ],
                ],
                [
                    'name' => 'Password Reset',
                    'code' => 'reset_password',
                    'enabled' => true,
                    'description' => 'Contact Account Password Reset',
                    'eventVariables' => [
                        new EventVariable(['name' => '__otp__', 'value' => '', 'description' => 'One Time Password', 'for_admin' => false]),
                    ],
                    'eventRecipents' => [
                        new EventRecipent(['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer', 'enabled' => true]),
                    ],
                ],
                [
                    'name' => 'Order Rule Checked',
                    'code' => 'order_rule_checked',
                    'enabled' => true,
                    'description' => 'Customer Order Rule Checked',
                    'eventVariables' => [
                        new EventVariable(['name' => '__approver_name__', 'value' => '', 'description' => 'Name of the approver', 'for_admin' => false]),
                        new EventVariable(['name' => '__web_order_number__', 'value' => '', 'description' => 'Web order number', 'for_admin' => false]),
                        new EventVariable(['name' => '__customer_order_approval_details_url__', 'value' => '', 'description' => '/order-approvals/:id', 'for_admin' => false]),
                    ],
                    'eventRecipents' => [
                        new EventRecipent(['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator', 'enabled' => true]),
                        new EventRecipent(['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer', 'enabled' => true]),
                        new EventRecipent(['name' => 'Business_Contact', 'event_action_field' => 'is_get_customer_business_contact', 'description' => 'Customer Business Contact', 'enabled' => true]),
                        new EventRecipent(['name' => 'Approver', 'event_action_field' => 'is_get_contact', 'description' => 'Approver', 'enabled' => true]),
                    ],
                ],
                [
                    'name' => 'Order Waiting Approval',
                    'code' => 'order_waiting_approval',
                    'enabled' => true,
                    'description' => 'Customer Order Waiting Approval',
                    'eventVariables' => [
                        new EventVariable(['name' => '__contact_name__', 'value' => '', 'description' => 'Name of the contact', 'for_admin' => false]),
                        new EventVariable(['name' => '__web_order_number__', 'value' => '', 'description' => 'Web order number', 'for_admin' => false]),
                        new EventVariable(['name' => '__customer_order_approval_details_url__', 'value' => '', 'description' => '/order-approvals/:id', 'for_admin' => false]),
                    ],
                    'eventRecipents' => [
                        new EventRecipent(['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator', 'enabled' => true]),
                        new EventRecipent(['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer', 'enabled' => true]),
                        new EventRecipent(['name' => 'Business_Contact', 'event_action_field' => 'is_get_customer_business_contact', 'description' => 'Customer Business Contact', 'enabled' => true]),
                        new EventRecipent(['name' => 'Contact', 'event_action_field' => 'is_get_contact', 'description' => 'Contact', 'enabled' => true]),
                    ],
                ],
                [
                    'name' => 'Order Request Approved',
                    'code' => 'order_request_approved',
                    'enabled' => true,
                    'description' => 'Customer Order Request Approved',
                    'eventVariables' => [
                        new EventVariable(['name' => '__contact_name__', 'value' => '', 'description' => 'Name of the contact', 'for_admin' => false]),
                        new EventVariable(['name' => '__web_order_number__', 'value' => '', 'description' => 'Web order number', 'for_admin' => false]),
                        new EventVariable(['name' => '__status_notes__', 'value' => '', 'description' => 'Order approval notes', 'for_admin' => false]),
                        new EventVariable(['name' => '__customer_order_approval_details_url__', 'value' => '', 'description' => '/order-approvals/:id', 'for_admin' => false]),
                    ],
                    'eventRecipents' => [
                        new EventRecipent(['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator', 'enabled' => true]),
                        new EventRecipent(['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer', 'enabled' => true]),
                        new EventRecipent(['name' => 'Business_Contact', 'event_action_field' => 'is_get_customer_business_contact', 'description' => 'Customer Business Contact', 'enabled' => true]),
                        new EventRecipent(['name' => 'Contact', 'event_action_field' => 'is_get_contact', 'description' => 'Contact', 'enabled' => true]),
                    ],
                ],
                [
                    'name' => 'Order Request Rejected',
                    'code' => 'order_request_rejected',
                    'enabled' => true,
                    'description' => 'Customer Order Request Rejected',
                    'eventVariables' => [
                        new EventVariable(['name' => '__contact_name__', 'value' => '', 'description' => 'Name of the contact', 'for_admin' => false]),
                        new EventVariable(['name' => '__web_order_number__', 'value' => '', 'description' => 'Web order number', 'for_admin' => false]),
                        new EventVariable(['name' => '__status_notes__', 'value' => '', 'description' => 'Order rejection notes', 'for_admin' => false]),
                        new EventVariable(['name' => '__customer_order_approval_details_url__', 'value' => '', 'description' => '/order-approvals/:id', 'for_admin' => false]),
                    ],
                    'eventRecipents' => [
                        new EventRecipent(['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator', 'enabled' => true]),
                        new EventRecipent(['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer', 'enabled' => true]),
                        new EventRecipent(['name' => 'Business_Contact', 'event_action_field' => 'is_get_customer_business_contact', 'description' => 'Customer Business Contact', 'enabled' => true]),
                        new EventRecipent(['name' => 'Contact', 'event_action_field' => 'is_get_contact', 'description' => 'Contact', 'enabled' => true]),
                    ],
                ],
                [
                    'name' => 'Custom Coil Request Received',
                    'code' => 'custom_coil_order_received',
                    'enabled' => true,
                    'description' => 'Custom Coil Request Received',
                    'eventVariables' => [
                        // Contact info.
                        new EventVariable(['name' => '__contact_name__', 'value' => '', 'description' => 'Name of the contact', 'for_admin' => false]),
                        new EventVariable(['name' => '__method_of_contact__', 'value' => '', 'description' => 'Method of contact', 'for_admin' => false]),
                        new EventVariable(['name' => '__company_name__', 'value' => '', 'description' => 'Company name', 'for_admin' => false]),
                        new EventVariable(['name' => '__country__', 'value' => '', 'description' => 'Country', 'for_admin' => false]),
                        new EventVariable(['name' => '__city__', 'value' => '', 'description' => 'City', 'for_admin' => false]),
                        new EventVariable(['name' => '__state__', 'value' => '', 'description' => 'State', 'for_admin' => false]),
                        new EventVariable(['name' => '__zipcode__', 'value' => '', 'description' => 'Zip Code', 'for_admin' => false]),
                        new EventVariable(['name' => '__address__', 'value' => '', 'description' => 'Address', 'for_admin' => false]),

                        // Measurement info.
                        new EventVariable(['name' => '__finned_width__', 'value' => '', 'description' => 'Finned width', 'for_admin' => false]),
                        new EventVariable(['name' => '__finned_height__', 'value' => '', 'description' => 'Finned height', 'for_admin' => false]),
                        new EventVariable(['name' => '__finned_length__', 'value' => '', 'description' => 'finned length', 'for_admin' => false]),
                        new EventVariable(['name' => '__casing_width__', 'value' => '', 'description' => 'Casing width', 'for_admin' => false]),
                        new EventVariable(['name' => '__casing_height__', 'value' => '', 'description' => 'Casing height', 'for_admin' => false]),
                        new EventVariable(['name' => '__front_flang_elength__', 'value' => '', 'description' => 'Front flang elength', 'for_admin' => false]),
                        new EventVariable(['name' => '__back_flange_length__', 'value' => '', 'description' => 'Back flange length', 'for_admin' => false]),

                        new EventVariable(['name' => '__coil_is_coated__', 'value' => '', 'description' => 'Coil is coated or not status', 'for_admin' => false]),
                        new EventVariable(['name' => '__copper_tube__', 'value' => '', 'description' => 'Copper tube', 'for_admin' => false]),
                        new EventVariable(['name' => '__number_of_fins_per_inc__', 'value' => '', 'description' => 'Number of fins per inc', 'for_admin' => false]),
                        new EventVariable(['name' => '__number_of_tubes__', 'value' => '', 'description' => 'Number of tubes', 'for_admin' => false]),

                        // Requested Qty and Notes.
                        new EventVariable(['name' => '__requested_quantity__', 'value' => '', 'description' => 'Customer requested quantity', 'for_admin' => false]),
                        new EventVariable(['name' => '__notes__', 'value' => '', 'description' => 'Customer notes', 'for_admin' => false]),
                    ],
                    'eventRecipents' => [
                        new EventRecipent(['name' => 'Salesperson', 'event_action_field' => 'is_get_salesperson', 'description' => 'Send email to salesperson', 'enabled' => true]),
                    ],
                ],
                [
                    'name' => 'Model / Serial Number Research',
                    'code' => 'model_serial_number_research',
                    'enabled' => true,
                    'description' => 'MODEL / SERIAL NUMBER RESEARCH',
                    'eventVariables' => [
                        new EventVariable(['name' => '__manufacturer_name__', 'value' => '', 'description' => 'Manufacturer Name', 'for_admin' => false]),
                        new EventVariable(['name' => '__model_number__', 'value' => '', 'description' => 'Model Number', 'for_admin' => false]),
                        new EventVariable(['name' => '__serial_number__', 'value' => '', 'description' => 'Serial Number', 'for_admin' => false]),
                        new EventVariable(['name' => '__part_description__', 'value' => '', 'description' => 'Part Description', 'for_admin' => false]),
                        new EventVariable(['name' => '__account_or_business_name__', 'value' => '', 'description' => 'Your Account # or Business Name', 'for_admin' => false]),
                        new EventVariable(['name' => '__zip_code__', 'value' => '', 'description' => 'Your ZIP Code', 'for_admin' => false]),
                        new EventVariable(['name' => '__method_of_contact__', 'value' => '', 'description' => 'Method of Contact (phone / email)', 'for_admin' => false]),
                    ],
                    'eventRecipents' => [
                        new EventRecipent(['name' => 'Salesperson', 'event_action_field' => 'is_get_salesperson', 'description' => 'Send email to salesperson', 'enabled' => true]),
                    ],
                ],
                [
                    'name' => 'Contact Account Request Received',
                    'code' => 'contact_account_request_received',
                    'enabled' => true,
                    'description' => 'Contact Account Request Received',
                    'eventVariables' => [
                        new EventVariable(['name' => '__account_number__', 'value' => '', 'description' => 'Customer ERP Code of the contact asking for logins', 'for_admin' => false]),
                        new EventVariable(['name' => '__email_address__', 'value' => '', 'description' => 'Email Address for new contact login', 'for_admin' => false]),
                        new EventVariable(['name' => '__full_name__', 'value' => '', 'description' => 'Name of the Contact asking for logins', 'for_admin' => false]),
                        new EventVariable(['name' => '__contacts_details_url_for_account_request_received__', 'value' => '', 'description' => '/admin/contact/:id/edit', 'for_admin' => false]),
                    ],
                    'eventRecipents' => [
                        new EventRecipent(['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator', 'enabled' => true]),
                        new EventRecipent(['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer', 'enabled' => true]),
                        new EventRecipent(['name' => 'Business_Contact', 'event_action_field' => 'is_get_customer_business_contact', 'description' => 'Customer Business Contact', 'enabled' => true]),
                        new EventRecipent(['name' => 'Contact', 'event_action_field' => 'is_get_contact', 'description' => 'Contact', 'enabled' => true]),
                    ],
                ],
                [
                    'name' => 'Contact Account Request Accepted',
                    'code' => 'contact_account_request_accepted',
                    'enabled' => true,
                    'description' => 'Contact Account Request Accepted',
                    'eventVariables' => [
                        new EventVariable(['name' => '__account_number__', 'value' => '', 'description' => 'Customer ERP Code of the contact asking for logins', 'for_admin' => false]),
                        new EventVariable(['name' => '__email_address__', 'value' => '', 'description' => 'Email Address for new contact login', 'for_admin' => false]),
                        new EventVariable(['name' => '__full_name__', 'value' => '', 'description' => 'Name of the Contact asking for logins', 'for_admin' => false]),
                        new EventVariable(['name' => '__contacts_details_url_for_account_request_accepted__', 'value' => '', 'description' => '/admin/contact/:id/show', 'for_admin' => false]),
                    ],
                    'eventRecipents' => [
                        new EventRecipent(['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator', 'enabled' => true]),
                        new EventRecipent(['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer', 'enabled' => true]),
                        new EventRecipent(['name' => 'Business_Contact', 'event_action_field' => 'is_get_customer_business_contact', 'description' => 'Customer Business Contact', 'enabled' => true]),
                        new EventRecipent(['name' => 'Contact', 'event_action_field' => 'is_get_contact', 'description' => 'Contact', 'enabled' => true]),
                    ],
                ],
                [
                    'name' => 'Create Order From Quotation',
                    'code' => 'create_order_from_quotation',
                    'enabled' => true,
                    'description' => 'Create Order From Quotation',
                    'eventVariables' => [
                        new EventVariable(['name' => '__erp_quote_number__', 'value' => '', 'description' => 'Quote Number', 'for_admin' => false]),
                        new EventVariable(['name' => '__contact_name__', 'value' => '', 'description' => 'Name of the contact', 'for_admin' => false]),
                        new EventVariable(['name' => '__customer_name__', 'value' => '', 'description' => 'Name of the customer', 'for_admin' => false]),
                        new EventVariable(['name' => '__shipping_address__', 'value' => '', 'description' => 'ERP order number', 'for_admin' => false]),
                        new EventVariable(['name' => '__total_amount__', 'value' => '', 'description' => 'Quotation Total Amount', 'for_admin' => false]),
                        new EventVariable(['name' => '__notes__', 'value' => '', 'description' => 'Customer notes', 'for_admin' => false]),
                        new EventVariable(['name' => '__po_number__', 'value' => '', 'description' => 'PO Number provided by customer', 'for_admin' => false]),
                        new EventVariable(['name' => '__shipping_method__', 'value' => '', 'description' => 'Shipping method selected', 'for_admin' => false]),
                        new EventVariable(['name' => '__special_instruction__', 'value' => '', 'description' => 'Special instructions added by customer', 'for_admin' => false]),
                        new EventVariable(['name' => '__customer_quotation_details__', 'value' => '', 'description' => 'Details Table', 'for_admin' => false]),
                    ],
                    'eventRecipents' => [
                        new EventRecipent(['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator', 'enabled' => false]),
                        new EventRecipent(['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer', 'enabled' => false]),
                        new EventRecipent(['name' => 'Business_Contact', 'event_action_field' => 'is_get_customer_business_contact', 'description' => 'Customer Business Contact', 'enabled' => false]),
                        new EventRecipent(['name' => 'Contact', 'event_action_field' => 'is_get_contact', 'description' => 'Contact', 'enabled' => false]),
                        new EventRecipent(['name' => 'Sales Person', 'event_action_field' => 'is_get_salesperson', 'description' => 'Contact', 'enabled' => false]),
                        new EventRecipent(['name' => 'Quotation Sales Person', 'event_action_field' => 'is_quote_sales_person', 'description' => 'ERP Sales Person', 'enabled' => true]),
                    ],
                ],
            ];

            foreach ($events as $event) {
                $eventVariables = $event['eventVariables'] ?? [];
                unset($event['eventVariables']);
                $eventRecipents = $event['eventRecipents'] ?? [];
                unset($event['eventRecipents']);
                $eventModel = Event::create($event);
                $eventModel->eventVariables()->saveMany($eventVariables);
                $eventModel->eventRecipents()->saveMany($eventRecipents);
            }
        }
    }
}
