<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentImport implements ToModel, WithHeadingRow, WithValidation
{
    public function  __construct($section_id){
        $this->section_id= $section_id;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $number =$row['contact_number'];
        $result = sprintf("(%s) %s-%s",
              substr($number, 0, 3),
              substr($number, 3, 3),
              substr($number, 6));
        $student= Student::create([
            'section_id'=>$this->section_id,
            'student_id'=>$row['student_id'],
            'first_name'=>$row['first_name'],
            'middle_name'=>$row['middle_name'],
            'last_name'=>$row['last_name'],
            'age'=>$row['age'],
            'gender'=>$row['gender'],
            'contact_number'=>$result,
            'email'=>$row['email'],
        ]);
        return $student;

    }
    public function rules():array{
        return [
            'student_id'=>'required|unique:students,student_id',
            'email' => 'required|unique:students,email',
            'first_name' => 'required|string',
            'middle_name' => 'required|string',
            'last_name' => 'required|string',
            'age' => 'required',
            'gender' => 'required|string',
            'contact_number' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'student_id.required' => 'The student id field is required.',
            'student_id.unique' => 'The student id has already been taken.',
            'first_name.required' => 'The first name field is required.',
            'middle_name.required' => 'The middle name field is required.',
            'last_name.required' => 'The last name field is required.',
            'contact_number.required' => 'The contact number field is required.',
        ];
    }

}
