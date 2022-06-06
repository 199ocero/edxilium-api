<?php

namespace App\Http\Controllers\Admin;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Imports\StudentImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Validators\ValidationException as ExcelValidateException;

class StudentSectionController extends Controller
{
    public function import(Request $request){
        $user = auth()->user();
        $user = $user->role;
        if($user=='admin'){
            $data = $request->validate([
                'section' => 'required|string',
                'file' => 'required|mimes:csv,txt'
            ]);
            $sectionUppercase = strtoupper($data['section']);
            $sectionName = Section::where('section',$sectionUppercase)->first();
            if($sectionName!=null){
                throw ValidationException::withMessages([
                    'section' => 'The section has already been taken.'
                ]);
            }else{
                $section = Section::create([
                    'section' => $sectionUppercase,
                ]);
                
                
                
                $errors=[];
                try {
                    $file = $request->file('file');
                    Excel::import(new StudentImport($section->id), $file);
                } catch (ExcelValidateException $e) {
                    
                    $failures = $e->failures();
                    
                    foreach ($failures as $failure) {
                        
                        $failure->row(); // row that went wrong
                        $failure->attribute(); // either heading key (if using heading row concern) or column index
                        $failure->errors(); // Actual error messages from Laravel validator
                        $failure->values(); // The values of the row that has failed.

                        $errors[$failure->attribute()] = $failure->errors();
                        
                    }
                }
                if(empty($errors)){
                    
                     $response = [
                        'message' => 'Student and section created successfully!',
                    ];
                    return response($response,200);
                }else{
                    Section::find($section->id)->delete();
                    $response = [
                        'message'=> "The given data was invalid.",
                        'errors' => $errors,
                    ];
                    return response($response,422);
                }
               
                
            }
            
            
        }else{
            $response = [
                'message' => 'User unauthorized.',
            ];
            return response($response,401);
        }
    }
}
