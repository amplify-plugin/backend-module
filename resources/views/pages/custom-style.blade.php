@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        __('Custom Style') => false,
    ];
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>
                {!! $crud->getSubheading() ?? trans('backpack::crud.edit').' '.$crud->entity_name !!}
                .</small>
        </h2>
    </section>
@endsection

@section('content')
    {{-- Default box --}}
    <div class="row">
        {{-- THE ACTUAL CONTENT --}}
        <div class="{{ $crud->getListContentClass() }}">
            <div class="card">
                <div class="card-body">
                    @error('content')
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $message }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @enderror
                    <code-editor
                        url="{{ url($crud->getRoute()) }}"
                        content="{{ old('content', $content) }}"
                        back-url="{{ backpack_url('/dashboard') }}"
                        errors="{{$errors}}"
                        csrf-token="{{ csrf_token() }}">
                        <template #header>
                            <label class="text-right fw-bold">
                                Caution: Custom Styles affect all pages.
                                <code class="text-danger">Style file location: (assets/css/custom.css)</code>.
                            </label>
                        </template>
                    </code-editor>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_scripts')
    <script src="{{  mix("js/backend.js", "vendor/backend") }}"></script>
@endsection
