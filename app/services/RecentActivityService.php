<?php

namespace App\Services;

use App\Models\RecentActivity;

class RecentActivityService
{
    public function getRecentActivitiesByUser()
    {
        // return auth()->user()->activities()->orderBy('created_at', 'desc')->limit(10)->get();
    }

    public function create($userId, $type)
    {
        RecentActivity::create([
            'user_id' => $userId,
            'type' => $type
        ]);
    }
}
