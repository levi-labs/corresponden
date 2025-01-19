<?php

namespace App\Http\Controllers;

use App\Models\Inbox;
use App\Models\RecentActivity;
use App\Models\Sent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public $activity;
    public $activitiesPerDay;
    public function index()
    {
        $title = 'Dashboard';
        $countActivity = RecentActivity::all();
        if (count($countActivity) == 0) {
            $recentActivity = $this->activity = RecentActivity::where('user_id', auth('web')->user()->id)->get();
        } else {
            $recentActivity = $this->activity = RecentActivity::where('user_id', auth('web')->user()->id)->limit(20)->get();
        }
        if (auth('web')->user()->role == 'admin' || auth('web')->user()->role == 'staff') {
            $report =  $this->activitiesPerDay = RecentActivity::selectRaw('DATE(created_at) as date, COUNT(*) as activity_count')
                ->groupBy(DB::raw('DATE(created_at)'))  // Mengelompokkan berdasarkan tanggal
                ->orderBy('date', 'asc')  // Mengurutkan berdasarkan tanggal
                ->get();
            $dates = $report->pluck('date')->toArray();  // Tanggal yang sudah diproses
            $activityCounts = $report->pluck('activity_count')->toArray();
            // dd($dates, $activityCounts);
            return view('pages.dashboard.index', compact('title', 'dates', 'activityCounts', 'recentActivity',));
        }
        if (auth('web')->user()->role == 'student' || auth('web')->user()->role == 'lecturer') {
            $inbox = Inbox::where('receiver_id', auth('web')->user()->id)->get();
            $sent = Sent::where('sender_id', auth('web')->user()->id)->get();
            return view('pages.dashboard.index', compact('title', 'recentActivity', 'inbox', 'sent'));
        }


        // return view('pages.dashboard.index', compact('title', 'dates', 'activityCounts', 'recentActivity', 'inbox', 'sent'));
    }
}
