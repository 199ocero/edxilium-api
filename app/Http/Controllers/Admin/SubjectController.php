<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class SubjectController extends Controller
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
            $subject = Subject::latest()->get();
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
                'subject' => 'required|unique:subjects,subject|string',
                'year_level' => 'required|string',
            ]);
            $subjectUppercase = strtoupper($data['subject']);
            $subjectName = Subject::where('subject',$subjectUppercase)->first();
            if($subjectName !=null){
                throw ValidationException::withMessages([
                    'subject' => 'The subject has already been taken.'
                ]);
            }else{
                 $subject = Subject::create([
                    'subject' => $data['subject'],
                    'year_level' => $data['year_level'],
                ]);
                $response = [
                    'message' => 'Subject created successfully!',
                    'data' => $subject,
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
            $subject = Subject::find($id);
            $response = [
                'message' => 'Fetch specific subject successfully!',
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
                'subject' => 'required|string',
                'year_level' => 'required|string',
            ]);

            $subject = Subject::find($id);
            $subject->subject = $data['subject'];
            $subject->year_level = $data['year_level'];
            $subject->update();

            $response = [
                'message' => 'Subject updated successfully!',
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
            $subject = Subject::destroy($id);

            if($subject==0){
                $response = [
                    'message' => 'Subject not found.'
                ];
            }else{
                $response = [
                    'message' => 'Subject deleted successfully!'
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
