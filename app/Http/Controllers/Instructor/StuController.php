<?php

namespace App\Http\Controllers\Instructor;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StuController extends Controller
{
    public function add($id){
        $user = auth()->user();
        $user = $user->role;
        if($user=='instructor'){

            $drop = Student::find($id);
            $drop->drop_status=0;
            $drop->update();

            $response = [
                'message' => 'Student added successfully!'
            ];
            
            return response($response,200);
        }else{
            $response = [
                'message' => 'User unauthorized.',
            ];
            return response($response,401);
        }
    }
    public function drop($id){
        $user = auth()->user();
        $user = $user->role;
        if($user=='instructor'){

            $drop = Student::find($id);
            $drop->drop_status=1;
            $drop->update();

            $response = [
                'message' => 'Student drop successfully!'
            ];
            
            return response($response,200);
        }else{
            $response = [
                'message' => 'User unauthorized.',
            ];
            return response($response,401);
        }
    }
}
