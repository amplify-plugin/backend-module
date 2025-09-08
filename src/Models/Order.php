<?php

namespace Amplify\System\Backend\Models;

use Amplify\ErpApi\Facades\ErpApi;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Order extends Model implements Auditable
{
    use CrudTrait;
    use \OwenIt\Auditing\Auditable;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'orders';

    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public static function guessQuotationWrapper()
    {
        $quotation = request()->route('quotation');
        $ship_vias = ! empty(request()->get('ship_vias')) ? 1 : null;

        if (! $quotation) {
            abort(404, 'Quotation Parameter is missing');
        }

        $quotation = ErpApi::getQuotationDetail(['quote_number' => $quotation, 'GetShipVias' => $ship_vias]);

        if (! $quotation->QuoteNumber) {
            abort(404, 'Invalid Quotation Number');
        }

        return $quotation;

    }

    public static function guessOrderWrapper()
    {
        $order = request()->route('order');

        if (! $order) {
            abort(404, 'Order Parameter is missing');
        }

        $order = ErpApi::getOrderDetail(['order_number' => $order]);

        if (! $order->OrderNumber) {
            abort(404, 'Invalid Order Number');
        }

    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
