<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Developers\DeveloperRequest;
use App\Models\Developer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;


class DeveloperController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('isAdmin')) {
            return $this->unauthorizedResponse();
        }
        // $this->authorize('isAdmin');
        
        $users = Developer::latest()->paginate(10);

        return $this->sendResponse($users, 'Developers list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Users\DeveloperRequest  $request
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(DeveloperRequest $request)
    {
        $user = Developer::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'phone_number' => $request['phone_number'],
            'address' => $request['address'],
        ]);

        return $this->sendResponse($user, 'Developer Created Successfully');
    }

    /**
     * Update the resource in storage
     *
     * @param  \App\Http\Requests\Users\UserRequest  $request
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(DeveloperRequest $request, $id)
    {
        $user = Developer::findOrFail($id);
        $user->update($request->all());

        return $this->sendResponse($user, 'Developer Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->authorize('isAdmin');

        $single_user_id = explode(',' , $id);

       foreach($single_user_id as $id) {
        $user = Developer::findOrFail($id);
        $user->delete();
       }

        

        return $this->sendResponse([$user], 'Developer has been Deleted');
    }
}
