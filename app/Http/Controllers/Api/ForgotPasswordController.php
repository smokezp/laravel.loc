<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Validator;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordReset;
use App\PasswordReset as PasswordResetModel;

class ForgotPasswordController extends ApiController
{
    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);
        $email = $request->email;
        $token = Hash::make(uniqid());
        $userId = User::where('email', $email)->pluck('id')->first();
        PasswordResetModel::create([
            'user_id' => $userId,
            'token' => $token
        ]);

        Mail::to($email)->send(new PasswordReset($token));
        $sent = (!Mail::failures());
        if ($sent) {
            return $this->success();
        } else {
            return $this->error();
        }
    }

    public function verifyToken(Request $request)
    {
        $this->validateToken($request);
        return $this->success();
    }

    public function reset(Request $request)
    {
        $this->validateToken($request);
        $this->validatePasswords($request);
        $passwordReset = PasswordResetModel::where('token', $request->token)->first();
        $passwordReset->user->update(['password' => Hash::make($request->password)]);
        $passwordReset->used = true;
        $passwordReset->save();
        return $this->success();
    }


    /**
     * Validate the email for the given request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateEmail(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email'
        ])->validate();
    }

    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateToken(Request $request)
    {
        Validator::make($request->all(), [
            'token' => [
                'required', 'exists:password_resets,token,used,0',
            ]
        ])->validate();
    }

    private function validatePasswords(Request $request)
    {

        Validator::make($request->all(), [
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8|same:password',
        ])->validate();

    }
}
