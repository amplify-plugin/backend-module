<?php

namespace Amplify\System\Backend\Traits;

trait ReorderTrait
{
    /**
     *  Reorder the items in the database using the Nested Set pattern.
     *
     *  Database columns needed: id, parent_id, lft, rgt, depth, name/title
     *
     * @return void
     */
    public function getReorderData()
    {
        $this->crud->hasAccessOrFail('reorder');

        if (! $this->crud->isReorderEnabled()) {
            abort(403, 'Reorder is disabled.');
        }

        $page = request()->page ?? 1;
        $items = request()->items ?? getDefaultReorderLimit();
        $limit = (int) $page * (int) $items;

        request()->merge(['page' => (string) ($page + 1)]);
        request()->merge(['items' => (string) $items]);

        $entries = $this->crud->getEntries();

        // get all results for that entity
        $this->crud->set('reorder.label', $this->reorderLabel ?? 'name');
        $this->data['entries'] = $entries->take($limit);
        $this->data['all_entries_count'] = $entries->count();
        $this->data['per_page'] = request()->items ?? 10;
        $this->data['crud'] = $this->crud;
        $this->data['title'] = $this->crud->getTitle()
                                           ?? trans('backpack::crud.reorder').' '.$this->crud->entity_name;
        // return view('crud::pages.product-classification.reorder'', $this->data);
    }
}
