<?php

namespace Amplify\System\Backend\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class ProductClassification extends Model implements AuditableContract
{
    use Auditable, CrudTrait, HasTranslations, Sluggable, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'product_classifications';

    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = [];

    protected $fillable = ['title', 'slug', 'values', 'parent_id', 'single_product_page_id'];
    // protected $hidden = [];

    protected $casts = [
        'parent_id' => 'int',
    ];

    protected $appends = ['label'];

    protected $translatable = ['title'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    /**
     * @var mixed
     */
    public $is_required;

    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProductClassification::class, 'parent_id', 'id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(ProductClassification::class, 'parent_id', 'id')->with('children');
    }

    public function child(): HasMany
    {
        return $this->hasMany(ProductClassification::class, 'parent_id', 'id');
    }

    public function attribute(): HasMany
    {
        return $this->hasMany(Attribute::class);
    }

    /**
     * For Pivot AttributeProductClassification
     */
    public function attributes(): BelongsToMany
    {
        $this->setIsRequired([1, 0]);

        return $this
            ->belongsToMany(
                Attribute::class,
                'attribute_product_classification',
                'classification_id',
                'attribute_id'
            )
            ->withPivot(['min', 'max', 'enums', 'boolean_titles', 'is_required', 'is_multiple'])
            ->withTimestamps();
    }

    public function option(): HasMany
    {
        return $this->hasMany(Option::class);
    }

    /**
     * For Pivot OptionProductClassification
     */
    public function options(): BelongsToMany
    {
        return $this->belongsToMany(
            Option::class,
            'option_product_classification',
            'classification_id',
            'option_id'
        )
            ->withTimestamps();
    }

    /**
     * Get the productClassification products
     */
    public function classificationProducts(): hasMany
    {
        return $this->hasMany(Product::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Scope a query to only is requires.
     *
     * @return mixed
     */
    public function scopeIsRequired($query)
    {
        return $query->where('is_required', 1);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * @throws \JsonException
     */
    public function getLabelAttribute()
    {
        return $this->attributes['label'] = $this->getDataOfAvailableLocale('title');
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    private function setIsRequired($is_required = [1, 0])
    {
        $this->is_required = in_array(
            Route::currentRouteName(),
            ['product-classification.edit', 'product-classification.update']
        ) !== false
            ? [1]
            : $is_required;
    }

    /**
     * @throws \JsonException
     */
    private function getDataOfAvailableLocale($original_field_name)
    {
        $locale = $_GET['locale'] ?? app()->getLocale();
        $data = $this->getTranslation($original_field_name, $locale);

        if (empty($data)) {
            $original_data = json_decode($this->attributes[$original_field_name] ?? null, false);
            $data = $original_data->{$locale} ?? collect($original_data)->first();
        }

        return $data;
    }
}
