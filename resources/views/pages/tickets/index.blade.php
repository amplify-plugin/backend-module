@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    $crud->entity_name => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
	<section class="container-fluid d-print-none">
    	<a href="javascript: window.print();" class="btn float-right"><i class="la la-print"></i></a>
		<h2>
	        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
	        <small>{!! $crud->getSubheading() ?? mb_ucfirst(trans('backpack::crud.preview')).' '.$crud->entity_name !!}.</small>
	        @if ($crud->hasAccess('list') && !in_array($crud->entity_name_plural, listOfCrudToHideBackToButton()))
	          <small class=""><a href="{{ url($crud->route) }}" class="font-sm"><i class="la la-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
	        @endif
	    </h2>
    </section>
@endsection

@push('after_styles')
    <link rel="stylesheet" href="{{ asset('packages/lightbox2/css/lightbox.min.css') }}">
    <style>
        .chat-composer { display: flex; align-items: flex-end; gap: 8px; }
        .chat-composer__clip,
        .chat-composer__send {
            flex: 0 0 44px; width: 44px; height: 44px; margin: 0; border-radius: 4px !important;
            display: inline-flex; align-items: center; justify-content: center; padding: 0;
        }
        .chat-composer__field { flex: 1 1 auto; min-width: 0; }
        .chat-composer__field textarea { min-height: 44px; resize: vertical; }
        .chat-composer__send .chat-spinner { border-color: rgba(255,255,255,.35); border-top-color: #fff; }
        .chat-file-input {
            position: absolute !important; width: 1px !important; height: 1px !important;
            padding: 0 !important; margin: -1px !important; overflow: hidden !important;
            clip: rect(0,0,0,0) !important; white-space: nowrap !important; border: 0 !important;
        }
        .chat-picks { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 8px; }
        .chat-picks:empty { display: none; }
        .chat-pick {
            display: flex; align-items: center; gap: 8px; max-width: 260px;
            padding: 4px 6px 4px 4px; border: 1px solid #e4e6eb; border-radius: 10px; background: #fff;
        }
        .chat-pick img, .chat-pick__icon {
            width: 36px; height: 36px; flex: 0 0 36px; border-radius: 6px; object-fit: cover;
        }
        .chat-pick__icon {
            display: inline-flex; align-items: center; justify-content: center;
            background: #e6e9ef; color: #3d4d6a;
        }
        .chat-pick__icon i { font-size: 16px; line-height: 1; }
        .chat-pick__meta { min-width: 0; }
        .chat-pick__name {
            display: block; max-width: 150px; overflow: hidden; text-overflow: ellipsis;
            white-space: nowrap; font-size: 13px; font-weight: 600; color: #1b2a4e;
        }
        .chat-pick__size { display: block; font-size: 11px; color: #6c757d; }
        .chat-pick__remove {
            border: 0; background: transparent; color: #6c757d; font-size: 18px;
            line-height: 1; padding: 0 2px; cursor: pointer;
        }
        .chat-spinner {
            width: 16px; height: 16px; border: 2px solid rgba(255,255,255,.35);
            border-top-color: #fff; border-radius: 50%; display: inline-block;
            animation: chat-spin .7s linear infinite;
        }
        .chat-spinner[hidden], [data-send-icon][hidden] { display: none !important; }
        .chat .chat-history { overflow-x: hidden; }
        .chat .chat-history .message {
            max-width: min(420px, 85%);
            box-sizing: border-box;
            overflow: hidden;
        }
        .chat .chat-history .message p,
        .chat .chat-history .message .message-data-time { display: block; clear: both; }
        .chat-attach-image-link { display: block; max-width: 100%; margin-top: 8px; line-height: 0; }
        .chat-attach-image {
            display: block; width: auto; max-width: 100%; max-height: 160px;
            object-fit: cover; border-radius: 8px;
        }
        .chat-attach-file {
            display: flex; align-items: center; justify-content: flex-start; gap: 8px;
            width: fit-content; max-width: 100%; box-sizing: border-box;
            margin: 8px auto 0 0; padding: 6px 10px 6px 6px; border-radius: 8px;
            background: #f4f5f7; border: 1px solid #e4e6eb; text-decoration: none !important;
            text-align: left; line-height: 1.2; color: #1b2a4e;
        }
        .chat-attach-file__icon {
            flex: 0 0 32px; width: 32px; height: 32px; border-radius: 6px;
            background: #dfe3ea; color: #3d4d6a; display: inline-flex;
            align-items: center; justify-content: center;
        }
        .chat-attach-file__icon i { font-size: 16px; line-height: 1; padding: 0; background: none; }
        .chat-attach-file__name {
            flex: 0 1 auto; min-width: 0; overflow: hidden; text-overflow: ellipsis;
            white-space: nowrap; font-size: 13px; text-align: left;
        }
        @keyframes chat-spin { to { transform: rotate(360deg); } }
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
        .chat-app-tall .chat-history {
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
            overflow: hidden;
            position: relative;
        }
        .chat-app-tall .chat-boot {
            display: none;
            position: absolute;
            inset: 0;
            z-index: 3;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            color: #20a8d8;
        }
        .chat-app-tall .chat-stage.is-loading .chat-boot { display: flex; }
        .chat-app-tall .chat-booting > * { visibility: hidden; }
        .chat-app-tall .chat-boot__spinner {
            width: 28px;
            height: 28px;
            border: 3px solid rgba(32, 168, 216, 0.25);
            border-top-color: currentColor;
            border-radius: 50%;
            animation: chat-boot-spin .7s linear infinite;
        }
        @keyframes chat-boot-spin { to { transform: rotate(360deg); } }
        .chat-app-tall .chat-history ul {
            height: 0 !important;
            max-height: none !important;
            flex: 1 1 0% !important;
            min-height: 0 !important;
            overflow-y: auto !important;
            overflow-anchor: none;
        }
        .chat-app-tall .chat-message {
            flex: 0 0 auto;
        }
    </style>
@endpush

@section('content')
    <div id="app">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card chat-app chat-app-tall"
                     @if ($threadMsg)
                         id="ticket-chat"
                         data-mode="admin"
                         data-poll-url="{{ route('admin.ticket.messages', $threadMsg->id) }}"
                         data-send-url="{{ route('admin.ticket.messages.store', $threadMsg->id) }}"
                     @endif>
                    <div class="chat ml-0">
                        @if ($threadMsg)
                            <div class="chat-header clearfix">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="chat-about">
                                            <h6 class="mt-2"><span class="font-weight-bold">Subject:</span>
                                                {{ $threadMsg->title }}</h6>
                                            <h6 class="mt-2"><span class="font-weight-bold">From:</span>
                                                {{ optional(optional($threadMsg->tickets->first())->sender)->name }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="chat-history chat-stage is-loading py-0 pr-0">
                                <div class="chat-boot" role="status" aria-label="Loading messages">
                                    <span class="chat-boot__spinner"></span>
                                </div>
                                @if (isset($threadMsg->tickets) && $threadMsg->tickets->count() > 0)
                                    <ul data-ticket-list data-ticket-scroll class="chat-booting mb-0 pl-0">
                                        @foreach ($threadMsg->tickets as $message)
                                            <li data-message-id="{{ $message->id }}" class="clearfix my-2">
                                                <div
                                                    class="message @if ($message->sender_id === optional(backpack_user())->id && $message->model == get_class(backpack_user())) other-message float-right @else my-message @endif">
                                                    @if (filled($message->message))
                                                        <p class="text-left">{!! nl2br(e($message->message)) !!}</p>
                                                    @endif
                                                    @php
                                                        $attachmentUrls = \Amplify\System\Ticket\TicketService::listValues($message->attachments);
                                                        $attachmentTitles = \Amplify\System\Ticket\TicketService::listValues($message->attachment_title);
                                                    @endphp
                                                    @foreach ($attachmentUrls as $key => $attachment)
                                                        @continue(! is_string($attachment) || $attachment === '')
                                                        @php
                                                            $attachmentPath = parse_url($attachment, PHP_URL_PATH) ?: $attachment;
                                                            $isImage = in_array(strtolower(pathinfo($attachmentPath, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp'], true);
                                                        @endphp
                                                        @if ($isImage)
                                                            <a href="{{ $attachment }}" class="chat-attach-image-link" data-lightbox="{{ $attachment }}" data-title="{{ $message->message }}">
                                                                <img class="chat-attach-image" src="{{ $attachment }}" alt="{{ $attachmentTitles[$key] ?? 'Image' }}">
                                                            </a>
                                                        @else
                                                            <a href="{{ $attachment }}" download class="chat-attach-file" title="Download attachment">
                                                                <span class="chat-attach-file__icon"><i class="la la-file"></i></span>
                                                                <span class="chat-attach-file__name">{{ $attachmentTitles[$key] ?? 'Attachment' }}</span>
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                    <small class="message-data-time text-muted font-italic"
                                                           data-ticket-time="{{ $message->created_at?->toIso8601String() }}">{{ \Amplify\System\Ticket\TicketService::humanTime($message->created_at) }}</small>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <ul data-ticket-list data-ticket-scroll class="chat-booting mb-0 pl-0" style="height: 480px"></ul>
                                @endif
                            </div>

                            <div class="chat-message clearfix">
                                <form data-ticket-form data-compose data-compose-max="10" data-compose-max-kb="10240" data-compose-icon="la la-file" action="{{ route('admin.ticket.messages.store', $threadMsg->id) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div data-compose-picks class="chat-picks"></div>
                                    <div class="chat-composer">
                                        <button type="button" class="btn btn-light chat-composer__clip" data-compose-attach aria-label="Attach a file">
                                            <i class="la la-paperclip"></i>
                                        </button>
                                        <div class="chat-composer__field">
                                            <textarea name="message" class="form-control" rows="1" placeholder="Enter text here...">{{ old('message') }}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-info chat-composer__send" aria-label="Send">
                                            <i class="la la-paper-plane" data-send-icon></i>
                                            <span class="chat-spinner" data-send-spinner hidden></span>
                                        </button>
                                        <input type="file" class="chat-file-input" data-compose-file name="attachments[]" multiple tabindex="-1" aria-hidden="true">
                                    </div>
                                    <div data-ticket-errors class="text-danger small mt-1"></div>
                                    @error('message')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <small class="text-danger">
                                        {{ $errors->first('attachments') }}
                                        {{ $errors->first('attachments.*') }}
                                    </small>
                                </form>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection



@section('after_scripts')
    <script src="{{ asset('packages/lightbox2/js/lightbox.min.js') }}"></script>
    @if ($threadMsg)
        <script src="{{ asset('vendor/ticket/js/ticket-chat.js') }}"></script>
    @endif
@endsection
