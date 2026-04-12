<?php

/**
 * Created by Reliese Model.
 */

namespace Amplify\System\Backend\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PasswordReset extends Model implements Auditable
{
    use CrudTrait;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'password_resets';

    public $incrementing = false;

    public $timestamps = false;

    protected $hidden = [
        'token',
    ];

    protected $fillable = [
        'email',
        'token',
    ];
}
