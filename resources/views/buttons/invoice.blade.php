@if ($entry->customer_code)
    <a href="{{ url($crud->route.'/invoice-summary/'.$entry->customer_code) }}" class="btn btn-sm btn-link" data-style="zoom-in"><span class="ladda-label"><i class="la la-eye"></i> invoice </span></a>
@endif
