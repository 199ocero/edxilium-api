<?php

namespace App\Http\Controllers\Instructor;

use App\Models\Assign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Instructor;

class AssiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $userRole = $user->role;
        if($userRole=='instructor'){
            $instructor_id = Instructor::where('instructor_id',auth()->id())->first();
            $assign = Assign::with('instructor','section','subject','schoolYear')->where('instructor_id',$instructor_id->id)->latest()->get();
            $response = [
                'message' => 'Fetch all data successfully!',
                'data' => $assign
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
        //
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
    public function destroy($id)
    {
        //
    }
}
