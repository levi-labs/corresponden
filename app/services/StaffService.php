<?php

namespace App\services;

use App\Models\Staff;

class StaffService
{
    public function createStaffFromUser($data)
    {
        $staff_id = date('Y') . str_pad($data['user_id'], 3, '0', STR_PAD_LEFT) . rand(0, 999);
        Staff::create([
            'fullname' => $data['name'],
            'user_id' => $data['user_id'],
            'email' => $data['email'],
            'staff_id' => $staff_id,
        ]);
    }
    public function getStaffByUserId($id)
    {
        return Staff::where('user_id', $id)->first();
    }
}
