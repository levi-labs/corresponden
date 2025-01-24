<?php

namespace App\Services;

use App\Models\Rector;

class RectorService
{
    public function getAllRectors()
    {
        return Rector::all();
    }
    public function createRectorFromUser($data)
    {
        $rector_id = date('Y') . str_pad($data['user_id'], 3, '0', STR_PAD_LEFT) . rand(0, 999);
        Rector::create([
            'fullname' => $data['name'],
            'user_id' => $data['user_id'],
            'email' => $data['email'],
            'rector_id' => $rector_id,
        ]);
    }
}
