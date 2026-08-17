@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
      trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
      'Server Info' => request()->url()
    ];
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">Server Info</span>
        </h2>
    </section>
@endsection

@section('content')

    <style>

        .amplify-package {
            height: 146px !important;
        }

        @media (max-width: 767px) {
            .amplify-package {
                width: 100%;
            }
        }

        @media (min-width: 768px) {
            .amplify-package {
                width: calc(50% - 1rem);
            }
        }

        @media (min-width: 992px) {
            .amplify-package {
                width: calc(33.33% - 1rem);
            }
        }

    </style>

    <script>
        function reCheckHealth() {
            swal({
                title: "Health Check",
                text: "The process will take more than couple of seconds after that please reload the page.",
                icon: "warning",
                buttons: ["{!! trans('backpack::crud.cancel') !!}", "Check"],
                dangerMode: true,
            }).then((value) => {
                if (value) {
                    $.ajax({
                        url: "{{ route('admin.api.health') }}",
                        data: {fresh: 1},
                        type: 'GET',
                        success: function (result) {

                            // Show a success notification bubble
                            new Noty({
                                type: "success",
                                text: "{!! '<strong>' .
                                        trans('backpack::crud.delete_confirmation_title') .
                                        '</strong><br>' .
                                        trans('backpack::crud.delete_confirmation_message') !!}"
                            }).show();
                        },
                        error: function (result) {
                            // Show an alert with the result
                            swal({
                                title: "{!! trans('backpack::crud.ajax_error_title') !!}",
                                text: result.message,
                                icon: "error",
                                timer: 4000,
                                buttons: false,
                            });
                        }
                    });
                }
            });
        }
    </script>

    <ul class="nav nav-tabs" id="serverInfoTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="health-tab" data-toggle="tab" data-target="#health"
                    type="button" role="tab" aria-controls="health" aria-selected="false">Health
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="package-info-tab" data-toggle="tab" data-target="#package-info"
                    type="button" role="tab" aria-controls="package-info" aria-selected="false">Packages
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="server-info-tab" data-toggle="tab" data-target="#server-info"
                    type="button" role="tab" aria-controls="server-info" aria-selected="true">Server Stats
            </button>
        </li>
    </ul>

    <div class="tab-content" id="serverInfoTabContent">
        <div class="tab-pane fade active show" id="health" role="tabpanel"
             aria-labelledby="health-tab">
            <div class="d-flex justify-content-between">
                <p>Reported At:
                    <code>{{ \Carbon\CarbonImmutable::createFromTimestamp($health['finishedAt'])->format('r') }}</code>.
                </p>
                <button class="btn btn-outline-primary" onclick="reCheckHealth()">ReCheck</button>
            </div>
            @if(!empty($health))

                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-1">
                        <thead>
                        <tr>
                            <th>Test</th>
                            <th>Status</th>
                            <th>Message</th>
                            <th>Meta</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($health['checkResults'] as $test)
                            <tr>
                                <th>{{ $test['label'] }}</th>
                                <td>
                                    @switch($test['name'])
                                        @case('DebugMode')
                                        @case('ErpApiLog')
                                        @case('EasyAskApiLog')
                                            <span @class(['badge px-3 py-2 d-block',
                                    'badge-secondary' => $test['status'] == 'skipped',
                                    'badge-danger' => ( $test['status'] != 'skipped') && ($test['meta']['expected'] != $test['meta']['actual']),
                                    'badge-success' => ( $test['status'] != 'skipped') && ($test['meta']['expected'] == $test['meta']['actual'])])>
                                {{ ucfirst($test['status']) }}
                            </span>
                                            @break

                                        @case('UsedDiskSpace')
                                            <span @class(['badge px-3 py-2 d-block',
                                    'badge-danger' => $test['status'] == 'failed',
                                    'badge-secondary' => $test['status'] == 'skipped',
                                    'badge-warning' => $test['status'] == 'warning',
                                    'badge-success' => $test['status'] =='passed'])>
                                {{ ucfirst($test['shortSummary']) }}
                            </span>
                                            @break

                                        @case('Backups')
                                            <span @class(['badge px-3 py-2 d-block',
                                    'badge-danger' => $test['status'] == 'failed',
                                    'badge-secondary' => $test['status'] == 'skipped',
                                    'badge-warning' => $test['status'] == 'warning',
                                    'badge-success' => $test['status'] =='passed'])>
                                {{ ucfirst($test['shortSummary']) }}
                            </span>
                                            @break

                                        @case('Cache')
                                            <span @class(['badge px-3 py-2 d-block',
                                    'badge-danger' => $test['status'] == 'failed',
                                    'badge-secondary' => $test['status'] == 'skipped',
                                    'badge-success' => $test['status'] =='ok'])>
                                {{ ucfirst($test['shortSummary']) }}
                            </span>
                                            @break

                                        @case('CpuLoad')
                                            <span @class(['badge px-3 py-2 d-block',
                                    'badge-danger' => $test['status'] == 'failed',
                                    'badge-secondary' => $test['status'] == 'skipped',
                                    'badge-success' => $test['status'] =='ok'])>
                                {{ ucfirst($test['shortSummary']) }}
                            </span>
                                            @break

                                        @case('Database')
                                            <span @class(['badge px-3 py-2 d-block',
                                'badge-danger' => $test['status'] == 'failed',
                                'badge-secondary' => $test['status'] == 'skipped',
                                'badge-success' => $test['status'] =='ok'])>
                                    {{ ucfirst($test['shortSummary']) }}
                            </span>
                                            @break

                                        @case('PimDatabase')
                                            <span @class(['badge px-3 py-2 d-block',
                                    'badge-danger' => $test['status'] == 'failed',
                                    'badge-secondary' => $test['status'] == 'skipped',
                                    'badge-success' => $test['status'] =='ok'])>
                                {{ ucfirst($test['shortSummary']) }}
                        </span>
                                            @break

                                        @case('DatabaseConnectionCount')
                                            <span @class(['badge px-3 py-2 d-block',
                                    'badge-danger' => $test['status'] == 'failed',
                                    'badge-secondary' => $test['status'] == 'skipped',
                                    'badge-success' => $test['status'] =='ok'])>
                                {{ ucfirst($test['shortSummary']) }}
                        </span>
                                            @break
                                        @case('DatabaseSize')
                                            <span @class(['badge px-3 py-2 d-block',
                                    'badge-danger' => $test['status'] == 'failed',
                                    'badge-secondary' => $test['status'] == 'skipped',
                                    'badge-success' => $test['status'] =='ok'])>
                                {{ ucfirst($test['shortSummary']) }}
                            </span>
                                            @break

                                        @case('ApiLogsTableSize')
                                            <span @class(['badge px-3 py-2 d-block',
                                    'badge-danger' => $test['status'] == 'failed',
                                    'badge-secondary' => $test['status'] == 'skipped',
                                    'badge-success' => $test['status'] =='ok'])>
                                {{ ucfirst($test['shortSummary']) }}
                            </span>
                                            @break

                                        @case('ActivityLogsTableSize')
                                            <span @class(['badge px-3 py-2 d-block',
                                    'badge-danger' => $test['status'] == 'failed',
                                    'badge-secondary' => $test['status'] == 'skipped',
                                    'badge-success' => $test['status'] =='ok'])>
                                {{ ucfirst($test['shortSummary']) }}
                            </span>
                                            @break

                                        @case('QueueFailedTableSize')
                                            <span @class(['badge px-3 py-2 d-block',
                                    'badge-danger' => $test['status'] == 'failed',
                                    'badge-secondary' => $test['status'] == 'skipped',
                                    'badge-success' => $test['status'] =='ok'])>
                                {{ ucfirst($test['shortSummary']) }}
                            </span>
                                            @break

                                        @case('Environment')
                                            <span @class(['badge px-3 py-2 d-block',
                                    'badge-secondary' => $test['status'] == 'skipped',
                                    'badge-danger' => ( $test['status'] != 'skipped') && ($test['meta']['expected'] != $test['meta']['actual']),
                                    'badge-success' => ( $test['status'] != 'skipped') && ($test['meta']['expected'] == $test['meta']['actual'])])>
                                {{ ucfirst($test['status']) }}
                            </span>
                                            @break
                                            {
                                        @case('SearchEngineAvailability')
                                            <span @class(['badge px-3 py-2 d-block',
                                    'badge-danger' => $test['status'] == 'failed',
                                    'badge-secondary' => $test['status'] == 'skipped',
                                    'badge-success' => $test['status'] =='ok'])>
                                {{ ucfirst($test['shortSummary']) }}
                        </span>
                                            @break

                                        @case('Queue')
                                            <span @class(['badge px-3 py-2 d-block',
                                    'badge-danger' => $test['status'] == 'failed',
                                    'badge-secondary' => $test['status'] == 'skipped',
                                    'badge-success' => $test['status'] =='ok'])>
                                {{ ucfirst($test['shortSummary']) }}
                        </span>
                                            @break

                                        @case('Redis')
                                            <span @class(['badge px-3 py-2 d-block',
                                    'badge-danger' => $test['status'] == 'failed',
                                    'badge-secondary' => $test['status'] == 'skipped',
                                    'badge-success' => $test['status'] =='ok'])>
                                {{ ucfirst($test['shortSummary']) }}
                        </span>
                                            @break

                                        @case('Schedule')
                                            <span @class(['badge px-3 py-2 d-block',
                                    'badge-danger' => $test['status'] == 'failed',
                                    'badge-secondary' => $test['status'] == 'skipped',
                                    'badge-success' => $test['status'] =='ok'])>
                                {{ ucfirst($test['shortSummary']) }}
                        </span>
                                            @break

                                        @case('SslCertificateValidity')
                                            <span @class(['badge px-3 py-2 d-block',
                                    'badge-danger' => $test['status'] == 'failed',
                                    'badge-secondary' => $test['status'] == 'skipped',
                                    'badge-success' => $test['status'] =='ok'])>
                                {{ ucfirst($test['shortSummary']) }}
                        </span>
                                            @break

                                        @case('SslCertificateExpired')
                                            <span @class(['badge px-3 py-2 d-block',
                                    'badge-danger' => $test['status'] == 'failed',
                                    'badge-secondary' => $test['status'] == 'skipped',
                                    'badge-success' => $test['status'] =='ok'])>
                                {{ ucfirst($test['shortSummary']) }}
                        </span>
                                            @break
                                        @case('SiteHealth')
                                            <span @class(['badge px-3 py-2 d-block',
                                    'badge-danger' => $test['status'] == 'failed',
                                    'badge-secondary' => $test['status'] == 'skipped',
                                    'badge-success' => $test['status'] =='ok'])>
                                {{ ucfirst($test['shortSummary']) }}
                        </span>
                                            @break
                                        @default
                                            <span
                                                    class="badge badge-secondary px-3 py-2">{{ ucfirst($test['shortSummary']) }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    <p>
                                        {!! preg_replace('/`([^`]+)`/', '<code>$1</code>', $test['notificationMessage']) !!}
                                    </p>
                                </td>
                                <td>
                                    @if(isset($test['meta']))
                                        <pre>
                                @json($test['meta'], JSON_PRETTY_PRINT)
                            </pre>
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>No Health Report Found</p>
            @endif
        </div>
        <div class="tab-pane fade" id="package-info" role="tabpanel"
             aria-labelledby="package-info-tab">
            <div class="d-flex flex-wrap">
                @foreach($packages as $index => $package)
                    <div class="card shadow amplify-package m-2 border">
                        <div class="card-body p-3">
                            <a href="{{ $package['homepage'] ?? '#' }}" target="_blank" class="text-decoration-none">
                                <h5 class="card-title text-capitalize">
                                    @if($package['abandoned'])
                                        <del>{{$package['name'] ?? 'N/A' }}</del>
                                    @else
                                        {{$package['name'] ?? 'N/A' }}
                                    @endif
                                </h5>
                            </a>

                            <h6 class="card-subtitle mb-2">
                                <span data-bs-toggle="tooltip" title="Installed">
                                    {{ $package['version'] }}
                                </span>
                                @if(!empty($package['latest']))
                                    <span class="text-muted" data-bs-toggle="tooltip"
                                          title="Latest">{{ $package['latest'] }}</span>
                                @endif
                            </h6>

                            <p class="card-text text-truncate w-100 mb-2">{{ $package['description'] }}</p>

                            @if(isset($package['source']))
                                <a href="{{ $package['source'] }}" class="card-link">Source</a>
                            @endif

                            @if(isset($package['homepage']))
                                <a href="{{ $package['homepage'] }}" class="card-link">Home Page</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="tab-pane fade" id="server-info" role="tabpanel"
             aria-labelledby="server-info-tab">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="thead-light text-center">
                    <tr>
                        <th>Option</th>
                        <th>Current</th>
                        <th>Recommended/Minimum</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($statistics as $option)
                        <tr>
                            <th width="24%">
                                {{ $option[0] }}
                            </th>
                            <td @if(isset($option[2])) width="38%" @else colspan="2" @endif>
                                {!! $option[1] !!}
                            </td>
                            @if(isset($option[2]))

                                <td @if(isset($option[2])) width="38%" @endif>
                                    {!! $option[2] !!}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection





