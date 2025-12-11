<?php

namespace Amplify\System\Backend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProductAvailability extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [
        'id'
    ];
}
