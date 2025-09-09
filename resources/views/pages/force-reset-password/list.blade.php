<!DOCTYPE html>
<html>

    <head>

        <title>Rest Password</title>

        <link rel="stylesheet" media="screen" href='{{ asset("frontend/template-3/css/vendor.min.css") }}'>
        <link id="mainStyles" rel="stylesheet" media="screen" href='{{asset("frontend/template-3/css/styles.min.css")}}'>
        <link id="customStyles" rel="stylesheet" media="screen" href='{{asset("frontend/template-3/css/custom.css")}}'>
        <link id="customStyles" rel="stylesheet" media="screen" href='{{asset("frontend/template-3/css/daterangepicker.css")}}'>

    </head>

    <body>    

        <div class="container mb-2 padding-bottom-3x" style="min-height: 600px;">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form class="login-box" method="post" action="{{ route('customer.force_reset_password') }}"
                        style="margin-top: 150px;">
                        @csrf()
                        <h4 class="margin-bottom-1x">{{ __('Update Password') }}</h4>
                        <div class="form-group">
                            <div class="input-group {{ $errors->has('password') ? 'is-invalid' : '' }}">
                                <input class="form-control" type="password" name="password" placeholder="Password" required>
                                <span class="input-group-addon">
                                    <i class="icon-lock"></i>
                                </span>
                            </div>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="input-group {{ $errors->has('password') ? 'is-invalid' : '' }}">
                                <input class="form-control" type="password" name="password" placeholder="Confirm Password"
                                    required>
                                <span class="input-group-addon">
                                    <i class="icon-lock"></i>
                                </span>
                            </div>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="text-center text-sm-right">
                            <button class="btn btn-primary margin-bottom-none" type="submit">{{ __('Reset') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </body>

</html>
