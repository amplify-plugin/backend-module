<?php

namespace Amplify\System\Backend\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndustryClassification extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeEnabled(Builder $query): Builder
    {
        return $query->where('status', true);
    }
}
