<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use JWTAuth;
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

        if ($token = $this->attempt($request->email, $request->password)) {
            $user = User::where('email', $request->email)->first();
            return $this->success(compact('user', 'token'));
        } else {
            return $this->error();
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
            return $this->error();
        } else {
            $password = $array['password'];
            $array['password'] = bcrypt($password);
            $user = User::create($array)->toArray();
            $token = $this->attempt($array['email'], $password);
            return $this->success(compact('user', 'token'), 'You are registered');
        }
    }

    public function logout() {
        JWTAuth::invalidate(JWTAuth::getToken());
        return $this->success();
    }

    private function attempt($email, $password)
    {
        return JWTAuth::attempt(['email' => $email, 'password' => $password]);
    }
}
