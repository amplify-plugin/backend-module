<?php

namespace Amplify\System\Backend\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OrderList extends Model implements Auditable
{
    use CrudTrait;
    use \OwenIt\Auditing\Auditable;

    const CUSTOMER_ORDER_LIST_TYPES = ['GLOBAL' => 'global', 'PERSONAL' => 'personal'];

    protected $fillable = ['name', 'list_type', 'description', 'contact_id', 'customer_id'];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::deleting(function (self $orderList) {
            $orderList->orderListItems()->delete();
        });
    }

    /**
     * relations
     */
    public function orderListItems()
    {
        return $this->hasMany(OrderListItem::class, 'list_id', 'id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Button function for Backend OrderList menu
     */
    public function buttonOrderListItems()
    {
        return '<a class="btn btn-sm btn-link" href="'.route('list-item.index')
            .'?list_id='.$this->id.'" data-toggle="tooltip" title="List Items"><i class="la la-list mr-2"></i>View List Items</a>';
    }

    public static function guessFavouriteModel()
    {
        $favourite = null;
        $title = 'Favourite';

        if (request()->route()->hasParameter('favourite')) {
            $favourite = request()->route()->favourite;
        } elseif (request()->route()->hasParameter('quick_list')) {
            $favourite = request()->route()->quick_list;
            $title = 'Quick List';
        }

        if (! $favourite) {
            abort(404, "{$title} Parameter is missing");
        }

        return self::find($favourite);
    }

    /**
     * Scopes
     */

    /**
     * Model functions
     */
    public function getCustomerName()
    {
        return optional(optional($this->contact)->customer)->customer_name;
    }
}
