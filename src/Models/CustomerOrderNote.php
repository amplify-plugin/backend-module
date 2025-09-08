<?php

namespace Amplify\System\Backend\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrderNote extends Model
{
    use CrudTrait;
    use HasFactory;

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'subject' => 'Order Note',
        'type' => 'SOEH',
    ];

    protected $fillable = ['customer_order_id', 'subject', 'note', 'type', 'erp_note_id', 'date'];

    public function order()
    {
        return $this->belongsTo(CustomerOrder::class);
    }
}
