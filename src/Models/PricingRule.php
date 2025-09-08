<?php

namespace Amplify\System\Backend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;

class PricingRule extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'pricing_rules';

    protected $guarded = ['id'];

    /**
     * @return HasOne
     */
    public function flat_discounts(): HasMany
    {
        return $this->hasMany(FlatDiscount::class);
    }

    /**
     * @return HasOne
     */
    public function volume_discounts(): HasMany
    {
        return $this->hasMany(VolumeDiscount::class);
    }

    public function order_value_discount(): HasOne
    {
        return $this->hasOne(OrderValueDiscount::class, 'pricing_rule_id');
    }
}
