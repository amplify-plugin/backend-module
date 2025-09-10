@extends(backpack_view('blank'))

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        </h2>
    </section>
@endsection

@php
    $widgets['before_content'][] = [
        'type'        => 'jumbotron',
        'heading'     => '404',
        'content'     => 'The view or route not found!',
        'button_link' => backpack_url('dashboard'),
        'button_text' => 'Back to dashboard',
    ];
@endphp

@section('after_scripts')
    <script src="{{mix("js/backend.js", "vendor/backend")}}"></script>
@endsection
<style>
    .jumbotron{
        text-align: center;
    }

</style>
