<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

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
            
            if($request->attachment==''){
                $data = $request->validate([
                    'deadline' => 'required',
                    'act_title' => 'string',
                    'instruction' => 'required|string',
                    'act_link' => 'required|string',
                ]);
                $announcement = Announcement::create([
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
                    'act_link' => 'required|string',
                    'attachment' => 'string',
                ]);
                $announcement = Announcement::create([
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
                'data'=>$announcement
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
                    'act_link' => 'required|string',
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
                    'attachment' => 'string',
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
