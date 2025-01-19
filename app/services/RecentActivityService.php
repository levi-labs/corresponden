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

        try {
            RecentActivity::create([
                'user_id' => $userId,
                'activity_type' => $type
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
