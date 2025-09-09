@extends(backpack_view('blank'))
<?php

use \koolreport\widgets\koolphp\Table;
use \koolreport\widgets\google\ColumnChart;
use \koolreport\widgets\google\LineChart;
use \koolreport\widgets\google\BarChart;
use \koolreport\widgets\google\PieChart;
?>
@section('header')
    <div class="container-fluid">
        <h2 class="mb-4">
            <span class="text-capitalize">Report</span>
            <small>
                <a href="{{ url('admin/report') }}" class="font-sm">
                    <i class="la la-angle-double-left"></i>
                    Back to all <span>Report</span>
                </a>
            </small>
        </h2>
    </div>
@endsection

@section('content')

    @foreach ($sql as $item)
        <h5>{{$item}}</h5>
    @endforeach
<?php
    if ($report->type == "bar") {
        BarChart::create(
            getReportData($data, $report, $title = null),
        );
    } elseif ($report->type == "pie") {
        PieChart::create(
            getReportData($data, $report, $title = null),
        );
    } elseif ($report->type == "line") {
        LineChart::create(
            getReportData($data, $report, $title = null),
        );
    }elseif ($report->type == "column") {
        ColumnChart::create(
            getReportData($data, $report, $title = null),
        );
    }else {
        Table::create(
            getReportData($data, $report, $title = "Title"),
        );
    }
    ?>

@endsection
