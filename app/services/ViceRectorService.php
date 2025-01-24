<?php

namespace App\Services;

use App\Models\ViceRector;

class ViceRectorService
{
    public function getAllViceRectors()
    {
        return ViceRector::all();
    }
    public function craeteViceRectorFromUser($data)
    {
        $viceRector_id = date('Y') . str_pad($data['user_id'], 3, '0', STR_PAD_LEFT) . rand(0, 999);
        ViceRector::create([
            'fullname' => $data['name'],
            'user_id' => $data['user_id'],
            'email' => $data['email'],
            'vice_rector_id' => $viceRector_id,
        ]);
    }
}
