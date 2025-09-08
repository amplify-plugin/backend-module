<?php

namespace Amplify\System\Backend\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AlexusmaiFileManagerController extends Controller
{
    public function index()
    {
        return view('crud::pages.filemanager.filemanager');
    }

    public function popup($input_id, Request $request)
    {
        $is_multiple = 0;
        if ($request->has('multiple')) {
            $is_multiple = 1;
        }

        return view('crud::pages.filemanager.filemanager-popup', ['inputId' => $input_id, 'isMultiple' => $is_multiple]);
    }
}
