<?php

namespace Amplify\System\Backend\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\PermissionRegistrar;

class CustomerRole extends Role
{
    public function teams()
    {
        return $this->belongsTo(Customer::class, 'team_id', 'id');
    }

    /**
     * A role belongs to some users of the model associated with its guard.
     */
    public function contacts(): BelongsToMany
    {
        return $this->morphedByMany(
            Contact::class,
            'model',
            config('permission.table_names.model_has_roles'),
            PermissionRegistrar::$pivotRole,
            config('permission.column_names.model_morph_key')
        );
    }

    public static function guessCurrentModel()
    {
        $role = request('role');

        if (! $role) {
            abort(404, 'Role Parameter is missing');
        }

        return self::find($role);
    }
}
