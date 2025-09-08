<?php

namespace Amplify\System\Backend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProductAvailability extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'item_number',
        'warehouse_id',
        'price',
        'list_price',
        'standard_price',
        'extended_price',
        'order_price',
        'average_lead_time',
        'unit_of_measure',
        'quantity_available',
        'quantity_on_order',
    ];
}
