<?php

namespace Amplify\System\Backend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use OwenIt\Auditing\Contracts\Auditable;

class FlatDiscount extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'flat_discounts';

    protected $guarded = ['id'];

    use HasFactory;

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
