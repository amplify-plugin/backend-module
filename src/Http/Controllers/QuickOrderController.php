<?php

namespace Amplify\System\Backend\Http\Controllers;

use Amplify\System\Imports\QuickOrderImport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class QuickOrderController extends Controller
{
    public function quickOrderFileUpload(Request $request)
    {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName().'_'.time();
        $filePath = $request->file->storeAs('public/quick_order/', $fileName);

        $fileExtension = strtoupper($file->getClientOriginalExtension());
        switch ($fileExtension) {
            case 'XLS':
                $readerType = \Maatwebsite\Excel\Excel::XLS;
                break;
            case 'XLSX':
                $readerType = \Maatwebsite\Excel\Excel::XLSX;
                break;
            default:
                $readerType = \Maatwebsite\Excel\Excel::CSV;
                break;
        }

        $fileData = Excel::toCollection(new QuickOrderImport, $filePath, 'local', $readerType);
        $fileData = $fileData->toArray();
        unset($fileData[0][0]);
        $all_products = $fileData[0];

        Storage::delete($filePath);

        return response()->json([
            'success' => true,
            'data' => $all_products,
        ]);
    }
}
