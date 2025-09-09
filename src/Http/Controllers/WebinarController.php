<?php

namespace Amplify\System\Backend\Http\Controllers;

use Amplify\System\Backend\Models\Webinar;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebinarController extends Controller
{
    public function index(Request $request)
    {
        $webinars = Webinar::query();

        if ($request->filled('q')) {
            $webinars->where('title', 'LIKE', "%{$request->q}%");
        }

        if ($request->filled('location')) {
            $webinars->where('address_name', 'LIKE', "%{$request->location}%");
        }

        if ($request->filled('daterange')) {
            [$startDateTime, $endDateTime] = explode(' - ', $request->daterange);

            $webinars->whereBetween('start_date_time', [
                Carbon::parse($startDateTime)->format('Y-m-d g:i:s'),
                Carbon::parse($endDateTime)->format('Y-m-d g:i:s'),
            ]);
        } else {
            $webinars->where('end_date_time', '>=', Carbon::now()->format('Y-m-d g:i:s'));
        }

        if ($request->filled('types')) {
            $webinars->whereHas('webinarType', function ($query) use ($request) {
                $query->whereIn('id', $request->types);
            });
        }

        return view('theme::template-1.components.webinar.index', [
            'webinars' => $webinars->with('webinarType')->orderBy('start_date_time', 'ASC')->paginate(12),
        ]);
    }

    public function getCalendarEvent(Request $request)
    {
        $request->validate([
            'start' => 'required',
            'end' => 'required',
        ]);

        $webinars = Webinar::select([
            'id',
            'page_id',
            'title',
            DB::raw("DATE_FORMAT(start_date_time, '%Y-%m-%d') as start_date"),
            DB::raw("DATE_FORMAT(end_date_time, '%Y-%m-%d') as end_date"),
        ])
            ->whereDate('start_date_time', '>=', $request->start)
            ->whereDate('end_date_time', '<=', $request->end)
            ->with(['page' => fn ($q) => $q->select('id', 'slug', 'name')])
            ->get();

        return response()->json([
            'data' => $webinars,
        ], 200);
    }
}
