<?php

namespace Amplify\System\Backend\Models;

use Amplify\System\Backend\Traits\HasSlug;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as DbCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Tag extends Model
{
    use CrudTrait;
    use HasFactory;
    use HasSlug;

    protected $fillable = ['name'];

    public $guarded = [];

    public function scopeWithType(Builder $query, ?string $type = null): Builder
    {
        if (is_null($type)) {
            return $query;
        }

        return $query->where('type', $type)->ordered();
    }

    public function scopeContaining(Builder $query, string $name, $locale = null): Builder
    {
        $locale = $locale ?? app()->getLocale();

        return $query->whereRaw('lower(`name`)', 'like', '%'.mb_strtolower($name).'%');
    }

    /**
     * @param  string|array|\ArrayAccess  $values
     * @return \Spatie\Tags\Tag|static
     */
    public static function findOrCreate($values, ?string $type = null, ?string $locale = null)
    {
        $tags = collect($values)->map(function ($value) use ($type, $locale) {
            if ($value instanceof self) {
                return $value;
            }

            return static::findOrCreateFromString($value, $type, $locale);
        });

        return is_string($values) ? $tags->first() : $tags;
    }

    public static function getWithType(string $type): DbCollection
    {
        return static::withType($type)->ordered()->get();
    }

    public static function findFromString(string $name, ?string $type = null, ?string $locale = null)
    {
        return static::query()
            ->where('name', $name)
            ->where('type', $type)
            ->first();
    }

    public static function findFromStringOfAnyType(string $name, ?string $locale = null)
    {
        return static::query()
            ->where('name', $name)
            ->first();
    }

    protected static function findOrCreateFromString(string $name, ?string $type = null, ?string $locale = null)
    {

        $tag = static::findFromString($name, $type);

        if (! $tag) {
            $tag = static::create([
                'name' => $name,
                'type' => $type,
            ]);
        }

        return $tag;
    }

    public static function getTypes(): Collection
    {
        return static::groupBy('type')->pluck('type');
    }

    public function scopeOrdered(Builder $query, string $direction = 'asc')
    {
        return $query->orderBy($this->determineOrderColumnName(), $direction);
    }

    public function determineOrderColumnName(): string
    {
        return 'order_column';
    }
}
