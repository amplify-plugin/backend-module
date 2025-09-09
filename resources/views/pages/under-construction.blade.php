@extends(backpack_view('blank'))

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            @if ($crud->hasAccess('list'))
                <small>
                    <a href="{{ url($crud->route) }}" class="d-print-none font-sm">
                        <i class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i>
                        {{ trans('backpack::crud.back_to_all') }}
                        <span>{{ $crud->entity_name_plural }}</span>
                    </a>
                </small>
            @endif
        </h2>
    </section>
@endsection

@php
    $widgets['before_content'][] = [
        'type'  => 'jumbotron',
        'image' => '<img width="100%" src="'.assets_image('/img/Under-Construction-Transparent-Background.png').'">',
    ];
@endphp

@section('after_scripts')
    <script src="{{asset("assets/js/app.js")}}"></script>
@endsection
