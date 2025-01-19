<?php

namespace app\services;

use App\Models\User;
use App\services\LectureService;
use App\services\StaffService;
use App\services\StudentService;
use Illuminate\Support\Facades\DB;

class UserService
{
    protected $studentService;
    protected $lectureService;
    protected $staffService;

    public function __construct(
        StudentService $studentService,
        LectureService $lectureService,
        StaffService $staffService

    ) {
        $this->studentService = $studentService;
        $this->lectureService = $lectureService;
        $this->staffService = $staffService;
    }


    public function getAllUsers()
    {
        return User::all();
    }

    public function getUserById($id) {}

    public function searchUser($search) {}

    public function create($data)
    {
        try {
            DB::transaction(function () use ($data) {
                // dd($data);
                $user = User::create($data);
                $data['user_id'] = $user->id;
                if ($data['role'] == 'student') {
                    $this->studentService->createStudentFromUser($data);
                } elseif ($data['role'] == 'lecturer') {
                    $this->lectureService->createLectureFromUser($data);
                } elseif ($data['role'] == 'staff') {
                    $this->staffService->createStaffFromUser($data);
                }
            });
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(User $user, $data)
    {
        $user->update($data);
    }

    public function destroy(User $user)
    {
        $user->delete();
    }
}
