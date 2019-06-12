<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('users.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'email' => 'required | email | unique:"users',
            'password' => 'required | min:8',
            'role' => 'required',
            'timezone' => 'nullable|timezone',
        ]);

        if ($validator->fails()) {
            $request->flash();
            return view('users.add')->withErrors($validator->messages());
        } else {
            $email = $request->email;
            $password = $request->password;
            $role = $request->role;
            $timezone = $request->timezone;
            User::store($email, $password, $role, $timezone);
            return redirect(route('admin.user.index'));
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $validator =  Validator::make($request->all(), [
            'email' => ['required' , Rule::unique('users')->ignore($user->id)],
            'password' => 'required | min:8',
            'role' => 'required',
            'timezone' => 'nullable|timezone',
        ]);

        if ($validator->fails()) {
            $request->flash();
            $user = User::find($id);
            return view('users.edit', ['user' => $user])->withErrors($validator->messages());
        } else {
            $email = $request->email;
            $password = $request->password;
            $role = $request->role;
            $timezone = $request->timezone;
            User::updateById($id, $email, $password, $role, $timezone);
            return redirect(route('admin.user.index'));
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
        $user = User::find($id);
        $user->delete();
    }
}
