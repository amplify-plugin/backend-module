@extends(backpack_view('blank'))

@section('after_styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('vendor/file-manager/css/file-manager.css') }}" rel="stylesheet">
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container-fluid">
        <h2>File Manager </h2>
        <div class="row">
            <div class="col-md-12" id="fm-main-block" style="height: 597px; overflow:scroll">
                <file-manager></file-manager>
            </div>
        </div>
    </div>
@endsection

@section('after_scripts')
 <!-- File manager -->
 <script src="{{asset("assets/js/app.js")}}"></script>
@endsection





