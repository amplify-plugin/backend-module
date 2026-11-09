<a href="javascript:void(0)" class="btn btn-warning" data-toggle="modal" data-target="#ImportCustomerOrderRule">
    <span class="ladda-label">
        <i class="la la-upload"></i> Import Customer Order Rule
    </span>
</a>


<div class="modal fade" id="ImportCustomerOrderRule" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Import Customer Order Rule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('customer-order-rule.import') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="form-group">
                        <label>Upload CSV file</label>
                        <input type="file" class="form-control" name="csv_file">
                        <small class="form-text text-muted">Uploaded CSV file must be maintain the format of
                            <a href="{{ asset('assets/samples/import-customer-order-rule.csv') }}" download>CSV File</a>.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
