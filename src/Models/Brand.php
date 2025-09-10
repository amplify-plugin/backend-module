<?php

namespace Amplify\System\Backend\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Brand extends Model implements Auditable
{
    use CrudTrait, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'brands';

    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];

    // protected $fillable = [];
    // protected $hidden = [];

    protected $appends = ['old_image'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function changeStatus()
    {
        if ($this->deleted_at) {
            return '<a class="btn btn-sm btn-link pr-0" href="javascript:void(0)" title="Make Publish" onclick="firePublishAction('.$this->id.')">
                        <i class="la la-check-circle"></i> Publish
                    </a>';
        } else {
            return '<a class="btn btn-sm btn-link pr-0" href="javascript:void(0)" title="Make Publish" onclick="fireArchiveAction('.$this->id.')">
                        <i class="la la-check-circle"></i> Archive
                    </a>';
        }
    }

    protected static function booted()
    {
        static::creating(function ($brand) {
            if (empty($brand->slug) && ! empty($brand->title)) {
                $brand->slug = self::generateSlug($brand->title);
            }
        });

        static::updating(function ($brand) {
            if ($brand->isDirty('title') && ! empty($brand->title)) {
                $brand->slug = self::generateSlug($brand->title);
            }
        });
    }

    /**
     * Generate a slug from a string.
     */
    protected static function generateSlug(string $string): string
    {
        $string = trim($string);
        // Remove apostrophes
        $string = str_replace("'", '', $string);
        // Replace non-alphanumeric characters with hyphen
        $string = preg_replace('/[^A-Za-z0-9]+/', '-', $string);
        // Collapse multiple hyphens
        $string = preg_replace('/-+/', '-', $string);

        // Trim leading/trailing hyphens
        return trim($string, '-');
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

    /**
     * @return mixed
     */
    public function getOldImageAttribute()
    {
        return $this->image;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
