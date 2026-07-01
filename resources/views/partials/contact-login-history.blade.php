@php
    $contactLogins = $contact->sessionLogins ?? collect();
@endphp
<table class="table table-bordered table-striped mb-0">
    <thead>
    <tr>
        <th>Customer</th>
        <th>Initiated By</th>
        <th>Last Logged At</th>
        <th>Last Logged Out</th>
    </tr>
    </thead>
    <tbody>
    @forelse($contactLogins as $entry)
        <tr>
            <td>{{ $entry->customer->customer_name ?? 'N/A' }}({{ $entry->customer->customer_code ?? 'N/A' }})</td>
            <td>{{ $entry->getImpersonatorDisplayName() }}</td>
            <td>{{ carbon_datetime($entry->last_logged_in) }}</td>
            <td>{{ carbon_datetime($entry->last_logged_out) }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4">No data available in table</td>
        </tr>
    @endforelse
    </tbody>
</table>
