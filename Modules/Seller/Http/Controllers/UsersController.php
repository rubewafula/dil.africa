<?php

namespace Modules\Seller\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use  App\User;
use Auth;
use  Session;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('seller::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('seller::users.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {


        $request->validate([
             'first_name'=>'required',
             'last_name'=>'required',
             'email'=>'required|email|unique:users|max:100',
             'password'=>'required|min:5|max:20',
             'role_id'=>'required'
        ]);


        $requestData = $request->all();

        $requestData['password']= bcrypt($request->password);
        $requestData['seller_id']= Auth::user()->seller_id;


        
        $user=   User::create($requestData);

        $user->attachRole($request->role_id);
        Session::flash('flash_message','updated successfully');

        return  redirect('seller/users');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('seller::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id,  Request  $request)
    {

        $user=  User::find($id);
        return view('seller::users.edit',compact('user'));


    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update($id,Request $request)
    {

        $user=  User::find($id);


          $request->validate([
             'first_name'=>'required',
             'last_name'=>'required',
             'email' => 'unique:users,email,'.$id,
             'password'=>'nullable|min:5|max:20',
        ]);
        
        $requestData = $request->except('password');

  if(!empty($request->password))
  {
    $requestData['password']= bcrypt($request->password);
    $requestData['seller_id']= Auth::user()->seller_id;

  }

        
        $user->update($requestData);

        if($request->has('role_id'))
        {

            $user->attachRole($request->role_id);
        }

        return redirect('seller/users')->with('flash_message', 'User updated!');

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }


 public function manage_users()
  {

    $users=  User::where('seller_id',Auth::user()->seller_id)->paginate(20);

    return  view('seller::users.manage_users',compact('users'));

  }
}
