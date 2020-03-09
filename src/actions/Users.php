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
        /**
         * $user = new User($params);
         * if (array_key_exists('password', $params)) {
         *    $user->password = password_hash($params['password'], PASSWORD_DEFAULT);
         * }
         */
        $user->password = password_hash($params['password'], PASSWORD_DEFAULT);
        $user->save();
        return $user;
        // END
    }

    public static function update($id, $params)
    {
        // BEGIN (write your solution here)
        $user = User::find($id);
        /**
         * $user->fill($params);
         * if (array_key_exists('password', $params)) {
         *     $user->password = password_hash($params['password'], PASSWORD_DEFAULT);
         * }
         */
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

    public static function indexQuery($params = [])
    {
        // BEGIN (write your solution here)
        if (empty($params)) {
            return User::all();
        }
        $users = User::query();
        switch ($params) {
            case array_key_exists('q', $params):
                foreach($params['q'] as $key => $val) {
                    $users->orWhere($key, '=', $val);
                }
                break;
            case array_key_exists('s', $params):
                [$key, $val] = explode(':', $params['s']);
                $users->orderBy($key, $val);
            break;
            default:
                return $users;
        };
        return $users->get();
        /**
         * $scope = User::query();

         * if (array_key_exists('s', $params)) {
         *    $sorting = $params['s'];
         *    [$fieldName, $direction] = explode(':', $sorting);
         *    $scope->orderBy($fieldName, $direction);
         * }

         * if (array_key_exists('q', $params)) {
         *    $conditions = $params['q'];
         *    foreach ($conditions as $name => $value) {
         *        $scope->orWhere($name, $value);
         *    }
         * }
         * return $scope->get();
         */
        // END
    }
}
