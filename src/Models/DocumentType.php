<?php

namespace Amplify\System\Backend\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @property-read string|null $file_path
 */
class DocumentType extends Model implements Auditable
{
    use CrudTrait;
    use \OwenIt\Auditing\Auditable;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'document_types';

    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];

    // protected $fillable = [];
    // protected $hidden = [];

    protected $appends = ['label'];

    public const MEDIA_TYPES = [
        'image' => 'Image',
        'video' => 'Video',
        'pdf' => 'PDF',
        'xls' => 'Excel Sheet',
        'doc' => 'Word Document',
        'google_doc' => 'Google Document',
        'google_sheet' => 'Google Sheet',
        'embedded' => 'Embedded Content',
        'octet-stream' => 'Octet Stream',
    ];

    public const ACCEPT_FILE_TYPES = [
        'image' => 'image/*',
        'video' => 'video/*',
        'pdf' => '.pdf',
        'xls' => '.xls,.xlsx',
        'doc' => '.doc,.docx',
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

    public function products(): BelongsToMany
    {
        return $this
            ->belongsToMany(Product::class, 'document_type_product')
            ->withPivot('file_path');
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
    public function getLabelAttribute()
    {
        return $this->attributes['label'] = $this->attributes['name'];
    }

    public function getFilePathAttribute(): ?string
    {
        return $this?->pivot?->file_path ?? null;
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
