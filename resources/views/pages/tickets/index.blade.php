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
@endpush

@section('content')
    <div id="app">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card chat-app">
                    <div class="chat ml-0">
                        @if ($threadMsg)
                            <div class="chat-header clearfix">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="chat-about">
                                            <h6 class="mt-2"><span class="font-weight-bold">Subject:</span>
                                                {{ $threadMsg->title }}</h6>
                                            <h6 class="mt-2"><span class="font-weight-bold">From:</span>
                                                {{ $threadMsg->tickets->first()->sender->name }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="chat-history py-0 pr-0">
                                @if (isset($threadMsg->tickets) && $threadMsg->tickets->count() > 0)
                                    <ul class="mb-0 pl-0">
                                        @foreach ($threadMsg->tickets as $message)
                                            <li class="clearfix my-2">
                                                <div
                                                    class="message @if ($message->sender_id === optional(backpack_user())->id && $message->model == get_class(backpack_user())) other-message float-right @else my-message @endif">
                                                    @if ($message->attachments)
                                                        @foreach (json_decode($message->attachments) as $attachment)
                                                            @if (in_array(pathinfo(($attachment), PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                                                <a href="{{ ($attachment) }}" data-lightbox="{{ ($attachment) }}" data-title="{{ $message->message }}">
                                                                    <object class="img-fluid" data="{{ ($attachment) }}"></object>
                                                                </a>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    <p class="text-left">{!! nl2br($message->message) !!}</p>
                                                    @if ($message->attachments)
                                                            @php
                                                                $attachment_titles = json_decode($message->attachment_title);
                                                            @endphp
                                                        @foreach (json_decode($message->attachments) as $key => $attachment)
                                                            @if (!in_array(pathinfo(($attachment), PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
																<a href="{{ ($attachment) }}" download title="Download Attachment"
																class="d-flex justify-content-start mt-3">
																	<div class="media border p-1 rounded" style="background-color: #EFEFEF;">
																		<i class="las la-file p-3 rounded-circle align-self-center mr-1 text-dark"
																		style="background-color: #d1d1d1;"></i>
																		<div class="media-body pt-2">
                                                                            <a href="{{ ($attachment) }}" download target="_blank">
                                                                                {{ (is_array($attachment_titles) ? $attachment_titles[$key] : $attachment_titles) ?? "" }}
                                                                            </a>
																		</div>
																	</div>
																</a>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    <small
                                                        class="message-data-time text-muted font-italic">{{ $message->created_at->diffForHumans() }}</small>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <ul style="height: 480px"></ul>
                                @endif
                            </div>

                            <div class="chat-message clearfix">
                                <form action="{{ route('admin.ticket.store', $threadMsg->id) }}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <div class="input-group frontend-message-input-group">
                                            <textarea name="message" class="form-control" style="padding-left: 0.75rem;" rows="2"
                                                    placeholder="Enter text here...">{{ old('message') }}</textarea>
                                            <div class="input-group-prepend">
                                                <button type="submit" class="btn btn-info rounded-right my-0 btn-block py-0 frontend-message-save-btn"
                                                        style="font-size: 1.5rem; height: 75px">
                                                    ➤
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @error('message')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror

                                    <div class="input-group mb-3 mt-4 d-flex clone-field">
                                        <div class="input-group-prepend">
                                            <button type="button" class="input-group-text bg-primary add-more-input">
                                                <i class="las la-plus text-white"></i>
                                            </button>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="form-control custom-file-input"
                                                name="attachments[]" id="attachments">
                                            <label class="custom-file-label" for="upload-file">Choose file</label>
                                        </div>
                                    </div>
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
    <script>
        $(document).on('click', '.add-more-input', function () {
            let html = `
            <div class="input-group mb-3 d-flex clone-field">
                <div class="input-group-prepend">
                    <button type="button" class="input-group-text bg-danger remove-file-input">
                        <i class="las la-trash-alt text-white"></i>
                    </button>
                </div>
                <div class="custom-file">
                <input type="file" class="form-control custom-file-input" name="attachments[]" id="attachments">
                    <label class="custom-file-label" for="upload-file">Choose file</label>
                </div>
            </div>
            `;

            $('.clone-field').last().after(html);
        });

        $(document).on('click', '.remove-file-input', function () {
            $(this).parent().parent().remove()
        });


        $(document).on('change', '.custom-file-input', function () {
            let filenmae = $(this).val()
            $(this).next('.custom-file-label').text(filenmae)
        });
    </script>
@endsection
