<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function editProfile()
    {
        $authUser = auth('web')->user();
        if ($authUser->role == 'student') {
            $data = $this->studentService->getStudentById(auth('web')->user()->id);
            return view('pages.profile.student-edit', compact('data'));
        } elseif ($authUser->role == 'lecturer') {
            return view('pages.profile.lecturer-edit');
        } elseif ($authUser->role == 'staff') {
            return view('pages.profile.staff-edit');
        }
    }

    public function changePassword()
    {
        $title = 'Change Password';

        return view('pages.profile.change-password', compact('title'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);

        $old_password = $request->old_password;
        $new_password = $request->new_password;

        $confirm_password = $request->confirm_password;

        $checkPassword = User::where('id', auth('web')->user()->id)->first();

        if (!Hash::check($old_password, $checkPassword->password)) {
            return redirect()->back()->with('error', 'Old password does not match');
        }

        if ($new_password != $confirm_password) {
            return redirect()->back()->with('error', 'Password does not match');
        }

        User::where('id', auth('web')->user()->id)->update([
            'password' => Hash::make($new_password)
        ]);

        return redirect()->back()->with('success', 'Password changed successfully');
    }
}
