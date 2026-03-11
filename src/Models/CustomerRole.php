<?php

namespace Amplify\System\Backend\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\PermissionRegistrar;

class CustomerRole extends Role
{
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
}
