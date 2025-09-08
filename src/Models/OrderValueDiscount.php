<?php

namespace Amplify\System\Backend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class OrderValueDiscount extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'order_value_discounts';

    protected $guarded = ['id'];

    public function order_value_discount_details(): HasMany
    {
        return $this->hasMany(OrderValueDiscountDetail::class);
    }
}
