<?php

namespace Amplify\System\Backend\Models;

use Amplify\System\Marketing\Models\Subscriber;
use Amplify\System\Message\Interfaces\MessageableInterface;
use Amplify\System\Message\Traits\Messageable;
use Amplify\System\Ticket\Interfaces\TicketableInterface;
use Amplify\System\Ticket\Traits\TicketableTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property Customer $activeCustomer
 * @property Customer $customer
 */
class Contact extends Authenticatable implements Auditable, MessageableInterface, TicketableInterface
{
    use CrudTrait, HasFactory, HasPermissions, HasRoles, Messageable, Notifiable, TicketableTrait;
    use \OwenIt\Auditing\Auditable;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    const AUTH_GUARD = 'customer';

    protected $table = 'contacts';

    protected $guarded = ['id'];

    protected $casts = [
        'assigned_customers' => 'array',
        'enabled' => 'boolean',
        'is_admin' => 'boolean',
        'is_approver' => 'boolean',
        'is_viewer' => 'boolean',
        'password_reset_required' => 'boolean',
        'is_buyer' => 'boolean',
    ];

    protected $hidden = ['password'];

    protected $attributes = [
        'redirect_route' => 'dashboard',
        'order_limit' => '0',
        'daily_budget_limit' => '0',
        'monthly_budget_limit' => '0',
    ];

    const REQUEST_ACCOUNT_VERIFICATION = 'request_account_verification';
    const NEW_RETAIL_CUSTOMER_VERIFICATION = 'new_retail_customer_verification';
    const EMAIL_VERIFICATION = 'email_verification';


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $rootUrl = array_unique([Storage::disk('uploads')->url('/'), config('app.url').'/uploads']);
            $model->profile_image = str_replace($rootUrl, '', $model->profile_image);

            if (! empty($model->profile_image)) {
                Storage::disk('uploads')->delete($model->profile_image);
            }

            ContactLogin::where([
                'contact_id' => $model->id,
                'customer_id' => $model->customer_id,
            ])->delete();
        });

        static::saving(function ($model) {

            if (! empty($model->password) && $model->isDirty('password')) {
                $model->password = Hash::make($model->password);

                if (request()->is('admin/*') && request()->route()->named('contacts.store', 'contacts.update')) {
                    $model->password_reset_required = true;
                }

            } else {
                unset($model->password);
            }

            // if (empty($model->login_id)) {
            //     $model->login_id = $model->email;
            // }

            if (! config('amplify.basic.enable_multi_customer_manage')) {
                $model->active_customer_id = null;
            }
        });
    }

    public function isApproved()
    {
        return $this->customer->approved == true;
    }

    public static function guessCurrentModel()
    {
        $contact = request('contact');

        if (! $contact) {
            abort(404, 'Contact Parameter is missing');
        }

        return self::find($contact);

    }

    public function avatarImage()
    {
        return ($this->profile_image)
            ? $this->profile_image
            : generateUserAvatar($this->name, false);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function accountTitle(): BelongsTo
    {
        return $this->belongsTo(AccountTitle::class);
    }

    public function ownRoles(): BelongsToMany
    {
        $relation = $this->morphToMany(
            config('permission.models.role'),
            'model',
            config('permission.table_names.model_has_roles'),
            config('permission.column_names.model_morph_key'),
            PermissionRegistrar::$pivotRole
        );

        if (! PermissionRegistrar::$teams) {
            return $relation;
        }

        $team_id = getPermissionsTeamId() === 0 ? get_customer_team_id() : getPermissionsTeamId();

        return $relation
            ->where(function ($q) use ($team_id) {
                $teamField = config('permission.table_names.roles').'.'.PermissionRegistrar::$teamsKey;
                $q->whereNull($teamField)->orWhere($teamField, $team_id ?: null);
            });
    }

    public function ownPermissions(): BelongsToMany
    {
        $relation = $this->morphToMany(
            config('permission.models.permission'),
            'model',
            config('permission.table_names.model_has_permissions'),
            config('permission.column_names.model_morph_key'),
            PermissionRegistrar::$pivotPermission
        );

        if (! PermissionRegistrar::$teams) {
            return $relation;
        }

        return $relation->wherePivot(PermissionRegistrar::$teamsKey, get_customer_team_id() ?? getPermissionsTeamId());
    }

    public function customer(): BelongsTo
    {
        if (config('amplify.basic.enable_multi_customer_manage', false) && is_numeric($this->active_customer_id)) {
            $key = 'active_customer_id';
        } else {
            $key = 'customer_id';
        }

        return $this->belongsTo(Customer::class, $key, 'id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(CustomerOrder::class, 'customer_id', 'id');
    }

    public function contacts(): HasMany
    {
        // First, get the customer instance
        $customer = $this->customer()->first();

        // Then, check if the customer exists and return the hasMany relationship
        if ($customer) {
            return $customer->hasMany(self::class)->where('id', '<>', $this->id);
        }

        // Return an empty relationship if the customer doesn't exist
        return $this->hasMany(self::class)->where('id', '<>', $this->id)->whereNull('id');
    }

    public function addresses()
    {
        return $this->hasManyThrough(
            CustomerAddress::class,
            Customer::class,
            'id', // Local key on the customers table...
            null,
            'customer_id' // Foreign key on the customer_addresses table...
        );
    }

    public function customer_address()
    {
        return $this->belongsTo(CustomerAddress::class, 'customer_address_id', 'id');
    }

    public function warehouse()
    {
        return $this->hasOneThrough(
            Warehouse::class,
            Customer::class,
            'id',
            'id',
            'customer_id',
            'warehouse_id'
        );
    }

    public function ownWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'id');
    }

    /**
     * return all contact order list collection
     *
     * @return HasMany
     */
    public function orderList()
    {
        return $this->hasMany(OrderList::class);
    }

    public function contactLogins()
    {
        return $this->hasMany(ContactLogin::class);
    }

    /**
     * same contact login
     *
     * @return HasMany
     */
    public function backendContactLogins()
    {
        return $this->contactLogins()->where('customer_id', '!=', $this->customer_id);
    }

    public function activeCustomer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'active_customer_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeApproved($query)
    {
        return $query->whereHas('customer', function (Builder $q) {
            $q->where('approved', Customer::APPROVED);
        });
    }

    public function scopeUnapproved($query)
    {
        return $query->whereHas('customer', function (Builder $q) {
            $q->where('approved', Customer::UNAPPROVED);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getSubscribedAttribute(): bool
    {
        return (bool) Subscriber::whereEmail($this->email)->whereStatus('subscribed')->first();
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setProfileImageAttribute($value)
    {
        if (request()->hasFile('profile_image')) {

            $attribute_name = 'profile_image';

            $disk = 'uploads';

            $destination_path = 'images/contacts';

            if (! Storage::disk($disk)->exists($destination_path)) {
                Storage::disk($disk)->makeDirectory($destination_path);
            }

            $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);

            $this->attributes['profile_image'] = Storage::disk($disk)->url($this->attributes['profile_image']);
        }
    }

    public function setSubscribedAttribute($value)
    {
        $subscribe = Subscriber::firstOrCreate([
            'email' => $this->attributes['email'],
        ]);

        $subscribe->status = request()->boolean('subscribe', false) ? 'subscribed' : 'unsubscribed';

        $subscribe->save();
    }

    /**
     * @see app/Http/Controllers/Admin/ContactCrudController.php
     */
    public function getAssignedCustomerNames(): string
    {
        if (empty($this->assigned_customers)) {
            return '-';
        }

        $customers = Customer::find($this->assigned_customers)?->pluck('name')->toArray() ?? [];

        return implode(', ', $customers);
    }

    public function updateEntryAsPerContactLogin($login_customer)
    {
        $this->update([
            'warehouse_id' => $login_customer['warehouse_id'],
            'customer_address_id' => $login_customer['customer_address_id'],
        ]);
    }

    public function updateContactLoginAsPerEntry()
    {
        ContactLogin::updateOrCreate([
            'contact_id' => $this->id,
            'customer_id' => $this->customer_id,
        ], [
            'warehouse_id' => $this->warehouse_id,
            'customer_address_id' => $this->customer_address_id,
            'ship_to_name' => $this->customer_address?->address_name ?? null,
        ]);
    }

    public function validateActiveCustomer()
    {
        if ($this->active_customer_id) {
            $doesntExist = $this->contactLogins()->where('customer_id', $this->active_customer_id)->doesntExist();

            if ($doesntExist) {
                $this->update(['active_customer_id' => null]);
            }
        }
    }
}
