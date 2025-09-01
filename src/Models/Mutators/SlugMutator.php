<?php

namespace Amplify\System\Backend\Models\Mutators;

use Illuminate\Support\Str;

trait SlugMutator
{
    public function setSlugAttribute($value)
    {
        $attribute_name = 'slug';
        $this->attributes[$attribute_name] = Str::slug($this->title ?? $this->name);
    }
}
