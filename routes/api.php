<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AssignController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Instructor\AnnController;
use App\Http\Controllers\Instructor\SecController;
use App\Http\Controllers\Instructor\StuController;
use App\Http\Controllers\Instructor\AssiController;
use App\Http\Controllers\Admin\InstructorController;
use App\Http\Controllers\Admin\SchoolYearController;
use App\Http\Controllers\Instructor\IrregController;
use App\Http\Controllers\Instructor\ProfileController;
use App\Http\Controllers\Admin\StudentSectionController;
use App\Http\Controllers\Student\StdController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Public Routes*/

//Create Admin
Route::post('/user/register',[AuthController::class,'register']);

//Login Admin
Route::post('/user/login',[AuthController::class,'login']);

/* Private Routes*/
Route::group(['middleware'=>['auth:sanctum','verified']],function(){

    // Admin Logout
    Route::post('/user/logout',[AuthController::class,'logout']);

    // User Role
    Route::get('/user/role',[AuthController::class,'role']);

    //Email Resend
    Route::get('email/resend/{id}', [VerificationController::class,'resend'])->name('verification.resend');

    /*===============Admin - Instructor==============*/
    
    // Create instructor
    Route::post('/instructor',[InstructorController::class,'store']);
    // Get all instructor
    Route::get('/instructor',[InstructorController::class,'index']);
    Route::get('/instructor/all',[InstructorController::class,'getInstructor']);
    // Get specific instructor
    Route::get('/instructor/{id}',[InstructorController::class,'show']);
    // Update specific instructor
    Route::put('/instructor/{id}',[InstructorController::class,'update']);
    // Delete specific instructor
    Route::delete('/instructor/{id}',[InstructorController::class,'destroy']);
    // Deactivate Instructor
    Route::put('/instructor/deactivate/{id}',[InstructorController::class,'deactivate']);
    // Activate Instructor
    Route::put('/instructor/activate/{id}',[InstructorController::class,'activate']);

    /*===============End==============*/

    /*===============Admin - Student==============*/
    // Create student
    Route::post('/student/{id}',[StudentController::class,'store']);
    // Get all student
    // Route::get('/student',[StudentController::class,'index']);
    // Get specific student by section
    Route::get('/student-section/{id}',[StudentController::class,'show']);
    // Get specific student
    Route::get('/student/{id}',[StudentController::class,'showSpecific']);
    // Update specific student
    Route::put('/student/{id}',[StudentController::class,'update']);
    // Delete specific student
    Route::delete('/student/{id}',[StudentController::class,'destroy']);
    /*===============End==============*/

    /*===============Admin - Section==============*/
    // Create section
    Route::post('/section',[SectionController::class,'store']);
    // Get all section
    Route::get('/section',[SectionController::class,'index']);
    // Get specific section
    Route::get('/section/{id}',[SectionController::class,'show']);
    // Update specific section
    Route::put('/section/{id}',[SectionController::class,'update']);
    // Delete specific section
    Route::delete('/section/{id}',[SectionController::class,'destroy']);
    // Import Student Section
    Route::post('/import/student-section',[StudentSectionController::class,'import']);
    /*===============End==============*/

    /*===============Admin - Subject==============*/
    // Create subject
    Route::post('/subject',[SubjectController::class,'store']);
    // Get all subject
    Route::get('/subject',[SubjectController::class,'index']);
    // Get specific subject
    Route::get('/subject/{id}',[SubjectController::class,'show']);
    // Update specific section
    Route::put('/subject/{id}',[SubjectController::class,'update']);
    // Delete specific section
    Route::delete('/subject/{id}',[SubjectController::class,'destroy']);
    /*===============End==============*/

    /*===============Admin - School==============*/
    // Create school
    Route::post('/school',[SchoolController::class,'store']);
    // Get all school
    Route::get('/school',[SchoolController::class,'index']);
    // Get specific school
    Route::get('/school/{id}',[SchoolController::class,'show']);
    // Update specific section
    Route::put('/school/{id}',[SchoolController::class,'update']);
    // Delete specific section
    Route::delete('/school/{id}',[SchoolController::class,'destroy']);
    /*===============End==============*/

    /*===============Admin - School Year==============*/
    // Create school-year
    Route::post('/school-year',[SchoolYearController::class,'store']);
    // Get all school-year
    Route::get('/school-year',[SchoolYearController::class,'index']);
    // Get specific school-year
    Route::get('/school-year/{id}',[SchoolYearController::class,'show']);
    // Update specific school-year
    Route::put('/school-year/{id}',[SchoolYearController::class,'update']);
    // Delete specific school-year
    Route::delete('/school-year/{id}',[SchoolYearController::class,'destroy']);
    /*===============End==============*/

    /*===============Admin - Assign==============*/
    // Create Assign
    Route::post('/assign',[AssignController::class,'store']);
    // Get all assign
    Route::get('/assign',[AssignController::class,'index']);
    // Delete specific assign
    Route::delete('/assign/{id}',[AssignController::class,'destroy']);
    // Get specific assign
    Route::get('/assign/{id}',[AssignController::class,'show']);
    // Update specific assign
    Route::put('/assign/{id}',[AssignController::class,'update']);
    /*===============End==============*/

    /*===============Instructor - Profile==============*/
    // Get instructor
    Route::get('/instructor/profile/{id}',[ProfileController::class,'show']);
    // Update instructor
    Route::put('/instructor/profile/{id}',[ProfileController::class,'update']);
    /*===============End==============*/

    /*===============Instructor - Assign==============*/
    // Get all assigned subject-section
    Route::get('/assigned/instructor',[AssiController::class,'index']);
    /*===============End==============*/

    /*===============Instructor - Section==============*/
    // Get specific information
    Route::get('/assigned/info/{section_id}/{subject_id}',[SecController::class,'showInfo']);
    // Get specific student by section
    Route::get('/assigned/student-section/{section_id}/{subject_id}',[SecController::class,'show']);
    /*===============End==============*/

    /*===============Instructor - Irregular==============*/
    // Get Student to be Irreg
    Route::get('/irregular/{section_id}/{subject_id}',[IrregController::class,'show']);
    // Create Irregular Student
    Route::post('/irregular',[IrregController::class,'store']);
    // Delete specific irreg student
    Route::delete('/irregular/{student_id}/{section_id}/{subject_id}',[IrregController::class,'destroy']);
    /*===============End==============*/

    /*===============Instructor - Add/Drop==============*/
    // Add Student
    Route::put('/student/add/{id}',[StuController::class,'add']);
    // Drop Student
    Route::put('/student/drop/{id}',[StuController::class,'drop']);
    /*===============End==============*/

    /*===============Instructor - Announcement==============*/
    // Create Announcement
    Route::post('/announcement/{section_id}/{subject_id}',[AnnController::class,'store']);
    // Delete specific Announcement
    Route::delete('/announcement/{id}',[AnnController::class,'destroy']);
    // Get Announcement by section and subject
    Route::get('/announcement/{section_id}/{subject_id}',[AnnController::class,'show']);
    // Get Announcement by id
    Route::get('/announcement/{id}',[AnnController::class,'getAnnoucement']);
    // Update specific Announcement
    Route::put('/announcement/{id}',[AnnController::class,'update']);
    /*===============End==============*/

    /*===============Student - Profile==============*/
    // Get student profile
    Route::get('/student/info/profile',[StdController::class,'show']);
    // Update instructor
    Route::put('/student/info/profile',[StdController::class,'update']);
    /*===============End==============*/

});

// Forgot Password
Route::post('password/email', [ForgotPasswordController::class,'forgot']);
// Reset Password
Route::post('password/reset', [ForgotPasswordController::class,'reset']);

 // Email Verification
Route::get('email/verify/{id}', [VerificationController::class,'verify'])->name('verification.verify');
