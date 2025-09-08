<?php

namespace Amplify\System\Backend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteSearchConfiguration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'site_id',
        'product_search_by_id_prefix',
        'easyask_host',
        'easyask_port',
        'easyask_dictionary',
        'sayt_product_id',
        'sayt_product_image',
        'sayt_product_name',
        'sayt_product_price',
        'sayt_product_description',
        'sayt_product_type',
        'sayt_product_sizes',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
