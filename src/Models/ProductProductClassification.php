<?php

namespace Amplify\System\Backend\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProductProductClassification extends Model implements Auditable
{
    use CrudTrait, HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id'];

    protected $table = 'product_product_classification';
}
