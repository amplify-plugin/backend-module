<?php

/**
 * Created by Reliese Model.
 */

namespace Amplify\System\Backend\Models;

use Amplify\System\Backend\Enums\ProductAvailabilityEnum;
use Amplify\System\Backend\Models\Mutators\ImageMutator;
use Amplify\System\Backend\Traits\DynamicDBConnectionTrait;
use Amplify\System\Cms\Models\Page;
use Amplify\System\Marketing\Models\Campaign;
use Amplify\System\Scopes\DatabaseScope;
use Amplify\System\Utility\Models\ImportDefinitionJobProduct;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use JsonException;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as ContractsAuditable;

/**
 * @property-read DocumentType|null $default_document_type
 * @property string $ship_restriction
 * @property bool $pricing
 * @property ProductAvailabilityEnum $availability
 * @property ProductImage $productImage
 */
class Product extends Model implements ContractsAuditable
{
    use Auditable, CrudTrait, DynamicDBConnectionTrait, HasTranslations, ImageMutator, Sluggable, SoftDeletes;

    protected $casts = [
        /*'selling_price'         => 'float',
        'regular_price'         => 'float',*/
        'primary_category_id' => 'int',
        'sales_rank_short' => 'int',
        'sales_rank_medium' => 'int',
        'sales_rank_long' => 'int',
        'bestseller_rank' => 'int',
        'on_sale' => 'bool',
        'top_rated' => 'bool',
        'availableIn_store' => 'bool',
        'free_shipping' => 'bool',
        'average_review_rating' => 'float',
        'review_count' => 'int',
        'products_list' => 'array',
        'customer_group_price' => 'array',
        'min_order_qty' => 'integer',
        'qty_interval' => 'integer',
        'own_truck_only' => 'bool',
        'in_stock' => 'bool',
        'is_ncnr' => 'bool',
        'flags' => 'array',
        'sku_default_attributes' => 'array',
        'specifications' => 'array',
    ];

    private $singleProductIndex = [
        'id' => 'Product Id',
        'product_slug' => 'Product Slug',
    ];

    protected $table = 'products';

    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];

    // protected $fillable = [];
    // protected $hidden = [];

    protected $appends = [
        'old_image', 'local_product_name', 'local_model_name', 'local_short_description', 'local_description',
        /* , 'id_product_name' */
    ];

    protected $translatable = [
        'short_description', 'description', 'model_name', 'product_name', 'pivot.attribute_value',
    ];

    public const PRODUCT_TYPES = ['normal', 'bundle', 'configurable', 'simple'];

    const MEDIA_TYPE = [
        'I' => 'Image',
        'M' => 'Media',
        'L' => 'Link',
    ];

    const TAB_DESCRIPTION = 'description';

    const TAB_FEATURE = 'feature';

    const TAB_SPECIFICATION = 'specification';

    const TAB_DOCUMENT = 'document';

    const TAB_SKU = 'sku';

    const TAB_RELATED_ITEM = 'related_item';

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public static function guessSingleProductDetail()
    {
        $parameter = request()->route('identifier');

        if (! $parameter) {
            abort('404', 'Product is not available.');
        }

        return Product::select('id', 'product_name', 'flags', 'has_sku', 'description', 'short_description', 'manufacturer_id',
            'single_product_page_id', 'sku_default_attributes', 'features', 'specifications', 'min_order_qty', 'vendornum',
            'qty_interval', 'product_code', 'in_stock', 'is_ncnr', 'gtin_number', 'product_slug', 'manufacturer', 'sku_id', 'uom')
            ->with('attributes', 'productImage', 'manufacturerRelation', 'singleProductPage')
            ->where(config('amplify.frontend.easyask_single_product_index', 'id'), $parameter)
            ->first();
    }

    public function scopeGetEaProductsData()
    {
        return \Sayt::getEaProductsData();
    }

    /**
     * @return string|void
     */
    public function statusPublish()
    {
        if ($this->status == 'draft') {
            return '<a class="btn btn-sm btn-link pr-0" href="'
                .route('product.status-update',
                    ['product' => $this->id, 'status' => 'published', 'previous_status' => $this->status])
                .'" title="Make Publish">
                    <i class="la la-check-circle"></i> Publish
                  </a>';
        }
    }

    /**
     * @param  false  $crud
     * @return string
     */
    public function statusUnpublish()
    {
        if ($this->status == 'published') {
            return '<a class="btn btn-sm btn-link pr-0" href="'
                .route('product.status-update',
                    ['product' => $this->id, 'status' => 'draft', 'previous_status' => $this->status])
                .'" title="Make Unpublish">
                    <i class="las la-times-circle"></i> Unpublish
                  </a>';
        }
    }

    /**
     * @return string
     */
    public function statusPublishExit()
    {
        if ($this->status == 'draft') {
            return '<a class="btn btn-info" href="'
                .route('product.status-update',
                    ['product' => $this->id, 'status' => 'published', 'previous_status' => $this->status])
                .'" title="Make Publish">
                    <i class="la la-check-circle"></i> Publish & Exit
                  </a>';
        }
    }

    /**
     * @param  false  $crud
     * @return string
     */
    public function cancel()
    {
        return '<a class="text-decoration-none rounded border border-warning text-warning px-3 py-2" href="'
            .route('product.index').'" title="Cancel">
                    <i class="la la-times-circle"></i> Cancel
                  </a>';
    }

    /**
     * @param  false  $crud
     * @return string
     */
    public function statusArchive()
    {
        if ($this->status == 'archived') {
            $status = isset(self::find($this->id)->previous_status)
                ? in_array(self::find($this->id)->previous_status, ['draft', 'published'])
                    ? 'draft'
                    : 'incomplete'
                : 'incomplete';

            return '<a class="btn btn-sm btn-link pr-0" href="'
                .route('product.remove.archive',
                    ['product' => $this->id, 'status' => $status, 'previous_status' => $this->status])
                .'" title="Remove From Archive">
                    <i class="la la-archive"></i>  Remove From Archive
                  </a>';
        } else {
            return '<a class="btn btn-sm btn-link pr-0" href="'
                .route('product.status-update',
                    ['product' => $this->id, 'status' => 'archived', 'previous_status' => $this->status])
                .'" title="Make Archive">
                    <i class="la la-archive"></i> Archive
                  </a>';
        }
    }

    protected static function booted()
    {
        static::addGlobalScope(new DatabaseScope);

        self::creating(function ($model) {
            $request = request();
            if ($request->method() === 'POST') {
                $model->product_name = $request->input('product_name');
                $model->description = $request->input('description');
                $model->short_description = $request->input('short_description');
            }

            $model->user_id = $model->user_id ?? backpack_auth()->id();
            $model->flags = request()->input('flags', []);
        });

        self::deleting(function ($model) {
            $model->status = 'archived';
            $model->save();
        });

        self::updating(function ($model) {
            $request = request();

            if ($request->method() === 'PUT') {
                $model->product_name = $request->input('product_name');
                $model->description = $request->input('description');
                $model->short_description = $request->input('short_description');
                $model->flags = $request->input('flags', []);
            }
        });
    }

    public function getTableColumns()
    {
        return $this->singleProductIndex;
    }

    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'product_slug' => [
                'source' => 'product_name',
            ],
        ];
    }

    public static function filterProduct($filter = [])
    {
        $builder = self::query();

        $query = $filter['q'] ?? '';

        $builder->select('products.id', 'products.product_name', 'products.product_code', 'products.short_description',
            'product__images.main as product_image')
            ->join('product__images', 'products.id', '=', 'product__images.product_id');

        if (is_string($query)) {
            $builder->where('product_code', 'like', strtolower("%{$query}%"))
                ->orWhere('product_name', 'like', strtolower("%{$query}%"))
                ->when(is_numeric($query), fn (Builder $query) => $query->where('products.id', '=', $query))
                ->orWhere('short_description', 'like', strtolower("%{$query}%"));
        }

        if (is_array($query)) {
            $builder->whereIn('products.id', $query);
        }

        return $builder;

    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function skuAttributes()
    {
        $sku_default_attributes = $this->sku_default_attributes;

        if (empty($sku_default_attributes) || ! is_string($sku_default_attributes)) {
            $sku_attributes = [];
        } else {
            $decoded = json_decode($sku_default_attributes, true);
            $sku_attributes = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : [];
        }

        return Attribute::select('id', 'name')->whereIn('id', $sku_attributes)->get();
    }

    /**
     * For Pivot CategoryProduct
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'category_product',
            'product_id',
            'category_id'
        )->withTimestamps();
    }

    public function categoryProduct()
    {
        return $this->hasMany(CategoryProduct::class);
    }

    public function CustomerGroupPrice(): BelongsToMany
    {
        return $this->belongsToMany(CustomerGroup::class)
            ->withPivot(['price'])
            ->withTimestamps();
    }

    public function documents(): BelongsToMany
    {
        return $this
            ->belongsToMany(DocumentType::class, 'document_type_product')
            ->withPivot('file_path');
    }

    public function getDefaultDocumentTypeAttribute(): ?DocumentType
    {
        $defaultTypeId = config('amplify.pim.document_type');

        return $this->documents()
            ->where('document_types.id', $defaultTypeId)
            ->first();

    }

    /**
     * For Pivot AttributeProduct
     */
    public function attributes(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                Attribute::class,
                'attribute_product',
                'product_id',
                'attribute_id'
            )
            ->orderBy('attribute_id', 'asc')
            ->withTimestamps()
            ->withPivot(['attribute_value']);
    }

    public function attributeValue(): BelongsToMany
    {
        return $this->belongsToMany(AttributeValue::class);
    }

    public function option(): HasMany
    {
        return $this->hasMany(Option::class);
    }

    public function manufacturerRelation(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id', 'id');
    }

    /**
     * No spelling mistake there is a db column as *manufacturer*
     */
    public function manufacturerr(): BelongsTo
    {
        return $this->manufacturerRelation();
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function singleProductPage(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'single_product_page_id', 'id');
    }

    /**
     * For Pivot OptionProduct
     */
    public function options(): BelongsToMany
    {
        return $this->belongsToMany(
            Option::class,
            'option_product',
            'product_id',
            'option_id'
        )
            ->withTimestamps();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function productClassification(): BelongsTo
    {
        return $this->belongsTo(ProductClassification::class);
    }

    public function productImage(): HasOne
    {
        return $this->hasOne(ProductImage::class);
    }

    public function attributeValues(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function skuProducts()
    {
        return $this->belongsToMany(Product::class, SkuProduct::class, 'parent_id', 'sku_id');
    }

    public function parentProducts()
    {
        return $this->belongsToMany(Product::class, SkuProduct::class, 'sku_id', 'parent_id');
    }

    public function modelCodes(): BelongsToMany
    {
        return $this->belongsToMany(ModelCode::class);
    }

    public function skuParent()
    {
        return $this->belongsTo(Product::class, 'parent_id');
    }

    public function skuProductList()
    {
        if ($this->has_sku) {
            return self::where('parent_id', $this->id)->get();
        } elseif ($this->parent_id) {
            return self::where('parent_id', $this->parent_id)->get();
        } else {
            return [];
        }
    }

    public function importDefinitionJobProduct()
    {
        return $this->hasMany(ImportDefinitionJobProduct::class);
    }

    public function attributeProduct()
    {
        return $this->hasMany(AttributeProduct::class);
    }

    public function campaigns(): BelongsToMany
    {
        return $this->belongsToMany(Campaign::class, 'campaign_products');
    }

    /**
     * @return string|null
     *
     * @throws JsonException
     */
    private function getDataOfAvailableLocale($original_field_name)
    {
        $locale = $_GET['locale'] ?? app()->getLocale();
        $data = $this->getTranslation($original_field_name, $locale);
        if (empty($data)) {
            try {
                $original_data = json_decode(($this->attributes[$original_field_name] ?? '{}'),
                    true, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
                // Handle the exception (e.g., log, provide a default value, etc.)
                $original_data = [];
            }
            $data = $original_data->{$locale} ?? collect($original_data)->first();
        }

        return $data;
    }

    private function getprivotLocalevalue($original_field_name)
    {
        $locale = $_GET['locale'] ?? app()->getLocale();
        $data = $this->getTranslation($original_field_name, $locale);

        if (empty($data)) {
            try {
                $original_data = json_decode(($this->attributes[$original_field_name] ?? '{}'),
                    true, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
                // Handle the exception (e.g., log, provide a default value, etc.)
                $original_data = [];
            }
            $data = $original_data->{$locale} ?? collect($original_data)->first();
        }

        return $data;
    }

    public function relatedProducts()
    {
        return $this->belongsToMany(
            Product::class, // Related model
            'product_relationships', // Pivot table
            'product_id', // Foreign key on pivot for this model
            'related_product_id' // Foreign key on pivot for the related model
        ); // eager load relationship type will be added later
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeProductCode(Builder $builder, string $product_code)
    {
        return $builder->where('product_code', '=', $product_code);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getProductIdAttribute(): int
    {
        return $this->id;
    }

    /**
     * @return string
     *
     * @throws JsonException
     */
    public function getLocalProductNameAttribute()
    {
        return $this->attributes['local_product_name'] = $this->getDataOfAvailableLocale('product_name');
    }

    /**
     * @return string
     *
     * @throws JsonException
     */
    public function getLocalModelNameAttribute()
    {
        return $this->attributes['local_model_name'] = $this->model_name
            ? $this->getDataOfAvailableLocale('model_name')
            : '';
    }

    /**
     * @return string
     *
     * @throws JsonException
     */
    public function getLocalShortDescriptionAttribute()
    {
        return $this->attributes['local_short_description'] = $this->short_description
            ? $this->getDataOfAvailableLocale('short_description')
            : '';
    }

    /**
     * @return string
     *
     * @throws JsonException
     */
    public function getLocalDescriptionAttribute()
    {
        return $this->attributes['local_description'] = $this->description
            ? $this->getDataOfAvailableLocale('description')
            : '';
    }

    /**
     * @return string
     */
    /*public function getIdProductNameAttribute(): string
    {
        return $this->id . ' - ' . $this->getLocalProductNameAttribute();
    }*/

    /**
     * @return mixed
     */
    public function getOldImageAttribute()
    {
        return $this->image;
    }

    public function getDisplayNameAttribute()
    {
        return $this->product_code.' - '.$this->product_name;
    }

    public function getAvailabilityAttribute(): ProductAvailabilityEnum
    {
        $code = trim($this->flags['availability'] ?? 'A');

        return ProductAvailabilityEnum::tryFrom($code);
    }

    public function getShipRestrictionAttribute(): ?string
    {
        return trim(preg_replace('/^(<br\s*\/?>|\s|&nbsp;|\\\n|\\\t)+/i', '', $this->flags['ship_restriction'] ?? ''));
    }

    public function getPricingAttribute(): ?string
    {
        return trim($this->flags['price'] ?? 'D') == 'D';
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setShipRestrictionAttribute($value = null)
    {
        $flags = $this->attributes['flags'];
        if (empty($flags)) {
            $flags = [];
        }

        if (is_string($flags)) {
            $flags = json_decode($flags, true);
        }

        $flags['ship_restriction'] = $value;

        $this->attributes['flags'] = json_encode($flags);
    }

    public function setProductCodeAttribute($value): void
    {
        $this->attributes['product_code'] = $value;
        $this->attributes['published_at'] = $this->status === 'published'
            ? now()
            : null;
        $this->attributes['archived_at'] = $this->status === 'archived'
            ? now()
            : null;
    }
}
