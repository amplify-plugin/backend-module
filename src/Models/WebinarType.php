<?php

namespace Amplify\System\Backend\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class WebinarType extends Model implements Auditable
{
    use CrudTrait;
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id'];
}
