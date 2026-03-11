<?php

namespace Amplify\System\Backend\Models;

use Amplify\System\Cms\Models\BannerZone;
use Amplify\System\Cms\Models\Page;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;

class Webinar extends Model implements Auditable
{
    use CrudTrait;
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id'];

    protected $casts = [
        'additional_photos' => 'array',
        'start_date_time' => 'datetime',
        'end_date_time' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (self $model) {
            $model->slug = Str::slug($model->title.Str::random(8));
            //            $model->cover_photo = url(config('amplify.frontend.fallback_image_path'));
            $model->getDirty();
        });
    }

    public function webinarType()
    {
        return $this->belongsTo(WebinarType::class);
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function bannerZone()
    {
        return $this->belongsTo(BannerZone::class);
    }

    public static function guessCurrentWebinar()
    {
        $event = request()->route('event_slug');

        if (! $event) {
            abort(404, 'Event Parameter is missing');
        }

        return self::where('slug', $event)->first();
    }

    public static function fetchWebinarPagination(array $filters = [])
    {
        $query = self::query();

        return $query->paginate($filters['per_page'] ?? getPaginationLengths()[0]);
    }
}
