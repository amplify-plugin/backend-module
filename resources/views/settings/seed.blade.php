@if (backpack_user()->isAdmin())
    @php
    $url = url($crud->route.'/seed');

    if (!empty($button->params)) {
        $url .= '?'.http_build_query($button->params);
    }

    @endphp
    <a href="{{ $url }}" class="btn btn-primary" data-style="zoom-in">
        <span class="ladda-label">
            <i class="la la-sync"></i>
            {{ trans('Sync') }} {{ $crud->entity_name_plural }}
        </span>
    </a>
@endif