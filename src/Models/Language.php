<?php

namespace Amplify\System\Backend\Models;

use Amplify\System\Backend\Traits\UpdateImageTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;

class Language extends Model implements Auditable
{
    use CrudTrait, HasFactory, UpdateImageTrait;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id'];

    public function setFlagAttribute($value)
    {
        $attribute_name = 'flag';
        $disk = 'uploads';
        $destination_path = 'images/flags';
        $oldImage = Str::replaceFirst($disk.'/', '', $this->{$attribute_name});

        // if the image was erased
        if ($value == null) {
            // delete the image from disk
            if ($oldImage && Storage::disk($disk)->exists($oldImage)) {
                Storage::disk($disk)->delete($oldImage);
            }

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (Str::startsWith($value, 'data:image')) {
            // 0. Make the image
            $image = \Image::make($value)->encode('png', 90);

            // 1. Generate a filename.
            $destination_path = $destination_path.'/'.md5($value.time()).'.png';

            // 2. Store the image on disk.
            Storage::disk($disk)->put($destination_path, $image->stream());

            // 3. Delete the previous image, if there was one.
            if ($oldImage && Storage::disk($disk)->exists($oldImage)) {
                Storage::disk($disk)->delete($oldImage);
            }

            // 4. Save the path to the database
            $this->attributes[$attribute_name] = $disk.'/'.$destination_path;
        }
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::saved(function (self $model) {
            $languages = static::select('name', 'code')->get()->pluck('name', 'code')->toArray();
            @file_put_contents(public_path('locale-lang.js'), json_encode($languages, JSON_UNESCAPED_UNICODE, JSON_PRETTY_PRINT));
        });
    }
}
