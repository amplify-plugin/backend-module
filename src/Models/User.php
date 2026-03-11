<?php

namespace Amplify\System\Backend\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Amplify\System\Message\Interfaces\MessageableInterface;
use Amplify\System\Message\Traits\Messageable;
use Amplify\System\Ticket\Interfaces\TicketableInterface;
use Amplify\System\Ticket\Traits\TicketableTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements Auditable, MessageableInterface, TicketableInterface
{
    use CrudTrait, HasRoles, Messageable, Notifiable, TicketableTrait;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'users';

    const AUTH_GUARD = 'web';

    const SYSTEM_TEAM_ID = 0;

    const USER_TYPES = [
        'admin' => 'Administrative',
        'sales' => 'Sales Person',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'enabled' => 'boolean',
        'is_admin' => 'boolean',
    ];

    public static function booted()
    {
        static::deleting(function ($model) {
            $rootUrl = array_unique([Storage::disk('uploads')->url('/'), config('app.url').'/uploads/']);

            $image_url = $model->image;

            foreach ($rootUrl as $ru) {
                $image_url = str_replace($ru, '', $image_url);
            }

            if (! empty($model->image)) {
                Storage::disk('uploads')->delete($image_url);
            }
        });
    }

    /**
     * A model may have multiple roles.
     */
    public function roles(): BelongsToMany
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

        return $relation->wherePivot(PermissionRegistrar::$teamsKey, getPermissionsTeamId())
            ->where(function ($q) {
                $teamField = config('permission.table_names.roles').'.'.PermissionRegistrar::$teamsKey;
                $q->whereNull($teamField)->orWhere($teamField, getPermissionsTeamId());
            });
    }

    public function isAdmin(): bool
    {
        return (bool)$this->is_admin;
    }

    public function avatarImage()
    {
        return ($this->image)
            ? $this->image
            : generateUserAvatar($this->name, false);
    }

    public function setImageAttribute($value)
    {
        if (request()->hasFile('image')) {
            $attribute_name = 'image';

            $disk = 'uploads';

            $destination_path = 'images/users';

            $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);

            $this->attributes['image'] = Storage::disk($disk)->url($this->attributes['image']);
        }
    }
}
