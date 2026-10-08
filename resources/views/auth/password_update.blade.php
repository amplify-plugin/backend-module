@extends(backpack_view('blank'))

@php
    $minPasswordLength = \Amplify\System\Helpers\SecurityHelper::passwordLength();
@endphp

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->count())
                <div class="alert alert-danger">
                    <ul class="mb-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="form" method="post" action="{{ route('admin.force-password.update', $user->id) }}">
                {!! csrf_field() !!}

                <div class="card padding-10">
                    <div class="card-header">
                        {{ trans('backpack::base.change_password') }}
                    </div>

                    <div class="card-body bold-labels">
                        <p class="text-muted">{{ __('For security reasons you must update your password before continuing.') }}</p>

                        <div class="form-group">
                            <label class="required">{{ trans('backpack::base.new_password') }}</label>
                            <input autocomplete="new-password" required minlength="{{ $minPasswordLength }}"
                                   class="form-control" type="password" name="password" id="password" value="">
                        </div>

                        <div class="form-group">
                            <label class="required">{{ trans('backpack::base.confirm_password') }}</label>
                            <input autocomplete="new-password" required minlength="{{ $minPasswordLength }}"
                                   class="form-control" type="password" name="password_confirmation" id="password_confirmation" value="">
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="la la-save"></i> {{ __('Update Password') }}
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
