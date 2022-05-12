<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify($user_id, Request $request) {
        if (!$request->hasValidSignature()) {
            // return response()->json(["msg" => "Expired url provided."], 401);
            return response()->view('error.expired', [], 403);
        }
    
        $user = User::findOrFail($user_id);
    
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }
    
        return redirect()->to('/');
    }
    
    public function resend($id) {
        $user = User::findOrFail($id);

        if ($user->hasVerifiedEmail()) {
            return response()->json(["message" => "Email already verified."], 400);
        }else{
            $user->sendEmailVerificationNotification();
            return response()->json(["message" => "Email verification link sent on your email."]);
        }
    
        
    }
}
