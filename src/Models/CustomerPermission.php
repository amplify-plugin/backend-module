<?php

namespace Amplify\System\Backend\Models;

class CustomerPermission extends Permission
{
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = str_replace(' ', '-', $value); // Remove leading and trailing whitespace
    }
}
