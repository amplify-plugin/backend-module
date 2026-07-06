<?php

namespace Amplify\System\Backend\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Collection;

class ContactLogin extends Model
{
    use CrudTrait;

    public const ROW_TYPE_ASSIGNMENT = 'assignment';

    public const ROW_TYPE_SESSION = 'session';

    protected $table = 'contact_logins';

    protected $guarded = ['id'];

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

    public static function resolveCustomerId(Contact $contact): int
    {
        if (config('amplify.basic.enable_multi_customer_manage', false) && $contact->active_customer_id != null) {
            return (int) $contact->active_customer_id;
        }

        return (int) $contact->customer_id;
    }

    public static function startSession(Contact $contact, ?EloquentModel $initiatedBy = null): self
    {
        $customerId = self::resolveCustomerId($contact);

        // Auth::login() regenerates the session id, so close the prior row by contact_login_id
        // (still in session data) rather than matching session_id on the old row.
        self::endSession();

        $login = self::create([
            'row_type' => self::ROW_TYPE_SESSION,
            'contact_id' => $contact->id,
            'customer_id' => $customerId,
            'impersonate_type' => $initiatedBy?->getMorphClass(),
            'impersonate_id' => $initiatedBy?->getKey(),
            'last_logged_in' => now(),
            'active' => true,
        ]);

        session(['contact_login_id' => $login->id]);

        return $login;
    }

    public static function endSession(?int $sessionRowId = null): void
    {
        $id = $sessionRowId ?? session('contact_login_id');

        if (! $id) {
            return;
        }

        self::query()
            ->session()
            ->where('id', $id)
            ->whereNull('last_logged_out')
            ->update([
                'last_logged_out' => now(),
                'active' => false,
            ]);

        session()->forget('contact_login_id');
    }

    /**
     * Open session rows for a contact, optionally excluding the current session row.
     */
    public static function openSessionsForContact(int $contactId, ?int $exceptRowId = null): Collection
    {
        return self::query()
            ->session()
            ->where('contact_id', $contactId)
            ->whereNull('last_logged_out')
            ->when($exceptRowId, fn (Builder $query) => $query->where('id', '!=', $exceptRowId))
            ->orderByDesc('last_logged_in')
            ->get();
    }

    /**
     * Whether this contact has active sessions in other browsers/devices.
     */
    public static function hasOtherActiveSessions(int $contactId): bool
    {
        $currentRowId = session('contact_login_id');

        return self::openSessionsForContact($contactId, is_numeric($currentRowId) ? (int) $currentRowId : null)->isNotEmpty();
    }

    public static function findOrCreateAssignment(array $attributes): self
    {
        return self::query()->updateOrCreate(
            [
                'contact_id' => $attributes['contact_id'],
                'customer_id' => $attributes['customer_id'],
                'row_type' => self::ROW_TYPE_ASSIGNMENT,
            ],
            array_merge($attributes, ['row_type' => self::ROW_TYPE_ASSIGNMENT])
        );
    }

    public static function currentSessionRow(): ?self
    {
        $sessionRowId = session('contact_login_id');

        if ($sessionRowId) {
            return self::query()->session()->find($sessionRowId);
        }

        return null;
    }

    public static function formatNameWithEmail(?string $name, ?string $email): string
    {
        $name = trim((string) $name);
        $email = trim((string) $email);

        if ($name !== '' && $email !== '') {
            return "{$name} ({$email})";
        }

        if ($name !== '') {
            return $name;
        }

        if ($email !== '') {
            return $email;
        }

        return 'N/A';
    }

    public function getContactDisplayLabel(): string
    {
        $contact = $this->contact;

        if (! $contact) {
            return 'N/A';
        }

        return self::formatNameWithEmail($contact->name, $contact->email);
    }

    public function getCustomerDisplayLabel(): string
    {
        $customer = $this->customer;

        if (! $customer) {
            return 'N/A';
        }

        return self::formatNameWithEmail($customer->display_name, $customer->email ?? null);
    }

    public function getWarehouseDisplayLabel(): string
    {
        $warehouse = $this->warehouse;

        if (! $warehouse) {
            return '-';
        }

        $code = trim((string) ($warehouse->code ?? ''));
        $name = trim((string) ($warehouse->name ?? ''));

        if ($code !== '' && $name !== '') {
            return "{$code} - {$name}";
        }

        return $name ?: $code ?: '-';
    }

    public function getCustomerAddressDisplayLabel(): string
    {
        return $this->customerAddress?->display_name ?? '-';
    }

    public function getImpersonatorDisplayName(): string
    {
        if (! $this->impersonate_type) {
            return 'Self';
        }

        $impersonator = $this->impersonator;

        if (! $impersonator) {
            return class_basename($this->impersonate_type).' #'.$this->impersonate_id;
        }

        return self::formatNameWithEmail($impersonator->name ?? null, $impersonator->email ?? null);
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

    public function impersonator(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'impersonate_type', 'impersonate_id');
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
    public function scopeAssignment(Builder $query): Builder
    {
        return $query->where('row_type', self::ROW_TYPE_ASSIGNMENT);
    }

    public function scopeSession(Builder $query): Builder
    {
        return $query->where('row_type', self::ROW_TYPE_SESSION);
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->whereNull('last_logged_out');
    }
}
