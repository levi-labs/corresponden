<?php

namespace app\services;

use App\Models\User;
use App\services\LectureService;
use App\Services\RectorService;
use App\services\StaffService;
use App\services\StudentService;
use App\Services\ViceRectorService;
use Illuminate\Support\Facades\DB;

class UserService
{
    protected $studentService;
    protected $lectureService;
    protected $staffService;
    protected $viceRectorService;
    protected $rectorService;

    public function __construct(
        StudentService $studentService,
        LectureService $lectureService,
        StaffService $staffService,
        ViceRectorService $viceRectorService,
        RectorService $rectorService


    ) {
        $this->studentService = $studentService;
        $this->lectureService = $lectureService;
        $this->staffService = $staffService;
        $this->viceRectorService = $viceRectorService;
        $this->rectorService = $rectorService;
    }


    public function getAllUsers()
    {
        return User::all();
    }

    public function getUserById($id) {}

    public function searchUser($search) {}

    public function create($data)
    {
        // dd($data);
        try {
            DB::transaction(function () use ($data) {
                // $data['is_koordinator'] = ;
                $user = User::create($data);
                $data['user_id'] = $user->id;
                if ($data['role'] == 'student') {
                    $this->studentService->createStudentFromUser($data);
                } elseif ($data['role'] == 'lecturer') {
                    $this->lectureService->createLectureFromUser($data);
                } elseif ($data['role'] == 'staff') {
                    $this->staffService->createStaffFromUser($data);
                } elseif ($data['role'] == 'rector') {
                    $this->rectorService->createRectorFromUser($data);
                } elseif ($data['role'] == 'vice rector') {
                    $this->viceRectorService->craeteViceRectorFromUser($data);
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
