<?php

namespace Amplify\System\Backend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Warehouse extends Model implements Auditable
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['name', 'code', 'email', 'address', 'telephone', 'zip_code', 'pickup_location', 'ship_via', 'enabled'];

    protected $casts = [
        'pickup_location' => 'boolean',
        'enabled' => 'boolean',
    ];
}
