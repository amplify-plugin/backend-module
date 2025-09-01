<?php

namespace Amplify\System\Backend\Models\Mutators;

trait ImageMutator
{
    protected $destination_path = '';

    public function setImageAttribute($value)
    {
        $this->destination_path = config('backpack.base.root_disk_base')
                                  .'/images/'
                                  .strtolower(class_basename(get_class($this)));
        $attribute_name = 'image';

        // or use your own disk, defined in config/filesystems.php
        $disk = config('backpack.base.root_disk_name', 'public_uploads');
        // destination path relative to the disk above
        $destination_path = $this->destination_path ?? config('backpack.base.root_disk_base');

        $uploaded_path = $this->updateImage($value, $this->{$attribute_name}, $disk, $destination_path);

        $this->attributes[$attribute_name] = $uploaded_path;
    }
}
