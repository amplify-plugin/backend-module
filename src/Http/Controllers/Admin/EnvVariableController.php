<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\EnvVariableUpdateRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;

/**
 * Class AccountTitleCrudController
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EnvVariableController extends BackpackCustomCrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;

    private string $envPath;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setRoute(config('backpack.base.route_prefix').'/env-variable');
        CRUD::setEntityNameStrings('env variable', 'env variables');

        $this->envPath = app()->environmentFilePath();
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     *
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->removeButton('create');
        $this->crud->setListView('backend::pages.editor');
        $this->data['header'] = <<<'HTML'
                            <label class="text-right fw-bold">
                                Caution: Any wrong/syntax change in (.env) may cause system failure.
                                <code class="text-danger">--"With great power comes great responsibility"</code>.
                            </label>
HTML;
        $this->data['content'] = file_get_contents($this->envPath);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     *
     * @return RedirectResponse
     */
    protected function store(EnvVariableUpdateRequest $request)
    {
        $code = $request->validated('content', '');

        $backupPath = $this->envPath.'.backup';

        copy($this->envPath, $backupPath);

        if (! file_put_contents($this->envPath, $code.PHP_EOL)) {
            copy($backupPath, $this->envPath);
            \Alert::error('Unable to modify the .env file.')->flash();
        } else {
            \Alert::success(__('backpack::crud.update_success'))->flash();
            Artisan::call('optimize:clear');
        }

        unlink($backupPath);

        return redirect()->to($this->crud->getRoute());
    }
}
