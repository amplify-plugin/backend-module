<?php

namespace Amplify\System\Backend\Http\Controllers\Admin\Charts;

use Amplify\System\Backend\Http\Controllers\Admin\Charts\Traits\OrderDataQuarterlyTrait;
use App\Http\Controllers\Admin\Charts\json;
use Backpack\CRUD\app\Http\Controllers\ChartController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Support\Facades\Cache;

/**
 * Class WeeklyOrderByQuarterlyChartController
 *
 * @property-read CrudPanel $crud
 */
class WeeklyOrderByQuarterlyChartController extends ChartController
{
    use OrderDataQuarterlyTrait;

    public function setup()
    {
        $this->chart = new Chart;

        $totalData = count($this->fetchData());
        $labels = [];
        for ($week = 1; $week <= $totalData; $week++) {
            $labels[] = generate_ordinal($week).' week';
        }
        // MANDATORY. Set the labels for the dataset points
        $this->chart->labels($labels);

        // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
        $this->chart->load(backpack_url('charts/weekly-order-by-quarterly'));

        // OPTIONAL
        // $this->chart->minimalist(false);
        // $this->chart->displayLegend(true);
    }

    /**
     * Respond to AJAX calls with all the chart data points.
     *
     * @return json
     */
    public function data()
    {
        $orderDataset = Cache::get('orderDataset');
        Cache::forget('orderDataset');

        $this->chart->dataset('Order', 'bar', $orderDataset)
            ->color('rgba(205, 32, 31, 1)')
            ->backgroundColor('rgba(205, 32, 31, 0.4)');
    }

    public function fetchData(): array
    {

        $weeklyOrder = $this->getWeeklyOrderData();
        // Store data in the cache
        Cache::put('orderDataset', $weeklyOrder);

        return $weeklyOrder;

    }
}
