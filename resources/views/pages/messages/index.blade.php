@extends(backpack_view('blank'))

@push('after_styles')
    <link rel="stylesheet" href="{{ asset('packages/lightbox2/css/lightbox.min.css') }}">
    <style>
        .chat-app-tall {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 188px);
            min-height: 560px;
            margin-bottom: 0;
        }
        .chat-app-tall > .chat {
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
        }
        .chat-app-tall .chat-panel {
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
        }
        .chat-app-tall .chat-history {
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
            overflow: hidden;
        }
        .chat-app-tall .chat-history ul {
            height: auto !important;
            max-height: none !important;
            flex: 1 1 auto;
            min-height: 0;
            overflow-y: auto;
        }
        .chat-app-tall .chat-message {
            flex: 0 0 auto;
        }
        .chat-app-tall .people-list {
            top: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
        }
        .chat-app-tall .people-list .chat-list {
            height: auto !important;
            flex: 1 1 auto;
            min-height: 0;
        }
    </style>
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
                <div class="card chat-app chat-app-tall">
                    <div id="plist" class="people-list" data-recent-url="{{ route('admin.message.recent') }}">
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
    <script src="{{ asset('vendor/backend/js/message-chat.js') }}"></script>
    <script>
        try {
            const chatBox = document.querySelector('.chat-history ul');
            chatBox.scrollTop = chatBox.scrollHeight;
        } catch (error) {
            console.warn(error);
        }
    </script>
@endsection
