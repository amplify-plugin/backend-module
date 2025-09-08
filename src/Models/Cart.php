<?php

namespace Amplify\System\Backend\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @property-read CartItem[]|\Illuminate\Database\Eloquent\Collection $cartItems
 */
class Cart extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $appends = ['total'];

    protected $guarded = ['id'];

    public function getTotalAttribute()
    {
        return $this->cartItems()->sum(\DB::raw('unitprice * quantity'));
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
