<?php

namespace Amplify\System\Backend\Models;

use Amplify\System\Backend\Traits\DynamicDBConnectionTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class OrderListItem extends Model implements Auditable
{
    use CrudTrait, DynamicDBConnectionTrait, HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $timestamps = true;

    protected $fillable = ['product_id', 'qty', 'list_id'];

    /**
     * Relations
     */

    /**
     * @return BelongsTo::class
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function list(): BelongsTo
    {
        return $this->belongsTo(OrderList::class);
    }

    /**
     * Functions
     */
    public function isLastItem()
    {
        return optional($this->list)->orderListItems->count() == 0;
    }

    /**
     * Scopes
     */

    /**
     * Model related functions
     */
}
