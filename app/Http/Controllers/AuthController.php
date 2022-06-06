<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            'role' => 'required|string',
            'status' => 'required|string',
            'email' => 'required|unique:users,email|string',
            'password' => 'required|confirmed|string',
        ]);
        if($data['role']=='instructor'){
            $instructor = User::create([
                'role' => $data['role'],
                'status' => $data['status'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
            Instructor::create([
                'instructor_id' => $instructor->id,
            ]);
            $token = $instructor->createToken('token')->plainTextToken;
            $response = [
                'message' => 'Instructor created successfully!',
                'data' => $instructor,
                'token' => $token
            ];
            return response($response,201);
        }else{
            $admin = User::create([
                'role' => $data['role'],
                'status' => $data['status'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
            $token = $admin->createToken('token')->plainTextToken;
            $response = [
                'message' => 'Admin created successfully!',
                'data' => $admin,
                'token' => $token
            ];
            return response($response,201);
        }  
        
    }
    public function login(Request $request){
        $data = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Check email
        $user = User::where('email',$data['email'])->first();
        
        if(!$user || !Hash::check($data['password'],$user->password)){
            throw ValidationException::withMessages([
                'email' => 'The provided credentials are incorrect.'
            ]);
        }else{
            if($user->hasVerifiedEmail()){
                if($user->status == 'activated'){
                    $token = $user->createToken('token')->plainTextToken;
                    if($user->role=='admin'){
                        $response = [
                            'message' => 'Admin login successfully!',
                            'data' => $user,
                            'role' => 'admin',
                            'token' => $token
                        ];
                        return response($response,200);
                    }else{
                        $response = [
                            'message' => 'Instructor login successfully!',
                            'data' => $user,
                            'role' => 'instructor',
                            'token' => $token
                        ];
                        return response($response,200);
                    }
                }else{
                    throw ValidationException::withMessages([
                        'account' => 'Your account is deactivated. Please contact your school administrator.'
                    ]);
                }
                
            }else{
                throw ValidationException::withMessages([
                    'verified' => 'The email address is not verified. Please contact your school administrator.'
                ]);
            }
        }
    }
    
    public function logout(Request $request){

        $request->user()->currentAccessToken()->delete();
        $response = [
            'message' => 'Logged out. Token destroyed, but do not worry as it will generate again when you login.'
        ];
        return response($response,200);
    }
    public function role(){
        $user = auth()->user();
        $user = $user->role;
        $response = [
            'role' => $user 
        ];
        return response($response,200);
    }
}
