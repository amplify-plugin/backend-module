<?php

namespace Amplify\System\Backend\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Role as OriginalRole;

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
}
