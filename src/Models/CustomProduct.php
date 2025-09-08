<?php

namespace Amplify\System\Backend\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomProduct extends Model
{
    use CrudTrait;
    use HasFactory;

    const PRODUCT_TYPE = [
        'cutting-board' => 'Cutting Board',
        'gasket' => 'Gasket',
        'replacement-strip-curtains' => 'Replacement Strip Curtains',
        'strip-curtains-bulk' => 'Strip Curtains Bulk',
        'tubular-heaters' => 'Tubular Heaters',
    ];

    protected $guarded = ['id'];
}
