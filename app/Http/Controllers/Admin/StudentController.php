<?php

namespace App\Http\Controllers\Admin;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class StudentController extends Controller
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
    public function store(Request $request,$section_id)
    {
        $user = auth()->user();
        $user = $user->role;
        if($user=='admin'){
             $requestData = $request->all();
            $requestData['contact_number'] = preg_replace('/\D/', '', $request->contact_number);
            $request->replace($requestData);
            $data = $request->validate([
                'student_id' => 'required|unique:students,student_id|string',
                'first_name' => 'required|string',
                'middle_name' => 'required|string',
                'last_name' => 'required|string',
                'age' => 'required|string',
                'gender' => 'required|string',
                'contact_number' => 'required|digits:10',
                'email' => 'required|unique:students,email|string',
            ]);
            $number =$data['contact_number'];
            $result = sprintf("(%s) %s-%s",
                substr($number, 0, 3),
                substr($number, 3, 3),
                substr($number, 6));
            $student = Student::create([
                'section_id' => $section_id,
                'student_id' => $data['student_id'],
                'first_name' => $data['first_name'],
                'middle_name' => $data['middle_name'],
                'last_name' => $data['last_name'],
                'age' => $data['age'],
                'gender' => $data['gender'],
                'contact_number' => $result,
                'email' => $data['email'],
            ]);
            $response = [
                'message' => 'Student created successfully!',
                'data' => $student,
            ];

            return response($response,201);
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
            $student = Student::where('section_id',$id)->latest()->get();
            $response = [
                'message' => 'Fetch specific student successfully!',
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
    public function showSpecific($id)
    {
        $user = auth()->user();
        $user = $user->role;
        if($user=='admin'){
            $student = Student::find($id);
            $response = [
                'message' => 'Fetch specific student successfully!',
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
            $requestData = $request->all();
            $requestData['contact_number'] = preg_replace('/\D/', '', $request->contact_number);
            $request->replace($requestData);
             $data = $request->validate([
                'student_id' => [
                    'required',
                    Rule::unique('students')->ignore($id),
                ],
                'first_name' => 'required|string',
                'middle_name' => 'required|string',
                'last_name' => 'required|string',
                'age' => 'required|string',
                'gender' => 'required|string',
                'contact_number' => 'required|digits:10',
                'email' => [
                    'required',
                    Rule::unique('students')->ignore($id),
                ],
            ]);
            $number =$data['contact_number'];
            $result = sprintf("(%s) %s-%s",
                substr($number, 0, 3),
                substr($number, 3, 3),
                substr($number, 6));
            $student = Student::find($id);
            $student->student_id = $data['student_id'];
            $student->first_name = $data['first_name'];
            $student->middle_name = $data['middle_name'];
            $student->last_name = $data['last_name'];
            $student->age = $data['age'];
            $student->gender = $data['gender'];
            $student->contact_number = $result;
            $student->email = $data['email'];
            $student->update();
    
            $response = [
                'message' => 'Student updated successfully!',
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
            $student = Student::destroy($id);

            if($student==0){
                $response = [
                    'message' => 'Student not found.'
                ];
            }else{
                $response = [
                    'message' => 'Student deleted successfully!'
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
