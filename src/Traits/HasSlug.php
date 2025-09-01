<?php

namespace Amplify\System\Backend\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    // public static function bootHasSlug()
    // {
    //     static::creating(function (Model $model) {
    //         $model->slug = \Str::slug($model->name);
    //         $model->getDirty();
    //     });
    // }

    public static function bootHasSlug()
    {
        static::creating(function (Model $model) {
            $model->slug = $model->generateSlug();
            $model->getDirty();
        });
    }

    protected function generateSlug(?string $locale = null): string
    {
        $slugger = config('tags.slugger');

        $slugger = $slugger ?: '\Illuminate\Support\Str::slug';

        return call_user_func($slugger, $this->name);
    }
}
