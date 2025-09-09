@extends(backpack_view('layouts.top_left'))

@php
    $breadcrumbs = [
      trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
      $crud->entity_name_plural => url($crud->route),
      trans('backpack::crud.list') => false,
    ];
@endphp

@section('header')
    <div class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small id="datatable_info_stack">{!! $crud->getSubheading() ?? '' !!}</small>
        </h2>
    </div>
@endsection

@section('content')
    <div class="row">

        <!-- THE ACTUAL CONTENT -->
        <div class="{{ $crud->getListContentClass() }}">
            <!-- Default box -->
            <!-- <button id="create-new-backup-button"
                    href="{{ url(config('backpack.base.route_prefix', 'admin').'/backup/create') }}"
                    class="btn btn-primary ladda-button mb-2" data-style="zoom-in"><span class="ladda-label"><i
                        class="la la-plus"></i> {{ trans('backpack::backup.create_a_new_backup') }}</span></button> -->

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#backupModal">
                <i class="la la-plus"></i> {{ trans('backpack::backup.create_a_new_backup') }}</span>
            </button>

            <!-- Modal -->
            <div class="modal fade" id="backupModal" tabindex="-1" role="dialog" aria-labelledby="backupModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-2" id="backupModalLabel">Choose Backup Objects</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url(config('backpack.base.route_prefix', 'admin').'/backup/create') }}" method="POST" id="backupForm">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="database" id="database" name="objects[]">
                            <label class="form-check-label" for="database">
                                Database
                                <br>
                                <small class="text-muted">Take a backup of your database only.</small>
                            </label>
                        </div>

                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" value="storage" id="storage" name="objects[]">
                            <label class="form-check-label" for="storage">
                                Storage
                                <br>
                                <small class="text-muted">Take a backup of your storage/uploaded files only.</small>
                            </label>
                        </div>

                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" value="full_backup" id="fullBackup" name="objects[]">
                            <label class="form-check-label" for="fullBackup">
                                Full Backup
                                <br>
                                <small class="text-muted">Take a full backup of your codes, storage/uploaded files and database at once.</small>
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="backupFormSubmit" class="btn btn-primary">Proceed</button>
                    </form>
                </div>
                </div>
            </div>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-hover table-striped pb-0 mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('backpack::backup.date') }}</th>
                            <th>{{ trans('backpack::backup.location') }}</th>
                            <th>Filename</th>
                            <th class="text-right">{{ trans('backpack::backup.file_size') }}</th>
                            <th class="text-right">{{ trans('backpack::backup.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($backups as $k => $b)
                            <tr>
                                <td>{{ $k+1 }}</td>
                                <td>{{ \Carbon\Carbon::createFromTimeStamp($b['last_modified'])->format(config('amplify.basic.date_time_format')) }}</td>
                                <td>{{ $b['disk'] }}</td>
                                <td>{{ $b['file_name'] }}</td>
                                <td class="text-right">{{ round((int)$b['file_size']/1048576, 2).' MB' }}</td>
                                <td class="text-right">
                                    @if ($b['download'])
                                        <a class="btn btn-sm btn-link"
                                           href="{{ url(config('backpack.base.route_prefix', 'admin').'/backup/download/') }}?disk={{ $b['disk'] }}&path={{ urlencode($b['file_path']) }}&file_name={{ urlencode($b['file_name']) }}"><i
                                                class="la la-cloud-download"></i> {{ trans('backpack::backup.download') }}
                                        </a>
                                    @endif
                                    <a class="btn btn-sm btn-link" data-button-type="delete"
                                       href="{{ url(config('backpack.base.route_prefix', 'admin').'/backup/'.$b['file_name']) }}?disk={{ $b['disk'] }}"><i
                                            class="la la-trash-o"></i> {{ trans('backpack::backup.delete') }}</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No backup found</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>

    <style>
        .modal{
            background-color: rgba(0, 0, 0, 0.3);
        }
        .modal-backdrop{
            display: none;
        }
    </style>
@endsection

@section('after_scripts')

    <script>
        jQuery(document).ready(function ($) {

            // capture the Create new backup button
            $("#backupFormSubmit").on('click', function (e) {
                e.preventDefault();

                var form = $('#backupForm');
                var create_backup_url = form.attr('action');
                console.log(create_backup_url, form.serialize());

                // do the backup through ajax
                $.ajax({
                    url: create_backup_url,
                    type: 'POST',
                    data: form.serialize(),
                    success: function (result) {
                        // Show an alert with the result
                        if (result.indexOf('failed') >= 0) {
                            new Noty({
                                text: "<strong>{{ trans('backpack::backup.create_warning_title') }}</strong><br>{{ trans('backpack::backup.create_warning_message') }}",
                                type: "warning"
                            }).show();
                        } else {
                            new Noty({
                                text: "<strong>{{ trans('backpack::backup.create_confirmation_title') }}</strong><br>{{ trans('backpack::backup.create_confirmation_message') }}",
                                type: "success"
                            }).show();
                        }
                    },
                    error: function (result) {
                        // Show an alert with the result
                        new Noty({
                            text: "<strong>{{ trans('backpack::backup.create_error_title') }}</strong><br>{{ trans('backpack::backup.create_error_message') }}",
                            type: "warning"
                        }).show();
                    }
                });
            });

            // capture the delete button
            $("[data-button-type=delete]").click(function (e) {
                e.preventDefault();
                var delete_button = $(this);
                var delete_url = $(this).attr('href');

                if (confirm("{{ trans('backpack::backup.delete_confirm') }}") == true) {
                    $.ajax({
                        url: delete_url,
                        type: 'DELETE',
                        success: function (result) {
                            // Show an alert with the result
                            new Noty({
                                text: "<strong>{{ trans('backpack::backup.delete_confirmation_title') }}</strong><br>{{ trans('backpack::backup.delete_confirmation_message') }}",
                                type: "success"
                            }).show();
                            // delete the row from the table
                            delete_button.parentsUntil('tr').parent().remove();
                        },
                        error: function (result) {
                            // Show an alert with the result
                            new Noty({
                                text: "<strong>{{ trans('backpack::backup.delete_error_title') }}</strong><br>{{ trans('backpack::backup.delete_error_message') }}",
                                type: "warning"
                            }).show();
                        }
                    });
                } else {
                    new Noty({
                        text: "<strong>{{ trans('backpack::backup.delete_cancel_title') }}</strong><br>{{ trans('backpack::backup.delete_cancel_message') }}",
                        type: "info"
                    }).show();
                }
            });

        });
    </script>
@endsection
