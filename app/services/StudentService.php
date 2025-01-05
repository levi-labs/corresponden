<?php

namespace App\services;

use App\Models\Student;
use Illuminate\Support\Str;

class StudentService
{
    // public function getAllUsers()
    // {
    //     return User::all();
    // }

    public function createStudentFromUser($data)
    {
        $student_id = date('Y') . str_pad($data['user_id'], 3, '0', STR_PAD_LEFT) . rand(0, 999);
        Student::create([
            'fullname' => $data['name'],
            'user_id' => $data['user_id'],
            'student_id' => $student_id,
        ]);
    }
}
