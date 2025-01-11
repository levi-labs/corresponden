<?php

namespace App\Http\Controllers;

use App\services\StudentService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }
    public function showProfile()
    {
        $authUser = auth('web')->user();
        if ($authUser->role == 'student') {
            $data = $this->studentService->getStudentById(auth('web')->user()->id);
            return view('pages.profile.student', compact('data'));
        } elseif ($authUser->role == 'lecturer') {
            return view('pages.profile.lecturer');
        } elseif ($authUser->role == 'staff') {
            return view('pages.profile.staff');
        }
    }
}
