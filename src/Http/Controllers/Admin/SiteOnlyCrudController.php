<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Http\Requests\SiteRequest;
use Amplify\System\Backend\Models\Site;
use Amplify\System\Cms\Models\Page;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SiteCrudController
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SiteOnlyCrudController extends BackpackCustomCrudController
{
    use CreateOperation;
    use DeleteOperation;
    use ListOperation;
    use ShowOperation;
    use UpdateOperation;

    public $templateOptions = [];

    public $pageOptions = [];

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Site::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/site_only');
        CRUD::setEntityNameStrings('site-only', 'site config pages');
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
        // TODO Remove Customer from side Create/Update
        // TODO Remove Config and will be applied in [SiteConf.]
        CRUD::addColumn(['name' => 'site_name', 'label' => 'Site Name']);
        CRUD::column('url');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
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
        $templateOptions = $this->getTemplateOptions();
        $pageOptions = $this->getPageOptions();

        CRUD::setValidation(SiteRequest::class);
        CRUD::addField([
            'name' => 'site_name',
            'label' => 'Site Name',
            'type' => 'text',
            'tab' => 'Basic Info',
        ]);
        CRUD::addField([
            'name' => 'site_description',
            'label' => 'Site Description',
            'tab' => 'Basic Info',
        ]);
        CRUD::addField([
            'name' => 'url',
            'label' => 'Url',
            'type' => 'url',
            'tab' => 'Basic Info',
        ]);
        CRUD::addField([
            'name' => 'template_id',
            'label' => 'Select Template',
            'type' => 'select2_from_array',
            'options' => $templateOptions,
            'tab' => 'Page Configuration',
        ]);
        CRUD::addField([
            'name' => 'front_page_id',
            'label' => 'Select Home Page',
            'type' => 'select2_from_array',
            'options' => $pageOptions,
            'tab' => 'Page Configuration',
        ]);
        CRUD::addField([
            'name' => 'shop_page_id',
            'label' => 'Select Category List Page',
            'type' => 'select2_from_array',
            'options' => $pageOptions,
            'tab' => 'Page Configuration',
        ]);
        CRUD::addField([
            'name' => 'product_page_id',
            'label' => 'Default Template For Products',
            'type' => 'select2_from_array',
            'options' => $pageOptions,
            'tab' => 'Page Configuration',
        ]);
        CRUD::addField([
            'name' => 'front_page_id',
            'label' => 'Select Home Page',
            'type' => 'select2_from_array',
            'options' => $pageOptions,
            'tab' => 'Page Configuration',
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    protected function setupShowOperation()
    {
        $templateOptions = $this->getTemplateOptions();
        $pageOptions = $this->getPageOptions();

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
            'label' => 'Url',
        ]);
        CRUD::addColumn([
            'name' => 'template_id',
            'label' => 'Select Template',
            'type' => 'select_from_array',
            'options' => $templateOptions,
        ]);
        CRUD::addColumn([
            'name' => 'front_page_id',
            'label' => 'Select Home Page',
            'type' => 'select_from_array',
            'options' => $pageOptions,
        ]);
        CRUD::addColumn([
            'name' => 'shop_page_id',
            'label' => 'Select Category List Page',
            'type' => 'select_from_array',
            'options' => $pageOptions,
        ]);
        CRUD::addColumn([
            'name' => 'product_page_id',
            'label' => 'Default Template For Products',
            'type' => 'select_from_array',
            'options' => $pageOptions,
        ]);
        CRUD::addColumn([
            'name' => 'front_page_id',
            'label' => 'Select Home Page',
            'type' => 'select_from_array',
            'options' => $pageOptions,
        ]);
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
        $this->setupCreateOperation();
    }

    public function getTemplateOptions()
    {
        $templateOptions = [];
        foreach (config('amplify.cms.templates') as $template) {
            $templateOptions[$template['id']] = $template['label'];
        }

        return $templateOptions;
    }

    public function getPageOptions()
    {
        return Page::all()->pluck('name', 'id')->toArray();
    }
}
