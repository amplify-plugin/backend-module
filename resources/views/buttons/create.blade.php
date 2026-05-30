@if ($crud->hasAccess('create'))
    @php
    $url = url($crud->route.'/create');

    if (!empty($button->params)) {
        $url .= '?'.http_build_query($button->params);
    }

    @endphp
    <a href="{{ $url }}" class="btn btn-primary" data-style="zoom-in">
        <span class="ladda-label">
            <i class="la la-plus"></i>
            {{ trans('backpack::crud.add') }} {{ \Str::title(\Str::replace('-', ' ', $crud->entity_name)) }}
        </span>
    </a>
@endif