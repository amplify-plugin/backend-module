<?php

namespace Amplify\System\Backend\Http\Controllers\Admin\Charts;

use Amplify\System\Backend\Models\CustomerOrder;
use Backpack\CRUD\app\Http\Controllers\ChartController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Carbon\Carbon;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

/**
 * Class MonthlyOrderAmountChartController
 *
 * @property-read CrudPanel $crud
 */
class MonthlyOrderAmountChartController extends ChartController
{
    public function setup()
    {
        $this->chart = new Chart;

        // MANDATORY. Set the labels for the dataset points
        $labels = [];
        $daysInMonth = Carbon::now()->month(Carbon::now()->month)->daysInMonth;

        for ($days_backwards = 1; $days_backwards <= $daysInMonth; $days_backwards++) {
            $labels[] = $days_backwards;
        }
        $this->chart->labels($labels);

        // RECOMMENDED.
        // Set URL that the ChartJS library should call, to get its data using AJAX.
        $this->chart->load(backpack_url('charts/monthly-order-amount'));

        // OPTIONAL.
        $this->chart->minimalist(false);
        $this->chart->displayLegend(true);
    }

    /**
     * Respond to AJAX calls with all the chart data points.
     *
     * @return void
     */
    public function data()
    {
        $daysInMonth = Carbon::now()->month(Carbon::now()->month)->daysInMonth;

        for ($days_backwards = 1; $days_backwards <= $daysInMonth; $days_backwards++) {
            // Could also be an array_push if using an array rather than a collection.
            $orders[] = CustomerOrder::whereDate('created_at', Carbon::now()->firstOfMonth()
                ->addDays($days_backwards - 1))
                ->sum('total_amount');
        }

        $this->chart->dataset('Amount', 'line', $orders)
            ->color('rgb(77, 189, 116)')
            ->backgroundColor('rgba(77, 189, 116, 0.4)');
    }
}
