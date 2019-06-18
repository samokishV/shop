<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\Services\UserService;
use App\User;
use Illuminate\Http\Response;

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
     * @param StoreUser $request
     * @param UserService $user
     * @return Response
     */
    public function store(StoreUser $request, UserService $user)
    {
        $user->store($request);
        return redirect(route('admin.user.index'));
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
     * @param UpdateUser $request
     * @param int $id
     * @param UserService $user
     * @return Response
     */
    public function update(UpdateUser $request, $id, UserService $user)
    {
        $user->update($request, $id);
        return redirect(route('admin.user.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param UserService $user
     * @return void
     */
    public function destroy($id, UserService $user)
    {
        $user->destroy($id);
    }
}
