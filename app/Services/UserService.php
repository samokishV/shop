<?php

namespace App\Services;

use App\User;

class UserService
{
    /**
     * @param string $email
     * @param string $password
     * @param string $role
     * @param string $timezone
     */
    public function store($email, $password, $role, $timezone)
    {
        User::store($email, $password, $role, $timezone);
    }

    /**
     * @param string $email
     * @param string $password
     * @param string $role
     * @param string $timezone
     * @param $id
     */
    public function update($email, $password, $role, $timezone, $id)
    {
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
