<?php

namespace App\Http\Controllers;

use App\Models\Inbox;
use App\Models\RecentActivity;
use App\Models\Sent;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public $activity;
    public function index()
    {
        $title = 'Dashboard';
        $countActivity = RecentActivity::all();
        if (count($countActivity) == 0) {
            $recentActivity = $this->activity = RecentActivity::where('user_id', auth('web')->user()->id)->get();
        } else {
            $recentActivity = $this->activity = RecentActivity::where('user_id', auth('web')->user()->id)->limit(20)->get();
        }
        if (auth('web')->user()->role == 'student' || auth('web')->user()->role == 'lecturer') {
            $inbox = Inbox::where('receiver_id', auth('web')->user()->id)->get();
            $sent = Sent::where('sender_id', auth('web')->user()->id)->get();
        }


        return view('pages.dashboard.index', compact('title', 'recentActivity'));
    }
}
