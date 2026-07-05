<?php

namespace Amplify\System\Backend\Seeders;

use Amplify\System\Backend\Models\Event;
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
                    ['name' => '__full_name__', 'description' => 'Name of the account'],
                    ['name' => '__customer_name__', 'description' => 'Name of the customer'],
                    ['name' => '__customer_code__', 'description' => 'Customer Code of the customer'],
                    ['name' => '__customer_email__', 'description' => 'Email of the customer'],
                    ['name' => '__customer_phone__', 'description' => 'Phone Number of the customer'],
                    ['name' => '__industry_classification__', 'description' => 'Industry Classification of the customer'],
                    ['name' => '__address_1__', 'description' => 'Address Line 1'],
                    ['name' => '__address_2__', 'description' => 'Address Line 2'],
                    ['name' => '__address_3__', 'description' => 'Address Line 3'],
                    ['name' => '__country_code__', 'description' => 'Country Code'],
                    ['name' => '__city__', 'description' => 'City'],
                    ['name' => '__state__', 'description' => 'State'],
                    ['name' => '__zip_code__', 'description' => 'Zip Code'],
                    ['name' => '__customer_details_url_for_request_received__', 'description' => '/admin/customer-registration/:id/show'],
                    ['name' => '__customer_details_url_for_request_accepted__', 'description' => '/admin/customer/:id/show'],
                ],
                'eventRecipents' => [
                    ['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator'],
                    ['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer'],
                ],
                'eventTemplates' => [
                    [
                        'name' => '[Admin] Registration Request Received Notification',
                        'subject' => 'New Customer Registration Request Received',
                        'email_body' => <<<'HTML'
<p>Dear System Administrator,</p>
<p>A new customer has registered on the __company_name__ platform and is currently awaiting account approval.</p>
<p>Please find the customer details below:</p>
<p>Account Name:&nbsp;__full_name__<br />
ERP Customer Number:&nbsp;__customer_code__<br />
Company Name:&nbsp;__customer_name__<br />
Email Address:&nbsp;__customer_email__<br />
Phone Number:&nbsp;__customer_phone__<br />
Registered Date:&nbsp;__timestamp__</p>
<p>Billing Address:</p>
Address Line 1:&nbsp;__address_1__<br />
Address Line 2:&nbsp;__address_2__<br />
Address Line 3:&nbsp;__address_3__<br />
City:&nbsp;__city__<br />
State:&nbsp;__state_name__ (__state_code__)<br />
Postal Code:&nbsp;__zip_code__<br />
Country:&nbsp;__country_name__ (__country_code__)</p>
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
                    ],
                    [
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
                    ],
                ],
            ],
            [
                'name' => 'Registration Request Accepted',
                'code' => Event::REGISTRATION_REQUEST_ACCEPTED,
                'enabled' => true,
                'description' => 'This event get triggered when from backend or by email verification registration request get approved.',
                'eventVariables' => [
                    ['name' => '__customer_name__', 'description' => 'Name of the customer'],
                    ['name' => '__customer_details_url_for_request_received__', 'description' => '/admin/customer-registration/:id/show'],
                    ['name' => '__customer_details_url_for_request_accepted__', 'description' => '/admin/customer/:id/show'],
                ],
                'eventRecipents' => [
                    ['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator'],
                    ['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer'],
                    ['name' => 'Business_Contact', 'event_action_field' => 'is_get_customer_business_contact', 'description' => 'Customer Business Contact'],
                    ['name' => 'Contact', 'event_action_field' => 'is_get_contact', 'description' => 'Contact'],
                ],
                'eventTemplates' => [
                    [
                        'name' => '[Customer] Registration Request Approved Notification',
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
                    ],
                ],
            ],
            [
                'name' => 'Order Received',
                'code' => Event::ORDER_RECEIVED,
                'enabled' => true,
                'description' => 'This events get triggered when we successfully received a order request on backend.',
                'eventVariables' => [
                    ['name' => '__customer_name__', 'description' => 'Name of the customer'],
                    ['name' => '__contact_name__', 'description' => 'Name of the contact'],
                    ['name' => '__logged_in_user_name__', 'description' => 'Name of the logged in user'],
                    ['name' => '__web_order_number__', 'description' => 'Web Order Number'],
                    ['name' => '__total_amount__', 'description' => 'Order Total Amount'],
                    ['name' => '__notes__', 'description' => 'Order Notes'],
                    ['name' => '__customer_order_details_url__', 'description' => '/customer-profile-order-list-items?order_id=:id'],
                    ['name' => '__customer_quotation_details_url__', 'description' => '/customer-profile-quotation-list-items?order_id=:id'],
                    ['name' => '__admin_order_details_url__', 'description' => '/admin/order/:id/show'],

                    ['name' => '__erp_order_number__', 'description' => 'ERP Order Number'],
                    ['name' => '__contact_email__', 'description' => 'Email of the contact'],

                    ['name' => '__billing_address_line_1__', 'description' => 'Billing Address Line 1'],
                    ['name' => '__billing_address_line_2__', 'description' => 'Billing Address Line 2'],
                    ['name' => '__billing_city__', 'description' => 'Billing City'],
                    ['name' => '__billing_state__', 'description' => 'Billing State'],
                    ['name' => '__billing_zip_code__', 'description' => 'Billing Zip Code'],
                    ['name' => '__billing_country__', 'description' => 'Billing Country'],

                    ['name' => '__shipping_address_line_1__', 'description' => 'Shipping Address Line 1'],
                    ['name' => '__shipping_address_line_2__', 'description' => 'Shipping Address Line 2'],
                    ['name' => '__shipping_city__', 'description' => 'Shipping City'],
                    ['name' => '__shipping_state__', 'description' => 'Shipping State'],
                    ['name' => '__shipping_zip_code__', 'description' => 'Shipping Zip Code'],
                    ['name' => '__shipping_country__', 'description' => 'Shipping Country'],

                    ['name' => '__order_suffix__', 'description' => 'Order Suffix'],
                    ['name' => '__po_number__', 'description' => 'Purchase Order Number'],
                    ['name' => '__order_status__', 'description' => 'Order Status'],
                    ['name' => '__order_type__', 'description' => 'Order Type'],
                    ['name' => '__invoice_amount__', 'description' => 'Invoice Amount'],
                    ['name' => '__warehouse_code__', 'description' => 'Warehouse Code'],
                    ['name' => '__entry_date__', 'description' => 'Order Entry Date'],
                    ['name' => '__estimate_ship_date__', 'description' => 'Estimated Ship Date'],
                    ['name' => '__order_details__', 'description' => 'Order Details Table'],
                    ['name' => '__invoice_date__', 'description' => 'Invoice Date'],
                    ['name' => '__carrier_code__', 'description' => 'Carrier Code'],

                ],
                'eventRecipents' => [
                    ['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator'],
                    ['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer'],
                    ['name' => 'Business_Contact', 'event_action_field' => 'is_get_customer_business_contact', 'description' => 'Customer Business Contact'],
                    ['name' => 'Contact', 'event_action_field' => 'is_get_contact', 'description' => 'Contact'],
                ],
                'eventTemplates' => [
                    [
                        'name' => '[Admin] Order Confirmation Notification',
                        'subject' => 'New Order Received',
                        'email_body' => <<<'HTML'
<p>Dear System Administrator,</p>
<p>
    System received an order successfully and is currently being processed.
</p>

<h3>Order Summary</h3>
<table style="border-collapse: collapse; width:100%; max-width:500px;">
    <tr>
        <td><strong>Order Number:</strong></td>
        <td>__erp_order_number__</td>
    </tr>
    <tr>
        <td><strong>Order Date:</strong></td>
        <td>__entry_date__</td>
    </tr>
    <tr>
        <td><strong>Total Amount:</strong></td>
        <td>__total_amount__</td>
    </tr>
    <tr>
        <td><strong>Order Status:</strong></td>
        <td>__order_status__</td>
    </tr>
</table>

<p style="margin: 25px 0;">You can view complete order details by clicking the button below:</p>

<p>__admin_order_details_url__</p>

<p>If you have any questions or require assistance, please contact the administrator.</p>

<p>&nbsp;</p>

<p>Best regards,<br />
__company_name__</p>
HTML,
                        'show_button' => true,
                        'button_text' => 'View Order Details',
                        'button_url' => '__admin_order_details_url__',
                        'notification_type' => 'emailable',
                        'enabled' => true,
                    ],
                    [
                        'name' => '[Customer] Order Confirmation Notification',
                        'subject' => 'Order Confirmation – Thank You for Your Purchase',
                        'email_body' => <<<'HTML'
<p>Dear __customer_name__,</p>
<p>
    Thank you for your order with <strong>__company_name__</strong>.  
    Your order has been successfully received and is currently being processed.
</p>

<h3>Order Summary</h3>
<table style="border-collapse: collapse; width:100%; max-width:500px;">
    <tr>
        <td><strong>Order Number:</strong></td>
        <td>__erp_order_number__</td>
    </tr>
    <tr>
        <td><strong>Order Date:</strong></td>
        <td>__entry_date__</td>
    </tr>
    <tr>
        <td><strong>Total Amount:</strong></td>
        <td>__total_amount__</td>
    </tr>
    <tr>
        <td><strong>Order Status:</strong></td>
        <td>__order_status__</td>
    </tr>
</table>

<p style="margin: 25px 0;">You can view complete order details by clicking the button below:</p>

<p>__customer_order_details_url__</p>

<p>If you have any questions or require assistance, please contact the administrator.</p>

<p>&nbsp;</p>

<p>Best regards,<br />
__company_name__</p>
HTML,
                        'show_button' => true,
                        'button_text' => 'View Order Details',
                        'button_url' => '/orders/:id',
                        'notification_type' => 'emailable',
                        'enabled' => true,
                    ],
                ],
            ],
            [
                'name' => 'Draft Order Received',
                'code' => Event::DRAFT_RECEIVED,
                'enabled' => true,
                'description' => 'This events get triggered When customer create a draft order or saved cart.',
                'eventVariables' => [
                    ['name' => '__customer_name__', 'description' => 'Name of the customer'],
                    ['name' => '__contact_name__', 'description' => 'Name of the contact'],
                    ['name' => '__logged_in_user_name__', 'description' => 'Name of the logged in user'],
                    ['name' => '__web_order_number__', 'description' => 'Web Order Number'],
                    ['name' => '__total_amount__', 'description' => 'Order Total Amount'],
                    ['name' => '__notes__', 'description' => 'Order Notes'],
                    ['name' => '__customer_order_details_url__', 'description' => '/customer-profile-order-list-items?order_id=:id'],
                    ['name' => '__customer_quotation_details_url__', 'description' => '/customer-profile-quotation-list-items?order_id=:id'],
                    ['name' => '__admin_order_details_url__', 'description' => '/admin/order/:id/show'],
                ],
                'eventRecipents' => [
                    ['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Admcontactinistrator'],
                    ['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer'],
                    ['name' => 'Business_Contact', 'event_action_field' => 'is_get_customer_business_contact', 'description' => 'Customer Business Contact'],
                    ['name' => 'Contact', 'event_action_field' => 'is_get_contact', 'description' => 'Contact'],
                ],
                'eventTemplates' => [
                ],
            ],
            [
                'name' => 'Order Notes Updated',
                'code' => Event::ORDER_NOTES_UPDATED,
                'enabled' => true,
                'description' => 'This events get triggered when from customer portal someone add or update a existing note on order.',
                'eventVariables' => [
                    ['name' => '__customer_name__', 'description' => 'Name of the customer'],
                    ['name' => '__contact_name__', 'description' => 'Name of the contact'],
                    ['name' => '__logged_in_user_name__', 'description' => 'Name of the logged in user'],
                    ['name' => '__web_order_number__', 'description' => 'Web Order Number'],
                    ['name' => '__total_amount__', 'description' => 'Order Total Amount'],
                    ['name' => '__notes__', 'description' => 'Order Notes'],
                    ['name' => '__customer_order_details_url__', 'description' => '/customer-profile-order-list-items?order_id=:id'],
                    ['name' => '__customer_quotation_details_url__', 'description' => '/customer-profile-quotation-list-items?order_id=:id'],
                    ['name' => '__admin_order_details_url__', 'description' => '/admin/order/:id/show'],
                ],
                'eventRecipents' => [
                    ['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator'],
                    ['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer'],
                    ['name' => 'Business_Contact', 'event_action_field' => 'is_get_customer_business_contact', 'description' => 'Customer Business Contact'],
                    ['name' => 'Contact', 'event_action_field' => 'is_get_contact', 'description' => 'Contact'],
                ],
                'eventTemplates' => [],
            ],
            [
                'name' => 'Quotation Received',
                'code' => Event::QUOTATION_RECEIVED,
                'enabled' => true,
                'description' => 'This event get triggered when someone make a request for quote from existing cart.',
                'eventVariables' => [
                    ['name' => '__customer_name__', 'description' => 'Name of the customer'],
                    ['name' => '__contact_name__', 'description' => 'Name of the contact'],
                    ['name' => '__logged_in_user_name__', 'description' => 'Name of the logged in user'],
                    ['name' => '__web_order_number__', 'description' => 'Web Order Number'],
                    ['name' => '__total_amount__', 'description' => 'Order Total Amount'],
                    ['name' => '__notes__', 'description' => 'Order Notes'],
                    ['name' => '__customer_order_details_url__', 'description' => '/customer-profile-order-list-items?order_id=:id'],
                    ['name' => '__customer_quotation_details_url__', 'description' => '/customer-profile-quotation-list-items?order_id=:id'],
                    ['name' => '__admin_order_details_url__', 'description' => '/admin/order/:id/show'],
                ],
                'eventRecipents' => [
                    ['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator'],
                    ['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer'],
                    ['name' => 'Business_Contact', 'event_action_field' => 'is_get_customer_business_contact', 'description' => 'Customer Business Contact'],
                    ['name' => 'Contact', 'event_action_field' => 'is_get_contact', 'description' => 'Contact'],
                ],
                'eventTemplates' => [
                    [
                        'name' => '[Admin] Quotation Confirmation Notification',
                        'subject' => 'New Request For Quotation Received',
                        'email_body' => <<<'HTML'
<p>Dear System Administrator,</p>
<p>
    System received an request for quotation successfully and is currently being processed.
</p>

<h3>Order Summary</h3>
<table style="border-collapse: collapse; width:100%; max-width:500px;">
    <tr>
        <td><strong>Quotation Number:</strong></td>
        <td>__erp_order_number__</td>
    </tr>
    <tr>
        <td><strong>Entry Date:</strong></td>
        <td>__entry_date__</td>
    </tr>
    <tr>
        <td><strong>Total Amount:</strong></td>
        <td>__total_amount__</td>
    </tr>
    <tr>
        <td><strong>Order Status:</strong></td>
        <td>__order_status__</td>
    </tr>
</table>

<p style="margin: 25px 0;">You can view complete order details by clicking the button below:</p>

<p>__customer_order_details_url__</p>

<p>If you have any questions or require assistance, please contact the administrator.</p>

<p>&nbsp;</p>

<p>Best regards,<br />
__company_name__</p>
HTML,
                        'show_button' => true,
                        'button_text' => 'View Details',
                        'button_url' => '/orders/:id',
                        'notification_type' => 'emailable',
                        'enabled' => true,
                    ],
                    [
                        'name' => '[Customer] Order Confirmation Notification',
                        'subject' => 'Order Confirmation – Thank You for Your Purchase',
                        'email_body' => <<<'HTML'
<p>Dear __customer_name__,</p>
<p>
    Thank you for your order with <strong>__company_name__</strong>.  
    Your order has been successfully received and is currently being processed.
</p>

<h3>Order Summary</h3>
<table style="border-collapse: collapse; width:100%; max-width:500px;">
    <tr>
        <td><strong>Order Number:</strong></td>
        <td>__erp_order_number__</td>
    </tr>
    <tr>
        <td><strong>Order Date:</strong></td>
        <td>__entry_date__</td>
    </tr>
    <tr>
        <td><strong>Total Amount:</strong></td>
        <td>__total_amount__</td>
    </tr>
    <tr>
        <td><strong>Order Status:</strong></td>
        <td>__order_status__</td>
    </tr>
</table>

<p style="margin: 25px 0;">You can view complete order details by clicking the button below:</p>

<p>__customer_order_details_url__</p>

<p>If you have any questions or require assistance, please contact the administrator.</p>

<p>&nbsp;</p>

<p>Best regards,<br />
__company_name__</p>
HTML,
                        'show_button' => true,
                        'button_text' => 'View Order Details',
                        'button_url' => '/orders/:id',
                        'notification_type' => 'emailable',
                        'enabled' => true,
                    ],
                ],
            ],
            [
                'name' => 'Catalog Changed',
                'code' => Event::CATALOG_CHANGED,
                'enabled' => true,
                'description' => 'This event get triggered when scheduled program received changes the catalog/product.',
                'eventVariables' => [
                    ['name' => '__execution_date__', 'value' => '-', 'description' => 'The date of synchronization has been requested.'],
                    ['name' => '__started_at__', 'value' => '-', 'description' => 'The datetime synchronization started.'],
                    ['name' => '__ended_at__', 'value' => '-', 'description' => 'The datetime when synchronization ended.'],
                    ['name' => '__records__', 'value' => '-', 'description' => 'The list of product codes that has been synchronization.'],
                ],
                'eventRecipents' => [
                    ['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator'],
                ],
                'eventTemplates' => [
                    [
                        'name' => '[Admin] Product catalog Updated Notification',
                        'subject' => 'Schedule Product Catalog Synced with ERP Completed',
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
                        'button_text' => 'Synchronization List',
                        'button_url' => route_uri('product-sync.index'),
                        'notification_type' => 'emailable',
                        'enabled' => true,
                    ],
                ],
            ],
            [
                'name' => 'Password Reset',
                'code' => Event::RESET_PASSWORD,
                'enabled' => true,
                'description' => 'This even get triggered when from customer portal someone requests to reset their password.',
                'eventVariables' => [
                    ['name' => '__otp__', 'description' => 'One Time Password'],
                    ['name' => '__full_name__', 'description' => 'Name of the contact/account holder'],
                    ['name' => '__otp_duration__', 'value' => '30 minutes', 'description' => 'Duration after the OTP will expires'],
                ],
                'eventRecipents' => [
                    ['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'Admin'],
                    ['name' => 'Contact', 'event_action_field' => 'is_get_contact', 'description' => 'Contact'],
                ],
                'eventTemplates' => [
                    [
                        'name' => '[Contact] Password Reset OTP Notification',
                        'subject' => 'Password Reset OTP Verification',
                        'email_body' => <<<'HTML'
<p>Dear __full_name__,</p>
<p> We received a request to reset your password for your <strong>__company_name__</strong> account. </p> 
<p> Please use the following One-Time Password (OTP) to proceed with your password reset: </p> 
<p style="text-align:center; margin:25px 0;"> 
<span style=" font-size:28px; font-weight:bold; letter-spacing:6px; background:#f4f4f4; padding:12px 20px; border-radius:6px; display:inline-block;"> __otp__</span></p> 
<p> This OTP is valid for <strong>__otp_duration__</strong>. Please do not share this code with anyone for security reasons.</p>
<p> If you did not request a password reset, you may safely ignore this email or contact the administrator immediately. </p> 
<p> If you experience any difficulties, please contact the administrator for assistance. </p> 

<p>&nbsp;</p>

<p>Best regards,<br />
__company_name__</p>
HTML,
                        'show_button' => false,
                        'button_text' => null,
                        'button_url' => null,
                        'notification_type' => 'emailable',
                        'enabled' => true,
                    ],
                ],
            ],
            [
                'name' => 'Contact Account Request Received',
                'code' => Event::CONTACT_ACCOUNT_REQUEST_RECEIVED,
                'enabled' => true,
                'description' => 'This event get triggered when someone request for online access from customer portal.',
                'eventVariables' => [
                    ['name' => '__account_number__', 'description' => 'Customer ERP Code of the contact asking for logins'],
                    ['name' => '__customer_code__', 'description' => 'Customer/company code of ERP'],
                    ['name' => '__customer_name__', 'description' => 'Customer/Company name in system'],
                    ['name' => '__email_address__', 'description' => 'Email Address for new contact login'],
                    ['name' => '__email_address__', 'description' => 'Email Address for new contact login'],
                    ['name' => '__full_name__', 'description' => 'Name of the Contact asking for logins'],
                    ['name' => '__contacts_details_url_for_account_request_received__', 'description' => '/admin/contact/:id/edit'],
                ],
                'eventRecipents' => [
                    ['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator'],
                    ['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer'],
                    ['name' => 'Business_Contact', 'event_action_field' => 'is_get_customer_business_contact', 'description' => 'Customer Business Contact'],
                    ['name' => 'Contact', 'event_action_field' => 'is_get_contact', 'description' => 'Contact'],
                ],
                'eventTemplates' => [
                    [
                        'name' => '[Admin] Request Online Access Received Notification',
                        'subject' => 'New Account Request Online Access Received',
                        'email_body' => <<<'HTML'
<p>Dear System Administrator,</p>

<p>A new customer has registered on the __company_name__ platform and is currently awaiting account approval.</p>

<p>Please find the customer details below:</p>

<p>Account Details:</p>

<p>Account Name:&nbsp;__full_name__<br />
Customer Number:&nbsp;__customer_code__<br />
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
                        'button_url' => str_replace('{id}', ':id', route_uri('account-request.edit')),
                        'notification_type' => 'emailable',
                        'enabled' => true,
                    ],
                    [
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
                    ],
                ],
            ],
            [
                'name' => 'Contact Account Request Accepted',
                'code' => Event::CONTACT_ACCOUNT_REQUEST_ACCEPTED,
                'enabled' => true,
                'description' => 'This event get triggered when from admin panel or by email verification account got approved.',
                'eventVariables' => [
                    ['name' => '__account_number__', 'description' => 'Customer ERP Code of the contact asking for logins'],
                    ['name' => '__email_address__', 'description' => 'Email Address for new contact login'],
                    ['name' => '__full_name__', 'description' => 'Name of the Contact asking for logins'],
                    ['name' => '__contacts_details_url_for_account_request_accepted__', 'description' => '/admin/contact/:id/show'],
                ],
                'eventRecipents' => [
                    ['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator'],
                    ['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer'],
                    ['name' => 'Business_Contact', 'event_action_field' => 'is_get_customer_business_contact', 'description' => 'Customer Business Contact'],
                    ['name' => 'Contact', 'event_action_field' => 'is_get_contact', 'description' => 'Contact'],
                ],
                'eventTemplates' => [
                    [
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
                    ],
                ],
            ],
            [
                'name' => 'Contact Account Request Verification',
                'code' => Event::CONTACT_ACCOUNT_REQUEST_VERIFICATION,
                'enabled' => true,
                'description' => 'This event get triggered when By configuration contexts are required to verify their email address before login.',
                'eventVariables' => [
                    ['name' => '__account_number__', 'description' => 'ERP Code of the contact asking for logins'],
                    ['name' => '__customer_code__', 'description' => 'ERP Code of the Customer/Company asking for logins'],
                    ['name' => '__customer_name__', 'description' => 'Name of account holder belongs to company'],
                    ['name' => '__email_address__', 'description' => 'Email Address of requested account holder'],
                    ['name' => '__phone_no__', 'description' => 'Phone Number of requested account holder'],
                    ['name' => '__full_name__', 'description' => 'Name of the contact/account holder'],
                    ['name' => '__contacts_details_url_for_account_request_accepted__', 'description' => '/admin/contact/:id/show'],
                ],
                'eventRecipents' => [
                    ['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator'],
                    ['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer'],
                    ['name' => 'Business_Contact', 'event_action_field' => 'is_get_customer_business_contact', 'description' => 'Customer Business Contact'],
                    ['name' => 'Contact', 'event_action_field' => 'is_get_contact', 'description' => 'Contact'],
                ],
                'eventTemplates' => [
                    [
                        'name' => '[Admin] Account Verification Requested Notification',
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
                        'button_url' => str_replace('{id}', ':id', route_uri('account-request.edit')),
                        'notification_type' => 'emailable',
                        'enabled' => false,
                    ],
                    [
                        'name' => '[Contact] Account Verification Notification',
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
                    ],
                ],
            ],
            [
                'name' => 'Create Order From Quotation',
                'code' => Event::CREATE_ORDER_FROM_QUOTATION,
                'enabled' => true,
                'description' => 'Create Order From Quotation',
                'eventVariables' => [
                    ['name' => '__erp_quote_number__', 'description' => 'Quote Number'],
                    ['name' => '__contact_name__', 'description' => 'Name of the contact'],
                    ['name' => '__customer_name__', 'description' => 'Name of the customer'],
                    ['name' => '__shipping_address__', 'description' => 'ERP order number'],
                    ['name' => '__total_amount__', 'description' => 'Quotation Total Amount'],
                    ['name' => '__notes__', 'description' => 'Customer notes'],
                    ['name' => '__po_number__', 'description' => 'PO Number provided by customer'],
                    ['name' => '__shipping_method__', 'description' => 'Shipping method selected'],
                    ['name' => '__special_instruction__', 'description' => 'Special instructions added by customer'],
                    ['name' => '__customer_quotation_details__', 'description' => 'Details Table'],
                ],
                'eventRecipents' => [
                    ['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator', 'enabled' => false],
                    ['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer', 'enabled' => false],
                    ['name' => 'Business_Contact', 'event_action_field' => 'is_get_customer_business_contact', 'description' => 'Customer Business Contact', 'enabled' => false],
                    ['name' => 'Contact', 'event_action_field' => 'is_get_contact', 'description' => 'Contact', 'enabled' => false],
                    ['name' => 'Sales Person', 'event_action_field' => 'is_get_salesperson', 'description' => 'Contact', 'enabled' => false],
                    ['name' => 'Quotation Sales Person', 'event_action_field' => 'is_quote_sales_person', 'description' => 'ERP Sales Person'],
                ],
                'eventTemplates' => [],
            ],
            [
                'name' => 'Customer Part Number Deleted',
                'code' => Event::CUSTOMER_PART_NUMBER_DELETED,
                'enabled' => true,
                'description' => 'Customer Part Number Deleted',
                'eventVariables' => [
                    ['name' => '__customer_name__', 'description' => 'Name of the customer'],
                    ['name' => '__customer_code__', 'description' => 'ERP Code of the customer'],
                    ['name' => '__product_code__', 'description' => 'Product Real Code'],
                    ['name' => '__product_name__', 'description' => 'Product Name'],
                    ['name' => '__customer_part_number__', 'description' => 'Customer Part Number'],
                ],
                'eventRecipents' => [
                    ['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator', 'enabled' => false],
                    ['name' => 'Customer', 'event_action_field' => 'is_get_customer', 'description' => 'Customer', 'enabled' => false],
                    ['name' => 'Business_Contact', 'event_action_field' => 'is_get_customer_business_contact', 'description' => 'Customer Business Contact', 'enabled' => false],
                    ['name' => 'Sales Person', 'event_action_field' => 'is_get_salesperson', 'description' => 'Contact', 'enabled' => false],
                ],
                'eventTemplates' => [
                    [
                        'name' => '[Admin] Customer Part Number Deleted Notification',
                        'subject' => 'Customer Part Number is Removed',
                        'email_body' => <<<'HTML'
<p>Dear System Administrator,</p>
<p>The customer part number code&nbsp; &quot;__customer_part_number__&quot; is deleted.</p>
<p><strong>Product Information:</strong>&nbsp;</p>
<ol>
	<li><strong>Product Name</strong>:&nbsp;__product_name__</li>
	<li><strong>Product Code:</strong>&nbsp;__product_code__</li>
</ol>
<p><strong>Customer Information:</strong></p>
<ol>
	<li><strong>Customer Code:&nbsp;</strong>__customer_code__</li>
	<li><strong>Customer Name:&nbsp;</strong>__customer_name__</li>
</ol>
<p><strong>Deleted Customer Part Number:&nbsp;</strong>__customer_part_number__</p>

<p>&nbsp;</p>

<p>Best regards,<br />
__company_name__ System Notification</p>
</p>
HTML,
                        'show_button' => false,
                        'button_text' => null,
                        'button_url' => route_uri('custom-part-number.index'),
                        'notification_type' => 'emailable',
                        'enabled' => true,
                    ],
                ],
            ],
            [
                'name' => 'Customer Registration Report Generated',
                'code' => Event::CUSTOMER_REGISTRATION_REPORT_GENERATED,
                'enabled' => true,
                'description' => 'This event get triggered on when system generate customer report created by system.',
                'eventVariables' => [
                    ['name' => '__interval_in_days__', 'description' => 'Number of days report is generated'],
                    ['name' => '__report_start_date__', 'description' => 'Date from report started'],
                    ['name' => '__report_end_date__', 'value' => 'Date from report end', 'description' => 'Product Real Code'],
                ],
                'eventRecipents' => [
                    ['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator', 'enabled' => false],
                ],
                'eventTemplates' => [
                    [
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
                    ],
                ],
            ],
            [
                'name' => 'Ticket Created',
                'code' => Event::TICKET_CREATED,
                'enabled' => true,
                'description' => 'This event get triggered when a customer creates a helpdesk ticker from customer portal.',
                'eventVariables' => [
                    ['name' => '__ticket_number__', 'description' => 'Support Ticket Number'],
                    ['name' => '__ticket_content__', 'description' => 'Support Ticket Content'],
                    ['name' => '__ticket_subject__', 'description' => 'Support Ticket Subject'],
                    ['name' => '__ticket_priority__', 'description' => 'Support Ticket Priority'],
                    ['name' => '__ticket_department__', 'description' => 'Support Ticket Department'],
                    ['name' => '__ticket_url__', 'description' => 'Support Ticket URL'],
                    ['name' => '__full_name__', 'description' => 'Support Ticket URL'],
                    ['name' => '__email_address__', 'description' => 'Support Ticket URL'],
                ],
                'eventRecipents' => [
                    ['name' => 'Admin', 'event_action_field' => 'is_get_admin', 'description' => 'System Administrator'],
                    ['name' => 'Contact', 'event_action_field' => 'is_get_contact', 'description' => 'Contact'],
                    ['name' => 'Ticket Department', 'event_action_field' => 'is_get_contact', 'description' => 'Ticket Department'],
                ],
                'eventTemplates' => [
                    [
                        'name' => '[Admin] Ticket Created notification',
                        'subject' => 'New Support Ticket Created – Action Required',
                        'email_body' => <<<'HTML'
<p>Dear System Administrator,</p>

<p>
    A customer has created a new support ticket in the system.
    Please review the ticket details below and take the necessary action as soon as possible.
</p>

<h3>Ticket Information</h3>

<table style="border-collapse: collapse; width:100%; max-width:600px;">
    <tr>
        <td><strong>Ticket Number:</strong></td>
        <td>__ticket_number__</td>
    </tr>
    <tr>
        <td><strong>Customer Name:</strong></td>
        <td>__customer_name__</td>
    </tr>
        <tr>
        <td><strong>Account Holder Name:</strong></td>
        <td>__full_name__</td>
    </tr>
    <tr>
        <td><strong>Customer Email:</strong></td>
        <td>__email_address__</td>
    </tr>
    <tr>
        <td><strong>Department:</strong></td>
        <td>__ticket_department__</td>
    </tr>
    <tr>
        <td><strong>Priority:</strong></td>
        <td>__ticket_priority__</td>
    </tr>
    <tr>
        <td><strong>Subject:</strong></td>
        <td>__ticket_subject__</td>
    </tr>
    <tr>
        <td><strong>Created At:</strong></td>
        <td>__timestamp__</td>
    </tr>
</table>

<p style="margin: 25px 0;">
    Please review and respond to this ticket at your earliest convenience.
</p>

<p>Kindly ensure the customer is notified and appropriate action is taken as soon as possible.</p>


<p>&nbsp;</p>

<p>Best regards,<br />
__company_name__</p>
HTML,
                        'show_button' => true,
                        'button_text' => 'View Ticket Details',
                        'button_url' => str_replace('{id}', ':id', route_uri('ticket.show')),
                        'notification_type' => 'emailable',
                        'enabled' => true,
                    ],
                ],
            ],
        ];
    }
}
