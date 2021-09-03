<?php

namespace Modules\Backend\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;
use Validator;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $users = User::where('first_name', 'LIKE', "%$keyword%")
                ->orWhere('gender', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $users = User::latest()->paginate($perPage);
        }

        return view('backend::users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend::users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $request->validate([
             'first_name'=>'required',
             'last_name'=>'required',
             'email'=>'required|email',
             'password'=>'required|min:5|max:20',
             'role_id'=>'required'
        ]);


        $requestData = $request->all();

        $requestData['password']= bcrypt($request->password);
        $requestData['is_customer'] = 0;
        
        $user=   User::create($requestData);

        $user->attachRole($request->role_id);

        return redirect()->back()->with('flash_message', 'User added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('backend::users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('backend::users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {

            $request->validate([
             'first_name'=>'required',
             'last_name'=>'required',
             'email'=>'required|email',
             'password'=>'nullable|min:5|max:20',
        ]);

        
        $requestData = $request->except('password');

  if($request->has('password'))
  {
    $requestData['password']= bcrypt($request->password);
  }

        
        $user = User::findOrFail($id);
        $user->update($requestData);

        if($request->has('role_id'))
        {

            $user->attachRole($request->role_id);
        }

        return redirect('backend/users')->with('flash_message', 'User updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        User::destroy($id);

        return redirect('backend/users')->with('flash_message', 'User deleted!');
    }


    public  function  remove_user_role($user_id,$role_id)
    {

       $user=  User::findOrFail($user_id);
       $user->DetachRole($role_id);

       return  redirect()->back()->with('flash_message','User  Role  removed  successfully');

    }
}
