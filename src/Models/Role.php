<?php

namespace Amplify\System\Backend\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Guard;
use Spatie\Permission\Models\Role as OriginalRole;
use Spatie\Permission\PermissionRegistrar;

class Role extends OriginalRole
{
    use CrudTrait;

    protected $fillable = ['name', 'team_id', 'guard_name', 'updated_at', 'created_at'];

    public function teams(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'team_id', 'id');
    }

    public static function guessCurrentModel()
    {
        $role = request('role');

        if (! $role) {
            abort(404, 'Role Parameter is missing');
        }

        return self::find($role);
    }

    public static function create(array $attributes = [])
    {
        $attributes['guard_name'] = $attributes['guard_name'] ?? Guard::getDefaultName(static::class);

        $params = ['name' => $attributes['name'], 'guard_name' => $attributes['guard_name'], 'team_id' => $attributes['team_id'] ?? User::SYSTEM_TEAM_ID];

        if (PermissionRegistrar::$teams) {
            if (array_key_exists(PermissionRegistrar::$teamsKey, $attributes)) {
                $params[PermissionRegistrar::$teamsKey] = $attributes[PermissionRegistrar::$teamsKey];
            } else {
                $attributes[PermissionRegistrar::$teamsKey] = getPermissionsTeamId();
            }
        }

        return static::query()->create($attributes);
    }
}
