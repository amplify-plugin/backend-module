@push($widget['stack'] ?? 'after_scripts')
    <script>
        {!! $widget['content'] ?? '' !!}
    </script>
@endpush