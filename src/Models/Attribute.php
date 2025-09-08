<?php

namespace Amplify\System\Backend\Models;

use Amplify\System\Backend\Traits\DynamicDBConnectionTrait;
use Amplify\System\Scopes\DatabaseScope;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as ContractsAuditable;

class Attribute extends Model implements ContractsAuditable
{
    use Auditable, CrudTrait, DynamicDBConnectionTrait, HasTranslations, Sluggable, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'attributes';

    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];

    protected $fillable = [
        'name', 'slug', 'description', 'is_new', 'is_updated', 'has_range', 'use_as_filter', 'searchable', 'tunable',
        'unit', 'type', 'traceparts_attribute_id',
    ];

    // protected $hidden = [];

    protected $appends = ['local_name'];

    protected $translatable = ['name'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*public function getFromValues($values, $key, $default = 0)
    {
        $obj = json_decode($values, true);

        return $obj[0][$key] ?? $default;
    }*/

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function productClassification(): belongsTo
    {
        return $this->belongsTo(ProductClassification::class);
    }

    /**
     * For Pivot AttributeProductClassification
     */
    public function productClassifications(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                ProductClassification::class,
                'attribute_product_classification',
                'attribute_id',
                'classification_id'
            )->withTimestamps()
            ->wherePivotIn(
                'is_required',
                request()->filled('is_required')
                    ? [request()->is_required]
                    : [1, 0]
            )
            ->withPivot(['min', 'max', 'enums', 'boolean_titles', 'is_required', 'is_multiple']);
    }

    /**
     * For Pivot AttributeProduct
     */
    public function products(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                Product::class,
                'attribute_product',
                'attribute_id',
                'product_id',
            )
            ->withTimestamps()
            ->withPivot(['attribute_value']);
    }

    /**
     * @throws \JsonException
     */
    private function getDataOfAvailableLocale($original_field_name): string
    {
        $locale = $_GET['locale'] ?? app()->getLocale();
        $data = $this->getTranslation($original_field_name, $locale);

        if (empty($data)) {
            $original_data = json_decode($this->attributes[$original_field_name] ?? '',
                false,
                512,
                JSON_THROW_ON_ERROR);
            $data = $original_data->{$locale} ?? collect($original_data)->first();
        }

        return $data;
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

    /*public function getIsRequiredAttribute()
    {
        return $this->attributes['is_required'] = $this->getFromValues($this->values, 'is_required');
    }

    public function getHasRangeAttribute()
    {
        return $this->attributes['has_range'] = $this->getFromValues($this->values, 'has_range');
    }

    public function getUseAsFilterAttribute(): string
    {
        return $this->attributes['use_as_filter'] = $this->getFromValues($this->values, 'use_as_filter');
    }

    public function getSearchableAttribute(): string
    {
        return $this->attributes['searchable'] = $this->getFromValues($this->values, 'searchable');
    }

    public function getTunableAttribute(): string
    {
        return $this->attributes['tunable'] = $this->getFromValues($this->values, 'tunable');
    }

    public function getUnitAttribute(): string
    {
        return $this->attributes['unit'] = $this->getFromValues($this->values, 'unit', '');
    }

    public function getTypeAttribute(): string
    {
        return $this->attributes['type'] = $this->getFromValues($this->values, 'type', '');
    }*/

    /**
     * @return string
     *
     * @throws \JsonException
     */
    public function getLocalNameAttribute()
    {
        return $this->attributes['local_name'] = $this->getDataOfAvailableLocale('name');
    }

    /*public function getLocalNameAttribute()
    {
        return $this->attributes['local_name'] = $this->getTranslation(
            'name',
            request()->locale ?? app()->getLocale()
        );
    }*/

    public function getMinAttribute(): string
    {
        return $this->attributes['min'] = '';
    }

    public function getMaxAttribute(): string
    {
        return $this->attributes['max'] = '';
    }

    public function getBooleanTrueAttribute(): string
    {
        return $this->attributes['boolean_true'] = '';
    }

    public function getBooleanFalseAttribute(): string
    {
        return $this->attributes['boolean_false'] = '';
    }

    public function getEnumsAttribute(): string
    {
        return $this->attributes['enums'] = '';
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setValuesAttribute($value)
    {
        $obj = json_decode($value, true);
        if (! ($obj[0] ?? false)) {
            $value = json_encode([$obj]);
        }

        $this->attributes['values'] = $value;
    }

    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new DatabaseScope);
    }
}
