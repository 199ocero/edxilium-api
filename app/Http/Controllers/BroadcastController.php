<?php

namespace App\Http\Controllers;

use App\Models\Drop;
use App\Models\Assign;
use App\Models\Student;
use App\Models\Irregular;
use App\Models\Instructor;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;

class BroadcastController extends Controller
{
    public function broadcastMessage($section_id,$subject_id){
        $user = auth()->user();
        $user = $user->role;
        if($user=='instructor'){
            
            $instructor_id = Instructor::where('instructor_id',auth()->id())->first();
            $irreg = Irregular::where('instructor_id',$instructor_id->id)
                            ->where('section_id',$section_id)
                            ->where('subject_id',$subject_id)
                            ->get();
            $irreg_id = [];

            foreach($irreg as $irreg){
                $irreg_id[]=$irreg->student_id;
            }
            

            $studentReg = Student::where('section_id',$section_id)->latest()->get();
            $studentIrreg = Student::findMany($irreg_id);
            $mergeStudent = $studentReg->merge($studentIrreg);


            $drop = Drop::where('section_id',$section_id)->where('subject_id',$subject_id)->latest()->get();

            $merge_id =[];
            
            foreach($mergeStudent as $mergeStudent){
                $merge_id[]=$mergeStudent->id;
            }
            $drop_id = [];
            foreach($drop as $drop){
                $drop_id[]=$drop->student_id;
            }

            $data = array_diff($merge_id,$drop_id);

            $finalData = Student::findMany($data);

            $fbID = [];
            foreach($finalData as $finalData){
                $fbID[]=$finalData->facebook_id;
            }
            $section = Section::find($section_id)->first();
            $subject = Subject::find($subject_id)->first();
            $response = [
                'message' => 'Fetch student facebook id successfully!',
                'section'=>$section->section,
                'subject'=>$subject->subject,
                'data' => array_filter($fbID),
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
