<?php

namespace App\Http\Controllers\Instructor;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Drop;

class StuController extends Controller
{
    public function add($student_id,$section_id,$subject_id){
        $user = auth()->user();
        $user = $user->role;
        if($user=='instructor'){

            Drop::where('student_id',$student_id)->where('section_id',$section_id)->where('subject_id',$subject_id)->delete();
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
    public function drop($student_id,$section_id,$subject_id){
        $user = auth()->user();
        $user = $user->role;
        if($user=='instructor'){

            $drop = Drop::create([
                'student_id' => $student_id,
                'section_id' => $section_id,
                'subject_id' => $subject_id,
            ]);

            $response = [
                'message' => 'Student drop successfully!',
                'data'=>$drop
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
