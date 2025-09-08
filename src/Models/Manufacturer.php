<?php

namespace Amplify\System\Backend\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Manufacturer extends Model implements Auditable
{
    use CrudTrait;
    use \OwenIt\Auditing\Auditable;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'manufacturers';

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

    public function changeStatus()
    {
        if ($this->archived_at) {
            return '<a class="btn btn-sm btn-link pr-0" href="javascript:void(0)" title="Make Publish" onclick="firePublishAction('.$this->id.')">
                        <i class="la la-check-circle"></i> Publish
                    </a>';
        } else {
            return '<a class="btn btn-sm btn-link pr-0" href="javascript:void(0)" title="Make Publish" onclick="fireArchiveAction('.$this->id.')">
                        <i class="la la-check-circle"></i> Archive
                    </a>';
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function imageSizes(): HasMany
    {
        return $this->hasMany(ManufacturerImageSize::class);
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
