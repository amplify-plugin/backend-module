@if ($crud->hasAccess('impersonate'))
    <a
            target="_blank"
            href="{{ url("{$crud->route}/{$entry->getKey()}/impersonate") }} "
            class="m-2 btn btn-sm btn-link">
        <i class="la la-user-alt-slash"></i>
        {{ 'Impersonate' }}
    </a>
@endif
