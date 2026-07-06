@php
    use Amplify\System\Backend\Models\ContactLogin;

    $contactLogins = ContactLogin::query()
        ->with(['contact', 'customer', 'impersonator'])
        ->latest()
        ->limit(10)
        ->get();
@endphp

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Latest Contact Logins</span>
        <a href="{{ backpack_url('contact-login') }}" class="btn btn-sm btn-link">See all</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead>
                <tr>
                    <th>Type</th>
                    <th>Contact</th>
                    <th>Customer</th>
                    <th>Initiated By</th>
                    <th>Last Logged In</th>
                    <th>Last Logged Out</th>
                    <th>Active</th>
                </tr>
                </thead>
                <tbody>
                @forelse($contactLogins as $entry)
                    <tr>
                        <td>{{ $entry->row_type === ContactLogin::ROW_TYPE_SESSION ? 'Session' : 'Assignment' }}</td>
                        <td>{{ $entry->getContactDisplayLabel() }}</td>
                        <td>{{ $entry->getCustomerDisplayLabel() }}</td>
                        <td>{{ $entry->getImpersonatorDisplayName() }}</td>
                        <td>{{ $entry->last_logged_in ? carbon_datetime($entry->last_logged_in) : '-' }}</td>
                        <td>{{ $entry->last_logged_out ? carbon_datetime($entry->last_logged_out) : '-' }}</td>
                        <td>
                            @if($entry->active)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No contact logins yet.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
