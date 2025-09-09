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
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body table-responsive">
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
        </div>
    </div>
@endsection





