<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'timezone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @param string $role
     * @return User
     */
    public static function findByRole($role)
    {
        return User::where('role', $role)
        ->get();
    }

    /**
     * @param string $email
     * @param string $password
     * @param string $role
     */
    public static function store($email, $password, $role)
    {
        $hash = Hash::make($password);

        $user = new User();
        $user->email = $email;
        $user->password = $hash;
        $user->role = $role;
        $user->save();
    }

    /**
     * @param int $id
     * @param string $email
     * @param string $password
     * @param string $role
     */
    public static function updateById($id, $email, $password, $role)
    {
        $user = User::find($id);

        $user->email = $email;

        if($user->password != $password) {
            $hash = Hash::make($password);
            $user->password = $hash;
        } else {
            $user->password = $password;
        }
        $user->role = $role;
        $user->save();
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        if($this->role === "admin") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function isManager()
    {
        if($this->role === "manager") {
            return true;
        }
    }
}
