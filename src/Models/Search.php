<?php

namespace Amplify\System\Backend\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class Search extends Model implements Auditable
{
    use CrudTrait, HasFactory;
    use \OwenIt\Auditing\Auditable;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'searches';

    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];

    protected $fillable = [
        'site_id',
        'easyask_url',
        'dictionary_name',
        'protocol',
        'port',
        'sayt_product_id',
        'sayt_product_image',
        'sayt_product_name',
        'sayt_product_price',
        'sayt_product_description',
        'sayt_product_type',
        'sayt_product_sizes',
        'product_search_by_id_prefix',
        'easyask_host',
        'easyask_port',
        'easyask_dictionary',
    ];

    // protected $hidden = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public static function isSiteSearchExist($site_id): bool
    {
        return (bool) self::where('site_id', $site_id)->first();
    }

    public static function getSiteSearchIdBySiteId($site_id): int
    {
        return (int) self::where('site_id', $site_id)->first()->id;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
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
