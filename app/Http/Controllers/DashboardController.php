<?php

namespace App\Http\Controllers;

use App\Models\RecentActivity;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $recentActivity = RecentActivity::all();
        if (count($recentActivity) == 0) {
            $recentActivity = RecentActivity::all();
        } else {
            $recentActivity = RecentActivity::limit(20)->get();
        }
        return view('pages.dashboard.index', compact('title', 'recentActivity'));
    }
}
