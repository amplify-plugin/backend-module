<?php

namespace Amplify\System\Backend\Models;

use Amplify\System\Backend\Traits\DynamicDBConnectionTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SkuProduct extends Pivot
{
    use DynamicDBConnectionTrait;

    protected $table = 'sku_product';

    // no auto‐incrementing primary key
    public $incrementing = false;

    protected $primaryKey = null;

    // no created_at / updated_at
    public $timestamps = false;

    protected $fillable = [
        'parent_id',
        'sku_id',
    ];
}
