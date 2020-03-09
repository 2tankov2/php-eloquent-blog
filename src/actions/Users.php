<?php

namespace App\actions;

use App\User;

class Users
{
    public static function index()
    {
        // BEGIN (write your solution here)
        $users = User::all(); 
        return $users;
        // END
    }

    public static function create($params)
    {
        // BEGIN (write your solution here)
        $user = new User();
        $user->first_name = $params['first_name'];
        $user->last_name = $params['last_name'];
        $user->email = $params['email'];
        $user->password = password_hash($params['password'], PASSWORD_DEFAULT);
        $user->save();
        return $user;
        // END
    }

    public static function update($id, $params)
    {
        // BEGIN (write your solution here)
        $user = User::find($id);
        if ($params['first_name']) {
            $user->first_name = $params['first_name'];
        }
        if ($params['last_name']) {
            $user->last_name = $params['last_name'];
        }
        if ($params['email']) {
            $user->email = $params['email'];
        }
        if ($params['password']) {
            $user->password = password_hash($params['password'], PASSWORD_DEFAULT);
        }
        $user->save();
        return $user;
        // END
    }

    public static function delete($id)
    {
        // BEGIN (write your solution here)
        $user = User::find($id);
        if (!$user) {
            return false;
        }

        return $user->delete();
        // END
    }
}
