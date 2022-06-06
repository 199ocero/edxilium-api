<?php

namespace App\Http\Controllers\Instructor;

use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
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
        //
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
        if($user=='instructor'){
            $instructor = Instructor::where('instructor_id',auth()->id())->first();
            $response = [
                'message' => 'Fetch specific instructor wtf howww?!',
                'data' => $instructor,
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
        if($user=='instructor'){
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
            ]);
            $number =$data['contact_number'];
            $result = sprintf("(%s) %s-%s",
                substr($number, 0, 3),
                substr($number, 3, 3),
                substr($number, 6));
            $instructor = Instructor::where('instructor_id',auth()->id())->first();
            $instructor->first_name = $data['first_name'];
            $instructor->middle_name = $data['middle_name'];
            $instructor->last_name = $data['last_name'];
            $instructor->age = $data['age'];
            $instructor->gender = $data['gender'];
            $instructor->contact_number = $result;
            $instructor->update();
    
            $response = [
                'message' => 'Profile updated successfully!',
                'data' => $instructor,
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
        //
    }
}
