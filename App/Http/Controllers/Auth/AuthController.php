<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginFormRequest;
use App\Models\User;
use Core\Http\Controller;
use Core\Redirect;
use Core\View;
use Exception;

class AuthController extends Controller
{
    /**
     * @throws Exception
     */
    public function login(LoginFormRequest $request)
    {
            if($request->get('username') && $request->get('password')){
                $user = new User();
                $user = $user->whereLogin('username', '=', $request->get('username'));

                if(!empty($user)){
                    if(password_verify($request->get('password'), $user["password"]))
                    {
                        $_SESSION['logged'] = true;
                        $_SESSION['id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['name'] = $user['name'];

                        return Redirect::route('/home', ["user" => $user]);
                    }
                }

                return Redirect::route('/', ['error_messages' => 'Username and password are invalid!']);
            }
    }

    public function logout(): Redirect
    {
        session_destroy();

        return Redirect::route('/');
    }

}