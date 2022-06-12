<?php

namespace App\Http\Controllers\Instructor;

use App\Models\Instructor;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class AnnController extends Controller
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
    public function store(Request $request,$section_id,$subject_id)
    {
        $user = auth()->user();
        $user = $user->role;
        if($user=='instructor'){
            $instructor_id = Instructor::where('instructor_id',auth()->id())->first();
            if($request->attachment==''){
                $data = $request->validate([
                    'deadline' => 'required',
                    'act_title' => 'string',
                    'instruction' => 'required|string',
                    'act_link' => 'required|url',
                ]);
                $announcement = Announcement::create([
                    'instructor_id' => $instructor_id->id,
                    'section_id' => $section_id,
                    'subject_id' => $subject_id,
                    'deadline' => $data['deadline'],
                    'act_title' => $data['act_title'],
                    'instruction' => $data['instruction'],
                    'act_link' => $data['act_link'],
                    'attachment' => null,
                ]);
            }else{
                $data = $request->validate([
                    'deadline' => 'required',
                    'act_title' => 'string',
                    'instruction' => 'required|string',
                    'act_link' => 'required|url',
                    'attachment' => 'url',
                ]);
                $announcement = Announcement::create([
                    'instructor_id' => $instructor_id->id,
                    'section_id' => $section_id,
                    'section_id' => $section_id,
                    'subject_id' => $subject_id,
                    'deadline' => $data['deadline'],
                    'act_title' => $data['act_title'],
                    'instruction' => $data['instruction'],
                    'act_link' => $data['act_link'],
                    'attachment' => $data['attachment'],
                ]);
            }
            
            $response = [
                'message' => 'Announcement created successfully!',
                'data' => $announcement,
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
            
            $announcement = Announcement::where('section_id',$section_id)->where('subject_id',$subject_id)->latest()->get();

            $response = [
                'message' => 'Fetch specific announcement successfully!',
                'data'=>$announcement,
            ];
            
            return response($response,200);
        }else{
            $response = [
                'message' => 'User unauthorized.',
            ];
            return response($response,401);
        }
    }
    public function getAnnoucement($id)
    {
        $user = auth()->user();
        $user = $user->role;
        if($user=='instructor'){
            
            $announcement = Announcement::find($id);

            $announce = [];
            $announce['id']=$announcement->id;
            $announce['section_id']=$announcement->section_id;
            $announce['subject_id']=$announcement->subject_id;
            $announce['deadline'] = Carbon::parse($announcement->deadline)->format('Y-m-d H:i');
            $announce['act_title']=$announcement->act_title;
            $announce['instruction']=$announcement->instruction;
            $announce['act_link']=$announcement->act_link;
            $announce['attachment']=$announcement->attachment;
            $announce['created_at']=$announcement->created_at;
            $announce['updated_at']=$announcement->updated_at;
            
            $response = [
                'message' => 'Fetch specific announcement successfully!',
                'data'=>$announce,
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
            if($request->attachment==''){
                $data = $request->validate([
                    'deadline' => 'required',
                    'act_title' => 'string',
                    'instruction' => 'required|string',
                    'act_link' => 'required|url',
                ]);
                $announcement = Announcement::find($id);
                $announcement->deadline = $data['deadline'];
                $announcement->act_title = $data['act_title'];
                $announcement->instruction = $data['instruction'];
                $announcement->act_link = $data['act_link'];
                $announcement->attachment = null;
                $announcement->update();
            }else{
                $data = $request->validate([
                    'deadline' => 'required',
                    'act_title' => 'string',
                    'instruction' => 'required|string',
                    'act_link' => 'required|string',
                    'attachment' => 'url',
                ]);
                $announcement = Announcement::find($id);
                $announcement->deadline = $data['deadline'];
                $announcement->act_title = $data['act_title'];
                $announcement->instruction = $data['instruction'];
                $announcement->act_link = $data['act_link'];
                $announcement->attachment = $data['attachment'];
                $announcement->update();
            }

            $response = [
                'message' => 'Announcement updated successfully!',
                'data' => $announcement,
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
        if($user=='instructor'){
            Announcement::destroy($id);
            $response = [
                'message' => 'Announcement deleted successfully!'
            ];
            
            return response($response,200);
        }
    }
}
