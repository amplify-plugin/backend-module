<?php

namespace Amplify\System\Backend\Http\Controllers;

use Amplify\System\Backend\Http\Requests\FrontendContactRequest;
use Amplify\System\Backend\Http\Resources\DataTableCollectionResource;
use Amplify\System\Backend\Models\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return DataTableCollectionResource
     */
    public function index(Request $request)
    {
        $filters = (array) json_decode($request->filters);
        $customer = customer(true);
        $keyword = $request->search;

        $data = Contact::when(isset($filters['isAdmin']) && $filters['isAdmin'], function ($query) {
            return $query->where('is_admin', true);
        })->when(isset($filters['isApprover']) && $filters['isApprover'], function ($query) {
            return $query->where('is_approver', true);
        })->where(['customer_id' => $customer->customer_id, ['id', '<>', $customer->id]])->where(function ($query) use ($keyword) {
            return $query->where('id', 'LIKE', "%{$keyword}%")
                ->orWhere('name', 'LIKE', "%{$keyword}%")
                ->orWhere('email', 'LIKE', "%{$keyword}%")
                ->orWhere('order_limit', 'LIKE', "%{$keyword}%");
        })->orderBy($request->column, $request->dir)->paginate($request->length);

        return new DataTableCollectionResource($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return JsonResponse
     */
    public function store(FrontendContactRequest $request)
    {
        $contact = Contact::create($request->validated());
        $contact->assignRole($request->input('roles'));

        if ($request->ajax()) {
            return response()->json(['message' => 'Contact has been created.'], 200);
        } else {
            return redirect(url('contact-list'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(FrontendContactRequest $request, Contact $contact)
    {
        $contact->update($request->validated());
        $contact->syncRoles($request->input('roles'));

        if ($request->ajax()) {
            return response()->json(['message' => 'Successfully updated'], 200);
        } else {
            return redirect(url('contact-list'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
