<?php

namespace Amplify\System\Backend\Models;

use Amplify\ErpApi\Traits\CustomerERPIDAttribute;
use Amplify\System\Marketing\Models\Subscriber;
use Amplify\System\OrderRule\Models\CustomerOrderRule;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @property Collection $addresses
 * @property Country $billingCountry
 * @property State $billingState
 */
class Customer extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    const APPROVED = true;

    const UNAPPROVED = false;

    use CrudTrait, CustomerERPIDAttribute, HasFactory;

    // use HasTranslations;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'customers';

    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = [
        'customer_po_required' => 'boolean',
        'allow_backorder' => 'boolean',
        'credit_card_only' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {

            $model->contacts->each(fn (Contact $contact) => $contact->delete());

            $model->addresses->each(fn (CustomerAddress $customerAddress) => $customerAddress->delete());
        });

    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function billingState(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state', 'iso2')
            ->where('country_code', $this->country_code);
    }

    public function billingCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_code', 'iso2');
    }

    /**
     * Finding the admin
     */
    public function contact(): HasOne
    {
        return $this->hasOne(Contact::class)
            ->where('is_admin', true);
    }

    public function getSubscribeAttribute()
    {
        return Subscriber::where('email', $this->email)->first() ? Subscriber::where('email', $this->email)->first()->status : null;
    }

    public function customer_group(): BelongsTo
    {
        return $this->belongsTo(CustomerGroup::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'customer_id', 'id');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(CustomerAddress::class, 'customer_id', 'id');
    }

    public function site(): HasOne
    {
        return $this->hasOne(Site::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function customerOrderRules()
    {
        return $this->hasMany(CustomerOrderRule::class)
            ->where('enabled', '=', true)
            ->with(['orderRule']);
    }

    public function industryClassification(): BelongsTo
    {
        return $this->belongsTo(IndustryClassification::class);
    }

    public function defaultAddress(): HasOne
    {
        return $this->hasOne(CustomerAddress::class, 'id', 'default_address_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeActive($query)
    {
        $query->whereApproved(self::APPROVED)->get();
    }

    public function scopeInactive($query)
    {
        $query->whereApproved(self::UNAPPROVED)->get();
    }

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
    /**
     * Set null if punch_out is false
     */
    public function setPunchOutConfigurationAttribute($value)
    {
        $this->attributes['punch_out_configuration'] = (bool) $this->punch_out
            ? $value
            : null;
    }

    // Define the display_name accessor
    public function getDisplayNameAttribute()
    {
        return $this->customer_name.' - '.$this->customer_code;
    }
}
