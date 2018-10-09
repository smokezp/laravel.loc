<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends ApiController
{
    public function login(Request $request)
    {
        $array = $request->all();
        Validator::make($array, [
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::where('email', $request->email)->first()->toArray();
            return $this->success(compact('user'), 'You are logined');
        } else {
            return $this->error('', 'You are not logined');
        }
    }

    public function register(Request $request)
    {
        $array = $request->all();
        Validator::make($array, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();

        $is_exist_user = User::where('email', $request->email)->first();
        if ($is_exist_user) {
            return $this->error('', 'This email already exist');
        } else {
            $user = User::create($array);
            auth()->login($user);
            $user = $user->toArray();
            return $this->success(compact('user'), 'You are registered');
        }
    }
}
