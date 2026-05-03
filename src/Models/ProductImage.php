<?php

/**
 * Created by Reliese Model.
 */

namespace Amplify\System\Backend\Models;

use Amplify\System\Backend\Traits\DynamicDBConnectionTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ProductImage extends Model implements Auditable
{
    use CrudTrait, DynamicDBConnectionTrait, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'product__images';

    protected $fillable = [
        'product_id',
        'main',
        'thumbnail',
        'additional',
        'updated_at',
    ];

    protected $casts = [
        'additional' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
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
