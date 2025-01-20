<?php

namespace App\Http\Controllers;

use App\Models\ArchiveIncomingLetter;
use App\Models\ArchiveOutgoingLetter;
use App\Models\Inbox;
use App\Models\RecentActivity;
use App\Models\Sent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public $activity;
    public $activitiesPerDay;
    public function index()
    {
        $title = 'Beranda';
        $countActivity = RecentActivity::all();
        if (count($countActivity) == 0) {
            $recentActivity = $this->activity = RecentActivity::where('user_id', auth('web')->user()->id)->get();
        } else {
            $recentActivity = $this->activity = RecentActivity::where('user_id', auth('web')->user()->id)
                ->orderBy('created_at', 'desc')
                ->limit(8)->get();
        }
        if (auth('web')->user()->role == 'admin' || auth('web')->user()->role == 'staff') {
            $report =  $this->activitiesPerDay = RecentActivity::selectRaw('DATE(created_at) as date, COUNT(*) as activity_count')
                ->groupBy(DB::raw('DATE(created_at)'))  // Mengelompokkan berdasarkan tanggal
                ->orderBy('date', 'asc')  // Mengurutkan berdasarkan tanggal
                ->get();
            $arsip_masuk = ArchiveIncomingLetter::selectRaw('DATE(created_at) as date, COUNT(*) as activity_count')
                ->groupBy(DB::raw('DATE(created_at)'))  // Mengelompokkan berdasarkan tanggal
                ->orderBy('date', 'asc')  // Mengurutkan berdasarkan tanggal
                ->get();
            $arsip_keluar = ArchiveOutgoingLetter::selectRaw('DATE(created_at) as date, COUNT(*) as activity_count')
                ->groupBy(DB::raw('DATE(created_at)'))  // Mengelompokkan berdasarkan tanggal
                ->orderBy('date', 'asc')  // Mengurutkan berdasarkan tanggal
                ->get();

            $dates = $report->pluck('date')->toArray();  // Tanggal yang sudah diproses
            $activityCounts = $report->pluck('activity_count')->toArray();
            $dates_arsip_masuk = $arsip_masuk->pluck('date')->toArray();  // Tanggal yang sudah diproses
            $activityCounts_arsip_masuk = $arsip_masuk->pluck('activity_count')->toArray();
            $dates_arsip_keluar = $arsip_keluar->pluck('date')->toArray();  // Tanggal yang sudah diproses
            $activityCounts_arsip_keluar = $arsip_keluar->pluck('activity_count')->toArray();
            $archive_incoming = ArchiveIncomingLetter::count();
            $archive_outgoing = ArchiveOutgoingLetter::count();
            $count_user =  User::count();
            // dd($dates, $activityCounts);
            return view(
                'pages.dashboard.index',
                compact(
                    'title',
                    'dates',
                    'activityCounts',
                    'recentActivity',
                    'archive_incoming',
                    'archive_outgoing',
                    'dates_arsip_masuk',
                    'activityCounts_arsip_masuk',
                    'dates_arsip_keluar',
                    'activityCounts_arsip_keluar',

                    'count_user'
                )
            );
        }
        if (auth('web')->user()->role == 'student' || auth('web')->user()->role == 'lecturer') {
            $inbox = Inbox::where('receiver_id', auth('web')->user()->id)->count();
            $sent = Sent::where('sender_id', auth('web')->user()->id)->count();
            $count_unread = Inbox::where('receiver_id', auth('web')->user()->id)->where('status', 'unread')->count();
            return view('pages.dashboard.index', compact('title', 'recentActivity', 'inbox', 'sent', 'count_unread'));
        }


        // return view('pages.dashboard.index', compact('title', 'dates', 'activityCounts', 'recentActivity', 'inbox', 'sent'));
    }
}
