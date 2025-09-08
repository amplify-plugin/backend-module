<?php

namespace Amplify\System\Backend\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class CustomerAddress extends Model implements Auditable
{
    use CrudTrait;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id'];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    /**
     * Functions
     */

    /**
     * This function checks if the address is the default address set by the contact
     */
    public function isDefaultAddress()
    {
        return $this->id == optional(optional(customer(true))->customer)->default_address_id;
    }

    public static function guessCurrentModel()
    {
        $address = request('address');

        if (! $address) {
            abort(404, 'Contact Parameter is missing');
        }

        return self::find($address);
    }

    // Define the display_name accessor
    public function getDisplayNameAttribute()
    {
        return $this->address_name.' - '.$this->address_code;
    }

    public function stateModel(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state', 'iso2');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_code', 'iso2');
    }
}
