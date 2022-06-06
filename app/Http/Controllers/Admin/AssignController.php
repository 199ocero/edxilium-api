<?php

namespace App\Http\Controllers\Admin;

use App\Models\Assign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Instructor;
use Illuminate\Validation\ValidationException;

class AssignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $user = $user->role;
        if($user=='admin'){
            $subject = Assign::with('instructor','section','subject','schoolYear')->latest()->get();
            $response = [
                'message' => 'Fetch all data successfully!',
                'data' => $subject
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $user = $user->role;
        if($user=='admin'){
            
            $data = $request->validate([
                'instructor_id' => 'required',
                'section_id' => 'required',
                'subject_id' => 'required',
                'school_year_id' => 'required',
            ]);
           
            $assignName = Assign::where('instructor_id',$data['instructor_id'])
                            ->where('subject_id',$data['subject_id'])
                            ->where('school_year_id',$data['school_year_id'])
                            ->get();
            if(!$assignName->isEmpty()){
                throw ValidationException::withMessages([
                    'instructor_id' => 'This assign combination is already added in our record. Please use another combination.'
                ]);
            }else{
                $assign = Assign::create([
                'instructor_id' => $data['instructor_id'],
                'section_id' => $data['section_id'],
                'subject_id' => $data['subject_id'],
                'school_year_id' => $data['school_year_id'],
            ]);
            $response = [
                'message' => 'Assign created successfully!',
                'data' => $assign,
            ];

            return response($response,201);
            
        }
            
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
    public function show($id)
    {
        $user = auth()->user();
        $user = $user->role;
        if($user=='admin'){
            $subject = Assign::with('instructor','section','subject','schoolYear')->find($id);
            $response = [
                'message' => 'Fetch specific assign successfully!',
                'data' => $subject,
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
        $user = auth()->user();
        $user = $user->role;
        if($user=='admin'){
            $data = $request->validate([
               'instructor_id' => 'required',
                'section_id' => 'required',
                'subject_id' => 'required',
                'school_year_id' => 'required',
            ]);

            $assign = Assign::find($id);
            $assign->instructor_id = $data['instructor_id'];
            $assign->section_id = $data['section_id'];
            $assign->subject_id = $data['subject_id'];
            $assign->school_year_id = $data['school_year_id'];
            $assign->update();

            $response = [
                'message' => 'Assign updated successfully!',
                'data' => $assign,
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();
        $user = $user->role;
        if($user=='admin'){
            $subject = Assign::destroy($id);

            if($subject==0){
                $response = [
                    'message' => 'Assign not found.'
                ];
            }else{
                $response = [
                    'message' => 'Assign deleted successfully!'
                ];
            }
            

            return response($response,200);
        }else{
            $response = [
                'message' => 'User unauthorized.',
            ];
            return response($response,401);
        }
    }
}
