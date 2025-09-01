<?php

namespace Amplify\System\Backend\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasTags
{
    public function scopeTagExists(Builder $query, string $tag): bool
    {
        return $query->withAnyTags($tag)->exists();
    }
}
