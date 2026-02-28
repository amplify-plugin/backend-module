<?php

namespace Amplify\System\Backend\Seeders;

use Amplify\System\Backend\Models\Event;
use Amplify\System\Backend\Models\EventRecipent;
use Amplify\System\Backend\Models\EventTemplate;
use Amplify\System\Backend\Models\EventVariable;
use Amplify\System\Traits\EventSeedTrait;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    use EventSeedTrait;

    public function withTruncate()
    {
        return true;
    }

    private function data()
    {
        return [
            [
                'name' => 'Registration Request Received',
                'code' => Event::REGISTRATION_REQUEST_RECEIVED,
                'enabled' => true,
                'description' => 'This event get triggered when a new retail customer apply on registration form.',
                'eventVariables' => [
                    // Existing variables
                    new EventVariable(['name' => '__full_name__', 'value' => '', 'description' => 'Name of the account', 'for_admin' => false]),
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
                'eventTemplates' => [
                    new EventTemplate([
                        'name' => '[Admin] Registration Request Received',
                        'subject' => 'New Customer Registration Request Received',
                        'email_body' => <<<'HTML'
<p>Dear System Administrator,</p>

<p>A new customer has registered on the __company_name__ platform and is currently awaiting account approval.</p>

<p>Please find the customer details below:</p>

<p>Account Name:&nbsp;__full_name__<br />
ERP Customer Number:&nbsp;__customer_code__<br />
Company Name:&nbsp;__customer_name__<br />
Email Address:&nbsp;__email_address__<br />
Phone Number:&nbsp;__phone_no__<br />
Registered Date:&nbsp;__timestamp__</p>

<p>Billing Address:</p>

<p>Address Name:&nbsp;__address_name__<br />
Street Address:&nbsp;__address_1__<br />
City:&nbsp;__city__<br />
State:&nbsp;__state__<br />
Postal Code:&nbsp;__zip_code__<br />
Country:&nbsp;__country_code__</p>

<p>Kindly review the submitted information and proceed with the account approval process.</p>

<p>Please let us know if any additional verification is required.</p>

<p>&nbsp;</p>

<p>Best regards,<br />
__company_name__</p>
HTML,
                        'show_button' => true,
                        'button_text' => 'Customer Details',
                        'button_url' => str_replace('{id}', ':id', route_uri('customer-registration.edit')),
                        'notification_type' => 'emailable',
                        'enabled' => true,
                    ]),
                    new EventTemplate([
                        'name' => '[Customer] Registration Received Notification',
                        'subject' => 'Your Account Registration is Under Review',
                        'email_body' => <<<'HTML'
<p>Dear <strong>__customer_name__</strong>,</p>

<p>Thank you for registering on our <strong>__company_name__</strong> platform.</p>

<p>Your account has been successfully created and is currently under review by our administration team. You will receive a confirmation email once your account has been approved.</p>

<p>We appreciate your patience during this process. If you have any urgent inquiries, please feel free to contact us.</p>

<p>&nbsp;</p>

<p>Best regards,<br />
__company_name__</p>
HTML,
                        'show_button' => false,
                        'notification_type' => 'emailable',
                        'enabled' => true,
                    ]),
                ],
            ],
            [
                'name' => 'Registration Request Accepted',
                'code' => Event::REGISTRATION_REQUEST_ACCEPTED,
                'enabled' => true,
                'description' => 'This event get triggered when from backend or by email verification registration request get approved.',
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
                'eventTemplates' => [
                    new EventTemplate([
                        'name' => '[Customer] Registration Request Approved',
                        'subject' => 'Your Account Has Been Approved – You May Now Login',
                        'email_body' => <<<'HTML'
<p>Dear __customer_name__,</p>

<p>We are pleased to inform you that your account registration request has been approved.</p>

<p>You may now log in to __company_name__ using your registered email address and password.</p>

<p>If you experience any difficulties accessing your account or have any questions, kindly contact the administrator for assistance.</p>

<p>We look forward to working with you.</p>

<p>&nbsp;</p>

<p>Best regards,<br />
__company_name__</p>
HTML,
                        'show_button' => true,
                        'button_text' => 'Account Login',
                        'button_url' => route_uri('frontend.login'),
                        'notification_type' => 'emailable',
                        'enabled' => true,
                    ]),
                ],
            ],
            [
                'name' => 'Order Received',
                'code' => Event::ORDER_RECEIVED,
                'enabled' => true,
                'description' => 'This events get triggered when we successfully received a order request on backend.',
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

                    new EventVariable(['name' => '__erp_order_number__', 'value' => '', 'description' => 'ERP Order Number', 'for_admin' => false]),
                    new EventVariable(['name' => '__contact_email__', 'value' => '', 'description' => 'Email of the contact', 'for_admin' => false]),

                    new EventVariable(['name' => '__billing_address_line_1__', 'value' => '', 'description' => 'Billing Address Line 1', 'for_admin' => false]),
                    new EventVariable(['name' => '__billing_address_line_2__', 'value' => '', 'description' => 'Billing Address Line 2', 'for_admin' => false]),
                    new EventVariable(['name' => '__billing_city__', 'value' => '', 'description' => 'Billing City', 'for_admin' => false]),
                    new EventVariable(['name' => '__billing_state__', 'value' => '', 'description' => 'Billing State', 'for_admin' => false]),
                    new EventVariable(['name' => '__billing_zip_code__', 'value' => '', 'description' => 'Billing Zip Code', 'for_admin' => false]),
                    new EventVariable(['name' => '__billing_country__', 'value' => '', 'description' => 'Billing Country', 'for_admin' => false]),

                    new EventVariable(['name' => '__shipping_address_line_1__', 'value' => '', 'description' => 'Shipping Address Line 1', 'for_admin' => false]),
                    new EventVariable(['name' => '__shipping_address_line_2__', 'value' => '', 'description' => 'Shipping Address Line 2', 'for_admin' => false]),
                    new EventVariable(['name' => '__shipping_city__', 'value' => '', 'description' => 'Shipping City', 'for_admin' => false]),
                    new EventVariable(['name' => '__shipping_state__', 'value' => '', 'description' => 'Shipping State', 'for_admin' => false]),
                    new EventVariable(['name' => '__shipping_zip_code__', 'value' => '', 'description' => 'Shipping Zip Code', 'for_admin' => false]),
                    new EventVariable(['name' => '__shipping_country__', 'value' => '', 'description' => 'Shipping Country', 'for_admin' => false]),

                    new EventVariable(['name' => '__order_suffix__', 'value' => '', 'description' => 'Order Suffix', 'for_admin' => false]),
                    new EventVariable(['name' => '__po_number__', 'value' => '', 'description' => 'Purchase Order Number', 'for_admin' => false]),
                    new EventVariable(['name' => '__order_status__', 'value' => '', 'description' => 'Order Status', 'for_admin' => false]),
                    new EventVariable(['name' => '__order_type__', 'value' => '', 'description' => 'Order Type', 'for_admin' => false]),
                    new EventVariable(['name' => '__invoice_amount__', 'value' => '', 'description' => 'Invoice Amount', 'for_admin' => false]),
                    new EventVariable(['name' => '__warehouse_code__', 'value' => '', 'description' => 'Warehouse Code', 'for_admin' => false]),
                    new EventVariable(['name' => '__entry_date__', 'value' => '', 'description' => 'Order Entry Date', 'for_admin' => false]),
                    new EventVariable(['name' => '__estimate_ship_date__', 'value' => '', 'description' => 'Estimated Ship Date', 'for_admin' => false]),
                    new EventVariable(['name' => '__order_details__', 'value' => '', 'description' => 'Order Details Table', 'for_admin' => false]),
                    new EventVariable(['name' => '__invoice_date__', 'value' => '', 'description' => 'Invoice Date', 'for_admin' => false]),
                    new EventVariable(['name' => '__carrier_code__', 'value' => '', 'description' => 'Carrier Code', 'for_admin' => false]),

                ],
                'eventRecipents' => [
                    new EventRecipent(['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator', 'enabled' => true]),
                    new EventRecipent(['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer', 'enabled' => true]),
                    new EventRecipent(['name' => 'Business_Contact', 'event_action_field' => 'is_get_customer_business_contact', 'description' => 'Customer Business Contact', 'enabled' => true]),
                    new EventRecipent(['name' => 'Contact', 'event_action_field' => 'is_get_contact', 'description' => 'Contact', 'enabled' => true]),
                ],
                'eventTemplates' => [],
            ],
            [
                'name' => 'Draft Order Received',
                'code' => Event::DRAFT_RECEIVED,
                'enabled' => true,
                'description' => 'This events get triggered When customer create a draft order or saved cart.',
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
                'eventTemplates' => [],
            ],
            [
                'name' => 'Order Notes Updated',
                'code' => Event::ORDER_NOTES_UPDATED,
                'enabled' => true,
                'description' => 'This events get triggered when from customer portal someone add or update a existing note on order.',
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
                'eventTemplates' => [],
            ],
            [
                'name' => 'Quotation Received',
                'code' => Event::QUOTATION_RECEIVED,
                'enabled' => true,
                'description' => 'This event get triggered when someone make a request for quote from existing cart.',
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
                'eventTemplates' => [],
            ],
            [
                'name' => 'Catalog Changed',
                'code' => Event::CATALOG_CHANGED,
                'enabled' => true,
                'description' => 'This event get triggered when scheduled program received changes the catalog/product.',
                'eventVariables' => [
                    new EventVariable(['name' => '__execution_date__', 'value' => '-', 'description' => 'The date of synchronization has been requested.', 'for_admin' => false]),
                    new EventVariable(['name' => '__started_at__', 'value' => '-', 'description' => 'The datetime synchronization started.', 'for_admin' => false]),
                    new EventVariable(['name' => '__ended_at__', 'value' => '-', 'description' => 'The datetime when synchronization ended.', 'for_admin' => false]),
                    new EventVariable(['name' => '__records__', 'value' => '-', 'description' => 'The list of product codes that has been synchronization.', 'for_admin' => false]),
                ],
                'eventRecipents' => [
                    new EventRecipent(['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator', 'enabled' => true]),
                ],
                'eventTemplates' => [
                    new EventTemplate([
                        'name' => '[Admin] Product catalog Updated',
                        'subject' => 'Schedule Product Catalog Synced with ERP Completed.',
                        'email_body' => <<<'HTML'
<p>Dear Administrator,</p> 
<p> This is to inform you that the scheduled catalog synchronization process for product 
attributes has been successfully executed and completed on the system. </p> 
<h3>Synchronization Details</h3> 
<table style="border-collapse: collapse; width:100%; max-width:600px;"> <tr> 
<td><b>Process Name:</b></td> 
<td>Product Attribute Catalog Synchronization</td> </tr> <tr> 
<td><b>Status:</b></td> 
<td>Completed Successfully</td> </tr> <tr> 
<td><b>Execution Date:</b></td> 
<td>__execution_date__</td> </tr> <tr> 
<td><b>Start Time:</b></td> <td>__started_at__</td> </tr> <tr> 
<td><b>End Time:</b></td> <td>__ended_at__</td> </tr> <tr> 
<td><b>Total Records Processed:</b></td> <td>__records__</td> </tr> 
</table> 

<p> No further action is required unless any inconsistencies are observed. </p> 
<p> If you require additional details or encounter any issues, please review the system logs or contact the system administrator. </p> 

<p>&nbsp;</p>

<p>Best regards,<br />
__company_name__ System Notification</p>
HTML,
                        'show_button' => true,
                        'button_text' => 'Catalog Synchronization',
                        'button_url' => route_uri('product-sync.index'),
                        'notification_type' => 'emailable',
                        'enabled' => true,
                    ]),
                ],
            ],
            [
                'name' => 'Password Reset',
                'code' => 'reset_password',
                'enabled' => true,
                'description' => 'This even get triggered when from customer portal someone requests to reset their password.',
                'eventVariables' => [
                    new EventVariable(['name' => '__otp__', 'value' => '', 'description' => 'One Time Password', 'for_admin' => false]),
                ],
                'eventRecipents' => [
                    new EventRecipent(['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer', 'enabled' => true]),
                ],
                'eventTemplates' => [],
            ],
            [
                'name' => 'Contact Account Request Received',
                'code' => Event::CONTACT_ACCOUNT_REQUEST_RECEIVED,
                'enabled' => true,
                'description' => 'This event get triggered when someone request for online access from customer portal.',
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
                'eventTemplates' => [
                    new EventTemplate([
                        'name' => '[Admin] Request Online Access Received',
                        'subject' => 'New Account Request Online Access Received',
                        'email_body' => <<<'HTML'
<p>Dear System Administrator,</p>

<p>A new customer has registered on the __company_name__ platform and is currently awaiting account approval.</p>

<p>Please find the customer details below:</p>

<p>Account Details:</p>

<p>Account Name:&nbsp;__full_name__<br />
ERP Customer Number:&nbsp;__customer_code__<br />
Company Name:&nbsp;__customer_name__<br />
Email Address:&nbsp;__email_address__<br />
Phone Number:&nbsp;__phone_no__<br />
Requested Date:&nbsp;__timestamp__</p>

<p>Kindly review the submitted information and proceed with the account approval process.</p>

<p>Please let us know if any additional verification is required.</p>

<p>&nbsp;</p>

<p>Best regards,<br />
__company_name__</p>
HTML,
                        'show_button' => true,
                        'button_text' => 'Contact Details',
                        'button_url' => str_replace('{id}', ':id', route_uri('contact-registration.edit')),
                        'notification_type' => 'emailable',
                        'enabled' => true,
                    ]),
                    new EventTemplate([
                        'name' => '[Customer] Request Online Access Received Notification',
                        'subject' => 'Your Request for Online Access is Under Review',
                        'email_body' => <<<'HTML'
<p>Dear <b>__full_name__</b>,</p>

<p>Thank you for registering on our <b>__company_name__</b> platform.</p>

<p>Your account has been successfully created and is currently under review by our administration team. You will receive a confirmation email once your account has been approved.</p>

<p>We appreciate your patience during this process. If you have any urgent inquiries, please feel free to contact us.</p>

<p>&nbsp;</p>

<p>Best regards,<br />
__company_name__</p>
HTML,
                        'show_button' => false,
                        'notification_type' => 'emailable',
                        'enabled' => true,
                    ]),
                ],
            ],
            [
                'name' => 'Contact Account Request Accepted',
                'code' => Event::CONTACT_ACCOUNT_REQUEST_ACCEPTED,
                'enabled' => true,
                'description' => 'This event get triggered when from admin panel or by email verification account got approved.',
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
                'eventTemplates' => [
                    new EventTemplate([
                        'name' => '[Customer] Request Online Access Approved',
                        'subject' => 'Your Account Has Been Approved – You May Now Login',
                        'email_body' => <<<'HTML'
<p>Dear __full_name__,</p>

<p>We are pleased to inform you that your account registration request has been approved.</p>

<p>You may now log in to __company_name__ using your registered email address and password.</p>

<p>If you experience any difficulties accessing your account or have any questions, kindly contact the administrator for assistance.</p>

<p>We look forward to working with you.</p>

<p>&nbsp;</p>

<p>Best regards,<br />
__company_name__</p>
HTML,
                        'show_button' => true,
                        'button_text' => 'Account Login',
                        'button_url' => route_uri('frontend.login'),
                        'notification_type' => 'emailable',
                        'enabled' => true,
                    ]),
                ],
            ],
            [
                'name' => 'Contact Account Request Verification',
                'code' => Event::CONTACT_ACCOUNT_REQUEST_VERIFICATION,
                'enabled' => true,
                'description' => 'This event get triggered when By configuration contexts are required to verify their email address before login.',
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
                'eventTemplates' => [
                    new EventTemplate([
                        'name' => '[Admin] Account Verification Requested',
                        'subject' => 'New Registered Account Requested Approval',
                        'email_body' => <<<'HTML'
<p>Dear System Administrator,</p>

<p>A new customer has registered on the __company_name__ platform and is currently awaiting account approval.</p>

<p>Please find the contact details below:</p>

<p>Account Name:&nbsp;__full_name__<br />
ERP Customer Number:&nbsp;__customer_code__<br />
Company Name:&nbsp;__customer_name__<br />
Email Address:&nbsp;__email_address__<br />
Phone Number:&nbsp;__phone_no__<br />
Registered Date:&nbsp;__timestamp__</p>

<p>Kindly review the submitted information and proceed with the account approval process.</p>

<p>&nbsp;</p>

<p>Best regards,<br />
__company_name__</p>
HTML,
                        'show_button' => true,
                        'button_text' => 'Account Details',
                        'button_url' => str_replace('{id}', ':id', route_uri('contact-registration.edit')),
                        'notification_type' => 'emailable',
                        'enabled' => true,
                    ]),
                    new EventTemplate([
                        'name' => '[Customer] Account Verification Requested',
                        'subject' => 'Please Verify Your Email Address to Complete Registration',
                        'email_body' => <<<'HTML'
<p>Dear __full_name__,</p>
<p>Thank you for registering with <b>__company_name__</b>.</p>
<p>Your account registration request has been successfully received. <br/>
To activate your account and gain access, please verify your email address by clicking on the verification link below: </p>
<p>__email_verification_url__</p>
<p> Once your email address is verified, you will be able to proceed with account access according to the approval process. <br/></p>
<p> If you experience any difficulties during verification or have any questions, please contact the administrator for assistance. <br/></p>

<p>&nbsp;</p>

<p>Best regards,<br />
__company_name__</p>
</p>
HTML,
                        'show_button' => true,
                        'button_text' => 'Verify Email',
                        'button_url' => str_replace(['{id}', '{hash}'], [':id', ':hash'], route_uri('frontend.verification.verify')),
                        'notification_type' => 'emailable',
                        'enabled' => true,
                    ]),
                ],
            ],
            [
                'name' => 'Create Order From Quotation',
                'code' => Event::CREATE_ORDER_FROM_QUOTATION,
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
                'eventTemplates' => [],
            ],
            [
                'name' => 'Customer Part Number Deleted',
                'code' => Event::CUSTOMER_PART_NUMBER_DELETED,
                'enabled' => true,
                'description' => 'Customer Part Number Deleted',
                'eventVariables' => [
                    new EventVariable(['name' => '__customer_name__', 'value' => '', 'description' => 'Name of the customer', 'for_admin' => false]),
                    new EventVariable(['name' => '__customer_code__', 'value' => '', 'description' => 'ERP Code of the customer', 'for_admin' => false]),
                    new EventVariable(['name' => '__product_code__', 'value' => '', 'description' => 'Product Real Code', 'for_admin' => false]),
                    new EventVariable(['name' => '__product_name__', 'value' => '', 'description' => 'Product Name', 'for_admin' => false]),
                    new EventVariable(['name' => '__customer_part_number__', 'value' => '', 'description' => 'Customer Part Number', 'for_admin' => false]),
                ],
                'eventRecipents' => [
                    new EventRecipent(['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator', 'enabled' => false]),
                    new EventRecipent(['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer', 'enabled' => false]),
                    new EventRecipent(['name' => 'Business_Contact', 'event_action_field' => 'is_get_customer_business_contact', 'description' => 'Customer Business Contact', 'enabled' => false]),
                    new EventRecipent(['name' => 'Sales Person', 'event_action_field' => 'is_get_salesperson', 'description' => 'Contact', 'enabled' => false]),
                ],
                'eventTemplates' => [],
            ],
            [
                'name' => 'Customer Registration Report Generated',
                'code' => Event::CUSTOMER_REGISTRATION_REPORT_GENERATED,
                'enabled' => true,
                'description' => 'This event get triggered on when system generate customer report created by system.',
                'eventVariables' => [
                    new EventVariable(['name' => '__interval_in_days__', 'value' => '', 'description' => 'Number of days report is generated', 'for_admin' => false]),
                    new EventVariable(['name' => '__report_start_date__', 'value' => '', 'description' => 'Date from report started', 'for_admin' => false]),
                    new EventVariable(['name' => '__report_end_date__', 'value' => 'Date from report end', 'description' => 'Product Real Code', 'for_admin' => false]),
                ],
                'eventRecipents' => [
                    new EventRecipent(['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator', 'enabled' => false]),
                ],
                'eventTemplates' => [
                    new EventTemplate([
                        'name' => '[Admin] Customer Registered Report Generated',
                        'subject' => 'New Customer Count Report From __report_start_date__ To __report_end_date__',
                        'email_body' => <<<'HTML'
<p>Dear System Administrator,</p>

<p>This is an automated system generated mail to provide you a list of new customers that has registered to the system.</p>

<p><strong>Report Information:</strong></p>

<p><strong>Start Date:</strong>__report_start_date__</p>

<p><strong>End Date:</strong> __report_end_date__</p>

<p>&nbsp;</p>

<p>Best regards,<br />
__company_name__</p>
HTML,
                        'notification_type' => 'emailable',
                        'enabled' => true,
                    ]),
                ],
            ],
            [
                'name' => 'Notify to department on new support ticket',
                'code' => Event::TICKET_CREATED,
                'enabled' => true,
                'description' => 'These event get triggered when a customer creates a helpdesk ticker from customer portal.',
                'eventVariables' => [
                    new EventVariable(['name' => '__ticket_content__', 'value' => '', 'description' => 'Support Ticket Content', 'for_admin' => false]),
                    new EventVariable(['name' => '__ticket_subject__', 'value' => '', 'description' => 'Support Ticket Subject', 'for_admin' => false]),
                    new EventVariable(['name' => '__ticket_priority__', 'value' => '', 'description' => 'Support Ticket Priority', 'for_admin' => false]),
                    new EventVariable(['name' => '__ticket_department__', 'value' => '', 'description' => 'Support Ticket Department', 'for_admin' => false]),
                    new EventVariable(['name' => '__ticket_url__', 'value' => '', 'description' => 'Support Ticket URL', 'for_admin' => true]),
                ],
                'eventRecipents' => [
                    new EventRecipent(['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator', 'enabled' => true]),
                    new EventRecipent(['name' => 'Contact', 'event_action_field' => 'is_get_contact', 'description' => 'Contact', 'enabled' => true]),
                    new EventRecipent(['name' => 'Ticket Department', 'event_action_field' => 'is_get_contact', 'description' => 'Ticket Department', 'enabled' => true]),
                ],
                'eventTemplates' => [],
            ],
        ];
    }
}
