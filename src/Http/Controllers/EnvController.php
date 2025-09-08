<?php

namespace Amplify\System\Backend\Http\Controllers;

use Amplify\System\Helpers\EnvHelper;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Throwable;

class EnvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('vendor.backpack.crud.pages.env-settings.create');
    }

    /**
     * Update the specified resource in storage.
     *
     *
     * @throws Throwable
     */
    public function changeDB(): JsonResponse
    {
        $newDB = Str::snake(request('newDB'));
        $createNewDB = request('createNewDB');

        return response()->json(EnvHelper::changeDB($newDB, $createNewDB));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Application|JsonResponse|RedirectResponse|Redirector
     *
     * @throws Throwable
     */
    public function resetDB()
    {
        $returnTo = urldecode(request('returnTo'));
        $response = EnvHelper::resetToDefaultDB();

        return $returnTo
            ? redirect($returnTo)
            : response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return array|JsonResponse
     *
     * @throws Throwable
     */
    public function checkDB()
    {
        return EnvHelper::checkDB();
    }
}
