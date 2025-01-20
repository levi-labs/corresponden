<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use App\Models\Staff;
use App\Models\Student;
use App\Models\User;
use App\services\LectureService;
use App\Services\RecentActivityService;
use App\services\StaffService;
use App\services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    protected $studentService;
    protected $lectureService;
    protected $staffService;
    protected $recentActivityService;

    public function __construct(
        StudentService $studentService,
        LectureService $lectureService,
        StaffService $staffService,
        RecentActivityService $recentActivityService
    ) {
        $this->studentService = $studentService;
        $this->lectureService = $lectureService;
        $this->staffService = $staffService;
        $this->recentActivityService = $recentActivityService;
    }
    public function showProfile()
    {
        $authUser = auth('web')->user();
        if ($authUser->role == 'student') {
            $data = $this->studentService->getStudentById(auth('web')->user()->id);
            return view('pages.profile.student.index', compact('data'));
        } elseif ($authUser->role == 'lecturer') {
            $data = $this->lectureService->getLectureByUserId(auth('web')->user()->id);
            return view('pages.profile.lecture.index', compact('data'));
        } elseif ($authUser->role == 'staff') {
            $data = $this->staffService->getStaffByUserId(auth('web')->user()->id);
            return view('pages.profile.staff.index', compact('data'));
        }
    }

    public function editProfile()
    {
        $title = 'Edit Profile';
        $authUser = auth('web')->user();
        if ($authUser->role == 'student') {
            $data = $this->studentService->getStudentById(auth('web')->user()->id);
            return view('pages.profile.student.edit', compact('data', 'title'));
        } elseif ($authUser->role == 'lecturer') {
            $data = $this->lectureService->getLectureByUserId(auth('web')->user()->id);
            return view('pages.profile.lecture.edit', compact('data', 'title'));
        } elseif ($authUser->role == 'staff') {
            $data = $this->staffService->getStaffByUserId(auth('web')->user()->id);
            return view('pages.profile.staff.edit', compact('data', 'title'))->with('edit');
        }
    }
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $authUser = auth('web')->user()->id;
            $request->validate([
                'fullname' => 'required',
            ]);
            $path = null;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $path = $file->storeAs('images', $name, 'public');
            }
            if (auth('web')->user()->role == 'student') {
                $student = Student::where('user_id', $authUser)->first();
                $student->update([
                    'fullname' => $request->fullname,
                    'phone' => $request->phone,
                    'hobby' => $request->hobby,
                    'gender' => $request->gender,
                    'date_of_birth' => $request->date_of_birth,
                    'address' => $request->address,
                    'faculty' => $request->faculty,
                    'image' => $path == null ? $student->image : $path,
                    'year_enrolled' => $request->year_enrolled
                ]);
                $this->recentActivityService->create($authUser, 'update-profile'); // Log('Profile updated successfully');
                DB::commit();
                return redirect()->route('profile.index')->with('success', 'Profile updated successfully');
            } elseif (auth('web')->user()->role == 'lecturer') {
                $lecturer = Lecture::where('user_id', $authUser)->first();
                $lecturer->update([
                    'fullname' => $request->fullname,
                    'gender' => $request->gender,
                    'faculty' => $request->faculty,
                    'degree' => $request->degree,
                    'date_of_birth' => $request->date_of_birth,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'address' => $request->address,
                    'image' => $path == null ? $lecturer->image : $path
                ]);
                $this->recentActivityService->create($authUser, 'update-profile'); // Log('Profile updated successfully');
                DB::commit();
                return redirect()->route('profile.index')->with('success', 'Profile updated successfully');
            } elseif (auth('web')->user()->role == 'staff') {
                $staff = Staff::where('user_id', $authUser)->first();
                $staff->update([
                    'fullname' => $request->fullname,
                    'gender' => $request->gender,
                    'degree' => $request->degree,
                    'date_of_birth' => $request->date_of_birth,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'address' => $request->address,
                    'image' => $path == null ? $staff->image : $path
                ]);
                $this->recentActivityService->create($authUser, 'update-profile'); // Log('Profile updated successfully');
                DB::commit();
                return redirect()->route('profile.index')->with('success', 'Profile updated successfully');
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function changePassword()
    {
        $title = 'Ubah Password';

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
        DB::beginTransaction();
        try {
            User::where('id', auth('web')->user()->id)->update([
                'password' => Hash::make($new_password)
            ]);
            $this->recentActivityService->create(auth('web')->user()->id, 'change-password');
            DB::commit();
            return redirect()->back()->with('success', 'Password changed successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
