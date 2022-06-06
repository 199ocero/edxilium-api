<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    public function forgot() {
        
        $credentials = request()->validate(['email' => 'required|email']);
        $findEmail = User::where('email', $credentials)->first();
        if($findEmail){
            Password::sendResetLink($credentials);

            return response()->json(["msg" => 'Reset password link sent on your email address.'],200);
        }else{
            throw ValidationException::withMessages([
                    'email' => 'Email does not exist.'
            ]);
        }
        
    }
    public function reset() {
        $credentials = request()->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);

        $reset_password_status = Password::reset($credentials, function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        if ($reset_password_status == Password::INVALID_TOKEN) {
            return view('error.invalid_token');
            // return response()->json(["msg" => "Invalid token provided"], 400);
        }else{
            return redirect()->away(env('FRONTEND_URL'));
        }
    }
}
