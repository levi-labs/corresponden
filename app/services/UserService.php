<?php

namespace app\services;

use App\Models\User;
use App\services\LectureService;
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

    ) {
        $this->studentService = $studentService;
        $this->lectureService = $lectureService;
    }


    public function getAllUsers()
    {
        return User::all();
    }

    public function getUserById($id) {}

    public function searchUser($search) {}

    public function create($data)
    {
        DB::transaction(function () use ($data) {
            // dd($data);
            $user = User::create($data);
            $data['user_id'] = $user->id;
            if ($data['role'] == 'student') {
                $this->studentService->createStudentFromUser($data);
            } elseif ($data['role'] == 'lecturer') {
                $this->lectureService->createLectureFromUser($data);
            }
        });
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
