<?php

namespace App\Services;

use App\User;
use Illuminate\Http\Request;

class UserService
{
    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $role = $request->role;
        $timezone = $request->timezone;
        User::store($email, $password, $role, $timezone);
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        $email = $request->email;
        $password = $request->password;
        $role = $request->role;
        $timezone = $request->timezone;
        User::updateById($id, $email, $password, $role, $timezone);
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
    }
}
