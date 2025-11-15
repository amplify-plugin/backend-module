<?php

namespace Amplify\System\Backend\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Event extends Model implements Auditable
{
    use CrudTrait;
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL CONSTANTS
    |--------------------------------------------------------------------------
    */

    const REGISTRATION_REQUEST_RECEIVED = 'registration_request_received';

    const CONTACT_ACCOUNT_REQUEST_RECEIVED = 'contact_account_request_received';

    const CONTACT_ACCOUNT_REQUEST_ACCEPTED = 'contact_account_request_accepted';

    const ORDER_NOTES_UPDATED = 'order_notes_updated';

    const ORDER_NOTES_UPDATED_ADMIN = 'order_notes_updated_admin';

    const REGISTRATION_REQUEST_ACCEPTED = 'registration_request_accepted';

    const ORDER_RECEIVED = 'order_received';

    const ORDER_ACCEPTED = 'order_accepted';

    const ORDER_REJECTED = 'order_rejected';

    const DRAFT_RECEIVED = 'draft_received';

    const QUOTATION_RECEIVED = 'quotation_received';

    const CATALOG_CHANGED = 'catalog_changed';

    const PAYMENT_SUCCESSFUL = 'payment_successful';

    const PAYMENT_FAILED = 'payment_failed';

    const RESET_PASSWORD = 'reset_password';

    const FORM_SUBMITTED = 'form_submitted';

    const ORDER_RULE_CHECKED = 'order_rule_checked';

    const ORDER_WAITING_APPROVAL = 'order_waiting_approval';

    const ORDER_REQUEST_APPROVED = 'order_request_approved';

    const ORDER_REQUEST_REJECTED = 'order_request_rejected';

    const CUSTOM_COIL_ORDER_RECEIVED = 'custom_coil_order_received';

    const MODEL_SERIAL_NUMBER_RESEARCH = 'model_serial_number_research';

    const CREATE_ORDER_FROM_QUOTATION = 'create_order_from_quotation';

    const CUSTOMER_PART_NUMBER_DELETED = 'customer_part_number_deleted';

    const CUSTOMER_REGISTRATION_REPORT_GENERATED = 'customer_registration_report_generated';

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'events';

    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function eventActions()
    {
        return $this->hasMany(EventAction::class);
    }

    public function eventVariables()
    {
        return $this->hasMany(EventVariable::class);
    }

    public function eventRecipents()
    {
        return $this->hasMany(EventRecipent::class);
    }

    public function eventTemplate()
    {
        return $this->hasMany(EventTemplate::class);
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
