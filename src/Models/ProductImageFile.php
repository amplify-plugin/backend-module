<?php

namespace Amplify\System\Backend\Models;

use Amplify\System\Backend\Traits\DynamicDBConnectionTrait;
use Illuminate\Database\Eloquent\Model;

class ProductImageFile extends Model
{
    use DynamicDBConnectionTrait;

    protected $table = 'product_image_files';

    protected $fillable = [
        'code',
        'path',
        'kind',
        'variant',
        'size',
        'mtime',
    ];

    protected $casts = [
        'size' => 'integer',
        'mtime' => 'integer',
    ];
}