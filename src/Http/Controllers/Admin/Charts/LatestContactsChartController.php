<?php

namespace Amplify\System\Backend\Http\Controllers\Admin\Charts;

use Amplify\System\Backend\Models\Contact;
use App\Http\Controllers\Admin\Charts\json;
use Backpack\CRUD\app\Http\Controllers\ChartController;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class LatestContactsChartController extends ChartController
{
    public function setup()
    {
        $this->chart = new Chart;

        // Generate labels for the last 6 months
        $labels = collect(range(5, 0))->map(function ($i) {
            return now()->subMonths($i)->format('F Y'); // e.g., "April 2024"
        })->toArray();

        $this->chart->labels($labels);

        // AJAX route for chart data
        $this->chart->load(backpack_url('charts/contacts'));

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

        // Get contact count for each of the last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $start = now()->subMonths($i)->startOfMonth();
            $end = now()->subMonths($i)->endOfMonth();

            $count = Contact::whereBetween('created_at', [$start, $end])->count();

            $data[] = $count;
        }

        $this->chart->dataset('Contacts Created', 'bar', $data)
            ->color('rgb(66, 186, 150, 1)')
            ->backgroundColor('rgb(66, 186, 150, 0.4)');
    }
}
