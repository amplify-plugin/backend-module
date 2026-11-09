@if ($crud->hasAccess('retry'))
    <a href="{{ url($crud->route.'/'.$entry->getKey().'/retry') }}" class="btn btn-sm btn-link text-capitalize"><i
            class="las la-retweet"></i> retry</a>
@endif
