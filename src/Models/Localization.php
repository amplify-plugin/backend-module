<?php

namespace Amplify\System\Backend\Models;

use Amplify\System\Jobs\DispatchLocalizationGenerator;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Localization extends Model implements Auditable
{
    use CrudTrait;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'localizations';

    protected $guarded = ['id'];

    protected $casts = ['lang' => 'array'];

    public static function boot()
    {
        parent::boot();

        $fn = function () {
            DispatchLocalizationGenerator::dispatch();
        };
        static::created($fn);
        static::updated($fn);
        static::deleted($fn);
    }
}
