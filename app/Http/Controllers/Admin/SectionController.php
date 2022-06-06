<?php

namespace App\Http\Controllers\Admin;

use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SectionController extends Controller
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
            $section = Section::latest()->get();
            $response = [
                'message' => 'Fetch all data successfully!',
                'data' => $section
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
            'section' => 'required|unique:sections,section|string',
        ]);
        $section = Section::create([
            'section' => $data['section'],
        ]);
        $response = [
            'message' => 'Section created successfully!',
            'data' => $section,
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
    public function show($id)
    {
        $user = auth()->user();
        $user = $user->role;
        if($user=='admin'){
            $section = Section::find($id);
        $response = [
            'message' => 'Fetch specific section successfully!',
            'data' => $section,
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
            $section = Section::find($id);
        $section->update($request->all());

        $response = [
            'message' => 'Section updated successfully!',
            'data' => $section,
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
            $section = Section::destroy($id);
            Student::where('section_id',$id)->delete();
            if($section==0){
                $response = [
                    'message' => 'Section not found.'
                ];
            }else{
                $response = [
                    'message' => 'Section deleted successfully!'
                ];
            }
            

            return response($response,200);
        }
    }
}
