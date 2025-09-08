<?php

namespace Amplify\System\Backend\Http\Controllers\Admin\Charts;

use Amplify\System\Backend\Models\Customer;
use App\Http\Controllers\Admin\Charts\json;
use Backpack\CRUD\app\Http\Controllers\ChartController;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class LatestCustomersChartController extends ChartController
{
    public function setup()
    {
        $this->chart = new Chart;

        // Labels for last 6 months (e.g., "Jan 2024", "Feb 2024", ...)
        $labels = collect(range(5, 0))->map(function ($i) {
            return now()->subMonths($i)->format('M Y');
        })->toArray();

        $this->chart->labels($labels);
        $this->chart->load(backpack_url('charts/customers'));
        $this->chart->minimalist(false);
        $this->chart->displayLegend(true);
    }

    /**
     * Respond to AJAX calls with all the chart data points.
     *
     * @return json
     */
    public function data()
    {
        $data = [];

        // Get customer count for each of the last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $startOfMonth = now()->subMonths($i)->startOfMonth();
            $endOfMonth = now()->subMonths($i)->endOfMonth();

            $count = Customer::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $data[] = $count;
        }

        $this->chart->dataset('Customers Created', 'bar', $data)
            ->color('rgb(66, 186, 150, 1)')
            ->backgroundColor('rgb(66, 186, 150, 0.4)');
    }
}
