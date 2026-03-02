<?php

namespace Amplify\System\Backend\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class EventRecipent extends Model implements Auditable
{
    use CrudTrait;
    use \OwenIt\Auditing\Auditable;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    public const EVENT_ACTION_FIELDS = [
        'is_get_admin' => 'System Admin',
        'is_get_customer' => 'Customer/Company',
        'is_get_contact' => 'Contact/Account Holder',
        'is_get_customer_business_contact' => 'Customer/Company Business Contact',
        'is_get_salesperson' => 'Customer/Company Salesperson',
        'is_quote_sales_person' => 'Customer/Company Quote Salesperson',
    ];

    protected $table = 'event_recipents';

    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $hidden = [];

    protected $attributes = [
        'enabled' => true,
    ];

    protected $casts = [
        'enabled' => 'boolean',
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
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function eventTemplate(): BelongsTo
    {
        return $this->belongsTo(EventTemplate::class);
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
