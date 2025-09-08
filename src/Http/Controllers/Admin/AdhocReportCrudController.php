<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Models\AdhocPromptSuggestion;
use Amplify\System\Backend\Models\ReportCategory;
use Amplify\System\Backend\Models\SavedDynamicReport;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/**
 * Class AdhocReportCrudController
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AdhocReportCrudController extends BackpackCustomCrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;

    protected $baseUrl = '';

    protected $commonQueries;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setRoute(config('backpack.base.route_prefix').'/dynamic-report');
        CRUD::setEntityNameStrings('dynamic-report', 'dynamic reports');

        $this->buildReportApi();
    }

    protected function setupCustomRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/generate-response', [
            'as' => $routeName.'.generate-response',
            'uses' => $controller.'@generateResponse',
            'operation' => 'generateResponse',
        ]);
        Route::post($segment.'/store', [
            'as' => $routeName.'.store',
            'uses' => $controller.'@store',
            'operation' => 'store',
        ]);
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
        $this->data['categories'] = ReportCategory::select('id', 'title')->get();
        $this->data['prompts'] = AdhocPromptSuggestion::whereStatus(1)->select('id', 'report_category_id', 'prompt')->get();
        $this->data['prompt'] = request()->filled('prompt') ? request()->prompt : null;
        $this->data['saved_report'] = request()->filled('report') ? SavedDynamicReport::find(request('report')) : null;
        $this->crud->setListView('crud::pages.report.adhoc-report');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
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
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
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
        $this->setupCreateOperation();
    }

    public function generateResponse(Request $request)
    {
        try {
            $response = Http::timeout(30)
                ->withoutVerifying()
                ->get($this->baseUrl, $this->commonQueries + ['q' => $request->input('query', null)]);

            $preparedData = $this->prepareAdhocRes($response->body());

            return response()->json($preparedData, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'question' => $request->input('query', null),
                'columns' => [],
                'data' => [],
            ], 500);
        }
    }

    private function buildReportApi()
    {
        $this->baseUrl .= config('amplify.report.protocol', 'http').'://';
        $this->baseUrl .= config('amplify.report.host', 'demov16.easyaskondemand1.com');
        $this->baseUrl .= config('amplify.report.port') ? ':'.config('amplify.report.port') : '';
        $this->baseUrl .= '/EasyAsk/apps/TranslateToResults.jsp';

        $this->commonQueries = [
            'dct' => config('amplify.report.business_query_dictionary'),
            'disp' => 'xml',
        ];
    }

    private function prepareAdhocRes($response)
    {
        $res = $this->validateRes($response);
        $question = $res['EA_Question'];
        $preparedData = [];

        if ($res['EA_ReturnCode'] === '0') {
            $columns = $res['EA_ItemDescription']['EA_DataDescription'];
            $columns = array_key_exists('@attributes', $columns) ? [$columns] : $columns;
            $rows = $res['EA_Item'];

            $preparedData = [
                'type' => 'Table',
                'question' => $question,
                'columns' => $columns,
                'data' => isset($rows['@attributes']) ? [$rows] : $rows,
                'show_chart' => count($columns) > 1,
            ];
        } elseif ($res['EA_ReturnCode'] === '-16' && array_key_exists('EA_Clarification', $res)) {
            $preparedData = [
                'type' => 'FixClarification',
                'is_active' => true,
                'question' => $question,
                'data' => $res['EA_Clarification'],
            ];
        } else {
            $preparedData = [
                'type' => 'FixWord',
                'question' => $question,
                'message' => 'I am not familiar with the word or phrase highlighted: '.$question,
            ];
        }

        return $preparedData;
    }

    private function validateRes($response)
    {
        try {
            // Empty Response
            if (is_null($response)) {
                throw new Exception("Empty Response Received ({$response})", 500);
            }

            // Invalid XML
            libxml_use_internal_errors(true);
            $response = simplexml_load_string($response);
            if ($response === false) {
                $error_message = '';
                foreach (libxml_get_errors() as $error) {
                    $error_message .= (' '.$error->message);
                }

                $error_message = trim($error_message);

                throw new Exception($error_message, 500);
            }

            return json_decode(json_encode($response), true);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:query,report',
            'report_category_id' => 'required|integer',
            'title' => 'required_if:type,report|max:255',
            'default_chart' => 'required_if:type,report|in:DataTable,PieChart,BarChart,LineChart',
            'prompt_data' => 'required|array',
            'description' => 'nullable',
        ]);

        switch ($request->type) {
            case 'query':
                AdhocPromptSuggestion::updateOrCreate([
                    'prompt' => $request->prompt_data['question'],
                ], [
                    'report_category_id' => $request->report_category_id,
                ]);
                break;

            case 'report':
                SavedDynamicReport::updateOrCreate([
                    'prompt' => $request->prompt_data['question'],
                ], [
                    'report_category_id' => $request->report_category_id,
                    'title' => $request->title,
                    'report_type' => $request->default_chart,
                    'report' => $request->prompt_data,
                    'description' => $request->input('description', null),
                ]);
                break;
        }

        return response()->json([
            'message' => 'Successfully saved '.$request->type,
        ], 200);
    }
}
