<?php

/**
 * Created by Reliese Model.
 */

namespace Amplify\System\Backend\Models;

use Amplify\System\Backend\Traits\DynamicDBConnectionTrait;
use Amplify\System\Scopes\DatabaseScope;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as ContractsAuditable;

class Category extends Model implements ContractsAuditable
{
    use Auditable, CrudTrait, DynamicDBConnectionTrait, HasTranslations, Sluggable, SoftDeletes;

    protected $table = 'categories';

    protected $casts = [
        'is_top_nav' => 'bool',
        'parent_id' => 'int',
        'level' => 'int',
        'featured' => 'bool',
    ];

    protected $guarded = [
        'id',
    ];

    protected $appends = ['label', 'old_image'];

    protected array $translatable = ['category_name'];

    public function showCloneCategoryBtn(): string
    {
        return '<a class="btn btn-sm btn-link" href="' . route('category.clone', $this->id)
            . '" data-toggle="tooltip" title="Create Classifcation"><i class="lar la-copy"></i> Create Classifcation</a>';
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * For Pivot CategoryProduct
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->with('productImage')->withTimestamps();
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->with('children');
    }

    public function child(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    /**
     * @throws \JsonException
     */
    private function getDataOfAvailableLocale($original_field_name): string
    {
        $locale = $_GET['locale'] ?? app()->getLocale();
        $data = $this->getTranslation($original_field_name, $locale);

        if (empty($data) && !empty($this->$this->attributes[$original_field_name])) {
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
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * @throws \JsonException
     */
    public function getLabelAttribute(): string
    {
        return $this->attributes['label'] = $this->getDataOfAvailableLocale('category_name');
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function getOldImageAttribute(): string
    {
        return $this->image ?? '';
    }

    public function productsLink()
    {
        return route('frontend.shop.index') . '/Products/Products/' . ($this->category_name ?? '');
    }

    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'category_slug' => [
                'source' => 'category_name',
            ],
        ];
    }

    /**
     * The "booted" method of the Category model.
     *
     * This method is automatically called when the model is being booted.
     * It registers global scopes that should be applied to all queries for this model.
     * In this case, it adds the DatabaseScope to filter records based on database context.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new DatabaseScope);

        static::saved(function (self $category) {
            if (Cache::has('site-db-categories')) {
                Cache::forget('site-db-categories');
            }
        });
    }
}
