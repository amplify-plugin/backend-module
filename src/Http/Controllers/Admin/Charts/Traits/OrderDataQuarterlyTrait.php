<?php

namespace Amplify\System\Backend\Http\Controllers\Admin\Charts\Traits;

use Amplify\System\Backend\Models\CustomerOrder;
use DateTime;
use Illuminate\Support\Facades\DB;

trait OrderDataQuarterlyTrait
{
    /**
     * getWeeklyOrderData
     *
     * @param  mixed  $lstQuarter
     */
    public function getWeeklyOrderData($lstQuarter = false): array
    {
        $currentYear = date('Y');
        $currentMonth = date('m', time());
        $currentQuarter = (int) ceil($currentMonth / 3);

        if ($lstQuarter) {
            $currentQuarter = $currentQuarter == 1 ? 4 : $currentQuarter - 1;
        }

        $firstMonth = ($currentQuarter - 1) * 3 + 1;
        $firstDay = new DateTime("$currentYear-$firstMonth-01");

        $lastMonth = $firstMonth + 2;
        $lastDay = new DateTime("last day of $currentYear-$lastMonth");

        $startDate = $firstDay->format('Y-m-d');
        $endDate = $lastDay->format('Y-m-d');

        $orderData = CustomerOrder::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('WEEK(created_at) as week'),
            DB::raw('COUNT(*) as order_count')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('year', 'week')
            ->get()->toArray();

        $weeklyOrder = array_map(function ($object) {
            return $object['order_count'];
        }, $orderData);

        return $weeklyOrder;
    }
}
