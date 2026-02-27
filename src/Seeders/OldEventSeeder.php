<?php

namespace Amplify\System\Backend\Seeders;

use Amplify\System\Backend\Models\Event;
use Amplify\System\Backend\Models\EventRecipent;
use Amplify\System\Backend\Models\EventVariable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class OldEventSeeder extends Seeder
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

            foreach ($this->data() as $event) {
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

    private function data()
    {
        return [
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
                'eventTemplates' => [],
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
                'eventTemplates' => [],
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
                'eventTemplates' => [],
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
                'eventTemplates' => []
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
                'eventTemplates' => []
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
                'eventTemplates' => []
            ],
        ];
    }

}