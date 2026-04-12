<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\ReportRequest;
use Amplify\System\Backend\Models\CustomerOrderLine;
use Amplify\System\Backend\Models\Report;
use Amplify\System\Backend\Models\ReportCondition;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\DB;

/**
 * Class ReportCrudController
 *
 * @property-read CrudPanel $crud
 */
class ReportCrudController extends BackpackCustomCrudController
{
    use CreateOperation;
    use DeleteOperation;
    use ListOperation;
    use ShowOperation;
    use UpdateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Report::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/report');
        CRUD::setEntityNameStrings('report', 'reports');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     *
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addButtonFromView('line', 'viewreport', 'viewreport', 'beginning');

        CRUD::addColumn([
            'name' => 'id',
            'label' => '#',
        ]);
        CRUD::addColumn([
            'name' => 'title',
            'label' => 'Title',
        ]);
        CRUD::addColumn([
            'name' => 'type',
            'label' => 'Chart Type',
        ]);
        // CRUD::addColumn([   // Color
        //     'name' => 'color',
        //     'label' => 'Color',
        // ]);
        CRUD::addColumn([
            'name' => 'prefix',
            'label' => 'Prefix',
        ]);
        CRUD::addColumn([
            'name' => 'suffix',
            'label' => 'Suffix',
        ]);
        CRUD::addColumn([
            'name' => 'datasource',
            'label' => 'Source',
        ]);
        CRUD::addColumn([
            'name' => 'source_type',
            'label' => 'Group Type',
        ]);

        CRUD::denyAccess('update');
        CRUD::denyAccess('show');

        // add new button
        // $this->crud->button('viewreport')->stack('line')->view('crud::buttons.viewreport');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    public function store(ReportRequest $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $report = new Report;
            $report->title = $request->title;
            $report->type = $request->type;
            $report->prefix = $request->prefix;
            $report->suffix = $request->suffix;
            $report->datasource = $request->datasource;
            $report->source_type = $request->source_type;
            $report->count_type = $request->count_type;
            $report->sum_by = $request->sum_by;
            $report->take_range = $request->take_range;
            $report->save();
            if ($request->reportConditions) {
                foreach ($request->reportConditions as $key => $value) {
                    $reportCondition = new ReportCondition;
                    $reportCondition->report_id = $report->id;
                    $reportCondition->group_type_name = $value['group_type_name'];
                    $reportCondition->group_type = $value['group_type'];
                    $reportCondition->conditions = json_encode($value['conditionLists']);
                    $reportCondition->save();
                }
            }
            DB::commit();

            return back();
        } catch (\Exception $e) {
            DB::rollback();

            return back()->withInput()->withErrors($e->getMessage());
        }
    }

    protected function setupShowOperation()
    {
        CRUD::addColumn([
            'name' => 'id',
            'label' => '#',
        ]);
        CRUD::addColumn([
            'name' => 'title',
            'label' => 'Title',
        ]);
        CRUD::addColumn([
            'name' => 'type',
            'label' => 'Type',
        ]);
        CRUD::addColumn([   // Color
            'name' => 'color',
            'label' => 'Color',
        ]);
        CRUD::addColumn([
            'name' => 'prefix',
            'label' => 'Prefix',
        ]);
        CRUD::addColumn([
            'name' => 'suffix',
            'label' => 'Suffix',
        ]);

        CRUD::addColumn([
            'name' => 'datasource',
            'label' => 'Datasource',
            'type' => 'text',
        ]);

        CRUD::addColumn([
            'name' => 'intervals',
            'label' => 'Intervals',
            'type' => 'table',
            'entity_singular' => 'interval', // used on the "Add X" button
            'columns' => ['Integer', 'Label'],
            'max' => 15, // maximum rows allowed in the table
            'min' => 0,
        ]);

        CRUD::addColumn([
            'name' => 'format',
            'label' => 'Format',
            'type' => 'text',
        ]);

    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     *
     * @return void
     */
    protected function setupCreateOperation()
    {
        // CRUD::setValidation(ReportRequest::class);

        CRUD::setCreateView('backend::pages.report.create');

        // Widget::add()->type('script')->content(asset('vendor/backend/js/forms/report.js'));
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     *
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->crud->getCurrentEntry()->reportConditions;

        CRUD::setUpdateView('backend::pages.report.create');
        $this->setupCreateOperation();
    }

    public function viewreport($id)
    {
        $sql = [];
        $report = Report::find($id);

        if ($report->source_type == 'top_product') {
            // tor product get top 10 product
            $query = CustomerOrderLine::with('product');
            $query = $query->select('product_code', DB::raw('count(*) as total'));
            $query = $query->groupBy('product_code');
            $query = $query->orderBy('total', 'desc');
            $query = $query->take($report->take_range ?? 10);
            $query = $query->get();

            $data = [];
            foreach ($query as $key => $value) {
                $data[] = ['column1' => $value->product_code, 'column2' => $value->total];
            }
        } else {

            foreach ($report->reportConditions as $key => $reportCondition) {
                $query = DB::table($report->datasource);
                $query = $query->where($report->source_type, $reportCondition->group_type);
                $conditions = json_decode($reportCondition->conditions);
                $groupedConditions = [];
                foreach ($conditions as $key => $value) {
                    if ($value->column_name !== null) {
                        if (! isset($groupedConditions[$value->column_name])) {
                            // If it's the first time encountering this column_name, use 'where'
                            $groupedConditions[$value->column_name] = ['where', []];
                        }
                        // Append the condition using 'orWhere'
                        $groupedConditions[$value->column_name][1][] = [$value->operator, $value->value];
                    }
                }
                foreach ($groupedConditions as $columnName => $conditionData) {
                    [$method, $conditions] = $conditionData;
                    $query->$method(function ($query) use ($columnName, $conditions) {
                        foreach ($conditions as $condition) {
                            $query->orWhere($columnName, $condition[0], $condition[1]);
                        }
                    });
                }

                array_push($sql, $query->toRawSql());
                if ($report->count_type == 'count') {
                    $query = $query->count();
                } else {
                    $query = $query->sum($report->sum_by);
                }
                $data[] = ['column1' => $reportCondition->group_type_name, 'column2' => $query];
            }
        }

        // dd('koi jas');
        return view('backend::pages.report.viewreport', compact('report', 'data', 'sql'));
    }
}
