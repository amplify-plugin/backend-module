<?php

namespace Amplify\System\Backend\Models;

use Amplify\System\Backend\Traits\DynamicDBConnectionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AttributeProductClassification extends Model implements Auditable
{
    use DynamicDBConnectionTrait, HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'attribute_product_classification';
}
