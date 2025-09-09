<?php

/**
 * Created by Reliese Model.
 */

namespace Amplify\System\Backend\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use OwenIt\Auditing\Contracts\Auditable;

class Site extends Model implements Auditable
{
    use CrudTrait, HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'sites';

    protected $fillable = [
        'site_name',
        'site_description',
        'url',
        'front_page_id',
        'shop_page_id',
        'product_page_id',
        'template_id',
    ];

    protected $with = [
        'search',
        'search_configuration',
    ];

    public function search(): HasOne
    {
        return $this->hasOne(Search::class);
    }

    public function sitePricing(): HasOne
    {
        return $this->hasOne(SitePricing::class);
    }

    public function search_configuration()
    {
        return $this->hasOne(SiteSearchConfiguration::class);
    }

    public static function getSiteOptions()
    {
        return Cache::remember('site-setting', now()->addHours(1), function () {
            return Site::orderBy('site_name', 'asc')->with('search', 'sitePricing')->get();
        });
    }
}
