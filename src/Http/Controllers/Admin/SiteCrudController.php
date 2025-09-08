<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\SiteRequest;
use Amplify\System\Backend\Models\Site;
use Amplify\System\Backend\Models\SiteSearchConfiguration;
use Amplify\System\Cms\Models\Page;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Prologue\Alerts\Facades\Alert;

/**
 * Class SiteCrudController
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SiteCrudController extends BackpackCustomCrudController
{
    use CreateOperation {
        store as traitStore;
    }
    use DeleteOperation {
        destroy as traitDestroy;
    }
    use ListOperation;
    use ShowOperation;
    use UpdateOperation {
        update as traitUpdate;
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Site::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/site');
        CRUD::setEntityNameStrings('site', 'sites');
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
        CRUD::column('id')->type('number')->thousands_sep('');

        $this->crud->addButtonFromView('line', 'deactivate', 'deactivate', 'end');

        $this->crud->addFilter([ // simple filter
            'type' => 'simple',
            'name' => 'trashed',
            'label' => 'Trashed',
        ],
            false,
            function () { // if the filter is active
                $this->crud->addClause('withTrashed');
            });

        CRUD::addColumn(['name' => 'site_name', 'label' => 'Site Name']);
        CRUD::addColumn([
            'name' => 'url',
            'type' => 'custom_html',
            'value' => function ($model) {
                return ! empty($model->url)
                    ? '<a href="'.$model->url.'" target="_blank">'.$model->url.'</a>'
                    : '-';
            },
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     *
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(SiteRequest::class);

        /* BasicInfo tab fields */
        CRUD::addField([
            'name' => 'site_name',
            'label' => 'Site Name',
        ]);
        CRUD::addField([
            'name' => 'site_description',
            'label' => 'Site Description',
        ]);
        CRUD::addField([
            'name' => 'url',
            'label' => 'Url',
        ]);

        /* Page Configuration tab fields */
        CRUD::addField([
            'name' => 'template_id',
            'label' => 'Select Template',
        ]);
        CRUD::addField([
            'name' => 'front_page_id',
            'label' => 'Select Home Page',
        ]);
        CRUD::addField([
            'name' => 'shop_page_id',
            'label' => 'Select Shop Page',
        ]);
        CRUD::addField([
            'name' => 'product_page_id',
            'label' => 'Select Product Page',
        ]);

        /* Search Configuration tab fields */
        CRUD::addField([
            'name' => 'easyask_url',
            'label' => 'Easyask Url',
        ]);
        CRUD::addField([
            'name' => 'dictionary_name',
            'label' => 'Dictionary Name',
        ]);
        CRUD::addField([
            'name' => 'protocol',
            'label' => 'Protocol',
        ]);
        CRUD::addField([
            'name' => 'port',
            'label' => 'Port',
        ]);
        CRUD::addField([
            'name' => 'sayt_product_id',
            'label' => 'Product ID',
        ]);
        CRUD::addField([
            'name' => 'sayt_product_image',
            'label' => 'Product Image',
        ]);
        CRUD::addField([
            'name' => 'sayt_product_name',
            'label' => 'Product Name',
        ]);
        CRUD::addField([
            'name' => 'sayt_product_price',
            'label' => 'Product Price',
        ]);
        CRUD::addField([
            'name' => 'sayt_product_description',
            'label' => 'Product Description',
        ]);
        CRUD::addField([
            'name' => 'sayt_product_type',
            'label' => 'Product Type',
        ]);
        CRUD::addField([
            'name' => 'sayt_product_sizes',
            'label' => 'Product Sizes',
        ]);

        CRUD::addField([
            'name' => 'product_search_by_id_prefix',
            'label' => 'Easyask Product Search By Id Prefix',
        ]);
        CRUD::addField([
            'name' => 'easyask_host',
            'label' => 'EasyAsk Host',
        ]);
        CRUD::addField([
            'name' => 'easyask_port',
            'label' => 'EasyAsk Port',
        ]);
        CRUD::addField([
            'name' => 'easyask_dictionary',
            'label' => 'EasyAsk Dictionary',
        ]);

        $this->crud->setCreateView('crud::pages.sites.create');
    }

    public function store(SiteRequest $request)
    {
        $site = Site::create($request->except('search_config'));

        SiteSearchConfiguration::create(
            $request->search_config +
            [
                'site_id' => $site->id,
            ]
        );
    }

    protected function setupShowOperation(): void
    {
        CRUD::addColumn([
            'name' => 'site_name',
            'label' => 'Site Name',
        ]);
        CRUD::addColumn([
            'name' => 'site_description',
            'label' => 'Site Description',
        ]);
        CRUD::addColumn([
            'name' => 'url',
            'type' => 'custom_html',
            'value' => function ($model) {
                return ! empty($model->url)
                    ? '<a href="'.$model->url.'" target="_blank">'.$model->url.'</a>'
                    : '-';
            },
        ]);
        CRUD::addColumn([
            'name' => 'template_id',
            'label' => 'Template',
            'type' => 'custom_html',
            'value' => function ($model) {
                $template = template($model->template_id);
                if (! empty($template)) {
                    return $template->label;
                } else {
                    return $model->template_id;
                }
            },
        ]);
        CRUD::addColumn([
            'name' => 'front_page_id',
            'label' => 'Home Page',
            'type' => 'custom_html',
            'value' => function ($model) {
                return ! empty($model->front_page_id)
                    ? Page::find($model->front_page_id)->name
                    : '-';
            },
        ]);
        CRUD::addColumn([
            'name' => 'shop_page_id',
            'label' => 'Shop Page',
            'type' => 'custom_html',
            'value' => function ($model) {
                return ! empty($model->shop_page_id)
                    ? Page::find($model->shop_page_id)->name
                    : '-';
            },
        ]);
        CRUD::addColumn([
            'name' => 'product_page_id',
            'label' => 'Product Page',
            'type' => 'custom_html',
            'value' => function ($model) {
                return ! empty($model->product_page_id)
                    ? Page::find($model->product_page_id)->name
                    : '-';
            },
        ]);
    }

    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');

        SiteSearchConfiguration::where('site_id', $id)->withTrashed()->forceDelete();

        return Site::where('id', $id)->withTrashed()->forceDelete($id);
    }

    public function deactivate($id)
    {
        Site::find($id)->delete();

        SiteSearchConfiguration::where('site_id', $id)->delete();

        Alert::success('Site has been deactivated successfully')->flash();

        return back();
    }

    public function activate($id)
    {
        $site = Site::where('id', $id)->withTrashed()->first();

        $site->restore();

        $site->search_configuration()->restore();

        return back();
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     *
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->data['sitesData'] = $this->crud->getCurrentEntry();

        $this->crud->setUpdateView('crud::pages.sites.create');

        $this->setupCreateOperation();
    }

    public function update(SiteRequest $request)
    {
        $site = Site::find($request->id);

        $site->update($request->except('search_config'));

        $site->search_configuration()->update($request->search_config);
    }
}
