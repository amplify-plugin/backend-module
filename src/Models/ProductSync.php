<?php

namespace Amplify\System\Backend\Models;

use Amplify\System\Utility\Models\FailedJob;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProductSync extends Model implements Auditable
{
    use CrudTrait;
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'product_syncs';

    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];

    // protected $fillable = [];
    // protected $hidden = [];
    protected $casts = [
        'is_processed' => 'boolean',
        'is_processing' => 'boolean',
        'allow_backorder' => 'boolean',
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
    public function failedJob()
    {
        return $this->hasMany(FailedJob::class);
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
