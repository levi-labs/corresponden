<?php

namespace app\services;

use App\Models\User;
use App\services\StudentService;
use Illuminate\Support\Facades\DB;

class UserService
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
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
