<?php

namespace App\Http\Controllers\Instructor;

use App\Models\Assign;
use App\Models\Section;
use App\Models\Student;
use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Drop;
use App\Models\Irregular;

class SecController extends Controller
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
    public function show($section_id,$subject_id)
    {
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
            $studentReg = $studentReg->map(function ($item) {
                $item->status = 'Regular';
                return $item;
            });

            $studentIrreg = Student::findMany($irreg_id);
            $studentIrreg = $studentIrreg->map(function ($item) {
                $item->status = 'Irregular';
                return $item;
            });
            
            $mergeStudent = $studentReg->merge($studentIrreg);


            $drop = Drop::where('section_id',$section_id)->where('subject_id',$subject_id)->latest()->get();

            $merge = $mergeStudent->map(function ($item) use ($drop) {
                foreach($drop as $drops){
                    if($drops->student_id==$item->id){
                        $item->status = 'Drop';
                        
                    }
                } 
                return $item;
            });
            $response = [
                'message' => 'Fetch specific student successfully!',
                'data' => $merge,
            ];

            return response($response,200);
        }else{
            $response = [
                'message' => 'User unauthorized.',
            ];
            return response($response,401);
        }
    }
    public function showInfo($section_id,$subject_id){
        $user = auth()->user();
        $user = $user->role;
        if($user=='instructor'){
            $instructor_id = Instructor::where('instructor_id',auth()->id())->first();
            $assign = Assign::with('instructor','section','subject','schoolYear')
                            ->where('instructor_id',$instructor_id->id)
                            ->where('section_id',$section_id)
                            ->where('subject_id',$subject_id)
                            ->first();
            $response = [
                'message' => 'Fetch specific section successfully!',
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
