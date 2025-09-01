<?php

namespace Amplify\System\Backend\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UpdateImageTrait
{
    /**
     * Removes the old image from storage and uploads new image into the storage
     * Returns image location
     */
    public function updateImage($newImage, $oldImage, $disk, $destination_path): ?string
    {
        // dd($newImage, $oldImage, $disk, $destination_path);

        $oldImage = Str::replaceFirst($disk.'/', '', $oldImage);

        if ($oldImage && Storage::disk($disk)->exists($oldImage)) {
            Storage::disk($disk)->delete($oldImage);
        }

        if (! $newImage) {
            return null;
        }

        // if a base64 was sent, store it in the db
        if (Str::startsWith($newImage, 'data:image')) {
            // 0. Make the image
            $image = \Image::make($newImage)->encode('png', 90);

            // 1. Generate a filename.
            $destination_path = $destination_path.'/'.md5($newImage.time()).'.png';

            // 2. Store the image on disk.
            Storage::disk($disk)->put($destination_path, $image->stream());

            // 3. Delete the previous image, if there was one.
            if ($oldImage && Storage::disk($disk)->exists($oldImage)) {
                Storage::disk($disk)->delete($oldImage);
            }

            // 4. return the path to store in the database
            return $disk.'/'.$destination_path;
        } else {
            return $newImage;
        }
    }
}
