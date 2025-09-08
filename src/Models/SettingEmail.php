<?php

namespace Amplify\System\Backend\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SettingEmail extends Model implements Auditable
{
    use CrudTrait;
    use \OwenIt\Auditing\Auditable;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'setting_emails';

    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];

    public const EMAIL_TYPES = [
        [
            'name' => 'Registration Request Received',
            'value' => 'registration_request_received',
        ],
        [
            'name' => 'Registration Request Received - Admin',
            'value' => 'registration_request_received_admin',
        ],
        [
            'name' => 'Registration Request Accepted',
            'value' => 'registration_request_accepted',
        ],
        [
            'name' => 'Registration Request Accepted - Admin',
            'value' => 'registration_request_accepted_admin',
        ],
        [
            'name' => 'Order Received',
            'value' => 'order_received',
        ],
        [
            'name' => 'Order Received - Admin',
            'value' => 'order_received_admin',
        ],
        [
            'name' => 'Order Notes Updated',
            'value' => 'order_notes_updated',
        ],
        [
            'name' => 'Quotation Received',
            'value' => 'quotation_received',
        ],
        [
            'name' => 'Quotation Received - Admin',
            'value' => 'quotation_received_admin',
        ],
        [
            'name' => 'Order Notes Updated - Admin',
            'value' => 'order_notes_updated_admin',
        ],
    ];

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
