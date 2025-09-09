@extends(backpack_view('blank'))

@push('after_styles')
    <link rel="stylesheet" href="{{ asset('packages/lightbox2/css/lightbox.min.css') }}">
@endpush

@php
    $defaultBreadcrumbs = [
      trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
      'Messages' => request()->url()
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">Messages</span>
            @if(!\Route::is('message.index'))
                <small>
                    <a href="{{ backpack_url('message') }}" class="font-sm">
                        <i class="la la-angle-double-left"></i>
                        Back to all <span>messages</span>
                    </a>
                </small>
            @endif
        </h2>
    </section>
@endsection

@section('content')
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card chat-app">
                    <div id="plist" class="people-list">
                        <div class="text-right">
                            <a href="{{ route('message.index') }}" class="btn btn-info btn-block mt-0">
                                <i class="la la-edit"></i> New message
                            </a>
                        </div>
                        <x-message-profile :as-customer="false" :threads="$threads" :current="$currentThread"/>
                    </div>
                    <div class="chat">
                        <x-message-history :as-customer="false" :current="$currentThread"/>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('after_scripts')
    <script src="{{ asset('packages/lightbox2/js/lightbox.min.js') }}"></script>
    <script>
        try {
            const chatBox = document.querySelector('.chat-history ul');
            chatBox.scrollTop = chatBox.scrollHeight;
        } catch (error) {
            console.warn(error);
        }
    </script>
@endsection
