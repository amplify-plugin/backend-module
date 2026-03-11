<?php

namespace Amplify\System\Backend\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Option extends Model implements Auditable
{
    use CrudTrait, SoftDeletes;
    use HasTranslations;
    use \OwenIt\Auditing\Auditable;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'options';

    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];

    protected $fillable = [
        'option_name',
        'is_required',
        'description',
        'option_type',
        'value_type',
        'default_value',
        'limit_min',
        'limit_max',
        'limit_choices',
    ];

    // protected $hidden = [];

    protected $casts = ['limit_choices' => 'array'];

    protected $appends = ['local_name'];

    protected $translatable = ['option_name'];

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

    public function productClassification(): BelongsTo
    {
        return $this->belongsTo(ProductClassification::class);
    }

    public function productClassifications(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductClassification::class,
            'option_product_classification',
            'option_id',
            'classification_id'
        )
            ->withTimestamps();
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * For Pivot OptionProduct
     */
    public function products(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                Product::class,
                'option_product',
                'option_id',
                'product_id'
            )
            ->withTimestamps();
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

    public function getLocalNameAttribute(): string
    {
        return $this->attributes['local_name'] = $this->option_name;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
