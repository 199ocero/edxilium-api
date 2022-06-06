<?php

namespace App\Http\Controllers\Instructor;

use App\Models\Assign;
use App\Models\Student;
use App\Models\Irregular;
use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IrregController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $user = $user->role;
        if($user=='instructor'){
            $instructor_id = Instructor::where('instructor_id',auth()->id())->first();
            $data = $request->validate([
                'student_id' => 'required',
                'section_id' => 'required',
                'subject_id' => 'required', 
            ]);
           
            $irreg = Irregular::create([
                'student_id' => $data['student_id'],
                'instructor_id' => $instructor_id->id,
                'section_id' => $data['section_id'],
                'subject_id' => $data['subject_id'],
            ]);
            $response = [
                'message' => 'Irregular student created successfully!',
                'data' => $irreg,
            ];

            return response($response,201);
            
        }else{
            $response = [
                'message' => 'User unauthorized.',
            ];
            return response($response,401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($section_id,$subject_id)
    {
        $user = auth()->user();
        $user = $user->role;
        if($user=='instructor'){
            $assign = Assign::whereNotIn('section_id',[$section_id])
                            ->whereNotIn('subject_id',[$subject_id])
                            ->get();
            $section = [];

            foreach($assign as $assign){
                $section[]=$assign->section_id;
            }
            $irreg = Irregular::all();

            $irregular=[];
            foreach($irreg as $irreg){
                $irregular[]=$irreg->student_id;
            }

            $student = Student::with('section')->where('section_id',$section)->whereNotIn('id',$irregular)->latest()->get();

            $response = [
                'message' => 'Fetch specific irregular student successfully!',
                'data'=>$student
            ];
            
            return response($response,200);
        }else{
            $response = [
                'message' => 'User unauthorized.',
            ];
            return response($response,401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($student_id,$section_id,$subject_id)
    {
        $user = auth()->user();
        $user = $user->role;
        if($user=='instructor'){
            Irregular::where('student_id',$student_id)
                    ->where('section_id',$section_id)
                    ->where('subject_id',$subject_id)
                    ->delete();

            $response = [
                'message' => 'Irregular student deleted successfully!'
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
