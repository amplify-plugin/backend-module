<?php

namespace Amplify\System\Backend\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedDynamicReport extends Model
{
    use CrudTrait;
    use HasFactory;

    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = ['report' => 'array'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    const REPORT_TYPE = [
        'DataTable' => 'DataTable',
        'PieChart' => 'Pie Chart',
        'BarChart' => 'Bar Chart',
        'LineChart' => 'Line Chart',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function viewReport($crud = false)
    {
        return '<a class="btn btn-sm btn-link" target="_blank" href="'.route('dynamic-report.index', ['report' => $this->id]).'"><i class="la la-chart-bar"></i> Report</a>';
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo(ReportCategory::class, 'report_category_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
