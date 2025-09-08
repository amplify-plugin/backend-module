<?php

namespace Amplify\System\Backend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManufacturerImageSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'manufacturer_id',
        'name',
        'path',
    ];

    /**
     * Get the product image that owns the image size.
     */
    public function productImage(): BelongsTo
    {
        return $this->belongsTo(ProductImage::class);
    }
}
