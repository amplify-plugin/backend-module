<?php

namespace Amplify\System\Backend\Models;

use Amplify\System\Backend\Traits\DynamicDBConnectionTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class ProductPurchasedTogether extends Model implements Auditable
{
    use CrudTrait, DynamicDBConnectionTrait;
    use \OwenIt\Auditing\Auditable;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'product_purchased_together';

    protected $guarded = ['id'];

    protected $casts = [
        'occurrence_count' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function (self $model) {
            if ($model->product_id_a > $model->product_id_b) {
                [$model->product_id_a, $model->product_id_b] = [
                    $model->product_id_b,
                    $model->product_id_a,
                ];
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function productA(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id_a');
    }

    public function productB(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id_b');
    }

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
