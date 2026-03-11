<?php

namespace Amplify\System\Backend\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read CartItem[]|Collection $cartItems
 */
class Cart extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'boolean',
        'sub_total' => 'float',
        'tax_amount' => 'float',
        'ship_charge' => 'float',
        'total' => 'float',
    ];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
