<?php

namespace Amplify\System\Backend\Http\Controllers\Backpack\Operations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

trait SlugOperation
{
    protected function setupCloneRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/slug', [
            'as' => $routeName.'.slug',
            'uses' => $controller.'@slug',
            'operation' => 'slug',
        ]);
    }

    protected function setupSlugDefaults()
    {
        $this->crud->allowAccess('slug');

        $this->crud->operation('slug', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
        });
    }

    public function slug(Request $request)
    {
        $where = $request->has('id')
            ? [['slug', 'LIKE', '%'.$request->slug.'%'], ['id', '!=', $request->id]]
            : ['slug' => $request->slug];

        $count = $this->crud->model->where($where)->count();

        return response()->json([
            'slug' => $count ? "$request->slug-$count" : $request->slug,
        ], 200);
    }
}
