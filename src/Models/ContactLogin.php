<?php

namespace Amplify\System\Backend\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactLogin extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'contact_logins';

    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    protected $casts = [
        'active' => 'boolean',
        'last_logged_out' => 'datetime',
        'last_logged_in' => 'datetime',
    ];

    protected $appends = ['roles', 'permissions'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public static function fetchContactLoginPagination(array $filters = [])
    {
        return Contact::with('customer')->when(! empty($filters['customer_name']), function ($query) use ($filters) {
            $query->whereHas('customer', function (Builder $query) use ($filters) {
                $query->where('customer_name', 'like', strtolower("%{$filters['customer_name']}%"));
            });
        })->when(! empty($filters['contact_name']), function ($query) use ($filters) {
            $query->where('name', 'like', strtolower("%{$filters['contact_name']}%"));
        })->when(! empty($filters['contact_email']), function ($query) use ($filters) {
            $query->where('email', 'like', strtolower("%{$filters['contact_email']}%"));
        })->paginate($filters['per_page'] ?? getPaginationLengths()[0]);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function customerAddress(): BelongsTo
    {
        return $this->belongsTo(CustomerAddress::class);
    }

    public function getRolesAttribute()
    {
        $roles = CustomerRole::select('roles.*')
            ->whereGuardName(Contact::AUTH_GUARD)
            ->join(config('permission.table_names.model_has_roles'), 'roles.id', '=', config('permission.table_names.model_has_roles').'.role_id')
            ->where([
                config('permission.table_names.model_has_roles').'.model_id' => $this->contact_id,
                config('permission.table_names.model_has_roles').'.team_id' => $this->customer_id,
                config('permission.table_names.model_has_roles').'.model_type' => Contact::class,
            ])->get()->pluck('id')->toArray();

        return $roles;
    }

    public function getPermissionsAttribute()
    {
        $permissions = CustomerPermission::select('permissions.*')
            ->whereGuardName(Contact::AUTH_GUARD)
            ->join(config('permission.table_names.model_has_permissions'), 'permissions.id', '=', config('permission.table_names.model_has_permissions').'.permission_id')
            ->where([
                config('permission.table_names.model_has_permissions').'.model_id' => $this->contact_id,
                config('permission.table_names.model_has_permissions').'.team_id' => $this->customer_id,
                config('permission.table_names.model_has_permissions').'.model_type' => Contact::class,
            ])->get()->pluck('id')->toArray();

        return $permissions;
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
