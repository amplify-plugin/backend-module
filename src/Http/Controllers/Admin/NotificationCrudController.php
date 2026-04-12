<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Models\Notification;
use Amplify\System\Backend\Models\User;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Carbon\Carbon;
use Prologue\Alerts\Facades\Alert;

class NotificationCrudController extends BackpackCustomCrudController
{
    use CreateOperation;
    use DeleteOperation;
    use ListOperation;
    use ShowOperation;
    use UpdateOperation;

    public function setup()
    {
        $this->crud->setModel(Notification::class);
        $this->crud->setRoute(config('backpack.base.route_prefix').'/notification');
        $this->crud->setEntityNameStrings('notification', 'notifications');

        $this->crud->addClause('orderBy', 'created_at', 'desc');

        $showAllUsers = request('show_all');
        if (! $showAllUsers) {
            $this->crud->addClause('where', 'notifiable_id', backpack_user()->id);
            $this->crud->addClause('where', 'notifiable_type', config('backpack.base.user_model_fqn'));
        }

        if (! request('show_dismissed')) {
            $this->crud->addClause('whereNull', 'read_at');
        }

        $this->crud->addButtonFromModelFunction('top', 'dismiss_all', 'dismissAllButton', 'beginning');

        $this->crud->addButtonFromModelFunction('line', 'action', 'actionButton', 'end');
        $this->crud->addButtonFromModelFunction('line', 'dismiss', 'dismissButton', 'end');

        $this->crud->denyAccess(['create', 'delete', 'update', 'show']);
    }

    protected function setupListOperation()
    {
        $this->crud->setActionsColumnPriority(-1);
        // $this->crud->disableResponsiveTable();

        // Filters

        $this->crud->addFilter(
            [
                'type' => 'simple',
                'name' => 'show_dismissed',
                'label' => 'Show Dismissed',
            ],
            false,
            function () {
                $this->crud->addClause('where', 'read_at', '!=', null);
            }
        );

        $this->crud->addFilter(
            [
                'type' => 'simple',
                'name' => 'show_all',
                'label' => 'Show notifications for all users (admin only)',
            ],
            false,
            function () {}
        );

        // columns

        $this->crud->addColumn([
            'label' => 'Date',
            'type' => 'datetime',
            'name' => 'created_at',
        ]);

        $this->crud->addColumn([
            'name' => 'message',
            'label' => 'Message',
            'type' => 'custom_html',
            'value' => function ($entry) {
                return '<div style="display:inline-block; max-width:100%; white-space: pre-wrap;">'.
                    ($entry->data->message_long ?? $entry->data->message ?? '-').
                    '</div>';
            },
        ]);

        if (request('show_all')) {
            $this->crud->addColumn([
                'label' => 'For',
                'type' => 'custom_html',
                'name' => 'notifiable_id',
                'value' => function ($entry) {
                    $user = User::find($entry->notifiable_id);

                    return $user->displayName ?? '-';
                },
            ]);
        }
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);

        $this->setupListOperation();
    }

    protected function setupCreateOperation() {}

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function dismissAll()
    {
        backpack_user()->unreadNotifications->markAsRead();

        Alert::success('All notifications dismissed')->flash();

        return redirect()->back();
    }

    public function dismiss($notificationId)
    {
        $notification = Notification::findOrFail($notificationId);

        $notification->read_at = Carbon::now();
        $notification->save();

        Alert::success('Notification dismissed')->flash();

        return redirect()->back();
    }

    public function unreadCount()
    {
        $count = backpack_user()->unreadNotifications->count();

        $lastNotification = backpack_user()->unreadNotifications()->orderBy('created_at', 'desc')->first();

        return response()->json([
            'count' => $count,
            'last_notification' => $lastNotification ? $lastNotification->data : null,
        ]);
    }
}
