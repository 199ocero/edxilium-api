<?php

namespace App\Http\Controllers\Admin;

use App\Models\SchoolYear;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class SchoolYearController extends Controller
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
            $schoolyear = SchoolYear::latest()->get();
            $response = [
                'message' => 'Fetch all data successfully!',
                'data' => $schoolyear
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
                'start_year' => 'required|string|digits:4',
                'end_year' => 'required|string|digits:4',
            ]);
            $year = SchoolYear::where('start_year',$data['start_year'])->where('end_year',$data['end_year'])->get();
            if(!$year->isEmpty()){
                throw ValidationException::withMessages([
                    'start_year' => 'This school year combination is already added in our record. Please use another combination.'
                ]);
            }
            else if($request->start_year>=$request->end_year){
                 throw ValidationException::withMessages([
                    'start_year' => 'The starting year should be lesser than the end year.'
                ]);
            }else{
                $schoolyear = SchoolYear::create([
                    'start_year' => $data['start_year'],
                    'end_year' => $data['end_year'],
                ]);
                $response = [
                    'message' => 'School Year created successfully!',
                    'data' => $schoolyear,
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
            $schoolyear = SchoolYear::find($id);
            $response = [
                'message' => 'Fetch specific school year successfully!',
                'data' => $schoolyear,
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
                'start_year' => 'required|string|digits:4',
                'end_year' => 'required|string|digits:4',
            ]);
            if($request->start_year>=$request->end_year){
                 throw ValidationException::withMessages([
                    'start_year' => 'The starting year should be lesser than the end year.'
                ]);
            }else{
                $schoolyear = SchoolYear::find($id);
                $schoolyear->start_year = $data['start_year'];
                $schoolyear->end_year = $data['end_year'];
                $schoolyear->update();
                $response = [
                    'message' => 'School Year updated successfully!',
                    'data' => $schoolyear,
                ];
                return response($response,200);
            }
            
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
            $schoolyear = SchoolYear::destroy($id);

            if($schoolyear==0){
                $response = [
                    'message' => 'School Year not found.'
                ];
            }else{
                $response = [
                    'message' => 'School Year deleted successfully!'
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
