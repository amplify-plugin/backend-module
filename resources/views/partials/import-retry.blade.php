<!-- Modal -->
<div class="modal fade modal-fullscreen" id="error-job-show" tabindex="-1" role="dialog"
     aria-labelledby="error-job-show--title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="error-job-show--title">Import Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="rounded border mb-3">
                    <table class="table m-0">
                        <thead>
                        <tr>
                            <th width="20">#</th>
                            <th width="20%">Column Name</th>
                            <th>Value</th>
                        </tr>
                        </thead>
                        <tbody id="error-job-show--tbody">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="error-job-show--save">
                    Save
                </button>
                <button type="button" class="btn btn-light" id="error-job-show--save-and-retry">
                    Save and retry
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
