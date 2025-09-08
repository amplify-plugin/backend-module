<?php

namespace Amplify\System\Backend\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Amplify\System\Message\Interfaces\MessageableInterface;
use Amplify\System\Message\Traits\Messageable;
use Amplify\System\Ticket\Interfaces\TicketableInterface;
use Amplify\System\Ticket\Traits\TicketableTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements Auditable, MessageableInterface, TicketableInterface
{
    use CrudTrait, HasFactory, HasRoles, Messageable, Notifiable, TicketableTrait;
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
    ];

    public static function boot()
    {
        parent::boot();

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

    public function isAdmin(): bool
    {
        return $this->is_admin === 1;
    }

    public function avatarImage()
    {
        return ($this->image)
            ? $this->image
            : generateUserAvatar($this->name, false);
    }

    public function setPasswordAttribute($value)
    {
        if (optional(Route::getCurrentRoute())->getName() === 'admin.force-password.reset') {
            $this->attributes['password'] = Hash::make($value);
        } else {
            $this->attributes['password'] = $value;
        }
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
