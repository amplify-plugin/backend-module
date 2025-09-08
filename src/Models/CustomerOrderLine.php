<?php

namespace Amplify\System\Backend\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class CustomerOrderLine extends Model implements Auditable
{
    use CrudTrait, HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'customer_order_lines';

    protected $guarded = ['id'];

    protected $casts = [
        'additional_info' => 'json',
    ];

    /**
     * Relations
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_code', 'product_code');
    }

    public function backpackProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(CustomerOrder::class, 'customer_order_id', 'id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    /**
     * Functions
     */
    public function getSubTotal()
    {
        return "<span class='text-right'>".currency_format(($this->qty * $this->customer_price)).'</span>';
    }

    public function getSubTotalAttribute()
    {
        return number_format(($this->qty * $this->customer_price), 2);
    }

    public function isLastItem()
    {
        return optional($this->order)->orderLines->count() == 0;
    }

    /**
     * Button functions
     */
    public function submitQuotePrice()
    {
        return '
            <div class="row justify-content-end mr-2">
                <button type="submit" class="btn btn-success" id="submit-price">
                    <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                    <span data-value="save_and_back">Update Price</span>
                </button>
            </div>
            ';
    }

    public function updateEnable()
    {
        return '
            <div class="row justify-content-end mr-2">
                <button type="submit" class="btn btn-info mr-1" id="edit-form">
                    <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                    <span data-value="save_and_back">Edit</span>
                </button>

                <button type="submit" class="btn btn-success" id="update-btn">
                    <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                    <span data-value="save_and_back">Save</span>
                </button>
            </div>
            ';
    }
}
