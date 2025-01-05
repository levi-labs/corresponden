<?php

namespace App\services;

use App\Models\Lecture;

class LectureService
{
    public function createLectureFromUser($data)
    {
        $lecture_id = date('Y') . str_pad($data['user_id'], 3, '0', STR_PAD_LEFT) . rand(0, 999);
        Lecture::create([
            'fullname' => $data['name'],
            'user_id' => $data['user_id'],
            'lecture_id' => $lecture_id,
        ]);
    }
}
