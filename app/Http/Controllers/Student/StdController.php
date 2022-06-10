<?php

namespace App\Http\Controllers\Student;

use App\Models\Drop;
use App\Models\Student;
use App\Models\Irregular;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StdController extends Controller
{
    public function show(){
        $user = auth()->user();
        $user = $user->role;
        if($user=='student'){
            $student = Student::where('student_user_id',auth()->id())->first();
            $response = [
                'message' => 'Fetch specific student profile!',
                'data' => $student,
            ];

            return response($response,200);
        }else{
            $response = [
                'message' => 'User unauthorized.',
            ];
            return response($response,401);
        }
    }
    public function update(Request $request)
    {
        $user = auth()->user();
        $user = $user->role;
        if($user=='student'){
            $requestData = $request->all();
            $requestData['contact_number'] = preg_replace('/\D/', '', $request->contact_number);
            $request->replace($requestData);
            $data = $request->validate([
                'first_name' => 'required|string',
                'middle_name' => 'required|string',
                'last_name' => 'required|string',
                'age' => 'required|string',
                'gender' => 'required|string',
                'contact_number' => 'required|digits:10',
                'facebook_id' => 'required|digits:16',
            ]);
            $number =$data['contact_number'];
            $result = sprintf("(%s) %s-%s",
                substr($number, 0, 3),
                substr($number, 3, 3),
                substr($number, 6));
            $student = Student::where('student_user_id',auth()->id())->first();
            $student->first_name = $data['first_name'];
            $student->middle_name = $data['middle_name'];
            $student->last_name = $data['last_name'];
            $student->age = $data['age'];
            $student->gender = $data['gender'];
            $student->facebook_id = $data['facebook_id'];
            $student->contact_number = $result;
            $student->update();
    
            $response = [
                'message' => 'Profile updated successfully!',
                'data' => $student,
            ];
    
            return response($response,200);
        }else{
            $response = [
                'message' => 'User unauthorized.',
            ];
            return response($response,401);
        }
    }
    public function studentProfile($fbID){
        $student = Student::where('facebook_id',$fbID)->first();
        if($student){
             $response = [
                'message' => 'Fetch specific student profile!',
                'data' => $student,
            ];

            return response($response,200);
        }else{
            $response = [
                'message' => 'Facebook ID not found. Please register your ID by clicking the Visit Edxilium in menu.',
            ];

            return response($response,200);
        }
       
    }
    public function studentAnnouncement($fbID){

        $student = Student::where('facebook_id',$fbID)->first();

        if($student){
            $irregular = Irregular::where('student_id',$student->id)->latest()->get();
            $drop = Drop::where('student_id',$student->id)->latest()->get();

            $section_id = [];
            foreach($irregular as $irreg){
                $section_id[]=$irreg->section_id;
            }
            $drop_section_id = [];
            $drop_subject_id = [];
            foreach($drop as $drop){
                $drop_section_id[]=$drop->section_id;
                $drop_subject_id[]=$drop->section_id;

            }
            array_push($section_id,$student->section_id);

            $announcement = Announcement::with('section','subject')->whereIn('section_id',$section_id)
                                        ->whereNotIn('section_id',$drop_section_id)
                                        ->whereNotIn('section_id',$drop_subject_id)
                                        ->latest()
                                        ->get();
            if($announcement){
                $response = [
                    'message' => 'Fetch specific student announcement!',
                    'data' => $announcement,
                ];

                return response($response,200);
            }else{
                $response = [
                    'message' => 'No announcement found. It is either your instructor didn\'t create announcement yet or you are drop in all section and subjects.',
                ];

                return response($response,200);
            }
            
        }else{
            $response = [
                'message' => 'Facebook ID not found. Please register your ID by clicking the Visit Edxilium in menu.',
            ];

            return response($response,200);
        }
        
    }
}
